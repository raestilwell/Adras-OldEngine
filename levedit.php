<?php
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

require("functions/functions.php");
require("scripts/verify.php");
require("scripts/style.php");

if (!is_numeric(get("admin"))) {
  if (!islevel($p, $co))
    newlevel($p, $co);
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
  echo "Level edited/created.<br>\n";
}
?>
