<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-16
 * Time: 13:26
 */

if (isset($_POST['login-submit'])) {

    require 'dbh.inc.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $page = $_GET['page'];
    if (empty($username) || empty($password)) {
        if(!contains('?',$page)) {
            header("Location: http://$_SERVER[HTTP_HOST]$page?error=emptyfields");
        }else {
            header("Location: http://$_SERVER[HTTP_HOST]$page&error=emptyfields");
        }
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            if(!contains('?',$page)) {
                header("Location: http://$_SERVER[HTTP_HOST]$page?error=sqlerror");
            }else {
                header("Location: http://$_SERVER[HTTP_HOST]$page&error=sqlerror");
            }
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"ss",$username, $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['pwdUsers']);
                if($pwdCheck == false){
                    if(!contains('?',$page)) {
                        header("Location: http://$_SERVER[HTTP_HOST]$page?error=wrongpassword");
                    }else {
                        header("Location: http://$_SERVER[HTTP_HOST]$page&error=wrongpassword");
                    }
                    exit();
                }else if($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];
                    $_SESSION['userEmail'] = $row['emailUsers'];
                    if(!contains('?',$page)) {
                        header("Location: http://$_SERVER[HTTP_HOST]$page?login=success");
                    }else {
                        header("Location: http://$_SERVER[HTTP_HOST]$page&login=success");
                    }
                    exit();
                }else {
                    if(!contains('?',$page)) {
                        header("Location: http://$_SERVER[HTTP_HOST]$page?error=wrongpassword");
                    }else {
                        header("Location: http://$_SERVER[HTTP_HOST]$page&error=wrongpassword");
                    }
                    exit();
                }
            }else{
                if(!contains('?',$page)) {
                    header("Location: http://$_SERVER[HTTP_HOST]$page?error=nouser");
                }else {
                    header("Location: http://$_SERVER[HTTP_HOST]$page&error=nouser");
                }
                exit();
            }
        }
    }

}else{
    header("Location: ../index.php");
    exit();
}
function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}