<?
$x = get("x");
$y = get("y");
$z = get("z");
$p = get("plane");
$c = "$x~$y~$z";
$mapa = "               ";
$mapb = "               ";
$mapc = "               ";
$mapd = "               ";
$mape = "               ";
$mapf = "       #       ";
$mapg = "               ";
$maph = "               ";
$mapi = "               ";
$mapj = "               ";
$mapk = "               ";

if (!getlevel($p,$c,"n")) $mape[7] = "-";
if (!getlevel($p,$c,"s")) $mapg[7] = "-";
if (!getlevel($p,$c,"e")) $mapf[9] = "|";
if (!getlevel($p,$c,"w")) $mapf[5] = "|";
if (getlevel($p,$c,"u")) $mape[8] = "^";
if (getlevel($p,$c,"d")) $mapg[6] = "v";

$ldata = $locdata;
$dx = $x;
$dy = $y;
$dz = $z;

$x = $dx;
$y = $dy + 1;
$c = "$x~$y~$z";
if (islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapc[7] = "-";
	if (!getlevel($p,$c,"s")) $mape[7] = "-";
	if (!getlevel($p,$c,"e")) $mapd[9] = "|";
	if (!getlevel($p,$c,"w")) $mapd[5] = "|";
	if (getlevel($p,$c,"u")) $mapc[8] = "^";
	if (getlevel($p,$c,"d")) $mape[6] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[7] = "+";
	}
}

$x = $dx;
$y = $dy - 1;
$c = "$x~$y~$z";
if (islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapg[7] = "-";
	if (!getlevel($p,$c,"s")) $mapi[7] = "-";
	if (!getlevel($p,$c,"e")) $maph[9] = "|";
	if (!getlevel($p,$c,"w")) $maph[5] = "|";
	if (getlevel($p,$c,"u")) $mapg[8] = "^";
	if (getlevel($p,$c,"d")) $mapi[6] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $maph[7] = "+";
	}
}

$x = $dx + 1;
$y = $dy;
$c = "$x~$y~$z";
if (islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mape[10] = "-";
	if (!getlevel($p,$c,"s")) $mapg[10] = "-";
	if (!getlevel($p,$c,"e")) $mapf[11] = "|";
	if (!getlevel($p,$c,"w")) $mapf[9] = "|";
	if (getlevel($p,$c,"u")) $mape[11] = "^";
	if (getlevel($p,$c,"d")) $mapg[9] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapf[10] = "+";
	}
}

$x = $dx - 1;
$y = $dy;
$c = "$x~$y~$z";
if (islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mape[4] = "-";
	if (!getlevel($p,$c,"s")) $mapg[4] = "-";
	if (!getlevel($p,$c,"e")) $mapf[5] = "|";
	if (!getlevel($p,$c,"w")) $mapf[3] = "|";
	if (getlevel($p,$c,"u")) $mape[5] = "^";
	if (getlevel($p,$c,"d")) $mapg[3] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapf[4] = "+";
	}
}

$x = $dx + 1;
$y = $dy + 1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapc[10] = "-";
	if (!getlevel($p,$c,"s")) $mape[10] = "-";
	if (!getlevel($p,$c,"e")) $mapd[11] = "|";
	if (!getlevel($p,$c,"w")) $mapd[9] = "|";
	if (getlevel($p,$c,"u")) $mapc[11] = "^";
	if (getlevel($p,$c,"d")) $mape[9] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[10] = "+";
	}
}

$x = $dx - 1;
$y = $dy + 1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapc[4] = "-";
	if (!getlevel($p,$c,"s")) $mape[4] = "-";
	if (!getlevel($p,$c,"e")) $mapd[5] = "|";
	if (!getlevel($p,$c,"w")) $mapd[3] = "|";
	if (getlevel($p,$c,"u")) $mapc[5] = "^";
	if (getlevel($p,$c,"d")) $mape[3] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[4] = "+";
	}
}

