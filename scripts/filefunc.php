<?php
/**
 * File handling functions
 * These functions manage file data stored in the database
 */

function isfile($name) {
	$dbh = dbconnect() or die ('IsFile error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	
	// Use prepared statements for security
	$stmt = mysqli_prepare($dbh, "SELECT 1 FROM files WHERE name = ?");
	mysqli_stmt_bind_param($stmt, "s", $name);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	
	$exists = mysqli_stmt_num_rows($stmt) > 0;
	
	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	
	return $exists;
}

function getfile($name) {
	$dbh = dbconnect() or die ('GetFile error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	
	// Use prepared statements for security
	$stmt = mysqli_prepare($dbh, "SELECT info FROM files WHERE name = ?");
	mysqli_stmt_bind_param($stmt, "s", $name);
	mysqli_stmt_execute($stmt);
	
	$result = mysqli_stmt_get_result($stmt);
	
	$data = "";
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$data = stripslashes($row['info']);
	}
	
	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	
	// Replace HTML entity with actual apostrophe
	$data = str_replace("&#39;", "'", $data);
	
	return $data;
}

function setfile($name, $value) {
	// Replace apostrophes with HTML entities for storage
	$value = str_replace("'", "&#39;", $value);
	
	$dbh = dbconnect() or die ('SetFile error: ' . mysqli_connect_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	
	// Use prepared statements for security
	$stmt = mysqli_prepare($dbh, "UPDATE files SET info = ? WHERE name = ?");
	mysqli_stmt_bind_param($stmt, "ss", $value, $name);
	$result = mysqli_stmt_execute($stmt);
	
	mysqli_stmt_close($stmt);
	mysqli_close($dbh);
	
	return $result;
}

function getfdata($filename) {
	clearstatcache();
	
	if (!is_file($filename)) {
		return "";
	}
	
	// Modern approach to file reading
	try {
		return file_get_contents($filename);
	} catch (Exception $e) {
		// Fallback to the old method if file_get_contents fails
		$data = "";
		$stream = fopen($filename, 'r');
		if ($stream) {
			$data = fread($stream, filesize($filename));
			fclose($stream);
		}
		return $data;
	}
}
?>