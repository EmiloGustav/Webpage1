<?php
require "header.php";
include "includes/getDb.inc.php";
if (isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
}

?>
<main class="container"><!--uses the full size of the browser and hides the overflow if any -->
    <link rel="stylesheet" type="text/css" href="css/myBooks/myBooks.css">
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
        .closeBtn {
            float:right;
            font-size: 14px;
            border: none;
            font-weight: bold;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        h6 {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }
        .btnYes {
            border-style: solid;
            border-width: 1px;
            border-color: black;
            background: grey;
            margin-left: 42%;
            margin-right: 10px;
            padding: 10px 20px;

            text-decoration:none;
            color: #000;
            font-size: 14px;
        }
        .btnNo{

            border-style: solid;
            border-width: 1px;
            border-color: black;
            background: grey;
            margin-right: 10px;
            padding: 10px 20px;

            text-decoration:none;
            color: #000;
            font-size: 14px;
        }
    </style>
    <script type="text/javascript">
        function addList() {
            document.getElementById('buttonJs').remove();
            var li = document.createElement('LI');
            li.setAttribute('id','jsNew');
            var form = document.createElement('FORM');
            form.setAttribute('action','includes/lists.inc.php?type=addList');
            form.setAttribute('method','POST');
            form.setAttribute('id','formNew')
            var input = document.createElement('INPUT') ;
            input.setAttribute('type','text')
            input.setAttribute('placeholder','Listans namn...')
            input.setAttribute('name','listName')
            var button = document.createElement('BUTTON');

            button.innerHTML = 'Skapa';
            button.setAttribute('type','submit');

            document.getElementById('js').parentNode.insertBefore(li,document.getElementById('js'));
            document.getElementById('jsNew').appendChild(form);
            document.getElementById('formNew').appendChild(input);
            document.getElementById('formNew').appendChild(button);
        }

    </script>
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
            // TODO kolla vilak tecken man får ha i listorna.
            //$userunfo = getUserInfo($_SESSION['userId']);
            $tbr = $userinfo['1'];
            $hr = $userinfo['2'];
            echo '<ul id="jsparent"><li><a href="myBooks.php?list=tbr">Vill läsa</a></li>';
            echo '<li><a href="myBooks.php?list=hr">Har läst</a></li>';
            // Get nr of lists
            $numberOfLists = $userinfo['11'];
            if($numberOfLists != NULL) {
                $lists = getLists($_SESSION['userId']);
                if(!contains(';:',$lists['1'])) {
                    $delfkn="deleteList('".$lists['1']."');";
                    echo '<li><a href="myBooks.php?list='.$lists['1'].'">'.$lists['1'].'</a><button class="closeBtn" onclick="'.$delfkn.'">&times;</button></li>';
                }else {
                    $listname = explode(';:',$lists['1']);
                    $listArticles = explode(';:',$lists['2']);
                    foreach ($listname as $x) {
                        $delfkn="deleteList('".$x."');";
                        echo '<li><a href="myBooks.php?list='.$x.'">'.$x.'</a><button class="closeBtn" onclick='.$delfkn.'>&times;</button></li>';
                    }
                }
            }
            echo '<li id="js"><button id="buttonJs" onclick="addList();">Skapa en ny lista</button></li>';
        echo '</ul></div>
        </div>

        <div class="rightColumn">';

        echo '  <div id="myModal" class="modal">
                <div class="modal-content" id="modalContent">
                <span class="close" id="modalSpan">&times;</span>
                
                
                </div></div>';


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

    ?>
    <script type="text/javascript">
        var span = document.getElementById('modalSpan');
        var modal = document.getElementById('myModal');
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        function deleteList(listName) {
            var modal = document.getElementById('myModal');
            modal.style.display='block';
            var mc = document.getElementById('modalContent');
            var h6 = document.createElement('H6');
            h6.innerText = 'Är du säker på att du vill ta bort listan '+listName.replace('+nsh+',' ' )+' och alla böcker i den?';
            var btnYes = document.createElement('A');
            btnYes.innerText = "Ja";
            btnYes.setAttribute('href','includes/lists.inc.php?type=removeList&listName='+listName);
            btnYes.setAttribute('class','btnYes');
            var btnNo = document.createElement('BUTTON');
            btnNo.innerText = "Nej";
            btnNo.setAttribute('class','btnNo');
            btnNo.setAttribute('onclick','document.getElementById("myModal").style.display=none;');
            mc.appendChild(h6);
            mc.appendChild(btnYes);
            mc.appendChild(btnNo);
        }
    </script>
</main>

<?php
require "footer.php";
?>
