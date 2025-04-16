<?php
$charnames = explode(":", getfile("online"));
$loggingin = isset($isloggingin) ? $isloggingin : null;

for ($i = 0; $i < count($charnames); $i++) {
	$time = time();
	if ($charnames[$i] != "") {
		$whouser = $charnames[$i];
		$whoname = stripslashes(getuser($whouser, "name"));
		$whotime = $time - getuser($whouser, "last_action");
		if (strpos($whouser, " ") !== false || ((strpos(getuser($whouser, "flags"), "(noidle)") === false && $whotime >= 3600) && $loggingin !== 1)) {
			$pcs = getlevel(getuser($whouser, "plane"), getcoords($whouser), "pcs");
			$pcs = str_replace("$whouser:", "", $pcs);
			setlevel(getcoords($whouser), getuser($whouser, "plane"), "pcs", $pcs);
			$ocdata = getfile("online");
			$ocdata = str_replace("$whouser:", "", $ocdata);
			setfile("online", $ocdata);
			// setuser($whouser, "chat", "");

			if (!$loggingin && !is_numeric(getuser($whouser, "admin"))) {
				$timelog = getfile("timelog");
				$timelog .= "$whouser:idle:" . time() . "\n";
				setfile("timelog", $timelog);
			}
		}
	}
}
?>
