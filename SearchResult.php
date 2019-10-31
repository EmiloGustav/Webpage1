<?php
require "header.php";
include "includes/getDb.inc.php"
?>
    <main class="container">

        <link rel="stylesheet" type="text/css" href="css/style.css">
        <style>
            li > .grid-container {
                display: grid;
                grid-template-columns: auto auto auto;
                grid-template-rows: auto auto;
                grid-gap: 3px;
                background-color: #2196F3;
                padding: 3px;
                overflow: hidden;
            }

            li .grid-container > div {
                background-color: rgba(255, 255, 255, 0.8);
                text-align: center;
            }

            .item1 {
                grid-column-start: 1;
                grid-column-end: 2;
                grid-row-start: 1;
                grid-row-end:3;
            }
            .item2{
                grid-column-start: 2;
                grid-column-end: 4;
                grid-row-start: 1;
                grid-row-end:1;
            }
            .item3{
                grid-column-start: 2;
                grid-column-end: 4;
                grid-row-start: 2;
                grid-row-end:2;
            }
            h5 {
                font-size: 15px;
                margin: 30px auto;
            }
            .pages > li {
                float:left;
                text-align: center;
                display: block;
                color: black;
                margin: 14px 0;
                text-decoration: none;
                font-size: larger;
            }
            .pages > li a {
                padding: 14px 16px;
                min-height: 14px;
                min-width: 16px;
            }
            pages > li a:hover {
                background-color: #ddd;
                color: black;
            }

            pages > li a:active {
                background-color: #2196F3;
                color: white;
            }


        </style>


        <div class="workspace">
            <div class="col">
                <div class="slideshow-container">
                    <h2>Månadens populäraste böcker</h2>

                    <div class="mySlides fade">
                        <div class="numbertext">1 / 4</div>
                        <img src="images/greatgatsby.jpg" width=" 200 px " height=" 300 px ">
                    </div>

                    <div class="mySlides fade">
                        <div class=" numbertext ">2 / 4</div>
                        <img src=" images/tokillamockingbird.jpg " width=" 200 px " height=" 300 px ">
                    </div>

                    <div class="mySlides fade">
                        <div class=" numbertext ">3 / 4</div>
                        <img src=" images/harrypotter.jpg " width=" 200 px " height=" 300 px ">
                    </div>

                    <div class="mySlides fade">
                        <div class=" numbertext ">4 / 4</div>
                        <img src=" images/fahrenheit.jpg " width=" 200 px " height=" 300 px ">
                    </div>

                    <a class=" prev " onclick=" plusSlides (- 1) ">&#10094;</a>
                    <a class=" next " onclick=" plusSlides(1) ">&#10095;</a>
                </div>

                <div style=" text - align: center ">
                    <span class=" dot " onclick=" currentSlide(1) "></span>
                    <span class=" dot " onclick=" currentSlide(2) "></span>
                    <span class=" dot " onclick=" currentSlide(3) "></span>
                    <span class=" dot " onclick=" currentSlide(4) "></span>
                </div>
                <?php
                if (isset($_GET["newpwd"])) {
                    if ($_GET["newpwd"] == "passwordupdated") {
                        echo '<p class="signupsucess">Ditt lösenord har blivit återställt!</p>';
                    }
                }
                ?>
            </div>

            <div class="col">
                <h2>Sökresultat</h2>
                <div class="searchResultBox">

                <?php
                // set articles per page as a global variable so you dont need to have 40 articles per page
                if (!empty($_GET['book'])) {

                    // API SEARCH ARRAY RETURNING
                    if(!isset($_GET['page'])) {
                        $startIndex=1;
                    }else {
                        $startIndex = 40 *($_GET['page'] - 1) + 1;
                    }
                    $maxResults = 40;
                    $articlesPerPage=10;
                    $search = str_replace(" ", "+", $_GET['book']);
                    $url = 'https://www.googleapis.com/books/v1/volumes?q=:' . $search . '&key=AIzaSyAVS0pl26V1YQiq1aYJxyhqe-AsuH1Pcq8&langRestrict=sv&maxResults='.$maxResults.'&startIndex='.$startIndex;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $array = json_decode($result, TRUE); // items -> 0 to totalItems -> volumeInfo -> title,array of authors, isbn etc

                    $tmparray=array();
                    if (!empty($array['totalItems'])) {
                        $tot=$array['totalItems']+$startIndex-1;
                        if($array['totalItems']<$maxResults) {
                            $totalItems = $array['totalItems'];
                        }else {
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
                            if (!empty($array) && !checkBookInDbById($array['items'][strval($x)]['id'])) {
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
                                }// echo print_r($array['items'][strval($x)]['imageLinks']['smallThumbnail']);
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
                                    addToBookTable($foundTitle, $foundAuthors, $publisher, $publishedDate, $description, $isbn13, $isbn10, $smallthumbnail, $thumbnail, $textsnippet, $googleId);
                                    array_push($tmparray, array(getBookByGoogleId($googleId)['0'],$foundTitle, $foundAuthors, $publisher, $publishedDate, $description, $isbn13, $isbn10, $smallthumbnail, $thumbnail, $textsnippet, $googleId));
                                }
                            } else if (checkBookInDbById($array['items'][strval($x)]['id'])) {
                                array_push($tmparray, getBookByGoogleId($array['items'][strval($x)]['id']));
                            }
                        }
                    }
                    printArray($tmparray,$tot,$articlesPerPage,$maxResults);
                }

                // TODO sätta så att man kan ändra articlesPerPage på sidan
                // Prints the items supposed to go on the site, prints x search results per page where x is yet to be set by a bar
                function printArray($array,$tot,$articlesPerPage,$maxResults) {
                    $amountOfPages = ($tot-$tot%$articlesPerPage)/$articlesPerPage + 1; // add 1 for the page that is not full of articles
                    $book = $_GET['book'];
                    if(!isset($_GET['page'])){
                        $page = 1;
                    }else {
                        $page = $_GET['page'];
                    } if ($page < 1) {
                        $page = 1;
                    }else if ($page > $amountOfPages){
                        $page = $amountOfPages;
                    }
                    if ($page < $amountOfPages) {
                        echo '<ul>';
                        for ($x = ($page - 1) * $articlesPerPage % $maxResults; $x < ($page - 1) * $articlesPerPage % $maxResults + $articlesPerPage; $x++) {
                            $hrefurl = 'bookpage.php?bookId=' . strval($array[strval($x)]['0']);
                            echo '
                        <li><a href="'.$hrefurl.'" class="grid-container">
                            <div class="item1"><img src="'.$array[strval($x)]['8'].'"></div>
                            <div class="item2"><h5>',$array[strval($x)]['1'],', ',$array[strval($x)]['2'],'</h5></div>
                            <div class="item3"><h5>'.$array[strval($x)]['10'].'</h5></div>
                        </a></li>
                        ';
                        }
                        echo '</ul>';
                        printPageBar($amountOfPages,$page,$book);
                    }else {
                        echo '<ul>';
                        for ($x = ($amountOfPages - 1) * $articlesPerPage ; $x < $tot; $x++) {
                            $hrefurl = 'bookpage.php?bookId=' . strval($array[strval($x)]['0']);
                            echo '
                        <li><a href="'.$hrefurl.'" class="grid-container">
                            <div class="item1"><img src="'.$array[strval($x)]['8'].'"></div>
                            <div class="item2"><h5>',$array[strval($x)]['1'],', ',$array[strval($x)]['2'],'</h5></div>
                            <div class="item3"><h5>'.$array[strval($x)]['10'].'</h5></div>
                        </a></li>
                        ';
                        }
                        echo '</ul>';
                        if ($amountOfPages > 1) {
                            printPageBar($amountOfPages,$page,$book);
                        }
                    }
                }

                function printPageBar($amountOfPages, $currentPage, $book){
                    echo '
                            <div class="pages-container">
                                <ul class="pages">
                                    <li><a class="pageLeft" href="SearchResult.php?page='.strval($currentPage - 1).'&book='.$book.'"> << </a></li>';
                    if ($currentPage > 3) {
                        echo '<li class="page">...</li>';
                    }
                    if ($currentPage - 2 < 1 || $currentPage + 2 > $amountOfPages ) {
                        if ($currentPage - 2 < 1 && $currentPage + 2 > $amountOfPages) {
                            for ($x = 1; $x <= $amountOfPages; $x++) {
                                echo '<li><a class="page" href="SearchResult.php?page='.strval($x).'&book='.$book.'"> '.strval($x).' </a></li>';
                            }
                        }else if ($currentPage + 2 > $amountOfPages){
                            $difference = $amountOfPages - $currentPage - 2; // alltid negativ
                            for ($x = -2; $x <= 2; $x++) {
                                if ($currentPage + $x + $difference <= $amountOfPages && $currentPage + $x + $difference > 0) {
                                    echo '  <li><a class="page" href="SearchResult.php?page='.strval($currentPage + $x + $difference).'&book='.$book.'"> '.strval($currentPage + $x + $difference).' </a></li>';
                                }
                            }
                        }else if ($currentPage - 2 < 1) {
                            $difference = 1 - $currentPage + 2;
                            for ($x = -2; $x <= 2; $x++) {
                                if ($currentPage + $x + $difference > 0 && $currentPage + $x + $difference <= $amountOfPages) {
                                    echo '  <li><a class="page" href="SearchResult.php?page=' . strval($currentPage + $x + $difference) . '&book=' . $book . '"> ' . strval($currentPage + $x + $difference) . ' </a></li>';
                                }
                            }
                        }
                    }else {
                        for ($x = -2; $x <= 2; $x++) {
                            echo '<li><a class="page" href="SearchResult.php?page='.strval($currentPage + $x).'&book='.$book.'"> '.strval($currentPage + $x).' </a></li>';
                        }
                    }
                    if ($amountOfPages - $currentPage > 3){
                        echo '<li class="page">...</li>';
                    }
                    echo '          <li><a class="pageRight" href="SearchResult.php?page='.strval($currentPage + 1).'&book='.$book.'"> >> </a></li>
                                </ul>                           
                            </div>
                            ';
                }
                ?>
                </div>
            </div>

            <div class="col">
                <?php
                if (!isset($_SESSION['userId'])) {
                    echo '
                <h2 class="newUserMessage">
                    Ny här? <a href="signup.php">Skapa ett konto gratis!</a>
                </h2>

                ';
                } else {
                    echo ' <h2 class= "newUserMessag e">
                Välkommen!
                </h2>
                ';
                }
                ?>

            </div>
        </div>
        <script src="js/index.js"></script>
    </main>


<?php
require  "footer.php"
?>