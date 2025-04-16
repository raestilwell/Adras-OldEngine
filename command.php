<?
require("scripts/function.php");
$x = $_GET['x'];
$y = $_GET['y'];
$username = $x;
$password = $y;
require("scripts/verify.php");
?>

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/c11c3ebcdf.js" crossorigin="anonymous"></script>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quattrocento+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Custom -->
  <link rel=stylesheet type=text/css href=css/command.css>

</head>

<script language=Javascript>
function clearForm(f){
    	f.action.value = f.nonaction.value;
    	f.nonaction.value = "";
    	return true;
      }
	  
      function recover(f){
	f.nonaction.value = f.action.value;
      }
	  
</script>

<script language="javascript">
   console.log('Command.php loaded.');
   console.log('Username:', '<?php echo $username; ?>');
   console.log('Password:', '<?php echo $password; ?>');
</script>



<body class="pt-3">

<form action=main.php method=post target=TOP name=theForm onSubmit="clearForm(theForm)">

<!--d-none d-md-block -->

  <div class="container"> <!-- Main Content Container -->
    
    <div class="row align-items-center d-none d-md-block "> <!-- Quick Links (Desktop)-->
      <div class="col">
        <ul class="quick-links mt-3">
          <li><a href="main.php?username=<?= $username ?>&password=<?= $password ?>&action=look+at+<?= $username ?>" target="TOP">Appearance</a></li>
          <li><a href="main.php?username=<?= $username ?>&password=<?= $password ?>&action=description" target="TOP">Description</a></li>
          <li><a href="main.php?username=<?= $x ?>&password=<?= $y ?>&action=stats" target="TOP">Stats</a></li>
          <li><a href="main.php?username=<?= $username ?>&password=<?= $password ?>&action=who" target="TOP">Who</a></li>
          <li><a href="main.php?username=<?= $username ?>&password=<?= $password ?>&action=mail" target="TOP">Mail</a></li>
          <li><a onClick="recover(theForm)" href="#">Recover</a></li>
          <li><a onclick="theForm.action.value='clear';theForm.phpubmit();" href="#" value="Clear">Clear Screen</a></li>
        </ul>
      </div>
    </div><!-- End Quicklinks -->
      
    <div class="row justify-content-md-center align-items-center justify-content-sm-end"><!-- Submit Bar and Languages -->
      <div class="col-md-8 col-sm-12 submit-bar"><!-- Submit Bar and Button -->
        <label class="visually-hidden" for="commandField">Command Field</label>
          <div class="input-group">
            <input type="text" class="form-control" id="commandField" name="nonaction" value="<?= htmlspecialchars(get("nonaction")) ?>">
                <input type=hidden name=action value="">
                <input type=hidden name=username value=<?=$username?>>
                <input type=hidden name=password VALUE=<?=$password?>>
            <button type="submit" class="btn btn-pink" value="Submit">Submit <i class="fa-solid fa-feather-pointed"></i></button> 
          </div>
      </div><!-- End Submit Bar and Button -->
      
      <div class="col-auto"><!-- Languages-->
        <label class="visually-hidden" for="langSelect">Select Your Language</label>
          <select class="form-select" name="thelang" id="langSelect">
            <option value="Common">Common</option>
            <?
            $x = $username;
            $flagdata = get("flags");
            $alltongues = (strpos($flagdata,"(alltongues)")!==false);
            if ($alltongues||strpos($flagdata,"(Common-Sign)") !== false)
            echo "          <option value=Common-Sign>Common-Sign</option>\n";
            if ($alltongues||strpos($flagdata,"(Dwarvish)") !== false)
              echo "          <option value=Dwarvish>Dwarvish</option>\n";
            if ($alltongues||strpos($flagdata,"(Elvish)") !== false)
              echo "          <option value=Elvish>Elvish</option>\n";
            if ($alltongues||strpos($flagdata,"(Gnomeish)") !== false)
              echo "          <option value=Gnomeish>Gnomeish</option>\n";
            if ($alltongues||strpos($flagdata,"(Halfling)") !== false)
              echo "          <option value=Halfling>Halfling</option>\n";
            if ($alltongues||strpos($flagdata,"(TideTongue)") !== false)
              echo "          <option value=TideTongue>TideTongue</option>\n";
            ?>
          </select>
      </div><!-- End Languages -->
    </div><!-- End Submit Bar and Languages -->
  </div> <!-- End Main Content Container -->
  
</form>

</body>

</html>