<?php
require "header.php";
?>

    <main class="container"><!--uses the full size of the browser and hides the overflow if any -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <div class="workspace"><!-- sets max size to 1280px and centers it.-->
            <!-- Three columns to work within left to right, from top to bottom in code -->
            <div class="col">
                <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="Books" width="426" height="250">
            </div>

            <div class="col">
                <h2>
                    Skapa ditt konto genom att fylla i nedastående.
                </h2>

                <?php
                    if(isset($_GET['error'])) {
                        if($_GET['error'] == 'emptyfields') {
                            echo '<div class="error">Alla fälten var inte ifyllda!</div>';
                        }else if($_GET['error'] == 'invalidemailusername'){
                            echo '<div class="error">Både e-post och användernamn var otillåtna eller redan tagna!</div>';
                        }else if ($_GET['error'] == 'invalidemail') {
                            echo '<div class="error">Din e-post var otillåtet eller redan tagen!</div>';
                        }else if ($_GET['error'] == 'invalidusername') {
                            echo '<div class="error">Ditt användarnamn var otillåtet eller redan tagen!</div>';
                        }else if ($_GET['error'] == 'pwdcheck') {
                            echo '<div class="error">Lösenorden överensstämmer inte!</div>';
                        }else if ($_GET['error'] == 'usertaken') {
                            echo '<div class="error">Användernamnet eller e-posten används redan!</div>';
                        }
                    }
                ?>

                <form action="includes/signup.inc.php" method="post">
                    <!-- Kanske göra som en lista och ha divs i varje li så att dem alltid blir på exakt samma höjd-->
                    <ul id="register">
                        <li id="space">
                            <div id="floatleft">Förnamn: </div>
                            <div id="floatright"><input type="text" placeholder="Förnamn" name="fornamn"></div>
                        </li>
                        <li id="space">
                            <div id="floatleft">Efternamn: </div>
                            <div id="floatright"><input type="text" placeholder="Efternamn" name="efternamn"></div>
                        </li>
                        <li id="space">
                            <div id="floatleft">Användarnamn: </div>
                            <?php
                                if(isset($_GET['username'])){
                                    echo '<div id="floatright"><input type="text" placeholder="Användarnamn" name="username" id="username" value="'.$_GET['username'].'"></div>';
                                }else {
                                    echo '<div id="floatright"><input type="text" placeholder="Användarnamn" name="username" id="username"></div>';
                                }
                            ?>
                        </li>
                        <li id=space>
                            <div id="floatleft">Epost: </div>
                            <?php
                            if(isset($_GET['email'])){
                                echo '<div id="floatright"><input type="text" placeholder="E-post adress" name="email" id="user_email" value="'.$_GET['email'].'"></div>';
                            }else {
                                echo '<div id="floatright"><input type="text" placeholder="E-post adress" name="email" id="user_email"></div>';
                            }
                            ?>
                        </li>
                        <li id="space">
                            <div id="floatleft">Lösenord: </div>
                            <div id="floatright"><input type="password" placeholder="Lösenord" name="password" id="user_password_signup"></div>
                        </li>
                        <li id="space">
                            <div id="floatleft">Återuppreppa Lösenord: </div>
                            <div id="floatright"><input type="password" placeholder="Lösenord" name="re-password" id="user_repassword_signup"></div>
                        </li>
                        <li id="space">
                            <div id="floatleft">Land: </div>
                            <div id="floatright"><?php readfile('html/countryDropdown.html'); ?></div>
                        </li>
                        <li><p>Genom att klicka Registrera, så accepterar du BonoLibros användarvillkor.</p></li>
                        <li id="space"><button type="submit" name="signup-submit">Registrera</button></li>
                    </ul>
                </form>
            </div>

            <div class="col">

            </div>

        </div>
    </main>

<?php
require "footer.php";
?>