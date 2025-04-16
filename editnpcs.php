<html>
<head>
<?
  $username = $_POST['username'];
  $password = $_POST['password'];
  $npcs = $_POST['npcs'];

  require("scripts/function.php");
  require("scripts/verify.php");
  require("scripts/style.php");
?>
</head>
<body>
<?
  $p = get("plane");
  $c = coords();
  setlevel($p,$c,"npcs",stripslashes($npcs));
  echo "NPCs updated.<br>\n";
?>
</body>
</html>