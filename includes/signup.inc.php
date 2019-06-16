<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-16
 * Time: 13:26
 */

if(isset($_POST['signup-submit'])) {

    require 'dbh.inc.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['re-password'];


    // Kolla om alla fälten är ifyllda
    if(empty($username) || empty($email) || empty($password) || empty($rePassword)) {
        header("Location: ../index.php?error=emptyfields&username=".$username."&email".$email);
        exit();
    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$username) && !filter_var($email,FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalidemailusername");
        exit();
    }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalidemail&username=".$username);
        exit();
    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
        header("Location: ../index.php?error=invalidusername&email=".$email);
        exit();
    }else if($password !== $rePassword) {
        header("Location: ../index.php?error=pwdcheck&username=".$username."&email".$email);
        exit();
    }else{
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../index.php?error=sqlerror1");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck = mysqli_stmt_num_rows($stmt);
            if ($resultcheck > 0) {
                header("Location: ../index.php?error=usertaken&email".$email);
                exit();
            }else{
                $sql = "INSERT INTO users (uidUsers,emailUsers,pwdUsers) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../index.php?error=sqlerror2");
                    exit();
                }else{
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt,"sss",$username,$email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}else{
    header("Location: ../index.php");
    exit();
}











