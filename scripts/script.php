<?php
/**
 * Enhanced E-Script with state management using the user table
 * This approach stores states in a 'script_states' column in your existing user table
 */

/**
 * First, you'll need to add the script_states column to your user table
 * You can run this SQL query manually:
 * 
 * ALTER TABLE users ADD COLUMN script_states TEXT;
 */

/**
 * State Management Functions
 */

// Set a state value
function setState($name, $value) {
	global $username;
	
	// Get current location as a key
	$coords = coords();
	$plane = get("plane");
	$location = "$plane:$coords";
	
	// Get current states
	$states = getStates();
	
	// Set the new state value
	if (!isset($states[$location])) {
		$states[$location] = array();
	}
	$states[$location][$name] = $value;
	
	// Save states back to user table
	saveStates($states);
}

// Get all states for the current user
function getStates() {
	global $username;
	
	$statesJson = get("script_states");
	
	if (empty($statesJson)) {
		return array();
	}
	
	$states = json_decode($statesJson, true);
	if (!is_array($states)) {
		return array();
	}
	
	return $states;
}

// Save states back to user table
function saveStates($states) {
	global $username;
	
	$statesJson = json_encode($states);
	
	// Save to user table
	set("script_states", $statesJson);
}

// Get a specific state value
function getStateValue($name) {
	// Get current location as a key
	$coords = coords();
	$plane = get("plane");
	$location = "$plane:$coords";
	
	// Get all states
	$states = getStates();
	
	// Check if state exists for this location
	if (isset($states[$location]) && isset($states[$location][$name])) {
		return $states[$location][$name];
	}
	
	return null;
}

// Check if a state exists and optionally matches a value
function checkState($name, $value = null) {
	// Get current location as a key
	$coords = coords();
	$plane = get("plane");
	$location = "$plane:$coords";
	
	// Get all states
	$states = getStates();
	
	// Check if state exists
	$stateExists = isset($states[$location]) && isset($states[$location][$name]);
	
	// If just checking existence
	if ($value === null) {
		return $stateExists;
	}
	
	// Check for specific value
	return $stateExists && $states[$location][$name] === $value;
}

// Clear a state
function clearState($name) {
	// Get current location as a key
	$coords = coords();
	$plane = get("plane");
	$location = "$plane:$coords";
	
	// Get all states
	$states = getStates();
	
	// Remove the state if it exists
	if (isset($states[$location]) && isset($states[$location][$name])) {
		unset($states[$location][$name]);
		saveStates($states);
	}
}

/**
 * Main Script Functions
 */

// Track if we should skip else blocks
$skip_else_stack = array();

