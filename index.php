<?php
	// need to start session
	session_start();
	$activePage = "play";

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){

//credentials
$host = "303.itpwebdev.com";
$user = "huan981_db_user";
$password = "itp303_test";
$db = "huan981_color_match";

$mysqli = new mysqli($host, $user, $password, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

//display games played and high score by storing in session
$sql_data = "SELECT high_score, games_played FROM users WHERE email = '" . $_SESSION["email"] . "'";
$response = $mysqli->query($sql_data);
	if(!$response) {
		echo $mysqli->error;
		exit();
	}

$data = $response->fetch_assoc();

$games_played = $data['games_played'];
// echo "games:" . $games_played;
$high_score = $data['high_score'];
// echo "high score: " . $high_score;

$_SESSION["games_played"] = $games_played;
$_SESSION["high_score"] = $high_score;

$mysqli->close();

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Color Matching</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://kit.fontawesome.com/de79172ee1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

<meta name="google-signin-client_id" content="1070054651173-2je2vs1jfr7nfv840gfef8grdj5e75ea.apps.googleusercontent.com">

<style>
	.nav-custom{
		background-color: transparent;
	}
	.nav-link{
		color: white !important;
		font-weight: 300;
	}
	.active-item{
		font-weight: 600;
	}
</style>
</head>
<body>

	<!-- special navbar for homepage -->

	<nav class="navbar navbar-expand-md navbar-dark nav-custom">
    <div class="d-flex flex-grow-1">
        <span class="w-100 d-lg-none d-block"><!-- hidden spacer to center brand on mobile --></span>
        <a class="navbar-brand d-none d-lg-inline-block" href="index.php">
            <img class = "logo" alt= "logo" src = "./images/logo-white.png">
        </a>
        <a class="navbar-brand-two mx-auto d-lg-none d-inline-block" href="index.php">
            <img class = "logo-mobile" alt= "logo" src = "./images/logo-white.png">        
        </a>
        <div class="w-100 text-right">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>

    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>
         <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
        <ul class="navbar-nav ml-auto flex-nowrap">
            <li class="nav-item">
                <a href="instructions.php" class="nav-link m-2 menu-item <?= ($activePage == 'instructions') ? 'active-item':''; ?>">instructions</a>
            </li>
            <li class="nav-item">
                <a href="index.php" class="nav-link m-2 menu-item <?= ($activePage == 'play') ? 'active-item':''; ?>">play</a>
            </li>
            <li class="nav-item">
                <a href="results.php" class="nav-link m-2 menu-item <?= ($activePage == 'results') ? 'active-item':''; ?>">results</a>
            </li>
            <li class="nav-item">
                <a href="#" id = "logout-btn" class="nav-link m-2 menu-item">logout</a>
            </li>
        </ul>
    </div>

    <?php else:?>

     <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
        <ul class="navbar-nav ml-auto flex-nowrap">
            <li class="nav-item">
                <a href="instructions.php" class="nav-link m-2 menu-item <?= ($activePage == 'instructions') ? 'active-item':''; ?>">instructions</a>
            </li>
            <li class="nav-item">
                <a href="index.php" class="nav-link m-2 menu-item <?= ($activePage == 'play') ? 'active-item':''; ?>">play</a>
            </li>
        </ul>
    </div>

<?php endif;?>
</nav>

	<div class = "text">

		<div class = "login-modal">
			<div class = "inner-div">
				<img class = "logo-login" alt = "logo" src = "./images/colormatch.png">
			</div>

			<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>
			
			<div class = "inner-div">
				<div class = "loggedin">
					<h4 class = "welcome">Welcome, <?php echo $_SESSION["name"]?></h4>
					<div class = "player-stats">
						<p class = "stats">Games Played:    <span class = "data"><?php echo $_SESSION["games_played"]?></span></p>	
						<p class = "stats">High Score:    <span class = "data"><?php echo $_SESSION["high_score"]?></span></p>
					</div>
				</div>
			</div>

			<?php else:?>
				<div class = "inner-div">
				<p class = "description">Log in to save your results</p>

				 <div id="gSignInWrapper">
    				<button id = "gbtn" class = "google-btn btn"><i class="fab white-btn-icon fa-google"></i>Sign In with Google</button>
  				</div>
  			</div>
			<?php endif;?>


			<div class = "inner-div">

			<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>
			<?php else:?>
				<p class = "description"> Or play as guest </p>
			<?php endif;?>
				<a href="play.php?level=easy" class = "btn play-btn reg-mode">Easy</a>
				<a href="play.php?level=medium" class = "btn play-btn speed-mode">Medium</a>
				<a href="play.php?level=hard" class = "btn play-btn hard-mode">Hard</a>
			</div>
		</div>	
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

</html>