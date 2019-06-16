<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-16
 * Time: 13:27
 */

session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
