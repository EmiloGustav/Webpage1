<?php
require "getDb.inc.php";
session_start();
echo $_GET['type'].'<br>'.$_GET['bookId'].'<br>'.$_SESSION['userId'];
if (isset($_GET['type']) && isset($_GET['bookId']) && isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
    if(strcasecmp($_GET['type'],'tbr') == 0 ) {
        // Check if there are any book in wtr
        if($userinfo['1'] == NULL ) {
            $userinfo['1'] = $_GET['bookId'];
        }else {
            $userinfo['1'] = $userinfo['1'].';:'.$_GET['bookId'];
        }
        changeUserData($userinfo);
    }else if(strcasecmp($_GET['type'],'hr') == 0 ){
        // Check if there are any book in wtr
        if($userinfo['2'] == NULL ) {
            $userinfo['2'] = $_GET['bookId'];
        }else {
            $userinfo['2'] = $userinfo['1'].';:'.$_GET['bookId'];
        }
        changeUserData($userinfo);
        // TODO Lägga till så att man frågar användaren om den vill sätta betyg eller ge en kommentar till boken
    }else if(strcasecmp($_GET['type'],'rating') == 0 ){
        if($userinfo['4'] == NULL ) {
            $userinfo['4'] = $_GET['bookId'];
            $userinfo['5'] = $_POST['value'];
            addRatingToBook($_POST['value'],$_GET['bookId']);
        }else {
            $userinfo['4'] = $userinfo['4'].';:'.$_GET['bookId'];
            $userinfo['5'] = $userinfo['5'].';:'.$_POST['value'];
            addRatingToBook($_POST['value'],$_GET['bookId']);
        }
        changeUserData($userinfo);
    }
    $bookId = $_GET['bookId'];
    header("Location: ../bookpage.php?bookId=".$bookId);
}else {
    // TODO lägga till en header så att man kommer tillbaka om man kommit hit otillåtet
}