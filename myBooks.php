<?php
require "header.php";
include "includes/getDb.inc.php";
if (isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
}

?>
<main class="container"><!--uses the full size of the browser and hides the overflow if any -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .workspace2 {
            max-width: 1280px;
            margin: 0 auto;
            display:grid;
            grid-template-columns: 30% 70%;
            grid-gap: 1em;
        }
        .workspace2>div {
            background: #eee;
            padding: 1em;
        }
        .workspace2 .leftColumn {

        }
        .workspace2 .rightColumn {

        }
        .list-container{

        }
        h2 {
            text-align: center;
        }
        .item-container {
            display: grid;
            grid-template-columns: 55px 35% 20% 20% auto;
            grid-gap: 3px;
            background-color: lightcoral;
            padding: 3px;
            overflow: hidden;
            border-bottom: black;
            border-style: inset;
        }
        .item-container > a {
            text-decoration: none;
            color: #000;
            font-size: large;
        }
        .item-container a > .img {
            width:50px;
            height:80px
        }
        .item-container > .title {
            text-align: left;
            margin:auto 0;
            padding: 30px;
        }
        .item-container > .author {
            text-align: left;
            margin:auto 0;
            padding: 30px;
        }
        .item-container > .rating {
            text-align: left;
            margin:auto 0;
            padding: 30px;
        }
    </style>
    <?php
        if(!isset($_SESSION['userId'])){
            echo '<div class="workspace2"><h3>Logga in för att se dina sidor</h3><br><a href="signup.php">Eller skapa ett konto här!</a></div>';
        }else {
            echo ' 
        <div class="workspace2">

        <div class="leftColumn">
        <div class="list-container">';
            // TODO lägga till bilder som "previewar" vad som finns i listan
            // TODO stylea listorna
            //$userunfo = getUserInfo($_SESSION['userId']);
            $tbr = $userinfo['1'];
            $hr = $userinfo['2'];
            echo '<ul><li><a href="myBooks.php?list=tbr">Vill läsa</a></li>';
            echo '<li><a href="myBooks.php?list=hr">Har läst</a></li>';
            // Get nr of lists
            $numberOfLists = $userinfo['11'];
            if($numberOfLists != NULL) {
                $lists = getLists($_SESSION['userId']);
                if(!contains(';:',$lists['1'])) {
                    echo '<li><a href="myBooks.php?list='.$lists['1'].'">'.$lists['1'].'</a></li>';
                }else {
                    $listname = explode(';:',$lists['1']);
                    $listArticles = explode(';:',$lists['2']);
                    foreach ($listname as $x) {
                        echo '<li><a href="myBooks.php?list='.$x.'">'.$x.'</a></li>';
                    }
                }
            }
        echo '</ul></div>
        </div>

        <div class="rightColumn">';
        if(!isset($_GET['list'])) {
            // show tbr
            if($tbr == NULL) {
                echo 'Lägg till något i din vill läsa sida för att se det här';
            }else if(!contains(';:',$tbr)){
                echo '<h2>Vill läsa</h2>';
                echo    '<div class="item-container">
                        <div class="img"></div>
                        <div class="title">Titel</div>
                        <div class="author">Författare</div>
                        <div class="rating">Betyg</div>
                        <div class="edit-remove"></div>
                        </div>';
                // TODO kanske ska författarens namn ta en till en författare sida
                // TODO Hantera om något av det som ska echoas skulle vara null
                $book = getBookByBookId($tbr);
                if($book['11'] == NULL) {
                    $book['11'] = "Inget betyg";
                }
                echo   '<div class="item-container">
                        <a href="bookpage.php?bookId='.$tbr.'"><img class="img" src="'.$book['8'].'" ></a>
                        <a class="title" href="bookpage.php?bookId='.$tbr.'">'.$book['1'].'</a>
                        <a class="author" href="bookpage.php?bookId='.$tbr.'">'.$book['2'].'</a>
                        <div class="rating">'.$book['11'].'</div>
                        <div class="edit-remove"></div> 
                        </div>';
            }else {
                echo '<h2>Vill läsa</h2>';
                echo   '<div class="item-container">
                        <div class="img"></div>
                        <div class="title">Titel</div>
                        <div class="author">Författare</div>
                        <div class="rating">Betyg</div>
                        <div class="edit-remove"></div>
                        </div>';
                $tbr = explode(';:',$tbr);
                // TODO hantera antal resultat per sida

                if(sizeof($tbr) > 10) {
                    $articlesPerPage = 10;
                    $amountOfPages = (sizeof($tbr)-sizeof($tbr)%$articlesPerPage)/$articlesPerPage + 1;
                    if(!isset($_GET['page'])) {
                        $page = 1;
                    }else {
                        $page = $_GET['page'];
                    }
                    for($x = ($page - 1) * $articlesPerPage; $x < $page * $articlesPerPage;$x++) {
                        if(isset($tbr[strval($x)])) {
                            $book = getBookByBookId($tbr[strval($x)]);
                            if($book['11'] == NULL) {
                                $book['11'] = "Inget betyg";
                            }
                            echo '  <div class="item-container">
                                    <a href="bookpage.php?bookId='.$tbr[strval($x)].'"><img class="img" src="'.$book['8'].'" ></a>
                                    <a class="title" href="bookpage.php?bookId='.$tbr[strval($x)].'">'.$book['1'].'</a>
                                    <a class="author" href="bookpage.php?bookId='.$tbr[strval($x)].'">'.$book['2'].'</a>
                                    <div class="rating">'.$book['11'].'</div>
                                    <div class="edit-remove"></div> 
                                    </div>';
                        }


                    }
                    // PAGE BAR
                    // TODO styling på pagebaren
                    echo '<div class="item-container">
                <div></div>
                <div></div>
                <div><ul>';
                    if($page > 3) {
                        echo '<li">...</li>';
                    }
                    if ($page - 2 < 1 || $page + 2 > $amountOfPages ) {
                        if ($page - 2 < 1 && $page + 2 > $amountOfPages) {
                            for ($x = 1; $x <= $amountOfPages; $x++) {
                                echo '<li><a href="myBooks.php?page='.strval($x).'"> '.strval($x).' </a></li>';
                            }
                        }else if ($page + 2 > $amountOfPages){
                            $difference = $amountOfPages - $page - 2; // alltid negativ
                            for ($x = -2; $x <= 2; $x++) {
                                if ($page + $x + $difference <= $amountOfPages && $page + $x + $difference > 0) {
                                    echo '  <li><a href="myBooks.php?page='.strval($page + $x + $difference).'"> '.strval($page + $x + $difference).' </a></li>';
                                }
                            }
                        }else if ($page - 2 < 1) {
                            $difference = 1 - $page + 2;
                            for ($x = -2; $x <= 2; $x++) {
                                if ($page + $x + $difference > 0 && $page + $x + $difference <= $amountOfPages) {
                                    echo '  <li><a href="myBooks.php?page=' . strval($page + $x + $difference) . '"> ' . strval($page + $x + $difference) . ' </a></li>';
                                }
                            }
                        }
                    }else {
                        for ($x = -2; $x <= 2; $x++) {
                            echo '<li><a href="myBooks.php?page='.strval($page + $x).'"> '.strval($page + $x).' </a></li>';
                        }
                    }
                    if ($amountOfPages - $page > 3){
                        echo '<li class="page">...</li>';
                    }

                    echo ' </ul></div>
                    <div></div>
                    <div></div>
                    </div>';

                }else {
                    for($x = 0; $x < sizeof($tbr);$x++) {
                        $book = getBookByBookId($tbr[strval($x)]);
                        if($book['11'] == NULL) {
                            $book['11'] = "Inget betyg";
                        }
                        echo '  <div class="item-container">
                                <a href="bookpage.php?bookId='.$tbr[strval($x)].'"><img class="img" src="'.$book['8'].'" ></a>
                                <a class="title" href="bookpage.php?bookId='.$tbr[strval($x)].'">'.$book['1'].'</a>
                                <a class="author" href="bookpage.php?bookId='.$tbr[strval($x)].'">'.$book['2'].'</a>
                                <div class="rating">'.$book['11'].'</div>
                                <div class="edit-remove"></div> 
                                </div>';
                    }
                }
            }
        }else {
            // show $_GET['list']
            $list = $_GET['list'];
            if(strcasecmp($list,"hr") == 0) {
                $hr = $userinfo['2'];
                printList($hr,'hr');
            }
            else if(strcasecmp($list,"tbr") == 0) {
                $tbr = $userinfo['1'];
                printList($tbr,'tbr');
            }



        }



       echo ' </div>

        </div>';
        }

    function printList($list,$listName) {
        if($list == NULL) {
            echo 'Lägg till något i din vill läsa sida för att se det här';
        }else if(!contains(';:',$list)){
            echo '<h2>Vill läsa</h2>';
            echo    '<div class="item-container">
                        <div class="img"></div>
                        <div class="title">Titel</div>
                        <div class="author">Författare</div>
                        <div class="rating">Betyg</div>
                        <div class="edit-remove"></div>
                        </div>';
            // TODO kanske ska författarens namn ta en till en författare sida
            // TODO Hantera om något av det som ska echoas skulle vara null
            $book = getBookByBookId($list);
            if($book['11'] == NULL) {
                $book['11'] = "Inget betyg";
            }
            echo   '<div class="item-container">
                        <a href="bookpage.php?bookId='.$list.'"><img class="img" src="'.$book['8'].'" ></a>
                        <a class="title" href="bookpage.php?bookId='.$list.'">'.$book['1'].'</a>
                        <a class="author" href="bookpage.php?bookId='.$list.'">'.$book['2'].'</a>
                        <div class="rating">'.$book['11'].'</div>
                        <div class="edit-remove"></div> 
                        </div>';
        }else {
            echo '<h2>Vill läsa</h2>';
            echo   '<div class="item-container">
                        <div class="img"></div>
                        <div class="title">Titel</div>
                        <div class="author">Författare</div>
                        <div class="rating">Betyg</div>
                        <div class="edit-remove"></div>
                        </div>';
            $list = explode(';:',$list);
            // TODO hantera antal resultat per sida

            if(sizeof($list) > 10) {
                $articlesPerPage = 10;
                $amountOfPages = (sizeof($list)-sizeof($list)%$articlesPerPage)/$articlesPerPage + 1;
                if(!isset($_GET['page'])) {
                    $page = 1;
                }else {
                    $page = $_GET['page'];
                }
                for($x = ($page - 1) * $articlesPerPage; $x < $page * $articlesPerPage;$x++) {
                    if(isset($list[strval($x)])) {
                        $book = getBookByBookId($list[strval($x)]);
                        if($book['11'] == NULL) {
                            $book['11'] = "Inget betyg";
                        }
                        echo '  <div class="item-container">
                                    <a href="bookpage.php?bookId='.$list[strval($x)].'"><img class="img" src="'.$book['8'].'" ></a>
                                    <a class="title" href="bookpage.php?bookId='.$list[strval($x)].'">'.$book['1'].'</a>
                                    <a class="author" href="bookpage.php?bookId='.$list[strval($x)].'">'.$book['2'].'</a>
                                    <div class="rating">'.$book['11'].'</div>
                                    <div class="edit-remove"></div> 
                                    </div>';
                    }


                }
                // PAGE BAR
                // TODO styling på pagebaren
                echo '<div class="item-container">
                <div></div>
                <div></div>
                <div><ul>';
                if($page > 3) {
                    echo '<li">...</li>';
                }
                if ($page - 2 < 1 || $page + 2 > $amountOfPages ) {
                    if ($page - 2 < 1 && $page + 2 > $amountOfPages) {
                        for ($x = 1; $x <= $amountOfPages; $x++) {
                            echo '<li><a href="myBooks.php?page='.strval($x).'&list='.$listName.'"> '.strval($x).' </a></li>';
                        }
                    }else if ($page + 2 > $amountOfPages){
                        $difference = $amountOfPages - $page - 2; // alltid negativ
                        for ($x = -2; $x <= 2; $x++) {
                            if ($page + $x + $difference <= $amountOfPages && $page + $x + $difference > 0) {
                                echo '  <li><a href="myBooks.php?page='.strval($page + $x + $difference).'&list='.$listName.'"> '.strval($page + $x + $difference).' </a></li>';
                            }
                        }
                    }else if ($page - 2 < 1) {
                        $difference = 1 - $page + 2;
                        for ($x = -2; $x <= 2; $x++) {
                            if ($page + $x + $difference > 0 && $page + $x + $difference <= $amountOfPages) {
                                echo '  <li><a href="myBooks.php?page=' . strval($page + $x + $difference) . '&list='.$listName.'"> ' . strval($page + $x + $difference) . ' </a></li>';
                            }
                        }
                    }
                }else {
                    for ($x = -2; $x <= 2; $x++) {
                        echo '<li><a href="myBooks.php?page='.strval($page + $x).'&list='.$listName.'"> '.strval($page + $x).' </a></li>';
                    }
                }
                if ($amountOfPages - $page > 3){
                    echo '<li class="page">...</li>';
                }

                echo ' </ul></div>
                    <div></div>
                    <div></div>
                    </div>';

            }else {
                for($x = 0; $x < sizeof($list);$x++) {
                    $book = getBookByBookId($list[strval($x)]);
                    if($book['11'] == NULL) {
                        $book['11'] = "Inget betyg";
                    }
                    echo '  <div class="item-container">
                                <a href="bookpage.php?bookId='.$list[strval($x)].'"><img class="img" src="'.$book['8'].'" ></a>
                                <a class="title" href="bookpage.php?bookId='.$list[strval($x)].'">'.$book['1'].'</a>
                                <a class="author" href="bookpage.php?bookId='.$list[strval($x)].'">'.$book['2'].'</a>
                                <div class="rating">'.$book['11'].'</div>
                                <div class="edit-remove"></div> 
                                </div>';
                }
            }
        }
    }

    function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
    ?>

</main>

<?php
require "footer.php";
?>
