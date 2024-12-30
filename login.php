<?php

DEFINE ('DBUSER', 'if0_37982722');
DEFINE ('DBPW', 'yO7FdeWU44');
DEFINE ('DBHOST', 'sql313.infinityfree.com');
DEFINE ('DBNAME', 'if0_37982722_GameDB');

//$SQLKEY="S1@@md:g";
 
$dbc = mysqli_connect(DBHOST,DBUSER,DBPW);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$dbs = mysqli_select_db($dbc, DBNAME);
if (!$dbs) {
    die("Database selection failed: " . mysqli_error($dbc));
    exit();
}

$LOGINNAME = mysqli_real_escape_string($dbc,$_GET['LOGINNAME']);
$PASSWORD = mysqli_real_escape_string($dbc,$_GET['PASSWORD']);

$query = "SELECT ID FROM USERS WHERE LOGINNAME='$LOGINNAME' and PASSWORD='$PASSWORD'";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));

if(mysqli_num_rows($result) > 0)
{
      $row = mysqli_fetch_row($result);
      $id = $row[0]; 
    echo json_encode(["status" => "success", "message" => "Login successful.","ID" => $id]);
}
else
{
    echo json_encode(["status" => "error", "message" => "Invalid login credentials."]);
}
$dbc->close();
exit();
?>
<!-- http://catchaball.liveblog365.com/login.php?LOGINNAME=first&PASSWORD=first

$row =  mysqli_fetch_row($result);
print $row[0];
-->
