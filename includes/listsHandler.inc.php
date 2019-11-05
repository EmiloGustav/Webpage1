<?php
include "getDb.php";
$getDb = new getDb();
$help = new helper();
session_start();
if (isset($_GET['type']) && isset($_SESSION['userId'])) {
    $userinfo = $getDb->getUserInfo($_SESSION['userId']);
    if(isset($_POST['personalList']) && strcasecmp($_GET['type'],'userCreatedList') == 0) {
        $lists = $getDb->getLists($_SESSION['userId']);
        $listStringName = $lists['1'];
        $listStringItems = $lists['2'];
        if(!$help->contains(';:',$listStringName)) {
            if(!$help->contains('::',$listStringItems)) {
                if(strcasecmp($_GET['bookId'],$listStringItems) == 0) {
                    // TODO error book already in list
                }else {
                    $getDb->addbookToList($listStringName,$_GET['bookId'],$_SESSION['userId']);
                }
            }else {
                $listArrayItems = explode('::',$listStringItems);
                if(array_search($_GET['bookId'],$listArrayItems) == false) {
                    $getDb->addbookToList($listStringName,$_GET['bookId'],$_SESSION['userId']);
                }else {
                    // TODO error book already in list
                }
            }
        }else {
            $listArrayName = explode(';:',$listStringName);
            $listNameKey = array_search($_POST['personalList'],$listArrayName);
            if($listNameKey !== false) {
                $listStringItems = explode(';:',$listStringItems)[$listNameKey];
                if(!$help->contains('::',$listStringItems)) {
                    if(strcasecmp($_GET['bookId'],$listStringItems) == 0) {
                        // TODO error book already in list
                    }else {
                        $getDb->addbookToList($listArrayName[$listNameKey],$_GET['bookId'],$_SESSION['userId']);
                    }
                }else {
                    $listArrayItems = explode('::',$listStringItems);
                    if(array_search($_GET['bookId'],$listArrayItems) == false) {
                        $getDb->addbookToList($listArrayName[$listNameKey],$_GET['bookId'],$_SESSION['userId']);
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
        $added = $getDb->addList($listName,$_SESSION['userId']);
        if($userinfo['11'] == NULL && $added == true) {
            $userinfo['11'] = 1;
        }else if($added == true){
            $userinfo['11'] = $userinfo['11'] + 1;
        }
        $getDb->changeUserData($userinfo);
    }
    else if(strcasecmp($_GET['type'],'removeList') == 0) {
        $listName = $_GET['listName'];
        $getDb->removeList($listName,$_SESSION['userId']);
        if($userinfo['11'] == 1) {
            $userinfo['11'] = NULL;
        }else {
            $userinfo['11'] = $userinfo['11'] - 1;
        }
        $getDb->changeUserData($userinfo);
    }
    header("Location: ../bookpage/bookpage.php?bookId=".$_GET['bookId']);
    exit();
}else{
    // TODO lägga till en header så att man kommer tillbaka om man kommit hit otillåtet eller om man inte är ionloggad
    //
}
