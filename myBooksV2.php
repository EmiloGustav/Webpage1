<?php
session_start();
include 'includes/getDb.inc.php';
if (isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Mina böcker</title>

    <link rel="stylesheet" href="css/myBooks/myBooks.css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <aside>
        <figure>
            <a href="index.php"><img id="logotype" src="images/books.png" alt=""></a>
            <a href="index.php">
                <figcaption>BonoLibro</figcaption>
            </a>
        </figure>
        <img id="menu-icon" src="images\menu.svg" alt="">

        <nav>
            <ul>
                <li><a href="myBooksV2.php?list=tbr">Vill läsa</a></li>
                <hr>
                <li><a href="myBooksV2.php?list=hbr">Har läst</a></li>
                <hr>
                <li><a href="myBooksV2.php?list=favourites">Favoriter</a></li>
                <hr>
                <?php
                $numberOfLists = $userinfo['11'];
                if ($numberOfLists != NULL) {
                    $lists = getLists($_SESSION['userId']);
                    if (!contains(';:', $lists['1'])) {
                        $delfkn = "deleteList('" . $lists['1'] . "');";
                        echo '<li><a href=myBooksV2.php?list=' . $lists['1'] . '">' . $lists['1'] . '</a></li>';
                        echo '<hr>';
                    } else {
                        $listname = explode(';:', $lists['1']);
                        foreach($listname as $i) {
                            $delfkn="deleteList('".$i."');";
                            echo '<li><a href="myBooks.php?list='.$i.'">'.$i.'</a></li>';
                            echo '<hr>';
                        }
                    }
                }
                ?>
                <li><a href="#">+ Skapa ny lista</a></li>
                <li>
                    <form action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logout-submit" id="btn-logout">Logga ut</button>
                    </form>
                </li>
            </ul>
        </nav>

    </aside>

    <main>
        <div class="list-side">
            <div class="container-list">
                <h1>Läser nu</h1>

                <form action="" id="form-perPage">
                    <label for="perPage">per sida</label>
                    <select name="perPage" id="perPage" onchange="$('form-perPage').submit()">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </form>

                <hr>
                <div class="list-bookItem">
                    <img src="images/greatgatsby.jpg" class="book-cover" alt="">

                    <div class="bookItem-description">
                        <a href="book.php" class="list-bookTitle">The Great Gatsby</a>
                        <p>Written by</p>
                        <a href="author.php" class="list-bookAuthor">F. Scott Fitzgerald</a>
                    </div>

                    <div class="bookItem-data">
                        <p>Betyg: 4.1 / 5</p>
                        <p>Lades till 'datum'</p>
                    </div>
                </div>
                <hr>

                <div class="list-bookItem">
                    <img src="images/fahrenheit.jpg" class="book-cover" alt="">

                    <div class="bookItem-description">
                        <a href="book.php" class="list-bookTitle">Fahrenheit</a>
                        <p>Written by</p>
                        <a href="author.php" class="list-bookAuthor">Ray Bradbury</a>
                    </div>

                    <div class="bookItem-data">
                        <p>Betyg: 4.1 / 5</p>
                        <p>Lades till 'datum'</p>
                    </div>
                </div>
                <hr>

                <div class="list-bookItem">
                    <img src="images/harrypotter.jpg" class="book-cover" alt="">

                    <div class="bookItem-description">
                        <a href="book.php" class="list-bookTitle">Harry Potter</a>
                        <p>Written by</p>
                        <a href="author.php" class="list-bookAuthor">J.K. Rowling</a>
                    </div>

                    <div class="bookItem-data">
                        <p>Betyg: 4.1 / 5</p>
                        <p>Lades till 'datum'</p>
                    </div>
                </div>
                <hr>

                <div class="list-bookItem">
                    <img src="images/harrypotter.jpg" class="book-cover" alt="">

                    <div class="bookItem-description">
                        <a href="book.php" class="list-bookTitle">Harry Potter</a>
                        <p>Written by</p>
                        <a href="author.php" class="list-bookAuthor">J.K. Rowling</a>
                    </div>

                    <div class="bookItem-data">
                        <p>Betyg: 4.1 / 5</p>
                        <p>Lades till 'datum'</p>
                    </div>
                </div>
                <hr>

                <div class="list-bookItem">
                    <img src="images/harrypotter.jpg" class="book-cover" alt="">

                    <div class="bookItem-description">
                        <a href="book.php" class="list-bookTitle">Harry Potter</a>
                        <p>Written by</p>
                        <a href="author.php" class="list-bookAuthor">J.K. Rowling</a>
                    </div>

                    <div class="bookItem-data">
                        <p>Betyg: 4.1 / 5</p>
                        <p>Lades till 'datum'</p>
                    </div>
                </div>
            </div>


        </div>

        <div class="ads">
            <div class="container-ads">
                <div class="container-item">
                    <h1>Det här är reklam!</h1>
                </div>
                <div class="container-item">
                    <h1>Det här är reklam!</h1>
                </div>
                <div class="container-item">
                    <h1>Det här är reklam!</h1>
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
</body>

</html>