<?php

if (isset($_POST["reset-password-submit"])) {
    /* Hämta användarens inmatade data */
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-reapeat"];

    if (empty($password) || empty($passwordRepeat)) {
        header("Location: ../index/index.php?newpwd=empty");
        exit();
    } else if ($password != $passwordRepeat) {
        header("Location: ../index/index.php?newpwd=pwdnotsame");
        exit();
    }

    /* Kontrollera så att Token inte har utgått */
    $currentDate = date("U");

    require 'dbh.inc-php';

    /* Välja token från databasen */
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Det uppstod ett fel!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_feth_assoc($result)) {
            echo "Du behöver åter skicka en återställningsförfrågan.";
            exit();
        } else {
            /* Matcha Token från databasen med Token från "form". */
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

            if ($tokenCheck === false) {
                echo "Du behöver åter skicka en återställningsförfrågan.";
                exit();
            } else if ($tokenCheck === true) {
                /* Uppdatera användaren i databasen */
                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE emailUsers=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "Det uppstod ett fel!";
                    exit();
                } else {
                    /* Ta användaren från "users-table" */
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_feth_assoc($result)) {
                        echo "Det uppstod ett fel!";
                        exit();
                    } else {
                        /* Uppdata användarens information i "users-table" */
                        $sql = "UPDATE users SET pwdUsers=? WHERE emailUsers=?";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "Det uppstod ett fel!";
                            exit();
                        } else {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            /* Delete Token */
                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "Det uppstod ett fel!";
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../index/index.php?newpwd=passwordupdated");
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    header("Location: ../index/index.php");
}
