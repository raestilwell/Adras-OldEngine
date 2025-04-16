<?
$command = 1;
$data = explode(":~:",getfile("locks"));
echo "<u>You Have the Following Keys</u><br>\n";
$k = 0;
$flagdata = get("flags");
for ($i = 1; $i < count($data) && strpos($flagdata,"(allkeys)") === false; $i++){
	if (strpos($flagdata,"(key$i)") === false) continue;
	$k = 1;
	$locs = explode(":",$data[$i]);
	$loc1 = explode(" ",$locs[0]);
	$loc2 = explode(" ",$locs[1]);
	$locatitl = getlevel($loc1[1],$loc1[0],"title");
	$locbtitl = getlevel($loc2[1],$loc2[0],"title");
	echo stripslashes("Lock $i: $locatitl --- $locbtitl<br>");
}
if (strpos($flagdata,"(allkeys)") !== false) echo "You have <i>all</i> of the keys.<br>\n"; else if ($k == 0) echo "You have no keys!<br>\n";
?>