function script($linenum) {
	global $username, $script, $action, $action2, $action3, $cloaked, $admin, $tok;
	global $skip_else_stack;
	
	// Initialize the else stack for this recursion level
	if (!isset($skip_else_stack[$linenum])) {
		$skip_else_stack[$linenum] = false;
	}
	
	static $cling = 0;
	$cling++;
	$lines = $script;
	
	for ($i = $linenum; $i < count($lines); $i++) {
		if ($i == count($lines) - 1) {
			$line = explode(" ", substr($lines[$i], 0, strlen($lines[$i])));
		} else {
			$line = explode(" ", substr($lines[$i], 0, strlen($lines[$i]) - 1));
		}
		
		// Handle endif - resets the else tracking
		if (strtolower($line[0]) == "endif") {
			$skip_else_stack[$linenum] = false;
			return $i;
		}
		
		// Handle else statement
		if (strtolower($line[0]) == "else") {
			if ($skip_else_stack[$linenum]) {
				// If we've already executed the if block, skip this else block
				$blezk = 1;
				for ($j = $i + 1; $j < count($lines); $j++) {
					if (substr(strtolower($lines[$j]), 0, 3) == "if ") $blezk++;
					if (substr(strtolower($lines[$j]), 0, 4) == "nif ") $blezk++;
					if (substr(strtolower($lines[$j]), 0, 5) == "endif") $blezk--;
					if ($blezk == 0) break;
				}
				$i = $j;
				continue;
			} else {
				// Otherwise execute the else block normally
				$i = script($i + 1);
				continue;
			}
		}
		
		// Handle if/nif conditions
		if (strtolower($line[0]) == "if" || strtolower($line[0]) == "nif") {
			if (strtolower($line[0]) == "if") $nif = true; else $nif = false;
			if ($nif) $cif = checkif(substr($lines[$i], 3, strlen($lines[$i]) - 4)); else $cif = checkif(substr($lines[$i], 4, strlen($lines[$i]) - 5));
			
			if ($cif == $nif) {
				// Condition is met - execute the block and mark that we should skip else blocks
				$skip_else_stack[$linenum] = true;
				$i = script($i + 1);
				continue;
			} else {
				// Condition not met - skip the block and mark that we should NOT skip else blocks
				$skip_else_stack[$linenum] = false;
				$blezk = 1;
				for ($j = $i + 1; $j != count($lines) - 1; $j++) {
					if (substr(strtolower($lines[$j]), 0, 3) == "if ") $blezk++;
					if (substr(strtolower($lines[$j]), 0, 4) == "nif ") $blezk++;
					if (substr(strtolower($lines[$j]), 0, 5) == "endif") $blezk--;
					if ($blezk == 0) break;
				}
				$i = $j;
				continue;
			}
		}
		
		// State management commands
		if (strtolower($line[0]) == "state") {
			$state_name = $line[1];
			
			// Set the state value
			$state_value = "";
			for ($j = 2; $j < count($line); $j++) {
				$state_value .= $line[$j] . " ";
			}
			$state_value = trim($state_value);
			
			setState($state_name, $state_value);
			continue;
		}
		
		if (strtolower($line[0]) == "checkstate") {
			$state_name = $line[1];
			$value = getStateValue($state_name);
			
			if ($value !== null) {
				echo "State '$state_name' value: $value<BR>";
			} else {
				echo "State '$state_name' is not set.<BR>";
			}
			continue;
		}
		
		if (strtolower($line[0]) == "clearstate") {
			$state_name = $line[1];
			clearState($state_name);
			continue;
		}
		
		// EXISTING COMMANDS FROM HERE DOWN - NO CHANGES
		if (strtolower($line[0]) == "print") {
			$message = substr($lines[$i], 6);
			echo "$message<BR>";
			continue;
		}
		if (strtolower($line[0]) == "open") {
			setlevel(get("plane"), coords(), strtolower($line[1][0]), 1);
			continue;
		}
		if (strtolower($line[0]) == "setother") {
			$levedir = strtolower($line[2]);
			$leveset = $line[3];
			$world = get("plane");
			if (count($line) > 4) {
				$world = $line[3];
				$leveset = $line[4];
			}
			setlevel($world, $line[1], $levedir, $leveset);
			continue;
		}
		if (strtolower($line[0]) == "close") {
			setlevel(get("plane"), coords(), strtolower($line[1][0]), 0);
			continue;
		}
		if (strtolower($line[0]) == "switch") {
			if (getlevel(get("plane"), coords(), strtolower($line[1][0])) == 0) {
				setlevel(get("plane"), coords(), strtolower($line[1][0]), 1);
			} else {
				setlevel(get("plane"), coords(), strtolower($line[1][0]), 0);
			}
			continue;
		}
		if (strtolower($line[0]) == "chat") {
			$message = substr($lines[$i], 5);
			$chat = get("chat");
			$chat .= "$message<br>\n";
			set("chat", $chat);
			continue;
		}
		if (strtolower($line[0]) == "chathere") {
			$message = substr($lines[$i], 9);
			$peeps = explode(":", getlevel(get("plane"), coords(), "pcs"));
			for ($k = 0; $k < count($peeps) - 1; $k++) {
				$chat = getuser($peeps[$k], "chat");
				if ($peeps[$k] == $username) {
					$mes = str_replace("[name]", "you", $message);
					$mes = str_replace("[Name]", "You", $mes);
				} else {
					$mes = str_replace("[name]", get("name"), $message);
					$mes = str_replace("[Name]", get("name"), $mes);
				}
				$chat .= "$mes<br>\n";
				setuser($peeps[$k], "chat", $chat);
			}
			continue;
		}
		if (strtolower($line[0]) == "chatelse") {
			$message = substr($lines[$i], 9);
			$peeps = explode(":", getlevel(get("plane"), coords(), "pcs"));
			for ($k = 0; $k < count($peeps) - 1; $k++) {
				$chat = getuser($peeps[$k], "chat");
				if ($peeps[$k] == $username) {
					continue;
				} else {
					$mes = str_replace("[name]", get("name"), $message);
					$mes = str_replace("[Name]", get("name"), $mes);
				}
				$chat .= "$mes<br>\n";
				setuser($peeps[$k], "chat", $chat);
			}
			continue;
		}
		if (strtolower($line[0]) == "chatthere") {
			$message = substr($lines[$i], 11 + strlen($line[1]));
			$peeps = explode(":", getlevel(get("plane"), $line[1], "pcs"));
			for ($k = 0; $k < count($peeps) - 1; $k++) {
				$chat = getuser($peeps[$k], "chat");
				$mes = str_replace("[name]", get("name"), $message);
				$mes = str_replace("[Name]", get("name"), $mes);
				$mes = str_replace("[NAME]", get("name"), $mes);
				$chat .= "$mes<br>\n";
				setuser($peeps[$k], "chat", $chat);
			}
			continue;
		}
		if (strtolower($line[0]) == "chatall") {
			$message = substr($lines[$i], 8);
			$peeps = explode(":", getfile("online"));
			for ($k = 0; $k < count($peeps) - 1; $k++) {
				$chat = getuser($peeps[$k], "chat");
				if ($peeps[$k] == $username) {
					$mes = str_replace("[name]", "you", $message);
					$mes = str_replace("[Name]", "You", $mes);
				} else {
					$mes = str_replace("[name]", get("name"), $message);
					$mes = str_replace("[Name]", get("name"), $mes);
				}
				$chat .= "$mes<br>\n";
				setchat($peeps[$k], "chat", $chat);
			}
			continue;
		}
		if (strtolower($line[0]) == "bot") {
			$botdata = getbot($line[1]);
			if ($botdata != "") {
				$botdata = explode("\n", $botdata);
				$botname = substr($botdata[0], 0, strlen($botdata[0]) - 1);
				$chat = "";
				for ($k = 3; $k < count($action3); $k++) {
					$chat .= $action3[$k];
					if ($k != count($action3) - 1) $chat .= " ";
				}
				$peeps = explode(":", getlevel(get("plane"), coords(), "pcs"));
				$botsays = $botdata[rand(1, count($botdata) - 1)];
				for ($k = 0; $k < count($peeps) - 1; $k++) {
					$peepchatdata = getuser($peeps[$k], "chat");
					if ($peeps[$k] != $username) {
						$cp = getuser($peeps[$k], "chatpref");
						$botsay = str_replace("[name]", get("name"), $botsays);
						$botsay = str_replace("[Name]", get("name"), $botsay);
						$botsay = str_replace("[NAME]", get("name"), $botsay);
						$peepchatdata .= stripslashes("$botsay<br>\n");
						if ($cp[16] == 1) setuser($peeps[$k], "newchat", 1);
					} else {
						$botsay = str_replace("[name]", "you", $botsays);
						$botsay = str_replace("[Name]", "You", $botsay);
						$botsay = str_replace("[NAME]", get("name"), $botsay);
						$peepchatdata .= stripslashes("<b>$botsay</b><br>\n");
					}
					setuser($peeps[$k], "chat", $peepchatdata);
				}
			}
			continue;
		}
		if (strtolower($line[0]) == "move") {
			$action = "teleport " . $line[1];
			
			if (count($line) > 2)
				$action .= " " . $line[2];
		
			$action3 = explode(" ", $action);
			scriptedMove($action3);
		}
		if (strtolower($line[0]) == "fame") {
			set("fame", get("fame") + $line[1]);
			continue;
		}
		if (strtolower($line[0]) == "piety") {
			set("piety", get("piety") + $line[1]);
			continue;
		}
		if (strtolower($line[0]) == "proficiency") {
			set("proficiency", get("proficiency") + $line[1]);
			continue;
		}
		if (strtolower($line[0]) == "quests") {
			set("quests", get("quests") + $line[1]);
			continue;
		}
		if (strtolower($line[0]) == "pflag") {
			set("flags", str_replace("($line[1])", "", get("flags")) . "($line[1])");
			continue;
		}
		if (strtolower($line[0]) == "-pflag") {
			set("flags", str_replace("($line[1])", "", get("flags")));
			continue;
		}
		if (strtolower($line[0]) == "lflag") {
			setlevel(get("plane"), coords(), "flags", str_replace("($line[1])", "", getlevel(get("plane"), coords(), "flags")) . "($line[1])");
			continue;
		}
		if (strtolower($line[0]) == "-lflag") {
			setlevel(get("plane"), coords(), "flags", str_replace("($line[1])", "", getlevel(get("plane"), coords(), "flags")));
			continue;
		}
		if (strtolower($line[0]) == "god") {
			set("deity", $line[1]);
			continue;
		}
		if (strtolower($line[0]) == "var") {
			$var = strtolower($line[1]);
			$val = "";
			for ($j = 2; $j < count($line) - 1; $j++) $val .= "$line[$j] ";
			if (count($line) > 2) $val .= $line[count($line) - 1];
			set($var, $val);
			continue;
		}
		if (strtolower($line[0]) == "bot2") {
			$tok = true;
			$action3[0] = "talk";
			$action3[2] = strtolower($line[1]);
			continue;
		}
	}
	
	return $i;
}

