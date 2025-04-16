<?
if (empty($username)) die("You are not logged in.<br>\n");
if (!isuser($username)) die("That user does not exist.<br>\n");
if (md5($password) != get("password")) die("Incorrect password.<br>\n");
$dsohi = get("admin");
if (getfile("lockout") != "" && get("admin") !== "X" && $dsohi[0] != "&") die("The admins are working on something or other. Or should be. Anyway, come back later.<br>\n");
?>