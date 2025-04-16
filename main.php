<?php
/**
 * Main Game Interface
 * Adrastium: Realms Reborn Online
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get user credentials from GET/POST
$username = $_GET['username'] ?? $_POST['username'] ?? '';
$password = $_GET['password'] ?? $_POST['password'] ?? '';
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Include required files
require("scripts/function.php");
require("scripts/verify.php");
require("scripts/muted.php");

// Initialize variables
$command = $cloaked = $posing = 0;
$isloggingin = $_GET['isloggingin'] ?? '';
$admin = get("admin");

// Process any lockout actions (admin only)
if (($admin == "X" || $admin[0] == "&") && ($action == "lockout" || $action == "letin")) {
	$action = "";
	setfile("lockout", $action == "lockout" ? 1 : "");
}

// Check for idle users
require("scripts/checkidle.php");

// Clear newchat flag when viewing the main page or clicking on chat notification
if ($action == "" || isset($_GET['clearchat'])) {
	set("newchat", 0);
}

// Update timelog if needed
if (!is_numeric(get("admin"))) {
	$timelog = getfile("timelog");
	$timelogEntries = explode("\n\n", $timelog);
	$lastEntry = end($timelogEntries);

	if (isset($lastEntry[0]) && is_numeric($lastEntry[0])) {
		$lastEntryTimestamp = intval($lastEntry[0]);

		if (($lastEntryTimestamp + 7 <= date("z")) || ($lastEntryTimestamp - 200 > date("z"))) {
			$timelog .= "end:" . time() . "\n\n" . ($lastEntryTimestamp + 7) . "\nstart:" . time() . "\n";
			setfile("timelog", $timelog);
		}
	}
}

// Handle login events
if ($isloggingin == 1) {
	handleLoginProcess();
}

// Update last action time and check timers
set("last_action", time());
checkUserTimers();
set("ip", $_SERVER['REMOTE_ADDR']);

// Filter and process the action
$action = filter(stripslashes($action));
$action2 = $action;
$action3 = explode(" ", $action2);
$action = strtolower($action);

// Add to log if necessary
$allowedActions = ["settings", "description", "del", "stats", "help", "info", "n", "s", "w", "e", "u", "d", "who", "look", "clear", "editfile", "log", "biglog"];

if (!isset($_POST['nolog']) && !in_array($action, $allowedActions)) {
	require("scripts/addlog.php");
}

if (!is_numeric(get("admin")) && !in_array($action, ["settings", "description", "del", "stats", "help", "info", "n", "s", "w", "e", "u", "d", "who", "look", "clear"])) {
	require("scripts/alog.php");
}

// Process basic commands (flags, map settings, etc.)
processBasicCommands($action);

// Process scripted areas
if (strpos(getlevel(get("plane"), coords(), "flags"), "(script)") !== false && strpos(get("flags"), "(noscript)") === false) {
	require("scripts/script.php");
}

// Process specialized commands
processSpecializedCommands($action, $action2, $action3);

// Process chat and communication if not muted/deaf
if (!get("muted") && !get("deaf")) {
	require("commands/orgCommands/guild.php");
	require("commands/orgCommands/militia.php");
	require("commands/orgCommands/clan.php");
	require("scripts/chatfunc.php");
	require("scripts/groups.php");
	require("scripts/ignore.php");
}

// Handle mail
require("scripts/mail.php");
require("scripts/datetime.php");

// Handle logout
if ($action === "quit" || $action === "logoff" || $action === "logout" || $action === "log out" || $action === "log off") {
	require("scripts/logout.php");
}

// Handle movement if not frozen
if (get("frozen") == 0) {
	require("scripts/movechar.php");
}

// Show map if appropriate
if (strpos(get("flags"), "(map)") === false && strpos(get("flags"), "(nomap)") === false && $action !== "who" && $action !== "settings" && $action !== "description" && $action !== "info" && $action !== "stats") {
	require("scripts/showmap.php");
}

// Show coordinates for admins
if (!is_numeric($admin)) {
	echo "You are at " . coords() . " on the " . get("plane") . " plane.<br>\n";
}

// Display status flags
displayStatusFlags();

// Handle look commands
if (substr($action, 0, 8) === "look at ") {
	require("scripts/lookat.php");
} elseif (strtolower($action3[0]) === "look") {
	require("scripts/lookdir.php");
}

// Display room or handle special views
if (!isSpecialView($action, $action3)) {
	if (!islevel(get("plane"), coords())) {
		echo "This level doesn't seem to exist.<br>\n";
		set("x", "you");
		set("y", "are");
		set("z", "stuck");
		set("plane", "physical");
	} else {
		require("scripts/showhere.php");
	}
} else {
	// Handle special views (stats, who, info, settings)
	if ($action === "stats") {
		require("scripts/showstat.php");
	} elseif ($action === "who" || $action === "online") {
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		require("scripts/who.php");
	} elseif ($action === "info") {
		require("scripts/info.php");
	} elseif ($action == "settings") {
		require("scripts/settings.php");
	}
}

// Handle AFK status
handleAfkStatus($action);

// If no command was recognized
if ($command == 0) {
	echo "Command failed: $action2";
}

// Check for mail
require("scripts/checkmail.php");

// Redirect to help page if requested
if ($action == "help") {
	echo "<script language=javascript>\nlocation='ndex.php';\n</script>\n";
}

// Add anchor for autoscroll if needed
$stayattop = isset($stayattop) ? $stayattop : false;
if (shouldAddBottomAnchor($action, $action3, $stayattop)) {
	echo "<a name=thebottom id=thebottom></a>";
}

// Track chat for notifications
trackChatForNotifications();

/**
 * Function definitions
 */

