<?php
function dbconnect(){
	$mysqli = new mysqli("localhost", "adras", "2US4u5vG7e", "adras_database");
	if ($mysqli->connect_error) {
		die("Connection failed: " . $mysqli->connect_error);
	}
	return $mysqli;
}
?>
