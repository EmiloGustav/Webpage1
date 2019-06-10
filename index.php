<?php
require "header.php";
?>
<main class="container">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <div class="workspace">
        <div class="col">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width="426" height="250">
        </div>

        <div class="col">
            <h2>Hej</h2>
        </div>

        <div class="col">
            <h2 class="newUserMessage">
                Ny här? Skapa ett konto gratis!
            </h2>
            <!-- Ändra PATH -->
            <form action="/action_page.php">
                <!-- Kanske göra som en lista och ha divs i varje li så att dem alltid blir på exakt samma höjd-->
                <ul id="registerLeft">
                    <li id="left">Förnamn: </li>
                    <li id="left">Efternamn: </li>
                    <li id="left">Epost:</li>
                    <li id="left">Lösenord:</li>
                    <li id="left">Återuppreppa Lösenord:</li>

                </ul>
                <ul id="registerRight">
                    <li id="right"><input type="text" placeholder="Förnamn" name="user[first_name]" id="user_first_name"></li>
                    <li id="right"><input type="text" placeholder="Efternamn" name="user[last_name]" id="user_last_name"></li>
                    <li id="right"><input type="email" placeholder="Email Adress" name="user[email]" id="user_email"></li>
                    <li id="right"><input type="password" placeholder="Lösenord" name="user[password]" id="user_password_signup"></li>
                    <li id="right"><input type="password" placeholder="Lösenord" name="user[password]" id="user_repassword_signup"></li>
                    <li id="right"><button type="submit_sign_up">Registrera</button></li>
                </ul>
            </form>
        </div>
    </div>
</main>
<?php
require "footer.php"
?>