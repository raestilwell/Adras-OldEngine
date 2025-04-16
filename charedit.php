<?php
// Gather variables
$username = $_POST['username'];
$password = $_POST['password'];
$charuser = $_POST['charname'];
$charname = $_POST['name'];
$chartitle = $_POST['title'] ?? '';
$charhometown = $_POST['hometown'];
$charrace = $_POST['race'];
$charrank = $_POST['rank'];
$charclass = $_POST['class'];
$chargender = $_POST['gender'];
$chareyes = $_POST['eyes'];
$charskin = $_POST['skin'];
$charhair = $_POST['hair'];
$charbuild = $_POST['build'];
$charheight = $_POST['height'];
$chardeity = $_POST['deity'];
$charhead = $_POST['head'];
$charears = $_POST['ears'];
$charneck = $_POST['neck'];
$charbody = $_POST['body'];
$charlarm = $_POST['larm'] ?? '';
$charrarm = $_POST['rarm'] ?? '';
$charwrists = $_POST['wrists'];
$charhands = $_POST['hands'];
$charfinger = $_POST['finger'];
$charlegs = $_POST['legs'];
$charfeet = $_POST['feet'];
$charpet = $_POST['pet'];
$charweapon = $_POST['weapon'];
$charrecall = $_POST['recall'];
$charrecallplane = $_POST['recallplane'];
$charquests = $_POST['quests'];
$charpiety = $_POST['piety'];
$charfamerank = $_POST['famerank'];
$charproficiency = $_POST['proficiency'];
$charclan = $_POST['clan'];
$charguild = $_POST['guild'];
$charmilitia = $_POST['militia'];
$charx = $_POST['x'];
$chary = $_POST['y'];
$charz = $_POST['z'];
$charplane = $_POST['plane'];
$chardescription = $_POST['description'];
$charflags = $_POST['flags'];
$charmute = $_POST['mute'] ?? '';
$charmutetime = $_POST['mutetime'];
$chardeaf = $_POST['deaf'] ?? '';
$chardeaftime = $_POST['deaftime'];

// Legacy character fields
$isLegacy = isset($_POST['is_legacy']) ? $_POST['is_legacy'] : '0';
$convertToLegacy = isset($_POST['convert_to_legacy']) ? $_POST['convert_to_legacy'] : '0';
$legacySetting = isset($_POST['legacy_setting']) ? $_POST['legacy_setting'] : '';
$legacyHistory = isset($_POST['legacy_history']) ? $_POST['legacy_history'] : '';
$legacyApproved = isset($_POST['legacy_approved']) ? $_POST['legacy_approved'] : '0';
$legacyTier = isset($_POST['legacy_tier']) ? $_POST['legacy_tier'] : '1';
$legacyAdminNotes = isset($_POST['legacy_admin_notes']) ? $_POST['legacy_admin_notes'] : '';
$newLegacySetting = isset($_POST['new_legacy_setting']) ? $_POST['new_legacy_setting'] : '';
$newLegacyHistory = isset($_POST['new_legacy_history']) ? $_POST['new_legacy_history'] : '';
$removeLegacy = isset($_POST['remove_legacy']) ? $_POST['remove_legacy'] : '0';

// Required files
require_once("scripts/function.php");
require_once("scripts/verify.php");
require_once("scripts/style.php");

// Get database connection
$dbh = dbconnect();

