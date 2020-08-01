<?php

session_start();
date_default_timezone_set('America/Los_Angeles');


if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){

//credentials
$host = "303.itpwebdev.com";
$user = "huan981_db_user";
$password = "itp303_test";
$db = "huan981_color_match";

// DB Connection
$mysqli = new mysqli($host, $user, $password, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

//store results
$sql_getID = "SELECT userID from users WHERE email = '" . $_SESSION["email"] . "'";
// echo $sql_getID . "\r\n";
$userID_results = $mysqli->query($sql_getID);
if(!$userID_results) {
		echo $mysqli->error;
		exit();
}

$userID_array = $userID_results->fetch_assoc();
$userID = $userID_array["userID"];
// echo $userID . "\r\n";

$date= date('Y-m-d H:i:s');

//find levelID for passed in level
$sql_find_level = "SELECT levelID FROM levels WHERE level = '" . $_POST["level"] . "';";
$levels = $mysqli->query($sql_find_level);
if(!$levels) {
		echo $mysqli->error;
		exit();
}

$level_arr = $levels->fetch_assoc();
$levelID = $level_arr["levelID"];
// echo $levelID . "\r\n";


//insert into results
$sql_insert = "INSERT INTO results(userID, levelID, score, date) VALUES(" . $userID . "," . $levelID . "," . $_POST["score"]
 . ", '" . $date . "');";
// echo $sql_insert . "\r\n";
$insert = $mysqli->query($sql_insert);
if(!$insert) {
		echo $mysqli->error;
		exit();
}

//update games played and high score
$sql_update_games = "UPDATE users SET games_played = games_played + 1 WHERE userID = " . $userID . ";";
// echo $sql_update_games . "\r\n";
$update_game = $mysqli->query($sql_update_games);
if(!$update_game ) {
		echo $mysqli->error;
		exit();
}

//get updates games
$sql_get_games = "SELECT games_played FROM users WHERE userID = " . $userID . ";";
// echo $sql_get_games . "\r\n";
$games_played_result = $mysqli->query($sql_get_games);
if(!$games_played_result) {
		echo $mysqli->error;
		exit();
}

$games_played = $games_played_result->fetch_assoc();

//update high score
$sql_get_scores = "SELECT score FROM results WHERE userID = " . $userID . " ORDER BY score DESC;";
// echo $sql_get_scores . "\r\n";
$high_scores = $mysqli->query($sql_get_scores);
if(!$high_scores) {
		echo $mysqli->error;
		exit();
}

$high_score = $high_scores->fetch_assoc();

$sql_update_score = "UPDATE users SET high_score = " . $high_score["score"] . " WHERE userID =  " . $userID;
// echo $sql_update_score . "\r\n";
$update = $mysqli->query($sql_update_score);
if(!$update) {
		echo $mysqli->error;
		exit();
}

//update session
$_SESSION["games_played"] = $games_played["games_played"];
$_SESSION["high_score"] = $high_score["score"];

$mysqli->close();

}else{
	// echo "not logged in, no results to save";
}

?>