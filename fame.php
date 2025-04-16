<?
require("scripts/function.php");
if ($x == "lskdsdlkfk" && isset($y)){
	$users = users();
	for ($i = 0; $i < count($users); $i++) setuser($users[$i],"fame",getuser($users[$i],"fame")+$y);
	echo "Yeah. That shoulda worked.<br>\n";
}else echo "Meh."
?>