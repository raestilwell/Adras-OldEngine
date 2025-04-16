<?php
// Create a new file called override-game.php
// This file specifically targets and overrides styles in game.css

// Get user preferences with fallbacks
$bgcolor = get("bgcolor") ?: "#000000";
$tcolor = get("tcolor") ?: "#FFFFFF";
$font = get("font") ?: "Arial, sans-serif";
$size = get("size") ?: "12";
?>

<style id="game-css-override">
/* This stylesheet specifically targets classes from game.css */

/* Override utility-links styling */
ul.utility-links > li > a {
	color: <?=$tcolor?> !important;
}

ul.utility-links > li > a:hover {
	color: <?=$tcolor?> !important;
}

/* Override top-right styling */
.top-right {
	background-color: <?=$bgcolor?> !important;
}

/* Override window-alert styling */
.window-alert {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
}

.window-alert a {
	color: <?=$tcolor?> !important;
}

/* Override any other specific classes from game.css */
h1, h2, h3, h4, h5 {
	color: <?=$tcolor?> !important;
}

/* Target any potential Bootstrap elements */
.container, .container-fluid, .row, .col, main, .card, .card-body {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
}

/* Ensure all divs and paragraphs are correctly styled */
div, p, span, table, td, th {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
}

/* Handle font preferences */
body, html {
	font-family: <?=$font?> !important;
	font-size: <?=$size?>pt !important;
}

/* Extra specific selector for strikethrough issues */
html body, html main, html .p-3, html .container, html .container-fluid {
	background-color: <?=$bgcolor?> !important;
	color: <?=$tcolor?> !important;
}
</style>