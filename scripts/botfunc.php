<?
function isbot($name){
	$data = false;
	$dbh=dbconnect() or die ('IsUser error: ' . mysql_error()."<br>");
	mysql_select_db("adrasis_database");
	$result = mysql_query("SELECT * FROM bots WHERE name = '$name'");
	if (mysql_num_rows($result) > 0) $data = true;
	mysql_close($dbh);
	return $data;
}
function newbot($name){
	$name = str_replace("'","&#39;",$name);
	$dbh=dbconnect() or die ('GetUser error: ' . mysql_error()."<br>");
	mysql_select_db("adrasis_database");
	$result = mysql_query("INSERT INTO bots(name) VALUES('$name')");
	mysql_close($dbh);
	return 1;
}
function getbot($name){
	$name = str_replace("'","&#39;",$name);
	$data = "";
	$dbh=dbconnect() or die ('GetUser error: ' . mysql_error()."<br>");
	mysql_select_db("adrasis_database");
	$result = mysql_query("SELECT * FROM bots WHERE name = '$name'");
	if (mysql_num_rows($result) > 0) $data = stripslashes(mysql_result($result,0,"data"));
	mysql_close($dbh);
	$data = str_replace("&#39;","'",$data);
	return $data;
}
function setbot($name,$value){
	$value = str_replace("'","&#39;",$value);
	$name = str_replace("'","&#39;",$name);
	$dbh=dbconnect() or die ('SetUser error: ' . mysql_error()."<br>");
	mysql_select_db("adrasis_database");
	$sql_query = mysql_query("UPDATE bots SET data = '$value' WHERE name = '$name'");
	mysql_close($dbh);
	return 1;
}
?>