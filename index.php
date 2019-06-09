<?php
require "header.php";
?>
<main class="container">
    <link rel="stylesheet" type="text/css" href="style.css">

    <div class="col">
        <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width="500" height="300">
    </div>

    <div class="col">
        <h2 class="newUserMessage">
            Ny här? Skapa ett konto gratis!
        </h2>
        <!-- Ändra PATH -->
        <form action="/action_page.php">
            <input type="text" placeholder="Namn" name="user[first_name]" id="user_first_name">
            <input type="email" placeholder="Email Adress" name="user[email]" id="user_email">
            <input type="password" placeholder="Lösenord" name="user[password]" id="user_password_signup">
            <button type="submit_sign_up">Registrera</button>
        </form>
    </div>

    <div class="col">
        <h2>Hej</h2>
    </div>

</main>
<?php
require "footer.php"
?>