<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-07-18
 * Time: 18:39
 */
require "getDb.inc.php";
session_start();
if (isset($_GET['type']) && isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
    if (strcasecmp($_GET['type'],'addList') == 0 ) {
        $listName = $_POST['listName'];
        $added = addList($listName,$_SESSION['userId']);
        if($userinfo['11'] == NULL && $added == true) {
            $userinfo['11'] = 1;
        }else if($added == true){
            $userinfo['11'] = $userinfo['11'] + 1;
        }
        changeUserData($userinfo);
    }
    else if(strcasecmp($_GET['type'],'removeList') == 0) {
        $listName = $_GET['listName'];
        removeList($listName,$_SESSION['userId']);
        if($userinfo['11'] == 1) {
            $userinfo['11'] = NULL;
        }else {
            $userinfo['11'] = $userinfo['11'] - 1;
        }
        changeUserData($userinfo);
    }
    else if (strcasecmp($_GET['type'],'addBook') == 0) {

    }
    else if(strcasecmp($_GET['type'],'removeBook') == 0) {

    }
    header("Location: ../myBooksV2.php");
    exit();
}else {
    // TODO lägga till en header så att man kommer tillbaka om man kommit hit otillåtet eller om man inte är ionloggad
    //
    header("Location: ../myBooksV2.php?msg=error");
    exit();
}
