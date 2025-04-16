<?php

// Function to safely retrieve values from $_POST and $_GET
function getValue($source, $key, $default = '') {
	return isset($source[$key]) ? $source[$key] : $default;
}

// Retrieve values from $_POST using the getValue function
$mm = getValue($_POST, 'mm');
$to = getValue($_POST, 'to');
$topic = getValue($_POST, 'topic');
$message = getValue($_POST, 'message');
$mailfunc = getValue($_GET, 'mailfunc');
$m = [];

// Retrieve values from $_GET using the getValue function for m0 to m10
for ($i = 0; $i <= 10; $i++) {
	$m[$i] = getValue($_GET, 'm' . $i);
}

// Mail functionality logic
if (!empty($mailfunc)) {
	$maildata = explode(":~:", get("mail"));

	for ($i = count($maildata) - 1; $i >= 0; $i--) {
		$var = "m$i";
		if (!empty($m[$i])) {
			switch ($mailfunc) {
				case "Delete":
					$newmaildata = $maildata[$i] . ":~:";
					$maildata = str_replace($newmaildata, "", implode(":~:", $maildata));
					$maildata = explode(":~:", $maildata);
					break;
				case "Mark Unread":
				case "Mark Read":
					$newmaildata = explode(":::", $maildata[$i]);
					$newmaildata[3] = ($mailfunc == "Mark Read") ? 1 : 0;
					$maildata[$i] = implode(":::", $newmaildata);
					break;
			}
		}
	}

	set("mail", implode(":~:", $maildata));
}

// Check for action3 and delete mail logic
if (strtolower(getValue($action3, 0)) == "deletemail") {
	$command = 1;
	$index = getValue($action3, 1);
	$maildata = explode(":~:", get("mail"));

	if ($index < count($maildata)) {
		$newmaildata = $maildata[$index] . ":~:";
		$maildata = str_replace($newmaildata, "", implode(":~:", $maildata));
		set("mail", $maildata);
		echo "Message $index deleted.<br>\n";
	} else {
		echo "You don't have that many messages.<br>\n";
	}

	$action = "mail";
}

