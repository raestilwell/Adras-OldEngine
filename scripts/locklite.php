<?if (strtolower($action3[0]) == "lock"){
	if (count($action3) > 1){
		$command = 1;
		$locknum = $action3[1];
		$key = "(key$locknum)";
		$flagdata = get("flags");
		if (strpos($flagdata, $key) === false && strpos($flagdata,"(allkeys)") === false) echo "You don't seem to have that key.<br>\n"; else{
			$lockdata = explode(":~:",getfile("locks"));
			if (count($lockdata) > $locknum){
				$lockdata = $lockdata[$locknum];
				$lockdata = explode(":",$lockdata);
				$lock1 = explode(" ",$lockdata[0]);
				$lock2 = explode(" ",$lockdata[1]);
				if ((coords() == $lock1[0] || coords() == $lock2[0]) && get("plane") == $lock1[1]){
					$coord1 = explode("~",$lock1[0]);
					$coord2 = explode("~",$lock2[0]);
					for ($i = 0; $i < 3; $i++){
						if ($coord1[$i] != $coord2[$i]){
							if ($i == 0){
								if ($coord1[$i] > $coord2[$i]){
									$dir1 = 'w';
									$dir2 = 'e';
								}else{
									$dir1 = 'e';
									$dir2 = 'w';
								}
							}else if ($i == 1){
								if ($coord1[$i] > $coord2[$i]){
									$dir1 = 's';
									$dir2 = 'n';
								}else{
									$dir1 = 'n';
									$dir2 = 's';
								}
							}else if ($i == 2){
								if ($coord1[$i] > $coord2[$i]){
									$dir1 = 'd';
									$dir2 = 'u';
								}else{
									$dir1 = 'u';
									$dir2 = 'd';
								}
							}
						}
					}
					setlevel(get("plane"),$lock1[0],$dir1,0);
					setlevel(get("plane"),$lock2[0],$dir2,0);
					echo "The lock has been set.<br>\n";
				}else echo "Lock not found. You aren't in the right place.<br>\n";
			}else echo "Lock does not exist.<br>\n";
		}
	}
}else if (strtolower($action3[0]) == "unlock"){
	if (count($action3) > 1){
		$command = 1;
		$locknum = $action3[1];
		$key = "(key$locknum)";
		$flagdata = get("flags");
		if (strpos($flagdata, $key) === false && strpos($flagdata,"(allkeys)") === false) echo "You don't seem to have that key.<br>\n"; else{
			$lockdata = explode(":~:",getfile("locks"));
			if (count($lockdata) > $locknum){
				$lockdata = $lockdata[$locknum];
				$lockdata = explode(":",$lockdata);
				$lock1 = explode(" ",$lockdata[0]);
				$lock2 = explode(" ",$lockdata[1]);
				if ((coords() == $lock1[0] || coords() == $lock2[0]) && get("plane") == $lock1[1]){
					$coord1 = explode("~",$lock1[0]);
					$coord2 = explode("~",$lock2[0]);
					for ($i = 0; $i < 3; $i++){
						if ($coord1[$i] != $coord2[$i]){
							if ($i == 0){
								if ($coord1[$i] > $coord2[$i]){
									$dir1 = 'w';
									$dir2 = 'e';
								}else{
									$dir1 = 'e';
									$dir2 = 'w';
								}
							}else if ($i == 1){
								if ($coord1[$i] > $coord2[$i]){
									$dir1 = 's';
									$dir2 = 'n';
								}else{
									$dir1 = 'n';
									$dir2 = 's';
								}
							}else if ($i == 2){
								if ($coord1[$i] > $coord2[$i]){
									$dir1 = 'd';
									$dir2 = 'u';
								}else{
									$dir1 = 'u';
									$dir2 = 'd';
								}
							}
						}
					}
					setlevel(get("plane"),$lock1[0],$dir1,1);
					setlevel(get("plane"),$lock2[0],$dir2,1);
					echo "The lock has opened.<br>\n";
				}else echo "Lock not found. You aren't in the right place.<br>\n";
			}else echo "Lock does not exist.<br>\n";
		}
	}
}else if ($action == "alter"){
	$command = 1;
	$f = getlevel(get("plane"),coords(),"flags");
	if (strpos($f,"($username)") !== false || !is_numeric(get("admin"))){
		$d = getlevel(get("plane"),coords(),"description");
		$a = getlevel(get("plane"),coords(),"alt");
		setlevel(get("plane"),coords(),"description",$a);
		setlevel(get("plane"),coords(),"alt",$d);
		echo "Description changed.<br>\n";
	}else echo "You do not own this room.<br>\n";
}
?>