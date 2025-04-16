<?php
$command = 1;
?>

<style>
	.btn-pink {
		font-family: 'Quattrocento', serif;
		background-color: #9d436b;
		color: #fff;
	}
	
	.btn-pink:hover{
		background-color: #7d2e51;
	}
	
	.legacy-info {
		border: 1px solid #555;
		border-radius: 5px;
		padding: 15px;
		margin-bottom: 20px;
		background-color: rgba(0,0,0,0.1);
	}
	
	.tier-badge {
		font-size: 0.9rem;
		padding: 0.25em 0.5em;
		border-radius: 3px;
		margin-left: 5px;
		display: inline-block;
	}
	
	.tier-1 { background-color: #6c757d; color: white; }
	.tier-2 { background-color: #28a745; color: white; }
	.tier-3 { background-color: #9966CC; color: white; }
	
	.progress {
		height: 25px;
		background-color: #2d2d2d;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	
	.progress-bar {
		color: white;
		font-weight: bold;
	}
</style>

<div class="container w-70 mx-auto">
<?php
// Check if character is a legacy character
$isLegacy = getuser($username, "is_legacy") == 1;

// If character is a legacy character, display legacy information
if ($isLegacy) {
	$legacyTier = getuser($username, "legacy_tier") ?: 1;
	$legacyTierDate = getuser($username, "legacy_tier_date") ?: date('Y-m-d H:i:s');
	$legacySetting = getuser($username, "legacy_setting");
	
	// Calculate days in current tier
	$currentTime = time();
	$tierTime = strtotime($legacyTierDate);
	$daysInTier = floor(($currentTime - $tierTime) / (60 * 60 * 24));
	
	// Calculate progress percentage
	$progressPercent = 0;
	$daysRemaining = 0;
	$progressLabel = "";
	
	if ($legacyTier == 1) {
		// Tier 1 progress (30 days minimum)
		$progressPercent = min(100, ($daysInTier / 30) * 100);
		$daysRemaining = max(0, 30 - $daysInTier);
		$progressLabel = $daysRemaining > 0 ? 
			"$daysRemaining days remaining before eligible for Tier 2" : 
			"Eligible for Tier 2 progression";
	} elseif ($legacyTier == 2) {
		// Tier 2 progress (90 days total minimum)
		$totalDays = $daysInTier + 30; // Assuming Tier 1 was at least 30 days
		$progressPercent = min(100, ($totalDays / 90) * 100);
		$daysRemaining = max(0, 90 - $totalDays);
		$progressLabel = $daysRemaining > 0 ? 
			"Approximately $daysRemaining more days before eligible for Tier 3" : 
			"Eligible for Tier 3 progression";
	} else {
		// Tier 3 (max tier)
		$progressPercent = 100;
		$progressLabel = "Maximum tier reached";
	}
	
	// Tier descriptions
	$tierDescriptions = [
		1 => "Basic class abilities only",
		2 => "Limited special abilities unlocked",
		3 => "Significant abilities unlocked"
	];
	
	// Tier colors
	$tierColors = [
		1 => "#6c757d",
		2 => "#28a745",
		3 => "#9966CC"
	];
	
	// Display legacy character information
	echo '<div class="legacy-info">';
	echo '<div class="row">';
	echo '<div class="col-9">';
	echo '<h3><i class="fa-solid fa-crown"></i> Legacy Character Information</h3>';
	echo '</div>';
	echo '<div class="col-3 text-end">';
	echo '<span class="tier-badge tier-' . $legacyTier . '">Tier ' . $legacyTier . '</span>';
	echo '</div>';
	echo '</div>';
	
	echo '<p>Your character from <strong>' . htmlspecialchars($legacySetting) . '</strong> is currently at <strong>Tier ' . $legacyTier . '</strong>: ' . $tierDescriptions[$legacyTier] . '</p>';
	
	echo '<div class="progress">';
	echo '<div class="progress-bar" role="progressbar" style="width: ' . $progressPercent . '%; background-color: ' . $tierColors[$legacyTier] . ';" aria-valuenow="' . $progressPercent . '" aria-valuemin="0" aria-valuemax="100">Tier ' . $legacyTier . ' Progress</div>';
	echo '</div>';
	
	echo '<p><small>' . $progressLabel . '</small></p>';
	echo '<p><small>' . $daysInTier . ' days in current tier</small></p>';
	echo '</div>';
}
?>

<form action="/description.php" method="post">
	<div class="row mb-4">
		<div class="col-6">
			<h2 class="mb-2"><?= htmlspecialchars(get("username")) ?>'s Profile</h2>
			  <label for="description" class="form-label visually-hidden">Character Profile</label>
			  <textarea class="form-control" name="action" style="height: 85.5%;"><?= htmlspecialchars(get("description")) ?></textarea>

		</div>
		
		<div class="col-6">
			<h3 class="mb-2">Character Background</h3>
				<!-- Original input fields -->
				<label for="race">Race</label>
				<input type="text" class="form-control mb-3" id="race" name="race" value="<?= htmlspecialchars(get("race")) ?>" <?= (is_numeric(get("admin"))) ? "disabled" : "" ?>>
				<input type="hidden" name="original_race" value="<?= htmlspecialchars(get("race")) ?>">
				
				<label for="class">Class</label>
				<input type="text" class="form-control mb-3" id="class" name="class" value="<?= htmlspecialchars(get("class")) ?>" <?= (is_numeric(get("admin"))) ? "disabled" : "" ?>>
				<input type="hidden" name="original_class" value="<?= htmlspecialchars(get("class")) ?>">

				  
				  <label for="home">Gender</label>
				  <select class="form-select mb-3" id="gender" name="gender">
					<option value="male" <?= (get("gender") == "male") ? "selected" : "" ?>>Male</option>
					<option value="female" <?= (get("gender") == "female") ? "selected" : "" ?>>Female</option>
					<option value="other" <?= (get("gender") == "other") ? "selected" : "" ?>>Nonbinary/Other</option>
				  </select>
			
				<label for="home">From</label>
				  <input type="text" class="form-control mb-3" id="home" name="home" value="<?= htmlspecialchars(get("hometown")) ?>">
			
				<label for="pet">Pet</label>
				  <input type="text" class="form-control mb-3" id="pet" name="pet" value="<?= htmlspecialchars(get("pet")) ?>">
			
		</div>
	</div>
		
		<div class="row mb-3">
			<div class="col-6">
				<div class="row">
					<div class="col">
						<h3 class="mb-2">Gear and Attire</h3>
					</div>
					<div class="col">
						<label class="form-check-label" for="e">Show Equipment</label>
						<input type="checkbox" "form-check-input" name="e" <?php if (strpos(get("flags"), "(equip)") !== false) echo " checked"; ?>>
						
					</div>
				</div>
			
			<label for="head">Head</label>
				<input type="text" class="form-control mb-3" id="head" name="head" value="<?= htmlspecialchars(get("head")) ?>">
			  
			  <label for="ears">Ears</label>
				<input type="text" class="form-control mb-3" id="ears" name="ears" value="<?= htmlspecialchars(get("ears")) ?>">
				
			<label for="neck">Neck</label>
				  <input type="text" class="form-control mb-3" id="neck" name="neck" value="<?= htmlspecialchars(get("neck")) ?>">
				  
			<label for="body">Body</label>
				<input type="text" class="form-control mb-3" id="body" name="body" value="<?= htmlspecialchars(get("body")) ?>">
					
			<label for="larm">Left Arm</label>
				<input type="text" class="form-control mb-3" id="larm" name="larm" value="<?= htmlspecialchars(get("larm")) ?>">
					  
			<label for="rarm">Right Arm</label>
				<input type="text" class="form-control mb-3" id="rarm" name="rarm" value="<?= htmlspecialchars(get("rarm")) ?>">
						
			<label for="wrists">Wrists</label>
				<input type="text" class="form-control mb-3" id="wrists" name="wrists" value="<?= htmlspecialchars(get("wrists")) ?>">
						  
			<label for="hands">Hands</label>
				<input type="text" class="form-control mb-3" id="hands" name="hands" value="<?= htmlspecialchars(get("hands")) ?>">
							
			<label for="fingers">Fingers</label>
				<input type="text" class="form-control mb-3" id="fingers" name="fingers" value="<?= htmlspecialchars(get("fingers")) ?>">
							  
			<label for="legs">Legs</label>
				<input type="text" class="form-control mb-3" id="legs" name="legs" value="<?= htmlspecialchars(get("legs")) ?>">
								
			<label for="feet">Feet</label>
				<input type="text" class="form-control mb-3" id="feet" name="feet" value="<?= htmlspecialchars(get("feet")) ?>">
				
			<label for="weapon">Weapon</label>
			<input type="text" class="form-control mb-1" id="weapon" name="weapon" value="<?= htmlspecialchars(get("weapon")) ?>" <?= (is_numeric(get("admin"))) ? "disabled" : "" ?>>
			<small class="form-text" style="color: rgba(255,255,255,.6);">Contact an Admin for weapon approval.</small>
			<input type="hidden" name="original_weapon" value="<?= htmlspecialchars(get("weapon")) ?>">

									  
		</div>
	
		<div class="col-6">
			<h3 class="mb-2">Appearance Details</h3>
			<label for="eyes">Eyes</label>
			  <input type="text" class="form-control mb-3" id="eyes" name="eyes" value="<?= htmlspecialchars(get("eyes")) ?>">
			  
			<label for="hair">Hair</label>
			  <input type="text" class="form-control mb-3" id="hair" name="hair" value="<?= htmlspecialchars(get("hair")) ?>">
			  
			<label for="skin">Skin</label>
			   <input type="text" class="form-control mb-3" id="skin" name="skin" value="<?= htmlspecialchars(get("skin")) ?>">
			   
			<label for="height">Height</label>
			  <input type="text" class="form-control mb-3" id="height" name="height" value="<?= htmlspecialchars(get("height")) ?>">
			  
			<label for="build">Build</label>
			  <input type="text" class="form-control mb-3" id="build" name="build" value="<?= htmlspecialchars(get("build")) ?>">
		
			<input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
			<input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>"><br>
			
			<button type="submit" class="btn btn-lg btn-pink fw-bold w-50 float-end">Update Description</button>
		</div>
	</div>
</form>
</div>