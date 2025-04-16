<?
if ($action == "time"){
	$command = 1;
	$hours = date("G");
	$minutes = date("i");
	$seconds = date("s");
	if ($hours < 6){
		$time = "after no-sun";
	}else if ($hours < 12){
		$time = "after new-sun";
	}else if ($hours < 18){
		$time = "after high-sun";
	}else{
		$time = "after low-sun";
	}
	$hours %= 6;
	echo "It is $hours:$minutes:$seconds $time.<br>\n";
}else if ($action == "date"){
	$command = 1;
	$day = date("z")+1;
	$year = date("Y") + 48000;
	$year2 = date("Y") + 998000;
	$days = number_format(floor(($year - 1) * 365.25) + $day);
	$datestr = "It is day $day of the year $year, year $year2 after the end of the Mortal War.";
	echo "$datestr<br>\n";
}
?>