<?

 $command = 1;

 if (strpos(getlevel(get("plane"),coords(),"flags"),"($username)") === false && is_numeric(get("admin")))
	 echo "You don't own this room.<br>\n";
 else
 {

	$title = getlevel(get("plane"),coords(),"title");

	$descript = getlevel(get("plane"),coords(),"description");

	$alt = getlevel(get("plane"),coords(),"alt");



	echo "<form action=roomedit.php method=post>
	      <input type=text name=title value=$title><br>\n
              <textarea name=descript rows=15 cols=50%>$descript</textarea><br>\n
	      <textarea name=alt rows=15 cols=50%>$alt</textarea><br>\n
	      <input type=hidden name=username value=$username>\n
	      <input type=hidden name=password value=$password>\n
	      <input type=submit value=Submit><BR>\n</form></center>";
 }

?>
