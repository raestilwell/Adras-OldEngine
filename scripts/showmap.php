<table style=text-align:center; cellpadding=0 cellspacing=0>
<?
$levdis=get("mapdis");
$myx=get("x");
$myy=get("y");
$myz=get("z");
$myp=get("plane");
for($i=$levdis;$i>=-$levdis;$i--){
	echo "<tr>";
	for($j=-$levdis;$j<=$levdis;$j++){
		$c=($myx+$j)."~".($myy+$i)."~$myz";
		if(islevel($myp,$c)){
			$n="1px";
			$s="1px";
			$w="1px";
			$e="1px";
			$ud=" - ";
			if(getlevel($myp,$c,"d"))$ud[0]="v";
			if(getlevel($myp,$c,"u"))$ud[2]="^";
			$ld = explode(":",getlevel($myp,$c,"pcs"));
			$hl = "";
			for($b = 0; $b < count($ld) - 1; $b++){
				$pn = $ld[$b];
				$pd = getuser($pn,"flags");
				if (strpos($pd,"(invis)") === false || !is_numeric(get("admin"))) $hl.="$pn<br>";
			}
			if($hl!=="")$ud=$ud[0]."<a style=color:black; onmouseOver=\"return overlib('<table style=color:white;background-color:black;border-width:1px;border-style:solid;border-color:gray; border=1><tr><td>$hl</td></tr></table>',VAUTO,HAUTO,FULLHTML);\" onMouseOut=\"return nd();\">+</a>".$ud[2];
			if($ud!=="   ")$ud="<font size=-1><b style=color:black;>$ud</b></font><br>";
			if(getlevel($myp,$c,"n"))$n=0;
			if(getlevel($myp,$c,"s"))$s=0;
			if(getlevel($myp,$c,"w"))$w=0;
			if(getlevel($myp,$c,"e"))$e=0;
			echo "<td class=mapcell style=\"border-width:$n $e $s $w;\">$ud</td>";
		}else echo "<td class=mapcell style=\"background-color:black;border-width:1px 1px 1px 1px;\"></td>";
	}
	echo "</tr>\n";
}
?>
</table>