// Enhanced checkif function to support state conditions and better handle commands
function checkif($line) {
	global $username, $action, $command;
	
	// Check for state conditions
	if (substr(strtolower($line), 0, 7) == "[state]") {
		$parts = explode(" ", substr($line, 7));
		$state_name = trim($parts[0]);
		
		// If just checking if state exists
		if (count($parts) == 1) {
			return checkState($state_name);
		}
		
		// Check for specific value
		$state_value = "";
		for ($j = 1; $j < count($parts); $j++) {
			$state_value .= $parts[$j] . " ";
		}
		$state_value = trim($state_value);
		
		return checkState($state_name, $state_value);
	}
	
	// Add special handling for numbered options like [1], [2], etc.
	if (preg_match('/^\[\d+\]$/', $line) && strtolower($action) === strtolower($line)) {
		$command = 1;
		return true;
	}
	
	// Original conditions below
	if (substr(strtolower($line), 0, 5) == "[has]") {
		$thestring = substr(strtolower($line), 6, strlen($line) - 7);
		if (strpos($action, $thestring) === false) return false;
		$command = 1;
	} else if (substr(strtolower($line), 0, 7) == "[first]") {
		$thestring = substr(strtolower($line), 8, strlen($line) - 9);
		if (strpos($action, $thestring) !== 0) return false;
		$command = 1;
	} else if (substr(strtolower($line), 0, 5) == "[bot]") {
		$thestring = substr(strtolower($line), 6, strlen($line) - 6);
		if (substr($action, 0, strlen($thestring) + 8) != "talk to $thestring") return false;
		$command = 1;
	} else if (substr(strtolower($line), 0, 7) == "[pflag]") {
		if ($line[8] == "-") {
			if (strpos(get("flags"), "(" . substr($line, 9, strlen($line) - 9) . ")") !== false) return false;
		} else {
			if (strpos(get("flags"), "(" . substr($line, 8, strlen($line) - 8) . ")") === false) return false;
		}
	} else if (substr(strtolower($line), 0, 7) == "[lflag]") {
		if ($line[8] == "-") {
			if (strpos(getlevel(get("plane"), coords(), "flags"), "(" . substr($line, 9, strlen($line) - 9) . ")") !== false) return false;
		} else {
			if (strpos(getlevel(get("plane"), coords(), "flags"), "(" . substr($line, 8, strlen($line) - 8) . ")") === false) return false;
		}
	} else if (substr(strtolower($line), 0, 5) == "[god]") {
		$parts = explode(" ", $line);
		if (strtolower(get("deity")) == strtolower($parts[1])) return true;
		return false;
	} else if (substr(strtolower($line), 0, 6) == "[-god]") {
		$parts = explode(" ", $line);
		if (strtolower(get("deity")) == strtolower($parts[1])) return false;
	} else if (substr(strtolower($line), 0, 6) == "[fame]") {
		$parts = explode(" ", $line);
		if (get("fame") < $parts[1]) return false;
	} else if (substr(strtolower($line), 0, 7) == "[piety]") {
		$parts = explode(" ", $line);
		if (get("piety") < $parts[1]) return false;
	} else if (substr(strtolower($line), 0, 13) == "[proficiency]") {
		$parts = explode(" ", $line);
		if (get("proficiency") < $parts[1]) return false;
	} else if (substr(strtolower($line), 0, 8) == "[quests]") {
		$parts = explode(" ", $line);
		if (get("quests") < $parts[1]) return false;
	} else if (substr(strtolower($line), 0, 9) == "[hasfame]") {
		if (get("quests") < get("fame")) return true;
		return false;
	} else if (substr(strtolower($line), 0, 5) == "[var]") {
		$l = explode(" ", $line);
		$var = strtolower($l[1]);
		$val = "";
		for ($j = 2; $j < count($l) - 1; $j++) $val .= "$l[$j] ";
		if (count($l) > 2) $val .= $l[count($l) - 1];
		if (get($var) != $val) return false;
	} else if (substr(strtolower($line), 0, 7) == "[invar]") {
		$l = explode(" ", $line);
		$var = strtolower($l[1]);
		$val = "";
		for ($j = 2; $j < count($l) - 1; $j++) $val .= "$l[$j] ";
		if (count($l) > 2) $val .= $l[count($l) - 1];
		if (strpos(get($var), $val) === false) return false;
	} else if (strtolower(trim($line)) === strtolower(trim($action))) {
		// Exact command match - handles simple commands like "n", "look north"
		$command = 1;
		return true;
	} else {
		return false;
	}
	
	return true;
}

function scriptedMove($action3) {
	$command = 1;

	if (strtolower($action3[1]) != "to") {
		$dest = explode("~", $action3[1]);
		$p = get("plane");

		if (count($action3) > 2)
			$p = strtolower($action3[2]);

		if (islevel($p, $action3[1])) {
			moveToLocation($dest, $p);
		} else {
			echo("Level $action3[1] not found on the $p plane. Teleportation failed.<br>\n");
		}
	} else {
		echo("Invalid syntax. Usage: teleport to [destination] or teleport [destination].<br>\n");
	}
}

function moveToLocation($dest, $p) {
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	$abc = 1;

	set("x", $dest[0]);
	set("y", $dest[1]);
	set("z", $dest[2]);
	set("plane", $p);

	$admin = get("admin");

	// Check if the player is not an admin before echoing the message
	if (is_numeric($admin)) {
		echo("You have teleported to $dest[0]~$dest[1]~$dest[2] on the $p plane.<br>\n");
	}
}

// Execute the script
$script = str_replace("&#39;", "'", explode("\n", getlevel(get("plane"), coords(), "script")));
script(0);
?>