<?php
if (isset($_GET['bookId'])) {
	$bookId = $_GET['bookId'];
} else {
	// TODO Send the user back
}
include "includes/getDb.inc.php";

$array = getBookByBookId($bookId);
if (isset($_SESSION['userId'])) {
	$userinfo = getUserInfo($_SESSION['userId']);
} else {
	$userinfo = NULL;
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/bookpagev2.css">

	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

	<title>BonoLibro</title>
</head>

<body>
	<script type="text/javascript">
		function switchRating() {

			var rating = document.getElementById("rating");
			var button = document.getElementById("ratingButton");
			button.innerText = rating.style.display;
			if (rating.style.display == "none" || rating.style.display == "" || rating.style.display == null) {
				rating.style.display = "block";
				button.innerText = "Dölj betyg";
			} else if (rating.style.display == "block") {
				rating.style.display = "none";
				button.innerText = "Visa betyg";
			}
		}
	</script>

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
		<div class="main-firstRow">
			<div class="main-container-book">
				<div class="book-image">
					<?php echo '<img src="' . $array['9'] . '" alt="Books">'; ?>

					<div class="container-addToList">
						<button>Lägg till i lista</button>
						<button>Lägg till i lista</button>
						<button>Lägg till i lista</button>
					</div>
				</div>

				<div class="book-information">
					<div class="header">
						<h1 id="book-title"><?php echo $array['1']; ?></h1>
						<p>Skriven av <a href="author.php"><?php echo $array['2'] ?></a></p>

						<br>

						<button type="button" onclick="switchRating()" id="ratingButton">Visa betyg</button>
						<p id="rating">
							<?php
							if ($array['11'] == NULL) {
								echo 'Inga betyg för denna bok än';
							} else {
								echo $array['11'];
							}
							?>
						</p>

						<form action="includes/addBook.inc.php?type=rating&bookId=<?php echo $bookId ?>" method="post" class="rate">
							<?php
							function isBookRated($bookId, $userinfo)
							{
								if (isset($userinfo['4'])) {
									if (!contains(';:', $userinfo['4']) && strcasecmp($userinfo['4'], $bookId) == 0) {
										return $userinfo['5'];
									} else if (!contains(';:', $userinfo['4']) && strcasecmp($userinfo['4'], $bookId) != 0) {
										return false;
									} else {
										$ratedBooksId = explode(";:", $userinfo['4']);
										for ($x = 0; $x < sizeof($ratedBooksId); $x++) {
											if (strcasecmp($bookId, $ratedBooksId[strval($x)]) == 0) {
												$tmpArray = explode(';:', $userinfo['5']);
												return $tmpArray[strval($x)];
											}
										}
										return false;
									}
								}
							}
							$bookRated = isBookRated($bookId, $userinfo);
							if ($bookRated == false) {
								echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
							} else {
								if ($bookRated == 1) {
									echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();" checked="checked"><label for="star1" title="Väldigt dålig"></label>';
								} else if ($bookRated == 2) {
									echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();" checked="checked"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
								} else if ($bookRated == 3) {
									echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();" checked="checked"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
								} else if ($bookRated == 4) {
									echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();" checked="checked"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
								} else if ($bookRated == 5) {
									echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();" checked="checked"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
								}
							}
							?>
						</form>
					</div>


					<hr>

					<div class="tab-container">
						<div class="tabButton-container">
							<button onclick="showTabPanel(0, 'rgb(43, 161, 140)')">Beskrivning</button>
							<button onclick="showTabPanel(1, 'rgb(43, 161, 140)')">Information</button>
						</div>

						<div class="tabPanel">
							<?php
							echo '<p>' . $array['5'] . '</p>';
							?>
						</div>

						<div class="tabPanel">
							<p><strong>Författare:</strong> <?php echo $array['2'] ?></p>
							<p><strong>Förlag:</strong> <?php echo $array['3'] ?></p>
							<p><strong>Utgiven:</strong> <?php echo $array['4'] ?></p>
							<p><strong>ISBN:</strong> <?php echo $array['6'] ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="main-secondRow">
			<div class="main-container-comments">
				<h2>Kommentarer</h2>
				<?php

				// TODO lägga till så att ;: och :: är illegala tecken när man skriven en kommentar
				// TODO kanske ändra så att man inte får all info i getuserinfo
				if ($array['12'] == NULL) {
					echo '<div class="comment">Var den första att skriva en kommentar för denna bok!</div>';
				} else if (!contains(';:', $array['12'])) {
					$comment = explode('::', $array['12']);
					$commentUserinfo = getUserInfo($comment['0']);
					echo '<div class="comment"><div class="name">' . $commentUserinfo['8'] . ' ' . $commentUserinfo['9'] . '</div>';
					if (isset($_SESSION['userId']) && $_SESSION['userId'] == $comment['0']) {
						echo '<div class="edit-remove"><a href="includes/addBook.inc.php?type=removeComment&bookId=' . $bookId . '&comment=' . $array['12'] . '">radera</a></div>';
					}
					echo '<br><div class="comment-text">' . $comment['1'] . '</div></div>';
				} else {
					$comments = explode(';:', $array['12']);
					foreach ($comments as $x) {
						$comment = explode('::', $x);
						$commentUserinfo = getUserInfo($comment['0']);
						echo '<div class="comment"><div class="name">' . $commentUserinfo['8'] . ' ' . $commentUserinfo['9'] . '</div>';
						if ($_SESSION['userId'] == $comment['0']) {
							echo '<div class="edit-remove"><a href="includes/addBook.inc.php?type=removeComment&bookId=' . $bookId . '&comment=' . $x . '">radera</a></div>';
						}
						echo '<br><div class="comment-text">' . $comment['1'] . '</div></div>';
					}
				}
				if (isset($_SESSION['userId'])) {
					// TODO ta hand om tom textarea här
					// TODO lägga till så att man kan edita och ta bor kommentarer
					echo '<form action="includes/addBook.inc.php?type=comment&bookId=' . $bookId . '" method="post">
                            Skriv en kommentar:<br>
                            <textarea class="text" name="comment"></textarea>
                            <button type="submit" class="button1">Publicera</button>
                        </form>';
				} else {
					// TODO länka till inlogning och skapa konto
					echo '<a href="login.php">Logga</a> in eller <a href="signup.php">skapa ett konto</a> för att skriva en kommentar.';
				}
				?>
			</div>

			<div class="main-container-reviews">

			</div>
		</div>
	</main>

	<script>
		// Mobile version menu/navigation
		(function() {
			var menu = document.querySelector('ul'),
				menulink = document.querySelector('#menu-icon');

			menulink.addEventListener('click', function(e) {
				menu.classList.toggle('active');
				e.preventDefault();
			});
		})();

		// Tab container (Beskrivning, specifik information)
		var tabButtons = document.querySelectorAll(".tab-container .tabButton-container button");
		var tabPanels = document.querySelectorAll(".tab-container .tabPanel");

		function showTabPanel(panelIndex, colorCode) {
			tabButtons.forEach(function(btn) {
				btn.style.backgroundColor = "";
				btn.style.color = "";
				btn.style.textDecoration = "none";
			});
			tabButtons[panelIndex].style.backgroundColor = colorCode;
			tabButtons[panelIndex].style.color = "white";
			tabButtons[panelIndex].style.textDecoration = "underline";

			tabPanels.forEach(function(tab) {
				tab.style.display = "none";
			});
			tabPanels[panelIndex].style.display = "block";
			tabPanels[panelIndex].style.backgroundColor = "white";
		}
		showTabPanel(0, 'rgb(43, 161, 140)');
	</script>
</body>

</html>