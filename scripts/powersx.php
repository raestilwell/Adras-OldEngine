<?

if(isset($_POST['whatever'])) {
    $whatever = $_POST['whatever'];
    // Use $whatever variable in your code here
} else {
    // Handle the case when 'whatever' is not set in $_POST
    $whatever = ''; // Assign a default value or perform other necessary actions
}


  if ($whatever == "Delete")
  {
  	$username = $_POST['username'];
  	$password = $_POST['password'];
	$plane = $_POST['plane'];
	for ($i = 0; $i <= count(levels($plane)); $i++)
	{
		$var = $_POST['a'.$i];
		if ($var == "on")
		{
			$var = $_POST['b'.$i];
			dellevel($plane,$var);
		}
	}
	echo "Levels deleted.<br>\n";
  }
  else if(strtolower($action3[0]) == "promote")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (isuser($bp))
    {
      setuser($bp,"admin",$action3[2]);
      echo "$bp has become a level $action3[2] admin.<br>\n";
    }
    else 
      echo "$bp does not exist.<br>\n";
  }
  else if(strtolower($action3[0]) == "check")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (isuser($bp)) 
      echo("$bp is a level ".getuser($bp,"admin")." admin.<br>\n"); 
    else 
      echo("$bp does not exist.");
  }
  else if ($action == "erase log")
  {
    echo("The log has been backed up and cleared.<br>\n");
  }
  else if (strtolower($action3[0]) == "seeplayer")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (!isuser($bp)) 
      echo("$bp does not exist.<BR>"); 
    else if (count($action3) > 2) 
      echo(getuser($bp,$action3[2]) . "<BR>"); 
    else 
      echo("$bpdata<BR>");
  }
  else if (strtolower($action3[0]) == "setplayer" && count($action3) > 2)
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $newval = "";
    for ($i = 3; $i < count($action3); $i++)
    {
      $newval .= $action3[$i];
      if ($i != count($action3) - 1) 
        $newval .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist.<BR>"); 
    else
    {
      $oldval = getuser($bp,$action3[2]);
      setuser($bp,$action3[2],$newval);
      echo("$bp value <i>$action3[2]</i> was $oldval and is now $newval.<br>\n");
    }
  }
  else if (strtolower($action3[0]) == "seelevel")
  {
    $command = 1;
    $data = getlevel(get("plane"),coords(),$action3[1]);
    echo stripslashes($data)."<br><br>\n\n";
  }
  else if (strtolower($action3[0]) == "setlevel")
  {
    $command = 1;
    $newval = "";
    $oldval = stripslashes(getlevel(get("plane"),coords(),$action3[1]));
    for ($i = 2; $i < count($action3); $i++)
    {
      $newval .= $action3[$i];
      if ($i != count($action3) - 1) 
        $newval .= " ";
    }
    setlevel(get("plane"),coords(),$action3[1],$newval);
    echo "$action3[1] was $oldval and is now $newval.<br><br>\n\n";
  }
  else if(strtolower($action3[0]) == "setlock")
  {
    $command = 1;
    if (count($action3) != 3) 
      echo "Incorrect format.<br>\n"; 
    else
    {
      $loc1 = $action3[1];
      $loc2 = $action3[2];
      $string = ":~:$loc1:$loc2";
      $data = getfile("locks");
      $data = explode(":~:",$data);
      $locknum = count($data);
      $data = implode(":~:",$data);
      $data .= $string;
      setfile("locks",$data);
      echo "Lock $locknum created between levels $loc1 and $loc2.<br>\n";
    }
  }
  else if(strtolower($action3[0]) == "seefile")
  {
    $command = 1;
    if (isfile($action3[1]))
    {
      $data = nl2br(getfile($action3[1]));
      echo "$data<br><br>\n\n";
    }
    else 
      echo "$action3[1] does not exist.<br>\n";
  }
  else if(strtolower($action3[0]) == "seeplane")
  {
    $command = 1;
    $p = $action3[1];
    $P = "";
    if ($p != get("plane")) 
      $P = " ".get("plane");
    $ls = levels($p);
    $j = count($ls);
    echo "<form action=main.php method=post>\n<table border=1>\n";
    for($i = 0; $i < $j; $i++)
    {
      $dat = getlevel($p,$ls[$i],"title");
      echo "<tr><td><input type=checkbox name=a$i><input type=hidden name=b$i value=\"$ls[$i]\"><input type=hidden name=plane value=\"$p\"></td><td><a href=\"main.php?username=$username&password=$password&action=teleport+$ls[$i]$P\" title=Teleport>$ls[$i]</a></td><td><a href=\"main.php?username=$username&password=$password&action=editlevel+$ls[$i]$P\" title=EditLevel>".phptripslashes($dat)."</a></td></tr>\n";
    }
    echo "<tr><td colspan=3>$j levels found.</td></tr>\n</table>\n<input type=hidden name=plane value=$p><input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=submit name=whatever value=Delete>\n</form>\n";
  }
  else if($action == "seeall coords")
  {
    $command = 1;
    echo "<table border=1>\n";
    $info = users();
    $num = count($info);
    for ($m = 0; $m < $num; $m++)
    {
      $peep = $info[$m];
      $dat = getuser($peep,"plane")." ".getcoords($peep);
      echo "<tr><td>$peep</td><td>$dat</td></tr>\n";
    }
    echo "<tr><td colspan=2>$num users.</td></tr>\n</table>\n";
  }
  else if(strtolower($action3[0]) == "seeall")
  {
    $command = 1;
    $i = $action3[1];
    $val = "";
    if (count($action3) > 2) 
      $val = substr($action,strlen($action3[1]) + 8);
    echo "<table border=1>\n";
    $l = 0;
    $info = users();
    $num = count($info);
    for ($m = 0; $m < $num; $m++)
    {
      $peep = $info[$m];
      $dat = getuser($peep,$i);
      if ($val == "" || strpos(strtolower($dat),$val) !== false)
      {
        echo "<tr><td>$peep</td><td>$dat</td></tr>\n";
	$l++;
      }
    }
    echo "<tr><td colspan=2>$num users.</td></tr>\n<tr><td colspan=2>$l matches.</td></tr>\n</table>\n";
  }
  else if(strtolower($action3[0]) == "editfile")
  {
    $command = 1;
    $filename = substr($action2,9);
    $dat = stripslashes(getfile($filename));
    echo "<form action=editfile.php method=post><center><textarea rows=20 cols=95% name=dat>$dat</textarea><br>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=hidden name=filename value=\"$filename\"><input type=submit value=\"Edit File\"></center></form>";
  }
  else if (strtolower($action3[0]) == "md5")
  {
    $command = 1;
    $word = substr($action2,4,strlen($action2)-4);
    echo "$word = ".md5($word);
  }
  //else if(strtolower($action3[0]) == "editstats")
