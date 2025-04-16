<?php
// Set command flag to indicate successful execution
$command = 1;

// Get the username to look up from action3 array
// First check if we have a valid username
if (isset($action3[1])) {
	$peep = ucwords(strtolower($action3[1]));
} else {
	echo "No character name specified.";
	die();
}

$peepsname = getuser($peep, "name");

// Include appearance functions 
require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/appearanceFunc.php");

// Getting basic character info
$gender = getuser($peep, "gender");
list($HeShe, $heshe, $hisher) = getGenderPronouns($gender);

// Gender grammar handling
$gendertest = $gender == "other" ? "are" : "is";
$gendergrammar = $gender == "other" ? "have" : "has";

// Organizations
$guild = getOrganizationInfo($peep, "guild", "guild", "guilds");
$clan = getOrganizationInfo($peep, "clan", "clan", "clans");
$militia = getOrganizationInfo($peep, "militia", "militia", "militias");
$descript = nl2br(getuser($peep, "description"));

// Character attributes
$home = formatInfo($peep, "hometown");
$eyes = formatInfo($peep, "eyes");
$hair = formatInfo($peep, "hair");
$skin = formatInfo($peep, "skin");
$height = formatInfo($peep, "height");
$build = formatInfo($peep, "build");
$rank = formatInfo($peep, "rank");
$class = formatInfo($peep, "class");
$race = formatInfo($peep, "race");
$fame = getuser($peep, "fame");

// Weapon status
$weapon = getuser($peep, "weapon");
if ($weapon) {
	$wep = "$HeShe $gendertest wielding <i>$weapon</i>.";
} else {
	$wep = "$HeShe $gendergrammar <i>no weapon</i>.";
}

// Marriage status
$spouse = getuser($peep, "spouse");
if ($spouse == "none") {
	$spouse = "$HeShe $gendertest not married. ";
} else {
	$spouse = "$HeShe $gendertest married to <i>" . getuser($spouse, "name") . "</i>. ";
}

// Deity information
$god = ucwords(strtolower(getuser($peep, "deity")));
if (strtolower($god) == "none") {
	$god = "";
} elseif (strtolower($god) == "faithless") {
	$god = ", and $gendertest <i>faithless</i>";
} else {
	$god = ", and $gendertest a follower of <i>$god</i>";
}

// Equipment
$head = formatEquipment($peep, "head");
$ears = formatEquipment($peep, "ears");
$neck = formatEquipment($peep, "neck");
$body = formatEquipment($peep, "body");
$larm = formatEquipment($peep, "larm");
$rarm = formatEquipment($peep, "rarm");
$wrists = formatEquipment($peep, "wrists");
$hands = formatEquipment($peep, "hands");
$fingers = formatEquipment($peep, "fingers");
$legs = formatEquipment($peep, "legs");
$feet = formatEquipment($peep, "feet");

// Grammar articles
$grammarRace = getGrammarArticle(getuser($peep, "race"));
$grammarClass = getGrammarArticle(getuser($peep, "class"));
$grammarRank = getGrammarArticle(getuser($peep, "rank"));

// Equipment description - match parameters to appearanceFunc.php
$arm = generateArmDescription($peep, $HeShe, $hisher, $gendergrammar, $gender, $head, $ears, $neck, $body, $larm, $rarm, $wrists, $hands, $fingers, $legs, $feet);

// Other info
$other = "";

// Check if admin
$isAdmin = false;
$adminLevel = get("admin");
if ($adminLevel == "X" || $adminLevel == "A" || $adminLevel == "T" || $username == "Rae") {
	$isAdmin = true;
}

// Get legacy character information
$isLegacy = getuser($peep, "is_legacy") == 1;
$legacySetting = getuser($peep, "legacy_setting");
$legacyHistory = getuser($peep, "legacy_history");
$legacyTier = getuser($peep, "legacy_tier") ?: 1;
$legacyAdminNotes = getuser($peep, "legacy_admin_notes");

// Get tier date or use character creation date as fallback
$legacyTierDate = getuser($peep, "legacy_tier_date");
if (empty($legacyTierDate)) {
	// If legacy_tier_date doesn't exist, use the character's creation date
	$legacyTierDate = date("Y-m-d H:i:s", getuser($peep, "created"));
}

