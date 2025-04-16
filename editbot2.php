<?
  $username = $_POST['username'];
  $password = $_POST['password'];
  $name = $_POST['name'];
  $data = $_POST['data'];
  $auto = $_POST['auto'];
  $x = $_POST['x'];
  $y = $_POST['y'];
  $z = $_POST['z'];
  $p = $_POST['p'];

  require("scripts/function.php");
  require("scripts/verify.php");
  require("scripts/style.php");
  if (is_numeric(get("admin")))
    echo "Foo'.<br>\n";
  else
  {
	if (!isbot2($name))
	  echo "Foo'?";
	else
	{
		if($auto=="on")
		  $auto="y";
		else
		  $auto="n";
		setbot2($name,$x,$y,$z,$p,$data,$auto);
		echo "Bot2 <i>$name</i> edited.<br>\n";
	}
}
?>