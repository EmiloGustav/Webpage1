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
    $firstanme = $_POST['fornamn'];
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
        $stmtusr = mysqli_stmt_init($conn);
        $stmtemail = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmtusr,$sqlusr)) {
            header("Location: ../index.php?error=sqlerrorusr");
            exit();
        }else if(!mysqli_stmt_prepare($stmtemail,$sqlemail)){
            header("Location: ../index.php?error=sqlerroremail");
            exit();
        }else{
            mysqli_stmt_bind_param($stmtusr,"s",$username);
            mysqli_stmt_execute($stmtusr);
            mysqli_stmt_store_result($stmtusr);
            $resultCheckusr = mysqli_stmt_num_rows($stmtusr);

            mysqli_stmt_bind_param($stmtemail,"s",$email);
            mysqli_stmt_execute($stmtemail);
            mysqli_stmt_store_result($stmtemail);
            $resultCheckemail = mysqli_stmt_num_rows($stmtemail);

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

                    // Här under sätts infon som är frivillig att lämna in när databsen väl är färdig.

             /*       if(isset($firstanme)) {
                        $sqlFirstname = "SELECT firstname FROM info WHERE firstname = ?";
                        $stmtFirstname = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmtFirstname, $sqlFirstname)) {
                            header("Location: ../index.php?error=sqlerrorfirstname");
                            exit();
                        }
                        mysqli_stmt_bind_param($stmtFirstname,'s',$firstname);
                        mysqli_stmt_execute($stmtFirstname);
                        $sqlInsert = "INSERT INTO info (firstname) VALUES (?)";
                        $stmtInsert = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmtInsert,$sqlInsert)) {
                            header("Location: ../index.php?error=sqlerrorfirstname2");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmtInsert,'s',$firstname);
                            mysqli_stmt_execute($stmtInsert);
                        }
                    }else if(isset($surname)) {
                        $sqlsurname = "SELECT surname FROM info WHERE surname = ?";
                        $stmtsurname = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmtsurname, $sqlsurname)) {
                            header("Location: ../index.php?error=sqlerrorsurname");
                            exit();
                        }
                        mysqli_stmt_bind_param($stmtsurname,'s',$surname);
                        mysqli_stmt_execute($stmtsurname);
                        $sqlInsert = "INSERT INTO info (surname) VALUES (?)";
                        $stmtInsert = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmtInsert,$sqlInsert)) {
                            header("Location: ../index.php?error=sqlerrorsurname2");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmtInsert,'s',$surname);
                            mysqli_stmt_execute($stmtInsert);
                        }
                    }else if(isset($country)) {
                        $sqlcountry = "SELECT country FROM info WHERE country = ?";
                        $stmtcountry = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmtcountry, $sqlcountry)) {
                            header("Location: ../index.php?error=sqlerrorcountry");
                            exit();
                        }
                        mysqli_stmt_bind_param($stmtcountry,'s',$country);
                        mysqli_stmt_execute($stmtcountry);
                        $sqlInsert = "INSERT INTO info (country) VALUES (?)";
                        $stmtInsert = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmtInsert,$sqlInsert)) {
                            header("Location: ../index.php?error=sqlerrorcountry2");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmtInsert,'s',$country);
                            mysqli_stmt_execute($stmtInsert);
                        }
                    }
            */
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











