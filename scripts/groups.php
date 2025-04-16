<?php

$gact = $_POST['gact'] ?? '';

if (!empty($gact)) {
	if ($gact == "Remove") {
		$gdata = get("friends");
		$gdat = explode(":", $gdata);
		for ($i = count($gdat) - 1; $i >= 0; $i--) {
			$var = "g$i";
			if (!empty($$var)) {
				$gdata = str_replace($gdat[$i] . ":", "", $gdata);
				echo $gdat[$i] . " successfully removed from your friends list.<br>\n";
			}
		}
		set("friends", $gdata);
	} else if ($gact == "Send Mail") {
		$action = "compose";
		$to = "";
		$gdat = explode(":", get("friends"));
		for ($i = count($gdat) - 1; $i >= 0; $i--) {
			$var = "g$i";
			if (!empty($$var)) {
				if ($to == "") {
					$to = $gdat[$i];
				} else {
					$to .= "," . $gdat[$i];
				}
			}
		}
	}
}

if (strtolower($action3[0]) === "+group" || strtolower($action3[0]) === "+friend"){
	$command = 1;
	$gadd = ucwords(strtolower($action3[1]));
	if (!isuser($gadd)) echo "User $gadd not found.<br>\n"; else{
		if ((strpos(get("friends"),"$gadd:") !== false)){
			echo "$gadd is already in your group.<br>\n";
		}else if($gadd == $username){
			echo "You cannot add yourself to your friends list.<br>\n";
		}else{
			set("friends",get("friends")."$gadd:");
			echo "$gadd successfully added to your friends list.<br>\n";
		}
	}
}else if(strtolower($action3[0]) === "-group" || strtolower($action3[0]) === "-friend"){
	$command = 1;
	for ($i = 1; $i < count($action3); $i++){
		$gremove = ucwords(strtolower($action3[$i]));
		if (strpos(get("friends"),"$gremove:") !== false){
			set("friends",str_replace("$gremove:","",get("friends")));
			echo "$gremove successfully removed from your friends list.<br>\n";
		}else echo "$gremove is not in your friends list.<br\n>";
	}
}else if ($action === "showfriends" || $action === "friends" || $action === "showgroup" || $action === "group" || $action == "group list" || $action == "friends list" || $action == "friend list"){
	$command = 1;
	$groupdata = get("friends");
	if (get("friends") == "") echo "Your friends list is empty.<br>\n"; else{
		echo "<form action=main.php>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password>\n<table>\n<tr><td><u>Friends</u></td></tr>\n";
		$groupdata = explode(":",get("friends"));
		for ($i = 0; $i < count($groupdata) - 1; $i++){
			$guser = $groupdata[$i];
			echo "<tr><td><input type=checkbox name=g$i> <a href=\"main.php?action=-group $guser&username=$username&password=$password\" title=Remove>X</a> - <a href=\"main.php?action=compose&to=$guser&username=$username&password=$password\" title=\"Send Mail\">$guser</a></td></tr>\n";
		}
		echo "<tr><td><input type=submit value=Remove name=gact> <input type=submit value=\"Send Mail\" name=gact></td></tr></table>\n</form>\n";
	}
}else if($action3[0] === "group" || $action3[0] == "friends"){
	$command = 1;
	if (get("friends") == "") echo "Your group is empty.<br>\n"; else{
		for ($i = 1; $i < count($action3); $i++){
			$message .= $action3[$i];
			$message .= " ";
		}
		set("chat",get("chat")."<b>You told your friends, \"$message\"</b><br>\n");
		$groupdata = explode(":",get("friends"));
		$myname = get("name");
		if (get("gender") === "male") $gender = "his"; else if (get("gender") === "female") $gender = "her"; else $gender = "their";
		for ($x = 0; $x < count($groupdata); $x++){
			$guser = $groupdata[$x];
			$cp = getuser($guser,"chatpref");
			if ($cp[12] == 1) setuser($guser,"newchat",1);
			if (strpos(getfile("online"),"$guser:") !== false && strpos(getuser($guser,"morons"),"$username:") === false) setuser($guser,"chat",getuser($guser,"chat")."<b>$myname told $gender friends, \"$message\"</b><br>\n");
		}
	}
}
?>