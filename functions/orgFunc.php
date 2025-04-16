<?php
function isorg($name){
	$data = false;
	$name = str_replace("'", "&#39;", $name);
	$dbh = dbconnect() or die('IsUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM orgs WHERE name = '$name'");
	if (mysqli_num_rows($result) > 0) $data = true;
	mysqli_close($dbh);
	return $data;
}

function orgs($type){
	$data = array();
	$dbh = dbconnect() or die("Userlist read error: " . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM orgs WHERE type = '$type' ORDER BY name");
	
	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = stripslashes($row["name"]);
	}

	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}


function getorg($name, $var){
	$data = "";
	$name = str_replace("'", "&#39;", $name);
	$dbh = dbconnect() or die('GetUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$result = mysqli_query($dbh, "SELECT * FROM orgs WHERE name = '$name'");
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$data = stripslashes($row[$var]);
	}
	mysqli_close($dbh);
	$data = str_replace("&#39;", "'", $data);
	return $data;
}

function setorg($name, $var, $value){
	$name = str_replace("'", "&#39;", $name);
	$value = str_replace("'", "&#39;", $value);
	$dbh = dbconnect() or die('SetUser error: ' . mysqli_error() . "<br>");
	mysqli_select_db($dbh, "adras_database");
	$sql_query = mysqli_query($dbh, "UPDATE orgs SET $var = '$value' WHERE name = '$name'");
	mysqli_close($dbh);
	return 1;
}


function displayOrganization($orgType) {
	$command = 1;
	$org = get($orgType);
	
	// Initialize $data as an empty array
	$data = array();

	if ($org == "") {
		echo "You are not a member of a $orgType.<br>\n";
	} else if (!isorg($org)) {
		echo "That $orgType no longer exists.<br>\n";
	} else {
		echo "<table border=1>\n<tr><td colspan=2>$org</td></tr>\n<tr><td>NAME</td><td>RANK</td></tr>\n<tr><td></td><td></td></tr>\n";

		$ranks = array("owners", "leaders", "officers", "members", "parole");

		foreach ($ranks as $rankType) {
			$data = explode(":", getorg($org, $rankType));

			// Check if $data is an array before using foreach
			if (is_array($data)) {
				foreach ($data as $item) {
					if ($item !== "") {
						switch ($rankType) {
							case "owners":
								$rank = "<b><u>owner</u></b>";
								break;
							case "leaders":
								$rank = "<b>leader</b>";
								break;
							case "officers":
								$rank = "<u>officer</u>";
								break;
							case "members":
								$rank = "<i>member</i>";
								break;
							case "parole":
								$rank = "on parole";
								break;
						}

						if (!isuser($item)) {
							$rank = "deleted";
						}

						echo "<tr><td>$item</td><td>$rank</td></tr>\n";
					}
				}
			}
		}

		echo "</table>\n";
	}
}

function sendMessageToOrganization($orgType) {
	global $command, $username, $action2;

	$command = 1;
	$org = get($orgType);

	if ($org == "") {
		echo "You are not a member of a $orgType!<br>\n";
	} else {
		$message = substr($action2, strlen($orgType) + 1);
		set("chat", get("chat") . "<b>You told your $orgType, \"$message\"</b><br>\n");
		$chardata = explode(":", getfile("online"));

		for ($i = 0; $i < count($chardata) - 1; $i++) {
			if ($chardata[$i] != $username && getuser($chardata[$i], $orgType) == $org) {
				$cp = getuser($chardata[$i], "chatpref");
				setuser($chardata[$i], "chat", getuser($chardata[$i], "chat") . get("name") . " told your $orgType, \"$message\"<br>\n");
				setuser($chardata[$i], "newchat", 1);

				$prefIndex = 13 + array_search($orgType, array("clan", "guild", "militia"));
				if ($cp[$prefIndex] == 1) {
					setuser($chardata[$i], "newchat", 1);
				}
			}
		}
	}
}

function addMemberToOrganization($orgType) {
	global $command, $username, $action3;

	$command = 1;
	$peep = ucwords(strtolower($action3[1]));
	$org = get($orgType);

	$owners = getorg($org, "owners");
	$leaders = getorg($org, "leaders");

	if ($org == "") {
		echo "You are not a member of a $orgType!<br>\n";
	} else if (strpos($owners, "$username:") === false && !empty($leaders) && strpos($leaders, "$username:") === false) {
		echo "You do not have sufficient privileges to add members to your $orgType.<br>\n";
	} else {
		if (isuser($peep)) {
			if (getuser($peep, $orgType) != "") {
				echo getuser($peep, "name") . " is already a member of a $orgType.<br>\n";
			} else {
				setuser($peep, $orgType, $org);
				setorg($org, "members", getorg($org, "members") . "$peep:");
				echo getuser($peep, "name") . " is now a member of your $orgType.<br>\n";
			}
		} else {
			echo "$peep does not exist.<br>\n";
		}
	}
}

function removeMemberFromOrganization($orgType) {
	global $command, $username, $action3;

	$command = 1;
	$peep = ucwords(strtolower($action3[1]));
	$org = get($orgType);
	$owners = getorg($org, "owners");
	$leaders = getorg($org, "leaders");

	if ($org == "") {
		echo "You are not a member of a $orgType!<br>\n";
	} else if (strpos($owners, "$username:") === false && !empty($leaders) && strpos($leaders, "$username:") === false) {
		echo "You do not have sufficient privileges to remove members from your $orgType.<br>\n";
	} else {
		if (isuser($peep)) {
			if (getuser($peep, $orgType) != $org) {
				echo getuser($peep, "name") . " is not a member of your $orgType.<br>\n";
			} else {
				setuser($peep, $orgType, "");
				setorg($org, "leaders", str_replace("$peep:", "", getorg($org, "leaders")));
				setorg($org, "officers", str_replace("$peep:", "", getorg($org, "officers")));
				setorg($org, "members", str_replace("$peep:", "", getorg($org, "members")));
				setorg($org, "parole", str_replace("$peep:", "", getorg($org, "parole")));
				echo getuser($peep, "name") . " has been removed from your $orgType.<br>\n";
			}
		} else {
			echo "$peep does not exist.<br>\n";
		}
	}
}

function changeMemberRankInOrganization($orgType) {
	global $command, $username, $action3;

	$command = 1;

	// Check if $action3 is set and has at least two elements
	if (isset($action3[1], $action3[2])) {
		$org = get($orgType);
		$peep = ucwords(strtolower($action3[1]));
		$rank = $action3[2];

		if ($org == "") {
			echo "You are not a member of a $orgType!<br>\n";
		} else if (strpos(getorg($org, "owners"), "$username") === false) {
			echo "You do not have sufficient privileges to change the ranks of your $orgType's members.<br>\n";
		} else if ($rank > 3 || $rank < 0) {
			echo "$orgType ranks range from 0 to 3.<br>\n";
		} else {
			if (isuser($peep)) {
				if (getuser($peep, $orgType) != $org) {
					echo getuser($peep, "name") . " is not a member of your $orgType.<br>\n";
				} else {
					setorg($org, "leaders", str_replace("$peep:", "", getorg($org, "leaders")));
					setorg($org, "officers", str_replace("$peep:", "", getorg($org, "officers")));
					setorg($org, "members", str_replace("$peep:", "", getorg($org, "members")));
					setorg($org, "parole", str_replace("$peep:", "", getorg($org, "parole")));

					switch ($rank) {
						case 0:
							setorg($org, "parole", getorg($org, "parole") . "$peep:");
							break;
						case 1:
							setorg($org, "members", getorg($org, "members") . "$peep:");
							break;
						case 2:
							setorg($org, "officers", getorg($org, "officers") . "$peep:");
							break;
						case 3:
							setorg($org, "leaders", getorg($org, "leaders") . "$peep:");
							break;
					}

					echo getuser($peep, "name") . "'s rank has been changed.<br>\n";
				}
			} else {
				echo "$peep does not exist.<br>\n";
			}
		}
	} else {
		echo "Invalid parameters for changing rank.<br>\n";
	}
}

function leaveOrganization($orgType) {
	global $command, $username;

	$command = 1;
	$peep = $username;
	$org = get($orgType);

	if ($org == "") {
		echo "You are not a member of a $orgType!<br>\n";
	} else {
		setorg($org, "owners", str_replace("$peep:", "", getorg($org, "owners")));
		setorg($org, "leaders", str_replace("$peep:", "", getorg($org, "leaders")));
		setorg($org, "officers", str_replace("$peep:", "", getorg($org, "officers")));
		setorg($org, "members", str_replace("$peep:", "", getorg($org, "members")));
		setorg($org, "parole", str_replace("$peep:", "", getorg($org, "parole")));
		set($orgType, "");

		echo "You have left the $org $orgType.<br>\n";
	}
}
?>
