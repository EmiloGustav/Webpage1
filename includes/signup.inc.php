<?php
/**
 * Created by PhpStorm.
 * User: Emil
 * Date: 2019-06-16
 * Time: 13:26
 */

if(isset($_POST['signup-submit'])) {

    require 'dbh.inc.php';

    // Dessa måste vara ifyllda dör att det ska gå att skapa ett konto.
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['re-password'];

    // Extra usr information.
    $firstname = $_POST['fornamn'];
    $surname = $_POST['efternamn'];
    $country = $_POST['country'];


    // Kolla om alla fälten är ifyllda
    if(empty($username) || empty($email) || empty($password) || empty($rePassword)) {
        header("Location: ../signup.php?error=emptyfields&username=".$username."&email=".$email);
        exit();
    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$username) && !filter_var($email,FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemailusername");
        exit();
    }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemail&username=".$username);
        exit();
    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
        header("Location: ../signup.php?error=invalidusername&email=".$email);
        exit();
    }else if($password !== $rePassword) {
        header("Location: ../signup.php?error=pwdcheck&username=".$username."&email=".$email);
        exit();
    }else{
        $sqlusr = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $sqlemail = "SELECT emailUsers FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sqlusr)) {
            header("Location: ../index.php?error=sqlerrorusr");
            exit();
        }else if(!mysqli_stmt_prepare($stmt,$sqlemail)){
            header("Location: ../index.php?error=sqlerroremail");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheckusr = mysqli_stmt_num_rows($stmt);

            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheckemail = mysqli_stmt_num_rows($stmt);

            if ($resultCheckusr > 0) {
                header("Location: ../signup.php?error=usertaken&email=".$email);
                exit();
            }else if($resultCheckemail > 0){
                header("Location: ../signup.php?error=emailtaken&username=".$username);
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

                    // Kontot är nu skapat med det viktigaste

                    $sql = "SELECT idUsers, uidUsers, CASE WHEN uidUsers='$username' THEN idUsers END FROM users";
                    $result = mysqli_query($conn,$sql);

                    while($row = mysqli_fetch_row($result)) {
                       if(isset($row['2'])){
                        $uid = $row['2'];
                       }
                    }

                    // Här under sätts infon som är frivillig att lämna in när databsen väl är färdig.

                    if(!isset($firstname)) {
                        $firstname = NULL;
                    }
                    if(!isset($surname)) {
                        $surname = NULL;
                    }
                    if(!isset($country)) {
                        $country = NULL;
                    }

                    $sql = "INSERT INTO info (firstname,surname,country,uid) VALUES (?,?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)) {
                        header("Location: ../index.php?error=sqlinfoerror");
                        exit();
                    }else {

                        mysqli_stmt_bind_param($stmt, "ssss", $firstname, $surname, $country,$uid);
                        mysqli_stmt_execute($stmt);
                    }

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











