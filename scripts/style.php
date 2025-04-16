<?php
// First, check if we have a bgcolor value
$bg_color = get("bgcolor");
if (empty($bg_color)) {
	$bg_color = "#000000"; // Default to black if no value
}

$text_color = get("tcolor");
if (empty($text_color)) {
	$text_color = "#FFFFFF"; // Default to white if no value
}

// Get current timestamp to prevent caching
$timestamp = time();
?>
<style>
/* Custom styles - updated: <?=$timestamp?> */
body, html {
	background-color: <?=$bg_color?> !important;
	color: <?=$text_color?> !important;
	font-weight: bold;
	font-family: <?=get("font")?>;
	font-size: <?=get("size")?>pt;
}
/* Reset Bootstrap container styles */
.container, .container-fluid, main, .p-3, div, p, span {
	background-color: <?=$bg_color?> !important;
	color: <?=$text_color?> !important;
}
/* Rest of your existing styles */
b { color: <?=get("bcolor")?>; }
a:link { color: <?=get("lcolor")?>; text-decoration: none; }
a:hover { color: <?=get("tcolor")?>; text-decoration: underline; }
a:active { color: <?=get("tcolor")?>; }
a:visited { color: <?=get("lcolor")?>; }
.friends { color: <?=get("fcolor")?>; }
.self { color: <?=get("scolor")?>; }
.achat { color: <?=get("acolor")?>; }
.button {
	border: 0;
	padding: 0;
	background-color: <?=get("bgcolor")?>;
	color: <?=get("bcolor")?>;
}
.mapcell {
	width: <?=get("mapcell")?>;
	height: <?=get("mapcell")?>;
	background-color: white;
	border-style: solid;
	border-width: 0;
	border-color: #000;
}
div#tchat { margin: 0px 20px 0px 20px; display: none; position: absolute; top: 0%; right: 0; }
div#tmail { margin: 0px 20px 0px 20px; display: none; position: absolute; top: 5%; right: 0; }
div#bchat { margin: 0px 20px 0px 20px; display: none; position: absolute; bottom: 0%; right: 0; }
div#bmail { margin: 0px 20px 0px 20px; display: none; position: absolute; bottom: 5%; right: 0; }
</style>