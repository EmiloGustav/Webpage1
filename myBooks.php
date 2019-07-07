<?php
require "header.php";
include "includes/getDb.inc.php";
if (isset($_SESSION['userId'])) {
    $userInfo = getUserInfo($_SESSION['userId']);
}

?>
<main class="container"><!--uses the full size of the browser and hides the overflow if any -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .workspace2 {
            max-width: 1280px;
            margin: 0 auto;
            display:grid;
            grid-template-columns: 30% 70%;
            grid-gap: 1em;
        }
        .workspace2>div {
            background: #eee;
            padding: 1em;
        }
        .workspace2 .leftColumn {

        }
        .workspace2 .rightColumn {

        }
    </style>
    <?php
        if(!isset($_SESSION['userId'])){
            echo '<div class="workspace2"><h3>Var snäll och loggain för att se dina sidor</h3><br><a href="signup.php">Eller skapa ett konto här!</a></div>';
        }else {
            echo ' 
        <div class="workspace2"><!-- sets max size to 1280px and centers it.-->
        <!-- Three columns to work within left to right, from top to bottom in code -->

        <div class="leftColumn">
            
        </div>

        <div class="rightColumn">

        </div>

    </div>';
        }
    ?>

</main>

<?php
require "footer.php";
?>
