<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve input data from POST request
$username = $_POST['username'];
$password = $_POST['password'];
$descript = $_POST['descript'];
$title = $_POST['title'];
$alt = $_POST['alt'];
$n = $_POST['n'];
$s = $_POST['s'];
$e = $_POST['e'];
$w = $_POST['w'];
$u = $_POST['u'];
$d = $_POST['d'];
$p = $_POST['p'];
$co = $_POST['co'];
$script = $_POST['script'];
$flagdata = $_POST['flags'];
$npcdata = $_POST['editnpc'];

// Include necessary functions and scripts
require("../scripts/function.php");
require("../scripts/verify.php");
require("../scripts/style.php");

// Check if the user is an admin
if (!is_numeric(get("admin"))) {
	// If not admin, check and set level data
	if (!islevel($p, $co)) {
		newlevel($p, $co);
	}

	// Set level data for each direction and attributes
	setlevel($p, $co, "n", $n);
	setlevel($p, $co, "s", $s);
	setlevel($p, $co, "e", $e);
	setlevel($p, $co, "w", $w);
	setlevel($p, $co, "u", $u);
	setlevel($p, $co, "d", $d);
	setlevel($p, $co, "title", filter(stripslashes($title)));
	setlevel($p, $co, "description", filter(stripslashes($descript)));
	setlevel($p, $co, "alt", filter(stripslashes($alt)));
	setlevel($p, $co, "script", filter(stripslashes($script)));
	setlevel($p, $co, "flags", filter(stripslashes($flagdata)));
	setlevel($p, $co, "npcs", filter(stripslashes($npcdata)));

	// Display success message
	echo "Level edited/created.<br>\n";
}
?>
