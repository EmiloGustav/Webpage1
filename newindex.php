<!DOCTYPE html>
<html>
<html lang="en">

<head>
    <title>BonoLibro</title>
    <meta name="author" content="Gustav och Emil">

    <link rel="stylesheet" type="text/css" href="css/styleNewIndex.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body>
    <div class="content">
        <?php
        if (!isset($_SESSION['userId'])) {
            ?>
            <header>
                <div class="header_container">
                    <a href="newindex.php" class="header-logo">BONOLIBRO</a>
                    <div class="menu_login_container">
                        <?php
                            if (!isset($_SESSION['userId'])) {
                                echo '  
                                    <form action="includes/login.inc.php" method="post">    
                                        <table>
                                            <tr>
                                                <td>
                                                     <label for="username">Användarnamn</label>
                                                </td>
                                                <td>
                                                    <label for="password">Lösenord</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Användarnamn..." name="username" id="right" style="width:130px;">
                                                </td>
                                                <td>
                                                    <input type="password" placeholder="Lösenord..." name="password" id="right" style="width:130px;">
                                                </td>
                                                <td>
                                                    <button type="submit" name="login-submit" class="login-button"><span>Logga in</span></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <a href="reset-password.php" id="forgot-password-link">Glömt lösenordet?</a>
                                                </td>
                                            </tr>
                                            </table>
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
                    </div>
                </div>
            </header>

            <section id="banner">
                <h1>Din nya favoritbok väntar på dig.</h1>
                <p>Samlar dina böcker som du har läst, ska läsa eller vill läsa.</p>
                <a href="signup.php" id="banner-registerlink">Starta ett konto</a>
                <br>
                <br>
                <a href="#section1">LÄS MER</a>
            </section>

            <section id="section1">
                <div class="nested">
                    <img src="images/books-and-beach.jpg" height="343px" width="530px">
                    <div class="description">
                        <hr>
                        <h1 class="box1-title">Kom igång</h1>
                        <p>Genom att starta ett konto får du möjligheten att börja samla dina böcker som du har läst, ska läsa eller vill läsa på en och samma plats.</p>
                        <a href="signup.php" id="s1-registerlink">Starta ett konto</a>
                    </div>
                    <a href="#section2" id="down-arrow">
                        <img id="down-arrow" src="images/down-arrow.png" width="60" height="60">
                    </a>
                </div>
            </section>

            <footer id="footer">

            </footer>

        <?php
        } else {

            ?>
        <?php }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="js/index.js"></script>

</body>

</html>