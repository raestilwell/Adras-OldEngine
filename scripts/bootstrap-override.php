<?php
// Get user preferences
$bgcolor = get("bgcolor");
$tcolor = get("tcolor");
$font = get("font");
$size = get("size");

// Default values if empty
if (empty($bgcolor)) $bgcolor = "#000000";
if (empty($tcolor)) $tcolor = "#FFFFFF";
if (empty($font)) $font = "Arial, sans-serif";
if (empty($size)) $size = "12";
?>
<style id="bootstrap-override">
/* This stylesheet will forcefully override Bootstrap */

/* Target Bootstrap's body and html */
html, 
body,
body.bg-light,
body.bg-white,
body.bg-dark {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
}

/* Target all containers and content areas */
.container, 
.container-fluid, 
.row, 
.col, 
.card, 
.p-3, 
main, 
section, 
article, 
aside, 
div {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
}

/* Target main content area */
main.p-3 {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
	font-family: <?=$font?> !important;
	font-size: <?=$size?>pt !important;
}

/* Override any text colors */
p, span, h1, h2, h3, h4, h5, h6, td, th, li {
	color: <?=$tcolor?> !important;
}

/* Ensure this stylesheet has the highest priority */
</style>