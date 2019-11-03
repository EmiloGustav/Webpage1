<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" href="login.css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div class="application-main">
        <main id="container">
            <div class="header">
                <img id="logotype" src="../images/books.png" alt="">
                <h1>Logga in på BonoLibro</h1>
            </div>
            <div class="login-form">
                <form action="login.inc.php" method="post">
                    <label for="username">Användarnamn</label>
                    <input class="input-block" type="text" name="username">
                    <label for="password">Lösenord</label>
                    <input class="input-block" type="password" name="password">
                    <a class="reset-password-link" href="..//pass-recovery/reset-password.php">Glömt lösenordet?</a>
                    <button type="submit" name="login-submit" id="login-button"><span>Logga in</span></button>
                    <p class="cna-callout">Ny på BonoLibro? <a href="../signup/signup.php">Skapa ett nytt konto.</a></p>
                </form>
                <ul>
                    <li><a href="siteterms.php">Villkor</a></li>
                    <li><a href="siteterms.php">Integritet</a></li>
                    <li><a href="siteterms.php">Säkerhet</a></li>
                    <li><a href="siteterms.php">Kontakt</a></li>
                </ul>
            </div>
        </main>
    </div>

</body>

</html>