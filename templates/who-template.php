<?php
/**
 * Template file for Who listing
 * This defines the common layout and structure used by both public and authenticated views
 */

// Function to output the header for who listing
function outputWhoHeader($title = 'ONLINE CHARACTERS') {
	echo "<center><h2 class='cinzel-heading'>$title</h2><br>\n";
}

// Function to output column headers based on view type
function outputColumnHeaders($viewType = 'basic') {
	echo "<table class='who-table'>\n";
	echo "<tr>";
	
	// Common columns for all views
	echo "<td class='cinzel-heading'>Name</td>";
	echo "<td class='spacer'></td>";
	echo "<td class='cinzel-heading'>Minutes Idle</td>";
	
	// Additional columns based on view type
	if ($viewType == 'admin' || $viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td class='cinzel-heading'>Seconds Idle</td>";
	}
	
	echo "<td class='spacer'></td>";
	echo "<td class='cinzel-heading'>Admin Level</td>";
	
	if ($viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td class='cinzel-heading'>IP Address</td>";
	}
	
	if ($viewType == 'admin' || $viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td class='cinzel-heading'>Current Location</td>";
	}
	
	if ($viewType == 'full' || $viewType == 'admin') {
		echo "<td class='spacer'></td>";
		echo "<td class='cinzel-heading'>Legacy Tier</td>";
	}
	
	echo "</tr>\n";
}

// Function to output a single character row
function outputCharacterRow($character, $viewType = 'basic') {
	extract($character); // This extracts variables from the array
	
	echo "<tr>";
	
	// Name column - common to all views
	echo "<td>";
	
	// Add button if present
	echo $button;
	
	// Move admin crown before the name if admin
	if (!empty($adminIcon)) {
		echo $adminIcon . " ";
	}
	
	// Name with appropriate tag
	echo "<$nameTag href=\"$nameLink\" $afkAttr class='no-underline'>$displayName</$nameTag>";
	
	// Icons for special status (after name)
	echo $icons;
	
	echo "</td>";
	echo "<td class='spacer'></td>";
	
	// Idle time - common to all views
	echo "<td><center>$minutesIdle</center></td>";
	
	// Seconds idle - for admin and full views
	if ($viewType == 'admin' || $viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td><center>$secondsIdle</center></td>";
	}
	
	// Admin level - common to all views (removed icon as it's now before name)
	echo "<td class='spacer'></td>";
	echo "<td><center>$adminLevel</center></td>";
	
	// IP Address - for full view only
	if ($viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td>$ipAddress</td>";
	}
	
	// Combined location (level name + coordinates)
	if ($viewType == 'admin' || $viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td><center>";
		// Format as "Level Name | Coordinates Plane"
		if (!empty($levelTitle)) {
			echo $levelTitle . " | ";
		}
		echo $coordinates;
		echo "</center></td>";
	}
	
	// Legacy tier information for admin and full views
	if ($viewType == 'admin' || $viewType == 'full') {
		echo "<td class='spacer'></td>";
		echo "<td><center>";
		if (strpos($legacyStatus, "Yes") !== false) {
			echo $legacyTier;
		} else {
			echo "-";
		}
		echo "</center></td>";
	}
	
	echo "</tr>\n";
}

// Function to output the footer with player count
function outputWhoFooter($playerCount) {
	echo "<tr></tr>\n<tr></tr>\n<tr></tr>\n<tr></tr>\n";
	echo "<tr><td colspan='14' align='center'>There are $playerCount players online.</td></tr>\n";
	echo "</table>";
}

// Function to output login message for public view - Now just a placeholder
// The actual implementation is in the public who.php file
function outputLoginMessage() {
	// This function is kept for backward compatibility
	// but the implementation is moved to the public who.php file
}

// Add basic CSS for the who table - only the essential styles
function outputWhoStyles() {
	echo "<style>
	.who-table { border-collapse: collapse; margin: 0 auto; }
	.who-table td { padding: 3px 5px; }
	.who-table td.spacer { width: 15px; }
	.self { color: #00AAFF; }
	.friends { color: #00FF00; }
	.cinzel-heading { 
		font-family: 'Cinzel Decorative', serif;
		font-weight: normal;
		text-decoration: none;
	}
	.no-underline {
		text-decoration: none;
	}
	</style>";
}
?>