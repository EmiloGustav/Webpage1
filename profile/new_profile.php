<?php
session_start();
include('../includes/getDb.php');
$getDb = new getDb();

$username = "";
$isFollowing = false;

if (isset($_GET['username'])) {
    if (getDb::query('SELECT uidUsers FROM users WHERE uidUsers=:uidUsers', array(':uidUsers' => $_GET['username']))) {
        $username = getDb::query('SELECT uidUsers FROM users WHERE uidUsers=:uidUsers', array(':uidUsers' => $_GET['username']))[0]['uidUsers'];
        $userid = getDb::query('SELECT idUsers FROM users WHERE uidUsers = :username', array(':username' => $_GET['username']))[0]['idUsers'];
        $followerid = $_SESSION['userId'];

        if (isset($_POST['follow'])) {
            if ($userid != $followerid) {
                if (!getDb::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid))) {
                    getDb::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid' => $userid, ':followerid' => $followerid));
                }
                $isFollowing = true;
            }
        }

        if (isset($_POST['unfollow'])) {
            if ($userid != $followerid) {
                if (getDb::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid))) {
                    getDb::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid));
                }
                $isFollowing = false;
            }
        }

        if (getDb::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid))) {
            $isFollowing = true;
        }

        $reviews = getDB::query('SELECT * FROM reviews WHERE user_id=:user_id', array(':user_id'=>$userid));

    } else {
        die('User not found!');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/myProfile.css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

    <title>BonoLibro</title>
</head>

<body>

    <aside>
        <figure>
            <a href="../index/index.php"><img id="logotype" src="../images/books.png" alt=""></a>
            <a href="../index/index.php">
                <figcaption>BonoLibro</figcaption>
            </a>
        </figure>
        <img id="menu-icon" src="../images/menu.svg" alt="">

        <nav>
            <ul>
                <?php
                if (isset($_SESSION['userId'])) {
                    echo '<li><a href="../profile/editProfile.php">Redigera profil</a></li>
                    <hr>
                    <li><a href="../myBooks/myBooks.php">Mina böcker</a></li>
				<hr>';
                } else {
                    echo '<li><a href="../login-logout/login.php">Logga in</a></li>
				<hr>
				<li><a href="../signup/signup.php">Registrera</a></li>
				<hr>';
                }
                ?>
            </ul>
        </nav>
    </aside>

    <main>
        <div class="main-left">
            <div class="container-profile">
                <?php
                $userData = $getDb->getUserInfo($userid);
                ?>

                <!-- If UserImage = NULL, set profileImage.png as default, else get image url from database or something -->
                <img src="../images/profileImage.png" alt="användarbild" style="width:130px; height:130px;">

                <div class="profile-header">
                    <h1><?php echo $username; ?></h1>

                    <form action="new_profile.php?username=<?php echo $username; ?>" method="post">
                        <?php
                        if ($userid != $followerid) {
                            if ($isFollowing) {
                                echo '<input type="submit" name="unfollow" value="Sluta följ">';
                            } else {
                                echo '<input type="submit" name="follow" value="Följ">';
                            }
                        }
                        ?>
                    </form>
                </div>

                <hr>

                <div class="profile-info">
                    <h3>Gick med</h3>
                    <p><?php echo ($userData['10']); ?></p>
                    <h3>Om</h3>
                    <p class="about-data"><?php echo ($userData['11']); ?></p>
                </div>
            </div>
        </div>

        <div class="main-right">
            <div class="container-feed">
                <h1><?php echo $username;?>'s recensioner</h1>
                <?php
                foreach ($reviews as $r) {
                  echo $r['title'];
                  echo $r['body'];
                  echo $r['posted_at'];
                  echo $r['likes'];
                  echo '<br>';
                }
                 ?>
            </div>
        </div>
    </main>

    <script type="text/javascript" src="js/myProfile.js"></script>

</body>

</html>