// Compose mail logic
if (in_array($action, ["compose", "send", "sendmail"])) {
	$topic = getValue($_GET, 'topic');
	$message = getValue($_GET, 'message');
	$to = getValue($_GET, 'to');
	$command = 1;

	if (!empty($from)) {
		$from = stripslashes($from);
	}

	if (!empty($topic)) {
		$topic = stripslashes($topic);
	}

	if (!empty($message)) {
		$message = stripslashes("\n\n-------\n$message");
	}

	echo "<form action=main.php method=post>\n";
	echo "TO: <input name=to value=$to><br><br>\n";
	echo "SUBJECT: <input name=topic value=\"$topic\"><br><br>\n";
	echo "<textarea rows=10 cols=50 name=message>$message</textarea><BR>\n";
	echo "<input type=hidden name=mm value=1>\n";
	echo "<input type=hidden name=username value=$username>\n";
	echo "<input type=hidden name=password value=$password>\n";
	echo "<input type=hidden name=action value=dosend>\n";
	echo "<input type=submit value=\"Send Message\">\n";
	echo "</form>\n";
} elseif (in_array($action, ["mail", "read", "readmail", "listmail", "inbox", "read mail"])) {
	//list mail logic
	
	$command = 1;
	
		if (get("mail") == "")
			echo "You don't have any mail. <a href=main.php?username=$username&password=$password&action=compose>Send</a>.<br>\n";
		else
		{
	
			$maildata = get("mail");
	
			if ($maildata == "") echo "You don't have any mail.<br>\n";
			else
			{
				$maildata = explode(":~:",$maildata);
	
				echo "<table width=50% align=center>\n
					<tr><td colspan=2>\n
					<form action=main.php>\n
					<input type=hidden name=username value=$username>\n
					<input type=hidden name=password value=$password>\n
					<input type=submit name=action value=Compose>
					<input type=submit name=action value=Friends>
					<input type=submit name=action value=\"Ignore List\">\n
					</form>\n</td></tr>\n
					<form action=main.php>\n
					<tr><td width=30%>From</td><td style=text-align:left>Subject</td></tr>\n";
	
				for ($i = 0; $i < count($maildata) - 1; $i++)
				{
	
					$thismaildata = explode(":::",$maildata[$i]);
	
					$from = $thismaildata[0];
	
					$topic = stripslashes($thismaildata[1]);
	
					if ($thismaildata[3] == 0) $topic = "<b>$topic</b>";
	
					$fa = "";
	
					$fb = "";
	
					if (strpos(get("friends"),"$from:") !== false)
					{
						$fa = "<font class=friends>"; $fb = "</font>";
					}
	
					echo "<tr><td><input type=checkbox name=m$i>
						<a href=\"main.php?action=compose&to=$from&username=$username&password=$password\">$fa$from$fb</a></td>
						<td style=text-align:left><a href=\"main.php?action=read+$i&username=$username&password=$password\">$fa$topic$fb</a></td></tr>\n";
	
				}
	
				echo "<tr><td colspan=2>
					<input type=submit value=Delete name=mailfunc>
					<input type=submit value=\"Mark Read\" name=mailfunc>
					<input type=submit value=\"Mark Unread\" name=mailfunc>\n
					<input type=hidden name=username value=$username>
					<input type=hidden name=password value=$password>
					<input type=hidden name=action value=read>\n</form>\n</td></tr>\n<table>\n";
	
			}
	
		}
	
} elseif (strtolower(getValue($action3, 0)) == "read" && is_numeric(getValue($action3, 1))) {
	// Read mail logic
	$command = 1;
	
		$index = $action3[1];
	
		$maildata = get("mail");
	
		$maildata = explode(":~:",$maildata);
	
		if (count($maildata) > $index)
		{
	
			$thismaildata = $maildata[$index];
	
			$thismaildata = explode(":::",$thismaildata);
	
			$thismaildata[3] = 1;
	
			$from = $thismaildata[0];
	
			$topic = $thismaildata[1];
	
			$message = $thismaildata[2];
	
			$thismaildata = implode(":::",$thismaildata);
	
			$thismaildata2 = $maildata[$index];
	
			$maildata = implode(":~:",$maildata);
	
			$maildata = str_replace($thismaildata2,$thismaildata,$maildata);
	
			set("mail",$maildata);
	
			echo "FROM: $from - <a href=main.php?username=$username&password=$password&action=%2Bgroup+$from>Make Friend</a> - 
					<a href=main.php?username=$username&password=$password&action=ignore+$from>Ignore</a><br>\n";
	
			echo "SUBJECT: ". stripslashes($topic) . "<br><br>\n";
	
			echo stripslashes(nl2br($message)) . "<br><br>\n";
	
			echo "<a href=\"main.php?action=compose&to=$from&username=$username&password=$password&topic=Re:+$topic&message=$message\">Reply</a> - 
				<a href=\"main.php?action=compose&username=$username&password=$password&topic=Fwd:+$topic&message=$message\">Forward</a> - 
				<a href=\"main.php?action=deletemail+$index&username=$username&password=$password\">Delete</a><br>\n
				<a href=main.php?username=$username&password=$password&action=read>Inbox</a> - 
				<a href=main.php?username=$username&password=$password&action=%2Bgroup+$from>Make Friend</a> - 
				<a href=main.php?username=$username&password=$password&action=ignore+$from>Ignore</a><br>";
	
		}
		else echo "You don't have that many messages.<br>\n";
	
} elseif ($action == "dosend" && $mm == 1) {
	// Sending mail logic
	$command = 1;
	
		$message = filter($message);
	
		$topic = filter($topic);
	
		$to = str_replace(" ","",$to);
	
		$To = explode(",",$to);
		$ad = get("admin");
	
		for ($i = 0; $i < count($To); $i++)
		{
	
			if ($ad == "X" || $ad[0] == "&")
			{
	
				if ($to == "(all)")
				{
	
					$users = users();
	
					for($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "") $topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
					}
	
					echo "All users have received the message.<br>\n";
	
					break;
	
				}
	
			}
	
			$to = ucwords(strtolower($To[$i]));
	
			$z = 0;
	
			if ($ad == "X" || $ad[0] == "&")
			{
	
				if (strtolower($to) == "(t)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("T");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "") $topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$z = 1;
	
				}
	
				if (strtolower($to) == "(r)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("R");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "")
							$topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$z = 1;
	
				}
	
				if (strtolower($to) == "(a)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("A");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "") $topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$z = 1;
	
				}
	
				if (strtolower($to) == "(w)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("W");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "")
							$topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
				}
	
				if (strtolower($to) == "(p)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("P");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "")
							$topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$z = 1;
	
				}
				if (strtolower($to) == "(x)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("X");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "")
							$topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$users = admin("&#9829;");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "")
							$topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$z = 1;
	
				}
	
				if (strtolower($to) == "(m)" || strtolower($to) == "(admin)")
				{
	
					$users = admin("M");
	
					for ($i = 0; $i < count($users); $i++)
					{
	
						$a = $users[$i];
	
						$maildata = getuser($a,"mail");
	
						if ($topic == "") $topic = "(no subject)";
	
						$maildata .= "$username:::$topic:::$message:::0:~:";
	
						setuser($a,"mail",$maildata);
	
						echo "Message successfully delivered to $a.<br>\n";
	
					}
	
					$z = 1;
	
				}
	
			}
	
			if ($z == 1) continue;
	
			if (!isuser($to))
				echo("User $to not found.<br>\n");
			//else if($to == $username)
				//echo "You cannot send mail to yourself.<br>\n";
	
			else if (strpos(getuser($to,"morons"),"$username:") !== false)
				echo "$to has blocked mail from you.<br>\n";
			else
			{
	
				$maildata = getuser($to,"mail");
	
				if ($topic == "") $topic = "(no subject)";
	
				$maildata .= "$username:::$topic:::$message:::0:~:";
	
				setuser($to,"mail",$maildata);
	
				echo "Message successfully delivered to $to.<br>\n";
	
			}
	
		}
	
	}

?>