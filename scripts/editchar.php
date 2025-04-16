<?php
$username = $_POST['username'];
$password = $_POST['password'];

// Check if this is a legacy character
$isLegacy = getuser($charname, "is_legacy") == 1;

// Get database connection
$dbh = dbconnect();

// Check if legacy columns exist in the database
$hasLegacyTier = false;
$checkColumn = $dbh->query("SHOW COLUMNS FROM users LIKE 'legacy_tier'");
if ($checkColumn && $checkColumn->num_rows > 0) {
	$hasLegacyTier = true;
}

// Legacy character information
$legacySetting = getuser($charname, "legacy_setting");
$legacyHistory = getuser($charname, "legacy_history");
$legacyTier = $hasLegacyTier ? (getuser($charname, "legacy_tier") ?: 1) : 1;
$legacyApproved = getuser($charname, "legacy_approved") == 1;
$legacyTierDate = getuser($charname, "legacy_tier_date");
$legacyAdminNotes = getuser($charname, "legacy_admin_notes");

// Calculate days in current tier
$currentTime = time();
$tierTime = strtotime($legacyTierDate ?: date('Y-m-d H:i:s'));
$daysInTier = floor(($currentTime - $tierTime) / (60 * 60 * 24));

// Tier descriptions
$tierDescriptions = [
	1 => "Basic class abilities only",
	2 => "Limited special abilities unlocked",
	3 => "Significant abilities unlocked"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Character: <?= htmlspecialchars($charname) ?> | Admin</title>
	
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FontAwesome CDN -->
	<script src="https://kit.fontawesome.com/c11c3ebcdf.js" crossorigin="anonymous"></script>
	
	<style>
		body {
			background-color: #f5f5f5;
		}
		.card {
			margin-bottom: 20px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
		}
		.card-header {
			background-color: #5a5a5a;
			color: white;
			font-weight: bold;
		}
		.form-label {
			font-weight: bold;
		}
		.btn-primary {
			background-color: #9d436b;
			border-color: #9d436b;
		}
		.btn-primary:hover {
			background-color: #7d2e51;
			border-color: #7d2e51;
		}
		.tier-badge {
			font-size: 0.9rem;
			padding: 0.25em 0.5em;
			border-radius: 3px;
			margin-left: 5px;
		}
		.tier-1 { background-color: #6c757d; color: white; }
		.tier-2 { background-color: #28a745; color: white; }
		.tier-3 { background-color: #9966CC; color: white; }
	</style>
</head>
<body>
	<div class="container py-4">
		<h1 class="mb-4">Edit Character: <?= htmlspecialchars($charname) ?></h1>
		
		<form action="charedit.php" method="post">
			<!-- Account Information -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-user-shield me-2"></i> Account Information
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-3">
							<label class="form-label">Creation Date:</label>
							<input type="text" class="form-control" value="<?= htmlspecialchars($charcreated) ?>" disabled>
						</div>
						<div class="col-md-4 mb-3">
							<label class="form-label">IP Address:</label>
							<input type="text" class="form-control" value="<?= htmlspecialchars($charip) ?>" disabled>
						</div>
						<div class="col-md-4 mb-3">
							<label class="form-label">Admin Level:</label>
							<input type="text" class="form-control" name="admin" value="<?= htmlspecialchars($charadmin) ?>">
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6 mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="mute" name="mute" value="Yes" <?= $charmuted == "1" ? "checked" : "" ?>>
								<label class="form-check-label" for="mute">
									Mute for
									<input type="text" class="form-control d-inline-block" name="mutetime" value="<?= htmlspecialchars($charmtime) ?>" style="width: 80px;"> minutes
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="deaf" name="deaf" value="Yes" <?= $chardeafen == "1" ? "checked" : "" ?>>
								<label class="form-check-label" for="deaf">
									Deafen for
									<input type="text" class="form-control d-inline-block" name="deaftime" value="<?= htmlspecialchars($chardtime) ?>" style="width: 80px;"> minutes
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Character Description -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-align-left me-2"></i> Character Description
				</div>
				<div class="card-body">
					<div class="mb-3">
						<label class="form-label">Description:</label>
						<textarea class="form-control" name="description" rows="8"><?= htmlspecialchars($chardescription) ?></textarea>
					</div>
					
					<div class="mb-3">
						<label class="form-label">Player Flags:</label>
						<textarea class="form-control" name="flags" rows="3"><?= htmlspecialchars($charflags) ?></textarea>
					</div>
				</div>
			</div>
			
			<!-- Legacy Character Information (only shown for legacy characters) -->
			<?php if ($isLegacy): ?>
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<span><i class="fas fa-crown me-2"></i> Legacy Character Information</span>
					<div>
						<?php if ($hasLegacyTier): ?>
						<span class="tier-badge tier-<?= $legacyTier ?>">Tier <?= $legacyTier ?></span>
						<?php endif; ?>
						<button type="button" class="btn btn-sm btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#removeLegacyModal">
							<i class="fas fa-times"></i> Remove Legacy Status
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Original Setting:</label>
								<input type="text" class="form-control" name="legacy_setting" value="<?= htmlspecialchars($legacySetting) ?>">
							</div>
							
							<div class="mb-3">
								<div class="form-check">
									<input type="hidden" name="is_legacy" value="1">
									<input class="form-check-input" type="checkbox" id="legacy_approved" name="legacy_approved" value="1" <?= $legacyApproved ? "checked" : "" ?>>
									<label class="form-check-label" for="legacy_approved">Approved</label>
								</div>
							</div>
							
							<?php if ($hasLegacyTier): ?>
							<div class="mb-3">
								<label class="form-label">Current Tier:</label>
								<select class="form-select" name="legacy_tier">
									<option value="1" <?= $legacyTier == 1 ? "selected" : "" ?>>Tier 1 - <?= $tierDescriptions[1] ?></option>
									<option value="2" <?= $legacyTier == 2 ? "selected" : "" ?>>Tier 2 - <?= $tierDescriptions[2] ?></option>
									<option value="3" <?= $legacyTier == 3 ? "selected" : "" ?>>Tier 3 - <?= $tierDescriptions[3] ?></option>
								</select>
								<div class="form-text"><?= $daysInTier ?> days in current tier</div>
							</div>
							<?php endif; ?>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Legacy History:</label>
								<textarea class="form-control" name="legacy_history" rows="5"><?= htmlspecialchars($legacyHistory) ?></textarea>
							</div>
							
							<?php
							// Only show admin notes if the column exists
							$checkColumn = $dbh->query("SHOW COLUMNS FROM users LIKE 'legacy_admin_notes'");
							if ($checkColumn && $checkColumn->num_rows > 0):
							?>
							<div class="mb-3">
								<label class="form-label">Admin Notes:</label>
								<textarea class="form-control" name="legacy_admin_notes" rows="3"><?= htmlspecialchars($legacyAdminNotes) ?></textarea>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php else: ?>
			<!-- Convert to Legacy Character option (only shown for non-legacy characters) -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-arrow-right-arrow-left me-2"></i> Convert to Legacy Character
				</div>
				<div class="card-body">
					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" id="convert_to_legacy" name="convert_to_legacy" value="1" onchange="toggleLegacyFields()">
						<label class="form-check-label" for="convert_to_legacy">
							Convert this character to a legacy character
						</label>
					</div>
					
					<div id="legacy_convert_fields" style="display: none;">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Original Setting:</label>
									<input type="text" class="form-control" id="new_legacy_setting" name="new_legacy_setting" placeholder="e.g., Forgotten Realms, Dragonlance, etc.">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">Approve Immediately:</label>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="legacy_approved" name="legacy_approved" value="1">
										<label class="form-check-label" for="legacy_approved">
											Yes, approve this legacy character immediately
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Legacy History:</label>
							<textarea class="form-control" id="new_legacy_history" name="new_legacy_history" rows="5" placeholder="Character history and notable abilities from original setting"></textarea>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<!-- Basic Information -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-user me-2"></i> Basic Information
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Display Name:</label>
								<input type="text" class="form-control" name="name" value="<?= htmlspecialchars($chardisp) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Race:</label>
								<input type="text" class="form-control" name="race" value="<?= htmlspecialchars($charrace) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Class:</label>
								<input type="text" class="form-control" name="class" value="<?= htmlspecialchars($charclass) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Gender:</label>
								<select class="form-select" name="gender">
									<option value="male" <?= $chargender == "male" ? "selected" : "" ?>>Male</option>
									<option value="female" <?= $chargender == "female" ? "selected" : "" ?>>Female</option>
									<option value="other" <?= $chargender == "other" ? "selected" : "" ?>>Other</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Hometown:</label>
								<input type="text" class="form-control" name="hometown" value="<?= htmlspecialchars($charhometown) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Rank:</label>
								<input type="text" class="form-control" name="rank" value="<?= htmlspecialchars($charrank) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Deity:</label>
								<input type="text" class="form-control" name="deity" value="<?= htmlspecialchars($chardeity) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Fame Rank:</label>
								<input type="text" class="form-control" name="famerank" value="<?= htmlspecialchars($charfamerank) ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Appearance -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-eye me-2"></i> Appearance
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Eyes:</label>
								<input type="text" class="form-control" name="eyes" value="<?= htmlspecialchars($chareyes) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Hair:</label>
								<input type="text" class="form-control" name="hair" value="<?= htmlspecialchars($charhair) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Skin:</label>
								<input type="text" class="form-control" name="skin" value="<?= htmlspecialchars($charskin) ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Height:</label>
								<input type="text" class="form-control" name="height" value="<?= htmlspecialchars($charheight) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Build:</label>
								<input type="text" class="form-control" name="build" value="<?= htmlspecialchars($charbuild) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Pet:</label>
								<input type="text" class="form-control" name="pet" value="<?= htmlspecialchars($charpet) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Weapon:</label>
								<input type="text" class="form-control" name="weapon" value="<?= htmlspecialchars($charweapon) ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Equipment -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-shield-alt me-2"></i> Equipment
				</div>
				<div class="card-body">
					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" id="showEquip" name="e" value="on" <?= strpos($charflags, "(equip)") !== false ? "checked" : "" ?>>
						<label class="form-check-label" for="showEquip">
							Show Equipment
						</label>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Head:</label>
								<input type="text" class="form-control" name="head" value="<?= htmlspecialchars($charhead) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Ears:</label>
								<input type="text" class="form-control" name="ears" value="<?= htmlspecialchars($charears) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Neck:</label>
								<input type="text" class="form-control" name="neck" value="<?= htmlspecialchars($charneck) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Body:</label>
								<input type="text" class="form-control" name="body" value="<?= htmlspecialchars($charbody) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Left Arm:</label>
								<input type="text" class="form-control" name="larm" value="<?= htmlspecialchars($charlarm) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Right Arm:</label>
								<input type="text" class="form-control" name="rarm" value="<?= htmlspecialchars($charrarm) ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Wrists:</label>
								<input type="text" class="form-control" name="wrists" value="<?= htmlspecialchars($charwrists) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Hands:</label>
								<input type="text" class="form-control" name="hands" value="<?= htmlspecialchars($charhands) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Fingers:</label>
								<input type="text" class="form-control" name="finger" value="<?= htmlspecialchars($charfinger) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Legs:</label>
								<input type="text" class="form-control" name="legs" value="<?= htmlspecialchars($charlegs) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Feet:</label>
								<input type="text" class="form-control" name="feet" value="<?= htmlspecialchars($charfeet) ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Location -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-map-marker-alt me-2"></i> Location
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-3 mb-3">
							<label class="form-label">X:</label>
							<input type="text" class="form-control" name="x" value="<?= htmlspecialchars($charx) ?>">
						</div>
						<div class="col-md-3 mb-3">
							<label class="form-label">Y:</label>
							<input type="text" class="form-control" name="y" value="<?= htmlspecialchars($chary) ?>">
						</div>
						<div class="col-md-3 mb-3">
							<label class="form-label">Z:</label>
							<input type="text" class="form-control" name="z" value="<?= htmlspecialchars($charz) ?>">
						</div>
						<div class="col-md-3 mb-3">
							<label class="form-label">Plane:</label>
							<input type="text" class="form-control" name="plane" value="<?= htmlspecialchars($charplane) ?>">
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">Recall:</label>
							<input type="text" class="form-control" name="recall" value="<?= htmlspecialchars($charrecall) ?>">
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Recall Plane:</label>
							<input type="text" class="form-control" name="recallplane" value="<?= htmlspecialchars($charrecallplane) ?>">
						</div>
					</div>
				</div>
			</div>
			
			<!-- Organizations & Stats -->
			<div class="card">
				<div class="card-header">
					<i class="fas fa-users me-2"></i> Organizations & Stats
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<h5 class="mb-3">Organizations</h5>
							<div class="mb-3">
								<label class="form-label">Guild:</label>
								<input type="text" class="form-control" name="guild" value="<?= htmlspecialchars($charguild) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Clan:</label>
								<input type="text" class="form-control" name="clan" value="<?= htmlspecialchars($charclan) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Militia:</label>
								<input type="text" class="form-control" name="militia" value="<?= htmlspecialchars($charmilitia) ?>">
							</div>
						</div>
						<div class="col-md-6">
							<h5 class="mb-3">Stats</h5>
							<div class="mb-3">
								<label class="form-label">Quests:</label>
								<input type="text" class="form-control" name="quests" value="<?= htmlspecialchars($charquests) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Piety:</label>
								<input type="text" class="form-control" name="piety" value="<?= htmlspecialchars($charpiety) ?>">
							</div>
							<div class="mb-3">
								<label class="form-label">Proficiency:</label>
								<input type="text" class="form-control" name="proficiency" value="<?= htmlspecialchars($charproficiency) ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Submit buttons -->
			<div class="d-flex justify-content-between mb-5">
				<button type="reset" class="btn btn-secondary">Reset Changes</button>
				<input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
				<input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
				<input type="hidden" name="charname" value="<?= htmlspecialchars($charname) ?>">
				<button type="submit" class="btn btn-primary">Save Character</button>
			</div>
		</form>
	</div>
	
	<!-- Bootstrap JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
	
	<!-- Custom JavaScript for the form -->
	<script>
		// Toggle visibility of legacy conversion fields
		document.addEventListener('DOMContentLoaded', function() {
			const convertCheckbox = document.getElementById('convert_to_legacy');
			const legacyFields = document.getElementById('legacy_convert_fields');
			
			if (convertCheckbox) {
				convertCheckbox.addEventListener('change', function() {
					if (legacyFields) {
						legacyFields.style.display = this.checked ? 'block' : 'none';
					}
				});
			}
		});
	</script>
	
	<!-- Remove Legacy Status Modal -->
	<?php if ($isLegacy): ?>
	<div class="modal fade" id="removeLegacyModal" tabindex="-1" aria-labelledby="removeLegacyModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="removeLegacyModalLabel">Remove Legacy Status</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to remove legacy character status from <?= htmlspecialchars($charname) ?>?</p>
					<p>This will delete all legacy character information, including:</p>
					<ul>
						<li>Original setting</li>
						<li>Legacy history</li>
						<li>Tier progression</li>
						<li>Admin notes</li>
					</ul>
					<p class="text-danger"><strong>This action cannot be undone.</strong></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<form action="charedit.php" method="post">
						<input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
						<input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
						<input type="hidden" name="charname" value="<?= htmlspecialchars($charname) ?>">
						<input type="hidden" name="remove_legacy" value="1">
						<button type="submit" class="btn btn-danger">Remove Legacy Status</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</body>
</html>