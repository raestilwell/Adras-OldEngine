<?php

$thelang = $_POST['thelang'] ?? null;

$notalk = 0;
set("language", "Common");

if ($thelang && ((strpos(get("flags"), "($thelang)") !== false) || (strpos(get("flags"), "(alltongues)") !== false))) {
	set("language", $thelang);
}

$lang = get("language");
$myname = get("name");
$pt = "<input type=button class=button onClick=javascript:tellTo('$username') value=*>";
$acl = count($action3);


if (strtolower($action3[0]) == "ooc" && getmuteval('ooc') != 0 && is_numeric(getuser($username,"admin"))){
echo "The ooc channel has been disabled by the admin.";
$command = 1;
}else if (strtolower($action3[0]) == "chat" && getmuteval('chat') != 0 && is_numeric(getuser($username,"admin"))){
echo "The chat channel has been disabled by the admin.";
$command = 1;
} else if ($acl>1&&(strtolower($action3[0]) == "ooc" || strtolower($action3[0]) == "chat")){
	if (strtolower($action3[0]) == "chat") $word = "chatted"; else $word = "chatted ooc";
	$command = 1;
	$message = substr($action2, 4);
	if ($action3[0] == "chat") $message = substr($action2, 5);
	set("chat",get("chat")."<b><font class=self>You $word, \"$message\"</font></b><br>\n");
	$chardata = explode(":",getfile("online"));
	$numchars = count($chardata);
	for ($i = 0; $i < $numchars; $i++){
		if ($chardata[$i] != $username && $chardata[$i] != ""){
			$peepname = $chardata[$i];
			$cp = getuser($peepname,"chatpref");
			if (strpos(getuser($peepname,"morons"),"$username:") !== false) continue;
			$pfdata = getuser($peepname,"flags");
			if (strpos($pfdata,strtolower("($action3[0])")) !== false) continue;
			if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname $word, \"$message\"</font><br>\n");
			else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname $word, \"$message\"<br>\n");
			if (($word[0] == "c" && $cp[9] == 1) || ($word[0] != "c" && $cp[8] == 1)) setuser($peepname,"newchat",1);
		}
	}
}else if ($action3[0] == "shout"){
	$command = 1;
	if ($acl>1&&$action3[1] != "to"){
		$message = substr($action2, 6);
		if ($lang == "Common") set("chat",get("chat")."<b><font class=self>You shouted, \"$message\"</font></b><br>\n");
		else if ($lang == "Common-sign" || $lang == "Drow-sign"){
			echo "You cannot shout in sign language!<br>\n";
			$notalk = 1;
		}else set("chat",get("chat")."<b><font class=self>You shouted in $lang, \"$message\"</font></b><br>\n");
		$chardata = explode(":",getfile("online"));
		$numchars = count($chardata);
		for ($i = 0; $i < $numchars && $notalk == 0; $i++){
			if ($chardata[$i] != $username && $chardata[$i] != ""){
				$peepname = $chardata[$i];
				$cp = getuser($peepname,"chatpref");
				if (get("plane") == getuser($peepname,"plane")){
				if (strpos(getuser($peepname,"morons"),"$username:") !== false) continue;
					if ($lang == "Common"){
						if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname shouted, \"$message\"</font><br>\n");
						else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname shouted, \"$message\"<br>\n");
					}else if (strpos(getuser($peepname,"flags"),"($lang)") !== false || strpos(getuser($peepname,"flags"),"(alltongues)") !== false){
						if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname shouted in $lang, \"$message\"</font><br>\n");
						else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname shouted in $lang, \"$message\"<br>\n");
					}else{
						if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname shouted something in $lang.</font><br>\n");
						else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname shouted something in $lang.<br>\n");
					}
					if ($cp[7] == 1) setuser($peepname,"newchat",1);
				}
			}
		}
	}elseif($acl>3){
		$peep = ucwords(strtolower($action3[2]));
		$chardata = getfile("online");
		if (strpos($chardata, "$peep:") === false) echo "$peep is not in Adrasteia right now.<br>\n"; else{
			$peepalias = getuser($peep,"name");
			$message = "";
			for ($i = 3; $i < count($action3); $i++){
				$message .= $action3[$i];
				if ($i < count($action3) - 1) $message .= " ";
			}
			if (getuser($peep,"plane") == get("plane")){
				if ($lang == "Common") set("chat",get("chat")."<b><font class=self>You shouted to $peepalias, \"$message\"</font></b><br>\n");
				else if ($lang == "Common-Sign" || $lang == "Drow-sign"){
					echo "You cannot shout in sign language!<br>\n";
					$notalk = 1;
				}else set("chat",get("chat")."<b><font class=self>You shouted to $peepalias in $lang, \"$message\"</font></b><br>\n");
				$chardata = explode(":",getfile("online"));
				$numchars = count($chardata);
				for ($i = 0; $i < $numchars && $notalk == 0; $i++){
					if ($chardata[$i] != $username && $chardata[$i] != ""){
						$peepname = $chardata[$i];
						$cp = getuser($peepname,"chatpref");
						if (getuser($peepname,"plane") == get("plane")){
							if (strpos(getuser($peepname,"morons"),"$username:") !== false) continue;
							if ($peepname != $peep){
								if ($lang == "Common"){
									if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname shouted to $peepalias, \"$message\"</font><br>\n");
									else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname shouted to $peepalias, \"$message\"<br>\n");
								}else if (strpos(getuser($peepname,"flags"),"($lang)") !== false || strpos(getuser($peepname,"flags"),"(alltongues)") !== false){
									if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname shouted to $peepalias in $lang, \"$message\"</font><br>\n");
									else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname shouted to $peepalias in $lang, \"$message\"<br>\n");
								}else{
									if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname shouted something to $peepalias in $lang.</font><br>\n");
									else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname shouted something to $peepalias in $lang.<br>\n");
								}
								if ($cp[6] == 1) setuser($peepname,"newchat",1);
							}else{
								if ($lang == "Common"){
									if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname shouted to you, \"$message\"</font></b><br>\n");
									else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname shouted to you, \"$message\"</b><br>\n");
								}else if (strpos(getuser($peepname,"flags"),"($lang)") !== false || strpos(getuser($peepname,"flags"),"(alltongues)") !== false){
									if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname shouted to you in $lang, \"$message\"</font></b><br>\n");
									else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname shouted to you in $lang, \"$message\"</b><br>\n");
								}else{
									if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname shouted something to you in $lang.</font></b><br>\n");
									else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname shouted something to you in $lang.</b><br>\n");
								}
								if ($cp[5] == 1) setuser($peepname,"newchat",1);
							}
						}
					}
				}
			}else echo "$peepalias is on a different plane.<br>\n";
		}
	}
}else if ($action3[0] == "say"){
	$command = 1;
	if ($acl>1&&$action3[1] != "to"){
		$message = substr($action2, 4);
		if ($lang == "Common") set("chat",get("chat")."<b><font class=self>You said, \"$message\"</font></b><br>\n");
		else set("chat",get("chat")."<b><font class=self>You said in $lang, \"$message\"</font></b><br>\n");
		$chardata = explode(":",getlevel(get("plane"),coords(),"pcs"));
		$numchars = count($chardata);
		for ($i = 0; $i < $numchars; $i++){
			if ($chardata[$i] != $username && $chardata[$i] != ""){
				$peepname = $chardata[$i];
				$cp = getuser($peepname,"chatpref");
				if (strpos(getuser($peepname,"morons"),"$username:") !== false) continue;
				if ($lang == "Common"){
					if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname said, \"$message\"</font><br>\n");
					else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname said, \"$message\"<br>\n");
				}else if (strpos(getuser($peepname,"flags"),"($lang)") !== false || strpos(getuser($peepname,"flags"),"(alltongues)") !== false){
					if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname said in $lang, \"$message\"</font><br>\n");
					else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname said in $lang, \"$message\"<br>\n");
				}else{
					if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname said something in $lang.</font><br>\n");
					else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname said something in $lang.<br>\n");
				}
				if ($cp[3] == 1) setuser($peepname,"newchat",1);
			}
		}
	}elseif($acl>3){
		$peep = ucwords(strtolower($action3[2]));
		$cdata = getlevel(get("plane"),coords(),"pcs");
		$chardata = explode(":",$cdata);
		if (strpos($cdata, "$peep:") === false || strpos(getuser($peep,"flags"),"(invis)") !== false) echo "$peep is not here right now.<br>\n"; else{
			$peepalias = getuser($peep,"name");
			$message = "";
			for ($i = 3; $i < count($action3); $i++){
				$message .= $action3[$i];
				if ($i < count($action3) - 1) $message .= " ";
			}
			if ($lang == "Common") set("chat",get("chat")."<b><font class=self>You said to $peepalias, \"$message\"</font></b><br>\n");
			else set("chat",get("chat")."<b><font class=self>You said to $peepalias in $lang, \"$message\"</font></b><br>\n");
			$numchars = count($chardata);
			for ($i = 0; $i < $numchars; $i++){
				if ($chardata[$i] != $username && $chardata[$i] != ""){
					$peepname = $chardata[$i];
					$cp = getuser($peepname,"chatpref");
					if (strpos(getuser($peepname,"morons"),"$username:") !== false) continue;
					if ($peepname != $peep){
						if ($lang == "Common"){
							if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname said to $peepalias, \"$message\"</font><br>\n");
							else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname said to $peepalias, \"$message\"<br>\n");
						}else if (strpos(getuser($peepname,"flags"),"($lang)") !== false || strpos(getuser($peepname,"flags"),"(alltongues)") !== false){
							if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname said to $peepalias in $lang, \"$message\"</font><br>\n");
							else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname said to $peepalias in $lang, \"$message\"<br>\n");
						}else{
							if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<font class=friends>$pt$myname said something to $peepalias in $lang.</font><br>\n");
							else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname said something to $peepalias in $lang.<br>\n");
						}
						if ($cp[2] == 1) setuser($peepname,"newchat",1);
					}else{
						if ($lang == "Common"){
							if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname said to you, \"$message\"</font></b><br>\n");
							else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname said to you, \"$message\"</b><br>\n");
						}else if (strpos(getuser($peepname,"flags"),"($lang)") !== false || strpos(getuser($peepname,"flags"),"(alltongues)") !== false){
							if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname said to you in $lang, \"$message\"</font></b><br>\n");
							else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname said to you in $lang, \"$message\"</b><br>\n");
						}else{
							if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname said something to you in $lang.</font></b><br>\n");
							else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname said something to you in $lang.</b><br>\n");
						}
						if ($cp[1] == 1) setuser($peepname,"newchat",1);
					}
				}
			}
		}
	}
}else if ($action3[0] == "tell"){
	$command = 1;
	if ($acl>3&&$action3[1] == "to"){
		$acy=1;
		$peep = ucwords(strtolower($action3[2]));
		$message = "";
		for ($i = 3; $i < count($action3); $i++){
			$message = "$message" . "$action3[$i]";
			if ($i < count($action3) - 1) $message .= " ";
		}
	}elseif($acl>2){
		$acy=1;
		$peep = ucwords(strtolower($action3[1]));
		$message = "";
		for ($i = 2; $i < count($action3); $i++){
			$message .= $action3[$i];
			if ($i < count($action3) - 1) $message .= " ";
		}
	}
	if (strpos(getfile("online"), "$peep:") === false) echo "$peep is not in Adrasteia right now.<br>\n"; elseif($acy==1){
		$peepname = getuser($peep,"name");
		$cp = getuser($peep,"chatpref");
		setuser($peep,"lasttell",$username);
		set("chat",get("chat")."<b><font class=self>You told $peepname, \"$message\"</font></b><br>\n");
		if (strpos(getuser($peep,"morons"),"$username:") === false){
			if (strpos(getuser($peep,"friends"),"$username:") !== false) setuser($peep,"chat",getuser($peep,"chat")."<b><font class=friends>$pt$myname told you, \"$message\"</font></b><br>\n");
			else setuser($peep,"chat",getuser($peep,"chat")."<b>$pt$myname told you, \"$message\"</b><br>\n");
			if ($cp[0] == 1) setuser($peep,"newchat",1);
		}
	}
}else if ($acl>3&&$action3[0] == "whisper"){
	$command = 1;
	$peep = ucwords(strtolower($action3[2]));
	$cdata = getlevel(get("plane"),coords(),"pcs");
	$chardata = explode(":",$cdata);
	if (strpos($cdata, "$peep:") === false || strpos(getuser($peep,"flags"),"(invis)") !== false) echo "$peep is not here right now.<br>\n"; else{
		$peepalias = getuser($peep,"name");
		$message = "";
		for ($i = 3; $i < count($action3); $i++){
			$message .= $action3[$i];
			if ($i < count($action3) - 1) $message .= " ";
		}
		set("chat",get("chat")."<b><font class=self>You whispered to $peepalias, \"$message\"</font></b><br>\n");
		$numchars = count($chardata);
		for ($i = 0; $i < $numchars; $i++){
			if ($chardata[$i] != $username && $chardata[$i] != ""){
				$peepname = $chardata[$i];
				$cp = getuser($peepname,"chatpref");
				if (strpos(getuser($peepname,"morons"),"$username:") !== false) continue;
				if ($peepname != $peep){
					if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname whispered something to $peepalias.</font></b><br>\n");
					else setuser($peepname,"chat",getuser($peepname,"chat")."$pt$myname whispered something to $peepalias.<br>\n");
				}else{
					if (strpos(getuser($peepname,"friends"),"$username:") !== false) setuser($peepname,"chat",getuser($peepname,"chat")."<b><font class=friends>$pt$myname whispered to you, \"$message\"</font></b><br>\n");
					else setuser($peepname,"chat",getuser($peepname,"chat")."<b>$pt$myname whispered to you, \"$message\"</b><br>\n");
				}
			}
		}
	}
}else if (!empty($action) && !empty($action3) && ($action[0] == "/" || strtolower($action3[0]) == "me")){
	$command = 1;

	$message = " " . substr($action2, 3);
	if ($action[0] == "/") {
		$message = substr($action2, 1);
	}

	// Checking the existence of the necessary variables before accessing them
	if (!empty(get("chat"))) {
		set("chat", get("chat") . "<b><font class=self>$myname$message</font></b><br>\n");
	}

	$chardata = explode(":", getlevel(get("plane"), coords(), "pcs"));
	$numchars = count($chardata);

	for ($i = 0; $i < $numchars; $i++) {
		if ($chardata[$i] != $username && $chardata[$i] != "") {
			$peepname = $chardata[$i];
			$cp = getuser($peepname, "chatpref");

			if (strpos(getuser($peepname, "morons"), "$username:") !== false) {
				continue;
			}

			if (strpos(getuser($peepname, "friends"), "$username:") !== false) {
				setuser($peepname, "chat", getuser($peepname, "chat") . "<font class=friends>$pt$myname$message</font><br>\n");
			} else {
				setuser($peepname, "chat", getuser($peepname, "chat") . "$pt$myname$message<br>\n");
			}

			if (!empty($cp) && $cp[4] == 1) {
				setuser($peepname, "newchat", 1);
			}
		}
	}
}
?>