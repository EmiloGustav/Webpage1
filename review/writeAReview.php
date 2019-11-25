<?php
session_start();
include('../includes/getDb.php');

if (isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];
} else {
    echo "Du måste vara inloggad för att skriva en recension.";
}
$book_id = $_GET['bookId'];

// Code for inserting / submit the review
if (isset($_POST['submit_review'])) {
    $review_title = $_POST['review_title'];
    $review_body = $_POST['review_body'];

    if (strlen($review_title) < 1) {
        die('Din rubrik är för kort!');
    }
    if (strlen($review_body) < 1) {
        die('Din text är för kort!');
    }

  getDb::query('INSERT INTO reviews VALUES (\'\', :review_title, :review_body, NOW(), 0, :user_id, :book_id)', array(':review_title' => $review_title, ':review_body' => $review_body, ':user_id' => $user_id, ':book_id' => $book_id));
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="stylesheet" type="text/css" href="css/writeAReview.css">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

  <title>BonoLibro</title>
</head>

<body>
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
          echo '<li><a href="../profile/editProfile.php">Redigera profil</a></li>
                    <hr>
                    <li><a href="../myBooks/myBooks.php">Mina böcker</a></li>
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
    <header>
      <h1>Skriv en recension för >boknamn<</h1> <p>Här kan du skriva en recension för den valda boken. Vet du inte hur man skriver en recension? Kika då in <a href="https://www.google.se">den här länken.</a></p>
    </header>

    <div class="container-writingSection">
        <form action="writeAReview.php?bookId=<?php echo $book_id; ?>" method="post">
            <input type="text" name="review_title" value="" placeholder="Rubrik">
            <textarea name="review_body" rows="8" cols="40"></textarea>
            <input type="submit" name="submit_review" value="Skapa recension">
        </form>
    </div>
  </main>

</body>

</html>
