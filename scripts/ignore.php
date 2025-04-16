<?
$iact = $_GET['iact'] ?? ''; // Initialize $iact with an empty string if it's not set in $_GET

if ($iact == "Remove"){
	$gdata = get("morons");
	$gdat = explode(":", $gdata);
	for ($i = count($gdat) - 1; $i >= 0; $i--) {
		$var = "i$i";
		if (!empty($$var)) {
			$gdata = str_replace($gdat[$i] . ":", "", $gdata);
			echo $gdat[$i] . " successfully removed from your friends list.<br>\n";
		}
	}
	set("morons", $gdata);
}
if ($action === "ignore" || $action === "showignore" || $action === "ignore list"){
	$command = 1;
	if (get("morons") == "") echo "Your ignore list is empty.<br>\n"; else{
		echo "<form action=main.php>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password>\n<table>\n<tr><td><u>Ignored</u></td></tr>\n";
		$data = explode(":",get("morons"));
		for ($i = 0; $i < count($data) - 1; $i++){
			$peep = $data[$i];
			echo "<tr><td><input type=checkbox name=i$i> <a href=\"main.php?action=-ignore $peep&username=$username&password=$password\" title=Remove>X - $peep</a></td></tr>\n";
		}
		echo "<tr><td><input type=submit value=Remove name=iact></td></tr></table>\n</form>\n";
	}
}else if (strtolower($action3[0]) == "+ignore" || strtolower($action3[0]) == "ignore"){
	$command = 1;
	$peep = ucwords(strtolower($action3[1]));
	if (!isuser($peep)) echo "User $gadd not found.<br>\n"; else{
		if ((strpos(get("morons"),"$peep:") !== false)){
			echo "You are already ignoring $peep.<br>\n";
		}else if($peep == $username){
			echo "You cannot add yourself to your ignore list.<br>\n";
		}else{
			set("morons",get("morons")."$peep:");
			echo "You are now ignoring $peep.<br>\n";
		}
	}
}else if(strtolower($action3[0]) === "-ignore"){
	$command = 1;
	for ($i = 1; $i < count($action3); $i++){
		$peep = ucwords(strtolower($action3[$i]));
		if (strpos(get("morons"),"$peep:") !== false){
			set("morons",str_replace("$peep:","",get("morons")));
			echo "$peep successfully removed from your ignore list.<br>\n";
		}else echo "$peep is not on your ignore list.<br\n>";
	}
}
?>