<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BonoLibro</title>

    <link rel="stylesheet" type="text/css" href="signup.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

</head>

<body>
    <div class="application-main">
        <main id="container">
            <div class="header">
                <h1>Skapa ett nytt konto</h1>
            </div>

            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'emptyfields') {
                    echo '<div class="error">Alla fälten var inte ifyllda!</div>';
                } else if ($_GET['error'] == 'invalidemailusername') {
                    echo '<div class="error">Både e-post och användernamn var otillåtna eller redan tagna!</div>';
                } else if ($_GET['error'] == 'invalidemail') {
                    echo '<div class="error">Din e-post var otillåtet eller redan tagen!</div>';
                } else if ($_GET['error'] == 'invalidusername') {
                    echo '<div class="error">Ditt användarnamn var otillåtet eller redan tagen!</div>';
                } else if ($_GET['error'] == 'pwdcheck') {
                    echo '<div class="error">Lösenorden överensstämmer inte!</div>';
                } else if ($_GET['error'] == 'usertaken') {
                    echo '<div class="error">Användernamnet eller e-posten används redan!</div>';
                }
            }
            ?>

            <div class="signup-form">
                <form action="signup.inc.php" method="post">
                    <label for="username">Användarnamn</label>
                    <?php
                    if (isset($_GET['username'])) {
                        echo '<input type="text" class="input-block" name="username" value="' . $_GET['username'] . '">';
                    } else {
                        echo '<input type="text" class="input-block" name="username">';
                    }
                    ?>

                    <label for="password">Lösenord</label>
                    <input type="password" class="input-block" name="password">
                    <p>Säkerställ att lösenordet är minst 15 tecken långt ELLER 8 tecken långt som inkluderar en siffra och en stor
                        bokstav</p>

                    <label for="email">E-postadress</label>
                    <?php
                    if (isset($_GET['email'])) {
                        echo '<input type="text" class="input-block" name="email" value="' . $_GET['email'] . '">';
                    } else {
                        echo '<input type="text" class="input-block" name="email">';
                    }
                    ?>
                    <div class="form-checkbox">
                        <label for="checkbox-subscription" id="lbl-checkbox">
                            <input type="checkbox" name="subscription" id="checkbox-subscription">Skicka tillfälliga produktuppdateringar
                            och erbjudanden.
                        </label>
                    </div>

                    <button type="submit" id="btn-signup" name="signup-submit">Registrera</button>

                    <p>Genom att klicka på Registrera godkänner du våra <a href="">användarvillkor</a>. Du kan läsa mer om hur vi samlar in och använder din data i vår <a href="">datapolicy</a> och hur vår <a href="">cookiespolicy</a> ser ut.</p>
                </form>
            </div>
        </main>
    </div>
</body>

</html>