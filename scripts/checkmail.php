<?
$cmd = get("mail");
if ($cmd != ""){
  	$cmd = explode(":~:",$cmd);
	$newmail = 0;
	for ($i = 0; $i < (count($cmd) - 1) && $newmail == 0; $i++){
		$x = $cmd[$i];
		$x = explode(":::",$x);
		if ($x[3] == 0) $newmail = 1;
	}
	if ($newmail == 1) echo "<script language=javascript>\nshowLayer(\"mail\");\n</script>\n";
}
if (get("newchat") == 1) echo "<script language=javascript>\nshowLayer(\"chat\");\n</script>";
?>
