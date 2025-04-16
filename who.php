<?php
// Initialize variables
$admin = $_GET['admin'] ?? 0; // Default to non-admin for public view
$username = $_GET['username'] ?? ''; // May be empty for public view
$password = $_GET['password'] ?? ''; // May be empty for public view

// Include essential functions and template
require("scripts/function.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/templates/who-template.php");

// Improved login check
$loggedIn = false;
if (!empty($username) && !empty($password)) {
	if (isuser($username)) {
		// Get stored password hash
		$storedHash = getuser($username, "password");
		// Compare with provided password
		if ($storedHash === md5(md5($password))) {
			$loggedIn = true;
		}
	}
}

// Get online players
$whodata = explode(":", getfile("online"));
$numon = count($whodata) - 1;
$numshow = $numon;

// Count visible players
$visiblePlayers = 0;
foreach ($whodata as $player) {
	if (!empty($player) && strpos(getuser($player, "flags"), "(nowho)") === false) {
		$visiblePlayers++;
	}
}
?>
<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="See who's currently online in Adrastium: Realms Reborn">
	<meta name="author" content="">
	<link rel="icon" href="Favicon Link">
	
	<title>Who's Online | Adrastium</title>
	
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	
	<!-- FontAwesome CDN -->
	<script src="https://kit.fontawesome.com/c11c3ebcdf.js" crossorigin="anonymous"></script>
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="assets/css/styles.css"/>
	<link rel="stylesheet" href="assets/css/who-styles.css"/>
  </head>
  <body class="d-flex vh-100 text-center who-page">
	
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
	  <header class="mb-auto">
		<div>
		  <h3 class="float-md-start mb-0">Adrastium</h3>
		  <nav class="nav nav-masthead justify-content-center float-md-end">
			<a class="nav-link fw-bold py-1 px-0" href="/">Home</a>
			<a class="nav-link fw-bold py-1 px-0" href="/character-registration">Register</a>
			<a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="https://adrastium.com/who.php">Who's Online</a>
		  </nav>
		</div>
	  </header>
	  
	  <main class="px-3">
		<h1>Current Adventurers</h1>
		<hr class="w-30">
		<p class="lead">These brave souls are currently exploring the realm of Adrastium</p>
		
		<div class="who-container">
			<?php
			$viewType = 'basic'; // Public view is always basic
			
			// Output appropriate column headers
			echo '<table class="who-table">';
			echo '<tr>';
			echo '<td class="cinzel-heading">Name</td>';
			echo '<td class="spacer"></td>';
			echo '<td class="cinzel-heading">Minutes Idle</td>';
			echo '<td class="spacer"></td>';
			echo '<td class="cinzel-heading">Admin Level</td>';
			echo '</tr>';
			
			// Process and display each character
			for ($i = 0; $i <= $numon; $i++) {
				$time = time();
				if ($whodata[$i] != "") {
					$whouser = $whodata[$i];
					
					// Skip hidden users for public view
					if (strpos(getuser($whouser, "flags"), "(nowho)") !== false) {
						$numshow--;
						continue;
					}
					
					// Name display with self highlight if logged in
					$displayName = getuser($whouser, "name");
					if ($loggedIn && $whouser == $username) {
						$displayName = "<font class=self>$displayName</font>";
					}
					
					// Admin icon for all admin levels
					$adminLevel = determineAdminLevel($whouser);
					$adminIcon = "";
					if ($adminLevel != "") {
						$adminIcon = "<i class=\"fa-solid fa-crown\" title=\"$adminLevel\"></i>";
					}
					
					// Output character row
					echo "<tr>";
					echo "<td>";
					
					// Move admin crown before the name
					if (!empty($adminIcon)) {
						echo $adminIcon . " ";
					}
					
					// AFK indicator
					$afkAttr = (getuser($whouser, "isafk") === "y") ? 
						"title=\"AFK\"" : "";
					
					// Name with link
					echo "<span $afkAttr class='no-underline'>";
					echo $displayName;
					echo "</span>";
					echo "</td>";
					
					echo "<td class='spacer'></td>";
					
					// Minutes idle
					$minutesIdle = floor((time() - getuser($whouser, "last_action")) / 60);
					echo "<td><center>" . $minutesIdle . "</center></td>";
					
					echo "<td class='spacer'></td>";
					
					// Admin level
					echo "<td><center>" . $adminLevel . "</center></td>";
					
					echo "</tr>";
				}
			}
			
			// Display player count
			echo "<tr><td colspan='5' class='text-center player-count'>There are $visiblePlayers adventurers online.</td></tr>";
			echo "</table>";
			
			// Only show login message if not logged in
			if (!$loggedIn) {
				?>
				<div class="login-cta">
					<h3>Adventure Awaits!</h3>
					<a href="index.php" class="btn btn-lg btn-pink fw-bold w-50">
						<i class="fa-solid fa-door-open me-2"></i>Enter the Realm
					</a>
				</div>
				<?php
			}
			?>
		</div>
		
		<?php if (!$loggedIn): ?>
		<p class="muted mt-3">
			New to Adrastium? <a href="character-registration" class="text-white hover-underline-animation">Create Your Character</a>
		</p>
		
		<ul class="external-links">
			<li>
				<a href="https://discord.gg/uheRfvWTxn" data-bs-toggle="tooltip" data-bs-title="Join Our Discord">
					<i class="fa-brands fa-discord"></i>
				</a>
			</li>
			
			<li>
				<a href="https://patreon.com/raestilwell" target="_blank" data-bs-toggle="tooltip" data-bs-title="Support Rae on Patreon">
					<i class="fa-brands fa-patreon"></i>
				</a>
			</li>
			
			<li>
				<a href="https://kofi.com/raestilwell" target="_blank" data-bs-toggle="tooltip" data-bs-title="Buy Rae a Kofi">
					<svg fill="rgba(255,255,255,.8)" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M23.881 8.948c-.773-4.085-4.859-4.593-4.859-4.593H.723c-.604 0-.679.798-.679.798s-.082 7.324-.022 11.822c.164 2.424 2.586 2.672 2.586 2.672s8.267-.023 11.966-.049c2.438-.426 2.683-2.566 2.658-3.734 4.352.24 7.422-2.831 6.649-6.916zm-11.062 3.511c-1.246 1.453-4.011 3.976-4.011 3.976s-.121.119-.31.023c-.076-.057-.108-.09-.108-.09-.443-.441-3.368-3.049-4.034-3.954-.709-.965-1.041-2.7-.091-3.71.951-1.01 3.005-1.086 4.363.407 0 0 1.565-1.782 3.468-.963 1.904.82 1.832 3.011.723 4.311zm6.173.478c-.928.116-1.682.028-1.682.028V7.284h1.77s1.971.551 1.971 2.638c0 1.913-.985 2.667-2.059 3.015z"></path></g></svg>
				</a>
			</li>    
		</ul>
		<?php endif; ?>
	  </main>
	  
	  <footer class="mt-auto text-white-50">
		<p>Copyright &copy;<?php echo date('Y'); ?> <a href="https://raemakes.com" target="_blank" class="text-white">RaeMakes</a>. All Rights Reserved.</p>
	  </footer>
	</div>
  
	<!-- Bootstrap Javascript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

	<script>
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	</script>
  </body>
</html>

<?php
// Helper function to determine admin level display
function determineAdminLevel($whouser) {
	if (getuser($whouser, "admin") === "0") {
		return "";
	} else if ($whouser == "Rae") {
		return "Owner";
	} else if (getuser($whouser, "admin") == "T") {
		return "Moderator";
	} else if (getuser($whouser, "admin") == "A") {
		return "Junior Admin";
	} else if (getuser($whouser, "admin") == "X") {
		return "Administrator";
	} else if (getuser($whouser, "admin") == "W") {
		return "Volunteer";
	} else {
		return getuser($whouser, "admin");
	}
}
?>