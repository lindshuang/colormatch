<?php

session_start();

$_SESSION["logged_in"] = true;
$_SESSION["email"] = $_POST["email"];

if ( isset($_POST['name']) && !empty($_POST['name']) ) {
	$_SESSION["name"] = $_POST["name"];
}

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
$name = $mysqli->real_escape_string($_POST["name"]);

//check if user exists
$sql_check = "SELECT * FROM users WHERE email = '" . $_POST["email"] . "'";
$check_results = $mysqli->query($sql_check);
if(!$check_results) {
		echo $mysqli->error;
		exit();
}

$num_rows = mysqli_num_rows($check_results); 

if ($num_rows == 0) {
  // if user doesn't exist, add new user into users
	$sql = "INSERT INTO users (email, name, high_score, games_played)
 	VALUES('" . $_POST["email"] ."', '" . $name . "', 0, 0)";

	//error checking
	$results = $mysqli->query($sql);
		if(!$results) {
			echo $mysqli->error;
			exit();
		}

	if($mysqli->affected_rows == 1) {
		// echo "inserted!";
		$isInserted = true;
	}
}

$mysqli->close();

?>