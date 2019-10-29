<?php
session_start();
include 'includes/getDb.inc.php';
if (isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
}
// TODO konstig skalning på bilderna när skärmen är under ett visst antal px
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
<script type="text/javascript">
    function addList() {
        document.getElementById('createList').remove();
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

        document.getElementById('liCreateList').parentNode.insertBefore(li,document.getElementById('liCreateList'));
        document.getElementById('jsNew').appendChild(form);
        document.getElementById('formNew').appendChild(input);
        document.getElementById('formNew').appendChild(button);
    }

</script>
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
                <li><a href="myBooksV2.php?list=hr">Har läst</a></li>
                <hr>
                <li><a href="myBooksV2.php?list=favourites">Favoriter</a></li>
                <hr>
                <?php
                $numberOfLists = $userinfo['11'];
                if ($numberOfLists != NULL) {
                    $lists = getLists($_SESSION['userId']);
                    if (!contains(';:', $lists['1'])) {
                        $delfkn = "deleteList('" . $lists['1'] . "');";
                        echo '<li><a href=myBooksV2.php?list=' . $lists['1'] . '">' . $lists['1'] . '</a><button class="closeBtn" onclick="'.$delfkn.'">&times;</button></li>';
                        echo '<hr>';
                    } else {
                        $listname = explode(';:', $lists['1']);
                        foreach($listname as $i) {
                            $delfkn="deleteList('".$i."');";
                            echo '<li><a href="myBooks.php?list='.$i.'">'.$i.'</a><button class="closeBtn" onclick="'.$delfkn.'">&times;</button></li>';
                            echo '<hr>';
                        }
                    }
                }
                ?>
                <li id="liCreateList"><button id="createList" onclick="addList()">+ Skapa ny lista</button></li>
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


                <?php
                function printArticlesPerPage() {

                    echo "<form action=\"\" id=\"form-perPage\">
                    <label for=\"perPage\">per sida</label>
                    <select name=\"perPage\" id=\"perPage\" onchange=\"this.form.submit()\">";
                    if(isset($_GET['perPage'])) {
                        for($i=0;$i<4;$i++) {
                            $articlesPerPage=0;
                            switch($i) {
                                case 0:
                                    $articlesPerPage=5;
                                    break;
                                case 1:
                                    $articlesPerPage=10;
                                    break;
                                case 2:
                                    $articlesPerPage=25;
                                    break;
                                case 3:
                                    $articlesPerPage=50;
                                    break;
                            }
                            if($_GET['perPage'] == $articlesPerPage) {
                                echo '<option value='.$articlesPerPage.' selected=\"selected\">'.$articlesPerPage.'</option>';
                            }else {
                                echo '<option value='.$articlesPerPage.'>'.$articlesPerPage.'</option>';
                            }
                        }
                        echo "</select><select name=\"list\" id=\"list\" style=\"display:none\"><option value=\"".$_GET['list']."\"></option></select>
                </form>

                <hr>";
                    }else {
                        echo "<option value=\"5\">5</option>
                        <option value=\"10\">10</option>
                        <option value=\"25\">25</option>
                        <option value=\"50\">50</option>
                    </select>
                    <select name=\"list\" id=\"list\" style=\"display:none\"><option value=\"".$_GET['list']."\"></option></select>
                </form>

                <hr>";
                    }


                }
                function echoBook($book) {
                    echo '<div class="list-bookItem">
                                    <img src="'.$book['8'].'" class="book-cover" alt="">
                
                                    <div class="bookItem-description">
                                        <a href="bookpage.php?bookId='.$book['0'].'" class="list-bookTitle">'.$book['1'].'</a>
                                        <p>Skriven av</p>
                                        <a href="author.php" class="list-bookAuthor">'.$book['2'].'</a>
                                    </div>
                
                                    <div class="bookItem-data">
                                        <p>Betyg: '.$book['11'].' / 5</p>
                                        <p>Lades till \'datum\'</p>
                                    </div>
                                </div>
                                <hr>';
                }
                function printItems($listname,$list) {
                    echo '<h1>'.$listname.'</h1>';
                    printArticlesPerPage();
                    $list = explode(';:',$list);
                    // TODO hantera antal resultat per sida
                    if(gettype($list) == "string") {
                        echoBook(getBookByBookId($list));
                    }else if(gettype($list) == "array") {
                        if(isset($_GET['perPage'])) {
                            $articlesPerPage = $_GET['perPage'];
                        }else {
                            $articlesPerPage = 5;
                        }
                        if(sizeof($list) > $articlesPerPage) {
                            $amountOfPages = (sizeof($list)-sizeof($list)%$articlesPerPage)/$articlesPerPage + 1;
                            if(!isset($_GET['page'])) {
                                $page = 1;
                            }else {
                                $page = $_GET['page'];
                            }
                            for($x = ($page - 1) * $articlesPerPage; $x < $page * $articlesPerPage;$x++) {
                                if (isset($list[strval($x)])) {
                                    $book = getBookByBookId($list[strval($x)]);
                                    if ($book['11'] == NULL) {
                                        $book['11'] = "Inget betyg";
                                    }
                                    echoBook($book);
                                }
                            }
                        }else{
                            foreach($list as $i) {
                                echoBook(getBookByBookId($i));
                            }
                        }
                    }
                }

                if(!isset($_GET['list'])) {
                    $tbr = $userinfo['1'];
                    printItems("Vill läsa",$tbr);
                }else {
                    $list = $_GET['list'];
                    if(strcasecmp($list,"hr") == 0) {
                        $hr = $userinfo['2'];
                        printItems("Har läst",$hr);
                    }
                    else if(strcasecmp($list,"tbr") == 0) {
                        $tbr = $userinfo['1'];
                        printItems("Vill läsa",$tbr);
                    }else {
                        printItems($list,getListItems());
                    }
                }
                echo '  <div id="myModal" class="modal">
                <div class="modal-content" id="modalContent">
                <span class="close" id="modalSpan" >&times;</span>
                
                
                </div></div>';
                ?>



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
    <script type="text/javascript">
        var span = document.getElementById('modalSpan');
        var modal = document.getElementById('myModal');
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            document.getElementsByClassName("h6")[0].remove();
            document.getElementsByClassName("btnNo")[0].remove();
            document.getElementsByClassName("btnYes")[0].remove();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                document.getElementsByClassName("h6")[0].remove();
                document.getElementsByClassName("btnNo")[0].remove();
                document.getElementsByClassName("btnYes")[0].remove();
            }
        }
        function deleteList(listName) {
            var modal = document.getElementById('myModal');
            modal.style.display='block';
            var mc = document.getElementById('modalContent');
            var h6 = document.createElement('H6');
            h6.innerText = 'Är du säker på att du vill ta bort listan '+listName+' och alla böcker i den?';
            h6.setAttribute('class','h6');
            var btnYes = document.createElement('A');
            btnYes.innerText = "Ja";
            btnYes.setAttribute('href','includes/lists.inc.php?type=removeList&listName='+listName);
            btnYes.setAttribute('class','btnYes');
            var btnNo = document.createElement('BUTTON');
            btnNo.innerText = "Nej";
            btnNo.setAttribute('class','btnNo');
            btnNo.setAttribute('onClick','document.getElementById("myModal").style.display="none";document.getElementsByClassName("h6")[0].remove();document.getElementsByClassName("btnNo")[0].remove();document.getElementsByClassName("btnYes")[0].remove();');
            mc.appendChild(h6);
            mc.appendChild(btnYes);
            mc.appendChild(btnNo);

        }
    </script>
</body>

</html>