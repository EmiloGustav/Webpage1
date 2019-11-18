<?php
include '../includes/getDb.php';
$getDb = new getDb();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/searchResult.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
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
            <div class="container-searchResults">
                <h1 id="title-searchResult">Sökresultat</h1>
                <p id="p-searchHits">9 träffar</p>

                <div class="container-searchItem">
                    <a href="../bookpage/bookpage.php"><img src="../images/fahrenheit.jpg" alt=""></a>

                    <div class="searchItem-info">
                        <a href="../bookpage/bookpage.php"><h3>Fahrenheit 451</h3></a>
                        <p>Skriven av <a href="author.php">Gustav Hultgren</a></p>
                        <p>1956, Albert Bonnier förlag, ISBN: 978-58381-3</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-rightColumn">

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