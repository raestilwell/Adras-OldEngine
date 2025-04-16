<?
// Styling and Google Fonts
echo '
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,400;0,700;1,400;1,700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Oswald:wght@400;700&family=Quattrocento:wght@400;700&family=Raleway:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
';


$fcolor = get("fcolor");
$title = getlevel(get("plane"),coords(),"title");
$descript = getlevel(get("plane"),coords(),"description");
$peeps = explode(":", getlevel(get("plane"),coords(),"pcs"));
$npcs = nl2br(getlevel(get("plane"),coords(),"npcs"));
$numpeeps = count($peeps);
if (getlevel(get("plane"),coords(),"pcs") == "") $numpeeps = 0;
echo "<h1 align=center>$title</h1>\n<center>\n";
$linx = array("","","","","","");
echo "<table align=center style=text-align:center; bgcolor=black><tr><td>\n";
if (getlevel(get("plane"),coords(),"n")) $linx[0] = "<a href=main.php?username=$username&password=$password&action=n><img src=images/northa.jpg border=0 alt=North title=North style=\"width: 30px; height: auto;\"></a>";
else $linx[0] = "<img src=images/northb.jpg border=0 alt=North title=North style=\"width: 30px; height: auto;\">";

if (getlevel(get("plane"),coords(),"s")) $linx[1] = "<a href=main.php?username=$username&password=$password&action=s><img src=images/southa.jpg border=0 alt=South title=South style=\"width: 30px; height: auto;\"></a>";
else $linx[1] = "<img src=images/southb.jpg border=0 alt=South title=South style=\"width: 30px; height: auto;\">";

if (getlevel(get("plane"),coords(),"e")) $linx[2] = "<a href=main.php?username=$username&password=$password&action=e><img src=images/easta.jpg border=0 alt=East title=East style=\"width: 30px; height: auto;\"></a>";
else $linx[2] = "<img src=images/eastb.jpg border=0 alt=East title=East style=\"width: 30px; height: auto;\">";

if (getlevel(get("plane"),coords(),"w")) $linx[3] = "<a href=main.php?username=$username&password=$password&action=w><img src=images/westa.jpg border=0 alt=West title=West style=\"width: 30px; height: auto;\"></a>";
else $linx[3] = "<img src=images/westb.jpg border=0 alt=West title=West style=\"width: 30px; height: auto;\">";

if (getlevel(get("plane"),coords(),"u")) $linx[4] = "<a href=main.php?username=$username&password=$password&action=u><img src=images/upa.jpg border=0 alt=Up title=Up style=\"width: 30px; height: auto;\"></a>";
else $linx[4] = "<img src=images/upb.jpg border=0 alt=Up title=Up style=\"width: 30px; height: auto;\">";

if (getlevel(get("plane"),coords(),"d")) $linx[5] = "<a href=main.php?username=$username&password=$password&action=d><img src=images/downa.jpg border=0 alt=Down title=Down style=\"width: 30px; height: auto;\"></a>";
else $linx[5] = "<img src=images/downb.jpg border=0 alt=Down title=Down style=\"width: 30px; height: auto;\">";
if (strpos(get("flags"),"(blind)") === false) echo "<img src=images/blank.jpg border=0 alt=\"\" style=\"width: 30px; height: auto;\">$linx[0]$linx[4]<br>\n<img src=images/blank.jpg border=0 alt=\"\" style=\"width: 30px; height: auto;\">$linx[3]$linx[2]<img src=images/blank.jpg border=0 alt=\"\" style=\"width: 30px; height: auto;\"><br>\n$linx[5]$linx[1]<img src=images/blank.jpg border=0 alt=\"\" style=\"width: 30px; height: auto;\"><br>";
?>
</td></tr></table>
<?
if (strpos(get("flags"),"(blind)") === false){
	if (getlevel(get("plane"),coords(),"n")) echo "<a href=main.php?username=$username&password=$password&action=n>north</a> ";
	if (getlevel(get("plane"),coords(),"s")) echo "<a href=main.php?username=$username&password=$password&action=s>south</a> ";
	if (getlevel(get("plane"),coords(),"w")) echo "<a href=main.php?username=$username&password=$password&action=w>west</a> ";
	if (getlevel(get("plane"),coords(),"e")) echo "<a href=main.php?username=$username&password=$password&action=e>east</a> ";
	if (getlevel(get("plane"),coords(),"u")) echo "<a href=main.php?username=$username&password=$password&action=u>up</a> ";
	if (getlevel(get("plane"),coords(),"d")) echo "<a href=main.php?username=$username&password=$password&action=d>down</a>";
}

