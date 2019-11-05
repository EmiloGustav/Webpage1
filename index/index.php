<?php
include '../includes/getDb.php';
session_start();
$getDb = new getDb();
if (isset($_SESSION['userId'])) {
	header("Location: http://$_SERVER[HTTP_HOST]/Webpage1/index/index-loggedin.php");
	exit();
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" type="text/css" href="index.css">

	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

	<title>BonoLibro</title>
</head>

<body>
	<aside>
		<figure>
			<img id="logotype" src="../images/books.png" alt="">
			<figcaption>BonoLibro</figcaption>
		</figure>
		<img id="menu-icon" src="../images/menu.svg" alt="">

		<nav>
			<ul>
				<li><a href="../login-logout/login.php">Logga in</a></li>
				<hr>
				<li><a href="../signup/signup.php">Registrera</a></li>
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
				<form action="../searchresult/SearchResult.php" method="get">
					<input type="text" id="searchbar" name="book" placeholder="Titel, författare eller ISBN.." autocomplete="off">
					<input type="submit" id="btnSearch" value="Sök">
				</form>
			</div>

			<div class="main-container-latestUpdates">
				<h1>Nyheter</h1>
			</div>
		</div>

		<div class="main-rightColumn">
			<div class="main-container-slideshowOfPopularBooks">
				<h1>Populärast just nu</h1>

				<?php
				$data = $getDb->getTheThreeHighestRatedBooks();
				?>

				<div class="slideshow-item">
					<div class="book">
						<?php echo '<a href="../bookpage/bookpage.php" class="img-link"><img src="' .$data[0]['smallthumbnail'].'" alt=""></a>'; ?>
						<div class="description">
							<?php echo '<h1>'.$data[0]['title'].'</h1>';
							echo '<p>Skriven av</p>';
							echo '<a href="author.php" class="list-bookAuthor">'.$data[0]['author'].'</a>';
							?>
						</div>
					</div>
				</div>

				<div class="slideshow-item">
					<div class="book">
						<?php echo '<a href="../bookpage/bookpage.php?bookId=12" class="img-link"><img src="'.$data[1]['smallthumbnail'].'" alt=""></a>'; ?>
						<div class="description">
							<?php echo '<h1>'.$data[1]['title'].'</h1>';
							echo '<p>Skriven av</p>';
							echo '<a href="author.php" class="list-bookAuthor">'.$data[1]['author'].'</a>';
							?>
						</div>
					</div>
				</div>

				<div class="slideshow-item">
					<div class="book">
						<?php echo '<a href="../bookpage/bookpage.php" class="img-link"><img src="'.$data[2]['smallthumbnail'].'" alt=""></a>'; ?>
						<div class="description">
							<?php echo '<h1>'.$data[2]['title'].'</h1>';
							echo '<p>Skriven av</p>';
							echo '<a href="author.php" class="list-bookAuthor">'.$data[2]['author'].'</a>';
							?>
						</div>
					</div>
				</div>

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