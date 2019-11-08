<?php
class bookpageHelper {
    var $help;
    public function __construct()
    {
        $this->help = new helper();
    }

    function isBookRated($bookId,$userinfo){
        if(isset($userinfo['4'])) {
            if(!$this->help->contains(';:',$userinfo['4']) && strcasecmp($userinfo['4'],$bookId) == 0) {
                return $userinfo['5'];
            }else if(!$this->help->contains(';:',$userinfo['4']) && strcasecmp($userinfo['4'],$bookId) != 0){
                return false;
            }else {
                $ratedBooksId = explode(";:" , $userinfo['4']);
                for($x = 0; $x < sizeof($ratedBooksId); $x++){
                    if(strcasecmp($bookId,$ratedBooksId[strval($x)]) == 0) {
                        $tmpArray = explode(';:',$userinfo['5']);
                        return $tmpArray[strval($x)];
                    }
                }
                return false;
            }
        }
    }
}
