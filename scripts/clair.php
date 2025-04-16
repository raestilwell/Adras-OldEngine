<?
$command = 1;
$peep = ucwords(strtolower($action3[1]));
if (isuser($peep) || getuser($peep,"plane") != get("plane")){
	$pn = getuser($peep,"name");
	$pw = getuser($peep,"plane");
	$pc = getcoords($peep);
	$pl = getlevel($pw,$pc,"title");
	echo "You see $pn in a place called $pl.<br><br>\n";
}else{
	echo "You see nothing but darkness.<br><br>\n";
}
?>