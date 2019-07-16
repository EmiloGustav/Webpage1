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
function getLists($userId) {
    $conn = getConnection();
    $sql = "SELECT * FROM lists WHERE uid=?";
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
    $uid = $array['6'];
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
// returns true if book is in db otherwise false
function checkBookInDbById($googleId) {
    $conn = getConnection();
    $sql = "SELECT googleId FROM books WHERE googleId=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt,"s",$googleId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultRows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        if($resultRows > 0) {
           // echo "id ".$googleId.' in library';
            return true;
        }else {
           // echo "id ".$googleId.' NOT in library';
            return false;
        }

    }
}
function checkBookInDbByTitleNAuthor($title, $author) {
    $conn = getConnection();
    $sql = "SELECT title FROM booksnotingoogle WHERE title=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "s", $title);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultRows = mysqli_stmt_num_rows($stmt);
        if ($resultRows > 0) {
            // echo $title.$author.' In booksnotingoogle';
            return true;
        }else {
            $sql = "SELECT * FROM books WHERE title=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // TODO ERRORHANTERING
                return false;
            } else {
                mysqli_stmt_bind_param($stmt, "s", $title);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $array = mysqli_fetch_array($result, MYSQLI_NUM);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                if (strcasecmp($array['2'], $author) == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}

function addToBookTable($title,$authors,$publisher,$publishedDate,$description,$isbn13,$isbn10,$smallthumbnail,$thumbnail,$textsnippet,$googleId){
    if ($googleId != NULL) {
        $conn = getConnection();
        $sql = "INSERT INTO books (title,author,publisher,published,description,isbn13,isbn10,smallthumbnail,thumbnail,textsnippet,googleId) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            //TODO ERROR HANTERING

            echo "Error" . $title . $authors . $publisher . $publishedDate . $description . $isbn13, $isbn10 . $smallthumbnail . $thumbnail . $textsnippet . $googleId;
        } else {
            mysqli_stmt_bind_param($stmt, "sssssssssss", $title, $authors, $publisher, $publishedDate, $description, $isbn13, $isbn10, $smallthumbnail, $thumbnail, $textsnippet, $googleId);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }else {
        echo "google id == NULL";
    }

}
function addToBooksNotInGoogle($title) {
    echo "add ".$title;
    $conn = getConnection();
    $sql = "INSERT INTO booksnotingoogle (title) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //TODO ERROR HANTERING

        echo "Error" . $title;
    } else {
        mysqli_stmt_bind_param($stmt, "s", $title);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getBookByGoogleId($googleId) {
    $conn = getConnection();
    $sql = "SELECT * FROM books WHERE googleId=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "s", $googleId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $array = mysqli_fetch_array($result, MYSQLI_NUM);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $array;
    }
}
function getBookByBookId($bookId) {
    $conn = getConnection();
    $sql = "SELECT * FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "s", $bookId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $array = mysqli_fetch_array($result, MYSQLI_NUM);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $array;
    }
}
function getBookByTitleNAuthor($title,$author) {
    $conn = getConnection();
    $sql = "SELECT * FROM books WHERE title=? AND author=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "ss", $title,$author);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $array = mysqli_fetch_array($result, MYSQLI_NUM);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $array;
    }
}
function getCommentsByBookId($bookId) {
    $conn = getConnection();
    $sql = "SELECT comments FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "s", $bookId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_row($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $row['0'];
    }
}

function updateSqlWithRating($rating,$bookId,$removedRating = 0,$changedRating = 0){
    $conn = getConnection();
    $sql = "SELECT * FROM books WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "s", $bookId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $array = mysqli_fetch_array($result, MYSQLI_NUM);

        (float)$currentRating = $array['11'];
        (int)$nrOfRatings = $array['14'];
        if($rating == -1 && $removedRating != 0) {
            if($currentRating == NULL){
                // TODO error borde ej kunna vara null när man kommer till remove
            }else if ((int) $nrOfRatings - 1 < 0) {
                // TODO error, borde ej kunna gå
            }else if ((int) $nrOfRatings == 1 ){
                $currentRating = NULL;
                $nrOfRatings = NULL;
            }else{

                // (4 * 2 - 4) / 1
                // (4 * 2 - 3 ) / 1
                $currentRating = (((float)$currentRating*$nrOfRatings)-$removedRating)/($nrOfRatings - 1);
                $nrOfRatings--;
            }
        }else if ($rating == -2 && $removedRating != 0 && $changedRating != 0){
            if($currentRating == NULL){
                // TODO error borde ej kunna vara null när man kommer till change
            }else if($nrOfRatings == 1) {
                $currentRating = $changedRating;
            }else{
                $currentRating = ((((float)$currentRating*$nrOfRatings)-$removedRating)/($nrOfRatings - 1)+$changedRating)/2;
            }
        }else {
            if($currentRating == NULL){
                $currentRating = $rating;
                $nrOfRatings = 1;
            }else {
                (float)$currentRating = ($currentRating+$rating)/2;
                $nrOfRatings++;
            }
        }
        $sql = "UPDATE books SET rating=?, nrOfRatings=? WHERE bookId=?";
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            // TODO ERRORHANTERING
            return false;
        }else {
            mysqli_stmt_bind_param($stmt, "sss", $currentRating,$nrOfRatings,$bookId);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
function addComment($comment,$bookId) {
    $conn = getConnection();
    $sql = "UPDATE books SET comments=? WHERE bookId=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        // TODO ERRORHANTERING
        return false;
    }else {
        mysqli_stmt_bind_param($stmt, "ss", $comment,$bookId);
        mysqli_stmt_execute($stmt);
    }
}























