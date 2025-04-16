<html>
<head>
<?
$username = $_POST['username'];
$password = $_POST['password'];
$filename = $_POST['filename'];
$dat = $_POST['dat'];

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
	setfile($filename,$dat);
	echo "File edited.<br>\n";
  }
?>
</body>
</html>