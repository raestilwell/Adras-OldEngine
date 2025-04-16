<?php
// Initialize variables
$loginname = $_POST['loginname'] ?? '';
$loginpass = $_POST['loginpass'] ?? '';

// Load functions
require("scripts/function.php");

$loginname = ucwords(strtolower($loginname));

// Basic validation
if ($loginname == "") {
	die("You didn't enter your username. Please go back and do so, or create a new character <a href=\"index.php?page=register\">here</a>.<br>\n");
}

if (!isuser($loginname)) {
	die("That username does not exist. To create it, click <a href='https://adrastium.com/character-registration/'>here</a>.<br>");
}

$username = $loginname;
$encrypted = md5($loginpass);

if (get("password") !== md5(md5($loginpass))) {
	die("Incorrect password.<br>\n");
}

// Get ALL style parameters
$bgcolor = get("bgcolor");
$tcolor = get("tcolor");
$font = get("font");
$size = get("size");
$bcolor = get("bcolor");
$lcolor = get("lcolor");
$fcolor = get("fcolor");
$scolor = get("scolor");
$acolor = get("acolor");
$mapcell = get("mapcell");

// Create a style parameter string to pass to frames
$style_params = "&bgcolor=" . urlencode($bgcolor) 
	. "&tcolor=" . urlencode($tcolor)
	. "&font=" . urlencode($font)
	. "&size=" . urlencode($size)
	. "&bcolor=" . urlencode($bcolor)
	. "&lcolor=" . urlencode($lcolor)
	. "&fcolor=" . urlencode($fcolor)
	. "&scolor=" . urlencode($scolor)
	. "&acolor=" . urlencode($acolor)
	. "&mapcell=" . urlencode($mapcell);

// Add user to online list
addlogin($loginname, $loginpass, $_SERVER['REMOTE_ADDR']);

if (!is_numeric(get("admin"))) {
	$timelog = getfile("timelog");
	$timelog .= "$loginname:in:" . time() . "\n";
	setfile("timelog", $timelog);
}

$asdf = 0;
$charsdata = getfile("online");

if (strpos($charsdata, "$loginname:") !== false) {
	$asdf = 1;
}

$charsdata = str_replace("$loginname:", "", $charsdata) . "$loginname:";
setfile("online", $charsdata);

$framesize = get("frame");
$encrypted = md5($loginpass);

// Output HTML with proper styling
echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>$loginname | Adrastium: Realms Reborn</title>\n";
echo "<style>\n";
echo "body, html, frameset { background-color: $bgcolor !important; }\n";
echo "</style>\n";
echo "</head>\n";

// Create frameset
echo "<frameset rows=\"$framesize%,*,0\" border=0 style=\"background-color: $bgcolor !important;\">\n";

// TOP frame with all style parameters
echo "<frame name=\"TOP\" ";
if ($asdf == 1) {
	echo "src=\"main.php?username=$loginname&password=$encrypted$style_params\"";
} else {
	echo "src=\"main.php?username=$loginname&password=$encrypted&isloggingin=1$style_params\"";
}
echo " style=\"background-color: $bgcolor !important;\" noresize>\n";

// BOTTOM frame with all style parameters
echo "<frame name=\"BOTTOM\" src=\"command.php?x=$loginname&y=$encrypted$style_params\" style=\"background-color: $bgcolor !important;\" noresize scrolling=no>\n";

// CHECKER frame
echo "<frame name=\"CHECKER\" src=\"chatchek.php?username=$loginname&password=$encrypted$style_params\" noresize>\n";

echo "</frameset>\n";
set("lasttell", "");
echo "</html>\n";
?>