$x = $dx + 1;
$y = $dy - 1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapg[10] = "-";
	if (!getlevel($p,$c,"s")) $mapi[10] = "-";
	if (!getlevel($p,$c,"e")) $maph[11] = "|";
	if (!getlevel($p,$c,"w")) $maph[9] = "|";
	if (getlevel($p,$c,"u")) $mapg[11] = "^";
	if (getlevel($p,$c,"d")) $mapi[9] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $maph[10] = "+";
	}
}

$x = $dx - 1;
$y = $dy - 1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapg[4] = "-";
	if (!getlevel($p,$c,"s")) $mapi[4] = "-";
	if (!getlevel($p,$c,"e")) $maph[5] = "|";
	if (!getlevel($p,$c,"w")) $maph[3] = "|";
	if (getlevel($p,$c,"u")) $mapg[5] = "^";
	if (getlevel($p,$c,"d")) $mapi[3] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $maph[4] = "+";
	}
}

$x = $dx;
$y = $dy+2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapa[7] = "-";
	if (!getlevel($p,$c,"s")) $mapc[7] = "-";
	if (!getlevel($p,$c,"e")) $mapb[9] = "|";
	if (!getlevel($p,$c,"w")) $mapb[5] = "|";
	if (getlevel($p,$c,"u")) $mapa[8] = "^";
	if (getlevel($p,$c,"d")) $mapc[6] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[7] = "+";
	}
}

$x = $dx;
$y = $dy-2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapi[7] = "-";
	if (!getlevel($p,$c,"s")) $mapk[7] = "-";
	if (!getlevel($p,$c,"e")) $mapj[9] = "|";
	if (!getlevel($p,$c,"w")) $mapj[5] = "|";
	if (getlevel($p,$c,"u")) $mapi[8] = "^";
	if (getlevel($p,$c,"d")) $mapk[6] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapj[7] = "+";
	}
}

$x = $dx+2;
$y = $dy;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mape[13] = "-";
	if (!getlevel($p,$c,"s")) $mapg[13] = "-";
	if (!getlevel($p,$c,"e")) $mapf[14] = "|";
	if (!getlevel($p,$c,"w")) $mapf[11] = "|";
	if (getlevel($p,$c,"u")) $mape[14] = "^";
	if (getlevel($p,$c,"d")) $mapg[12] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapf[13] = "+";
	}
}

$x = $dx-2;
$y = $dy;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mape[1] = "-";
	if (!getlevel($p,$c,"s")) $mapg[1] = "-";
	if (!getlevel($p,$c,"e")) $mapf[3] = "|";
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

$x = $dx+2;
$y = $dy+1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapc[13] = "-";
	if (!getlevel($p,$c,"s")) $mape[13] = "-";
	if (!getlevel($p,$c,"e")) $mapd[14] = "|";
	if (!getlevel($p,$c,"w")) $mapd[11] = "|";
	if (getlevel($p,$c,"u")) $mapc[14] = "^";
	if (getlevel($p,$c,"d")) $mape[12] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[13] = "+";
	}
}

$x = $dx+2;
$y = $dy+2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapa[13] = "-";
	if (!getlevel($p,$c,"s")) $mapc[13] = "-";
	if (!getlevel($p,$c,"e")) $mapb[14] = "|";
	if (!getlevel($p,$c,"w")) $mapb[11] = "|";
	if (getlevel($p,$c,"u")) $mapa[14] = "^";
	if (getlevel($p,$c,"d")) $mapc[12] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[13] = "+";
	}
}

$x = $dx+2;
$y = $dy-1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapg[13] = "-";
	if (!getlevel($p,$c,"s")) $mapi[13] = "-";
	if (!getlevel($p,$c,"e")) $maph[14] = "|";
	if (!getlevel($p,$c,"w")) $maph[11] = "|";
	if (getlevel($p,$c,"u")) $mapg[14] = "^";
	if (getlevel($p,$c,"d")) $mapi[12] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $maph[13] = "+";
	}
}

$x = $dx+2;
$y = $dy-2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapi[13] = "-";
	if (!getlevel($p,$c,"s")) $mapk[13] = "-";
	if (!getlevel($p,$c,"e")) $mapj[14] = "|";
	if (!getlevel($p,$c,"w")) $mapj[11] = "|";
	if (getlevel($p,$c,"u")) $mapi[14] = "^";
	if (getlevel($p,$c,"d")) $mapk[12] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapj[13] = "+";
	}
}

