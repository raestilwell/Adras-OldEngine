<?php

if ($action === "guild") {
	displayOrganization("guild");
} else if (strtolower($action3[0]) === "guild") {
	sendMessageToOrganization("guild");
} else if (strtolower($action3[0]) === "+guild") {
	addMemberToOrganization("guild");
} else if (strtolower($action3[0]) === "-guild") {
	removeMemberFromOrganization("guild");
} else if (strtolower($action3[0]) === "guildrank") {
	changeMemberRankInOrganization("guild");
}else if (strtolower($action3[0]) === "leaveguild") {
leaveOrganization("guild");
}
?>