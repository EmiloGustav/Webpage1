<?php
include 'includes/getDb.inc.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!--<link rel="stylesheet" type="text/css" href="css/styleNewIndex.css">-->

    <link rel="stylesheet" type="text/css" href="css/index/index-loggedin.css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    <title>BonoLibro</title>
</head>

<body>
    <?php
    if (isset($_SESSION['userId'])) {
        ?>

        <aside>
            <figure>
                <img id="logotype" src="images/books.png" alt="">
                <figcaption>BonoLibro</figcaption>
            </figure>
            <img id="menu-icon" src="images\menu.svg" alt="">

            <nav>
                <ul>
                    <li><a href="index-loggedin.php">Hem</a></li>
                    <hr>
                    <li><a href="myBooksV2.php">Mina böcker</a></li>
                    <hr>
                    <li><a href="myProfile.php">Min profil</a></li>
                    <hr>
                    <li><a href="inbox.php">Meddelanden</a></li>
                    <hr>
                    <li>
                        <form action="includes/logout.inc.php" method="post">
                            <button type="submit" name="logout-submit" id="btn-logout">Logga ut</button>
                        </form>
                    </li>
                </ul>
            </nav>

        </aside>

        <main>
            <div class="1of3">
                <div class="container-readsNow">
                    <h1>Läser nu</h1>
                    <img src="images/greatgatsby.jpg" alt="">
                    <img src="images/fahrenheit.jpg" alt="">
                    <img src="images/harrypotter.jpg" alt="">
                    <a href="myBooksV2.php?list=hr">Redigera</a>
                </div>

                <div class="container-wantToRead">
                    <h1>Vill läsa</h1>
                    <img src="images/tokillamockingbird.jpg" alt="">
                    <img src="images/fahrenheit.jpg" alt="">
                    <img src="images/harrypotter.jpg" alt="">
                    <a href="myBooksV2.php?list=tbr">Redigera</a>
                </div>
            </div>

            <div class="2of3">
                <div class="container-latestUpdates">
                    <h1>Senaste uppdateringarna</h1>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <a id="link-seeAll" href="#">Se alla</a>
                </div>
            </div>

            <div class="3of3">
                <div class="container-feed">
                    <h1>Nyheter</h1>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                </div>
                <div class="container-ad">
                    <h1>Det här är reklam!</h1>
                </div>
            </div>
        </main>

    <?php
        // Error message.
    } else {
        ?>

    <?php
    }
    ?>

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