<?

$username = $_POST['username'];
$title = $_POST['title'];
$descript = $_POST['descript'];
$alt = $_POST['alt'];

require_once("scripts/function.php");
require("scripts/verify.php");
require("scripts/style.php");
$flagdata = getlevel(get("plane"),coords(),"flags");
if (strpos($flagdata,"($username)") !== false || (!is_numeric(get("admin")) && get("admin") !== "0")){
	setlevel(get("plane"),coords(),"title",filter(stripslashes($title)));
	setlevel(get("plane"),coords(),"description",filter(stripslashes($descript)));
	setlevel(get("plane"),coords(),"alt",filter(stripslashes($alt)));
	echo "Room edited.<br>\n";
}else echo "You do not have permission to edit this room...<br>\n";

?>