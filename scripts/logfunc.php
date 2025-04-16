<?php

function logsize() {
	$dbh = dbconnect() or die('Database connection error');

	$result = $dbh->query("SELECT * FROM giantlog");
	$data = $result->num_rows;

	$dbh->close();
	return $data;
}

function getlog() {
	$data = "";
	$dbh = dbconnect() or die('Database connection error');

	$result = $dbh->query("SELECT * FROM giantlog ORDER BY num");
	while ($row = $result->fetch_assoc()) {
		$data .= $row["data"] . "<br>";
	}

	$dbh->close();
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function searchlog($key) {
	$data = "";
	$key = str_replace("'", "&#39;", $key);
	$key = str_replace("&#58;", ":", $key);

	$dbh = dbconnect() or die('Database connection error');

	$result = $dbh->query("SELECT * FROM giantlog WHERE data LIKE '%$key%' ORDER BY num");
	while ($row = $result->fetch_assoc()) {
		$data .= $row["data"];
	}

	$dbh->close();
	return $data;
}

function addlog($new) {
	$num = logsize();
	$new = str_replace("'", "&#39;", $new);
	$new = explode("<br>", $new);

	$dbh = dbconnect() or die('Database connection error');

	for ($i = 0; $i < count($new); $i++) {
		$dbh->query("INSERT INTO giantlog(num, data) VALUES(" . ($num + $i) . ", '" . $dbh->real_escape_string($new[$i]) . "<br>')");
	}

	$dbh->close();
	return 1;
}
?>