// Format basic character info based on rank
if ($rank === "<i>denizen</i>") {
	$characterInfo = "$peepsname is $grammarRace $race and appears to be $grammarClass $class. $HeShe $gendertest from $home$god. $HeShe $gendertest $height and $build, and $heshe $gendergrammar $eyes eyes, $hair hair, and $skin skin. $spouse$peepsname has a fame rating of $fame. $wep $arm<br>\n$guild<br>\n$clan<br>\n$militia$other<br><br>\n$descript";
} else {
	$characterInfo = "$peepsname is $grammarRace $race and appears to be $grammarClass $class. $HeShe $gendertest $grammarRank $rank from $home$god. $HeShe $gendertest $height and $build, and $heshe $gendergrammar $eyes eyes, $hair hair, and $skin skin. $spouse$peepsname has a fame rating of $fame. $wep $arm<br>\n$guild<br>\n$clan<br>\n$militia$other<br><br>\n$descript";
}

// Add legacy character information for admins
if ($isAdmin && $isLegacy) {
	// Calculate days in current tier
	$currentTime = time();
	
	// Handle different date formats
	if (is_numeric($legacyTierDate)) {
		$tierTime = $legacyTierDate; // Already a timestamp
	} else {
		$tierTime = strtotime($legacyTierDate); // Convert from string date
		
		// If conversion fails, use character creation time
		if ($tierTime === false) {
			$tierTime = getuser($peep, "created");
		}
	}
	
	$daysInTier = floor(($currentTime - $tierTime) / (60 * 60 * 24));
	
	// Format tier information with appropriate styling
	$tierStyles = [
		1 => "color: #6c757d; font-weight: bold;", // Grey for Tier 1
		2 => "color: #28a745; font-weight: bold;", // Green for Tier 2
		3 => "color: #9966CC; font-weight: bold;"  // Purple for Tier 3
	];
	
	$tierStyle = $tierStyles[$legacyTier] ?? $tierStyles[1];
	
	// Create admin-only legacy character information section
	$legacyInfo = "<hr><div style='border: 1px solid #555; padding: 10px; margin: 10px 0; background-color: #212121;'>";
	$legacyInfo .= "<h4 style='margin-top: 0;'><i class='fa-solid fa-crown'></i> Legacy Character Information (Admin Only)</h4>";
	$legacyInfo .= "<p><strong>Original Setting:</strong> " . htmlspecialchars($legacySetting) . "</p>";
	$legacyInfo .= "<p><strong>Current Tier:</strong> <span style='$tierStyle'>Tier $legacyTier</span> ($daysInTier days in current tier)</p>";
	
	// Show progression requirements
	if ($legacyTier == 1) {
		$daysRemaining = max(0, 30 - $daysInTier);
		$legacyInfo .= "<p><strong>Tier Progression:</strong> " . ($daysRemaining > 0 ? "$daysRemaining days remaining before eligible for Tier 2" : "Eligible for Tier 2 progression") . "</p>";
	} elseif ($legacyTier == 2) {
		$totalDays = $daysInTier + 30; // Assuming Tier 1 was at least 30 days
		$daysRemaining = max(0, 90 - $totalDays);
		$legacyInfo .= "<p><strong>Tier Progression:</strong> " . ($daysRemaining > 0 ? "Approximately $daysRemaining more days before eligible for Tier 3" : "Eligible for Tier 3 progression") . "</p>";
	} else {
		$legacyInfo .= "<p><strong>Tier Progression:</strong> Maximum tier reached</p>";
	}
	
	// Legacy character history
	$legacyInfo .= "<p><strong>Legacy History:</strong></p>";
	$legacyInfo .= "<div style='max-height: 150px; overflow-y: auto; background-color: #212121; padding: 10px; border-radius: 5px;'>";
	$legacyInfo .= nl2br(htmlspecialchars($legacyHistory));
	$legacyInfo .= "</div>";
	
	// Add admin notes section if they exist
	if (!empty($legacyAdminNotes)) {
		$legacyInfo .= "<p><strong>Admin Notes:</strong></p>";
		$legacyInfo .= "<div style='max-height: 150px; overflow-y: auto; background-color: #212121; padding: 10px; border-radius: 5px;'>";
		$legacyInfo .= nl2br(htmlspecialchars($legacyAdminNotes));
		$legacyInfo .= "</div>";
	}
	
	$legacyInfo .= "</div>";
	
	// Append legacy information to character display for admins
	$characterInfo .= $legacyInfo;
}

// Remove equipment display if flag isn't set
if (strpos(getuser($peep, "flags"), "(equip)") === false) {
	$arm = "";
}

// Get user color preferences
$textColor = get("tcolor") ?: "#FFFFFF";
$borderColor = get("ccolor") ?: "#333333";

// Create a simple modal that doesn't require Bootstrap JavaScript
?>

