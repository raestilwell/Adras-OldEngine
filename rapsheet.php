<html>
<head>
<?
$username = $_POST['username'];
$password = $_POST['password'];
$offender = $_POST['offender'];
$offense = $_POST['offense'];
$act = $_POST['act'];
$date = date("F j, Y");
$admin = $username;


require("scripts/rapsheet.php");
require("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
?>
</head>
<body>
<?
  if (is_numeric(get("admin")))
    echo "Foo'.<br>\n";
  else
  {
	setrap($offender,$offense,$act,$date,$admin);
	echo "Rapsheet edited.<br>\n";
  }
?>
</body>
</html>