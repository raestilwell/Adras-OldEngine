<?php
// This script examines character data before and after removing legacy status
require_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/function.php');

// Check if processing form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$admin_username = $_POST['admin_username'];
	$admin_password = $_POST['admin_password'];
	$character_name = $_POST['character_name'];
	$action = $_POST['action'] ?? '';
	
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
	
	// Get current character data
	$query = "SELECT * FROM users WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
	$result = $dbh->query($query);
	
	if (!$result || $result->num_rows == 0) {
		die("<p style='color:red'>Error: Could not retrieve character data</p>");
	}
	
	$before_data = $result->fetch_assoc();
	
	echo "<h2>Character Data Examination Tool</h2>";
	
	if ($action == 'remove_legacy') {
		echo "<h3>Removing Legacy Status</h3>";
		
		// Method 1: Use setuser() function
		setuser($character_name, "is_legacy", 0);
		setuser($character_name, "legacy_setting", NULL);
		setuser($character_name, "legacy_history", NULL);
		setuser($character_name, "legacy_approved", 0);
		setuser($character_name, "legacy_tier", NULL);
		setuser($character_name, "legacy_admin_notes", NULL);
		
		// Method 2: Use direct SQL to handle legacy_tier_date
		$query1 = "ALTER TABLE users DROP COLUMN legacy_tier_date";
		$result1 = $dbh->query($query1);
		
		$query2 = "ALTER TABLE users ADD COLUMN legacy_tier_date DATETIME NULL";
		$result2 = $dbh->query($query2);
		
		echo "<p>Legacy status removal attempt complete.</p>";
	}
	
	// Get updated character data
	$query = "SELECT * FROM users WHERE username = '" . $dbh->real_escape_string($character_name) . "'";
	$result = $dbh->query($query);
	
	if (!$result || $result->num_rows == 0) {
		die("<p style='color:red'>Error: Could not retrieve updated character data</p>");
	}
	
	$after_data = $result->fetch_assoc();
	
	// Display character information
	echo "<h3>Character Information</h3>";
	
	// Field categories for organization
	$basicFields = ['username', 'name', 'race', 'class', 'gender', 'x', 'y', 'z', 'plane', 'description'];
	$legacyFields = ['is_legacy', 'legacy_setting', 'legacy_history', 'legacy_tier', 'legacy_tier_date', 'legacy_admin_notes', 'legacy_approved'];
	$otherFields = array_diff(array_keys($before_data), array_merge($basicFields, $legacyFields));
	
	// Display basic fields
	echo "<h4>Basic Character Information</h4>";
	displayFieldComparison($before_data, $after_data, $basicFields);
	
	// Display legacy fields
	echo "<h4>Legacy Fields</h4>";
	displayFieldComparison($before_data, $after_data, $legacyFields);
	
	// Display other fields
	echo "<h4>Other Fields</h4>";
	displayFieldComparison($before_data, $after_data, $otherFields);
	
	// Add legacy removal button if character is legacy
	if ($after_data['is_legacy'] == 1) {
		echo "<h3>Legacy Status Actions</h3>";
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='admin_username' value='" . htmlspecialchars($admin_username) . "'>";
		echo "<input type='hidden' name='admin_password' value='" . htmlspecialchars($admin_password) . "'>";
		echo "<input type='hidden' name='character_name' value='" . htmlspecialchars($character_name) . "'>";
		echo "<input type='hidden' name='action' value='remove_legacy'>";
		echo "<button type='submit' style='background: #d9534f; color: white; padding: 10px 15px; border: none; cursor: pointer;'>Remove Legacy Status</button>";
		echo "</form>";
	}
	
	$dbh->close();
	
	echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
} else {
	// Display form
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Character Data Examination Tool</title>
		<style>
			body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
			h1 { color: #333; }
			label { display: block; margin-bottom: 5px; font-weight: bold; }
			input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin-bottom: 15px; }
			button { background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
			button:hover { background: #45a049; }
			.changed { background-color: #fff3cd; }
			.warning { color: #f44336; font-weight: bold; }
		</style>
	</head>
	<body>
		<h1>Character Data Examination Tool</h1>
		
		<p>This tool examines character data and can safely remove legacy status.</p>
		
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
			
			<button type="submit">Examine Character Data</button>
		</form>
	</body>
	</html>
	<?php
}

// Helper function to display field comparison
function displayFieldComparison($before, $after, $fields) {
	echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
	echo "<tr><th>Field</th><th>Before</th><th>After</th><th>Changed?</th></tr>";
	
	foreach ($fields as $field) {
		if (isset($before[$field]) || isset($after[$field])) {
			$beforeValue = isset($before[$field]) ? $before[$field] : 'N/A';
			$afterValue = isset($after[$field]) ? $after[$field] : 'N/A';
			$changed = $beforeValue !== $afterValue;
			$rowClass = $changed ? " class='changed'" : "";
			
			// Format values for display
			$beforeDisplay = (is_null($beforeValue) || $beforeValue === '') ? 'NULL' : htmlspecialchars(substr((string)$beforeValue, 0, 100));
			$afterDisplay = (is_null($afterValue) || $afterValue === '') ? 'NULL' : htmlspecialchars(substr((string)$afterValue, 0, 100));
			
			if (strlen((string)$beforeValue) > 100) $beforeDisplay .= '...';
			if (strlen((string)$afterValue) > 100) $afterDisplay .= '...';
			
			echo "<tr$rowClass>";
			echo "<td>$field</td>";
			echo "<td>$beforeDisplay</td>";
			echo "<td>$afterDisplay</td>";
			echo "<td>" . ($changed ? "<span style='color:red'>Yes</span>" : "No") . "</td>";
			echo "</tr>";
		}
	}
	
	echo "</table>";
}
?>