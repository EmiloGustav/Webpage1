<?php
class index_getDb {
	
	public function  __construct()
    {
        require "../includes/dbh.inc.php";
        include ("../includes/sqlErrorHandler.php");
        $this->sqlErrorHandler = new sqlErrorHandler();
    }
	
	function getTheThreeHighestRatedBooks() {
        $data = array();
        $conn = getConnection();
        $sql = "SELECT bookId, title, author, published, smallthumbnail FROM books ORDER BY rating DESC LIMIT 3";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            return false;
        } else {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result) {
                while($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $data;
        }
    }
	
	function getLatestBookFromCurrentlyReading($userId) {
		$data = array();
        $conn = getConnection();
        $sql = "";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            return false;
        } else {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result) {
                while($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $data;
        }
    }
}