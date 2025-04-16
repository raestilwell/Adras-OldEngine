<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="Favicon Link">
	
	<title>Adrastium Help</title>
	
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
  
  </head>
  <body class="d-flex vh-100 text-center justify-content-center align-items-center">
	  <main class="px-3">
	  <h1>In Game Help</h1>
	  <hr class="w-30">
  
	  <!-- Begin page Content -->
	<?
	$page=$_GET['page'];
	$u = $_GET['u'];
	$p = $_GET['p'];
	if (is_file("pages/".$page.".htm"))require("pages/".$page.".htm");
	else if ($page == "c") require("pages/commands.htm");
	else if ($page == "t") require("pages/tops.htm");
	else echo "<p><a class='text-white hover-underline-animation' href=pages/commands.htm target=_top>Command List</a></p>
	<p><a class='text-white hover-underline-animation' href=map.php?u=$u&p=$p target=_top>The Map</a></p>";
	?>
	
	  </main>
	<!-- Bootstrap Javascript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>