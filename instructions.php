<?php
  session_start();
  $activePage = 'instructions';
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

<style>
  body{
    background: none;
    background-color: white;
  }
</style>

</head>
<body>

    <?php
        include('nav.php');
    ?>


	<div class = "content-div">
		<h4 class = "content-title">Instructions</h4>
    <h6 class= "content-subtitle">colormatch is a game that tests your color perception.</h6>
    <p>
      You will be presented with a series of colors, displayed on the bottom half of the page.  Using the color picker on the page, match the top color to the bottom color as closely as possible before time runs out! Double click when you're ready to check your color.
    </p>
    <img id = "ex-image" alt = "example" src = "./images/example.png">
    <p id = "ex-description"> goal: select a color as close to the mauve (bottom half) as possible!</p>
    <p>
      You’ll receive a score for each color based on how close your pick was to the correct color. At the end of the game, your scores will be totaled out of 500!

    </p>
    <p>
      Please log in with Google to save your results and view past results. Or, play as an unregistered guest. Good luck!
    </p>
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