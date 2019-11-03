<?php
require "getDb.inc.php";
session_start();
if (isset($_GET['type']) && isset($_SESSION['userId'])) {
    $userinfo = getUserInfo($_SESSION['userId']);
    if(isset($_POST['personalList']) && strcasecmp($_GET['type'],'userCreatedList') == 0) {
        $lists = getLists($_SESSION['userId']);
        $listStringName = $lists['1'];
        $listStringItems = $lists['2'];
        if(!contains(';:',$listStringName)) {
            if(!contains('::',$listStringItems)) {
                if(strcasecmp($_GET['bookId'],$listStringItems) == 0) {
                    // TODO error book already in list
                }else {
                    addbookToList($listStringName,$_GET['bookId'],$_SESSION['userId']);
                }
            }else {
                $listArrayItems = explode('::',$listStringItems);
                if(array_search($_GET['bookId'],$listArrayItems) == false) {
                    addbookToList($listStringName,$_GET['bookId'],$_SESSION['userId']);
                }else {
                    // TODO error book already in list
                }
            }
        }else {
            $listArrayName = explode(';:',$listStringName);
            $listNameKey = array_search($_POST['personalList'],$listArrayName);
            if($listNameKey !== false) {
                $listStringItems = explode(';:',$listStringItems)[$listNameKey];
                if(!contains('::',$listStringItems)) {
                    if(strcasecmp($_GET['bookId'],$listStringItems) == 0) {
                        // TODO error book already in list
                    }else {
                        addbookToList($listArrayName[$listNameKey],$_GET['bookId'],$_SESSION['userId']);
                    }
                }else {
                    $listArrayItems = explode('::',$listStringItems);
                    if(array_search($_GET['bookId'],$listArrayItems) == false) {
                        addbookToList($listArrayName[$listNameKey],$_GET['bookId'],$_SESSION['userId']);
                    }else {
                        // TODO error book already in list
                    }
                }
            }else {
                // TODO listname not in list (shouldnt be able to reach here)
            }
        }
    }
    else if (strcasecmp($_GET['type'],'addList') == 0 ) {
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
}else{
    // TODO lägga till en header så att man kommer tillbaka om man kommit hit otillåtet eller om man inte är ionloggad
    //
}
