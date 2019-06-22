<?php
require "header.php";
?>
<main class="container">

    <link rel="stylesheet" type="text/css" href="css/style.css">


    <div class="workspace">
        <div class="col">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width="426" height="250">
            <?php
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
    <script src="js/index.js"></script>
</main>


<?php
require  "footer.php"
?>