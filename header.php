<?php
$color = "red";
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
                <ul>
                    <li><a href="index.php">Hem</a></li>
                    <li><a href="minsida.php">Mina böcker</a></li>
                    <li><a href="isprinsessan_camilla_lackberg.php">En bok</a></li>
                    <li>
                        <div class="search">
                            <form action="search.php">
                                <input id="search" type="text" placeholder="Sök efter en bok" name="book">
                            </form>
                        </div>
                    </li>
                    <li><div class="login-container">
                        <!-- Ändra PATH -->
                        <form action="/action_page.php">
                            <button type="submit_login">Login</button>
                            <input type="text" placeholder="Lösenord" name="password">
                            <input type="text" placeholder="Användarnamn" name="username">
                        </form>
                    </div></li>
                </ul>
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