/**
 * Handle login process for new connections
 */
function handleLoginProcess() {
	global $username;
	
	$flagdata = get("flags");
	$invis = strpos($flagdata, "(invis)");
	set("last_login", time());
	set("flags", str_replace("(nodeltemp)", "", get("flags")));

	if ($invis === false) {
		$action = "/" . get("login");
		echo "<font color=" . get("tcolor") . ">\n";
	}

	print nl2br(stripslashes(getfile("login")));

	$pcs = explode(":", getfile("online"));
	foreach ($pcs as $pc) {
		if (strpos(getuser($pc, "friends"), $username) !== false &&
			!(getuser($pc, "x") == get("x") && getuser($pc, "y") == get("y") &&
				getuser($pc, "z") == get("z") && getuser($pc, "plane") == get("plane"))
		) {
			setuser($pc, "chat", getuser($pc, "chat") . "<font class=friends><input type=button class=button onClick=javascript:tellTo('$username') value=*>$username has come online.</font><br>\n");
		}
	}
}

/**
 * Check and reset user timers (deaf/muted)
 */
function checkUserTimers() {
	// Reset deaf and dtime if necessary
	if (get("dtime") != "0" && get("last_action") > get("dtime")) {
		set("dtime", "0");
		set("deaf", 0);
	}

	// Reset muted and mtime if necessary
	if (get("mtime") != "0" && get("last_action") > get("mtime")) {
		set("mtime", "0");
		set("muted", 0);
	}
}

/**
 * Process basic commands like setting flags and map settings
 */
function processBasicCommands($action) {
	global $command;
	
	$commands = [
		"-ooc" => "(ooc)",
		"-chat" => "(chat)",
		"+ooc" => "(ooc)",
		"+chat" => "(chat)",
		"-map" => "(map)",
		"+map" => "(map)",
		"+bold" => "(bold)",
		"-bold" => "(bold)",
		"mapminustwo" => ["mapdistort" => -2],
		"mapminusone" => ["mapdistort" => -1],
		"mapbaselevel" => ["mapdistort" => 0],
		"mapplusone" => ["mapdistort" => 1],
		"mapplustwo" => ["mapdistort" => 2],
		"cloak" => ["flags" => "(cloak)"],
		"uncloak" => ["flags" => str_replace("(cloak)", "", get("flags"))],
	];

	foreach ($commands as $key => $value) {
		if ($action === $key) {
			$command = 1;
			if (is_array($value)) {
				foreach ($value as $property => $propertyValue) {
					$$property = $propertyValue;
				}
			} else {
				set("flags", get("flags") . $value);
			}
		}
	}
}