$x = $dx+1;
$y = $dy+2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapa[10] = "-";
	if (!getlevel($p,$c,"s")) $mapc[10] = "-";
	if (!getlevel($p,$c,"e")) $mapb[11] = "|";
	if (!getlevel($p,$c,"w")) $mapb[9] = "|";
	if (getlevel($p,$c,"u")) $mapa[11] = "^";
	if (getlevel($p,$c,"d")) $mapc[9] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[10] = "+";
	}
}

$x = $dx+1;
$y = $dy-2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapi[10] = "-";
	if (!getlevel($p,$c,"s")) $mapk[10] = "-";
	if (!getlevel($p,$c,"e")) $mapj[11] = "|";
	if (!getlevel($p,$c,"w")) $mapj[9] = "|";
	if (getlevel($p,$c,"u")) $mapi[11] = "^";
	if (getlevel($p,$c,"d")) $mapk[9] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapj[10] = "+";
	}
}

$x = $dx-2;
$y = $dy+2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapa[1] = "-";
	if (!getlevel($p,$c,"s")) $mapc[1] = "-";
	if (!getlevel($p,$c,"e")) $mapb[3] = "|";
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

$x = $dx-2;
$y = $dy+1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapc[1] = "-";
	if (!getlevel($p,$c,"s")) $mape[1] = "-";
	if (!getlevel($p,$c,"e")) $mapd[3] = "|";
	if (!getlevel($p,$c,"w")) $mapd[0] = "|";
	if (getlevel($p,$c,"u")) $mapc[2] = "^";
	if (getlevel($p,$c,"d")) $mape[0] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapd[1] = "+";
	}
}

$x = $dx-2;
$y = $dy-1;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapg[1] = "-";
	if (!getlevel($p,$c,"s")) $mapi[1] = "-";
	if (!getlevel($p,$c,"e")) $maph[3] = "|";
	if (!getlevel($p,$c,"w")) $maph[0] = "|";
	if (getlevel($p,$c,"u")) $mapg[2] = "^";
	if (getlevel($p,$c,"d")) $mapi[0] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $maph[1] = "+";
	}
}

$x = $dx-2;
$y = $dy-2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapi[1] = "-";
	if (!getlevel($p,$c,"s")) $mapk[1] = "-";
	if (!getlevel($p,$c,"e")) $mapj[3] = "|";
	if (!getlevel($p,$c,"w")) $mapj[0] = "|";
	if (getlevel($p,$c,"u")) $mapi[2] = "^";
	if (getlevel($p,$c,"d")) $mapk[0] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapj[1] = "+";
	}
}

$x = $dx-1;
$y = $dy-2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapi[4] = "-";
	if (!getlevel($p,$c,"s")) $mapk[4] = "-";
	if (!getlevel($p,$c,"e")) $mapj[5] = "|";
	if (!getlevel($p,$c,"w")) $mapj[3] = "|";
	if (getlevel($p,$c,"u")) $mapi[5] = "^";
	if (getlevel($p,$c,"d")) $mapk[3] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapj[4] = "+";
	}
}

$x = $dx-1;
$y = $dy+2;
$c = "$x~$y~$z";
if(islevel($p,$c)){
	if (!getlevel($p,$c,"n")) $mapa[4] = "-";
	if (!getlevel($p,$c,"s")) $mapc[4] = "-";
	if (!getlevel($p,$c,"e")) $mapb[5] = "|";
	if (!getlevel($p,$c,"w")) $mapb[3] = "|";
	if (getlevel($p,$c,"u")) $mapa[5] = "^";
	if (getlevel($p,$c,"d")) $mapc[3] = "v";
	$ld = explode(":",getlevel($p,$c,"pcs"));
	for($j = 0; $j < count($ld) - 1; $j++){
		$pn = $ld[$j];
		$pd = getuser($pn,"flags");
		if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $mapb[4] = "+";
	}
}
echo "<pre>\n$mapa\n$mapb\n$mapc\n$mapd\n$mape\n$mapf\n$mapg\n$maph\n$mapi\n$mapj\n$mapk\n</pre>\n";
?>