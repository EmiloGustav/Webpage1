<?php
require "header.php";
?>
    <main class="container">

        <link rel="stylesheet" type="text/css" href="css/style.css">


        <div class="workspace">
            <div class="col">
                <div class="slideshow-container">
                    <h2>Månadens populäraste böcker</h2>

                    <div class="mySlides fade">
                        <div class="numbertext">1 / 4</div>
                        <img src="images/greatgatsby.jpg" width=" 200 px " height=" 300 px ">
                    </div>

                    <div class="mySlides fade">
                        <div class=" numbertext ">2 / 4</div>
                        <img src=" images/tokillamockingbird.jpg " width=" 200 px " height=" 300 px ">
                    </div>

                    <div class="mySlides fade">
                        <div class=" numbertext ">3 / 4</div>
                        <img src=" images/harrypotter.jpg " width=" 200 px " height=" 300 px ">
                    </div>

                    <div class="mySlides fade">
                        <div class=" numbertext ">4 / 4</div>
                        <img src=" images/fahrenheit.jpg " width=" 200 px " height=" 300 px ">
                    </div>

                    <a class=" prev " onclick=" plusSlides (- 1) ">&#10094;</a>
                    <a class=" next " onclick=" plusSlides(1) ">&#10095;</a>
                </div>

                <div style=" text - align: center ">
                    <span class=" dot " onclick=" currentSlide(1) "></span>
                    <span class=" dot " onclick=" currentSlide(2) "></span>
                    <span class=" dot " onclick=" currentSlide(3) "></span>
                    <span class=" dot " onclick=" currentSlide(4) "></span>
                </div>
                <?php
                if (isset($_GET["newpwd"])) {
                    if ($_GET["newpwd"] == "passwordupdated") {
                        echo '<p class="signupsucess">Ditt lösenord har blivit återställt!</p>';
                    }
                }
                ?>
            </div>

            <div class="col">
                <h2>Sökresultat</h2>
                <div class="searchResultBox">
                <?php
                $search = $_GET['book'];
                if(!empty($search)) {
                    // Ändrar mellanrum till +
                    $search = str_replace(" ","+",$search);

                    // stränghantering för att avgöra om författare eller boknamn behövs

                    $url = 'http://libris.kb.se/xsearch?query=f%C3%B6rf:' . $search . '&format=json&start=1&n=200';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $obj = json_decode($result,TRUE );
                    try {
                        $array = array(array('identifier','creator','title','isbn'));
                        //print_r($array);
                        $bookIndex = 1;
                        for ($x = 1; $x < sizeof($obj['xsearch']['list']); $x++){
                            //print_r($obj['xsearch']['list'][strval($x)]);

                            //check if undefiend
                            if(!isset($obj['xsearch']['list'][strval($x)]['identifier'])
                                ||!isset($obj['xsearch']['list'][strval($x)]['creator'])
                                ||!isset($obj['xsearch']['list'][strval($x)]['title'])
                                ||!isset($obj['xsearch']['list'][strval($x)]['isbn'])
                                ||!isset($obj['xsearch']['list'][strval($x)]['language'])
                                ||!isset($obj['xsearch']['list'][strval($x)]['type'])) {
                                //throw new Exception("Odefinerad variabel");
                                continue;
                            }


                            $identifier = $obj['xsearch']['list'][strval($x)]['identifier'];
                            $creatorOld = $obj['xsearch']['list'][strval($x)]['creator'];
                            $title = $obj['xsearch']['list'][strval($x)]['title'];
                            $isbn = $obj['xsearch']['list'][strval($x)]['isbn'];


                            if (contains(', ',$creatorOld)) {
                                $tmpArray = explode(", ",$creatorOld);
                                $creator = strval($tmpArray[1]) . " " . strval($tmpArray[0]);
                            }else if(contains(' ', $creatorOld)){
                                $tmpArray = explode(" ",$creatorOld);
                                $creator = strval($tmpArray[1]) . " " . strval($tmpArray[0]);
                            }else{
                                $creator = $creatorOld;
                            }


                            if (gettype($isbn) == "array") {
                                $tmpIsbn = "";
                                for($y = 0;$y < sizeof($isbn); $y++) {
                                    $tmpIsbn = $tmpIsbn.','.strval($isbn[strval($y)]);
                                }
                                $isbn=$tmpIsbn;
                            }


                            if ($obj['xsearch']['list'][strval($x)]['language'] == "swe"
                                && $obj['xsearch']['list'][strval($x)]['type'] == "book") {
                                $match=FALSE;
                                for($y = 0; $y < sizeof($array);$y++) {
                                    if (strval($title) == strval($array[strval($y)]['2'])){
                                        //echo strval($title).strval($array[strval($y)]['2']);
                                        $match = TRUE;
                                        break ;
                                    }
                                }
                                if(!$match) {
                                    $tmpArray = array($identifier,$creator,$title,$isbn);
                                    array_push($array,$tmpArray);
                                    $bookIndex++;
                                }
                            }
                        }
                        printArray($array);

                    }catch(Exception $e) {
                        echo $e -> getMessage();
                    }


                   // print_r($obj['xsearch']['list']);
                }
                // returns true if $needle is a substring of $haystack
                function contains($needle, $haystack)
                {
                    return strpos($haystack, $needle) !== false;
                }
                function printArray($array) {
                    for ($x = 1; $x < sizeof($array);$x++) {
                        $hrefurl = 'bookpage.php?creator='.strval($array[strval($x)]['1']).'&title='.strval($array[strval($x)]['2']).'&identifier='.strval($array[strval($x)]['0']).'&isbn='.$array[strval($x)]['3'];
                        echo '
                        <a href="'.$hrefurl.'" class="searchResult">
                        ',$array[strval($x)]['1'],', ',$array[strval($x)]['2'],'
                        </a>
                        ';
                    }

                }

                ?>
                </div>
            </div>

            <div class="col">
                <?php
                if (!isset($_SESSION['userId'])) {
                    echo '
                <h2 class="newUserMessage">
                    Ny här? <a href="signup.php">Skapa ett konto gratis!</a>
                </h2>

                ';
                } else {
                    echo ' <h2 class= "newUserMessag e">
                Välkommen!
                </h2>
                ';
                }
                ?>

            </div>
        </div>
        <script src="js/index.js"></script>
    </main>


<?php
require  "footer.php"
?>