<?php
/**
 * Gustav Hultgren
 * Date: 2019-06-18
 */

if (isset($_POST["reset-request-submit"])) {
    
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost/Webpage1/create-new-password.php?selector=" . $selector . "&validator =" . bin2hex($token);

    $expires = date("U") + 1800;

    require 'dbh.inc.php';

    $userEmail = $_POST["email"];

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Det uppstod ett fel!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Det uppstod ett fel!";
        exit();
    } else {
        $hashed_token = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashed_token, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    /* Send the e-mail */
    $to = $userEmail;

    $subject = 'Återställ ditt lösenord för CoolaBöcker1996';

    $message = '<p>Vi har mottagit en förfrågan om att återställa ett lösenord. Om det inte är du som har begärt att återställa lösenordet kan du ignorera detta e-mail.</p>';
    $message .= '<p>Följ denna länken för att återställa ditt lösenord: </br>';
    $message .= '<a href="' . $url . '">' . $url . ' </a></p>';

    $headers = "Från: CoolaBöcker1996 <hultgrengustav@gmail.com>\r\n";
    $headers .= "Reply-To: hultgrengustav@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header("Location: ../reset-password.php?reset=success");

} else {
    header("Location: ../index.php");
}