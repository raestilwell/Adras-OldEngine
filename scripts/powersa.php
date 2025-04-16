<?
  if(strtolower($action3[0]) == "maket")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (getuser($bp,"admin") == 0)
    {
      setuser($bp,"admin","T");
      echo "$bp has become a level T admin.<br>\n";
    }
    else 
      echo "You can't change $bp's admin level.<br>\n";
  }
  else if(strtolower($action3[0]) == "taket")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    if (getuser($bp,"admin") == "T")
    {
      setuser($bp,"admin",0);
      echo "$bp has become a level 0 admin.<br>\n";
    }
    else 
      echo "You can't change $bp's admin level.<br>\n";
  }
  else if ($action3[0] == "+pflag")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $newval = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $newval .= $action3[$i];
      if ($i != count($action3) - 1) 
        $newval .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist.<BR>"); 
    else
    {
      setuser($bp,"flags",getuser($bp,"flags").$newval);
      echo "$bp now has the flag $newval.<br>\n";
    }
  }
  else if ($action3[0] == "-pflag")
  {
    $command = 1;
    $bp = ucwords(strtolower($action3[1]));
    $newval = "";
    for ($i = 2; $i < count($action3); $i++)
    {
      $newval .= $action3[$i];
      if ($i != count($action3) - 1) 
        $newval .= " ";
    }
    if (!isuser($bp)) 
      echo("$bp does not exist.<BR>"); 
    else
    {
      setuser($bp,"flags",str_replace($newval,"",getuser($bp,"flags").$newval));
      echo "$bp no longer has the flag $newval.<br>\n";
    }
  }
  else if ($action3[0] == "+lflag")
  {
    $command = 1;
    $coords = coords();
    $p = get("plane");
    $newval = $action3[1];
    $bpdata = getlevel($p,$coords,"flags");
    $bpdata .= $newval;
    setlevel($p,$coords,"flags",$bpdata);
    echo "Flag $newval added to level $coords $p.<br>\n";
  }
  else if ($action3[0] == "-lflag")
  {
    $command = 1;
    $coords = coords();
    $p = get("plane");
    $newval = $action3[1];
    $bpdata = getlevel($p,$coords,"flags");
    $bpdata = str_replace($newval,"",$bpdata);
    setlevel($p,$coords,"flags",$bpdata);
    echo "Flag $newval removed from level $coords.<br>\n";
  }
  else if ($action == "lflags")
  {
    $command = 1;
    $ld = getlevel(get("plane"),coords(),"flags");
    echo "$ld<br>\n";
  }
  else if(strtolower($action3[0]) == "tochat")
  {
    $command = 1;
    $foo = ucwords(strtolower($action3[1]));
    if (count($action3) < 2) 
      echo "Please specify a user.<br>\n"; 
    else if (!isuser($foo)) 
      echo "User $action3[1] does not exist.<br>\n"; 
    else
    {
      $bpdat = getuser($foo,"chat");
      $newval = "";
      for ($i = 2; $i < count($action3); $i++)
      {
        $newval .= $action3[$i];
        if ($i != count($action3) - 1) 
          $newval .= " ";
      }
      $bpdat .= "$newval<br>\n";
      setuser($foo,"chat",stripslashes($bpdat));
      setuser($foo,"newchat",1);
      echo "$foo's chat:<br>\n".phptripslashes($bpdat);
    }
  }
  else if (strtolower($action3[0]) == "pflags")
  {
    $command = 1;
    if (count($action3) < 2) 
      echo "Please specify a user.<br>"; 
    else if (!isuser(ucwords(strtolower($action3[1])))) 
      echo "User $action3[1] does not exist.<br>"; 
    else
    {
      $bpflag = getuser(ucwords(strtolower($action3[1])),"flags");
      echo "$bpflag<br>\n";
    }
  }
  else if (strtolower($action3[0]) === "newrace" && $admin != "R")
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
      setuser($bp,"race",$val);
      echo "$bp's race is now $val.<br>\n";
    }
  }
  else if (strtolower($action3[0])==="addfame"){
    $command = 1;
    $bp=ucwords(strtolower($action3[1]));
    if(isuser($bp))
    {
      setuser($bp,"fame",getuser($bp,"fame")+$action3[2]);
      echo "You have added ".$action3[2]." fame to $bp. New value: ".getuser($bp,"fame")."<br>\n";
    }
    else 
      echo "$bp does not exist.<br>\n";
  }
  else if($action == "editmemo")

  {

    $command = 1;

    $dat = stripslashes(getfile("memo"));

    echo "<center><form action=editfile.php method=post>
	<textarea name=dat rows=15 cols=100%>$dat</textarea><br>\n
	<input type=hidden name=username value=$username>\n
	<input type=hidden name=password value=$password>\n
	<input type=hidden name=dothis value=setmemo>\n
	<input type=hidden name=filename value=memo>\n
	<input type=submit value=Submit><BR>\n</form></center>";

  }
?>