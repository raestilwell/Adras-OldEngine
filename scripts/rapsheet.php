<?
function setrap($offender,$offense,$act,$date,$username){
	$value = str_replace("'","$#39;",$data);
	$dbh = dbconnect() or die ('Set Rapsheet error: ' . mysql_error(). "<br>");
	mysql_select_db("adrasis_database");
	$sql_query = mysql_query("INSERT INTO rapsheet (rapID,offender,offense,action,date,admin) VALUES (null,'$offender','$offense','$act','$date','$username')") or die(mysql_error());
	mysql_close($dbh);
	return 1;

	echo "Rapsheet has been updated successfully.";
	}
function rap($num,$val)
	{
	$data = "";
	$dbh=dbconnect() or die ('GetUser error: ' . mysql_error()."<br>");
	mysql_select_db("adrasis_database");
	$result = mysql_query("SELECT $val FROM rapsheet WHERE rapID = '$num'");
	if (mysql_num_rows($result) > 0)
	{
		$data = stripslashes(mysql_result($result,0,$val));
	}
	mysql_close($dbh);
	$data = str_replace("&#39;","'",$data);
	return $data;
	}
?>