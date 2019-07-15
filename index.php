<?php
include "includes/getDb.inc.php";
require 'header.php';

//$array = getBookById('2E5OAgAAQBAJ');
?>
<main class="container">

    <link href="https://fonts.googleapis.com/css?family=Catamaran&display=swap" rel="stylesheet">

    <style>
        header {
            background-color: #fff;
            width: 100%;
            height: 35px;
        }

        header .header-logo {
            float: left;
            margin-left: 300px;
            font-family: 'Catamaran', sans-serif;
            font-size: 24px;
            font-weight: 900px;
            color: #111;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
        }

        .index-banner {
            width: 100%;
            height: 50vh;
            background-image: url('images/bookshelf.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            display: table;
        }

        .vertical-center {
            display: table-cell;
            vertical-align: middle;
        }

        .index-banner h2 {
            font-family: 'Catamaran', sans-serif;
            font-size: 60px;
            font-weight: 900;
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px #111;
        }

        .index-banner p {
            max-width: 900px;
            margin: auto;
            font-family: 'Catamaran', sans-serif;
            font-size: 28px;
            font-weight: 100;
            line-height: 38px;
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px #111;
        }

        .register-button button {
            background: rgb(66, 184, 221, 0.8);
            border: none;
            border-radius: 6px;
            color: white;
            padding: 10px 25px;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }

        .register-button button:hover {
            background: rgb(66, 184, 221);
        }

        .main-content {
            max-width: 1000px;
            margin: auto;
            margin-top: 10px;
            display: grid;
            grid-template-columns: 60% 40%;
            grid-column-gap: 1em;
            grid-row-gap: 1em;
            align-content: center;
            font-family: 'Catamaran', sans-serif;
        }

        .main-content>div {
            border-top: 1px solid;
            border-top-color: lightgray;
            padding: 1em;
        }

        input[type=text],
        input[type=password],
        .login-button {
            float: right;
            margin-left: 5px;
        }

        .login-button {
            margin-right: 250px;
            background-color: gray;
            border: none;
            border-radius: 3px;
            color: white;
            padding: 3px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: darkslategrey;
        }

        .findsummerbook-button,
        .makead-button {
            background-color: #f44336;
            border: none;
            border-radius: 6px;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }

        .findsummerbook-button:hover,
        .makead-button:hover {
            background-color: #f20000;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <?php
    if (!isset($_SESSION['userId'])) {
        ?>
        <header>
            <a href="index.html" class="header-logo">BonoLibro</a>

            <?php
            if (!isset($_SESSION['userId'])) {
                echo '  
                    <form action="includes/login.inc.php" method="post">
                        <button type="submit" name="login-submit" class="login-button"><span>Logga in</span></button>
                        <input type="password" placeholder="Lösenord..." name="password" id="right" style="width:106px;">
                        <input type="text" placeholder="Användarnamn..." name="username" id="right">
                    </form>';
            } else {
                echo '
                    <form action="includes/logout.inc.php" method="post">
                       <button type="submit" name="logout-submit" id="right"><span>Logga ut</span></button>
                    </form>
                    <a href="myProfile.php" id="profile">', $_SESSION['userUid'], '\'s profil </a>
                    ';
            }
            ?>

        </header>

        <section class="index-banner">
            <div class="vertical-center">
                <h2>Utforska världens böcker.</h2>
                <p>På BonoLibro kan du hitta nästa spännande läsning, följa författare eller andra läsare...</p>
                <form action="signup.php">
                    <div class="register-button" style="text-align:center">
                        <button type="submit">Skapa ett konto</button>
                    </div>
                </form>
            </div>

        </section>
        <section class="main-content">
            <div class="box-1">
                <h2>Semesterns populäraste böcker</h2>
                <p>BonoLibro har sammanställt de populäraste böckerna och författarna enligt er användare.</p>
                <button type="button" class="findsummerbook-button">Hitta sommarens bok</button>
            </div>
            <div class="box-2">
                <h1>Här är en lista eller slideshow.</h1>
            </div>
            <div class="box-3">
                <h2>Är du författare eller utgivare?</h2>
                <p>Gör reklam för böcker eller ett förlag och nå ut till BonoLibros användare.</p>
                <button type="button" class="makead-button">Gör reklam</button>
            </div>
            <div class="box-4">
                <h1>Här är reklam.</h1>
            </div>
        </section>

    <?php
    } else {
        ?>
        <div class="workspace">
            <div class="col">
                <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop& w =1050&q=80" a l t="Books" wi d th="4 26" height="250">

                <?php
                /*if(isset($_SESSION['userId'])) {
                        $userInfo = getUserInfo($_SESSION['userId']);
                        $userInfo['2'] = 'hello23';
                        $newUserInfo=changeUserData($userInfo);
    
    
                        echo print_r($newUserInfo);
                    }*/

                //echo '<img src="'.$array['9'].'"  width="80" height="80">';
                if (isset($_GET["newpwd"])) {
                    if ($_GET["newpwd"] == "passwordupdated") {
                        echo '<p class="signupsucess">Ditt lösenord har blivit återställt!</p>';
                    }
                }
                ?>
            </div>

            <div class=" col ">
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
            </div>

            <div class=" col ">
                <?php
                if (!isset($_SESSION['userId'])) {
                    echo '
                    <h2 class="newUserMessage">
                        Ny här? <a href="signup.php">Skapa ett konto gratis!</a>
                    </h2>
                    ';
                } else {
                    echo ' <h2 class= "newUserMessage">
                    Välkommen!
                    </h2>
                    ';
                }
                ?>

            </div>
        </div>

    <?php
    }
    ?>

    <script src="js/index.js"></script>

</main>

<?php
require  "footer.php"
?>