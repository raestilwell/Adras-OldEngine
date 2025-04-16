<?php

if ($action === "clan") {
	displayOrganization("clan");
} else if (strtolower($action3[0]) === "clan") {
	sendMessageToOrganization("clan");
} else if (strtolower($action3[0]) === "+clan") {
	addMemberToOrganization("clan");
} else if (strtolower($action3[0]) === "-clan") {
	removeMemberFromOrganization("clan");
} else if (strtolower($action3[0]) === "clanrank") {
	changeMemberRankInOrganization("clan");
}else if (strtolower($action3[0]) === "leaveclan") {
leaveOrganization("clan");
}
?>