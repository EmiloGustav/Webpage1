<?php
class getListOfBooks {
    var $startIndex;

    public function __construct()
    {
        $this->startIndex = 1;
    }

    function incrementIndex() {
        $this->startIndex += 40;
    }

    function getListOfBooksID() {


        incrementIndex();
    }
}