<?
$username = $_POST['username'];
$password = $_POST['password'];

$action = $_POST['action'];

require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
if (getlevel(get("plane"),coords(),"board") == "") echo "There is no bulletin board here.<br>\n"; else{
	$action = filter($action);
	$data = explode(":~:",getlevel(get("plane"),coords(),"board"));
	$size = count($data);
	$message = stripslashes(nl2br($action));
	$thetime = date("l, F jS, Y - g:i A") . " MST";
	$thisdata = explode(":::",$data[$data[0]]);
	$thisdata[0] = get("name");
	$thisdata[1] = $thetime;
	$thisdata[2] = $message;
	$thisdata = implode(":::",$thisdata);
	$data[$data[0]] = $thisdata;
	$data[0]++;
	if ($data[0] > $size) $data[0] = 1;
	$data = implode(":~:",$data);
	setlevel(get("plane"),coords(),"board",$data);
	echo "Message posted.<br>\n";
}
?>