<?php

DEFINE ('DBUSER', 'if0_37982722');
DEFINE ('DBPW', 'yO7FdeWU44');
DEFINE ('DBHOST', 'sql313.infinityfree.com');
DEFINE ('DBNAME', 'if0_37982722_GameDB');

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

$NAME = mysqli_real_escape_string($dbc, $_GET['NAME']);
$LOGINNAME = mysqli_real_escape_string($dbc,$_GET['LOGINNAME']);
$PASSWORD = mysqli_real_escape_string($dbc,$_GET['PASSWORD']);

$query = "INSERT IGNORE INTO USERS (NAME, LOGINNAME, PASSWORD) VALUES ('$NAME','$LOGINNAME','$PASSWORD')";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));

if (mysqli_affected_rows($dbc) > 0){
        $UserID = mysqli_insert_id($dbc);
    echo "User Created";
    $game_query = "INSERT INTO GameState (UserID) VALUES ($UserID)";
    $game_results = mysqli_query($dbc,$game_query) or trigger_error("GameState query error" . mysqli_error($dbc));
}
else {
    echo "Failed to create user. LOGINNAME already exists.";
}
mysqli_close($dbc);
exit;
?>

<!--
http://catchaball.liveblog365.com/create.php?NAME=first&LOGINNAME=first&PASSWORD=first
-->
