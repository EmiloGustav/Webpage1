<?php
class sqlErrorHandler {
    var $help;
    function __construct()
    {
        include "helper.php";
        $this->help = new helper();
    }

    function createErrorMsg($function, $logName, ...$params)
    {
        $timestamp = time();
        $error = date("F d, Y h:i:s A", $timestamp) . ': The function ' . $function . ' generated a sql error with ';
        if ($params != null && gettype($params) == "Array") {
            $tmp = $this->help->arrayToString($params, '::');
        } else {
            $tmp = $params;
        }
        $error = $error . $tmp;
        error_log($error, 3, "../tmp/logs/" . $logName . ".log");
    }
}