/**
 * Process specialized commands (talk, recall, sethome, etc.)
 */
function processSpecializedCommands($action, $action2, $action3) {
	global $command, $posing, $admin, $username;

	// Handle talk commands
	if (strtolower($action3[0]) == "talk" && isbot2here(strtolower($action3[2]))) {
		$bd = getbot2(strtolower($action3[2]));
		if ($bd[6] == "y" || isset($GLOBALS['tok']) && $GLOBALS['tok'] === true) {
			echo "<script>\nthis.location='talkbot2.php?username=$username&password={$_GET['password']}&name=" . strtolower($action3[2]) . "'\n</script>";
			die();
		}
	}

	// Handle sethome
	if ($action === "sethome") {
		set("recall", get("x") . "~" . get("y") . "~" . get("z"));
		set("recallplane", get("plane"));
		$command = 1;
	}

	// Handle recall
	if (strpos(get("flags"), "(norecall)") === false && strpos(get("flags"), "(recall") !== false) {
		$command = 1;

		if ($action3[0] == "recall") {
			handleRecall($action3);
		} elseif ($action === "recall guild") {
			handleGuildRecall();
		}
	}

	// Handle pose
	if (strtolower($action3[0]) === "pose") {
		$posing = 1;
	}

	// Load admin powers if applicable
	if ($admin === "X") {
		require("scripts/powersx.php");
		require("scripts/powers.php");
		require("scripts/powersa.php");
		require("scripts/powerst2.php");
		require("scripts/powersw.php");
		require("scripts/powerst.php");
	}

	// Handle followers
	if (strpos(get("followers"), ",") !== false) {
		handleFollowers();
	}

	// Handle follow command
	if (strtolower($action3[0]) === "follow") {
		require("scripts/follow.php");
	}

	// Handle admin command
	if (!is_numeric($admin) && $action === "admin") {
		$command = 1;
		require("pages/admin.txt");
	}

	// Handle other special commands
	if ($action === "seekeys") {
		require("scripts/seekeys.php");
	}

	if ($action === "editroom") {
		require("scripts/editroom.php");
	}

	if (strtolower($action3[0]) === "post") {
		require("scripts/post.php");
	}

	if ($action === "read board") {
		require("scripts/readboard.php");
	}

	if (($admin == "&#9829;" || $admin == "X") && $action3[0] == "editpost") {
		require("scripts/editpost.php");
	}

	if ($action === "description") {
		require("scripts/descript.php");
	}

	if ($action === "change pass" || $action === "changepass" || $action === "change password" || $action === "changepassword") {
		require("scripts/changepass.php");
	}

	require("scripts/locklite.php");
	require("scripts/checkpos.php");
}

/**
 * Display user status flags
 */
function displayStatusFlags() {
	if (strpos(get("flags"), "(invis)") !== false) {
		echo "You are invisible.<br>\n";
	}

	if (strpos(get("flags"), "(nowho)") !== false) {
		echo "You are hidden from the wholist.";
	}

	if (strpos(get("flags"), "(cloak)") !== false) {
		echo "You are cloaked.<br>\n";
	}
}

/**
 * Determine if current action is a special view
 */
function isSpecialView($action, $action3) {
	return ($action === "help" || 
			strtolower($action3[0]) === "deletemail" || 
			$action === "settings" || 
			$action === "info" || 
			strtolower($action3[0]) === "editlevel" || 
			$action3[0] === "read" || 
			$action === "readmail" || 
			$action === "listmail" || 
			$action === "inbox" || 
			$action === "compose" || 
			$action === "send" || 
			$action === "sendmail" || 
			$action === "stats" || 
			$action === "equipment" || 
			$action === "who" || 
			$action === "online" || 
			$action === "read list" || 
			$action === "read board");
}

/**
 * Handle AFK status
 */
function handleAfkStatus($action) {
	global $command;
	
	$afk = get("isafk");
	if ($action === "afk") {
		$command = 1;
		if ($afk === "y") {
			set("isafk", "n");
			echo "You are no longer AFK.<br>\n";
		} else {
			set("isafk", "y");
			echo "You are now AFK.";
		}
	} elseif ($afk == "y" && get("unafk") === "y") {
		set("isafk", "n");
		echo "You are no longer AFK.<br>\n";
	}

	if ($action === "") {
		$command = 1;
	}
}

