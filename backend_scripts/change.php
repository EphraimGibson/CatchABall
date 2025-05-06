<?php

DEFINE ('DBUSER', 'if0_37982722');
DEFINE ('DBPW', 'yO7FdeWU44');
DEFINE ('DBHOST', 'sql313.infinityfree.com');
DEFINE ('DBNAME', 'if0_37982722_GameDB');

// Connect to the database
$dbc = mysqli_connect(DBHOST, DBUSER, DBPW);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$dbs = mysqli_select_db($dbc, DBNAME);
if (!$dbs) {
    die("Database selection failed: " . mysqli_error($dbc));
    exit();
}

// Sanitize input parameters
$USERID = mysqli_real_escape_string($dbc, $_GET['USERID']);
$CURRENT_SCORE = mysqli_real_escape_string($dbc, $_GET['CURRENT_SCORE']);
$CURRENT_INTERVAL = mysqli_real_escape_string($dbc, $_GET['CURRENT_INTERVAL']);
$CURRENT_LIVES = mysqli_real_escape_string($dbc, $_GET['CURRENT_LIVES']);


// Check current high score for the user
$check_query = "SELECT Highscore FROM GameState WHERE UserID = $USERID";
$check_result = mysqli_query($dbc, $check_query);

if ($check_result && mysqli_num_rows($check_result) > 0) {
    $row = mysqli_fetch_assoc($check_result);
    $current_highscore = $row['Highscore'];

    // Update Highscore only if Current_Score is greater
    if ($CURRENT_SCORE > $current_highscore) {
        $HIGHSCORE = $CURRENT_SCORE;
    }
    else{
        $HIGHSCORE = $current_highscore;
    }

    // Update the database
    $query = "UPDATE GameState
              SET Highscore = '$HIGHSCORE', 
                  Current_Score = '$CURRENT_SCORE', 
                  Current_Interval = '$CURRENT_INTERVAL',
                  current_lives = '$CURRENT_LIVES'
              WHERE UserID = $USERID";
    $result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
} else {
    echo "UserID not found in GameState table.";
}

mysqli_close($dbc);
exit;
?>

<!-- http://catchabaldb.freesite.online/change.php?USERID=2&CURRENT_SCORE=4&CURRENT_INTERVAL=3&CURRENT_LIVES=1 -->

