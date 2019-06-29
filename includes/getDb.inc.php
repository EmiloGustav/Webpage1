<?php
require "dbh.inc.php";



function getUserInfo($userId) {
    // Returns array with userinfo
    $conn = getConnection();
    $sql = "SELECT * FROM info WHERE uid=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return "error1";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $array = mysqli_fetch_array($result, MYSQLI_NUM);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $array;
    }
}
function changeUserData($array) {
    $uid =$array['6'];
    $oldData = getUserInfo($uid);
    $conn = getConnection();
    $categories = getCategories('info');
    if (sizeof($categories) != sizeof($array)) {
        return "Error";
    }
    $stmt = mysqli_stmt_init($conn);
    for ($x = 0; $x < sizeof($array); $x++) {
        $var = strval($categories[strval($x)]);
        $sql = "UPDATE info SET  $var=? WHERE uid=$uid";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return "error".$sql;
        }else{
            if ($oldData[strval($x)] != $array[strval($x)]) {
                mysqli_stmt_bind_param($stmt, 's', $array[strval($x)]);
            }else {
                mysqli_stmt_bind_param($stmt, 's', $oldData[strval($x)]);
            }
            mysqli_stmt_execute($stmt);
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return getUserInfo($uid);
}

// Returns the categories for a table with TABLE_NAME.
function getCategories($TABLE_NAME) {
    $conn = getConnection();
    $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return "error";
    } else {
        mysqli_stmt_bind_param($stmt,"s",$TABLE_NAME);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $categories = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            array_push($categories,$row['3']);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $categories;
    }
}
// Starts a connection with the db and returns the connection.
function getConnection(){
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "loginsystembok";

    $conn = mysqli_connect($servername, $dBUsername,$dBPassword,$dBName);

    if(!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }
    return $conn;
}