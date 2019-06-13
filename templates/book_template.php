<?php
require "header.php";
?>

<script type="text/javascript">
    function switchRating() {

        var rating = document.getElementById("rating");
        var button = document.getElementById("ratingButton");
        button.innerText=rating.style.display;
        if(rating.style.display == "none" ||rating.style.display == ""||rating.style.display == null ){
            rating.style.display = "block";
            button.innerText = "Betyg x av y röster, dölj?";
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
            <img src="images/..." alt="Books">
        </div>

        <div class="col">
            <h3>Titeln på boken</h3>
            <h4>Författaren namn</h4>
            <div class="summarise">
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
                Massor av text som står på baksidan.
            </div>
            <div id="ratingBox" >
                <button type="button" onclick="switchRating()" id="ratingButton">Visa betyg</button>
                <div class="rate" id="rating">
                    <input type="radio" id="star5" name="rate" value="5"><label for="star5" title="Perfekt"></label>
                    <input type="radio" id="star4" name="rate" value="4"><label for="star4" title="Bra"></label>
                    <input type="radio" id="star3" name="rate" value="3"><label for="star3" title="Okej"></label>
                    <input type="radio" id="star2" name="rate" value="2"><label for="star2" title="Inte så bra"></label>
                    <input type="radio" id="star1" name="rate" value="1"><label for="star1" title="Väldigt dålig"></label>
                </div>
            </div>
            <div class="commentfield">
                Kommentarer:
                <div class="comment">
                    Visningsnamn <br>
                    Här kommer själva kommentaren
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
