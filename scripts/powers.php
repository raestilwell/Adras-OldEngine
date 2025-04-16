<?php

  if ($action === "log")
  {
    $command = 1;
    $logdata = stripslashes(getfile("log"));
    echo "<u>The Log</u><br>\n<font size=-1>$logdata</font><br>";
  }
  else if (strtolower($action3[0]) === "giantlog")
  {
    $command = 1;
    $key = stripslashes(substr($action2,9));
    $logdata = stripslashes(searchlog($key));
    echo "<u>The GIANT Log</u><br>\n<font size=-1>$logdata</font><br>";
  }
  else if (strtolower($action3[0]) === "biglog")
  {
    $command = 1;
    $logdata = stripslashes(getfile("biglog"));
    echo "<u>The BIG Log</u><br><font size=-1>$logdata</font><br>";
  }
  else if($action === "loginmessage")
  {
    $command = 1;
    $dat = stripslashes(getfile("login"));
    echo "<form action=editlogin.php method=post>\n<center><textarea rows=10 cols=95% name=dat>" . str_replace("<br />","",$dat) . "</textarea><br>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=submit value=\"Edit File\"></center></form>";
  }
  else if (strtolower($action3[0]) === "find")
  {
    $command = 1;
    $peep = ucwords(strtolower($action3[1]));
    if (isuser($peep)) 
      echo stripslashes(getuser($peep,"name"))." is at ".getcoords($peep).".<br>\n"; 
    else 
      echo "$peep does not exist.<br>\n";
  }
  else if (strtolower($action3[0]) === "checkip"){
    $command = 1;
    $ip = $action3[1];
    $data = getlogins(0,$ip);
    echo "<u>The following characters have been logged on from $ip</u><br>\n";
    for ($i = 0; $i < count($data); $i++)
      echo $data[$i][0]."<br>\n";
  }
  else if (strtolower($action3[0]) === "checkchar"){
    $command = 1;
    $ip = $action3[1];
    $data = getlogins(ucwords(strtolower($ip)));
    echo "<u>$ip has been logged on from the following IPs</u><br>\n";
    for($i=0;$i<count($data);$i++)
      echo $data[$i][2]."<br>\n";
    echo "For a total of ".count($data)." logins<br>\n";
  }
  else if (strtolower($action3[0]) === "crosscheck"){
    $nox = getfile("noxcheck");
    $command = 1;
    $char = $action3[1];
    $ips = "";
    $chars = "";
    $data = getlogins(ucwords(strtolower($char)));
    echo "<u>Crosschecking ".ucwords(strtolower($char))."</u><br>";
    for ($i = 0; $i < count($data); $i++)
    {
      $dat = $data[$i];
      if (strpos($ips,"(".phptrtolower($dat[2]).")") === false) $ips .= "(".phptrtolower($dat[2]).")";
    }
    $j = 0;
    $data = getlogins();
    for ($i = 0; $i < count($data); $i++)
    {
      $dat = $data[$i];
      if ($dat[0] != "" && is_numeric(strpos($nox,$dat[0]))) 
        continue;
      if (strtolower($dat[0]) != strtolower($char) && strpos($chars,"(".phptrtolower($dat[0]).")") === false && strpos($ips,"(".phptrtolower($dat[2]).")") !== false)
      {
        if (isuser($dat[0])) 
          $thingy = "<font color=blue>exists</font>";
        else 
          $thingy = "<font color=red><s>exists</s></font>";
        $chars .= "(".phptrtolower($dat[0]).")";
        echo "$dat[0]::$dat[2] $thingy<br>\n";
        $j++;
      }
    }
    echo "$j matches.<br>\n";
  }
  else if (strtolower($action3[0]) === "mute"){
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (isuser($bp))
    {
      $len = 0;
      if (is_numeric($action3[2])) 
        $len = time()+$action3[2]*60;
      $len .= "";
      setuser($bp,"muted",1);
      setuser($bp,"mtime",$len);
      if ($len == 0) 
        echo "$bp has been muted.<br>\n"; 
      else 
        echo "$bp has been muted for $action3[2] minutes.<br>\n";
    }
    else 
      echo "$action3[1] was not found. Mute failed.<br>\n";
  }
  else if(strtolower($action3[0]) === "unmute")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (isuser($bp))
    {
      setuser($bp,"muted",0);
      setuser($bp,"mtime","0");
      echo "$bp has been unmuted.<br>\n";
    }
    else 
      echo("$action3[1] was not found. Unmute failed.<br>\n");
  }
  else if(strtolower($action3[0]) === "title")
  {
	$command = 1;
	$bp = ucwords(strtolower($action3[1]));
	$title = "";
	for ($i = 2; $i < count($action3); $i++){
		$title .= $action3[$i];
		if ($i != count($action3) - 1) $title .= " ";
	}
	if (isuser($bp))
	{
		setuser($bp,"title",$title);
		echo "The title for $bp has been changed to $title.<br>\n";
	}
	else echo("$action3[1] was not found. Title change failed.<br>\n");
  }
  else if(strtolower($action3[0]) === "cleartitle")
{
	$command = 1;
	$bp = ucwords(strtolower($action3[1]));
	$title = "";
	if (isuser($bp)){
		setuser($bp,"title",$title);
		echo "The title for $bp has been cleared.<br>\n";
	}else echo("$action3[1] was not found. Title clearing has failed.<br>\n");
}
  else if (strtolower($action3[0]) === "watch")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $spydata = stripslashes(getuser($bp,"chat"));
    if ($spydata != "") 
      echo("<u>$action3[1]'s Chat</u><br>\n$spydata<br>\n"); 
    else 
      echo("$action3[1] doesn't have any chat, and probably isn't online. Watch failed.<br>\n");
  }
  else if (strtolower($action3[0]) === "warp")
  {
    $command = 1;
    $targ = ucwords(strtolower($action3[1]));
    if (isuser($targ))
    {
      $p = "";
      if (strtolower($action3[2]) != "to")
      {
        $dest = explode("~",$action3[2]);
        $p = get("plane");
        $c = $action3[2];
        if (!empty($action3[3])) 
          $p = $action3[3];
        if (!islevel($p,$c)) 
          echo "Level $action3[2] not found. Warp failed.<br>\n";
      }
      else
      {
        $bp = ucwords(strtolower($action3[3]));
        if (isuser($bp))
        {
          $dest[0] = getuser($bp,"x");
          $dest[1] = getuser($bp,"y");
          $dest[2] = getuser($bp,"z");
          $p = getuser($bp,"plane");
          $c = "$dest[0]~$dest[1]~$dest[2]";
        }
        else 
          echo("Destination character $action3[3] not found. Warp failed.<BR>");
      }
      if (!islevel($p,$c)) 
        echo "Level $p $c not found. Warp failed.<br>\n"; 
      else
      {
        $tp = getuser($targ,"plane");
        setlevel(getuser($targ,"plane"),getcoords($targ),"pcs",str_replace("$targ:","",getlevel(getuser($targ,"plane"),getcoords($targ),"pcs")));
        setuser($targ,"x",$dest[0]);
        setuser($targ,"y",$dest[1]);
        setuser($targ,"z",$dest[2]);
        setuser($targ,"plane",$p);
        setlevel(getuser($targ,"plane"),getcoords($targ),"pcs",str_replace("$targ:","",getlevel(getuser($targ,"plane"),getcoords($targ),"pcs")));
        if ($bp != "") 
          echo "$targ has been warped to $bp at $dest[0]~$dest[1]~$dest[2].<br>\n"; 
        else 
          echo "$targ has been warped to $dest[0]~$dest[1]~$dest[2].<br>\n";
      }
    }
    else echo "Target character $action3[1] not found. Warp failed.<br>\n";
  }
  else if (strtolower($action3[0]) === "freeze")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (getuser($bp,"admin") != "X" && getuser($bp,"admin") != "&#9829;")
    {
      setuser($bp,"frozen",1);
      echo "$bp has been frozen.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "unfreeze")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    setuser($bp,"frozen",0);
    echo "$bp has been unfrozen.<br>\n";
  }
  else if (strtolower($action3[0]) === "deafen")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (isuser($bp))
    {
      $len = 0;
      if (is_numeric($action3[2])) 
        $len = time()+$action3[2]*60;
      $len .= "";
      setuser($bp,"deaf",1);
      setuser($bp,"dtime",$len);
      if ($len == 0) 
        echo "$bp has been deafened.<br>\n"; 
      else 
        echo "$bp has been deafened for $action3[2] minutes.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "undeafen")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (isuser($bp))
    {
      setuser($bp,"deaf",0);
      setuser($bp,"dtime","0");
      echo "$bp has been undeafened.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "glitch")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (getuser($bp,"admin") != "X" && getuser($bp,"admin") != "&#9829;")
    {
      setuser($bp,"password","#".getuser($bp,"password")."#");
      echo "$bp has been glitched.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "unglitch")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    setuser($bp,"password",str_replace("#","",getuser($bp,"password")));
    echo "$bp has been unglitched.<br>\n";
  }
  else if (strtolower($action3[0]) === "pose")
  {
    $bp = ucwords(strtolower($action3[1]));
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      if (getuser($bp,"admin") != "X" || get("admin") === "X" || getuser($bp,"admin") != "&#9829;")
      {
        $username = $bp;
        for ($i = 2; $i < count($action3); $i++)
        {
          $temp .= "$action3[$i]";
          if ($i != count($action3)-1)
            $temp .= " ";
        }
        $action2 = $temp;
        $action = strtolower($action2);
        $action3 = explode(" ",$action2);
        echo "You have posed as $username.<br>";
      }
    }
  }
  else if (strtolower($action3[0]) === "newguild")
  {
    $command = 1;
    $peep = ucwords(strtolower($action3[1]));
    $org = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $org .= $action3[$i];
      if ($i != count($action3) - 1) 
        $org .= " ";
    }
    $org = stripslashes($org);
    if (!isuser($peep)) {
        echo "$peep does not exist.<br>\n"; 
    } else if (isorg($org)) {
        echo "An organization with that name already exists.<br>\n"; 
    } else {
        if (getuser($peep, "guild") != "") {
            echo getuser($peep, "name") . " is already a member of " . stripslashes(getuser($peep, "guild")) . ".<br>\n"; 
        } else {
            setuser($peep, "guild", $org);
            $org = str_replace("'", "&#39;", $org);
    
            // Using your existing dbconnect() function
            $dbh = dbconnect();
            mysqli_select_db($dbh, "adras_database");
    
            $query = "INSERT INTO orgs (name, type, owners) VALUES ('$org', 'g', '$peep')";
            mysqli_query($dbh, $query);
    
            mysqli_close($dbh);
    
            echo getuser($peep, "name") . " is now the owner of $org.<br>\n";
        }
    }
}
  else if (strtolower($action3[0]) === "newmilitia")
  {
    $command = 1;
    $peep = ucwords(strtolower($action3[1]));
    $org = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $org .= $action3[$i];
      if ($i != count($action3) - 1) 
      $org .= " ";
    }
    $org = stripslashes($org);
    if (!isuser($peep)) {
        echo "$peep does not exist.<br>\n"; 
    } else if (isorg($org)) {
        echo "An organization with that name already exists.<br>\n"; 
    } else {
        if (getuser($peep, "militia") != "") {
            echo getuser($peep, "name") . " is already a member of " . stripslashes(getuser($peep, "militia")) . ".<br>\n"; 
        } else {
            setuser($peep, "militia", $org);
            $org = str_replace("'", "&#39;", $org);
    
            // Using your existing dbconnect() function
            $dbh = dbconnect();
            mysqli_select_db($dbh, "adras_database");
    
            $query = "INSERT INTO orgs (name, type, owners) VALUES ('$org', 'm', '$peep')";
            mysqli_query($dbh, $query);
    
            mysqli_close($dbh);
    
            echo getuser($peep, "name") . " is now the owner of $org.<br>\n";
        }
    }
}
  else if (strtolower($action3[0]) === "newclan")
  {
    $command = 1;
    $peep = ucwords(strtolower($action3[1]));
    $org = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $org .= $action3[$i];
      if ($i != count($action3) - 1) 
        $org .= " ";
    }
   $org = stripslashes($org);
   if (!isuser($peep)) {
       echo "$peep does not exist.<br>\n"; 
   } else if (isorg($org)) {
       echo "An organization with that name already exists.<br>\n"; 
   } else {
       if (getuser($peep, "clan") != "") {
           echo getuser($peep, "name") . " is already a member of " . stripslashes(getuser($peep, "clan")) . ".<br>\n"; 
       } else {
           setuser($peep, "clan", $org);
           $org = str_replace("'", "&#39;", $org);
   
           // Using your existing dbconnect() function
           $dbh = dbconnect();
           mysqli_select_db($dbh, "adras_database");
   
           $query = "INSERT INTO orgs (name, type, owners) VALUES ('$org', 'c', '$peep')";
           mysqli_query($dbh, $query);
   
           mysqli_close($dbh);
   
           echo getuser($peep, "name") . " is now the owner of $org.<br>\n";
       }
   }
}
  else if (strtolower($action3[0]) === "seeorg")
  {
    $command = 1;
    $org = stripslashes(substr($action2,7));
    if (isorg($org))
    {
      echo "<table border=1>\n<tr><td colspan=2>$org</td></tr>\n<tr><td>NAME</td><td>RANK</td></tr>\n<tr><td></td><td></td></tr>\n";
      $data = explode(":",getorg($org,"owners"));
      for ($i = 0; $i < count($data) - 1; $i++)
      {
        $rank = "<b><u>owner</u></b>";
        if (!isuser($data[$i])) 
          $rank = "deleted";
        echo "<tr><td>$data[$i]</td><td>$rank</td></tr>\n";
      }
      $data = explode(":",getorg($org,"leaders"));
      for ($i = 0; $i < count($data) - 1; $i++)
      {
        $rank = "<b>leader</b>";
        if (!isuser($data[$i])) 
          $rank = "deleted";
        echo "<tr><td>$data[$i]</td><td>$rank</td></tr>\n";
      }
      $data = explode(":",getorg($org,"officers"));
      for ($i = 0; $i < count($data) - 1; $i++)
      {
        $rank = "<u>officer</u>";
        if (!isuser($data[$i])) 
          $rank = "deleted";
        echo "<tr><td>$data[$i]</td><td>$rank</td></tr>\n";
      }
      $data = explode(":",getorg($org,"members"));
      for ($i = 0; $i < count($data) - 1; $i++)
      {
        $rank = "<i>member</i>";
        if (!isuser($data[$i])) 
          $rank = "deleted";
        echo "<tr><td>$data[$i]</td><td>$rank</td></tr>\n";
      }
      $data = explode(":",getorg($org,"parole"));
      for ($i = 0; $i < count($data) - 1; $i++)
      {
        $rank = "on parole";
        if (!isuser($data[$i])) 
          $rank = "deleted";
        echo "<tr><td>$data[$i]</td><td>$rank</td></tr>\n";
      }
      echo "</table>\n";
    }
    else echo "$org is not an organization.<br>\n";
  }
 else if ($action === "seeguilds" || $action === "seeclans" || $action === "seemilitias") {
     $command = 1;
     switch ($action) {
         case "seeguilds":
             echo "<u>Guilds</u><br>\n";
             $orgs = orgs("g");
             $org = "guild";
             break;
         case "seeclans":
             echo "<u>Clans</u><br>\n";
             $orgs = orgs("c");
             $org = "clan";
             break;
         case "seemilitias":
             echo "<u>Militias</u><br>\n";
             $orgs = orgs("m");
             $org = "militia";
     }
     
     if (!empty($orgs)) {
         foreach ($orgs as $orgName) {
             echo $orgName . "<br>\n";
         }
     } else {
         echo "No " . $org . "s.<br>\n";
     }
 }

  else if (strtolower($action3[0]) === "rename")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"name",$val);
      echo "$bp has been renamed $val.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newclass")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"class",$val);
      echo "$bp's class is now $val.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newrank")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"rank",$val);
      echo "$bp's rank is now $val.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "neweyes")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"eyes",$val);
      echo "$bp now have $val eyes.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newhair")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"hair",$val);
      echo "$bp now has $val hair.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newskin")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"skin",$val);
      echo "$bp now has $val skin.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newbuild")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"build",$val);
      echo "$bp's build is now $val.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newheight")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist."); 
    else
    {
      setuser($bp,"height",$val);
      echo "$bp's height is now $val.<br>\n";
    }
  }
  else if($action3[0] === "wed")
  {
    $command = 1;
    $wed1 = ucwords(strtolower($action3[1]));
    $wed2 = ucwords(strtolower($action3[2]));
    if (!isuser($wed1) || !isuser($wed2)) 
      echo "Somebody doesn't exist...<br>\n"; 
    else
    {
      setuser($wed1,"spouse",$wed2);
      setuser($wed2,"spouse",$wed1);
      echo "$wed1 and $wed2 are now married.<br>\n";
    }
  }
  else if($action3[0] === "unwed"){
    $command = 1;
    for ($i = 1; $i < count($action3); $i++)
    {
      $wed = ucwords(strtolower($action3[$i]));
      if (isuser($wed)) 
        setuser($wed,"spouse","none"); 
      else 
        echo $wed . " does not exist.<br>\n";
    }
  }
  else if($action === "editnpcs"){
    $command = 1;
    $npcs = getlevel(get("plane"),coords(),"npcs");
    echo "<center>One NPC per line, please.<form action=editnpcs.php method=post>\n<textarea name=npcs rows=10 cols=95%>$npcs</textarea><br>\n<input type=hidden name=username value=$username><input TYPE=hidden name=password value=$password><input type=submit value=\"Edit NPCs\"></form></center>\n";
  }
  else if($action === "seelocks")
  {
    $command = 1;
    $data = getfile("locks");
    $data = explode(":~:",$data);
    for ($i = 1; $i < count($data); $i++)
    {
      $locs = explode(":",$data[$i]);
      $loc1 = explode(" ",$locs[0]);
      $loc2 = explode(" ",$locs[1]);
      $loc1titl = getlevel($loc1[1],$loc1[0],"title");
      $loc2titl = getlevel($loc2[1],$loc2[0],"title");
      echo stripslashes("Lock $i: $loc1titl, $loc1[0]; $loc2titl $loc2[0]<br>\n");
    }
  }
  else if (strtolower($action3[0]) === "giveroom")
  {
    $command = 1;
    $peep = ucwords(strtolower($action3[1]));
    if (isuser($peep))
    {
      setlevel(get("plane"),coords(),"flags",getlevel(get("plane"),coords(),"flags")."($peep)");
      echo "This room can now be edited by $peep.<br>\n";
    }
    else 
      echo "$peep does not exist.<br>\n";
  }
  else if (strtolower($action3[0]) === "editlock")
  {
    $command = 1;
    $locknum = $action3[1];
    $coord1 = $action3[2];
    $coord2 = $action3[3];
    $lockdat = explode(":~:",getfile("locks"));
    $lockdat[$locknum] = "$coord1:$coord2";
    $lockdat = implode(":~:",$lockdat);
    setfile("locks",$lockdat);
    echo "Lock $locknum successfully edited. Levels: $coord1 $coord2<br>\n";
  }
  else if (strtolower($action3[0]) === "makelock"){
    $command = 1;
    $loc1 = coords();
    $loc2 = explode("~",$loc1);
    switch(strtolower($action3[1]))
    {
      case "n":
        $loc2[1]++;
        break;
      case "s":
        $loc2[1]--;
        break;
     case "w":
        $loc2[0]--;
        break;
     case "e":
        $loc2[0]++;
        break;
     case "u":
        $loc2[2]++;
        break;
     case "d":
        $loc2[2]--;
    }
    $loc2 = implode("~",$loc2);
    if ($loc2 != $loc1)
    {
      $plane = get("plane");
      $string = ":~:$loc1 $plane:$loc2 $plane";
      setfile("locks",getfile("locks").$string);
      echo "Lock created between levels $loc1 and $loc2.<br>\n";
    }
    else 
      echo "Syntax error.<br>\n";
  }
  else if (strtolower($action3[0] === "givekey"))
  {
    $command = 1;
    $peep = ucwords(strtolower($action3[1]));
    if (isuser($peep))
    {
      $keynum = $action3[2];
      $keydat = setuser($peep,"flags",getuser($peep,"flags")."(key$keynum)");
      echo "$peep now has key #$keynum.<BR>";
    }
    else 
      echo "$peep does not exist.<br>\n";
  }
  else if (strtolower($action3[0]) === "editbot")
  {
    $command = 1;
    $botname = strtolower(ucwords($action3[1]));
    $dat = getbot($botname);
    echo "You are editing $action3[1].<br><form action=editbot.php method=post><center>Put the bot's name on the first line.<br>Each subsequent line should have the bot's action.<br><textarea rows=10 cols=95% name=dat>$dat</textarea><br><input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=hidden name=botname value=\"$botname\"><input type=submit value=\"Edit Bot\"></center></form>";
  }
  else if ($action === "script on")
  {
    $command = 1;
    setlevel(get("plane"),coords(),"flags",getlevel(get("plane"),coords(),"flags")."(script)");
    echo "Scripts are now <u>on</u>.<br>\n";
  }
  else if ($action === "script off")
  {
    $command = 1;
    setlevel(get("plane"),coords(),"flags",str_replace("(script)","",getlevel(get("plane"),coords(),"flags")));
    echo "Scripts are now <u>off</u>.<br>\n";
  }
  else if ($action === "script")
  {
    $command = 1;
    if (strpos(getlevel(get("plane"),coords(),"flags"),"(script)") === false) 
      echo "Scripts are currently <u>off</u>.<br>\n"; 
    else 
      echo "Scripts are currently <u>on</u>.<br>\n";
  }
  else if(strtolower($action3[0]) === "editscript")
  {
    $command = 1;
    $c = coords();
    $p = get("plane");
    $dat = getlevel(get("plane"),coords(),"script");
    echo "<form action=editscript.php method=post><center><textarea rows=10 cols=95% name=dat>$dat</textarea><br><input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=submit value=\"Edit Script\"></center></form>";
  }
  else if($action === "genmap")
  {
    $command = 1;
    $xl = 0;
    $xh = 0;
    $yl = 0;
    $yh = 0;
    $ls = levels(get("plane"));
    for ($i = 0; $i < count($ls); $i++)
    {
      $file = explode("~",$ls[$i]);
      if (is_numeric($file[0]) && is_numeric($file[1]) && is_numeric($file[2]) && $file[2] > -25 && $file[2] < 25)
      {
        if ($xl > $file[0]) 
          $xl = $file[0];
        if ($xh < $file[0]) 
          $xh = $file[0];
        if ($yl > $file[1]) 
          $yl = $file[1];
        if ($yh < $file[1]) 
          $yh = $file[1];
      }
    }
    $xm = $xh - $xl;
    $ym = $yh - $yl;
    $xa = "";
    for ($i = 0; $i < $xm; $i++) 
      $xa .= ":";
    $ya = $xa;
    for ($i = 0; $i < $ym; $i++) 
      $ya .= ":~:$xa";
    $arr = explode(":~:",$ya);
    for ($i = 0; $i < count($arr); $i++) 
      $arr[$i] = explode(":",$arr[$i]);
    for ($i = 0; $i < count($arr); $i++) 
      for ($j = 0; $j < count($arr[0]); $j++) 
        $arr[$i][$j] = "000000";
    for ($i = 0; $i < count($ls); $i++)
    {
      $file = explode("~",$ls[$i]);
      if (is_numeric($file[0]) && is_numeric($file[1]) && is_numeric($file[2]) && $file[2] > -25 && $file[2] < 25)
      {
        if ($file[2] < 0)
        {
          $arr[$file[1]-$yl][$file[0]-$xl][4] = "F";
          $arr[$file[1]-$yl][$file[0]-$xl][5] = "F";
        }
        else if ($file[2] > 0)
        {
          $arr[$file[1]-$yl][$file[0]-$xl][2] = "F";
          $arr[$file[1]-$yl][$file[0]-$xl][3] = "F";
        }
        else
        {
          $arr[$file[1]-$yl][$file[0]-$xl][0] = "F";
          $arr[$file[1]-$yl][$file[0]-$xl][1] = "F";
        }
      }
    }
    echo "<table bgcolor=#000000>\n";
    for ($i = count($arr) - 1; $i >= 0; $i--)
    {
      echo "<tr>";
      for ($j = 0; $j < count($arr[0]); $j++)
      {
        echo "<td bgcolor=#".$arr[$i][$j]." cellpadding=10 title=\"".($j+$xl)."~".($i+$yl)."\"> </td>";
      }
      echo "</tr>\n";
    }
    echo "<tr><td colspan=$xm><font color=#FF0000>Ground Level</td></tr>\n";
    echo "<tr><td colspan=$xm><font color=#00FF00>Above Ground</td></tr>\n";
    echo "<tr><td colspan=$xm><font color=#0000FF>Below Ground</td></tr>\n";
    echo "<tr><td colspan=$xm><font color=#FFFF00>Ground and Above</td></tr>\n";
    echo "<tr><td colspan=$xm><font color=#FF00FF>Ground and Below</td></tr>\n";
    echo "<tr><td colspan=$xm><font color=#00FFFF>Above and Below</td></tr>\n";
    echo "<tr><td colspan=$xm><font color=#FFFFFF>All Three</td></tr>\n";
    echo "</table>\n";
    echo "X: $xl - $xh<br>\n";
    echo "Y: $yl - $yh<br>\n";
  }
  else if (strtolower($action3[0]) == "seebirth")
  {
    $command = 1;
    $char = ucwords(strtolower($action3[1]));
    if (!isuser($char)) 
      echo "$char does not exist.<br>\n"; 
    else
    {
      $string = date("l, n/j/Y",getuser($char,"created"));
      echo "$char was created on $string.<br>\n";
    }
  }
  else if (strtolower($action3[0]) == "seelogin"){
    $command = 1;
    $char = ucwords(strtolower($action3[1]));
    if (!isuser($char)) 
      echo "$char does not exist.<br>\n"; 
    else
    {
      $string = date("l, n/j/Y",getuser($char,"created"));
      $time = time() - getuser($char,"last_login");
      for ($h = 0;$time >= 3600;$time -= 3600) 
        $h++;
      for ($m = 0;$time >= 60;$time -= 60) 
        $m++;
      $d = ($h-($h%24))/24;
      $h %= 24;
      echo "$char last logged in $d days, $h hours, $m minutes, and $time seconds ago.<br>\n";
    }
  }
  else if ($action == "showwho")
  {
    $command = 1;
    set("flags",str_replace("(nowho)","",get("flags")));
  }
  else if ($action == "nowho"){
    $command = 1;
    set("flags",get("flags")."(nowho)");
  }
  else if($action == "noxcheck" && ($admin == "X" || $admin[0] == "&" || $admin == "A" || $username == "Laanshor"))
  {
    $command = 1;
    $filename = "noxcheck";
    $dat = stripslashes(getfile($filename));
    echo "<form action=editfile.php method=post><center><textarea rows=10 cols=95% name=dat>$dat</textarea><br>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=hidden name=filename value=\"$filename\"><input type=submit value=\"Edit File\"></center></form>";
  }
  else if ($action == "rapsheet")
  {
	require("scripts/rapsheet.php");
	$command = 1;
	$raps = numraps();
	echo "<table>\n<tr><td><u>Offender</u></td><td><u>Offense</u></td><td><u>Action Taken</u></td><td><u>Date</u></td><td><u>Admin</u></td></tr>\n";
	for ($i = 0; $i <= $raps; $i++){
		echo "<tr><td>".rap($i,"offender")."</td><td>".rap($i,"offense")."</td><td>".rap($i,"action")."</td><td>".rap($i,"date")."</td><td>".rap($i,"admin")."</td></tr>\n";
	}
	echo "<form action=rapsheet.php method=post><tr><td><input name=offender></td><td><input name=offense size=75></td><td><input name=act size=75></td><td><input type=submit name=action value=\"Add New\"></td><td>$username</td></tr><input type=hidden name=username value=$username><input type=hidden name=password value=$password></form>\n</table>\n";
  }
  else if(strtolower($action3[0]) == "rpinfo")
  {
    $command = 1;
    $filename = "rpinfo";
    $dat = stripslashes(getfile($filename));
    echo "<form action=editfile.php method=post><center><textarea rows=10 cols=95% name=dat>$dat</textarea><br>\n<input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=hidden name=filename value=\"$filename\"><input type=submit value=\"Edit File\"></center></form>";
  }
  else if(strtolower($action3[0])=="unflag")
  {
    $command=1;
    $targ=ucwords(strtolower($action3[1]));
    if(!isuser($targ)) 
      echo "$targ does not exist.<br>\n";
    else
    {
      setuser($targ,"newbie",0);
      echo "$targ is no longer flagged as a newbie.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "setweapon")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $val = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $val .= $action3[$i];
      if ($i != count($action3) - 1) 
        $val .= " ";
    }
    if (!isuser($bp)) 
      echo "$bp does not exist."; 
    else
    {
      setuser($bp,"weapon",$val);
      echo "$bp's weapon is now <i>$val</i>.<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newbot2")
  {
    $command = 1;
    $bn = stripslashes(strtolower($action3[1]));
    if (!isbot2($bn))
    {
      newbot2($bn,get("x"),get("y"),get("z"),get("plane"));
      echo "New Bot2 named <i>$bn</i> created at your location. The Bot2's location can be changed via the <i>editbot2</i> command.<br>\n";
    }
    else 
      echo "A Bot2 named <i>$bn</i> already exists. Please choose another name.<br>\n";
  }
  else if (strtolower($action3[0]) === "delbot2")
  {
    $command = 1;
    $bn = stripslashes(strtolower($action3[1]));
    if (isbot2($bn))
    {
      delbot2($bn);
      echo "The Bot2 named <i>$bn</i> has been deleted.<br>\n";
    }
    else 
      echo "No Bot2 named <i>$bn</i> exists. Deletion failed.<br>\n";
  }
  else if (strtolower($action3[0]) === "editbot2")
  {
    $command = 1;
    $bn = stripslashes(strtolower($action3[1]));
    if (isbot2($bn))
    {
      $bot2data = getbot2($bn);
      $bot2x = $bot2data[1];
      $bot2y = $bot2data[2];
      $bot2z = $bot2data[3];
      $bot2p = $bot2data[4];
      $bot2d = $bot2data[5];
      $bot2a = $bot2data[6];
      if($bot2a=="y")
        $bot2a=" checked=checked";
      else 
        $bot2a="";
      echo "<form action=editbot2.php method=post>\n<table><tr><td>Name:</td><td><input type=text readonly name=name value=$bn></td></tr>\n<tr><td>X:</td><td><input type=text name=x value=$bot2x></td></tr><tr><td>Y:</td><td><input type=text name=y value=$bot2y></td></tr><tr><td>Z:</td><td><input type=text name=z value=$bot2z></td></tr><tr><td>Plane:</td><td><input type=text name=p value=$bot2p></td></tr>";
      echo "<tr><td>Auto:</td><td><input name=auto type=checkbox$bot2a></td></tr><tr><td>Data:</td><td><textarea cols=100% rows=20 name=data>$bot2d</textarea></td></tr><tr><td colspan=2><input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=submit value=\"Edit Bot2\"></td></tr></table></form>\n\n";
    }
    else 
      echo "No Bot2 named <i>$bn</i> exists. Edit failed.<br>\n";
  }
?>