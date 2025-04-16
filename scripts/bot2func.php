<?
function isbot2($name){
	$data = false;
	$dbh=dbconnect();
	mysql_select_db("adrasis_database");
	$result = mysql_query("SELECT * FROM bots2 WHERE name = '$name'");
	if (mysql_num_rows($result) > 0) $data = true;
	mysql_close($dbh);
	return $data;
}
function isbot2here($name){
	$data = false;
	$x=get("x");
	$y=get("y");
	$z=get("z");
	$p=get("plane");
	$dbh=dbconnect();
	mysql_select_db("adrasis_database");
	$result = mysql_query("SELECT * FROM bots2 WHERE name = '$name' AND x = '$x' AND y = '$y' AND z = '$z' AND p = '$p'");
	if (mysql_num_rows($result) > 0) $data = true;
	mysql_close($dbh);
	return $data;
}
function newbot2($name,$x,$y,$z,$p){
	$name = str_replace("'","&#39;",$name);
	$dbh=dbconnect();
	mysql_select_db("adrasis_database");
	$result = mysql_query("INSERT INTO bots2(name,x,y,z,p) VALUES('$name','$x','$y','$z','$p')");
	mysql_close($dbh);
	return 1;
}
function getbot2($name){
	$a = null;
	$dbs = dbconnect();
	mysql_select_db("adrasis_database");
	$q=mysql_query("SELECT * FROM bots2 WHERE name = '$name'");
	$a=mysql_fetch_row($q);
	mysql_close($dbs);
	return $a;
}
function setbot2($name,$x,$y,$z,$p,$data,$auto){
	$data = stripslashes(str_replace("'","&#39;",$data));
	$dbh=dbconnect();
	mysql_select_db("adrasis_database");
	$sql_query = mysql_query("UPDATE bots2 SET x = '$x', y = '$y', z = '$z', p = '$p', data = '$data', auto = '$auto' WHERE name = '$name'");
	mysql_close($dbh);
	return 1;
}
function delbot2($name){
	$dbh=dbconnect();
	mysql_select_db("adrasis_database");
	mysql_query("DELETE FROM bots2 WHERE name = '$name'");
	mysql_close($dbh);
	return 1;
}
?>