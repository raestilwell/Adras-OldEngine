<?php
  $username = $_GET['username'];
  $password = $_GET['password'];
  require("scripts/function.php");
  require("scripts/verify.php");
?>
<meta http-equiv="refresh" content="<?=get("refresh")?>">
<?php
  $cmd = get("mail");
  if ($cmd != "") {
	$cmd = explode(":~:", $cmd);
	$newmail = 0;
	for ($i = 0; $i < (count($cmd) - 1) && $newmail == 0; $i++) {
	  $x = $cmd[$i];
	  $x = explode(":::", $x);
	  if ($x[3] == 0)
		$newmail = 1;
	}
  }
  
  // Get the newchat flag directly from the user's record
  $newchat = get("newchat");
  
  if ($newmail == 1 || $newchat == 1) {
	echo "<script>
	function showLayer(whichLayer) {
	  try {
		// Get reference to the element in the parent frame
		var element = parent.frames['TOP'].document.getElementById(whichLayer);
		if (element) {
		  element.style.display = 'block';
		} else {
		  console.error('Element ' + whichLayer + ' not found');
		}
	  } catch (e) {
		console.error('Error showing layer: ' + e.message);
	  }
	}
	</script>";
	
	if ($newmail == 1) {
	  echo "<script>showLayer('bmail');</script>";
	}
	if ($newchat == 1) {
	  echo "<script>showLayer('bchat');</script>";
	}
  }
?>