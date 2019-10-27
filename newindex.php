<?php
include 'includes/getDb.inc.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/index/index.css">

	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

	<title>BonoLibro</title>
</head>

<body>
	<aside>
		<figure>
			<img id="logotype" src="images/books.png" alt="">
			<figcaption>BonoLibro</figcaption>
		</figure>
		<img id="menu-icon" src="images\menu.svg" alt="">

		<nav>
			<ul>
				<li><a href="login.php">Logga in</a></li>
				<hr>
				<li><a href="signup.php">Registrera</a></li>
				<hr>
			</ul>
		</nav>
	</aside>

	<main>
		<div class="main-leftColumn">
			<div class="main-container-welcomeMessage">
				<h1 id="title-mobile">Välkommen</h1>
				<h1 id="title-desktop">Välkommen till BonoLibro</h1>
				<p>På BonoLibro kan du samla alla dina böcker som du har läst, läser eller vill läsa.</p>
				<a href="signup.php" class="cna">Skapa ett nytt konto</a>
			</div>

			<div class="main-container-listOfPopularBooks">
				<h1>Populärast just nu</h1>
				<a href="bookpage.php" class="img-link"><img src="images/greatgatsby.jpg" alt=""></a>
				<a href="bookpage.php" class="img-link"><img src="images/fahrenheit.jpg" alt=""></a>
				<a href="bookpage.php" class="img-link"><img src="images/harrypotter.jpg" alt=""></a>
				<a href="#">Fler topplistor</a>
			</div>
		</div>

		<div class="main-rightColumn">
			<div class="main-container-latestUpdates">
				<h1>Senaste uppdateringarna</h1>
			</div>
			
			<div class="main-container-ads">
				<h1>Det här är reklam.</h1>
			</div>
		</div>
	</main>

	<script>
		(function() {
			var menu = document.querySelector('ul'),
				menulink = document.querySelector('#menu-icon');

			menulink.addEventListener('click', function(e) {
				menu.classList.toggle('active');
				e.preventDefault();
			});
		})();
	</script>
</body>

</html>