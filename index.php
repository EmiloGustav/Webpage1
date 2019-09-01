<?php
include "includes/getDb.inc.php";
require 'header.php'

//$array = getBookById('2E5OAgAAQBAJ');
?>
<div class="container">

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
            height: 100vh;
            background-color: #3F3F3F;
            display: table;
        }

        .vertical-center {
            display: table-cell;
            vertical-align: middle;
        }

        .index-banner h2 {
            font-family: 'Catamaran', sans-serif;
            font-size: 55px;
            font-weight: 900;
            color: #fff;
            text-align: center;
        }

        .index-banner p {
            max-width: 600px;
            margin: auto;
            font-family: 'Catamaran', sans-serif;
            font-size: 20px;
            font-weight: 100;
            line-height: 28px;
            color: #fff;
            text-align: center;
        }

        .getstarted-a {
            background: none;
            border: 2px solid white;
            color: white;
            padding: 10px 20px;
            margin-top: 40px;
            text-decoration: none;
            font-family: 'Catamaran', sans-serif;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.5s;
        }

        a.getstarted-a:hover {
            background-color: #fff;
            color: black;
        }

        .main-content {
            max-width: 1150px;
            margin: auto;
            margin-top: 10px;
            display: grid;
            grid-template-columns: 100%;
            grid-column-gap: 1em;
            grid-row-gap: 1em;
            align-content: center;
            font-family: 'Catamaran', sans-serif;
        }

        .main-content>div {
            padding: 1em;
        }

        .box-1 {
            height: 100vh;
            margin-top: 200px;
            display: grid;
            grid-template-columns: 55% 45%;
        }

        .box-1 hr {
            border: 2px solid orange;
            margin-right: 100%;
            float: left;
            width: 80px;
        }

        .box-1 h1.box1-title {
            background: #fff;
            color: #111;
            float: left;
            font-family: 'Catamaran', sans-serif;
            font-size: 40px;
        }

        .box-1 p {
            float: left;
            margin: auto;
            margin-top: 10px;
            line-height: 25px;
            color: #737373;
        }

        .down-arrow {
            grid-column-start: 1;
            grid-column-end: 2;
        }

        .box-2 {
            display: grid;
            grid-template-columns: 50% 50%;
        }

        .register-button {
            background: none;
            border: 2px solid white;
            color: white;
            padding: 10px 20px;
            margin-top: 40px;
            text-decoration: none;
            font-family: 'Catamaran', sans-serif;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.5s;
        }

        .register-button button:hover {
            background-color: #fff;
            color: black;
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

    <?php
    if (!isset($_SESSION['userId'])) {
        ?>

        <section class="index-banner">
            <div class="vertical-center">
                <h2>Din nya favoritbok väntar på dig.</h2>
                <p>Samlar dina böcker som du har läst, ska läsa eller vill läsa.</p>

                <a class="getstarted-a" href="#box-1">KOM IGÅNG</a>

                <!--<form action="signup.php">
                    <div class="register-button" style="text-align:center">
                        <button type="submit" onclick="scrollFunction()">KOM IGÅNG</button>
                    </div>-->

                </form>
            </div>

        </section>

        <section class="main-content">
            <section id="box-1">
                <div class="box-1">
                    <div class="image-side">
                        <img src="images/books-and-beach.jpg" height="343px" width="530px">
                    </div>
                    <div class="description-side">
                        <hr>
                        <h1 class="box1-title">BonoLibro</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit
                            amet ultricies est. Pellentesque non leo eget dui pulvinar hendrerit. Pellentesque non leo eget dui pulvinar hendrerit.</p>
                        <form action="signup.php">
                            <div class="register-button" style="text-align:center">
                                <button type="submit">Starta ett konto</button>
                            </div>
                        </form>
                    </div>
                    <a href="#box-2" width="60" height="60">
                        <img id="down-arrow" src="images/down-arrow.png" width="60" height="60">
                    </a>
                </div>
            </section>

            <section id="box-2">
                <div class="box-2">
                    <div class="image-side">
                        <img src="images/fahrenheit.jpg" height="300px" width="200px">
                    </div>
                    <div class="description-side">
                        <h2>Semesterns populäraste böcker</h2>
                        <p>BonoLibro har sammanställt de populäraste böckerna och författarna enligt er användare.</p>
                        <button type="button" class="findsummerbook-button">Hitta sommarens bok</button>
                    </div>
                </div>
            </section>

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

    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="js/index.js"></script>

</div>

<?php
require  "footer.php"
?>