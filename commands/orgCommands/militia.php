<?php

if ($action === "militia") {
	displayOrganization("militia");
} else if (strtolower($action3[0]) === "militia") {
	sendMessageToOrganization("militia");
} else if (strtolower($action3[0]) === "+militia") {
	addMemberToOrganization("militia");
} else if (strtolower($action3[0]) === "-militia") {
	removeMemberFromOrganization("militia");
} else if (strtolower($action3[0]) === "militiarank") {
	changeMemberRankInOrganization("militia");
}else if (strtolower($action3[0]) === "leavemilitia") {
leaveOrganization("militia");
}
?>