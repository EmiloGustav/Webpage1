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
            button.innerText = "betyg x av y röster, dölj?";
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
            <img src="images/isprinsessan.jpg" alt="Books" width="250px" height="400px">
        </div>

        <div class="col">
            <h3>Isprinsessan</h3>
            <h4>Camilla Läckberg</h4>
            <div class="summarise">
                Huset var ödsligt och tomt. Kylan trängde in i alla vrår. En tunn hinna av is hade bildats i badkaret. Hon hade börjat anta en lätt blåaktig ton. Han tyckte att hon såg ut som en prinsessa där hon låg. En isprinsessa. Golvet han satt på var iskallt, men kylan bekymrade honom inte. Han sträckte ut handen och rörde vid henne. Blodet på hennes handleder hade för länge sedan stelnat. Kärleken till henne hade aldrig varit starkare. Han smekte hennes arm, som om han smekte den själ som nu flytt kroppen. Han vände sig inte om när han gick. Det var inte adjö, utan på återseende.I debutromanen Isprinsessan förlägger Camilla Läckberg handlingen vintertid till sin hemort Fjällbacka och låter morden växa fram ur småstadsandans sämre sidor. Hon tecknar ett porträtt av ett slutet samhälle där alla, på gott och ont, vet allt om varandra och där det yttre skenet har stor betydelse. Något som under fel omständigheter kan bli ödesdigert ...
            </div>
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
