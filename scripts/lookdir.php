<?
$command = 1;
$x = get("x");
$y = get("y");
$z = get("z");
$coords = "$x~$y~$z";
$in = $action3[1][0];
switch($in){
	case "n":
		$a = "y";
		$b = 1;
		break;
	case "s":
		$a = "y";
		$b = -1;
		break;
	case "e":
		$a = "x";
		$b = 1;
		break;
	case "w":
		$a = "x";
		$b = -1;
		break;
	case "u":
		$a = "z";
		$b = 1;
		break;
	case "d":
		$a = "z";
		$b = -1;
		break;
}
$c = 0;
for ($i = 0; $i < 3 && getlevel(get("plane"),$coords,$in) == 1; $i++){
	if ($c == 0) echo "<u>A little way off</u><br>\n";
	else if ($c == 1) echo "<u>A bit further</u><br>\n";
	else echo "<u>A long way off</u><br>\n";
	$c++;
	$$a += $b;
	$coords = "$x~$y~$z";
	$peepdata = explode(":",getlevel(get("plane"),$coords,"pcs"));
	$thecount = 0;
	for ($j = 0; $j < count($peepdata) - 1; $j++){
		if (strpos(getuser($peepdata[$j],"flags"),"(invis)") === false || !is_numeric(get("admin"))){
			echo "You see ".getuser($peepdata[$j],"name").".<br>\n";
			$thecount++;
		}
	}
	if ($thecount == 0) echo "Nobody.<br>\n";
	echo "<br>\n";
}
?>