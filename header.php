<?php
$color = "red";
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="This will often show up in search results">
    <meta name="viewport" content="width=device-width, initial scale=1">

    <link rel="stylesheet" type="text/css" href="css/header.css">

    <link rel="stylesheet" type="text/css" href="css/styleNewIndex.css">

    <!--<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">-->

    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash&display=swap" rel="stylesheet">

    <title>BonoLibro</title>
</head>

<body>
    <div class="header">
        <!-- Header for NOT logged in users. -->
        <?php
        if (!isset($_SESSION['userId'])) {
            ?>
            <div class="inner-header">
                <div class="logo-container">
                    <h1><a href="newindex.php">BonoLibro</a></h1>

                </div>

                <div class="login-container">
                    <form action="includes/login.inc.php" method="post">
                        <input type="text" placeholder="Användarnamn..." name="username" autocomplete="off">
                        <input type="password" placeholder="Lösenord..." name="password">
                        <button type="submit" name="login-submit" class="login-button"><span>Logga in</span></button>
                    </form>
                </div>
            </div>

            <!-- Header for logged in users. -->
        <?php
        } else { ?>
            <div class="inner-header">
                <div class="logo-container">
                    <h1><a href="index.php">BonoLibro</a></h1>
                </div>

                <ul class="navigation">
                    <li>
                        <form action="includes/logout.inc.php" method="post">
                            <button type="submit" name="logout-submit" id="right"><span>Logga ut</span></button>
                        </form>
                        <a href="myProfile.php" id="profile">'s profil </a>
                    </li>
                </ul>
            </div>
        <?php
        }
        ?>

    </div>