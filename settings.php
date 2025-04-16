<?php
// Start with error reporting to help debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Load functions and verify user
require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");

// Process form values - your existing code here
$background = $_POST['background'] ?? '';
$color = $_POST['color'] ?? '';
$ccolor = $_POST['ccolor'] ?? '';
$ocolor = $_POST['ocolor'] ?? '';
$bcolor = $_POST['bcolor'] ?? '';
$fcolor = $_POST['fcolor'] ?? '';
$link = $_POST['link'] ?? '';
$acolor = $_POST['acolor'] ?? '';
$font = $_POST['font'] ?? '';
$fontsize = $_POST['fontsize'] ?? '';
$topframesize = $_POST['topframesize'] ?? '';
$refresh = $_POST['refresh'] ?? '';
$mapcell = $_POST['mapcell'] ?? '';
$ooc = isset($_POST['ooc']);
$chat = isset($_POST['chat']);
$map = isset($_POST['map']);
$bold = isset($_POST['bold']);
$scroll = isset($_POST['scroll']);
$unafk = isset($_POST['unafk']);
$p0 = $_POST['p0'] ?? '';
$p1 = $_POST['p1'] ?? '';
// ... other p values ...
$login = $_POST['login'] ?? '';
$logout = $_POST['logout'] ?? '';
$afk = $_POST['afk'] ?? '';

// Update settings - your existing code here
if ($ooc) set("flags", str_replace("(ooc)", "", get("flags"))); 
else set("flags", str_replace("(ooc)", "", get("flags")) . "(ooc)");

if ($chat) set("flags", str_replace("(chat)", "", get("flags"))); 
else set("flags", str_replace("(chat)", "", get("flags")) . "(chat)");

if ($map) set("flags", str_replace("(map)", "", get("flags"))); 
else set("flags", str_replace("(map)", "", get("flags")) . "(map)");

if ($unafk) set("unafk", "y"); else set("unafk", "n");

if (empty($bold)) set("flags", str_replace("(bold)", "", get("flags"))); 
else set("flags", str_replace("(bold)", "", get("flags")) . "(bold)");

if (empty($scroll)) set("flags", str_replace("(scroll)", "", get("flags"))); 
else set("flags", str_replace("(scroll)", "", get("flags")) . "(scroll)");

set("bgcolor", $background);
set("tcolor", $color);
set("ccolor", $ccolor);
set("scolor", $ocolor);
set("bcolor", $bcolor);
set("fcolor", $fcolor);
set("lcolor", $link);
set("mapcell", $mapcell);

if (!is_numeric(get("admin"))) set("acolor", $acolor);

set("refresh", $refresh);
set("font", $font);
set("size", $fontsize);
set("frame", $topframesize);
set("login", str_replace("\"", "&#34;", stripslashes($login)));
set("logout", str_replace("\"", "&#34;", stripslashes($logout)));
set("afk", str_replace("\"", "&#34;", stripslashes($afk)));

// Chat preferences
$chatpref = "";
for ($i = 0; $i < 19; $i++) {
	$var = "p$i";
	if (isset($$var) && $$var == "on") $chatpref .= "1";
	else $chatpref .= "0";
}
if ($chatpref[0] == "0") $chatpref[0] = "n";
set("chatpref", $chatpref);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Settings Updated</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		body { 
			background-color: #<?= $background ?>; 
			color: #<?= $color ?>; 
			font-family: <?= $font ?>; 
			font-size: <?= $fontsize ?>pt; 
		}
		.message {
			margin: 20px;
			padding: 20px;
			border: 1px solid #<?= $color ?>;
			border-radius: 5px;
		}
		.return-button {
			display: inline-block;
			margin-top: 15px;
			padding: 8px 16px;
			background-color: #<?= $color ?>;
			color: #<?= $background ?>;
			text-decoration: none;
			border: none;
			border-radius: 4px;
			font-weight: bold;
			cursor: pointer;
			font-family: <?= $font ?>;
			font-size: <?= $fontsize ?>pt;
		}
		.return-button:hover {
			text-decoration: underline;
		}
		.password-field {
			padding: 8px;
			margin-right: 10px;
			border-radius: 4px;
			border: 1px solid #<?= $color ?>;
			background-color: #<?= $background ?>;
			color: #<?= $color ?>;
		}
	</style>
</head>
<body>
	<div class="message">
		<h2>Settings Updated Successfully</h2>
		<p>Your background and other settings have been saved. You're seeing the new background color right now!</p>
		<p>To return to the game with your new settings, please enter your password:</p>
		
		<form id="loginForm" method="POST" action="game.php" target="_top">
			<input type="hidden" name="loginname" value="<?= $username ?>">
			<input type="password" id="passwordField" name="loginpass" class="password-field" placeholder="Enter your password">
			<button type="submit" class="return-button">Return to Game</button>
		</form>
	</div>
</body>
</html>