<?

$locpeeps = getlevel(get("plane"),coords(),"pcs");
if ($locpeeps === false){
	set("x","you");
	set("y","are");
	set("z","stuck");
	set("plane","physical");
	die("Check error.<br>\n");
}
setlevel(get("plane"),coords(),"pcs",str_replace("$username:","",$locpeeps)."$username:");
$locpeeps = getlevel(get("plane"),coords(),"pcs");
$pdat = isset($locdata) && isset($locdata[11]) ? explode(":", $locdata[11]) : [];
for ($i = 0; $i < count($pdat) - 1; $i++){
	if (isuser($pdat[$i])) continue;
	$locpeeps = str_replace("$pdat[$i]:","",$locpeeps);
}
if (strpos(getfile("online"),"$username:") === false){
	setfile("online",getfile("online")."$username:");
	if(!$isloggingin&&!is_numeric(get("admin"))){
		$timelog=getfile("timelog");
		$timelog.="$username:unidle:".time()."\n";
		setfile("timelog",$timelog);
	}
}

$hps = explode(":",$locpeeps);
for ($i = 0; $i < count($hps) - 1; $i++) if (coords() != getcoords($hps[$i]) || get("plane") != getuser($hps[$i],"plane") || strpos(getfile("online"),"$hps[$i]:") === false) $locpeeps = str_replace("$hps[$i]:","",$locpeeps);
setlevel(get("plane"),coords(),"pcs",$locpeeps);
?>