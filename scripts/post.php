<?
$command = 1;
$dat = substr($action2,5);
if (getlevel(get("plane"),coords(),"board") == "") echo "There is no bulletin board here.<br>\n"; else{
	echo "<center><form action=post.php method=post>\n<textarea name=action rows=10 cols=95%>$dat</textarea>\n<input type=hidden name=username value=$username>\n<input type=hidden name=password value=$password><br>\n<input type=submit value=Post>\n</form></center>\n";
}
?>