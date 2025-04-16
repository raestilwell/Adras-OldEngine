<?
$dir = "in a flash of light";
$undir = "nowhere";
if ($action == "n" && getlevel(get("plane"),coords(),"n") == 1){
	$command = 1;
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	set("y",get("y")+1);
	$abc = 1;
	$dir = "north";
	$undir = "the south";
}else if ($action == "s" && getlevel(get("plane"),coords(),"s") == 1){
	$command = 1;
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	set("y",get("y")-1);
	$abc = 1;
	$dir = "south";
	$undir = "the north";
}else if ($action == "e" && getlevel(get("plane"),coords(),"e") == 1){
	$command = 1;
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	set("x",get("x")+1);
	$abc = 1;
	$dir = "east";
	$undir = "the west";
}else if ($action == "w" && getlevel(get("plane"),coords(),"w") == 1){
	$command = 1;
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	set("x",get("x")-1);
	$abc = 1;
	$dir = "west";
	$undir = "the east";
}else if ($action == "u" && getlevel(get("plane"),coords(),"u") == 1){
	$command = 1;
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	set("z",get("z")+1);
	$abc = 1;
	$dir = "up";
	$undir = "below";
}else if ($action == "d" && getlevel(get("plane"),coords(),"d") == 1){
	$command = 1;
	$x1 = get("x");
	$y1 = get("y");
	$z1 = get("z");
	$c1 = coords();
	$p1 = get("plane");
	set("z",get("z")-1);
	$abc = 1;
	$dir = "down";
	$undir = "above";
}
if ($abc == 1 && !get("frozen")){
	$folpeeps = "";
	$fols = get("followers");
	if ($fols !== ""){
		$folpeeps = ", followed by ";
		$fols = explode(",",$fols);
		for ($f = 0; $f < count($fols)-1; $f++){
			$folpeeps .= $fols[$f];
			if ($f != count($fols)-2) $folpeeps .= ", ";
		}
	}
	$locdata = str_replace("$username:", "",getlevel($p1,$c1,"pcs"));
	if ($folpeeps !== ""){
		for ($f = 0; $f < count($fols)-1; $f++){
			$locdata = str_replace("$fols[$f]:", "", $locdata);
			setuser($fols[$f],"x",get("x"));
			setuser($fols[$f],"y",get("y"));
			setuser($fols[$f],"z",get("z"));
			setuser($fols[$f],"plane",get("plane"));
		}
	}
	setlevel($p1,$c1,"pcs",$locdata);
	$peeps = explode(":",$locdata);
	for ($i = 0; $i < count($peeps) && strpos(get("flags"),"(invis)") === false && $cloaked == 0; $i++)
		if ($peeps[$i] != ""){
			setuser($peeps[$i],"chat",getuser($peeps[$i],"chat").get("name")." left $dir$folpeeps.<br>\n");
			$cp = getuser($peeps[$i],"chatpref");
			if ($cp[18] == 1) setuser($peeps[$i],"newchat",1);
		}
	$peeps = getlevel(get("plane"),coords(),"pcs");
	$peeps = explode(":",$peeps);
	for ($i = 0; $i < count($peeps) && strpos(get("flags"),"(invis)") === false && $cloaked == 0; $i++)
		if ($peeps[$i] != "" && $peeps[$i] != $username){
			setuser($peeps[$i],"chat",getuser($peeps[$i],"chat").get("name")." appeared from $undir$folpeeps.<br>\n");
			$cp = getuser($peeps[$i],"chatpref");
			if ($cp[17] == 1) setuser($peeps[$i],"newchat",1);
		}
	setlevel(get("plane"),coords(),"pcs",str_replace("$username:","",getlevel(get("plane"),coords(),"pcs")));
	if ($folpeeps !== ""){
		$olp = getlevel(get("plane"),coords(),"pcs");
		for ($f = 0; $f < count($fols)-1; $f++) $olp = str_replace("$fols[$f]:","",$olp)."$fols[$f]:";
		setlevel(get("plane"),coords(),"pcs",$olp);
	}
	setlevel(get("plane"),coords(),"pcs",str_replace("$username:","",getlevel(get("plane"),coords(),"pcs"))."$username:");
}
?>