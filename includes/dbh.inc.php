<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-16
 * Time: 13:38
 */

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "loginsystembok";

$conn = mysqli_connect($servername, $dBUsername,$dBPassword,$dBName);

if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}
function getConnection()
{
    // Starts a connection with the db and returns the connection.
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "loginsystembok";

    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

