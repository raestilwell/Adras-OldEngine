<?php
if (strtolower($action3[0]) === "editlevel") {
	$command = 1;

	// Set default values for coords ($c) and plane ($p)
	$c = isset($action3[1]) ? $action3[1] : coords();
	$p = isset($action3[2]) ? $action3[2] : get("plane");

	// Retrieve level data
	$script = getlevel($p, $c, "script");
	$flagdata = getlevel($p, $c, "flags");
	$npcdata = getlevel($p, $c, "npcs");

	// Parse coordinates
	$coords = explode("~", $c);
	list($x, $y, $z) = $coords;

	// Check if the level exists
	if (islevel($p, $c)) {
		// Retrieve level details
		$n = getlevel($p, $c, "n");
		$s = getlevel($p, $c, "s");
		$e = getlevel($p, $c, "e");
		$w = getlevel($p, $c, "w");
		$u = getlevel($p, $c, "u");
		$d = getlevel($p, $c, "d");
		$title = stripslashes(getlevel($p, $c, "title"));
		$descript = stripslashes(getlevel($p, $c, "description"));
		$alt = stripslashes(getlevel($p, $c, "alt"));
		$no = 0;
	} else {
		// Set default values if the level doesn't exist
		$n = $s = $e = $w = $u = $d = 0;
		$title = $descript = $alt = "";
		$no = 1;
	}

	// Include external script
	require("scripts/levelgen.php");
}
?>
