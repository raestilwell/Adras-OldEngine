<?php
$t = date("m/d H:i");
$c = get("x") . "~" . get("y") . "~" . get("z") . " " . get("plane");
$dbh = dbconnect();
mysqli_select_db($dbh, "adras_database");
mysqli_query($dbh, "INSERT INTO alog(name,time,location,action) VALUES('$username','$t','$c','$action2')");
mysqli_close($dbh);
?>
