<?php
session_start();
require("getDb.inc.php");
if(isset($_POST['bookItem']) && isset($_GET['listName'])) {
    if(strcasecmp($_GET['listName'], "Vill läsa") == 0) {
        $_GET['listName'] = "tbr";
        $userinfo = getUserInfo($_SESSION['userId']);
        $tbr=$userinfo[1];
        if(sizeof($_POST['bookItem']) == 1) {
            $_POST['bookItem'] = $_POST['bookItem'][0];
            if(!contains(';:',$tbr)) {
                if(strcasecmp($_POST['bookItem'],$tbr) == 0) {
                    $userinfo[1]=null;
                }else {
                    // TODO shouldnt reach
                }
            }else {
                $tbrItems=explode(';:',$tbr);
                $key=array_search($_POST['bookItem'],$tbrItems);
                if($key !== false) {
                    array_splice($tbrItems,$key,1);
                    $userinfo[1]=arrayToString($tbrItems,';:');
                }else {
                    // TODO shouldnt reach
                }
            }
        }else {
            if(!contains(';:',$tbr)){
                // TODO shouldnt reach
            }else {
                $tbrItems=explode(';:',$tbr);
                foreach ($_POST['bookItem'] as $i) {
                    $key=array_search($i,$tbrItems);
                    if($key !== false) {
                        array_splice($tbrItems,$key,1);
                    }else {
                        // TODO shouldnt reach
                    }
                }
                $userinfo[1]=arrayToString($tbrItems,';:');
            }
        }
        changeUserData($userinfo);
    }else if(strcasecmp($_GET['listName'], "Har läst") == 0) {
        $_GET['listName'] = "hr";
        $userinfo = getUserInfo($_SESSION['userId']);
        $hr=$userinfo[2];
        if(sizeof($_POST['bookItem']) == 1) {
            $_POST['bookItem'] = $_POST['bookItem'][0];
            if(!contains(';:',$hr)) {
                if(strcasecmp($_POST['bookItem'],$hr) == 0) {
                    $userinfo[2]=null;
                }else {
                    // TODO shouldnt reach
                }
            }else {
                $hrItems=explode(';:',$hr);
                $key=array_search($_POST['bookItem'],$hrItems);
                if($key !== false) {
                    array_splice($hrItems,$key,1);
                    $userinfo[2]=arrayToString($hrItems,';:');
                }else {
                    // TODO shouldnt reach
                }
            }
        }else {
            if(!contains(';:',$hr)){
                // TODO shouldnt reach
            }else {
                $hrItems=explode(';:',$hr);
                foreach ($_POST['bookItem'] as $i) {
                    $key=array_search($i,$hrItems);
                    if($key !== false) {
                        array_splice($hrItems,$key,1);
                    }else {
                        // TODO shouldnt reach
                    }
                }
                $userinfo[2]=arrayToString($hrItems,';:');
            }
        }
        changeUserData($userinfo);
    }else {
        foreach ($_POST['bookItem'] as $i) {
            removeBookFromList($_GET['listName'],$i,$_SESSION['userId']);
        }
    }
    header("Location: http://$_SERVER[HTTP_HOST]/Webpage1/myBooks.php?list=".$_GET["listName"]);
    exit();
}
