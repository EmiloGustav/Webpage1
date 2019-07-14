<?php
require "header.php";
include "includes/getDb.inc.php";
require "includes/dbh.inc.php";
//$array = getBookById('2E5OAgAAQBAJ');
?>
<main class="container">

    <link rel="stylesheet" type="text/css" href="css/style.css">


    <div class="workspace">
        <div class="col">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width="426" height="250">

            <?php
                /*if(isset($_SESSION['userId'])) {
                    $userInfo = getUserInfo($_SESSION['userId']);
                    $userInfo['2'] = 'hello23';
                    $newUserInfo=changeUserData($userInfo);


                    echo print_r($newUserInfo);
                }*/

                //echo '<img src="'.$array['9'].'"  width="80" height="80">';
/*
                $rating = -1;
                $conn = getConnection();
                $bookId = 9;
                $removedRating=5;

                $sql = "SELECT * FROM books WHERE bookId=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)) {
                    // TODO ERRORHANTERING
                    return false;
                }else {
                    mysqli_stmt_bind_param($stmt, "s", $bookId);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $array = mysqli_fetch_array($result, MYSQLI_NUM);

                    $currentRating = $array['11'];
                    $nrOfRatings = $array['14'];
                  //  echo $currentRating.'<br>';
                  //  echo $nrOfRatings;
                    if($rating == -1 && $removedRating != 0) {
                        if($currentRating == NULL){
                            // TODO error borde ej kunna vara null när man kommer till remove
                        }else if ((int) $nrOfRatings - 1 < 0) {
                            // TODO error, borde ej kunna gå
                        }else if ((int) $nrOfRatings == 1 ){
                            $currentRating = 0;
                            $nrOfRatings = 0;
                        }else{

                            // (4 * 2 - 4) / 1
                            // (4 * 2 - 3 ) / 1
                            echo $currentRating.'<br>';
                            echo $nrOfRatings.'<br>';
                            (float)$tmpCurrentRating = (((float)$currentRating*$nrOfRatings)-$removedRating)/($nrOfRatings - 1);
                            $currentRating = $tmpCurrentRating;
                            $nrOfRatings--;
                        }
                    }else {
                        if($currentRating == NULL){
                            $currentRating = $rating;
                            $nrOfRatings = 1;
                        }else {
                            (float)$currentRating = ($currentRating+$rating)/2;
                            $nrOfRatings++;
                        }
                    }
                    $sql = "UPDATE books SET rating=?, nrOfRatings=? WHERE bookId=?";
                    if(!mysqli_stmt_prepare($stmt,$sql)) {
                        // TODO ERRORHANTERING
                        return false;
                    }else {
                        mysqli_stmt_bind_param($stmt, "sss", $currentRating,$nrOfRatings,$bookId);
                        mysqli_stmt_execute($stmt);
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }

                if((int)$rating == -1) {
                    echo gettype($rating);
                }*/



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