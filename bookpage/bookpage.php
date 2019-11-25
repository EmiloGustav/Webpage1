<?php
if (isset($_GET['bookId'])) {
	$bookId = $_GET['bookId'];
} else {
	// TODO Send the user back
}

session_start();
include "../includes/getDb.php";
include "php/bookpageHelper.php";
$getDb = new getDb();
$help = new helper();
$bookpageHelper = new bookpageHelper();
$array = $getDb->getBookByBookId($bookId);
if (isset($_SESSION['userId'])) {
	$userinfo = $getDb->getUserInfo($_SESSION['userId']);
	$user_id = getDb::query('SELECT idUsers FROM users WHERE idUsers=:idUsers', array(':idUsers' => $_SESSION['userId']))[0]['idUsers'];
	$hasLiked = False;

	if(isset($_GET['review_id'])) {
		if(!getDB::query('SELECT user_id FROM review_likes WHERE user_id=:user_id AND review_id=:review_id', array(':user_id'=>$user_id, ':review_id'=>$_GET['review_id']))) {
			getDB::query('UPDATE reviews SET likes=likes+1 WHERE id=:review_id', array(':review_id' => $_GET['review_id']));
			getDB::query('INSERT INTO review_likes(review_id, user_id) VALUES (:review_id, :user_id)', array(':review_id'=>$_GET['review_id'], ':user_id'=>$user_id));
		} else {
			getDB::query('UPDATE reviews SET likes=likes-1 WHERE id=:review_id', array(':review_id' => $_GET['review_id']));
			getDB::query('DELETE FROM review_likes WHERE review_id=:review_id AND user_id=:user_id', array(':review_id'=>$_GET['review_id'], ':user_id'=>$user_id));
		}
	}

} else {
	$userinfo = NULL;
}
$reviews = getDB::query('SELECT * FROM reviews WHERE book_id=:book_id', array(':book_id'=>$bookId));
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/bookpagev2.css">

	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

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
			<a href="../index/index.php"><img id="logotype" src="../images/books.png" alt=""></a>
			<a href="../index/index.php">
				<figcaption>BonoLibro</figcaption>
			</a>
		</figure>
		<img id="menu-icon" src="../images/menu.svg" alt="">

		<nav>
			<ul>
				<?php
				if (isset($_SESSION['userId'])) {
					echo '<li><a href="../myBooks/myBooks.php">Mina böcker</a></li>
				<hr>
				<li><a href="../profile/myProfile.php">Min profil</a></li>
				<hr>';
				} else {
					echo '<li><a href="../login-logout/login.php">Logga in</a></li>
				<hr>
				<li><a href="../signup/signup.php">Registrera</a></li>
				<hr>';
				}
				?>
			</ul>
		</nav>
	</aside>

	<main>
		<div class="main-firstRow">
			<div class="main-container-book">
				<div class="book-image">
					<?php echo '<img src="' . $array['9'] . '" alt="Books">'; ?>

					<button id="btnShowAddButtons" onclick="showContainerWithAddButtons()">LÄGG TILL</button>
					<div id="container-addButtons">
						<a href="../includes/bookHandler.inc.php?type=tbr&bookId=<?php echo $bookId ?>">Läser</a>
						<a href="../includes/bookHandler.inc.php?type=tbr&bookId=<?php echo $bookId ?>">Vill läsa</a>
						<a href="../includes/bookHandler.inc.php?type=hr&bookId=<?php echo $bookId ?>">Har läst</a>
						<a href="../includes/bookHandler.inc.php?type=tbr&bookId=<?php echo $bookId ?>">Favoriter</a>
						<?php
							if ($userinfo[11] != NULL) {
								echo '<form action="../includes/listsHandler.inc.php?type=userCreatedList&bookId=' . $bookId . '" method="post"><select name="personalList" id="personalList">';
								$listName = $getDb->getLists($_SESSION['userId'])['1'];
								if (!$help->contains(';:', $listName)) {
									echo '<option value="' . $listName . '">' . $listName . '</option>';
								} else {
									$listNameArray = explode(';:', $listName);
									foreach ($listNameArray as $i) {
										echo '<option value="' . $i . '">' . $i . '</option>';
									}
								}
								echo '</select><input type="submit" value="Lägg till i listan"></form>';
							}
							?>
					</div>

					<br>

					<a href="../review/writeAReview.php?bookId=<?php echo $bookId?>">Skriv en recension</a>

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

						<form action="../includes/bookHandler.inc.php?type=rating&bookId=<?php echo $bookId ?>" method="post" class="rate">
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

					<br>

					<div class="tab-container">
						<div class="tabButton-container">
							<button onclick="showTabPanel(0, 'rgb(43, 161, 140)')">Beskrivning</button>
							<button onclick="showTabPanel(1, 'rgb(43, 161, 140)')">Information</button>
						</div>

						<div class="tabPanel">
							<?php
							$bookDescription = $array['5'];
							if (strlen($bookDescription) == 0) {
								echo 'Det finns ingen beskrivning för den här boken.';
							} else if (strlen($bookDescription) <= 400) {
								echo $bookDescription;
							} else {
								$firstPart = substr($bookDescription, 0, 400);
								$secondPart = substr($bookDescription, 401);
								echo '<p>' . $firstPart . '<span id="dots">...</span><span id="more">' . $secondPart . '</span></p>';
							}
							?>
							<button id="btnReadMore" onclick="readMore()">Läs mer</button>
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
					echo '<p>Var den första att skriva en kommentar för denna bok!</p>';
				} else if (!$help->contains(';:', $array['12'])) {
					$comment = explode('::', $array['12']);
					$commentUserinfo = $getDb->getUserInfo($comment['0']);
					echo '<div class="comment"><div class="name">' . $commentUserinfo['8'] . ' ' . $commentUserinfo['9'] . '</div>';
					if (isset($_SESSION['userId']) && $_SESSION['userId'] == $comment['0']) {
						echo '<div class="edit-remove"><a href="php/commentHandler.inc.php?type=removeComment&bookId=' . $bookId . '&comment=' . $array['12'] . '">radera</a></div>';
					}
					echo '<br><div class="comment-text">' . $comment['1'] . '</div></div>';
				} else {
					$comments = explode(';:', $array['12']);
					foreach ($comments as $x) {
						$comment = explode('::', $x);
						$commentUserinfo = $getDb->getUserInfo($comment['0']);
						echo '<div class="comment"><div class="name">' . $commentUserinfo['8'] . ' ' . $commentUserinfo['9'] . '</div>';
						if ($_SESSION['userId'] == $comment['0']) {
							echo '<div class="edit-remove"><a href="php/commentHandler.inc.php?type=removeComment&bookId=' . $bookId . '&comment=' . $x . '">radera</a></div>';
						}
						echo '<br><div class="comment-text">' . $comment['1'] . '</div></div>';
					}
				}
				if (isset($_SESSION['userId'])) {
					// TODO ta hand om tom textarea här
					// TODO lägga till så att man kan edita och ta bor kommentarer
					echo '<form action="php/commentHandler.inc.php?type=comment&bookId=' . $bookId . '" method="post">
                            Skriv en kommentar:<br>
                            <textarea class="text" name="comment"></textarea>
                            <button type="submit" class="button1">Publicera</button>
                        </form>';
				} else {
					// TODO länka till inlogning och skapa konto
					echo '<p><a href="../login-logout/login.php">Logga</a> in eller <a href="../signup/signup.php">skapa ett konto</a> för att skriva en kommentar.</p>';
				}
				?>
			</div>

			<div class="main-container-reviews">
				<h2>Recensioner</h2>
				<?php
                foreach ($reviews as $r) {
					echo $r['id'];
                  	echo $r['title'];
                  	echo $r['body'];
                  	echo $r['posted_at'];
                  	echo $r['likes'];
				  	echo $r['user_id'];
                  	echo '<br>';

					if(!getDB::query('SELECT review_id FROM review_likes WHERE review_id=:review_id AND user_id=:user_id', array(':review_id'=>$r['id'], ':user_id'=>$user_id))) {
						echo '<form action="../bookpage/bookpage.php?bookId='.$bookId.'&review_id='.$r['id'].'&user_id='.$user_id.'" method="post">
			              			<input type="submit" name="submit_like" value="Gilla">
									<span>'.$r['likes'].' gilla-markeringar</span>
			          			</form>';
				  	} else {
					  	echo '<form action="../bookpage/bookpage.php?bookId='.$bookId.'&review_id='.$r['id'].'&user_id='.$user_id.'" method="post">
									<input type="submit" name="submit_unlike" value="Ogilla">
									<span>'.$r['likes'].' gilla-markeringar</span>
								</form>';
				  	}
                }
                 ?>
			</div>
		</div>
	</main>

	<script type="text/javascript" src="javascript/bookpage.js"></script>
</body>

</html>
