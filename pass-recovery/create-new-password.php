<?php
require "../header.php";
?>
<main class="container">

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/index.js"></script>

    <div class="workspace">
        <div class="col">
            <!-- Kontrollera tokens -->
            <?php
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            /* Kontrollera om tokens faktiskt finns i URL */
            if (empty($selector) || empty($validator)) {
                echo "Kunde inte validera din förfrågan!";
            } else {
                /* Kontrollera om de hexadecimala tokens fakitskt är hexadecimala tokens */
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>

                    <form action="reset-password.inc.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector ?>;">
                        <input type="hidden" name="validator" value="<?php echo $validator ?>;">
                        <input type="password" name="pwd" placeholder="Ange ett nytt lösenord...">
                        <input type="password" name="pwd-repeat" placeholder="Upprepa nytt lösenord...">
                        <button type="submit" name="reset-password-submit">Återställ lösenord</button>
                    </form>

                <?php
            }
        }
        ?>

        </div>
    </div>

</main>

<?php
require "../footer.php"
?>