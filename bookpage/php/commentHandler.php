<?php
require "../../includes/dbh.inc.php";
include "../../includes/sqlErrorHandler.php";
$sqlErrorHandler = new sqlErrorHandler();
session_start();
if (isset($_GET['type']) && isset($_GET['bookId']) && isset($_SESSION['userId'])) {
    if (strcasecmp($_GET['type'],'comment') == 0 ){
        $comment = $_POST['comment'];
        $bookId = $_GET['bookId'];
        $currentComments = getCommentsByBookId($bookId,$sqlErrorHandler);
        // TODO check if already commented, max amount of comments?

        if($currentComments == NULL) {
            $currentComments = $_SESSION['userId'].'::'.$comment;
            addComment($currentComments,$bookId,$sqlErrorHandler);
        }else {
            $currentComments = $currentComments.';:'.$_SESSION['userId'].'::'.$comment;
            addComment($currentComments,$bookId,$sqlErrorHandler);
        }
    }
    else if (strcasecmp($_GET['type'],'removeComment') == 0) {
        $comment = $_GET['comment'];
        $bookId = $_GET['bookId'];
        $currentComments = getCommentsByBookId($bookId,$sqlErrorHandler);
        if(!$sqlErrorHandler->help->contains(';:',$currentComments)) {
            $currentComments = NULL;
        }else {
            $currentComments = explode(';:',$currentComments);
            for($x = 0; $x < sizeof($currentComments);$x++){
                if(strcasecmp($currentComments[strval($x)],$comment) == 0) {
                    $match = $x;
                }
            }
            array_splice($currentComments,$match,1);
            $tmpString="";
            for($x = 0;$x < sizeof($currentComments);$x++) {
                if($x  == 0) {
                    $tmpString = $currentComments[strval($x)];
                }else {
                    $tmpString = $tmpString.';:'.$currentComments[strval($x)];
                }
            }
            if(strcasecmp('',$tmpString) == 0) {
                $tmpString = NULL;
            }
            $currentComments = $tmpString;
        }
        addComment($currentComments,$bookId,$sqlErrorHandler);
    }
    $bookId = $_GET['bookId'];
    header("Location: ../bookpage.php?bookId=".$bookId);
    exit();

}
else{
        // TODO lägga till en header så att man kommer tillbaka om man kommit hit otillåtet eller om man inte är ionloggad
        //
}

// FUNCTIONS //

function addComment($comment, $bookId,$sqlErrorHandler)
{
    // adds comment to book with bookId
    $conn = getConnection();
    $sql = "UPDATE books SET comments=? WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $sqlErrorHandler->createErrorMsg(__FUNCTION__, "sql-error", "bookId=" . $bookId, "comment=" . $comment);
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $comment, $bookId);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getCommentsByBookId($bookId,$sqlErrorHandler)
{
    // returns comment for book, returns false if sql error
    // bookId is our id for the books
    $conn = getConnection();
    $sql = "SELECT comments FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $sqlErrorHandler->createErrorMsg(__FUNCTION__, "sql-error", "bookId=" . $bookId);
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "s", $bookId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_row($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $row['0'];
    }
}