/**
 * Determine if bottom anchor should be added
 */
function shouldAddBottomAnchor($action, $action3, $stayattop) {
	return (
		(
			$action === "" ||
			$action[0] === "/" ||
			in_array(strtolower($action3[0]), ["me", "whisper", "talk", "chat", "ooc", "say", "tell", "shout", "achat", "ashout"]) ||
			$action === "clear" ||
			(
				in_array(strtolower($action3[0]), ["guild", "clan", "militia", "group", "friends"]) &&
				$action !== strtolower($action3[0])
			)
		) &&
		strpos(get("flags"), "(scroll)") !== false &&
		!$stayattop
	);
}

/**
 * Track chat messages for notifications
 */
function trackChatForNotifications() {
	$currentChat = get("chat");
	$lastSeenChat = get("last_seen_chat");
	
	// If the current chat is different from last seen chat, set newchat flag
	if ($currentChat != $lastSeenChat) {
		// Only set newchat if there are more messages (not just clearing the chat)
		if (strlen($currentChat) > strlen($lastSeenChat)) {
			set("newchat", 1);
		}
	}
	
	// When the user views the page, update last_seen_chat
	// But only if they're actively looking at the chat (not in other sections)
	if (get('action') != "help" && get('action') != "settings" && get('action') != "info" && 
		get('action') != "stats" && get('action') != "who" && get('action') != "equipment") {
		set("last_seen_chat", $currentChat);
		
		// If they're viewing chat, clear the newchat flag
		if (get('action') == "") {
			set("newchat", 0);
		}
	}
}

/**
 * Handle recall command
 */
function handleRecall($action3) {
	global $username;
	
	$recallPlane = isset($action3[1]) ? strtolower($action3[1]) : null;
	$flagdata = get("flags");

	if ($recallPlane != "") {
		if ((strpos($flagdata, "(astaria)") && $recallPlane == "astaria") || 
			(strpos($flagdata, "(allrecall)") && $recallPlane == "astaria")) {
			set("x", "0");
			set("y", "-4");
			set("z", "0");
			set("plane", "astaria");
		} else if (strpos($flagdata, "($recallPlane)") || strpos($flagdata, "(allrecall)")) {
			set("x", "0");
			set("y", "0");
			set("z", "0");
			set("plane", $recallPlane);
		} else {
			$plane = ucfirst($recallPlane);
			echo "You are not able to recall to $plane.";
		}
	} else if (get("recall") != "") {
		$recall = explode("~", get("recall"));
		$plane = get("recallplane");
		setlevel(get("plane"), coords(), "pcs", str_replace("$username:", "", getlevel(get("plane"), coords(), "pcs")));
		$peeps = explode(":", getlevel(get("plane"), coords(), "pcs"));
		for ($i = 0; $i < count($peeps) - 1; $i++) {
			$chatdat = getuser($peeps[$i], "chat") . get("name") . " disappeared via the magick of Recall.<br>\n";
			setuser($peeps[$i], "chat", $chatdat);
		}
		set("x", $recall[0]);
		set("y", $recall[1]);
		set("z", $recall[2]);
		set("plane", $plane);
		$GLOBALS['action'] = "me appeared via the magick of Recall.";
		$GLOBALS['action2'] = $GLOBALS['action'];
		$GLOBALS['action3'] = explode(" ", $GLOBALS['action']);
	} else {
		echo "Recall location is not set, so you cannot recall";
	}
}

/**
 * Handle recall guild command
 */
function handleGuildRecall() {
	global $username;
	
	if (get("plane") === "physical") {
		$statdata = explode("~", get("stat"));
		setlevel(get("plane"), coords(), "pcs", str_replace("$username:", "", getlevel(get("plane"), coords(), "pcs")));
		$peeps = explode(":", getlevel(get("plane"), coords(), "pcs"));
		for ($i = 0; $i < count($peeps) - 1; $i++) {
			$chatdat = getuser($peeps[$i], "chat") . get("name") . " disappeared via the magick of Recall.<br>\n";
			setuser($peeps[$i], "chat", $chatdat);
		}
		set("x", -6);
		set("y", -5);
		set("z", 0);
		$GLOBALS['action'] = "me appeared via the magick of Recall.";
		$GLOBALS['action2'] = $GLOBALS['action'];
		$GLOBALS['action3'] = explode(" ", $GLOBALS['action']);
	} else {
		echo "You can only use Recall while on the physical plane.<br>";
	}
}

