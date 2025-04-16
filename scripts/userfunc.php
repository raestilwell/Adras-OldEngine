<?php
function users(){
	$data = array();
	$dbh = dbconnect() or die("Userlist read error: " . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM users ORDER BY username");
	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = $row['username'];
	}
	mysqli_close($dbh);
	return $data;
}

function admin($level){
	$data = "";
	$dbh = dbconnect() or die("Userlist read error: " . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM users ORDER BY username");
	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = $row['username'];
	}
	mysqli_close($dbh);
	return $data;
}

function isuser($username){
	$data = false;
	$dbh = dbconnect() or die ('IsUser error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$query = "SELECT * FROM users WHERE username = ?";
	$stmt = mysqli_prepare($dbh, $query);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0) {
		$data = true;
	}

	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	return $data;
}

function get($var) {
	global $username;
	$data = null; // Set the default value to null
	$dbh = dbconnect() or die('Get error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$query = "SELECT * FROM users WHERE username = ?";
	$stmt = mysqli_prepare($dbh, $query);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		if (isset($row[$var])) {
			$data = stripslashes($row[$var]);
		}
	}

	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function set($var, $value){
	global $username;
	$value = str_replace("'", "&#39;", $value);
	$dbh = dbconnect() or die('Set error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	
	// Escape the column name using backticks
	$var = mysqli_real_escape_string($dbh, $var);
	
	// Use regular query with escaped values instead of prepared statement for dynamic column
	$escapedValue = mysqli_real_escape_string($dbh, $value);
	$escapedUsername = mysqli_real_escape_string($dbh, $username);
	
	$query = "UPDATE users SET `$var` = '$escapedValue' WHERE username = '$escapedUsername'";
	$result = mysqli_query($dbh, $query);
	
	if (!$result) {
		die("Query failed: " . mysqli_error($dbh));
	}
	
	mysqli_close($dbh);
	return 1;
}

function coords(){
	global $username;
	$data = "";
	$dbh = dbconnect() or die('Get error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$query = "SELECT * FROM users WHERE username = ?";
	$stmt = mysqli_prepare($dbh, $query);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$data = stripslashes($row['x'] . "~" . $row['y'] . "~" . $row['z']);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function getuser($username, $var){
	$data = "";
	$dbh = dbconnect() or die('GetUser error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$query = "SELECT * FROM users WHERE username = ?";
	$stmt = mysqli_prepare($dbh, $query);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		if (isset($row[$var])) {
			$data = stripslashes($row[$var]);
		} else {
			// If the index doesn't exist or is null, set $data to an empty string or any default value you prefer
			$data = ""; // You can change this line to set a default value
		}
	}

	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function setuser($username, $var, $value){
	$value = str_replace("'", "&#39;", $value);
	$dbh = dbconnect() or die('SetUser error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	
	// Escape the column name using backticks
	$var = mysqli_real_escape_string($dbh, $var);
	
	// Use regular query with escaped values instead of prepared statement for dynamic column
	$escapedValue = mysqli_real_escape_string($dbh, $value);
	$escapedUsername = mysqli_real_escape_string($dbh, $username);
	
	$query = "UPDATE users SET `$var` = '$escapedValue' WHERE username = '$escapedUsername'";
	$result = mysqli_query($dbh, $query);
	
	if (!$result) {
		die("Query failed: " . mysqli_error($dbh));
	}
	
	mysqli_close($dbh);
	return 1;
}

function getcoords($username){
	$data = "";
	$dbh = dbconnect() or die('GetUser error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$query = "SELECT * FROM users WHERE username = ?";
	$stmt = mysqli_prepare($dbh, $query);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$data = stripslashes($row['x'] . "~" . $row['y'] . "~" . $row['z']);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function del($username){
	$clan = getuser($username, "clan");
	$mil = getuser($username, "militia");
	$guild = getuser($username, "guild");

	if ($clan != ""){
		setorg($clan, "owners", str_replace("$username:", "", getorg($clan, "owners")));
		setorg($clan, "leaders", str_replace("$username:", "", getorg($clan, "leaders")));
		setorg($clan, "officers", str_replace("$username:", "", getorg($clan, "officers")));
		setorg($clan, "members", str_replace("$username:", "", getorg($clan, "members")));
		setorg($clan, "parole", str_replace("$username:", "", getorg($clan, "parole")));
	}

	if ($mil != ""){
		setorg($mil, "owners", str_replace("$username:", "", getorg($mil, "owners")));
		setorg($mil, "leaders", str_replace("$username:", "", getorg($mil, "leaders")));
		setorg($mil, "officers", str_replace("$username:", "", getorg($mil, "officers")));
		setorg($mil, "members", str_replace("$username:", "", getorg($mil, "members")));
		setorg($mil, "parole", str_replace("$username:", "", getorg($mil, "parole")));
	}

	if ($guild != ""){
		setorg($guild, "owners", str_replace("$username:", "", getorg($guild, "owners")));
		setorg($guild, "leaders", str_replace("$username:", "", getorg($guild, "leaders")));
		setorg($guild, "officers", str_replace("$username:", "", getorg($guild, "officers")));
		setorg($guild, "members", str_replace("$username:", "", getorg($guild, "members")));
		setorg($guild, "parole", str_replace("$username:", "", getorg($guild, "parole")));
	}

	$dbh = dbconnect() or die('GetUser error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	mysqli_query($dbh, "DELETE FROM users WHERE username = '$username'");
	mysqli_query($dbh, "DELETE FROM apps WHERE username = '$username'");
	mysqli_close($dbh);
}

function numraps(){
	$dbh = dbconnect() or die('IsUser error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM rapsheet");
	$data = mysqli_num_rows($result);
	mysqli_close($dbh);
	return $data;
}
?>