// Verify admin status
if (!is_numeric(getuser($username, "admin")) && (md5($password) == getuser($username, "password"))) {
	
	// Check if we're removing legacy status
	if ($removeLegacy == '1') {
		// Handle legacy status removal separately with direct SQL
		// This ensures that ONLY legacy fields are affected
		
		// First, ensure database is selected
		if (!$dbh->select_db("adras_database")) {
			die("Error selecting database: " . $dbh->error);
		}
		
		// Use direct SQL to just clear legacy fields and nothing else
		$legacyQuery = "UPDATE users SET 
			is_legacy = 0,
			legacy_setting = NULL,
			legacy_history = NULL,
			legacy_approved = 0,
			legacy_tier = NULL
			WHERE username = '" . $dbh->real_escape_string($charuser) . "'";
			
		$dbh->query($legacyQuery);
		
		// Handle the problematic legacy_tier_date field
		$checkCol = $dbh->query("SHOW COLUMNS FROM users LIKE 'legacy_tier_date'");
		if ($checkCol && $checkCol->num_rows > 0) {
			$dropQuery = "ALTER TABLE users DROP COLUMN legacy_tier_date";
			$dbh->query($dropQuery);
			
			$addQuery = "ALTER TABLE users ADD COLUMN legacy_tier_date DATETIME NULL";
			$dbh->query($addQuery);
		}
		
		// Handle legacy_admin_notes field
		$checkCol = $dbh->query("SHOW COLUMNS FROM users LIKE 'legacy_admin_notes'");
		if ($checkCol && $checkCol->num_rows > 0) {
			$notesQuery = "UPDATE users SET legacy_admin_notes = NULL WHERE username = '" . $dbh->real_escape_string($charuser) . "'";
			$dbh->query($notesQuery);
		}
		
		// Success message for legacy removal
		echo "Legacy status successfully removed from $charuser. All other character information has been preserved.";
	}
	else {
		// Continue with normal character update
		// Standard character fields update - using setuser() function
		setuser($charuser, "name", $charname);
		setuser($charuser, "title", $chartitle);
		setuser($charuser, "hometown", $charhometown);
		setuser($charuser, "race", $charrace);
		setuser($charuser, "rank", $charrank);
		setuser($charuser, "class", $charclass);
		setuser($charuser, "gender", $chargender);
		setuser($charuser, "eyes", $chareyes);
		setuser($charuser, "skin", $charskin);
		setuser($charuser, "hair", $charhair);
		setuser($charuser, "build", $charbuild);
		setuser($charuser, "height", $charheight);
		setuser($charuser, "deity", $chardeity);
		setuser($charuser, "head", $charhead);
		setuser($charuser, "ears", $charears);
		setuser($charuser, "neck", $charneck);
		setuser($charuser, "body", $charbody);
		setuser($charuser, "larm", $charlarm);
		setuser($charuser, "rarm", $charrarm);
		setuser($charuser, "wrists", $charwrists);
		setuser($charuser, "hands", $charhands);
		setuser($charuser, "finger", $charfinger);
		setuser($charuser, "legs", $charlegs);
		setuser($charuser, "feet", $charfeet);
		setuser($charuser, "pet", $charpet);
		setuser($charuser, "weapon", $charweapon);
		setuser($charuser, "recall", $charrecall);
		setuser($charuser, "recallplane", $charrecallplane);
		setuser($charuser, "quests", $charquests);
		setuser($charuser, "piety", $charpiety);
		setuser($charuser, "famerank", $charfamerank);
		setuser($charuser, "proficiency", $charproficiency);
		setuser($charuser, "clan", $charclan);
		setuser($charuser, "guild", $charguild);
		setuser($charuser, "militia", $charmilitia);
		setuser($charuser, "x", $charx);
		setuser($charuser, "y", $chary);
		setuser($charuser, "z", $charz);
		setuser($charuser, "plane", $charplane);
		setuser($charuser, "description", $chardescription);
		setuser($charuser, "flags", $charflags);
		setuser($charuser, "mtime", $charmutetime);
		setuser($charuser, "dtime", $chardeaftime);
		
		// Check to see if player is muted
		if (isset($_POST['mute']) && $_POST['mute'] == 'Yes') {
			setuser($charuser, "muted", 1);
		} else {
			setuser($charuser, "muted", 0);
		}
		
		// Check to see if player is deafened
		if (isset($_POST['deaf']) && $_POST['deaf'] == 'Yes') {
			setuser($charuser, "deaf", 1);
		} else {
			setuser($charuser, "deaf", 0);
		}
		
		// Ensure database is selected
		if (!$dbh->select_db("adras_database")) {
			die("Error selecting database: " . $dbh->error);
		}
		
		// Ensure necessary columns exist
		$columns = [
			['is_legacy', 'TINYINT(1) DEFAULT 0'],
			['legacy_setting', 'VARCHAR(255)'],
			['legacy_history', 'TEXT'],
			['legacy_tier', 'INT DEFAULT 1'],
			['legacy_tier_date', 'DATETIME NULL'],
			['legacy_admin_notes', 'TEXT'],
			['legacy_approved', 'TINYINT(1) DEFAULT 0']
		];
		
		foreach ($columns as $col) {
			$col_name = $col[0];
			$col_def = $col[1];
			
			$checkCol = $dbh->query("SHOW COLUMNS FROM users LIKE '$col_name'");
			
			if (!$checkCol || $checkCol->num_rows == 0) {
				$dbh->query("ALTER TABLE users ADD COLUMN $col_name $col_def");
			}
		}
		
		// Handle legacy character operations using direct SQL
		if ($isLegacy == '1') {
			// Get current tier
			$result = $dbh->query("SELECT legacy_tier FROM users WHERE username = '" . $dbh->real_escape_string($charuser) . "'");
			$currentTier = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['legacy_tier'] : 0;
			
			// Check if tier has changed
			$updateTierDate = ($legacyTier != $currentTier);
			
			// Update existing legacy character
			$query = "UPDATE users SET 
				is_legacy = 1,
				legacy_setting = '" . $dbh->real_escape_string($legacySetting) . "',
				legacy_history = '" . $dbh->real_escape_string($legacyHistory) . "',
				legacy_approved = '" . $dbh->real_escape_string($legacyApproved) . "',
				legacy_tier = '" . $dbh->real_escape_string($legacyTier) . "',
				legacy_admin_notes = '" . $dbh->real_escape_string($legacyAdminNotes) . "'";
				
			// Update tier date if tier has changed
			if ($updateTierDate) {
				$query .= ", legacy_tier_date = NOW()";
			}
			
			$query .= " WHERE username = '" . $dbh->real_escape_string($charuser) . "'";
			
			$dbh->query($query);
		} 
		elseif ($convertToLegacy == '1' && !empty($newLegacySetting) && !empty($newLegacyHistory)) {
			// Convert to legacy character
			$conversionNote = "[" . date('Y-m-d H:i') . "] $username: Character converted to legacy character.\n\n";
			
			$query = "UPDATE users SET 
				is_legacy = 1,
				legacy_setting = '" . $dbh->real_escape_string($newLegacySetting) . "',
				legacy_history = '" . $dbh->real_escape_string($newLegacyHistory) . "',
				legacy_approved = '" . $dbh->real_escape_string($legacyApproved) . "',
				legacy_tier = 1,
				legacy_tier_date = NOW(),
				legacy_admin_notes = '" . $dbh->real_escape_string($conversionNote) . "'
				WHERE username = '" . $dbh->real_escape_string($charuser) . "'";
				
			$dbh->query($query);
		}
		
		// Success message
		echo "$charuser has been successfully updated.";
	}
	
	// Close the database connection
	$dbh->close();
} else {
	echo "You do not have permission to edit characters.";
}
?>