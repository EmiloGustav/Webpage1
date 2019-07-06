<?php
$bookId = $_GET['bookId'];
require "header.php";
include "includes/getDb.inc.php";
$array = getBookByBookId($bookId);
?>
    <script type="text/javascript">
        function switchRating() {

            var rating = document.getElementById("rating");
            var button = document.getElementById("ratingButton");
            button.innerText=rating.style.display;
            if(rating.style.display == "none" ||rating.style.display == ""||rating.style.display == null ){
                rating.style.display = "block";
                button.innerText = "Dölj betyg";
            }else if(rating.style.display == "block") {
                rating.style.display ="none";
                button.innerText = "Visa betyg";
            }
        }
    </script>
    <main class="container">
        <link rel="stylesheet" type="text/css" href="css/bookpage.css">
        <div class="workspace">

            <div class="col">

                <!-- Hur ska vi göra med bilder här för att få generiskt, typ images/$creator/$title.jpg ?-->

                <?php echo '<img src="'.$array['9'].'" alt="Books" width="250px" height="400px">'; ?>
            </div>

            <div class="col">

                <h3><?php echo $array['1'];?></h3>
                <h4><?php echo $array['2']?></h4>

                <!-- vi måste hitta summeringen någonstans så att vi kan lägga in den -->

                <div class="summarise">
                    <?php echo $array['5']; ?>
                </div>

                <!-- lägga till databs så att ratingen tas från den och läggs in där när någon klickar på stjärnorna -->

                <div id="ratingBox" >
                    <button type="button" onclick="switchRating()" id="ratingButton">Visa betyg</button>
                    <p id="rating">
                        <?php
                        echo '4.45'
                        ?>
                    </p>
                </div>
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5"><label for="star5" title="Perfekt"></label>
                    <input type="radio" id="star4" name="rate" value="4"><label for="star4" title="Bra"></label>
                    <input type="radio" id="star3" name="rate" value="3"><label for="star3" title="Okej"></label>
                    <input type="radio" id="star2" name="rate" value="2"><label for="star2" title="Inte så bra"></label>
                    <input type="radio" id="star1" name="rate" value="1"><label for="star1" title="Väldigt dålig"></label>
                </div>

                <!-- ladda kommentarer från en databas som hör ihop med boken -->

                <div class="commentfield">
                    Kommentarer:
                    <div class="comment">
                        Camilla läckberg, <br>
                        Fyfan vad bra!
                    </div>
                    <div class="comment">
                        Per, 54. <br>
                        Denna var sjuk, läs den /Per
                    </div>
                </div>
            </div>

            <div class="col">

            </div>
        </div>
    </main>

<?php
require "footer.php";
?>
<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-22
 * Time: 13:31
 */