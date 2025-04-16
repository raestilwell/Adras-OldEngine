<?
  $command = 1;
  if (getlevel(get("plane"),coords(),"board") == "") 
    echo "There is no bulletin board here.<br>\n"; 
  else
  {
    $data = explode(":~:",getlevel(get("plane"),coords(),"board"));
    for ($j = 0; $j <= count($data); $j++)
    {
      $x = "";
      if ($admin == "&#9829;" || $admin == "X") 
        $x = " --- <a href=main.php?username=$username&password=$password&action=editpost+$j>Edit</a>";
      $thisdata = explode(":::",$data[$j]);
      if ($thisdata[0] == "") 
        continue;
      echo stripslashes($thisdata[0]) . " --- $thisdata[1]$x<br>\n" . stripslashes($thisdata[2]) . "\n<hr width=90%>\n";
    }
  }
?>