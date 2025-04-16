<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$action = $_POST['action'] ?? '';
$e = isset($_POST['e']) ? $_POST['e'] : '';

// Other attribute fields with default empty values

$race = isset($_POST['race']) ? $_POST['race'] : (isset($_POST['original_race']) ? $_POST['original_race'] : '');
$class = isset($_POST['class']) ? $_POST['class'] : (isset($_POST['original_class']) ? $_POST['original_class'] : '');
$gender = $_POST['gender'] ?? '';
$home = $_POST['home'] ?? '';
$pet = $_POST['pet'] ?? '';

$head = $_POST['head'] ?? '';
$ears = $_POST['ears'] ?? '';
$neck = $_POST['neck'] ?? '';
$body = $_POST['body'] ?? '';
$rarm = $_POST['rarm'] ?? '';
$larm = $_POST['larm'] ?? '';
$wrists = $_POST['wrists'] ?? '';
$hands = $_POST['hands'] ?? '';
$fingers = $_POST['fingers'] ?? '';
$legs = $_POST['legs'] ?? '';
$feet = $_POST['feet'] ?? '';
$weapon = isset($_POST['weapon']) ? $_POST['weapon'] : (isset($_POST['original_weapon']) ? $_POST['original_weapon'] : '');


$eyes = $_POST['eyes'] ?? '';
$hair = $_POST['hair'] ?? '';
$skin = $_POST['skin'] ?? '';
$height = $_POST['height'] ?? '';
$build = $_POST['build'] ?? '';


require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");

// Sanitize and filter the action input
if (get("fame") >= 25 || strpos(get("flags"), "(dimage)") !== false) {
	$action = afilter($action);
} else {
	$action = filter($action);
}

$f = str_replace("(equip)", "", get("flags"));
if (isset($e) && $e == "on") {
	set("flags", "$f(equip)");
} else {
	set("flags", $f);
}

// Update user attributes even if empty or deliberately set as empty

set("race", $race);
set("class", $class);
set("gender", $gender);
set("hometown", $home ?? '');
set("pet", $pet ?? '');

set("description", trim(html_entity_decode($action)) ?? '');
set("head", $head ?? '');
set("ears", $ears ?? '');
set("neck", $neck ?? '');
set("body", $body ?? '');
set("rarm", $rarm ?? '');
set("larm", $larm ?? '');
set("wrists", $wrists ?? '');
set("hands", $hands ?? '');
set("fingers", $fingers ?? '');
set("legs", $legs ?? '');
set("feet", $feet ?? '');
set("weapon", $weapon ?? '');

set("eyes", $eyes ?? '');
set("hair", $hair ?? '');
set("skin", $skin ?? '');
set("height", $height ?? '');
set("build", $build ?? '');

echo "Description updated.<br>\n";
?>
