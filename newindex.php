<?php
include "includes/getDb.inc.php";
require 'header.php'
?>
<div class="content">
    <?php
    if (!isset($_SESSION['userId'])) {
        ?>

        <div class="global_container">
            <div class="global_container_grid">
                <div class="description_container">
                    <h1>Välkommen</h1>
                    <p>På BonoLibro kan du samla alla dina böcker som du har läst, läser eller vill läsa. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veritatis cumque delectus repellat reiciendis. Dolorum sapiente doloribus harum optio, laborum ducimus voluptatibus aliquam culpa necessitatibus blanditiis doloremque veritatis, quis nobis perspiciatis.</p>
                    
                    <h1 id="createNewAccountH1">Är du ny här?</h1>
                    <p>Fyll i informationen nedan och klicka sedan Skapa konto</p>

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
                    <form action="includes/signup.inc.php" method="post">
                        <table class="table_registration">
                            <tr>
                                <td>
                                    <?php
                                        if (isset($_GET['username'])) {
                                            echo '<div id="floatright"><input type="text" autocomplete="off" placeholder="Användarnamn" name="username" id="username" value="' . $_GET['username'] . '"></div>';
                                        } else {
                                            echo '<div id="floatright"><input type="text" autocomplete="off" placeholder="Användarnamn" name="username" id="username"></div>';
                                        }
                                        ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="email" placeholder="E-postaddress">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="password" placeholder="Lösenord" name="password" id="user_password_signup">
                                </td>
                                <td>
                                    <input type="password" placeholder="Återupprepa lösenord" name="password" id="user_repassword_signup">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="Förnamn" name="firstname">
                                </td>
                                <td>
                                    <input type="text" placeholder="Efternamn" name="lastname">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="submit" name="signup-submit" class="signup-button">Skapa konto</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <p class="linkToTandC">Genom att klicka på Skapa konto godkänner du våra <a href="">användarvillkor</a>. Du kan läsa mer om hur vi samlar in och använder din data i vår <a href="">datapolicy</a> och hur vår <a href="">cookiespolicy</a> ser ut.</p>
                </div>

                <div class="reg_container">
                    <h1>Topplistor</h1>
                    <ul>
                        <li><a href="#">Bästa 2019</a></li>
                        <li><a href="#">Bästa genom tiderna</a></li>
                        <li><a href="#">Bästa i Sverige</a></li>
                    </ul>
                </div>
            </div>
        </div>

    <?php
    } else {

        ?>
    <?php }
    ?>
</div>
<?php
require 'footer.php'
?>