<html>
<head>
<style>
td{width:80;height:80;background-color:white;border-style:solid;border-width:0;border-color:#000;}
body{background-color:silver;}
a{color:white;}
a:hover{color:lime;}
</style>
</head>
<body>
<table style=text-align:center; align=center cellpadding=0 cellspacing=0>
<?
  $u = $_GET['u'];
  $p = $_GET['p'];
  $x = $_GET['x'];
  $y = $_GET['y'];
  $z = $_GET['z'];
  $plane = $_GET['plane'];
  
  if(!isset($plane))
  {
  	$plane = "physical";
  }

  require("scripts/function.php");
  if(!isset($x))
    $x=0;
  if(!isset($y))
    $y=0;
  if(!isset($z))
    $z=0;
  $me="";
  if(isset($u)&&getuser($u,"password")==$p&&getuser($u,"plane")==$plane)
    $me=getuser($u,"x")."~".getuser($u,"y")."~".getuser($u,"z");
  for($i=9;$i>=-9;$i--)
  {
	echo "<tr>";
	for($j=-7;$j<=7;$j++)
	{
      $c=($x+$j)."~".($y+$i)."~$z";
      if(islevel($plane,$c))
      {
		$n="1px";
		$s="1px";
		$w="1px";
		$e="1px";
		$ud="";
		$h="";
		if($me==$c)
		  $h="<br><font size=+2 color=red><b title='You Are Here'>X</b></font>";
		if(getlevel($plane,$c,"d"))
		  $ud="v";
		if(getlevel($plane,$c,"u"))
		  $ud=" ^";
		if($ud)
		  $ud="<font size=+1><b>$ud</b></font><br>";
		if(getlevel($plane,$c,"n"))
		  $n=0;
		if(getlevel($plane,$c,"s"))
		  $s=0;
		if(getlevel($plane,$c,"w"))
		  $w=0;
		if(getlevel($plane,$c,"e"))
		  $e=0;
		echo "<td style=\"border-width:$n $e $s $w;\">$ud".getlevel($plane,$c,"title")."$h</td>";
	  }
	  else
	    echo "<td style=\"background-color:black;border-width:1px 1px 1px 1px;\"></td>";
	}
	echo "</tr>\n";
  }
?>
</table>
</body>
</html>