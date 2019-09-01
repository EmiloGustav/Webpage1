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

    <link rel="stylesheet" type="text/css" href="css/navigation.css">

    <!--<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">-->

    <title>BonoLibro</title>

    <style>
        header {
            background-color: #fff;
            width: 100%;
            height: 45px;
        }

        header .header-logo {
            float: left;
            margin-left: 300px;
            margin-top: 8px;
            font-family: 'Catamaran', sans-serif;
            font-size: 24px;
            font-weight: 900px;
            color: #111;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
        }

        input[type=text],
        input[type=password],
        .login-button {
            float: right;
            margin-left: 5px;
        }

        .login-button {
            margin-right: 250px;
            margin-top: 14px;   
            background-color: gray;
            border: none;
            border-radius: 3px;
            color: white;
            padding: 3px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: darkslategrey;
        }
    </style>
</head>

<body>
    <header>
        <a href="index.php" class="header-logo">BonoLibro</a>

        <?php
        if (!isset($_SESSION['userId'])) {
            echo '  
                    <form action="includes/login.inc.php" method="post">
                        <button type="submit" name="login-submit" class="login-button"><span>Logga in</span></button>
                        <input type="password" placeholder="Lösenord..." name="password" id="right" style="width:106px;">
                        <input type="text" placeholder="Användarnamn..." name="username" id="right">
                    </form>';
        } else {
            echo '
                <form action="includes/logout.inc.php" method="post">
                <button type="submit" name="logout-submit" id="right"><span>Logga ut</span></button>
                </form>
                <a href="myProfile.php" id="profile">', $_SESSION['userUid'], '\'s profil </a>
                    ';
        }
        ?>
    </header>
    <script type="text/javascript">
        window.onscroll = function() {
            followPage();
        }
        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop();

        function followPage() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>