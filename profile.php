<?php
require "header.php";
?>

<main class="container">

    <style>
        .wrapper {
            max-width: 900px;
            margin: auto;
            display: grid;
            grid-template-columns: 70% 30%;
            grid-gap: 1em;
        }

        .wrapper>div {
            background: #eee;
            padding: 1em;
        }

        .wrapper .leftContainer .top {
            display: grid;
            grid-template-columns: 30% 70%;
        }

        .wrapper .leftContainer .top .image {
            font-size: 13px;
            text-align: center;
        }

        .wrapper .leftContainer .top .info .location {
            font-size: 15px;
            font-weight: bold;
        }
    </style>

    <div class="wrapper">
        <!-- LEFT CONTAINER -->
        <div class="leftContainer">
            <div class="top">
                <div class="image">
                    <img src="images/profileImage.png" alt="avatar" style="width:130px; height:130px;">
                    <p>0 i betyg (0.0 medel)</p>
                    <p>0 recensioner</p>
                </div>
                <div class="info">
                    <h3>Gustav Hultgren</h3>
                    <hr size="1" width=" 100%">
                    <p1 class="location">Plats</p>
                        <p1 class="activity">Gick med</p>
                </div>
            </div>
            <div class="bookshelf">
                <h5>GUSTAVS BOKHYLLA</h5>
                <hr size="1" width=" 100%">
                <a href="profile.php">Läst</a>
                <a href="profile.php">Läser</a>
                <a href="profile.php">Vill läsa</a>
            </div>
            <div class="quotes">
                <h5>GUSTAVS CITAT</h5>
                <hr size="1" width=" 100%">
                <p>Gustav har tyvärr inte lagt till några citat.</p>
            </div>
        </div>
        
        <!-- RIGHT CONTAINER -->
        <div class="rightContainer">
            <div class="favouriteAthour">
                <h5>Gustavs favoritförfattare</h5>
                <hr size="1" width=" 100%">
                <p>Camilla Läckberg</p>
            </div>

        </div>

        <script src="js/index.js"></script>

</main>

<?php
require  "footer.php"
?>