<?php
function dbconnect(){
	$host = "localhost";
	$username = "adras";
	$password = "2US4u5vG7e";
	$dbname = "adras_database";

	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch(PDOException $e) {
		// Handle connection errors gracefully
		// You can log the error or display an error message
		// For example:
		// echo "Connection failed: " . $e->getMessage();
		return null;
	}
}
?>