<?
$dothis = $_POST['dothis'] ?? '';


  if (strtolower($action3[0]) == "teleport")

  {

    $command = 1;

    if (strtolower($action3[1]) != "to")

    {

      $dest = explode("~",$action3[1]);

      $p = get("plane");
      if (count($action3) > 2)
 
        $p = strtolower($action3[2]);

      if (islevel($p,$action3[1]))
      {

        $x1 = get("x");

        $y1 = get("y");

        $z1 = get("z");

        $c1 = coords();

        $p1 = get("plane");

        $abc = 1;

        set("x",$dest[0]);

        set("y",$dest[1]);

        set("z",$dest[2]);

        set("plane",$p);

        if ($cloaked != 1)
 
          echo("You have teleported to $action3[1] on the $p plane.<br>\n");

      }

      else
 
        echo("Level $action3[1] not found on the $p plane. Teleportation failed.<br>\n");

    }

    else

    {

      $bp = ucwords(strtolower($action3[2]));

      if (isuser($bp))

      {

        $x1 = get("x");

        $y1 = get("y");

        $z1 = get("z");

        $c1 = coords();

        $p1 = get("plane");

        $abc = 1;

        set("x",getuser($bp,"x"));

        set("y",getuser($bp,"y"));

        set("z",getuser($bp,"z"));

        set("plane",getuser($bp,"plane"));

        echo "You have teleported to $action3[2] at ".coords()." on the ".get("plane")." plane.<br>\n";

      }

      else
 
        echo("Character $action3[2] not found. Teleportation failed.<br>\n");

    }

  }
  else if(strtolower($action3[0]) == "rp")
  {
    $command = 1;
    $string = substr($action2,3)."<br>\n";
    $data = explode(":",getlevel(get("plane"),coords(),"pcs"));
    for ($i = 0; $i < count($data) - 1; $i++)
    {
      setuser($data[$i],"chat",getuser($data[$i],"chat").$string);
      setuser($data[$i],"newchat",1);
    }
  }

  else if(strtolower($action3[0]) == "hide")

  {

    $command = 1;

    set("flags",get("flags")."(invis)");

    if (count($action3) > 1)
    {

      $action2 = "me " . substr($action2,5);

      $action = strtolower($action2);

      $action3 = explode(" ",$action2);

    }

  }

  else if(strtolower($action3[0]) == "appear")

  {

    $command = 1;

    set("flags",str_replace("(invis)","",get("flags")));

    if (count($action3) > 1)

    {

      $action2 = "me " . substr($action2,7);

      $action = strtolower($action2);

      $action3 = explode(" ",$action2);

    }

  }

  else if(strtolower($action3[0]) == "achat")

  {

    $command = 1;

    $message = substr($action2,6);

    $chars = explode(":",getfile("online"));

    set("chat",get("chat")."<b><font class=achat>You admin-chatted, \"$message\"</font></b><br>\n");

    $name = get("name");

    for ($i = 0; $i < count($chars) - 1; $i++)

    {

      $peep = $chars[$i];

      if ($peep == $username)
 
        continue;

      if (!is_numeric(getuser($peep,"admin"))||$peep==="Chron")

      {

        setuser($peep,"chat",getuser($peep,"chat")."<b><font class=achat>$name admin-chatted, \"$message\"</font></b><br>\n");

        setuser($peep,"newchat",1);

      }

    }

  }

  else if($action == "memo")

  {

    $command = 1;

    echo stripslashes(nl2br(getfile("memo")));

  }

  else if($dothis == "setmemo")

  {

    $memodata = $_POST['memodata'];

    setfile("memo",$memodata);

    echo "Memo updated.<br>\n";

  }

  else if(strtolower($action3[0]) == "ashout")

  {

    $command = 1;

    $string = "<b>".get("name")." announced, \"".phpubstr($action2,7)."\"</b><br>\n";

    $data = explode(":",getfile("online"));

    for ($i = 0; $i < count($data) - 1; $i++)

    {

      setuser($data[$i],"chat",getuser($data[$i],"chat").$string);

      setuser($data[$i],"newchat",1);

    }

  }

  else if(strtolower($action3[0])=="mapdis")

  {

    $command = 1;

    set("mapdis",$action3[1]);

  }

  else if(strtolower($action3[0]) === "summon")

  {

    $command = 1;

    $bp = ucwords(strtolower($action3[1]));
    $targ = isset($_POST['targ']) ? $_POST['targ'] : "no one";

    if (isuser($bp))

    {

      setlevel(getuser($bp,"plane"),getcoords($bp),"pcs",str_replace("$targ:","",getlevel(getuser($bp,"plane"),getcoords($bp),"pcs")));

      setuser($bp,"x",get("x"));

      setuser($bp,"y",get("y"));

      setuser($bp,"z",get("z"));

      setuser($bp,"plane",get("plane"));

      setlevel(getuser($bp,"plane"),getcoords($bp),"pcs",str_replace("$targ:","",getlevel(getuser($bp,"plane"),getcoords($bp),"pcs")));

      echo "$bp has been summoned to you at ".coords().".<br>\n";

    }

    else
 
      echo "$bp could not be found. Summon failed.<br>\n";

  }

?>