<?php

session_start();


if (!isset($_POST["date"]) || empty($_POST["date"])){
	echo "invalid date";

}else{

	$date = $_POST["date"];


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

//get userID corresponding to email
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


//delete
$sql_delete = "DELETE FROM results WHERE userID = " . $userID . " AND date = '" . $date . "';";

$results = $mysqli->query($sql_delete);
if(!$results) {
		echo $mysqli->error;
		exit();
}

//update high score if needed and games played
$sql_update_games = "UPDATE users SET games_played = games_played - 1 WHERE userID = " . $userID . ";";
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

//no scores left
if ($high_scores->num_rows == 0){
	$sql_update_score = "UPDATE users SET high_score = 0 " .  " WHERE userID = " . $userID;
	// echo $sql_update_score . "\r\n";
	$update = $mysqli->query($sql_update_score);
	if(!$update) {
		echo $mysqli->error;
		exit();
	}

}else{

	$high_score = $high_scores->fetch_assoc();

	$sql_update_score = "UPDATE users SET high_score = " . $high_score["score"] . " WHERE userID =  " . $userID;
	// echo $sql_update_score . "\r\n";
	$update = $mysqli->query($sql_update_score);
	if(!$update) {
		echo $mysqli->error;
		exit();
	}
}

$mysqli->close();

}


?>




