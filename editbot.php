<?
$username = $_POST['username'];
$password = $_POST['password'];
$botname = $_POST['botname'];
$dat = $_POST['dat'];

require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
if (is_numeric(get("admin"))) echo "Foo'.<br>\n"; else{
	if (!isbot($botname)) newbot($botname);
	setbot($botname,$dat);
	echo "Bot edited.<br>\n";
}
?>