/**
 * Handle followers logic
 */
function handleFollowers() {
	$fols = explode(",", get("followers"));

	for ($i = 0; $i < count($fols); $i++) {
		if (strpos(getlevel(get("plane"), coords(), "pcs"), "$fols[$i]:") === false) {
			set("followers", str_replace("$fols[$i],", "", get("followers")));
		}
	}

	if (get("followers") != "") {
		echo "You are being followed by: " . str_replace(",", ", ", substr(get("followers"), 0, strlen(get("followers")) - 1)) . "<br>\n";
	}
}
?>

<!-- Quick Whisper Feature -->
<a style="visibility:hidden;" href="javascript:tellTo('<?=get("lasttell")?>')" accesskey="r"></a>

<!-- Bootstrap Javascript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<script>
	// Initialize tooltips
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	
	// Debug function
	function debugAlerts() {
	  console.log('bmail display: ' + document.getElementById('bmail').style.display);
	  console.log('bchat display: ' + document.getElementById('bchat').style.display);
	}
	
	// Function to explicitly show alerts
	window.showAlert = function(alertType) {
	  console.log('showAlert called for: ' + alertType);
	  if (alertType === 'bmail') {
		var element = document.getElementById('bmail');
		element.style.display = 'block';
		element.classList.add('visible');
		console.log('Mail alert should now be visible');
	  } else if (alertType === 'bchat') {
		var element = document.getElementById('bchat');
		element.style.display = 'block';
		element.classList.add('visible');
		console.log('Chat alert should now be visible');
	  }
	  debugAlerts();
	}
	
	// Function to explicitly hide alerts
	window.hideAlert = function(alertType) {
	  console.log('hideAlert called for: ' + alertType);
	  if (alertType === 'bmail') {
		document.getElementById('bmail').style.display = 'none';
		document.getElementById('bmail').classList.remove('visible');
	  } else if (alertType === 'bchat') {
		document.getElementById('bchat').style.display = 'none';
		document.getElementById('bchat').classList.remove('visible');
	  }
	  debugAlerts();
	}
	
	// Initialize alerts
	document.addEventListener('DOMContentLoaded', function() {
	  console.log('DOM loaded, initializing alerts');
	  
	  // Hide alerts initially
	  document.getElementById('bmail').style.display = 'none';
	  document.getElementById('bchat').style.display = 'none';
	  
	  // Add click handlers
	  var mailLink = document.querySelector('#bmail a');
	  var chatLink = document.querySelector('#bchat a');
	  
	  if (mailLink) {
		mailLink.addEventListener('click', function() {
		  hideAlert('bmail');
		});
	  }
	  
	  if (chatLink) {
		chatLink.addEventListener('click', function() {
		  hideAlert('bchat');
		});
	  }
	  
	  debugAlerts();
	});
	
	// Function available to other frames
	window.showLayer = function(whichLayer) {
	  console.log('showLayer called for: ' + whichLayer);
	  var element = document.getElementById(whichLayer);
	  if (element) {
		element.style.display = 'block';
		element.classList.add('visible');
		console.log('Layer ' + whichLayer + ' should now be visible');
	  } else {
		console.error('Element ' + whichLayer + ' not found');
	  }
	  debugAlerts();
	}
	
	// Check chat status periodically
	function checkChatStatus() {
	  fetch('check_chat_status.php?username=<?=$username?>&password=<?=$password?>')
		.then(response => response.text())
		.then(data => {
		  if (data.trim() === '1') {
			showLayer('bchat');
		  }
		})
		.catch(error => console.error('Error checking chat status:', error));
	}
	
	// Check every 5 seconds
	setInterval(checkChatStatus, 5000);
</script>