<?
function levels($world){
	$data = array();
	$dbh = dbconnect() or die ("Userlist read error: " . mysqli_error($dbh) . "<br>");
	$result = mysqli_query($dbh, "SELECT * FROM levels WHERE world = '$world' ORDER BY coords");
	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = $row['coords'];
	}
	mysqli_close($dbh);
	return $data;
}

function islevel($world, $coords){
	$data = false;
	$dbh = dbconnect() or die ('IsUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM levels WHERE coords = '$coords' AND world = '$world'");
	if (mysqli_num_rows($result) > 0) {
		$data = true;
	}
	mysqli_close($dbh);
	return $data;
}

function getlevel($world, $coords, $var){
	$data = "";
	$dbh = dbconnect() or die ('GetUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM levels WHERE coords = '$coords' AND world = '$world'");
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$data = stripslashes($row[$var]);
	}
	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function setlevel($world, $coords, $var, $value){
	$value = str_replace("'", "&#39;", $value);
	$dbh = dbconnect() or die ('SetUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	if (is_numeric($value)) {
		mysqli_query($dbh, "UPDATE levels SET $var = $value WHERE coords = '$coords' AND world = '$world'");
	} else {
		mysqli_query($dbh, "UPDATE levels SET $var = '$value' WHERE coords = '$coords' AND world = '$world'");
	}
	mysqli_close($dbh);
	return 1;
}

function newlevel($world, $coords){
	$dbh = dbconnect() or die ('SetUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	mysqli_query($dbh, "INSERT INTO levels (world,coords) VALUES('$world', '$coords')");
	mysqli_close($dbh);
	return 1;
}

function dellevel($world, $coords){
	$dbh = dbconnect() or die ('SetUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	mysqli_query($dbh, "DELETE FROM levels WHERE world = '$world' AND coords = '$coords'");
	mysqli_close($dbh);
	return 1;
}

?>