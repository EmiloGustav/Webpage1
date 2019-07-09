<?php
if(isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
}else {
    // TODO Send the user back
}

require "header.php";
include "includes/getDb.inc.php";

$array = getBookByBookId($bookId);
if(isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
}else {
    $userinfo = NULL;
}

?>
    <script type="text/javascript">
        function switchRating() {

            var rating = document.getElementById("rating");
            var button = document.getElementById("ratingButton");
            button.innerText=rating.style.display;
            if(rating.style.display == "none" ||rating.style.display == ""||rating.style.display == null ){
                rating.style.display = "block";
                button.innerText = "Dölj betyg";
            }else if(rating.style.display == "block") {
                rating.style.display ="none";
                button.innerText = "Visa betyg";
            }
        }
    </script>
    <style>
        .container-grid{
            max-width: 900px;
            display: grid;
            grid-template-columns: 30% 60% 10%;
            grid-gap: 3px;
            padding: 3px;
            overflow: hidden;
            margin: auto;
            text-align: center;
        }
        .item1 {
            grid-column-start: 1;
            grid-column-end: 2;
        }
        .item2{
            grid-column-start: 2;
            grid-column-end: 3;
        }
        .item3{
            grid-column-start: 3;
            grid-column-end: 4;
        }
        .inputs{
            border: none;
            background:cadetblue;
            font-size: large;
            padding:12px 6px;
            min-width: 90%;
        }
        .inputs:hover {
            background:lightcoral;
        }
    </style>
    <main class="container">
        <link rel="stylesheet" type="text/css" href="css/bookpage.css">
        <div class="container-grid">

            <div class="item1">

                <!-- Hur ska vi göra med bilder här för att få generiskt, typ images/$creator/$title.jpg ?-->

                <?php echo '<img src="'.$array['9'].'" alt="Books" width="250px" height="400px">'; ?>

                <ul>
                    <li>
                        <?php
                        if($userinfo == NULL){
                            //TODO error
                        }else {
                            if($userinfo['1'] == NULL) {
                                echo '  <form action="includes/addBook.inc.php?type=tbr&bookId='.$bookId.'" method="post">
                                        <input class="inputs" type="submit" value="Lägg till i \'vill läsa\' listan!">
                                        </form>';
                            }else {
                                $tmpArray = explode(';:',$userinfo['1']);
                                $tbr = false;
                                foreach ($tmpArray as $x) {
                                    if(strcasecmp($x,$bookId) == 0) {
                                        // TODO lägg till i addBook
                                        echo '  <form action="includes/addBook.inc.php?type=tbrRemove&bookId='.$bookId.'" method="post">
                                        <input class="inputs" type="submit" value="Ta bort från \'vill läsa\' listan!">
                                        </form>';
                                        $tbr = true;
                                        break;
                                    }
                                }
                                if($tbr == false) {
                                    echo '  <form action="includes/addBook.inc.php?type=tbr&bookId='.$bookId.'" method="post">
                                            <input class="inputs" type="submit" value="Lägg till i \'vill läsa\' listan!">
                                            </form>';
                                }
                            }
                        }

                        ?>

                    </li>
                    <li>
                        <?php
                        if($userinfo == NULL){
                            //TODO error
                        }else {
                            if($userinfo['2'] == NULL) {
                                echo '      <form action="includes/addBook.inc.php?type=hr&bookId='.$bookId.'" method="post">
                                            <input class="inputs" type="submit" value="Lägg till i \'har läst\' listan!">
                                            </form>';
                            }else {
                                $tmpArray = explode(';:',$userinfo['2']);
                                $read = false;
                                foreach ($tmpArray as $x) {
                                    if(strcasecmp($x,$bookId) == 0) {
                                        // TODO lägg till i addBook
                                        echo '      <form action="includes/addBook.inc.php?type=hrRemove&bookId='.$bookId.'" method="post">
                                                    <input class="inputs" type="submit" value="Ta bort från \'har läst\' listan!">
                                                    </form>';
                                        $read = true;
                                        break;
                                    }
                                }
                                if($read == false) {
                                    echo '  <form action="includes/addBook.inc.php?type=hr&bookId='.$bookId.'" method="post">
                                            <input class="inputs" type="submit" value="Lägg till i \'vill läsa\' listan!">
                                            </form>';
                                }
                            }
                        }

                        ?>

                    </li>
                </ul>
            </div>

            <div class="item2">

                <h3><?php echo $array['1'];?></h3>
                <h4><?php echo $array['2']?></h4>

                <!-- vi måste hitta summeringen någonstans så att vi kan lägga in den -->

                <div class="summarise">
                    <?php echo $array['5']; ?>
                </div>

                <!-- lägga till databs så att ratingen tas från den och läggs in där när någon klickar på stjärnorna -->
                <ul>
                    <li>
                        <div id="ratingBox" >
                            <button type="button" onclick="switchRating()" id="ratingButton">Visa betyg</button>
                            <p id="rating">
                                <?php
                                if ($array['11'] == NULL) {
                                    echo 'Inga betyg för denna bok än';
                                }else {
                                    echo $array['11'];
                                }
                                ?>
                            </p>
                        </div>
                    </li>
                    <li>
                        <form action="includes/addBook.inc.php?type=rating&bookId=<?php strval($bookId)?>" method="post" class="rate">
                            <?php
                            // TODO lägga till metod för att ta bort rating
                            function isBookRated($bookId,$userinfo){
                                if(isset($userinfo['4'])) {
                                    $ratedBooksId = explode(";:" , $userinfo['4']);
                                    for($x = 0; $x < sizeof($ratedBooksId); $x++){
                                        if(strcasecmp($bookId,$ratedBooksId[strval($x)]) == 0) {
                                            return $x;
                                        }
                                    }
                                    return false;
                                }
                            }
                            $bookRated = isBookRated($bookId,$userinfo);
                            if($bookRated == false){
                                echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                            }else {
                                $tmp = explode(';:',$userinfo['5']);
                                $rating = $tmp[strval($x)];
                                switch ($rating){
                                    case 1:
                                        echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();" checked="checked"><label for="star1" title="Väldigt dålig"></label>';
                                    case 2:
                                        echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();" checked="checked"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                    case 3:
                                        echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();" checked="checked"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                    case 4:
                                        echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();" checked="checked"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                    case 5:
                                        echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();" checked="checked"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                }
                            }
                            ?>

                        </form>
                    </li>
                </ul>
                <!-- ladda kommentarer från en databas som hör ihop med boken -->

                <div class="commentfield">
                    Kommentarer:
                    <div class="comment">
                        Camilla läckberg, <br>
                        Fyfan vad bra!
                    </div>
                    <div class="comment">
                        Per, 54. <br>
                        Denna var sjuk, läs den /Per
                    </div>
                </div>
            </div>

            <div class="item3">

            </div>
        </div>
    </main>

<?php
require "footer.php";
?>
<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-22
 * Time: 13:31
 */