//  {
//    $command = 1;
//    if (count($action3) < 2)
//    {
//      echo "Please specify a user.<br>";
//    }
//    else if (!isuser(ucwords(strtolower($action3[1]))))
//    {
//      echo "User $action3[1] does not exist.<br>";
//    }
//    else
//    {
//      $bpdat = explode(":~:",getstats(ucwords(strtolower($action3[1]))));
//      echo "<table border=1 style=text-align:center;><form action=elinon.php method=post><tr><td>Name</td><td><input name=username value=\"$bpdat[0]\"></td></tr><tr><td>Password</td><td>$bpdat[1]</td></tr><tr><td>Race</td><td><input name=race value=\"$bpdat[2]\"></td></tr><tr><td>Guild</td><td><input name=guild value=$bpdat[3]></td></tr><tr><td>Class</td><td><input name=class value=\"$bpdat[4]\"></td></tr><tr><td colspan=2><input type=submit value=Submit></td></tr></form></table>";
//    }
//  }
  else if (strtolower($action3[0]) == "ban" && count($action3) > 1)
  {
    $command = 1;
    $ip = $action3[1];
    $stuff = getfdata(".htaccess");
    $stuff .= "deny from $ip\n";
    $stream = fopen(".htaccess",w);
    fwrite($stream,$stuff);
    fclose($stream);
    echo "$ip banned.<br>";
  }
  else if (strtolower($action3[0]) == "unban" && count($action3) > 1)
  {
    $command = 1;
    $ip = $action3[1];
    $stuff = getfdata("../.htaccess");
    $stuff = str_replace("deny from $ip\n","",$stuff);
    $stream = fopen("../.htaccess",w);
    fwrite($stream,$stuff);
    fclose($stream);
    echo "$ip unbanned.<br>";
  }
  else if ($action == "inactive")
  {
    $command = 1;
    $now = time();
    $j = 0;
    $users = users();
    $rows = count($users);
    echo "<form method=post action=main.php method=post>\n";
    $k = 0;
    for ($i = 0; $i < $rows; $i++)
    {
      $user = $users[$i];
      if (is_numeric(getuser($user,"admin")) && ($now - getuser($user,"last_action")) > 2419200 && strpos(getuser($user,"flags"),"(nodel)") === false && strpos(getuser($user,"flags"),"(nodeltemp)") === false && (getuser($user,"fame") <= 10 || ($now - getuser($user,"last_action")) > 2419200))
      {
        echo "<input type=hidden name=n$i value=$user><input type=checkbox name=c$i>$user<br>\n";
        $j++;
        $meh .= "'$user', ";
        $k = $i;
      }
    }
    echo "<b>Total characters: $j</b><br>\n<input type=hidden name=action value=del><input type=hidden name=max value=$k>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password>\n<input type=submit value=\"Delete Selected Characters\">\n</form>\n";
  }
  else if (strtolower($action3[0]) == "deletechar")
  {
    for ($i = 1; $i < count($action3); $i++)
    {
      $user = ucwords(strtolower($action3[$i]));
      if (!isuser($user))
      {
        echo "$user does not exist.<br>\n";
        continue;
      }
      $command = 1;
      del($user);
      echo "$user deleted.<br>\n";
    }
  }
  else if ($action == "del")
  {
	$max = $_POST['max'];
	$command = 1;
	for ($i = 0; $i <= $max; $i++)
	{
		$var = $_POST['c'.$i];
		if($var == "on")
		{
			$var = $_POST['n'.$i];
			del($var);
			echo $var." deleted.<br>\n";
		}
	}
}
  else if (strtolower($action3[0]) == "dellevel")
  {
    for ($i = 1; $i < count($action3); $i++)
    {
      dellevel(get("plane"),$action3[$i]);
      echo "$action3[$i] deleted.<br>\n";
    }
  }
