<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-16
 * Time: 13:27
 */
$page = $_GET['page'];
session_start();
session_unset();
session_destroy();
header("Location: http://$_SERVER[HTTP_HOST]$page");
