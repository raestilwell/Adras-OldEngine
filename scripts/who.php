<?php
/**
 * Enhanced Internal Who Page for Online Users
 * Includes responsive design with Bootstrap and accordion cards for mobile view
 */
$command = 1;

// Include the template file
require_once($_SERVER['DOCUMENT_ROOT'] . "/templates/who-template.php");

// Begin output
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="See who's currently online in Adrastium: Realms Reborn">
	<title>Who's Online | Adrastium</title>
	
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	
	<!-- FontAwesome CDN -->
	<script src="https://kit.fontawesome.com/c11c3ebcdf.js" crossorigin="anonymous"></script>
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="../assets/css/styles.css"/>
	<link rel="stylesheet" href="../assets/css/who-styles.css"/>
	
</head>
<body class="who-page internal-who <?= $isAdmin ? 'admin-user' : 'regular-user' ?>">
	<div class="container-fluid py-4">
		<div class="row justify-content-center">
			<div class="col-12">
				<h1 class="text-center">Current Adventurers</h1>
				<hr class="w-30 mx-auto">
				
				<?php
				// Determine view type based on admin level
				if (($admin == "T") || ($admin == "W")) {
					$viewType = 'admin';
				} else if (!is_numeric($admin)) {
					$viewType = 'full';
				} else {
					$viewType = 'basic';
				}
				
				// Check if current user is an admin
				$isAdmin = !is_numeric($admin) || $admin == "T" || $admin == "W" || $admin == "A" || $admin == "X" || $username == "Rae";

				// Get online players
				$whodata = explode(":", getfile("online"));
				$ips = "";
				$bips = "";
				$numon = count($whodata) - 1;
				$numshow = $numon;
				
				// First pass to identify duplicate IPs
				for ($i = 0; $i < $numon; $i++) {
					if (empty($whodata[$i])) continue;
					$whouser = $whodata[$i];
					if (strpos(getuser($whouser, "flags"), "(hideip)") !== false) continue;
					$ip = getuser($whouser, "ip");
					if (strpos($ips, "($ip)") !== false) $bips .= "($ip)";
					$ips .= "($ip)";
				}
				
				// Check if any legacy characters are online
				$anyLegacyCharactersOnline = false;
				for ($i = 0; $i < $numon; $i++) {
					if (!empty($whodata[$i])) {
						$whouser = $whodata[$i];
						if (getuser($whouser, "is_legacy") == 1) {
							$anyLegacyCharactersOnline = true;
							break;
						}
					}
				}
				
				// Collect characters for both desktop and mobile views
				$characters = [];
				
				for ($i = 0; $i <= $numon; $i++) {
					if (empty($whodata[$i])) continue;
					
					$whouser = $whodata[$i];
					
					// Skip hidden users for non-admins
					if (strpos(getuser($whouser, "flags"), "(nowho)") !== false && is_numeric($admin)) {
						$numshow--;
						continue;
					}
					
					// Get character information
					$whoname = getuser($whouser, "name");
					$whotime = time() - getuser($whouser, "last_action");
					$whomins = floor($whotime / 60);
					$whosecs = $whotime % 60;
					$coords = getcoords($whouser);
					$p = getuser($whouser, "plane");
					$wp = ucfirst($p);
					
					// Special character flags
					$userFlags = getuser($whouser, "flags");
					$isNewPlayer = strpos($userFlags, "(newplayer)") !== false;
					$isLegacy = getuser($whouser, "is_legacy") == 1;
					$legacyTier = getuser($whouser, "legacy_tier") ?: 1;
					
					// AFK tooltip
					$whoafk = "";
					$afkMessage = "";
					if (getuser($whouser, "isafk") === "y") {
						$whoafk = "data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"AFK: " . getuser($whouser, "afk") . "\"";
						$afkMessage = getuser($whouser, "afk");
					}
					
					// Get level title
					$t = getlevel($p, $coords, "title");
					
					// Admin level display
					$adminLevel = determineAdminLevel($whouser);
					$adminIcon = "";
					if ($adminLevel != "") {
						$adminIcon = "<i class=\"fa-solid fa-crown\" title=\"$adminLevel\"></i>";
					}
					
					// IP display with formatting for duplicates
					$ip = getuser($whouser, "ip");
					$ipDisplay = $ip;
					if (strpos($bips, "($ip)") !== false) {
						$ipDisplay = "<span class=\"text-warning\">$ip</span>";
					}
					
					if (strpos(getuser($whouser, "flags"), "(hideip)") !== false) {
						$ipDisplay = "127.0.0.1";
					}
					
					// Friends display
					$nameClass = "";
					if (strpos(get("friends"), "$whouser:") !== false) {
						$whoname = "<span class=\"friends\">$whoname</span>";
						$nameClass = "friends";
					}
					
					// Self highlighting
					if ($whouser == $username) {
						$whoname = "<span class=\"self\">$whoname</span>";
						$nameClass = "self";
					}
					
					// Icons for special character types
					$icons = "";
					if ($isAdmin) {
						if ($isNewPlayer) {
							$icons .= " <i class='fa-solid fa-sparkles' title=\"New Player!\"></i>";
						}
						if ($isLegacy) {
							$icons .= " <i class='fa-solid fa-hourglass' title=\"Legacy Character\"></i>";
						}
					}
					
					// Store character data for both views
					$characters[] = [
						'username' => $whouser,
						'displayName' => $whoname,
						'nameClass' => $nameClass,
						'minutesIdle' => $whomins,
						'secondsIdle' => $whosecs,
						'adminLevel' => $adminLevel,
						'adminIcon' => $adminIcon,
						'ipAddress' => $ipDisplay,
						'rawIp' => $ip,
						'coordinates' => "$coords $wp",
						'levelTitle' => $t,
						'isAfk' => getuser($whouser, "isafk") === "y",
						'afkTooltip' => $whoafk,
						'afkMessage' => $afkMessage,
						'icons' => $icons,
						'isLegacy' => $isLegacy,
						'legacyTier' => $legacyTier
					];
				}
				?>
				
				<!-- Desktop View (Table) -->
				<div class="who-container desktop-table">
					<div class="table-responsive">
						<table class="who-table">
							<tr>
								<td class="cinzel-heading">Name</td>
								<td class="spacer"></td>
								<td class="cinzel-heading">Minutes Idle</td>
								
								<?php if ($viewType == 'admin' || $viewType == 'full'): ?>
									<td class="spacer"></td>
									<td class="cinzel-heading hide-on-mobile">Seconds Idle</td>
								<?php endif; ?>
								
								<td class="spacer"></td>
								<td class="cinzel-heading">Admin Level</td>
								
								<?php if ($viewType == 'full'): ?>
									<td class="spacer"></td>
									<td class="cinzel-heading hide-on-mobile">IP Address</td>
								<?php endif; ?>
								
								<?php if ($viewType == 'admin' || $viewType == 'full'): ?>
									<td class="spacer"></td>
									<td class="cinzel-heading hide-on-mobile">Location</td>
								<?php endif; ?>
								
								<?php if (($viewType == 'full' || $viewType == 'admin') && $anyLegacyCharactersOnline): ?>
									<td class="spacer"></td>
									<td class="cinzel-heading hide-on-mobile">Legacy Tier</td>
								<?php endif; ?>
							</tr>
							
							<?php foreach ($characters as $char): ?>
							<tr>
								<td>
									<?php if (!empty($char['adminIcon'])): echo $char['adminIcon'] . " "; endif; ?>
									<a href="javascript:parent.frames[0].location='main.php?username=<?= $username ?>&password=<?= $password ?>&action=lookwho <?= $char['username'] ?>'" <?= $char['afkTooltip'] ?> class="text-white">
										<?= $char['displayName'] ?>
									</a>
									<?= $char['icons'] ?>
								</td>
								<td class="spacer"></td>
								<td><center><?= $char['minutesIdle'] ?></center></td>
								
								<?php if ($viewType == 'admin' || $viewType == 'full'): ?>
									<td class="spacer"></td>
									<td class="hide-on-mobile"><center><?= $char['secondsIdle'] ?></center></td>
								<?php endif; ?>
								
								<td class="spacer"></td>
								<td><center><?= $char['adminLevel'] ?></center></td>
								
								<?php if ($viewType == 'full'): ?>
									<td class="spacer"></td>
									<td class="hide-on-mobile"><?= $char['ipAddress'] ?></td>
								<?php endif; ?>
								
								<?php if ($viewType == 'admin' || $viewType == 'full'): ?>
									<td class="spacer"></td>
									<td class="hide-on-mobile"><center>
										<a href="javascript:parent.frames[0].location='main.php?username=<?= $username ?>&password=<?= $password ?>&action=teleport+to+<?= $char['username'] ?>'" class="text-white">
											<?= $char['coordinates'] ?>
										</a>
										<?php if (!empty($char['levelTitle'])): ?> | <?= $char['levelTitle'] ?><?php endif; ?>
									</center></td>
								<?php endif; ?>
								
								<?php if (($viewType == 'full' || $viewType == 'admin') && $anyLegacyCharactersOnline): ?>
									<td class="spacer"></td>
									<td class="hide-on-mobile"><center>
										<?= $char['isLegacy'] ? $char['legacyTier'] : "-" ?>
									</center></td>
								<?php endif; ?>
							</tr>
							<?php endforeach; ?>
							
							<tr><td colspan='14' align='center' class='player-count'>There are <?= $numshow ?> adventurers online.</td></tr>
						</table>
					</div>
				</div>
				
				<!-- Mobile View (Accordion) -->
				<div class="who-container mobile-accordion">
					<div class="accordion-container">
						<div class="accordion" id="whoAccordion">
						<?php $index = 0; foreach ($characters as $char): $index++; ?>
						<div class="accordion-item mb-2">
							<h2 class="accordion-header" id="heading<?= $index ?>">
								<button class="accordion-button <?= ($index !== 1) ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= ($index === 1) ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
									<div class="character-header">
										<div class="character-name">
											<?php if (!empty($char['adminIcon'])): echo $char['adminIcon'] . " "; endif; ?>
											<span class="<?= $char['nameClass'] ?>"><?= strip_tags($char['displayName']) ?></span>
											<?php if ($char['isAfk']): ?>
												<span class="ms-2 badge bg-secondary">AFK</span>
											<?php endif; ?>
										</div>
										<div class="character-icons">
											<?= $char['icons'] ?>
										</div>
									</div>
								</button>
							</h2>
							<div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= ($index === 1) ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#whoAccordion">
								<div class="accordion-body">
									<div class="character-info-grid">
										<div class="info-label">Idle Time:</div>
										<div class="info-value"><?= $char['minutesIdle'] ?>m <?= $char['secondsIdle'] ?>s</div>
										
										<div class="info-label">Admin Level:</div>
										<div class="info-value"><?= $char['adminLevel'] ?: 'None' ?></div>
										
										<?php if ($viewType == 'full'): ?>
										<div class="info-label">IP Address:</div>
										<div class="info-value"><?= strip_tags($char['ipAddress']) ?></div>
										<?php endif; ?>
										
										<div class="info-label">Location:</div>
										<div class="info-value"><?= $char['coordinates'] ?>
											<?php if (!empty($char['levelTitle'])): ?>
												<div class="level-title"><?= $char['levelTitle'] ?></div>
											<?php endif; ?>
										</div>
										
										<?php if (($viewType == 'full' || $viewType == 'admin') && $char['isLegacy']): ?>
										<div class="info-label">Legacy Tier:</div>
										<div class="info-value"><?= $char['legacyTier'] ?></div>
										<?php endif; ?>
										
										<?php if ($char['isAfk'] && !empty($char['afkMessage'])): ?>
										<div class="info-label">AFK Message:</div>
										<div class="info-value"><?= $char['afkMessage'] ?></div>
										<?php endif; ?>
									</div>
									
									<div class="character-actions mt-3">
										<a href="javascript:parent.frames[0].location='main.php?username=<?= $username ?>&password=<?= $password ?>&action=lookwho <?= $char['username'] ?>'">
											<i class="fa-solid fa-eye"></i> Look
										</a>
										<?php if ($viewType == 'admin' || $viewType == 'full'): ?>
										<a href="javascript:parent.frames[0].location='main.php?username=<?= $username ?>&password=<?= $password ?>&action=teleport+to+<?= $char['username'] ?>'">
											<i class="fa-solid fa-location-arrow"></i> Teleport
										</a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					</div>
					<div class="text-center player-count mt-3">
						There are <?= $numshow ?> adventurers online.
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Bootstrap Javascript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
	
	<script>
		// Initialize tooltips
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
</body>
</html>

<?php
// Helper function to determine admin level display
function determineAdminLevel($whouser) {
	if (getuser($whouser, "admin") === "0") {
		return "";
	} else if ($whouser == "Rae") {
		return "Owner";
	} else if (getuser($whouser, "admin") == "T") {
		return "Moderator";
	} else if (getuser($whouser, "admin") == "A") {
		return "Junior Admin";
	} else if (getuser($whouser, "admin") == "X") {
		return "Admin";
	} else if (getuser($whouser, "admin") == "W") {
		return "Volunteer";
	} else {
		return getuser($whouser, "admin");
	}
}
?>