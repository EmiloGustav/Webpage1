<?php
include "getDb.php";
$getDb = new getDb();
session_start();
if (isset($_GET['type']) && isset($_GET['bookId']) && isset($_SESSION['userId'])) {
    $userinfo = $getDb->getUserInfo($_SESSION['userId']);
    if (strcasecmp($_GET['type'],'tbr') == 0 ) {
        // Check if there are any book in wtr
        if($userinfo['1'] == NULL ) {
            $userinfo['1'] = $_GET['bookId'];
        }else {
            $userinfo['1'] = $userinfo['1'].';:'.$_GET['bookId'];
        }
        $getDb->changeUserData($userinfo);
    }
    else if (strcasecmp($_GET['type'],'hr') == 0 ){
        // Check if there are any book in wtr
        if($userinfo['2'] == NULL ) {
            $userinfo['2'] = $_GET['bookId'];
        }else {
            $userinfo['2'] = $userinfo['1'].';:'.$_GET['bookId'];
        }
        $getDb->changeUserData($userinfo);
        // TODO Lägga till så att man frågar användaren om den vill sätta betyg eller ge en kommentar till boken
    }
    else if (strcasecmp($_GET['type'],'rating') == 0 ){
        $bookId = $_GET['bookId'];
        $rating = $_POST['rate'];
        if($userinfo['4'] == NULL ) {
            // Check if the user has NULL ratings
            $tmpArrayBookId = $bookId;
            $tmpArrayRating = $rating;
            $getDb->updateSqlWithRating($rating,$bookId);
        }else if(!$getDb->sqlErrorHandler->help->contains(';:',$userinfo['4'])) {
            // Check if the user has more than one rated book
            if (strcasecmp($bookId, $userinfo['4']) == 0 && $userinfo['5'] == $rating) {
                $getDb->updateSqlWithRating(-1,$bookId,$rating);
                $tmpArrayBookId = null;
                $tmpArrayRating = null;
            }else if(strcasecmp($bookId, $userinfo['4']) == 0){
                $getDb->updateSqlWithRating(-2,$bookId,$userinfo['5'],$rating);
                $tmpArrayBookId = $bookId;
                $tmpArrayRating = $rating;
            }else {
                $getDb->updateSqlWithRating($rating,$bookId);
                $tmpArrayBookId = $userinfo['4'].';:'.$bookId;
                $tmpArrayRating = $userinfo['5'].';:'.$rating;
            }
        }else {
            // See if the rated book is previously rated
            $arrayBookId = explode(';:', $userinfo['4']);
            $arrayRating = explode(';:', $userinfo['5']);
            $bookMatch=false;
            $changeRating=false;
            for ($x = 0; $x < sizeof($arrayBookId); $x++) {
                // If rating and name is the same as the entered info just remove the rating
                if (strcasecmp($bookId, $arrayBookId[strval($x)]) == 0 && $arrayRating[strval($x)] == $rating) {
                    $getDb->updateSqlWithRating(-1,$bookId, $rating);
                    $bookMatch=$x;
                }else if(strcasecmp($bookId, $arrayBookId[strval($x)]) == 0 ){
                    $getDb->updateSqlWithRating(-2,$bookId, $arrayRating[strval($x)],$rating);
                    $bookMatch=$x;
                    $changeRating = true;
                }
            }
            if($bookMatch != false) {
                array_splice($arrayBookId, $bookMatch,1);
                array_splice($arrayRating, $bookMatch,1);
                $tmpArrayBookId = "";
                $tmpArrayRating = "";
                for ($x = 0; $x < sizeof($arrayBookId); $x++) {
                    if($x < sizeof($arrayBookId)-1){
                        $tmpArrayBookId = $tmpArrayBookId.$arrayBookId[strval($x)].';:';
                        $tmpArrayRating = $tmpArrayRating.$arrayRating[strval($x)].';:';
                    }else {
                        $tmpArrayBookId = $tmpArrayBookId.$arrayBookId[strval($x)];
                        $tmpArrayRating = $tmpArrayRating.$arrayRating[strval($x)];
                    }
                }
                if($changeRating == true) {
                    if(strcasecmp($tmpArrayRating,'') == 0) {
                        $tmpArrayBookId = $bookId;
                        $tmpArrayRating = $rating;
                    }else {
                        $tmpArrayBookId = $tmpArrayBookId.';:'.$bookId;
                        $tmpArrayRating = $tmpArrayRating.';:'.$rating;
                    }
                }
                if (strcasecmp('',$tmpArrayRating) == 0) {
                    $tmpArrayRating = null;
                }
                if (strcasecmp('',$tmpArrayBookId) == 0) {
                    $tmpArrayBookId = null;
                }

            }else if ($bookMatch == false) {
                $getDb->updateSqlWithRating($rating,$bookId);
                $tmpArrayBookId = $userinfo['4'].';:'.$bookId;
                $tmpArrayRating = $userinfo['5'].';:'.$rating;
            }
        }
        $userinfo['4'] = $tmpArrayBookId;
        $userinfo['5'] = $tmpArrayRating;
        $getDb->changeUserData($userinfo);
        //getDb->changeUserData($userinfo);
    }
    else if (strcasecmp($_GET['type'],'tbrRemove') == 0 ) {
        // Check if there are any book in wtr
        if($userinfo['1'] == NULL ) {
            // TODO error ska inte kunna vara null
        }else {
            if(!$getDb->sqlErrorHandler->help->contains(';:',$userinfo['1'])) {
                $userinfo['1'] = null;
            }else {
                $tmpArray = explode(';:',$userinfo['1']);
                $index = array_search(strval($_GET['bookId']),$tmpArray);
                if($index === false) {
                    // TODO error
                }else {
                    array_splice($tmpArray, $index, 1);
                    $tmpUserinfo = "";
                    for ($x = 0; $x < sizeof($tmpArray); $x++) {
                        if ($x != sizeof($tmpArray) - 1) {
                            $tmpUserinfo = $tmpUserinfo . $tmpArray[strval($x)] . ';:';
                        } else {
                            $tmpUserinfo = $tmpUserinfo . $tmpArray[strval($x)];
                        }
                    }
                    $userinfo['1'] = $tmpUserinfo;
                }
            }
        }
        $getDb->changeUserData($userinfo);
    }
    else if (strcasecmp($_GET['type'],'hrRemove') == 0 ) {
        // Check if there are any book in wtr
        if($userinfo['2'] == NULL ) {
            // TODO error ska inte kunna vara null
        }else {
            if(!$getDb->sqlErrorHandler->help->contains(';:',$userinfo['2'])) {
                $userinfo['2'] = null;
            }else {
                $tmpArray = explode(';:',$userinfo['2']);
                $index = array_search(strval($_GET['bookId']),$tmpArray);
                if($index === false) {
                    // TODO error
                }else {
                    array_splice($tmpArray, $index, 1);
                    $tmpUserinfo = "";
                    for ($x = 0; $x < sizeof($tmpArray); $x++) {
                        if ($x != sizeof($tmpArray) - 1) {
                            $tmpUserinfo = $tmpUserinfo . $tmpArray[strval($x)] . ';:';
                        } else {
                            $tmpUserinfo = $tmpUserinfo . $tmpArray[strval($x)];
                        }
                    }
                    var_dump($tmpUserinfo);
                    $userinfo['2'] = $tmpUserinfo;
                }
            }
        }
        $getDb->changeUserData($userinfo);
    }
    $bookId = $_GET['bookId'];
    header("Location: ../bookpage/bookpage.php?bookId=".$bookId);
    exit();

}else{
    // TODO lägga till en header så att man kommer tillbaka om man kommit hit otillåtet eller om man inte är ionloggad
    //
}
