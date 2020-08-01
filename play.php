<?php

  session_start();
  $activePage = 'play';

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
<script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>

<style>
	 body{
      background-color: white;
      background: none;
   }
</style>
</head>

<body onload ="setRandomColor()">

<?php
  include('nav.php');
?>

<div id = "timerParent">
  <div id="progressTimer"></div>
</div>


  <div id = "selected"></div>

<div class="wheel-wrapper">
    <div id="wheel">
      <div id="picker"></div>
      <div id="values"></div>
    </div>
</div>

<!-- color pop up -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <h2 id = "final_score"></h2>
    <h6 id = "msg"></h6>
    <div class = "play-btns">
      <button id = "next" class = "btn btn-next-play">Next Color</button>
    </div>
  </div>

</div>

<!-- end game pop up -->
<div id="end-game" class="endModal">

  <!-- Modal content -->
  <div class="modal-content">
    <h2 id = "ending_score"></h2>
    <div class = "play-btns">
      <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>
        <a href="results.php" class = "btn btn-results speed-mode">View All Results</a>
      <?php endif;?>
      <a href="index.php" class = "btn btn-next-play speed-mode">Done</a>
    </div>
  </div>

</div>
	
<div class = "footer"></div>


</body>

<script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://apis.google.com/js/api:client.js"></script>
<script src="google_login.js"></script>
<script> startApp(); </script>

<script src="jquery.progressTimer.js"></script>
<script src = "play.js"></script>

</html>