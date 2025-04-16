<?
$username = $_POST['username'];
$password = $_POST['password'];
$dat = $_POST['dat'];

require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
setfile("login",$dat);
echo "File edited.<br>\n";
?>