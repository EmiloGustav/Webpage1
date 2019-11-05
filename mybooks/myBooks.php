<?php
session_start();
include '../includes/getDb.php';
$getDb = new getDb();
if (isset($_SESSION['userId'])) {
    $userinfo = $getDb->getUserInfo($_SESSION['userId']);
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

    <link rel="stylesheet" href="css/myBooks.css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
<link rel="stylesheet" type="text/css" href="css/myBooks.css">
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
                <li><a href="myBooks.php?list=tbr">Vill läsa</a></li>
                <hr>
                <li><a href="myBooks.php?list=hr">Har läst</a></li>
                <hr>
                <li><a href="myBooks.php?list=favourites">Favoriter</a></li>
                <hr>
                <?php
                $numberOfLists = $userinfo['11'];
                if ($numberOfLists != NULL) {
                    $lists = $getDb->getLists($_SESSION['userId']);
                    if (!$getDb->sqlErrorHandler->help->contains(';:', $lists['1'])) {
                        $delfkn = "deleteList('" . $lists['1'] . "');";
                        echo '<li><a href=myBooks.php?list=' . $lists['1'] . '">' . $lists['1'] . '</a><button class="closeBtn" onclick="'.$delfkn.'">&times;</button></li>';
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
                    <form action="../login-logout/logout.inc.php" method="post">
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
                    <select name=\"perPage\" id=\"perPage\" onchange=\"document.getElementById('form-perPage').submit()\">";
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
                        if(!isset($_GET['list'])) {
                            $listname="tbr";
                        }else {
                            $listname= $_GET['list'];
                        }
                        echo "</select><select name=\"list\" id=\"list\" style=\"display:none\"><option value=\"".$listname."\"></option></select>
                </form>
                <button onclick='toggleEdit()'>Edit</button>
                <button onclick='document.getElementById(\"editedList\").submit();' class='edit-list'>submit</button> 
                <hr>";
                    }else {
                        if(!isset($_GET['list'])) {
                            $listname="tbr";
                        }else {
                            $listname= $_GET['list'];
                        }
                        echo "<option value=\"5\">5</option>
                        <option value=\"10\">10</option>
                        <option value=\"25\">25</option>
                        <option value=\"50\">50</option>
                    </select>
                    <select name=\"list\" id=\"list\" style=\"display:none\"><option value=\"".$listname."\"></option></select>
                </form>
                <button onclick='toggleEdit()'>Edit</button>
                <button onclick='document.getElementById(\"editedList\").submit();' class='edit-list'>submit</button> 
                <hr>";
                    }


                }
                function echoBook($book) {
                    echo '<div class="list-bookItem">
                                    <img src="'.$book['8'].'" class="book-cover" alt="">
                
                                    <div class="bookItem-description">
                                        <a href="../bookpage/bookpage.php?bookId='.$book['0'].'" class="list-bookTitle">'.$book['1'].'</a>
                                        <p>Skriven av</p>
                                        <a href="author.php" class="list-bookAuthor">'.$book['2'].'</a>
                                    </div>
                
                                    <div class="bookItem-data">
                                        <p>Betyg: '.$book['11'].' / 5</p>
                                        <p>Lades till \'datum\'</p>
                                    </div>
                                    <input class="edit-list" type="checkbox" name="bookItem[]" value='.$book['0'].'> 
                                </div>
                                <hr>';
                }
                function printItems($listname,$list,$getDb) {
                    echo '<h1>'.$listname.'</h1>';
                    printArticlesPerPage();
                    echo '<form action="editBookList.inc.php?listName='.$listname.'" method="post" id="editedList">';
                    $list = explode(';:',$list);
                    // TODO hantera antal resultat per sida
                    if(gettype($list) == "string") {
                        echoBook($getDb->getBookByBookId($list));
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
                                    $book = $getDb->getBookByBookId($list[strval($x)]);
                                    if ($book['11'] == NULL) {
                                        $book['11'] = "Inget betyg";
                                    }
                                    echoBook($book);
                                }
                            }
                        }else{
                            foreach($list as $i) {
                                echoBook($getDb->getBookByBookId($i));
                            }
                        }
                    }
                }

                if(!isset($_GET['list'])) {
                    $tbr = $userinfo['1'];
                    printItems("Vill läsa",$tbr,$getDb);
                }else {
                    $list = $_GET['list'];
                    if(strcasecmp($list,"hr") == 0) {
                        $hr = $userinfo['2'];
                        printItems("Har läst",$hr,$getDb);
                    }
                    else if(strcasecmp($list,"tbr") == 0) {
                        $tbr = $userinfo['1'];
                        printItems("Vill läsa",$tbr,$getDb);
                    }else {
                        printItems($list,str_replace('::',';:',$getDb->getListItems($_GET['list'],$_SESSION['userId'])),$getDb);
                    }
                }
                echo '  <div id="myModal" class="modal">
                <div class="modal-content" id="modalContent">
                <span class="close" id="modalSpan" >&times;</span>
                
                
                </div></div>';
                ?>

                </form>

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
    <script type="text/javascript" src="javascript/addAndDeleteLists.js"></script>
    <script type="text/javascript" src="javascript/myBooks.js"></script>
</body>
</html>