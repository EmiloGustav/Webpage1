<?php
include 'php/index_getDb.php';
session_start();
$index_getDb = new index_getDb();
if (!isset($_SESSION['userId'])) {
    header("Location: http://$_SERVER[HTTP_HOST]/Webpage1/index/index-loggedin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!--<link rel="stylesheet" type="text/css" href="css/styleNewIndex.css">-->

    <link rel="stylesheet" type="text/css" href="css/index-loggedin.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

    <title>BonoLibro - Hem</title>
</head>

<body>
    <?php
    if (isset($_SESSION['userId'])) {
        ?>

        <aside>
            <figure>
                <a href="../index/index.php"><img id="logotype" src="../images/books.png" alt=""></a>
                <a href="../index/index.php"><figcaption>BonoLibro</figcaption></a>
            </figure>
            <img id="menu-icon" src="../images/menu.svg" alt="">

            <nav>
                <ul>
                    <li><a href="../mybooks/myBooks.php">Mina böcker</a></li>
                    <hr>
                    <li><a href="../profile/myProfile.php">Min profil</a></li>
                    <hr>
                    <li>
                        <form action="../login-logout/logout.inc.php" method="post">
                            <p>Inloggad som >användarnamn<</p>
                            <button type="submit" name="logout-submit" id="btn-logout">Logga ut</button>
                        </form>
                    </li>
                </ul>
            </nav>

        </aside>

        <main>
            <div class="left">
                <div class="container-search">
                    <h1>Sök och utforska böcker</h1>
                    <form action="../searchresult/SearchResult.php" method="get">
                        <input type="text" id="searchbar" name="book" placeholder="Titel, författare eller ISBN.." autocomplete="off">
                        <input type="submit" id="btnSearch" value="Sök">
                    </form>
                </div>

                <div class="container-latestUpdates">
                    <h1>Senaste uppdateringarna</h1>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <a id="link-seeAll" href="#">Se alla</a>
                </div>
            </div>

            <div class="right">
                <div class="container-readsNow">
                    <?php
                        $data = $index_getDb->getLatestBookFromCurrentlyReading(3);
                        ?>

                    <h1>Du läser just nu</h1>
                    <div class="book">
                        <?php echo '<a href="../bookpage/bookpage.php?bookId=' . $data[0]['bookId'] . '" class="img-link"><img src="' . $data[0]['smallthumbnail'] . '" alt=""></a>'; ?>
                        <div class="description">
                            <?php echo '<a href="../bookpage/bookpage.php?bookId=' . $data[0]['bookId'] . '"><h1>' . $data[0]['title'] . '</h1></a>';
                                echo '<p>Skriven av</p>';
                                echo '<a href="author.php" class="list-bookAuthor">' . $data[0]['author'] . '</a>';
                                ?>
                        </div>
                    </div>
                </div>

                <div class="container-feed">
                    <h1>Nyheter</h1>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                    <p><strong>ExampleName:</strong> Lorem ipsum dolor sit amet consectetur. Debitis, ea. <a>Läs mer</a></p>
                </div>
            </div>
        </main>

    <?php
        // Error message.
    } else { }
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