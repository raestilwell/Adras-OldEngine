<?
$x = get("x");
$y = get("y");
$z = get("z");
$p = get("plane");
$c = "$x~$y~$z";
$mapa = "         ";
$mapb = "         ";
$mapc = "         ";
$mapd = "    #    ";
$mape = "         ";
$mapf = "         ";
$mapg = "         ";
if (!getlevel($p,$c,"n")) $mapc[4] = "-";
if (!getlevel($p,$c,"s")) $mape[4] = "-";
if (!getlevel($p,$c,"e")) $mapd[6] = "|";
if (!getlevel($p,$c,"w")) $mapd[2] = "|";
if (getlevel($p,$c,"u")) $mapc[5] = "^";
if (getlevel($p,$c,"d")) $mape[3] = "v";

$dx = $x;
$dy = $y;
$dz = $z;
$dc = $c;
$neo = 0;
$nwo = 0;
$seo = 0;
$swo = 0;
if (getlevel($p,$dc,"n")){
	$x = $dx;
	$y = $dy + 1;
	$c = "$x~$y~$z";
	if (islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mapa[4] = "-";
		if (!getlevel($p,$c,"s")) $mapc[4] = "-";
		if (!getlevel($p,$c,"e")) $mapb[6] = "|";
		if (!getlevel($p,$c,"w")) $mapb[2] = "|";
		if (getlevel($p,$c,"u")) $mapa[5] = "^";
		if (getlevel($p,$c,"d")) $mapc[3] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[4] = "+";
		}
		if ($locdata[2] == 1) $neo = 1;
		if ($locdata[3] == 1) $nwo = 1;
	}
}
if (getlevel($p,$dc,"s")){
	$x = $dx;
	$y = $dy - 1;
	$c = "$x~$y~$z";
	if (islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mape[4] = "-";
		if (!getlevel($p,$c,"s")) $mapg[4] = "-";
		if (!getlevel($p,$c,"e")) $mapf[6] = "|";
		if (!getlevel($p,$c,"w")) $mapf[2] = "|";
		if (getlevel($p,$c,"u")) $mape[5] = "^";
		if (getlevel($p,$c,"d")) $mapg[3] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapf[4] = "+";
		}
		if ($locdata[2] == 1) $seo = 1;
		if ($locdata[3] == 1) $swo = 1;
	}
}
if (getlevel($p,$dc,"e")){
	$x = $dx + 1;
	$y = $dy;
	$c = "$x~$y~$z";
	if (islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mapc[7] = "-";
		if (!getlevel($p,$c,"s")) $mape[7] = "-";
		if (!getlevel($p,$c,"e")) $mapd[8] = "|";
		if (!getlevel($p,$c,"w")) $mapd[6] = "|";
		if (getlevel($p,$c,"u")) $mapc[8] = "^";
		if (getlevel($p,$c,"d")) $mape[6] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[7] = "+";
		}
		if ($locdata[0] == 1) $neo = 1;
		if ($locdata[1] == 1) $seo = 1;
	}
}
if (getlevel($p,$dc,"w")){
	$x = $dx - 1;
	$y = $dy;
	$c = "$x~$y~$z";
	if (islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mapc[1] = "-";
		if (!getlevel($p,$c,"s")) $mape[1] = "-";
		if (!getlevel($p,$c,"e")) $mapd[2] = "|";
		if (!getlevel($p,$c,"w")) $mapd[0] = "|";
		if (getlevel($p,$c,"u")) $mapc[2] = "^";
		if (getlevel($p,$c,"d")) $mape[0] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[1] = "+";
		}
		if ($locdata[0] == 1) $nwo = 1;
		if ($locdata[1] == 1) $swo = 1;
	}
}
if ($neo == 1){
	$x = $dx + 1;
	$y = $dy + 1;
	$c = "$x~$y~$z";
	if(islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mapa[7] = "-";
		if (!getlevel($p,$c,"s")) $mapc[7] = "-";
		if (!getlevel($p,$c,"e")) $mapb[8] = "|";
		if (!getlevel($p,$c,"w")) $mapb[6] = "|";
		if (getlevel($p,$c,"u")) $mapa[8] = "^";
		if (getlevel($p,$c,"d")) $mapc[6] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[7] = "+";
		}
	}
}
if ($nwo == 1){
	$x = $dx - 1;
	$y = $dy + 1;
	$c = "$x~$y~$z";
	if(islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mapa[1] = "-";
		if (!getlevel($p,$c,"s")) $mapc[1] = "-";
		if (!getlevel($p,$c,"e")) $mapb[2] = "|";
		if (!getlevel($p,$c,"w")) $mapb[0] = "|";
		if (getlevel($p,$c,"u")) $mapa[2] = "^";
		if (getlevel($p,$c,"d")) $mapc[0] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[1] = "+";
		}
	}
}
if ($seo == 1){
	$x = $dx + 1;
	$y = $dy - 1;
	$c = "$x~$y~$z";
	if(islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mape[7] = "-";
		if (!getlevel($p,$c,"s")) $mapg[7] = "-";
		if (!getlevel($p,$c,"e")) $mapf[8] = "|";
		if (!getlevel($p,$c,"w")) $mapf[6] = "|";
		if (getlevel($p,$c,"u")) $mape[8] = "^";
		if (getlevel($p,$c,"d")) $mapg[6] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapf[7] = "+";
		}
	}
}
if ($swo == 1){
	$x = $dx - 1;
	$y = $dy - 1;
	$c = "$x~$y~$z";
	if(islevel($p,$c)){
		if (!getlevel($p,$c,"n")) $mape[1] = "-";
		if (!getlevel($p,$c,"s")) $mapg[1] = "-";
		if (!getlevel($p,$c,"e")) $mapf[2] = "|";
		if (!getlevel($p,$c,"w")) $mapf[0] = "|";
		if (getlevel($p,$c,"u")) $mape[2] = "^";
		if (getlevel($p,$c,"d")) $mapg[0] = "v";
		$ld = explode(":",getlevel($p,$c,"pcs"));
		for($j = 0; $j < count($ld) - 1; $j++){
			$pn = $ld[$j];
			$pd = getuser($pn,"flags");
			if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapf[1] = "+";
		}
	}
}
echo "<pre>\n$mapa\n$mapb\n$mapc\n$mapd\n$mape\n$mapf\n$mapg\n</pre>\n";
?>