//  else if(strtolower($action3[0]) == "seeapps")
//  {
//	$command=1;
//	$x=apps(strtolower($action3[1]));
//	for($i=0;$x&&$i<count($x);$i++) echo "<a href=main.php?action=seeapp+$x[$i]&username=$username&password=$password>$x[$i]</a><br>\n";
//  }
//  else if(strtolower($action3[0]) == "seeapp" && isapp($action3[1]))
//  {
//    $command=1;
//    require("scripts/app.php");
//  }
  else if($action=="timelog")
  {
    $command=1;
    $timelog=explode("\n\n",getfile("timelog"));
    $timelog=explode("\n",$timelog[count($timelog)-1-$action3[1]]);
    $s=explode(":",$timelog[1]);
    $s=$s[1];
    $ls=explode(" ","&#9829; X A R W P M T");
    for($z=0;$z<count($ls);$z++)
    {
      echo "<br>\n<u>Level $ls[$z]</u><br>\n";
      $a=admin($ls[$z]);
      for($i=0;$a&&$i<count($a);$i++)
      {
	$t=0;
	$x=$s;
	for($j=2;$j<count($timelog);$j++)
	{
          $l=explode(":",$timelog[$j]);
          if($l[0]!=$a[$i])
            continue;
	  if($l[1]=="in"||$l[1]=="unidle")
	    $x=$l[2];
	  else 
	    $t+=$l[2]-$x;
        }
	$min = $t % 3600;
	$hou = ($t - $min) / 3600;
	$sec = $min % 60;
	$min = ($min - $sec) / 60;
	echo "$a[$i] - $hou hours, $min minutes, $sec seconds<br>\n";
      }
    }
  }
  else if ($action == "create board")
  {
    $command = 1;
    if (getlevel(get("plane"),coords(),"board") <> "") 
      echo "There is already a bulletin board here.<br>\n"; 
    else
    {
      $title = getlevel(get("plane"),coords(),"title");

      $thetime = date("l, F jS, Y - g:i A") . " MST";
      $thisdata = explode(":::",$data[$data[0]]);
      $thisdata[0] = get("name");
      $thisdata[1] = $thetime;
      $thisdata[2] = $title . " Bulletin Board.";
      $thisdata = implode(":::",$thisdata);

      setlevel(get("plane"),coords(),"board",$thisdata);
      echo "Message board has been created.<br>\n";
    }
  }
  else if ($action3[0] == "turnoff")
  {
	$channel = strtolower($action3[1]);
	setmute($channel,1);
        if ($channel != "ooc" || $channel != "chat")
        {
           echo "Channel not recognized.";
        }
        else
        {
	echo "Channel '$channel' status: Muted\n";
        }
	$command = 1;
  }
  else if ($action3[0] == "turnon"){
	$channel = strtolower($action3[1]);
	setmute($channel,0);
if ($channel != "ooc" || $channel != "chat")
        {
           echo "Channel not recognized.";
        }
        else
        {
	echo "Channel '$channel' status: Unmuted\n";
        }
	$command = 1;
  }
 else if (strtolower($action3[0]) === "editchar")
 {
     $command = 1;
 
     // Check if $action3 has at least 2 elements before accessing index 1
     if (isset($action3[1]) && $action3[1] != "")
     {
         $charname = ucfirst($action3[1]);
     }
     else
     {
         $charname = $username;
     }

	
	if (isuser($charname) == True)
	{
		
	//Gather information for Edit Character form.
	$charip = getuser($charname,"ip");
	$chardisp = getuser($charname,"name");
	$charadmin = getuser($charname,"admin");
	$charcreated = date("n/j/Y",getuser($charname,"created"));
	$charmuted = getuser($charname,"muted");
	$charmtime = getuser($charname,"mtime");
	$chardeafen = getuser($charname,"deaf");
	$chardtime = getuser($charname,"dtime");
	$chartitle = getuser($charname,"title");
	$charhometown = getuser($charname,"hometown");
	$charrace = getuser($charname,"race");
	$charrank = getuser($charname,"rank");
	$charclass = getuser($charname,"class");
	$chargender = getuser($charname,"gender");
	$chareyes = getuser($charname,"eyes");
	$charskin = getuser($charname,"skin");
	$charhair = getuser($charname,"hair");
	$charbuild = getuser($charname,"build");
	$charheight = getuser($charname,"height");
	$chardeity = getuser($charname,"deity");
	$charhead = getuser($charname,"head");
	$charears = getuser($charname,"ears");
	$charneck = getuser($charname,"neck");
	$charbody = getuser($charname,"body");
	$charlarm = getuser($charname,"larm");
	$charrarm = getuser($charname,"rarm");
	$charwrists = getuser($charname,"wrists");
	$charhands = getuser($charname,"hands");
	$charfinger = getuser($charname,"finger");
	$charlegs = getuser($charname,"legs");
	$charfeet = getuser($charname,"feet");
	$charpet = getuser($charname,"pet");
	$charweapon = getuser($charname,"weapon");
	$charrecall = getuser($charname,"recall");
	$charrecallplane = getuser($charname,"recallplane");
	$charquests = getuser($charname,"quests");
	$charpiety = getuser($charname,"piety");
	$charproficiency = getuser($charname,"proficiency");
	$charfamerank = getuser($charname,"famerank");
	$charclan = getuser($charname,"clan");
	$charguild = getuser($charname,"guild");
	$charmilitia = getuser($charname,"militia");
	$charx = getuser($charname,"x");
	$chary = getuser($charname,"y");
	$charz = getuser($charname,"z");
	$charplane = getuser($charname,"plane");
	$chardescription = getuser($charname,"description");
	$charflags = getuser($charname,"flags");
		
	//Call the form.
	require("scripts/editchar.php");
	}
	else
	{
		echo "Character $charname does not exist.";
	}
}
?>