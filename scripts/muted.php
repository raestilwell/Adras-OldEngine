<?php
function getmuteval($chan)
{
    $data = "";
    $dbh = dbconnect() or die ('GetUser error: ' . mysqli_error($dbh) . "<br>");
    mysqli_select_db($dbh, "adras_database");
    $result = mysqli_query($dbh, "SELECT mute FROM muted WHERE channel = '$chan'");
    if (mysqli_num_rows($result) > 0)
    {
        $data = stripslashes(mysqli_fetch_assoc($result)['mute']);
    }
    mysqli_close($dbh);
    return $data;
}

function setmute($chan, $val)
{
    $oppval = ($val == 1) ? 0 : 1;
    $data = str_replace("'", "$#39;", $data); // Looks like $data is undefined here, should it be $val?

    $dbh = dbconnect() or die ('Set Rapsheet error: ' . mysqli_error($dbh) . "<br>");
    mysqli_select_db($dbh, "adras_database");
    $sql_query = mysqli_query($dbh, "UPDATE muted SET mute = '$val' WHERE channel = '$chan'") or die(mysqli_error($dbh));
    mysqli_close($dbh);
    return 1;
}
?>