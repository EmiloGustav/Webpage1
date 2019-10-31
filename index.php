<?php
include 'includes/getDb.inc.php';
session_start();
if (isset($_SESSION['userId'])) {
	header("Location: http://$_SERVER[HTTP_HOST]/Webpage1/index-loggedin.php");
	exit();
}
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

			<div class="main-container-search">
				<h1>Sök och utforska böcker</h1>
				<form action="SearchResult.php" method="get">
					<input type="text" id="searchbar" name="book" placeholder="Titel, författare eller ISBN.." autocomplete="off">
					<input type="submit" id="btnSearch" value="Sök">
				</form>
			</div>

		</div>

		<div class="main-rightColumn">
			<div class="main-container-slideshowOfPopularBooks">

				<h1>Populärast just nu</h1>

				<div class="slideshow-item">
					<div class="book">
						<a href="bookpage.php" class="img-link"><img src="images/greatgatsby.jpg" alt=""></a>
						<div class="description">
							<h1>The Great Gatsbty</h1>
							<p>Skriven av</p>
							<a href="author.php" class="list-bookAuthor">Fitzergald</a>
						</div>
					</div>
					

				</div>

				<div class="slideshow-item">
					<div class="book">
						<a href="bookpage.php" class="img-link"><img src="images/fahrenheit.jpg" alt=""></a>
						<div class="description">
							<h1><a>Fahrenheit</a></h1>
							<p>Skriven av</p>
							<a href="author.php" class="list-bookAuthor">Ray Bradbury</a>
						</div>
					</div>
				</div>

				<div class="slideshow-item">
					<div class="book">
						<a href="bookpage.php" class="img-link"><img src="images/harrypotter.jpg" alt=""></a>
						<div class="description">
							<h1>Harry Potter</h1>
							<p>Skriven av</p>
							<a href="author.php" class="list-bookAuthor">J.K. Rowling</a>
						</div>
					</div>
					
				</div>

			</div>

			<div class="main-container-latestUpdates">
				<h1>Nyheter</h1>
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

	<script>
		var slideIndex = 0;
		showSlides();

		function showSlides() {
			var i;
			var slides = document.getElementsByClassName("slideshow-item");
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";
			}
			slideIndex++;
			if (slideIndex > slides.length) {
				slideIndex = 1;
			}
			slides[slideIndex - 1].style.display = "block";
			setTimeout(showSlides, 3000);
		}
	</script>
</body>

</html>