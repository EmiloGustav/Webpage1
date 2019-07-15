<!DOCTYPE html>
<html>

<head>
    <title>CoolaBöcker1996</title>

    <link href="https://fonts.googleapis.com/css?family=Catamaran&display=swap" rel="stylesheet">

    <style>
        header {
            background-color: #fff;
            width: 100%;
            height: 45px;
        }

        header .header-logo {
            font-family: 'Catamaran', sans-serif;
            font-size: 24px;
            font-weight: 900px;
            color: #111;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .index-banner {
            width: 100%;
            height: 60vh;
            background-image: url('images/bookshelf.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            display: table;
        }

        .vertical-center {
            display: table-cell;
            vertical-align: middle;
        }

        .index-banner h2 {
            font-family: 'Catamaran', sans-serif;
            font-size: 60px;
            font-weight: 900;
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px #111;
        }

        .index-banner p {
            max-width: 900px;
            margin: auto;
            font-family: 'Catamaran', sans-serif;
            font-size: 28px;
            font-weight: 100;
            line-height: 38px;
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px #111;
        }

        .register-button button {
            display: inline-block;
            padding: 0.46em 1.6em;
            border: 0.1em solid #000000;
            margin: 0 0.2em 0.2em 0;
            border-radius: 0.12em;
            box-sizing: border-box;
            font-family: 'Catamaran', sans-serif;
            font-size: 15px;
            font-weight: 300;
            color: #000000;
            text-shadow: 0 0.04em 0.04em rgba(0, 0, 0, 0.35);
            background-color: #AFA2FF;
            text-align: center;
            transition: all 0.15s;
        }

        .register-button button:hover {
            text-shadow: 0 0 2em rgba(255, 255, 255, 1);
            color: #FFFFFF;
            border-color: #FFFFFF;
        }

        .main-content {
            max-width: 1000px;
            margin: auto;
            margin-top: 10px;
            display: grid;
            grid-template-columns: 60% 40%;
            grid-column-gap: 1em;
            grid-row-gap: 1em;
            align-content: center;
            font-family: 'Catamaran', sans-serif;
        }

        .main-content>div {
            background: #fbeee6;
            padding: 1em;
        }
    </style>
</head>

<body>
    <?php
    if (!isset($_SESSION['userId'])) {
        ?>
        <header>
            <a href="index.html" class="header-logo">BonoLibro</a>

            <form action="includes/login.inc.php" method="post">
                <input type="text" placeholder="Användarnamn..." name="username" id="right">
                <input type="password" placeholder="Lösenord..." name="password" id="right" style="width:106px;">
                <button type="submit" name="login-submit"><span>Logga in</span></button>
            </form>

        </header>

        <section class="index-banner">
            <div class="vertical-center">
                <h2>Utforska världens böcker.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis quia provident itaque accusantium nam possimus fugiat doloribus! Temporibus eligendi dicta, nemo molestiae ratione non provident reprehenderit necessitatibus fuga, dolorum excepturi!</p>
                <form action="signup.php">
                    <div class="register-button" style="text-align:center">
                        <button type="submit">Registrera ett konto</button>
                    </div>
                </form>
            </div>

        </section>
        <section class="main-content">
            <div class="box-1">
                <h2>Semesterns populäraste böcker</h2>
                <p>BonoLibro har sammanställt de populäraste böckerna och författarna enligt er användare.</p>
                <button type="button">Hitta sommarens bok</button>
            </div>
            <div class="box-2">
                <h1>Här är en lista eller slideshow.</h1>
            </div>
            <div class="box-3">
                <h2>Är du författare eller utgivare?</h2>
                <p>Gör reklam för en eller flera böcker för BonoLibros användare.</p>
                <button type="button">Gör reklam</button>
            </div>
            <div class="box-4">
                <h1>Här är reklam.</h1>
            </div>
        </section>
        
        <?php 
        } else {
        echo ' <h2 class="newUserMessage">
            Välkommen!
        </h2>
        ';
        }
        ?>
        <header>
            <a href="index.html" class="header-logo">BonoLibro</a>
        </header>

        <section class="index-banner">
            <div class="vertical-center">
                <h2>Utforska världens böcker.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis quia provident itaque accusantium nam possimus fugiat doloribus! Temporibus eligendi dicta, nemo molestiae ratione non provident reprehenderit necessitatibus fuga, dolorum excepturi!</p>
                <form action="signup.php">
                    <div class="register-button" style="text-align:center">
                        <button type="submit">Registrera ett konto</button>
                    </div>
                </form>
            </div>

        </section>
        <section class="main-content">
            <div class="box-1">
                <h2>Semesterns populäraste böcker</h2>
                <p>BonoLibro har sammanställt de populäraste böckerna och författarna enligt er användare.</p>
                <button type="button">Hitta sommarens bok</button>
            </div>
            <div class="box-2">
                <h1>Här är en lista eller slideshow.</h1>
            </div>
            <div class="box-3">
                <h2>Är du författare eller utgivare?</h2>
                <p>Gör reklam för en eller flera böcker för BonoLibros användare.</p>
                <button type="button">Gör reklam</button>
            </div>
            <div class="box-4">
                <h1>Här är reklam.</h1>
            </div>
        </section>

    </body>

    <?php
    require  "footer.php"
    ?>