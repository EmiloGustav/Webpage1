<?php
require "header.php";
?>

<main class="container">

    <style>
        .wrapper {
            background-color: white;
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

        .top h4 {
            font-size: 24px;
            width: 50%;  
            margin: 0px;
            float: left;
            padding: 5px 5px;
        }

        .top .image {
            font-size: 13px;
            text-align: center;
        }

        .top .editprofile {
            font-size: 12px;
            float: left;
            margin-top: 13px;
        }

        .top .info .location,
        .activity,
        .about {
            font-size: 15px;
            font-weight: bold;
        }
    </style>

    <?php
    require 'dbh.inc.php';

    //Retrieve common information about the user to later print it out.
    $sql = "SELECT id, firstName, lastName, dateOfBirth, land FROM users";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        
    }
    ?>

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
                    <h4><?php echo $_SESSION["userUid"];?></h4>
                    <a class="editprofile" href="editProfilePage.php">Redigera profil</a>
                    <hr size="1" width=" 100%">
                    <p class="location">Plats</p>
                    <p class="activity">Gick med</p>
                    <p class="about">Om</p>
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
                <a class="edit" href="editprofile.php">Redigera</a>
                <hr size="1" width=" 100%">
                <p>Camilla Läckberg</p>
            </div>

        </div>

        <script src="js/index.js"></script>

</main>

<?php
require  "footer.php"
?>