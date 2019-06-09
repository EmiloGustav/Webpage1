<?php
    $color ="red";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="This will often show up in search results">
    <meta name="viewport" content="width=device-width, initial scale=1">
    <link rel="stylesheet" type="text/css" href="Navigation.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    
    <title>Coolbooks1996</title>
</head>
<body>
<header>
    <h1>Coolbooks1996</h1>
    <nav>
        <ul>
            <li><a href="index.php">Hem</a></li>
            <li><a href="controls.php">Mina böcker</a></li>
            <div class="login-container">
            <!-- Ändra PATH -->    
            <form action="/action_page.php">
                    <input type="text" placeholder="Användarnamn" name="username">
                    <input type="text" placeholder="Lösenord" name="password">
                    <button type="submit_login">Login</button>
                </form>
            </div>
        </ul>
    </nav>

    <div class="promoHeader_container">
        <div id="promoHeader_image">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width = "500" height = "300">
        </div>
        <div id="newAccountBox">
            <h2 class="newUserMessage">
                Ny här? Skapa ett konto gratis!
            </h2>
            <!-- Ändra PATH -->
            <form action="/action_page.php">
                    <input type="text" placeholder="Namn" name="user[first_name]"
                    id="user_first_name">
                    <input type="email" placeholder="Email Adress" name="user[email]" id="user_email">
                    <input type="password" placeholder="Lösenord" name="user[password]" id="user_password_signup">
                    <button type="submit_sign_up">Registrera</button>
                </form>

        </div>
    </div>
</header>