<!-- Simple Modal Overlay -->
<div id="simple-modal">
  <div class="modal-container">
	<!-- Modal Header -->
	<div class="modal-header">
	  <h3 class="modal-title"><?= $peepsname ?></h3>
	  <button onclick="closeModal();" class="modal-close">
		<i class="fa-solid fa-x"></i>
	  </button>
	</div>
	
	<!-- Modal Body -->
	<div class="modal-body">
	  <?= $characterInfo ?>
	</div>
	
	<!-- Modal Footer with Admin Buttons -->
	<div class="modal-footer">
	  
 <?php if ($isAdmin): ?>
	  <!-- Admin Action Buttons -->
	  <div class="admin-button-group">
		<!-- Edit button disabled for now -->
		<button class="admin-button" style="opacity: 0.5; cursor: not-allowed;" disabled>
		  <i class="fa-solid fa-user-pen"></i> Edit Character
		</button>
		<a href="main.php?username=<?= urlencode($username) ?>&password=<?= urlencode($password) ?>&action=summon <?= $peep ?>" class="admin-button">
		  <i class="fa-solid fa-person-circle-plus"></i> Summon Here
		</a>
		<a href="main.php?username=<?= urlencode($username) ?>&password=<?= urlencode($password) ?>&action=teleport to <?= $peep ?>" class="admin-button">
		  <i class="fa-solid fa-location-crosshairs"></i> Teleport to Location
		</a>
	  </div>
	  <?php else: ?>
	  <!-- For non-admins, just a close button -->
	  <button onclick="closeModal();" class="close-button">Close</button>
	  <?php endif; ?>
	</div>
  </div>
</div>

<!-- Style for hover effect on buttons -->
<style>
/* Modal styling */
#simple-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-container {
  width: 90%;
  max-width: 1200px;
  max-height: 85vh;
  background-color: #212121;
  border: 2px solid #333333;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0,0,0,0.5);
  overflow: hidden;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #333333;
  background-color: #212121;
}

.modal-title {
  margin: 0;
  font-size: 1.5rem;
  color: #FFFFFF;
}

.modal-close {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-close i {
  color: #fff;
  font-size: 28px;
  transition: color 0.3s ease;
}

.modal-close i:hover {
  color: #9d436b;
}

.modal-body {
  padding: 20px;
  max-height: calc(85vh - 130px);
  overflow-y: auto;
  background-color: #212121;
  color: #FFFFFF;
}

.modal-footer {
  padding: 15px 20px;
  border-top: 1px solid #333333;
  background-color: #212121;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
}

/* Button styling */
.admin-button-group {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.admin-button {
  padding: 8px 12px;
  background-color: #9d436b;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-family: 'Quattrocento', serif;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: background-color 0.3s ease;
}

.admin-button i {
  margin-right: 5px;
}

.admin-button:hover {
  background-color: #7d2e51;
}

.close-button {
  padding: 10px 20px;
  background-color: #9d436b;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-family: 'Quattrocento', serif;
  transition: background-color 0.3s ease;
}

.close-button:hover {
  background-color: #7d2e51;
}
</style>

<!-- Script to handle modal functionality including scroll locking -->
<script>
  // Store the original body overflow style
  var originalStyle = document.body.style.overflow;
  
  // Lock the scroll when modal appears
  document.body.style.overflow = 'hidden';
  
  // Function to close the modal and restore scrolling
  function closeModal() {
	document.getElementById('simple-modal').style.display = 'none';
	document.body.style.overflow = originalStyle;
  }
  
  // Handle Escape key
  document.addEventListener('keydown', function(event) {
	if (event.key === 'Escape') {
	  closeModal();
	}
  });
  
  // Optional: Close modal when clicking on the backdrop (outside the modal)
  document.getElementById('simple-modal').addEventListener('click', function(event) {
	if (event.target === this) {
	  closeModal();
	}
  });
</script>

<!-- Continue normal game flow -->
<?php
// Run the look action to show the room
$originalAction = $action;
$originalAction2 = $action2;
$originalAction3 = $action3;

// Reset action to "look" to show the room
$action = "look";
$action2 = "look";
$action3 = array("look");

// Set a flag to prevent recursive lookwho calls
$isAfterLookwho = true;

// Show the room as well
if (!islevel(get("plane"), coords())) {
	echo "This level doesn't seem to exist.<br>\n";
	set("x", "you");
	set("y", "are");
	set("z", "stuck");
	set("plane", "physical");
} else {
	require("scripts/showhere.php");
}

// Optional: Reset original action values if needed
$action = $originalAction;
$action2 = $originalAction2;
$action3 = $originalAction3;
?>