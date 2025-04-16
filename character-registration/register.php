<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require($_SERVER['DOCUMENT_ROOT'] . '/scripts/function.php');
$IP = $_SERVER['REMOTE_ADDR'];

$IPcheck = explode(".",$IP);
$IPcheck[3] = "*";
$IPcheck = implode(".",$IPcheck);

$username = $_POST['username'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$race = $_POST['race'];
$iclass = $_POST['iclass'];
$gender = $_POST['gender'];
$iflags = "";

// Process character type and agreement
$is_legacy = isset($_POST['is_legacy']) && $_POST['is_legacy'] == 1 ? 1 : 0;
$legacy_setting = isset($_POST['legacy_setting']) ? htmlspecialchars($_POST['legacy_setting']) : '';
$legacy_history = isset($_POST['legacy_history']) ? htmlspecialchars($_POST['legacy_history']) : '';
$legacy_agreement = isset($_POST['legacy_agreement']) && $_POST['legacy_agreement'] == 1 ? 1 : 0;
$new_character_agreement = isset($_POST['new_character_agreement']) && $_POST['new_character_agreement'] == 1 ? 1 : 0;

// Start HTML output with proper DOCTYPE and styling
?>
<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="Favicon Link">
	
	<title>Adrastium | Realms Reborn | Registration Success</title>
	
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	
	<!-- FontAwesome CDN -->
	<script src="https://kit.fontawesome.com/c11c3ebcdf.js" crossorigin="anonymous"></script>
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="../assets/css/styles.css"/>
  
  </head>
  <body class="d-flex vh-100 text-center">
	  
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
		<header class="mb-auto">
		  <div>
			<h3 class="float-md-start mb-0">Adrastium</h3>
			<nav class="nav nav-masthead justify-content-center float-md-end">
			  <a class="nav-link fw-bold py-1 px-0" href="../">Home</a>
			  <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="/character-registration">Register</a>
			  <a class="nav-link fw-bold py-1 px-0" href="https://adrastium.com/who.php">Who's Online</a>
			</nav>
		  </div>
		</header>
<?php
// Validation checks
if ($username == "") die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You did not enter a username. Please click Back on your browser and do so.</p></main></div></body></html>");

$username = strtolower($username);
$username = ucwords($username);

for ($i = 0; $i < strlen($username); $i++) if (!(ord($username[$i]) >= 97 && ord($username[$i]) <= 122) && !(ord($username[$i]) >= 65 && ord($username[$i]) <= 90)) die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Your username may only contain letters. Please click Back on your browser and correct it.</p></main></div></body></html>");

if (isuser($username)) die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>That username is already in use. Please click Back on your browser and use a different one.</p></main></div></body></html>");

if (strlen($username) > 15) die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Your username may not be more than 15 characters long. Please click Back on your browser and correct it.</p></main></div></body></html>");

if (strlen($username) < 3) die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Your username may not be less than 3 characters long. Please click Back on your browser and correct it.</p></main></div></body></html>");

if ($pass1 !== $pass2) die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Your passwords did not match. Please click Back on your browser and correct it.</p></main></div></body></html>");

if (strlen($pass1) < 4) die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Your password must be at least four characters long. Please click Back on your browser and correct it.</p></main></div></body></html>");

if ($pass1 == "") die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You did not enter a password. Please click Back on your browser and do so.</p></main></div></body></html>");

// Validate legacy fields if the legacy checkbox is checked
if ($is_legacy) {
	if (empty($legacy_setting)) {
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Please specify the original setting of your legacy character. Click Back on your browser and complete this field.</p></main></div></body></html>");
	}
	
	if (empty($legacy_history)) {
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Please provide history and notable abilities of your legacy character. Click Back on your browser and complete this field.</p></main></div></body></html>");
	}
	
	if (!$legacy_agreement) {
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You must agree to the legacy character progression terms. Click Back on your browser and check the agreement box.</p></main></div></body></html>");
	}
} else {
	// Validate new character agreement
	if (!$new_character_agreement) {
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You must agree to follow the honor system for fair roleplay. Click Back on your browser and check the agreement box.</p></main></div></body></html>");
	}
}

switch($race) {
	case 1:
		$irace = "custom";
		break;
	case 2:
		$irace = "dwarf";
		$iflags = "(Dwarvish)";
		break;
	case 3:
		$irace = "high elf";
		$iflags = "(Elvish)";
		break;
	case 4:
		$irace = "wood elf";
		$iflags = "(Elvish)";
		break;
	case 5:
		$irace = "drow";
		$iflags = "(Elvish)";
		break;
	case 6:
		$irace = "gnome";
		$iflags = "(Gnomeish)";
		break;
	case 7:
		$irace = "high half-elf";
		$iflags = "(Elvish)";
		break;
	case 8:
		$irace = "wood half-elf";
		$iflags = "(Elvish)";
		break;
	case 9:
		$irace = "half-drow";
		$iflags = "(Elvish)";
		break;
	case 10:
		$irace = "halfling";
		$iflags = "(Halfling)";
		break;
	case 11:
		$irace = "human";
		break;
	case 12:
		$irace = "lycan";
		break;
	case 13:
		$irace = "vampire";
		break;
	default:
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You did not select a race. Click Back on your browser and do so.</p></main></div></body></html>");
}

switch($iclass) {
	case 1:
		$iclass = "artificer";
		break;
	case 2:
		$iclass = "artisan";
		break;
	case 3:
		$iclass = "barbarian";
		break;
	case 4:
		$iclass = "bard";
		break;
	case 5:
		$iclass = "cleric";
		break;
	case 6:
		$iclass = "druid";
		break;
	case 7:
		$iclass = "fighter";
		break;
	case 8:
		$iclass = "mage";
		break;
	case 9:
		$iclass = "paladin";
		break;
	case 10:
		$iclass = "ranger";
		break;
	case 11:
		$iclass = "rogue";
		break;
	default:
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You did not select a class. Click Back on your browser and do so.</p></main></div></body></html>");
}

switch($gender) {
	case 1:
		$igender = "female";
		break;
	case 2:
		$igender = "male";
		break;
	case 3:
		$igender = "other";
		break;
	default:
		die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>You did not select a gender. Click Back on your browser and do so.</p></main></div></body></html>");
}

// Add flags
$iflags .= "(equip)";
$iflags .= "(newplayer)"; // Add newplayer flag by default

$dbh = dbconnect();

if ($dbh->select_db("adras_database")) {
	// Database selected successfully
} else {
	// Error selecting database
	die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Error selecting database: " . $dbh->error . "</p></main></div></body></html>");
}

// Prepare the SQL query
$dmp = md5(md5($pass1));
$created = time();

// Base query components
if ($is_legacy) {
	// Include legacy fields in the query for legacy characters
	$query = "INSERT INTO users(username, name, password, race, class, gender, created, flags, is_legacy, legacy_setting, legacy_history, legacy_tier)";
	$query .= " VALUES('$username', '$username', '$dmp', '$irace', '$iclass', '$igender', '$created', '$iflags', 1, '" . 
			 $dbh->real_escape_string($legacy_setting) . "', '" . 
			 $dbh->real_escape_string($legacy_history) . "', 1)";
} else {
	// Standard query for new characters
	$query = "INSERT INTO users(username, name, password, race, class, gender, created, flags)";
	$query .= " VALUES('$username', '$username', '$dmp', '$irace', '$iclass', '$igender', '$created', '$iflags')";
}

$sql_query = $dbh->query($query);

if ($sql_query === true) {
	// The INSERT query was successful
	$dbh->query("UPDATE users SET body = 'cotton tunic' WHERE username = '$username'");
} else {
	// The INSERT query failed
	die("<main class='px-3'><h1>Error</h1><hr class='w-30'><p class='lead'>Query execution failed: " . $dbh->error . "</p></main></div></body></html>");
}

$dbh->close();

// Success page with proper styling
?>
		<main class="px-3">
			<h1><?php echo $username; ?> created successfully!</h1>
			<hr class="w-30">
			
			<?php if ($is_legacy): ?>
			<div class="alert alert-adras mb-4">
				<h4><i class="fas fa-info-circle me-2"></i>Legacy Character Notice</h4>
				<p>Your legacy character information has been recorded. An administrator will reach out to discuss your character's progression in Adrastium.</p>
				<p>In the meantime, you will begin with basic class abilities (Tier 1) as per the progression system.</p>
			</div>
			<?php endif; ?>
			
			<p class="lead">Login below to begin your adventure!</p>

			<form name="form1" method="post" action="https://adrastium.com/game.php" class="mb-4">
				<div class="mb-3">
					<label for="loginname" class="form-label visually-hidden">Character Name</label>
					<input name="loginname" type="text" class="form-control" id="loginname" value="<?php echo $username; ?>" aria-describedby="login" placeholder="Character Name">
				</div>
				<div class="mb-3">
					<label for="loginpass" class="form-label visually-hidden">Password</label>
					<input name="loginpass" type="password" class="form-control" id="loginpass" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-lg btn-pink fw-bold w-50">Login</button>
			</form>
		</main>
		
		<footer class="mt-auto text-white-50">
			<p>Copyright &copy;2024 <a href="https://raemakes.com" target="_blank" class="text-white">RaeMakes</a>. All Rights Reserved.</p>
		</footer>
	</div>
  
	<!-- Bootstrap Javascript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>