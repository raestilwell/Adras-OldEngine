<?
  $garg = '';
  
  if (strtolower($action3[0]) == "nonlog" && ($admin == "X"))
  {
    $action2 = substr($action2,7);
    $action = strtolower($action2);
    $action3 = explode(" ",$action2);
  }
  else if($action == "quit" && $garg == "yes")
  {
  }
  else
  {
    $ldata = getfile("log");
    $ldata .= "$username::$action2<br>";
    setfile("log",$ldata);
    $bldata = "";
    $bldata = getfile("biglog");
    if(strlen($bldata) > 200000)
    {
      addlog($bldata);
      setfile("biglog","");
    }
    if (strlen($ldata) > 50000 || ($action == "erase log" && $admin == "X"))
    {
      $timedata = "<font size=+1><u>".date("l, F jS, Y")."</u></font><br>";
      $bldata .= "$timedata$ldata";
      setfile("biglog",$bldata);
      setfile("log","");
    }
  }
?>