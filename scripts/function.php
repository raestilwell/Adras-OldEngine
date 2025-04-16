<?php
// Check if the file has already been included
if (!defined('FUNCTION_PHP_INCLUDED')) {
	// Set a flag to indicate this file has been included
	define('FUNCTION_PHP_INCLUDED', true);
	
	// Updated dependencies with proper PHP extensions
	require_once("botfunc.php");
	require_once("filefunc.php");
	require_once("levfunc.php");
	require_once("logfunc.php");
	require_once("/home/adras/public_html/functions/orgFunc.php");
	require_once("userfunc.php");
	require_once("filtfunc.php");
	require_once("bot2func.php");
	require_once("dbfunc.php");
	
	// Only define functions if they don't already exist
	if (!function_exists('newapp')) {
		function newapp($x)
		{
			$dbs = dbconnect();
			// Using mysqli instead of deprecated mysql functions
			mysqli_select_db($dbs, "adras_database");
			
			// Using prepared statements for security
			$stmt = mysqli_prepare($dbs, "INSERT INTO apps(username) VALUES(?)");
			mysqli_stmt_bind_param($stmt, "s", $x);
			$result = mysqli_stmt_execute($stmt);
			
			mysqli_close($dbs);
			return $result;
		}
	}
	
	if (!function_exists('isapp')) {
		function isapp($x)
		{
			$dbs = dbconnect();
			mysqli_select_db($dbs, "adras_database");
			
			// Using prepared statements for security
			$stmt = mysqli_prepare($dbs, "SELECT * FROM apps WHERE username = ?");
			mysqli_stmt_bind_param($stmt, "s", $x);
			mysqli_stmt_execute($stmt);
			
			mysqli_stmt_store_result($stmt);
			$count = mysqli_stmt_num_rows($stmt);
			
			mysqli_stmt_close($stmt);
			mysqli_close($dbs);
			
			return $count;
		}
	}
	
	if (!function_exists('getapp')) {
		function getapp($x)
		{
			$dbs = dbconnect();
			mysqli_select_db($dbs, "adras_database");
			
			// Using prepared statements for security
			$stmt = mysqli_prepare($dbs, "SELECT * FROM apps WHERE username = ?");
			mysqli_stmt_bind_param($stmt, "s", $x);
			mysqli_stmt_execute($stmt);
			
			$result = mysqli_stmt_get_result($stmt);
			$app = mysqli_fetch_assoc($result);
			
			mysqli_stmt_close($stmt);
			mysqli_close($dbs);
			
			return $app;
		}
	}
	
	if (!function_exists('setapp')) {
		function setapp($x, $var, $val)
		{
			$dbs = dbconnect();
			mysqli_select_db($dbs, "adras_database");
			
			// Building the query dynamically but safely
			// Note: This requires $var to be a valid column name
			$query = "UPDATE apps SET " . $var . " = ? WHERE username = ?";
			$stmt = mysqli_prepare($dbs, $query);
			mysqli_stmt_bind_param($stmt, "ss", $val, $x);
			$result = mysqli_stmt_execute($stmt);
			
			mysqli_stmt_close($stmt);
			mysqli_close($dbs);
			
			return $result;
		}
	}
	
	if (!function_exists('apps')) {
		function apps($x)
		{
			$where = "";
			if ($x) {
				$where = " WHERE $x = 'o'";
			}
			
			$dbs = dbconnect();
			mysqli_select_db($dbs, "adras_database");
			
			$query = "SELECT username FROM apps" . $where . " ORDER BY username";
			$result = mysqli_query($dbs, $query);
			
			$d = [];
			if ($result) {
				while ($row = mysqli_fetch_row($result)) {
					$d[] = $row[0];
				}
				mysqli_free_result($result);
			} else {
				mysqli_close($dbs);
				return [];
			}
			
			mysqli_close($dbs);
			return $d;
		}
	}
	
	if (!function_exists('addlogin')) {
		function addlogin($x, $y, $z)
		{
			$mysqli = dbconnect();
			
			// Hash the password
			$hashedPassword = password_hash($y, PASSWORD_DEFAULT);
			
			$query = "INSERT INTO logins (username, password, ip) VALUES (?, ?, ?)";
			$stmt = $mysqli->prepare($query);
			
			// Bind parameters and execute the statement
			$stmt->bind_param("sss", $x, $hashedPassword, $z);
			$result = $stmt->execute();
			
			// Close the statement and connection
			$stmt->close();
			$mysqli->close();
			
			return $result;
		}
	}
	
	if (!function_exists('getlogins')) {
		function getlogins()
		{
			$y = "";
			if (func_num_args() == 1) {
				$y = " WHERE username = '" . func_get_arg(0) . "'";
			} elseif (func_num_args() == 2) {
				$y = " WHERE ip = '" . func_get_arg(1) . "'";
			}
			
			$a = [];
			
			$dbs = dbconnect();
			
			$db_selected = mysqli_select_db($dbs, "adras_database");
			
			if (!$db_selected) {
				die("Cannot select database: " . mysqli_error($dbs));
			}
			
			$q = mysqli_query($dbs, "SELECT * FROM logins" . $y);
			
			if (!$q) {
				die("Query failed: " . mysqli_error($dbs));
			}
			
			$x = mysqli_num_rows($q);
			
			for ($i = 0; $i < $x; $i++) {
				$a[$i] = mysqli_fetch_row($q);
			}
			
			mysqli_close($dbs);
			
			return $a;
		}
	}
	
	// Add this new function with the function_exists check
	if (!function_exists('getPasswordHash')) {
		function getPasswordHash($username)
		{
			$dbh = dbconnect();
			
			// Using prepared statements for security
			$stmt = mysqli_prepare($dbh, "SELECT password FROM users WHERE username = ?");
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			
			mysqli_stmt_store_result($stmt);
			
			if (mysqli_stmt_num_rows($stmt) > 0) {
				mysqli_stmt_bind_result($stmt, $storedPasswordHash);
				mysqli_stmt_fetch($stmt);
				
				mysqli_stmt_close($stmt);
				mysqli_close($dbh);
				
				return $storedPasswordHash;
			} else {
				mysqli_stmt_close($stmt);
				mysqli_close($dbh);
				
				return null; // Return null if username not found
			}
		}
	}
}
?>