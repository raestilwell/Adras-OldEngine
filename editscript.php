<?
$username = $_POST['username'];
$password = $_POST['password'];
$dat = $_POST['dat'];

require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
if (!is_numeric(get("admin"))){
	setlevel(get("plane"),coords(),"script",$dat);
	echo "Script edited.<br>\n";
}
?>