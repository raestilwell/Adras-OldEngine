<?php
// This is a standalone script for safely removing legacy status from a character
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/function.php');

// Check if processing form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
	$admin_username = $_POST['admin_username'];
	$admin_password = $_POST['admin_password'];
	$character_name = $_POST['character_name'];
	
	// Validate admin credentials
	if (!isuser($admin_username)) {
		die("<p style='color:red'>Error: Admin username not found</p>");
	}
	
	if (md5(md5($admin_password)) != getuser($admin_username, "password")) {
		die("<p style='color:red'>Error: Invalid admin password</p>");
	}
	
	$admin_level = getuser($admin_username, "admin");
	if (is_numeric($admin_level)) {
		die("<p style='color:red'>Error: User does not have admin privileges</p>");
	}
	
	// Validate character exists
	if (!isuser($character_name)) {
		die("<p style='color:red'>Error: Character not found</p>");
	}
	
	// Get database connection
	$dbh = dbconnect();
	
	if (!$dbh) {
		die("<p style='color:red'>Error: Could not connect to database</p>");
	}
	
	// Ensure database is selected
	if (!$dbh->select_db("adras_database")) {
		die("<p style='color:red'>Error: Could not select database: " . $dbh->error . "</p>");
	}
	
	// Store current character data for verification
	$query = "SELECT * FROM users WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
	$result = $dbh->query($query);
	
	if (!$result || $result->num_rows == 0) {
		die("<p style='color:red'>Error: Could not retrieve character data</p>");
	}
	
	$before_data = $result->fetch_assoc();
	
	echo "<h2>Safely Removing Legacy Status</h2>";
	
	// FIXED: Use NULL for legacy_tier_date to properly clear it
	$query = "UPDATE users SET 
		is_legacy = 0,
		legacy_setting = NULL,
		legacy_history = NULL,
		legacy_approved = 0,
		legacy_tier = NULL,
		legacy_tier_date = NULL,
		legacy_admin_notes = NULL
		WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
		
	echo "<p>Executing query: " . htmlspecialchars($query) . "</p>";
	
	$result = $dbh->query($query);
	
	if (!$result) {
		echo "<p style='color:red'>Error: " . $dbh->error . "</p>";
	} else {
		echo "<p style='color:green'>Legacy status successfully removed!</p>";
		
		// Add another query specifically for legacy_tier_date if needed
		$query2 = "UPDATE users SET legacy_tier_date = NULL WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
		echo "<p>Executing additional query: " . htmlspecialchars($query2) . "</p>";
		$result2 = $dbh->query($query2);
		
		if (!$result2) {
			echo "<p style='color:red'>Error clearing legacy_tier_date: " . $dbh->error . "</p>";
		} else {
			echo "<p style='color:green'>Additional legacy_tier_date clearing successful!</p>";
		}
	}
	
	// Verify character data after removal
	$query = "SELECT * FROM users WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
	$result = $dbh->query($query);
	
	if (!$result || $result->num_rows == 0) {
		echo "<p style='color:red'>Error: Could not retrieve updated character data</p>";
	} else {
		$after_data = $result->fetch_assoc();
		
		echo "<h3>Verification</h3>";
		
		// Check if important character fields were preserved
		$critical_fields = ['name', 'race', 'class', 'gender', 'x', 'y', 'z', 'plane'];
		$all_preserved = true;
		
		echo "<table border='1' cellpadding='5'>";
		echo "<tr><th>Field</th><th>Before</th><th>After</th><th>Preserved?</th></tr>";
		
		foreach ($critical_fields as $field) {
			$preserved = $before_data[$field] === $after_data[$field];
			if (!$preserved) $all_preserved = false;
			
			echo "<tr>";
			echo "<td>$field</td>";
			echo "<td>" . htmlspecialchars($before_data[$field]) . "</td>";
			echo "<td>" . htmlspecialchars($after_data[$field]) . "</td>";
			echo "<td>" . ($preserved ? "<span style='color:green'>Yes</span>" : "<span style='color:red'>No</span>") . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		if ($all_preserved) {
			echo "<p style='color:green'>All critical character data was preserved.</p>";
		} else {
			echo "<p style='color:red'>Warning: Some character data was not preserved!</p>";
		}
		
		// Verify legacy fields were cleared
		$legacy_fields = ['is_legacy', 'legacy_setting', 'legacy_history', 'legacy_approved', 'legacy_tier', 'legacy_tier_date', 'legacy_admin_notes'];
		$all_cleared = true;
		
		echo "<h4>Legacy Fields</h4>";
		echo "<table border='1' cellpadding='5'>";
		echo "<tr><th>Field</th><th>Before</th><th>After</th><th>Cleared?</th></tr>";
		
		foreach ($legacy_fields as $field) {
			$cleared = empty($after_data[$field]) || $after_data[$field] === '0' || $after_data[$field] === NULL;
			if (!$cleared) $all_cleared = false;
			
			echo "<tr>";
			echo "<td>$field</td>";
			echo "<td>" . htmlspecialchars(substr($before_data[$field] ?? '', 0, 50)) . "</td>";
			echo "<td>" . htmlspecialchars(substr($after_data[$field] ?? '', 0, 50)) . "</td>";
			echo "<td>" . ($cleared ? "<span style='color:green'>Yes</span>" : "<span style='color:red'>No</span>") . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		if ($all_cleared) {
			echo "<p style='color:green'>All legacy fields were successfully cleared.</p>";
		} else {
			echo "<p style='color:red'>Warning: Some legacy fields were not cleared!</p>";
			
			// Fix for legacy_tier_date if still not cleared
			if (!empty($after_data['legacy_tier_date'])) {
				echo "<h4>Attempting Final Fix for legacy_tier_date</h4>";
				
				// Try a direct SQL fix with a stronger NULL method
				$final_fix = "UPDATE users SET legacy_tier_date = NULL WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
				$final_result = $dbh->query($final_fix);
				
				if (!$final_result) {
					echo "<p style='color:red'>Final fix failed: " . $dbh->error . "</p>";
				} else {
					echo "<p style='color:green'>Final fix executed. Please refresh to check if successful.</p>";
				}
			}
		}
	}
	
	$dbh->close();
	
	echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
} else {
	// Display form
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Safe Legacy Removal</title>
		<style>
			body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
			h1 { color: #333; }
			label { display: block; margin-bottom: 5px; font-weight: bold; }
			input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin-bottom: 15px; }
			button { background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
			button:hover { background: #45a049; }
			.warning { color: #f44336; font-weight: bold; }
		</style>
	</head>
	<body>
		<h1>Safe Legacy Character Status Removal</h1>
		
		<p>This tool safely removes legacy status from a character without affecting other character data.</p>
		<p class="warning">WARNING: This action will remove all legacy-related information from the character. This cannot be undone.</p>
		
		<form method="post" action="">
			<h2>Admin Authentication</h2>
			<div>
				<label for="admin_username">Admin Username:</label>
				<input type="text" id="admin_username" name="admin_username" required>
			</div>
			
			<div>
				<label for="admin_password">Admin Password:</label>
				<input type="password" id="admin_password" name="admin_password" required>
			</div>
			
			<h2>Character Selection</h2>
			<div>
				<label for="character_name">Character Name:</label>
				<input type="text" id="character_name" name="character_name" required>
			</div>
			
			<button type="submit" name="remove" value="1">Remove Legacy Status</button>
		</form>
	</body>
	</html>
	<?php
}
?>