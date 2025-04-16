<?php
// Save this as dynamic-game-css.php
// This file generates a custom version of game.css with the user's colors

// Get the required user preferences
$bgcolor = get("bgcolor") ?: "#000000";
$tcolor = get("tcolor") ?: "#FFFFFF";

// Set the content type to CSS
header("Content-Type: text/css");

// Get the CSS template
$css = file_get_contents("assets/css/game-custom.css");

// Replace the placeholders with actual values
$css = str_replace("/*BG_COLOR*/", $bgcolor, $css);
$css = str_replace("/*TEXT_COLOR*/", $tcolor, $css);

// Output the CSS
echo $css;
?>