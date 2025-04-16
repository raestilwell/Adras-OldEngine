<?
  if(strtolower($action3[0]) == "rpall")
    {
      $command = 1;
      $string = substr($action2,6)."<br>\n";
      $data = explode(":",getfile("online"));
      for ($i = 0; $i < count($data) - 1; $i++)
      {
        setuser($data[$i],"chat",getuser($data[$i],"chat").$string);
        setuser($data[$i],"newchat",1);
      } 
    }
?>