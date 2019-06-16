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


