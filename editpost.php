<?
$username = $_POST['username'];
$password = $_POST['password'];
$action = $_POST['action'];
$num = $_POST['num'];
require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
if (getlevel(get("plane"),coords(),"board") == "" && (get("admin") == "&#9829;" || get("admin") == "X")) echo "There is no bulletin board here.<br>\n"; else{
	$data = explode(":~:",getlevel(get("plane"),coords(),"board"));
	$dat = explode(":::",$data[$num]);
	$dat[2] = stripslashes(nl2br($action));
	$dat = implode(":::",$dat);
	$data[$num] = $dat;
	$data = implode(":~:",$data);
	setlevel(get("plane"),coords(),"board",$data);
	echo "Message edited.<br>\n";
}
?>