<?
$username = $_POST['username'];
$password = $_POST['password'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];

require("scripts/function.php");
require("scripts/style.php");
if (strlen($pass1) < 4){
	echo "Your password must be at least 4 characters long.<BR>";
	require("scripts/changepass.php");
}else if ($pass1 != $pass2){
	echo "Passwords do not match.<br>";
	require("scripts/changepass.php");
}else{
	if (isuser($username)){
		if (md5(md5($password)) != get("password")){
			echo "Incorrect password.<br>\n";
			require("scripts/changepass.php");
		}else{
			set("password",md5(md5($pass1)));
			echo "Password changed successfully. You will need to log back in.<br>\n";
		}
	}else echo "$username does not exist.<br>\n";
}
?>