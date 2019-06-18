<?php
require "header.php";
?>
<main class="container">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/index.js"></script>

    <div class="workspace">
        <div class="col">
            <h1>Återställ ditt lösenord</h1>
            <p>Ett e-mail med instruktioner om hur du återställer ditt lösenord kommer att skickas till dig.</p>
            <form action="includes/reset-request.inc.php" method="post">
                <input type="text" name="email" placeholder="Ange din e-mailadress...">
                <button type="submit" name="reset-request-submit">Återställ lösenord</button>
            </form>
            <?php
                if (isset($_GET["reset"])) {
                    if ($_GET["reset"] == "success") {
                        echo '<p class="signupsucess">Kolla din e-mail!</p>';
                    }
                }
            ?>
        </div>
    </div>

</main>

<?php
require "footer.php"
?>