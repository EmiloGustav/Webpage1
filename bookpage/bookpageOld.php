<?php
if(isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
}else {
    // TODO Send the user back
}

require "../header.php";
include "../includes/getDb.php";
include "php/bookpageHelper.php";
$getDb = new getDb();
$help = new helper();
$bookpageHelper = new bookpageHelper();
$array = $getDb->getBookByBookId($bookId);
if(isset($_SESSION['userId'])) {
    $userinfo = $getDb->getUserInfo($_SESSION['userId']);
}else {
    $userinfo = NULL;
}

?>
    <link rel="stylesheet" type="text/css" href="bookpage.css">
    <main class="container">
        <div class="container-grid">
            <div class="item1">
                <?php echo '<img src="'.$array['9'].'" alt="Books" width="250px" height="400px">'; ?>
                <ul>
                    <li>
                        <?php
                        if($userinfo == NULL){
                            //TODO error
                        }else {
                            if($userinfo['1'] == NULL) {
                                echo '  <form action="../includes/bookHandler.inc.php?type=tbr&bookId='.$bookId.'" method="post">
                                            <input class="inputs" type="submit" value="Lägg till i \'vill läsa\' listan!">
                                        </form>';
                            }else {
                                $tmpArray = explode(';:',$userinfo['1']);
                                $tbr = false;
                                foreach ($tmpArray as $x) {
                                    if(strcasecmp($x,$bookId) == 0) {
                                        // TODO lägg till i addBook
                                        echo '  <form action="../includes/bookHandler.inc.php?type=tbrRemove&bookId='.$bookId.'" method="post">
                                        <input class="inputs" type="submit" value="Ta bort från \'vill läsa\' listan!">
                                        </form>';
                                        $tbr = true;
                                        break;
                                    }
                                }
                                if($tbr == false) {
                                    echo '  <form action="../includes/bookHandler.inc.php?type=tbr&bookId='.$bookId.'" method="post">
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
                                echo '      <form action="../includes/bookHandler.inc.php?type=hr&bookId='.$bookId.'" method="post">
                                            <input class="inputs" type="submit" value="Lägg till i \'har läst\' listan!">
                                            </form>';
                            }else {
                                $tmpArray = explode(';:',$userinfo['2']);
                                $read = false;
                                foreach ($tmpArray as $x) {
                                    if(strcasecmp($x,$bookId) == 0) {
                                        // TODO lägg till i addBook
                                        echo '      <form action="../includes/bookHandler.inc.php?type=hrRemove&bookId='.$bookId.'" method="post">
                                                    <input class="inputs" type="submit" value="Ta bort från \'har läst\' listan!">
                                                    </form>';
                                        $read = true;
                                        break;
                                    }
                                }
                                if($read == false) {
                                    echo '  <form action="../includes/bookHandler.inc.php?type=hr&bookId='.$bookId.'" method="post">
                                            <input class="inputs" type="submit" value="Lägg till i \'vill läsa\' listan!">
                                            </form>';
                                }
                            }
                        }

                        ?>
                    </li>
                        <?php
                        if($userinfo[11] != NULL) {
                            echo '<li><form action="../includes/listsHandler.inc.php?type=userCreatedList&bookId='.$bookId.'" method="post"><select name="personalList" id="personalList">';
                            $listName = $getDb->getLists($_SESSION['userId'])['1'];
                            if(!$help->contains(';:',$listName)) {
                                echo '<option value="'.$listName.'">'.$listName.'</option>';
                            }else {
                                $listNameArray = explode(';:',$listName);
                                foreach ($listNameArray as $i) {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            }
                            echo '</select><input type="submit" value="Lägg till i listan"></form></li>';
                        }
                        ?>
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
                        <form action="../includes/bookHandler.inc.php?type=rating&bookId=<?php echo $bookId?>" method="post" class="rate">
                            <?php
                            $bookRated = $bookpageHelper->isBookRated($bookId,$userinfo);
                            if($bookRated == false){
                                echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                            }
                            else {
                                if ($bookRated == 1) {
                                    echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();" checked="checked"><label for="star1" title="Väldigt dålig"></label>';
                                } else if ($bookRated == 2) {
                                    echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();" checked="checked"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                } else if ($bookRated == 3) {
                                    echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();" checked="checked"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                } else if ($bookRated == 4) {
                                    echo '  <input type="radio" id="star5" name="rate" value="5" onclick="this.form.submit();"><label for="star5" title="Perfekt" ></label>
                                        <input type="radio" id="star4" name="rate" value="4" onclick="this.form.submit();" checked="checked"><label for="star4" title="Bra"></label>
                                        <input type="radio" id="star3" name="rate" value="3" onclick="this.form.submit();"><label for="star3" title="Okej"></label>
                                        <input type="radio" id="star2" name="rate" value="2" onclick="this.form.submit();"><label for="star2" title="Inte så bra"></label>
                                        <input type="radio" id="star1" name="rate" value="1" onclick="this.form.submit();"><label for="star1" title="Väldigt dålig"></label>';
                                } else if ($bookRated == 5) {
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
                    <?php

                    // TODO lägga till så att ;: och :: är illegala tecken när man skriven en kommentar
                    // TODO kanske ändra så att man inte får all info i getuserinfo
                    if($array['12'] == NULL) {
                        echo '<div class="comment">Var den första att skriva en kommentar för denna bok</div>';
                    }else if (!$getDb->sqlErrorHandler->help->contains(';:',$array['12'])) {
                        $comment = explode('::',$array['12']);
                        $commentUserinfo = $getDb->getUserInfo($comment['0']);
                        echo '<div class="comment"><div class="name">'.$commentUserinfo['8'].' '.$commentUserinfo['9'].'</div>';
                        if(isset($_SESSION['userId']) && $_SESSION['userId'] == $comment['0']) {
                            echo '<div class="edit-remove"><a href="php/commentHandler.php?type=removeComment&bookId='.$bookId.'&comment='.$array['12'].'">radera</a></div>';
                        }
                        echo '<br><div class="comment-text">'.$comment['1'].'</div></div>';
                    }else {
                        $comments = explode(';:',$array['12']);
                        foreach ($comments as $x) {
                            $comment = explode('::',$x);
                            $commentUserinfo = getUserInfo($comment['0']);
                            echo '<div class="comment"><div class="name">'.$commentUserinfo['8'].' '.$commentUserinfo['9'].'</div>';
                            if($_SESSION['userId'] == $comment['0']) {
                                echo '<div class="edit-remove"><a href="php/commentHandler.php?type=removeComment&bookId='.$bookId.'&comment='.$x.'">radera</a></div>';
                            }
                            echo '<br><div class="comment-text">'.$comment['1'].'</div></div>';
                        }
                    }
                    if(isset($_SESSION['userId'])) {
                        // TODO ta hand om tom textarea här
                        // TODO lägga till så att man kan edita och ta bor kommentarer
                        echo '<form action="php/commentHandler.php?type=comment&bookId='.$bookId.'" method="post">
                            Kommentera:<br>
                            <textarea class="text" name="comment"></textarea>
                            <button type="submit" class="button1">Publicera</button>
                        </form>';
                    }else {
                        // TODO länka till inlogning och skapa konto
                        echo 'Logga in eller skapa ett konto för att skriva en kommentar';
                    }


                    ?>

                </div>
            </div>

            <div class="item3">

            </div>
        </div>
    </main>
    <script type="text/javascript" src="javascript/bookpage.js"></script>
<?php
require "../footer.php";
?>
<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-22
 * Time: 13:31
 */