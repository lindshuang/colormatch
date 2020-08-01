<?php

session_start();

if (!isset($_GET["term"]) || empty($_GET["term"])){
	echo "invalid sortby parameter";

}else{

$sortby = $_GET["term"];
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


//get all results
if ($sortby == "high"){
	$sql_get_results = "SELECT score, date, level FROM results JOIN levels ON results.levelID = levels.levelID WHERE userID = " . $userID . " ORDER BY score DESC;";

}else if ($sortby == "level"){
	$sql_get_results = "SELECT score, date, level FROM results JOIN levels ON results.levelID = levels.levelID WHERE userID = " . $userID . " ORDER BY results.levelID ASC;";

	// $sql_get_results = "SELECT score, date, level, results.levelID FROM results JOIN levels ON results.levelID = levels.levelID WHERE userID = " . $userID . " ORDER BY levelID ASC;";
}else if ($sortby == "recent"){
	$sql_get_results = "SELECT score, date, level FROM results JOIN levels ON results.levelID = levels.levelID WHERE userID = " . $userID . " ORDER BY date DESC;";
}

$results = $mysqli->query($sql_get_results);
if(!$results) {
		echo $mysqli->error;
		exit();
}

if ($results->num_rows == 0){
	echo json_encode((object) null);
}else{
	$results_array = [];
	// Run through results, add them into $results_array
	while($row = $results->fetch_assoc()) {
	array_push($results_array, $row);
	}

// Convert the assoc array to json string
echo json_encode($results_array);

}

$mysqli->close();

}


?>




