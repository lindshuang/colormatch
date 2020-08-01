<?php

session_start();

$activePage = 'results';

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
$sql_get_results = "SELECT score, date, level FROM results JOIN levels ON results.levelID = levels.levelID WHERE userID = " . $userID . " ORDER BY date DESC;";
$results = $mysqli->query($sql_get_results);
if(!$results) {
		echo $mysqli->error;
		exit();
}

$mysqli->close();

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Color Matching</title>
	<!-- Latest compiled and minified CSS -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://kit.fontawesome.com/de79172ee1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">


<style>
	body{
		background-color: white;
		background: none;
	}
</style>

</head>
<body>

	<?php
  		include('nav.php');
	?>
		
		<div class = "result-header">
			<h3 class = "content-title"><?php echo $_SESSION["name"];?>'s Scores</h3>

			<!-- sorting dropdown -->
			<div class="dropdown">
  				<button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    			Sort By
  				</button>
  				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
   					<a class="dropdown-item custom-dd" href="#" id="high">High Score</a>
   					<a class="dropdown-item custom-dd" id = "recent" href="#">Most Recent</a>
   					<a class="dropdown-item custom-dd" id = "level" href="#">Level</a>
  				</div>
			</div>
		</div>
	<!-- 	</div> -->

		<div class = "result-gallery">

		<?php if ($results->num_rows == 0) : ?>
			<div><p>No results yet! Play now!</p></div>
		<?php else: ?>

		<?php while($row = $results->fetch_assoc()) : ?>
		<div class="gallery">
			<div class="flip-card-inner">
				<div class="flip-card-front <?php echo$row['level']?>">
					<h3 class = "score"><?php echo $row['score']; ?></h3>
					<h6 class = "level"><?php echo$row['level']?> </h6>
					<p class = "date"><?php echo substr($row['date'], 6, 10); ?></p>
				</div>
				 <div class="flip-card-back">
				 	<div class ="back-inner">
				 		<a href="#" class = "delete-link"><i class="far fa-trash-alt fa-2x"></i></a>
				 		<p class = "hidden"><?php echo $row['date']; ?></p>
				 	</div>
    			 </div>
    		</div>
    	</div>

		<?php endwhile; ?>
		<?php endif;?>

		</div>	

	<div class = "footer">
	</div>

</body>

<script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://apis.google.com/js/api:client.js"></script>
<script src="google_login.js"></script>
<script> startApp(); </script>

<script src= "results.js"></script>


</html>