<?
  $ghi="";
  require("scripts/function.php");
  $u = $_GET['u'];
  $p = $_GET['p'];
  $plane = $_GET['plane'];
  if(!isset($plane))
  	$plane = "nameless";
  if(isset($u)&&getuser($u,"password")==$p)
  {
    $ghi="'&u=$u&p=$p'";
    $ihg="&u=$u&p=$p";
  }
?>
<html>
<head>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/styles.css"/>
  
<style>
td{width:1.5em;height:1.5em;}
td:hover{background-color:#9d436b;}
body{background-color:#2a2237;}
</style>
</head>
<body class="d-flex vh-100 text-center justify-content-center pt-5">
<main class="px-3">
<h1>Maps of Adrastium</h1>
<hr class="w-30">

<p><a style="font-size: 1.1em;" class="text-white hover-underline-animation" href="closemap.php?x=0&y=0&z=0&plane=nameless&u=<?= $u ?>&p=<?= $p ?>">Nameless City</a></p>

<p>Click a region to enlarge, or click on the main map.</p>
<div class="mx-auto text-center"><?
  if(isset($u)&&getuser($u,"password")==$p&&getuser($u,"plane")==$plane)
    $me=getuser($u,"x")."~".getuser($u,"y")."~".getuser($u,"z");
    if(!isset($x))
      $x=0;
    elseif($x==1)
      $x=-1;
    elseif($x==2)
      $x=-4;
    elseif($x==3)
      $x=6;
    $command = 1;
    $xl = 0;
    $xh = 0;
    $yl = 0;
    $yh = 0;
    if(!isset($dp))
      $dp=$plane;
    $ls = levels($dp);
    for ($i = 0; $i < count($ls); $i++)
    {
	  $file = explode("~",$ls[$i]);
	  if (is_numeric($file[0]) && is_numeric($file[1]) && is_numeric($file[2]) && $file[2] == $x)
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
	  if (is_numeric($file[0]) && is_numeric($file[1]) && is_numeric($file[2]) && $file[2] == $x)
	  {
		$arr[$file[1]-$yl][$file[0]-$xl] = "FFFFFF";
	  }
    }
    echo "<table class='mx-auto' bgcolor=#000000 cellpadding=0 cellspacing=0>\n";
    for ($i = count($arr) - 1; $i >= 0; $i--)
    {
	  echo "<tr>";
	  for ($j = 0; $j < count($arr[0]); $j++)
	  {
		$title="";
		$xc=($j+$xl);
		$yc=($i+$yl);
		$c="$xc~$yc~$x";
		$h="bgcolor=#".$arr[$i][$j];
		if($me==$c)
		  $h="bgcolor=#2a2237";
		if ($arr[$i][$j] != "000000")
		  $title = getlevel($plane,$c,"title");
		echo "<td $h cellpadding=10 title=\"$title\" onClick=javascript:location.href='closemap.php?x=$xc&y=$yc&z=$x&plane=$plane&u=$u&p=$p'> </td>";
	}
	echo "</tr>\n";
}
echo "</table>\n";
?></div>
</main>
</body>
</html>