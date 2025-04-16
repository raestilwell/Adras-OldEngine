<?
$command = 1;
if (getlevel(get("plane"),coords(),"board") == "") echo "There is no bulletin board here.<br>\n"; else{
	$data = explode(":~:",getlevel(get("plane"),coords(),"board"));
	$dat = explode(":::",$data[$action3[1]]);
	$dat = str_replace("<br />","",$dat[2]);
	echo "<center><form action=editpost.php method=post>\n<textarea name=action rows=10 cols=95%>$dat</textarea>\n<input type=hidden name=username value=$username>\n<input type=hidden name=password value=$password>\n<input type=hidden name=num value=$action3[1]>\n<br>\n<input type=submit value=Post>\n</form></center>\n";
}
?>