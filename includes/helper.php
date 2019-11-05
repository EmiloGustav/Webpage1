<?php
class helper {
    function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
    function arrayToString($array, $divider){
        $tmp = "";
        if(sizeof($array) == 1) {
            $tmp=$array[0];
        }else {
            $first = true;
            foreach ($array as $x) {
                if($first == true) {
                    if (gettype($x) == "Array") {
                        $tmp = arrayToString($x, '::');
                    } else {
                        $tmp = $x;
                    }
                    $first=false;
                }else {
                    if (gettype($x) == "Array") {
                        $tmp = $tmp . arrayToString($x, '::');
                    } else {
                        $tmp = $tmp . $divider . $x;
                    }
                }

            }
        }
        return $tmp;
    }
}
