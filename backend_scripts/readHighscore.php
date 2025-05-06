<?php

DEFINE('DBUSER', 'if0_37982722');
DEFINE('DBPW', 'yO7FdeWU44');
DEFINE('DBHOST', 'sql313.infinityfree.com');
DEFINE('DBNAME', 'if0_37982722_GameDB');

// Establish database connection
$dbc = mysqli_connect(DBHOST, DBUSER, DBPW, DBNAME);
if (!$dbc) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]));
}

// Sanitize input
$ID = mysqli_real_escape_string($dbc, $_GET['ID']);

// Query to fetch the highest score in the table
$highestScoreQuery = "SELECT MAX(Highscore) AS HighestScore FROM GameState";
$highestScoreResult = mysqli_query($dbc, $highestScoreQuery);

if ($highestScoreResult && mysqli_num_rows($highestScoreResult) > 0) {
    $highestScoreRow = mysqli_fetch_assoc($highestScoreResult);
    $highestScore = $highestScoreRow['HighestScore'];
} else {
    echo json_encode(["status" => "error", "message" => "Failed to retrieve the highest score."]);
    mysqli_close($dbc);
    exit();
}

// Query to fetch the current user's high score
$userQuery = "SELECT Highscore FROM GameState WHERE UserID = $ID";
$userResult = mysqli_query($dbc, $userQuery);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userRow = mysqli_fetch_assoc($userResult);

    $HIGHSCORE = $userRow['Highscore'];

    // Return the results as JSON
    echo json_encode([
        "status" => "success",
        "highestScoreInTable" => $highestScore,
        "userHighscore" => $HIGHSCORE
        ]
    );
} else {
    echo json_encode(["status" => "error", "message" => "GameState not found for UserID $ID"]);
}

// Close the database connection
mysqli_close($dbc);
?>