echo "<br><br>\n</center>\n$descript<br><br>\n";
if ($npcs != "") echo "$npcs<br><br>\n";
if ($numpeeps > 1){
	for ($i = 0; $i < $numpeeps; $i++){
		if ($peeps[$i] != $username){
			$d = ".";
			$peep = $peeps[$i];
			if ($peep != "" && isuser($peep)){
				$peeppet = getuser($peep,"pet");
				$pfdat = getuser($peep,"flags");
				$peepr = getuser($peep,"race");
				$peepd1 = getuser($peep,"class");
				$peepd2 = getuser($peep,"rank");
				$peepd3 = getuser($peep,"deity");
				$peepd4 = getuser($peep,"gender");
				$peepd5 = getuser($peep,"eyes");
				$peepd6 = getuser($peep,"hair");
				$peepd7 = getuser($peep,"skin");
				$peepd8 = getuser($peep,"hometown");
				$peepd9 = getuser($peep,"spouse");
				$peepd10 = getuser($peep,"fame");
				$afkp = "";
				if (getuser($peep,"isafk")==="y") $afkp = "<center><b>AFK</b></center><br>";
				if ($peeppet != "") $d = filter(" with $peeppet.");
				$thepeepname = getuser($peep,"name");
				if (strpos($pfdat,"(cloak)") !== false) $d .= " <font color=red>(cloaked)</font>";
				if (strpos($pfdat,"(invis)") !== false) $d .= " <font color=blue>(invisible)</font>";
				$button="<input type=button class=button onClick=javascript:tellTo('$peeps[$i]') value=*>";
				$overlib = "onmouseover=\"return overlib('<table style=color:".get("tcolor").";background-color:".get("bgcolor").";border-width:1px;border-style:solid;border-color:".get("ccolor")."; border=1><tr><td style=border-width:0;>".$afkp."<b>Class:</b> $peepd1<br><b>Rank:</b> $peepd2<br><b>Home:</b> $peepd8<br><b>Deity:</b> $peepd3<br><b>Gender:</b> $peepd4<br><b>Eyes:</b> $peepd5<br><b>Hair:</b> $peepd6<br><b>Skin:</b> $peepd7<br><b>Spouse:</b> $peepd9<br><b>Fame:</b> $peepd10<br></td></tr></table>',HAUTO,VAUTO,FULLHTML);\" onmouseout=\"return nd();\"";
				$dString = "The $peepr known as $button<a href=main.php?username=$username&password=$password&action=look+at+$peeps[$i] $overlib>$thepeepname</a> is here$d<br>\n";
				if (strpos(get("friends"),"$peep:") !== false) $dString = "The $peepr known as $button<a href=main.php?username=$username&password=$password&action=look+at+$peeps[$i] $overlib><font color=$fcolor>$thepeepname</font></a> is here$d<br>\n";
				if (((strpos($pfdat,"(cloak)") === false || strpos(get("flags"),"(perc)") !== false) && strpos($pfdat,"(invis)") === false) || !is_numeric(get("admin"))) echo $dString;
			}
		}
	}
	echo "<br>\n";
}
if (get("deaf") == 0){
	echo "<div id=userchat style=color:".get("ccolor").";>\n";
	if (strpos(get("flags"),"(bold)") === false) echo "<p style=font-weight:normal;>\n";
	echo get("chat")."</div>\n";
}
if ($posing == 0){
	$chatdata = str_replace("<hr width=50% style='margin: 0 auto;'>\n","",get("chat"));
	$chatdata = str_replace("<p style=font-weight:normal;>\n","",$chatdata);

	// Check if $flagdata is set before using it
	$flagdata = isset($flagdata) ? $flagdata : "";

	// Add <hr> only if it doesn't exist
	if (strpos($chatdata, "<hr width=50% style='margin: 0 auto;'>") === false) {
		$chatdata .= "<hr width=50% style='margin: 0 auto;'>\n";
	}

	if (strpos($flagdata,"(bold)") === false) $chatdata .= "<p style=font-weight:normal;>\n";
	set("chat",$chatdata);
	set("newchat",0);
}

?>