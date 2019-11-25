<?php
include '../includes/getDb.php';
$getDb = new getDb();
session_start();
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
        <div class="main-leftColumn">

            <div class="container-searchResults">

                <?php
                // set articles per page as a global variable so you dont need to have 40 articles per page
                if (!empty($_GET['book'])) {

                    // API SEARCH ARRAY RETURNING
                    if (!isset($_GET['page'])) {
                        $startIndex = 1;
                    } else {
                        $startIndex = 40 * ($_GET['page'] - 1) + 1;
                    }
                    $maxResults = 40;
                    $articlesPerPage = 10;
                    $search = str_replace(" ", "+", $_GET['book']);
                    $url = 'https://www.googleapis.com/books/v1/volumes?q=:' . $search . '&key=AIzaSyAVS0pl26V1YQiq1aYJxyhqe-AsuH1Pcq8&langRestrict=sv&maxResults=' . $maxResults . '&startIndex=' . $startIndex;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $array = json_decode($result, TRUE); // items -> 0 to totalItems -> volumeInfo -> title,array of authors, isbn etc

                    $tmparray = array();
                    if (!empty($array['totalItems'])) {
                        $tot = $array['totalItems'] + $startIndex - 1;
                        if ($array['totalItems'] < $maxResults) {
                            $totalItems = $array['totalItems'];
                        } else {
                            $totalItems = $maxResults;
                        }
                    } else {
                        $totalItems = 0;
                    }
                    if ($totalItems == 0) {
                        // TODO addToBooksNotInGoogle($title);
                        // TODO add new way to find dead end searches
                    } else {
                        for ($x = 0; $x < $maxResults; $x++) {
                            // TODO FICA checkbook in db argument
                            if (!empty($array) && !$getDb->checkBookInDbById($array['items'][strval($x)]['id'])) {
                                if (!empty($array['items'][strval($x)]['volumeInfo']['title'])) {
                                    $foundTitle = $array['items'][strval($x)]['volumeInfo']['title'];
                                } else {
                                    $foundTitle = NULL;
                                }
                                // Set the authors for the book
                                if (!empty($array['items'][strval($x)]['volumeInfo']['authors'])) {
                                    if (gettype($authorsArray = $array['items'][strval($x)]['volumeInfo']['authors']) == 'array') {
                                        $foundAuthors = "";
                                        for ($y = 0; $y < sizeof($authorsArray); $y++) {
                                            if ($y != sizeof($authorsArray) - 1) {
                                                $foundAuthors = $foundAuthors . $authorsArray[strval($y)] . ', ';
                                            } else {
                                                $foundAuthors = $foundAuthors . $authorsArray[strval($y)];
                                            }
                                        }
                                    } else {
                                        $foundAuthors = $array['items'][strval($x)]['volumeInfo']['authors'];
                                    }
                                } else {
                                    $foundAuthors = NULL;
                                }
                                // Set the publisher for the book
                                if (!empty($array['items'][strval($x)]['volumeInfo']['publisher'])) {
                                    $publisher = $array['items'][strval($x)]['volumeInfo']['publisher'];
                                } else {
                                    $publisher = NULL;
                                }
                                if (!empty($array['items'][strval($x)]['volumeInfo']['publishedDate'])) {
                                    $publishedDate = $array['items'][strval($x)]['volumeInfo']['publishedDate'];
                                } else {
                                    $publishedDate = NULL;
                                }
                                if (!empty($array['items'][strval($x)]['volumeInfo']['description'])) {
                                    $description = $array['items'][strval($x)]['volumeInfo']['description'];
                                } else {
                                    $description = NULL;
                                }
                                if (!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'])) {
                                    for ($y = 0; $y < sizeof($array['items'][strval($x)]['volumeInfo']['industryIdentifiers']); $y++) {
                                        if (!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type']) && strcasecmp($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type'], "ISBN_13") == 0) {
                                            $isbn13 = $array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['identifier'];
                                            break;
                                        } else {
                                            $isbn13 = NULL;
                                        }
                                    }
                                    for ($y = 0; $y < sizeof($array['items'][strval($x)]['volumeInfo']['industryIdentifiers']); $y++) {
                                        if (!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type']) && strcasecmp($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type'], "ISBN_10") == 0) {
                                            $isbn10 = $array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['identifier'];
                                            break;
                                        } else {
                                            $isbn10 = NULL;
                                        }
                                    }
                                } // echo print_r($array['items'][strval($x)]['imageLinks']['smallThumbnail']);
                                // echo print_r($array['items'][strval($x)]['volumeInfo']);
                                if (!empty($array['items'][strval($x)]['volumeInfo']['imageLinks']['smallThumbnail'])) {
                                    $smallthumbnail = $array['items'][strval($x)]['volumeInfo']['imageLinks']['smallThumbnail'];
                                } else {
                                    $smallthumbnail = NULL;
                                }
                                if (!empty($array['items'][strval($x)]['volumeInfo']['imageLinks']['thumbnail'])) {
                                    $thumbnail = $array['items'][strval($x)]['volumeInfo']['imageLinks']['thumbnail'];
                                } else {
                                    $thumbnail = NULL;
                                }
                                if (!empty($array['items'][strval($x)]['id'])) {
                                    $googleId = $array['items'][strval($x)]['id'];
                                } else {
                                    $googleId = NULL;
                                }
                                if (!empty($array['items'][strval($x)]['searchInfo']['textSnippet'])) {
                                    $textsnippet = $array['items'][strval($x)]['searchInfo']['textSnippet'];
                                } else {
                                    $textsnippet = NULL;
                                }
                                if ($googleId != NULL) {
                                    // TODO implement getBookId
                                    $getDb->addToBookTable($foundTitle, $foundAuthors, $publisher, $publishedDate, $description, $isbn13, $isbn10, $smallthumbnail, $thumbnail, $textsnippet, $googleId);
                                    array_push($tmparray, array($getDb->getBookByGoogleId($googleId)['0'], $foundTitle, $foundAuthors, $publisher, $publishedDate, $description, $isbn13, $isbn10, $smallthumbnail, $thumbnail, $textsnippet, $googleId));
                                }
                            } else if ($getDb->checkBookInDbById($array['items'][strval($x)]['id'])) {
                                array_push($tmparray, $getDb->getBookByGoogleId($array['items'][strval($x)]['id']));
                            }
                        }
                    }
                    
                    printArray($tmparray, $tot, $articlesPerPage, $maxResults);
                }
                ?>

                <h1 id="title-searchResult">Sökresultat</h1>
                <p id="p-searchHits">9 träffar</p>

                <ul id="container-searches">

                </ul>
                <div class="container-searchItem">
                    <a href="../bookpage/bookpage.php"><img src="../images/fahrenheit.jpg" alt=""></a>

                    <div class="searchItem-info">
                        <a href="../bookpage/bookpage.php">
                            <h3>Fahrenheit 451</h3>
                        </a>
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