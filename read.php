<?php

DEFINE('DBUSER', 'if0_37982722');
DEFINE('DBPW', 'yO7FdeWU44');
DEFINE('DBHOST', 'sql313.infinityfree.com');
DEFINE('DBNAME', 'if0_37982722_GameDB');

// Establish database connection
$dbc = mysqli_connect(DBHOST, DBUSER, DBPW, DBNAME);
if (!$dbc) {
    die("Database connection failed: " . mysqli_connect_error());
    exit();
}

// Sanitize input
$ID = mysqli_real_escape_string($dbc, $_GET['ID']);

// Query to fetch user name
$query = "SELECT NAME FROM USERS WHERE ID = $ID";
$result = mysqli_query($dbc, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_row($result); // Fetch the NAME column
    $NAME = $row[0];

    // Query to fetch GameState details
    $GameStateQuery = "SELECT Highscore, Current_Score, Current_Interval, Current_Lives FROM GameState WHERE UserID = $ID";
    $GameStateResult = mysqli_query($dbc, $GameStateQuery);

    if ($GameStateResult && mysqli_num_rows($GameStateResult) > 0) {
        $gameRow = mysqli_fetch_assoc($GameStateResult);
        $HIGHSCORE = $gameRow['Highscore'];
        $CURRENT_SCORE = $gameRow['Current_Score'];
        $CURRENT_INTERVAL = $gameRow['Current_Interval'];
        $CURRENT_LIVES = $gameRow['Current_Lives'];

        // Return the results as JSON
        echo json_encode([
            "status" => "success",
            "user" => $NAME,
            "gameState" => [
                "highscore" => $HIGHSCORE,
                "current_score" => $CURRENT_SCORE,
                "current_interval" => $CURRENT_INTERVAL,
                "current_lives" => $CURRENT_LIVES
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "GameState not found for UserID $ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found for ID $ID"]);
}

// Close the database connection
mysqli_close($dbc);
exit;
?>
