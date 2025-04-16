<?
$username = $_POST['username'];

$command=1;
echo "
<form action=changepass.php method=post>
<input type=hidden name=username value=$username>
<table border=0>
<tr><td colspan=2>Editing password for <b>$username</b>.</td></tr>
<tr><td>Current Password:</td><td><input type=password name=password></td></tr>
<tr><td>New Password:</td><td><INPUT type=password name=pass1></td></tr>
<tr><td>Re-enter New Password:</td><td><input type=password name=pass2></td></tr>
<tr><td></td><td ALIGN=center><input type=submit VALUE='Change Password'></td></tr>
</table>
</form>
Password must be at least four characters long.<br>"
?>