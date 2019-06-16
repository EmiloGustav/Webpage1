<?php
require "header.php";
?>
<main class="container">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/index.js"></script>

    <div class="workspace">
        <div class="col">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width="426" height="250">
        </div>

        <div class="col">
            <div class="slideshow-container">
                <h2>Månadens populäraste böcker</h2>

                <div class="mySlides fade">
                    <div class="numbertext">1 / 4</div>
                    <img src="images/greatgatsby.jpg" width="200px" height="300px">
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">2 / 4</div>
                    <img src="images/tokillamockingbird.jpg" width="200px" height="300px">
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">3 / 4</div>
                    <img src="images/harrypotter.jpg" width="200px" height="300px">
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">4 / 4</div>
                    <img src="images/fahrenheit.jpg" width="200px" height="300px">
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
            </div>


        </div>

        <div class="col">
            <?php
            if(!isset($_SESSION['userId'])){
                echo '
                <h2 class="newUserMessage">
                Ny här? Skapa ett konto gratis!
                </h2>
                <!-- Ändra PATH -->
                <form action="includes/signup.inc.php" method="post">
                    <!-- Kanske göra som en lista och ha divs i varje li så att dem alltid blir på exakt samma höjd-->
                    <ul id="register">
                        <li id="space">
                            <div id="left">Användarnamn </div>
                            <div id="right"><input type="text" placeholder="Användarnamn" name="username" id="username"></div>
                        </li>
                        <li id=space>
                            <div id="left">Epost: </div>
                            <div id="right"><input type="email" placeholder="Email Adress" name="email" id="user_email"></div>
                        </li>
                        <li id="space">
                            <div id="left">Lösenord: </div>
                            <div id="right"><input type="password" placeholder="Lösenord" name="password" id="user_password_signup"></div>
                        </li>
                        <li id="space">
                            <div id="left">Återuppreppa Lösenord: </div>
                            <div id="right"><input type="password" placeholder="Lösenord" name="re-password" id="user_repassword_signup"></div>
                        </li>
                        <li id="right"><button type="submit" name="signup-submit">Registrera</button></li>
                    </ul>
                </form>
                ';
            }else {
               echo ' <h2 class="newUserMessage">
                Välkommen!
                </h2>
                ';
            }
            ?>

        </div>
    </div>

</main>


<?php
require "footer.php"
?>