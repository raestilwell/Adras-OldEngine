<?
set("followers","");
if (strtolower($action3[0]) == "follow"){
	$peeps = explode(":",getlevel(get("plane"),coords(),"pcs"));
	for ($i = 0; $i < count($peeps) - 1; $i++) setuser($peeps[$i],"followers",str_replace("$username,","",getuser($peeps[$i],"followers")));
}
if ($action == "follow"){
	$command = 1;
	echo "You are no longer following anyone.<br>\n";
}
if (count($action3) > 1 && ucwords(strtolower($action3[1])) != $username){
	$peep = ucwords(strtolower($action3[1]));
	if (strpos(get("followers"),"$peep,") !== false) echo "$peep is already following you!"; else if (strpos(getlevel(get("plane"),coords(),"pcs"),"$peep:") !== false){
		setuser($peep,"followers",str_replace("$username,","",getuser($peep,"followers"))."$username,");
		echo "You are now following $peep.<br>\n";
		$command = 1;
	}else echo "$peep is not here.<br>\n";
}
?>