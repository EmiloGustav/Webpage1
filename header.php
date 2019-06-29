<?php
$color = "red";
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="This will often show up in search results">
    <meta name="viewport" content="width=device-width, initial scale=1">

    <link rel="stylesheet" type="text/css" href="css/Navigation.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

    <title>Coolbooks1996</title>
</head>

<body>
    <header>
        <h1>Coolbooks1996</h1>
        <nav id="navbar">
            <div class="workspace">
                <div class="col">
                    <ul>
                        <li><a href="index.php">Hem</a></li>
                        <li><a href="minsida.php">Mina böcker</a></li>
                        <li><a href="isprinsessan_camilla_lackberg.php">En bok</a></li>
                    </ul>
                </div>
                <div class="col">
                    <div class="search">
                        <form action="SearchResult.php" method="get">
                            <input id="search" type="text" placeholder="Sök efter en bok" name="book">
                        </form>
                    </div>
                </div>
                <div class="col">
                    <div class="login-container">
                        <?php
                        if(!isset($_SESSION['userId'])){
                            echo '  
                                    <form action="signup.php" method="post">
                                        <button type="submit" name="signup"><span>Skapa konto</span></button>
                                    </form>
                                    
                                    <form action="includes/login.inc.php" method="post">
                                        <button type="submit" name="login-submit"><span>Login</span></button>
                                        <input type="password" placeholder="Lösenord..." name="password" id="right" style="width:106px;">
                                        <input type="text" placeholder="Användarnamn..." name="username" id="right">
                                    </form>';
                        }else {
                            echo '
                                    <form action="includes/logout.inc.php" method="post">
                                        <button type="submit" name="logout-submit" id="right"><span>Logga ut</span></button>
                                    </form>
                                    <a href="myProfile.php" id="profile">',$_SESSION['userUid'],'\'s profil </a>
                                    ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <script type="text/javascript">
        window.onscroll = function(){
            followPage();
        }
        var navbar = document.getElementById("navbar");
        var sticky=navbar.offsetTop

        function followPage() {
            if(window.pageYOffset >= sticky){
                navbar.classList.add("sticky")
            }else {
                navbar.classList.remove("sticky")
            }
        }
    </script>
