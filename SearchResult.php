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
                /*
                $search = $_GET['book'];
                if(!empty($search)) {
                    // Ändrar mellanrum till +
                    $search = str_replace(" ","+",$search);
                    $url = 'https://www.googleapis.com/books/v1/volumes?q='.$search;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $array = json_decode($result,TRUE ); // items -> 0 to totalItems -> volumeInfo -> title,array of authors, isbn etc
                   // echo print_r($array['items']);
                    printBooks($array);


                }
                /*
                function printBooks($array) {
                    $totalItems = $array['totalItems'];
                    $articlesPerPage = 10;
                    $amountOfPages = ($totalItems-$totalItems%$articlesPerPage)/$articlesPerPage + 1; // add 1 for the page that is not full of articles

                    if(!isset($_GET['page'])){
                        $page = 1;
                    }else {
                        $page = $_GET['page'];
                    } if ($page < 1) {
                        $page = 1;
                    }else if ($page > $amountOfPages){
                        $page = $amountOfPages;
                    }
                    if($page < $amountOfPages ) {
                        for ($x = ($page - 1) * $articlesPerPage; $x < ($page) * $articlesPerPage; $x++) {
                            $authors = "";
                            for ($y = 0; $y < sizeof($array['items'][strval($x)]['volumeInfo']['authors']); $y++) {
                                $authors .= $array['items'][strval($x)]['volumeInfo']['authors'][strval($y)] . ", ";
                            }

                            $title = $array['items'][strval($x)]['volumeInfo']['title'];
                            if (!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers']['imageLinks']['smallThumbnail'])) {
                                $thumbnail =$array['items'][strval($x)]['volumeInfo']['industryIdentifiers']['imageLinks']['smallThumbnail'];
                            }else {
                                $thumbnail = 'Standard image';
                            }
                            //$textSnippet =

                            $hrefurl = 'bookpage.php?id='.strval($array['items'][strval($x)]['id']);
                            echo '<a href="'.$hrefurl.'"class="searchResult">';
                            echo '<div class="thumbnail"><img src="'.$thumbnail.'" width="426" height="250"></div>';
                            echo '<div class="rightside"><div class="top">'.$title.', '.$authors.'</div><div class="bottom">Här kan man ha liten del av beskrivningen</div></div>';
                            echo '</a>';

                                      

                        }
                        printPageBar($amountOfPages,$page,$_GET['book']);
                    }
                }*/

                $librisArray = getLibrisArray();
                for($x = 1; $x < sizeof($librisArray); $x++) {
                    if (checkBookInDbByTitleNAuthor($librisArray[strval($x)]['2'],$librisArray[strval($x)]['1'])) {
                        // echo $librisArray[strval($x)]['2'].$librisArray[strval($x)]['1'].' in library <br>';

                    }else {
                        // echo $librisArray[strval($x)]['2'].$librisArray[strval($x)]['1'].' NOT in library <br>';
                        $googleArray = addResultsFromGoogle($librisArray[strval($x)]['2'],$librisArray[strval($x)]['1']);
                    }




                    /*
                    if ($googleArray != false) {
                        // Set the title
                        if (!empty($googleArray['volumeInfo']['title'])){
                            $title = $googleArray['volumeInfo']['title'];
                        }
                        // Set the authors for the book
                        if (!empty($googleArray['volumeInfo']['authors'])){
                            if (gettype($authorsArray = $googleArray['volumeInfo']['authors']) == 'array') {
                                $authors = "";
                                for($y = 0; $y < sizeof($authorsArray); $y++ ) {
                                    if ($y != sizeof($authorsArray)-1) {
                                        $authors = $authors.$authorsArray[strval($y)].', ';
                                    }else {
                                        $authors = $authors.$authorsArray[strval($y)];
                                    }
                                }
                            }
                        }
                        // Set the publisher for the book
                        if (!empty($googleArray['volumeInfo']['publisher'])){
                            $publisher = $googleArray['volumeInfo']['publisher'];
                        }
                        if (!empty($googleArray['volumeInfo']['publishedDate'])){
                            $publishedDate = $googleArray['volumeInfo']['publishedDate'];
                        }
                        if (!empty($googleArray['volumeInfo']['description'])){
                            $description = $googleArray['volumeInfo']['description'];
                        }
                        //// INDUSTRY IDENTIFIERS /////
                      //  $industryIdentifiers = $googleArray['industryIdentifiers'];


                    }else {


                    }*/
                }
                //$results = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1);
                $results = array();
                for($x = 1; $x < sizeof($librisArray); $x++) {
                    $tmpArray = getBookByTitleNAuthor($librisArray[strval($x)]['2'],$librisArray[strval($x)]['1']);
                   // echo '<br> results <br>'.print_r($results);
                    if ($tmpArray != false) {
                        array_push($results,$tmpArray);
                    }
                }

                printArray($results);

                function getLibrisArray(){
                    $search = $_GET['book'];
                    if(!empty($search)) {
                        // Ändrar mellanrum till +
                        $search = str_replace(" ","+",$search);

                        // stränghantering för att avgöra om författare eller boknamn behövs
                        // författare f%C3%B6rf:
                        $url = 'http://libris.kb.se/xsearch?query=' . $search . '&format=json&start=1&n=200';

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $obj = json_decode($result,TRUE );
                        try {
                            $array = array(array('identifier','creator','title','isbn'));
                            //print_r($array);
                            $bookIndex = 1;
                            for ($x = 1; $x < sizeof($obj['xsearch']['list']); $x++){
                                //print_r($obj['xsearch']['list'][strval($x)]);

                                //check if undefiend
                                if(!isset($obj['xsearch']['list'][strval($x)]['identifier'])
                                    ||!isset($obj['xsearch']['list'][strval($x)]['creator'])
                                    ||!isset($obj['xsearch']['list'][strval($x)]['title'])
                                    ||!isset($obj['xsearch']['list'][strval($x)]['isbn'])
                                    ||!isset($obj['xsearch']['list'][strval($x)]['language'])
                                    ||!isset($obj['xsearch']['list'][strval($x)]['type'])) {
                                    //throw new Exception("Odefinerad variabel");
                                    continue;
                                }

                                // Set Values from xsearch to variables
                                $identifier = $obj['xsearch']['list'][strval($x)]['identifier'];
                                $creatorOld = $obj['xsearch']['list'][strval($x)]['creator'];
                                $title = $obj['xsearch']['list'][strval($x)]['title'];
                                $isbn = $obj['xsearch']['list'][strval($x)]['isbn'];

                                // fix the authour name (Firstname, lastname)
                                if (contains(', ',$creatorOld)) {
                                    $tmpArray = explode(", ",$creatorOld);
                                    $creator = strval($tmpArray[1]) . " " . strval($tmpArray[0]);
                                }else if(contains(' ', $creatorOld)){
                                    $tmpArray = explode(" ",$creatorOld);
                                    $creator = strval($tmpArray[1]) . " " . strval($tmpArray[0]);
                                }else{
                                    $creator = $creatorOld;
                                }

                                // Check if there are multiple isbn's for the book, if so create an array with integers.
                                if (gettype($isbn) == "array") {
                                    $tmpIsbn = "";
                                    for($y = 0;$y < sizeof($isbn); $y++) {
                                        $tmpIsbn = $tmpIsbn.','.strval($isbn[strval($y)]);
                                    }
                                    $isbn=$tmpIsbn;
                                }

                                // Check if the book is in swedish and of the type book then dont get multiples of the same and push the item to the array.
                                if ($obj['xsearch']['list'][strval($x)]['language'] == "swe"
                                    && $obj['xsearch']['list'][strval($x)]['type'] == "book") {
                                    $match=FALSE;
                                    for($y = 0; $y < sizeof($array);$y++) {
                                        if (strval($title) == strval($array[strval($y)]['2'])){
                                            //echo strval($title).strval($array[strval($y)]['2']);
                                            $match = TRUE;
                                            break ;
                                        }
                                    }
                                    if(!$match) {
                                        $tmpArray = array($identifier,$creator,$title,$isbn);
                                        array_push($array,$tmpArray);
                                        $bookIndex++;
                                    }
                                }
                            }
                            return $array;
                        }catch(Exception $e) {
                            echo $e -> getMessage();
                        }
                        // print_r($obj['xsearch']['list']);
                    }
                }

                function addResultsFromGoogle($title,$author,$maxResults = 40) {
                    if (!empty($title) && !empty($author) && $maxResults <= 40 && $maxResults > 0) {
                       // $title = str_replace(" ","+",$title);
                        $author = str_replace(" ","+",$author);
                        $url = 'https://www.googleapis.com/books/v1/volumes?q=inauthor:'.$author.'&maxResults='.$maxResults.'&key=AIzaSyAVS0pl26V1YQiq1aYJxyhqe-AsuH1Pcq8&langRestrict=sv';

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);

                        $array = json_decode($result,TRUE ); // items -> 0 to totalItems -> volumeInfo -> title,array of authors, isbn etc
                        $tmparray = array();
                        // echo print_r($array);

                        if (!empty($array['totalItems'])) {
                            $totalItems = $array['totalItems'];
                        }else {
                            $totalItems = $maxResults;
                        }
                        if ($totalItems < $maxResults){
                            $maxResults = $totalItems;
                        }
                        if ($totalItems == 0) {
                            addToBooksNotInGoogle($title);
                        }else {

                            for ($x = 0; $x < $maxResults; $x++) {
                                if (!empty($array['items'][strval($x)]['volumeInfo']['title'])){
                                    $foundTitle = $array['items'][strval($x)]['volumeInfo']['title'];
                                    if (strcasecmp($foundTitle,$title) == 0) {
                                        $nomatch = false;
                                        break;
                                    }else {
                                        $nomatch = true;
                                    }
                                }
                            }

                            if($nomatch == true) {
                                echo 'addedtobooksnotyin google '.$title;
                                addToBooksNotInGoogle($title);
                                return false;
                            }

                            for ($x = 0; $x < $maxResults; $x++) {
                                // TODO FICA checkbook in db argument
                                if(!empty($array) && !checkBookInDbById($array['items'][strval($x)]['id'])) {
                                    if (!empty($array['items'][strval($x)]['volumeInfo']['title'])){
                                        $foundTitle = $array['items'][strval($x)]['volumeInfo']['title'];
                                    }else {
                                        $foundTitle = NULL;
                                    }
                                    // Set the authors for the book
                                    if (!empty($array['items'][strval($x)]['volumeInfo']['authors'])){
                                        if (gettype($authorsArray = $array['items'][strval($x)]['volumeInfo']['authors']) == 'array') {
                                            $foundAuthors = "";
                                            for($y = 0; $y < sizeof($authorsArray); $y++ ) {
                                                if ($y != sizeof($authorsArray)-1) {
                                                    $foundAuthors = $foundAuthors.$authorsArray[strval($y)].', ';
                                                }else {
                                                    $foundAuthors = $foundAuthors.$authorsArray[strval($y)];
                                                }
                                            }
                                        }else {
                                            $foundAuthors = $array['items'][strval($x)]['volumeInfo']['authors'];
                                        }
                                    }else {
                                        $foundAuthors = NULL;
                                    }
                                    // Set the publisher for the book
                                    if (!empty($array['items'][strval($x)]['volumeInfo']['publisher'])){
                                        $publisher = $array['items'][strval($x)]['volumeInfo']['publisher'];
                                    }else {
                                        $publisher = NULL;
                                    }
                                    if (!empty($array['items'][strval($x)]['volumeInfo']['publishedDate'])){
                                        $publishedDate = $array['items'][strval($x)]['volumeInfo']['publishedDate'];
                                    }else {
                                        $publishedDate = NULL;
                                    }
                                    if (!empty($array['items'][strval($x)]['volumeInfo']['description'])){
                                        $description = $array['items'][strval($x)]['volumeInfo']['description'];
                                    }else {
                                        $description = NULL;
                                    }
                                    if(!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'])) {
                                        for($y = 0; $y < sizeof($array['items'][strval($x)]['volumeInfo']['industryIdentifiers']);$y++) {
                                            if (!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type']) && strcasecmp($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type'], "ISBN_13") == 0) {
                                                $isbn13 = $array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['identifier'];
                                                break;
                                            }else {
                                                $isbn13 = NULL;
                                            }
                                        }
                                        for($y = 0; $y < sizeof($array['items'][strval($x)]['volumeInfo']['industryIdentifiers']);$y++) {
                                            if (!empty($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type']) && strcasecmp($array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['type'], "ISBN_10") == 0) {
                                                $isbn10 = $array['items'][strval($x)]['volumeInfo']['industryIdentifiers'][strval($y)]['identifier'];
                                                break;
                                            }else {
                                                $isbn10 = NULL;
                                            }
                                        }
                                    }
                                    // echo print_r($array['items'][strval($x)]['imageLinks']['smallThumbnail']);
                                    // echo print_r($array['items'][strval($x)]['volumeInfo']);
                                    if(!empty($array['items'][strval($x)]['volumeInfo']['imageLinks']['smallThumbnail'])) {
                                        $smallthumbnail = $array['items'][strval($x)]['volumeInfo']['imageLinks']['smallThumbnail'];
                                    }else {
                                        $smallthumbnail = NULL;
                                    }
                                    if(!empty($array['items'][strval($x)]['volumeInfo']['imageLinks']['thumbnail'])) {
                                        $thumbnail = $array['items'][strval($x)]['volumeInfo']['imageLinks']['thumbnail'];
                                    }else {
                                        $thumbnail = NULL;
                                    }
                                    if(!empty($array['items'][strval($x)]['id'])) {
                                        $googleId = $array['items'][strval($x)]['id'];
                                    }else {
                                        $googleId = NULL;
                                    }
                                    if(!empty($array['items'][strval($x)]['searchInfo']['textSnippet'])) {
                                        $textsnippet = $array['items'][strval($x)]['searchInfo']['textSnippet'];
                                    }else {
                                        $textsnippet = NULL;
                                    }
                                    if($googleId != NULL) {
                                        array_push($tmparray,array($foundTitle,$foundAuthors,$publisher,$publishedDate,$description,$isbn13,$isbn10,$smallthumbnail,$thumbnail,$textsnippet,$googleId));
                                        addToBookTable($foundTitle,$foundAuthors,$publisher,$publishedDate,$description,$isbn13,$isbn10,$smallthumbnail,$thumbnail,$textsnippet,$googleId);
                                    }
                                }
                            }
                        }
                        return $tmparray;
                    }else if (empty($title)) {
                        // TODO Fylla i med felhantering
                        echo 'error';
                        return false;
                    }else if (empty($author)) {
                        echo 'error';
                        return false;
                    }else if ($maxResults <= 40) {
                        echo 'error';
                        return false;
                    }else if ($maxResults > 0) {
                        echo 'error';
                        return false;
                    }else {
                        echo 'error';
                        return false;
                    }
                }

                function crossCheckGoogle($title,$author,$maxResults = 40) {
                    if (!empty($title) && !empty($author) && $maxResults <= 40 && $maxResults > 0) {
                        $title = str_replace(" ","+",$title);
                        $url = 'https://www.googleapis.com/books/v1/volumes?q=inauthor:'.$author.'&maxResults='.$maxResults.'&key=AIzaSyAVS0pl26V1YQiq1aYJxyhqe-AsuH1Pcq8';

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);

                        $array = json_decode($result,TRUE ); // items -> 0 to totalItems -> volumeInfo -> title,array of authors, isbn etc

                        for ($x = 0; $x < $maxResults; $x++) {
                            checkBookInDb($array['items'][strval($x)],$maxResults);
                        }

                        for ($x = 0; $x < $maxResults; $x++) {
                            $title = str_replace("+"," ",$title);
                            if (strcasecmp($title, $array['items'][strval($x)]['volumeInfo']['title']) == 0) {
                                // TODO Kontrollera så att det är samma författare
                                return $array['items'][strval($x)];
                            }
                        }
                        echo 'no matches';
                        return false;

                    }else if (empty($title)) {
                        // TODO Fylla i med felhantering
                        echo 'error';
                        return false;
                    }else if (empty($author)) {
                        echo 'error';
                        return false;
                    }else if ($maxResults <= 40) {
                        echo 'error';
                        return false;
                    }else if ($maxResults > 0) {
                        echo 'error';
                        return false;
                    }else {
                        echo 'error';
                        return false;
                    }
                    /*
                    $search = $_GET['book'];
                    if(!empty($search)) {
                        // Ändrar mellanrum till +
                        $search = str_replace(" ","+",$search);
                        $url = 'https://www.googleapis.com/books/v1/volumes?q='.$search;

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);

                        $array = json_decode($result,TRUE ); // items -> 0 to totalItems -> volumeInfo -> title,array of authors, isbn etc
                        // echo print_r($array['items']);
                        printBooks($array);


                    }*/
                }

                // returns true if $needle is a substring of $haystack
                function contains($needle, $haystack)
                {
                    return strpos($haystack, $needle) !== false;
                }

                function printArray($array) {
                    $amountOfPages = (sizeof($array)-sizeof($array)%10)/10 + 1; // add 1 for the page that is not full of articles
                    $articlesPerPage = 10;
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
                        for ($x = ($page - 1) * $articlesPerPage; $x < $page * $articlesPerPage; $x++) {
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
                        for ($x = ($amountOfPages - 1) * $articlesPerPage; $x < sizeof($array); $x++) {
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
                            echo '<li><a class="page" href="SearchResult.php?page='.strval($currentPage + $x).'&book='.$currentPage.'"> '.strval($currentPage + $x).' </a></li>';
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