<?
$command = 1;
$locpeeps = getlevel(get("plane"),coords(),"pcs");
setlevel(get("plane"),coords(),"pcs",str_replace("$username:","",$locpeeps));
setfile("online",str_replace("$username:","",getfile("online")));
$charlist = explode(":",getlevel(get("plane"),coords(),"pcs"));
$numchars = count($charlist);
$garg = '';
 
  //Search flag data for the (invis flag)
  $flagdata = get("flags");
  $invis = (strpos($flagdata,"(invis)"));
  
  //If (invis) is not found, display customized logout output.
  if ($invis === false)
  {
  	for ($i = 0; $i < $numchars && $garg != "yes"; $i++)
		setuser($charlist[$i],"chat",getuser($charlist[$i],"chat").get("name").get("logout")."<br>\n");
  }
  
set("chat","");
if(!is_numeric(get("admin"))){
	$timelog=getfile("timelog");
	$timelog.="$username:out:".time()."\n";
	setfile("timelog",$timelog);
}
?>
You have left Adrastium.<br>
<script language=JavaScript>
parent.location="https://adrastium.com/";
</script>
<? die(""); ?>