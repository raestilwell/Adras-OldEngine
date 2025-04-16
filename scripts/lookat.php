<?php
$command = 1;
$peep = ucwords(strtolower($action3[2]));
$peepsname = getuser($peep, "name");
$peeps = getlevel(get("plane"), coords(), "pcs");
$pflags = getuser($peep, "flags");

require("../www/functions/appearanceFunc.php");

$gender = getuser($peep, "gender");
list($HeShe, $heshe, $hisher) = getGenderPronouns($gender);

if (isset($action3[3])) {
	$boolean = ucwords(strtolower($action3[3]));
	
	// Perform operations using $boolean
	if ($boolean != "") {
		$name = "<i>" . getuser($peep, "name") . "</i>";
		$race = "<i>" . getuser($peep, "race") . "</i>";
		$gender = getuser($peep, "gender");
		list($HeShe, $heshe, $hisher) = getGenderPronouns($gender);
	} else {
		$boolean = '';
		$name = formatInfo($peep, "name"); // Use formatInfo function for consistency
		$race = "<i>Unknown</i>"; // Assign a default value for $race
		// Consider redirecting to an error page or displaying a user-friendly message
		echo "The required value is not available."; // Error message
	}
}

$gendertest = getuser($peep, "gender") == "other" ? "are" : "is";
$gendergrammar = getuser($peep, "gender") == "other" ? "have" : "has";
	
$guild = getOrganizationInfo($peep, "guild", "guild", "guilds");
$clan = getOrganizationInfo($peep, "clan", "clan", "clans");
$militia = getOrganizationInfo($peep, "militia", "militia", "militias");
$descript = nl2br(getuser($peep, "description"));

$gender = getuser($peep, "gender");
$home = formatInfo($peep, "hometown");
$eyes = formatInfo($peep, "eyes");
$hair = formatInfo($peep, "hair");
$skin = formatInfo($peep, "skin");
$height = formatInfo($peep, "height");
$build = formatInfo($peep, "build");
$rank = formatInfo($peep, "rank");
$class = formatInfo($peep, "class");
$race = formatInfo($peep, "race");
$fame = formatInfo($peep, "famerank");

$weapon = formatInfo($peep, "weapon");
$wepDescription = $weapon ? "$HeShe $gendertest wielding <i>$weapon</i>." : "$HeShe $gendergrammar <i>no weapon</i>.";

$petData = formatInfo($peep, "pet");
$ret = generateRetDescription($peep, $petData);

$spouse = getuser($peep, "spouse");

$spouse = getuser($peep,"spouse");
if ($spouse == "none") { $spouse = "$HeShe $gendertest not married. ";} else {$spouse = "$HeShe $gendertest married to <i>".getuser($spouse,"name")."</i>. ";}

$god = getuser($peep, "deity");
$godStatus = (strtolower($god) == "none")
	? formatInfo($peep, "")
	: ((strtolower($god) == "faithless")
		? formatInfo($peep, ", and $gendertest <i>faithless</i>")
		: formatInfo($peep, ", and $gendertest a follower of <i>$god</i>"));	
			
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

$grammarRace = getGrammarArticle(getuser($peep, "race"));
$grammarClass = getGrammarArticle(getuser($peep, "class"));
$grammarRank = getGrammarArticle(getuser($peep, "rank"));

$arm = generateArmDescription($peep, $HeShe, $hisher, $gendergrammar, $gender, $head, $ears, $neck, $body, $larm, $rarm, $wrists, $hands, $fingers, $legs, $feet);

// Check if the viewer is an admin
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

// Format basic character info
if ($rank === "<i>denizen</i>"){
	$characterInfo = "<br>$peepsname is $grammarRace $race and appears to be $grammarClass $class. $HeShe $gendertest from $home. $peepsname is $height and $build, and $heshe $gendergrammar $eyes eyes, $hair hair, and $skin skin." . " $wepDescription $arm<br>$spouse<br>\n$guild<br>\n$clan<br>\n$militia<br><br>\n$descript";
} else {
	$characterInfo = "<br>$peepsname is $grammarRace $race and appears to be $grammarClass $class. $HeShe $gendertest $grammarRank $rank from $home. $peepsname is $height and $build, and $heshe $gendergrammar $eyes eyes, $hair hair, and $skin skin." . " $wepDescription $arm<br>$spouse<br>\n$guild<br>\n$clan<br>\n$militia<br><br>\n$descript";
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
	$legacyInfo = "<hr><div style='border: 1px solid #555; padding: 10px; margin: 10px 0; background-color: rgba(0,0,0,0.1);'>";
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
	$legacyInfo .= "<div style='max-height: 150px; overflow-y: auto; background-color: rgba(0,0,0,0.1); padding: 10px; border-radius: 5px;'>";
	$legacyInfo .= nl2br(htmlspecialchars($legacyHistory));
	$legacyInfo .= "</div>";
	
	// Add admin notes section if they exist
	if (!empty($legacyAdminNotes)) {
		$legacyInfo .= "<p><strong>Admin Notes:</strong></p>";
		$legacyInfo .= "<div style='max-height: 150px; overflow-y: auto; background-color: rgba(0,0,0,0.1); padding: 10px; border-radius: 5px;'>";
		$legacyInfo .= nl2br(htmlspecialchars($legacyAdminNotes));
		$legacyInfo .= "</div>";
	}
	
	$legacyInfo .= "</div>";
	
	// Append legacy information to character display for admins
	$characterInfo .= $legacyInfo;
}

if (strpos(getuser($peep, "flags"), "(equip)") === false) {
	$arm = "";
} elseif ($peep != $username && (strpos($peeps, "$peep:") === false || strpos(getuser($peep, "flags"), "(invis)") !== false)) {
	echo "You do not see $peep here.";
} else {
	echo $characterInfo;
}

if ($peep != $username) {
	$myname = get("name");
	set("chat", get("chat") . "<b><font class=self>You looked at $peepsname.</font></b><br>\n");
	$chardata = explode(":", getlevel(get("plane"), coords(), "pcs"));
	$numchars = count($chardata);
	for ($i = 0; $i < $numchars; $i++) {
		if ($chardata[$i] != $username && $chardata[$i] != "") {
			$peepname = $chardata[$i];
			$cp = getuser($peepname, "chatpref");
			if ($chardata[$i] == $peep) {
				$peepchat = "<b>$myname looked at you.</b><br>\n";
				if ($cp[10] == 1) setuser($peepname, "newchat", 1);
			} elseif (strpos(getuser($peepname, "friends"), "$username:") !== false) {
				$peepchat = "<font class=friends>$myname looked at $peepsname.</font><br>\n";
			} else {
				$peepchat = "$myname looked at $peepsname.<br>\n";
			}
			setuser($peepname, "chat", getuser($peepname, "chat") . $peepchat);
			if ($chardata[$i] != $peep && $cp[11] == 1) setuser($peepname, "newchat", 1);
		}
	}
}
?>