<?
require("scripts/function.php");require("scripts/verify.php");
if (strpos(get("flags"),"(bold)") === false) echo "<p style=font-weight:normal;>\n";
echo get("chat");
?>
