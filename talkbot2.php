<?
   //pass username, password, name (meaning the Bot2's name)
  require("scripts/function.php");
  require("scripts/verify.php");
  require("scripts/style.php");
  $uname=ucwords(strtolower($name));
  if (!isbot2here($name))
    echo "You don't see <i>$uname</i> here.<br>\n";
  else
  {
	if (!$word)
	  $word="look";
	else
	  $word = strtolower($word);
	$bd=getbot2($name);
	$bd=explode("@",$bd[5]);
	$y="";
	for($x=1;$x<count($bd);$x+=2)
	{
	  if(strtolower($bd[$x])==$word)
	  {
	    $y=$bd[$x+1];
	    break;
	  }
	  else if(strtolower($bd[$x])=="_")
	    $y=$bd[$x+1];
	}
	$y=nl2br($y);
	echo "<h2 align=center>$uname</h2>$y<br><br>\n<form name=bot2form action=talkbot2.php method=post><input type=hidden name=username value=$username><input type=hidden name=password value=$password><input type=hidden name=name value=$name>Say: <input type=text name=word id=word><input type=submit value=Submit></form><br><br>Hint: All Bot2's should respond to <i>name</i>, <i>job</i>, and <i>look</i>.";
  }
?>
<script>
document.bot2form.word.focus()
</script>