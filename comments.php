<!DOCTYPE HTML>
<?PHP 
    session_start();
    include 'config/database.php';
    if ($_SESSION['username'] != NULL) {
        $name = $_SESSION['username'];
    }
    if ($_POST['comments'] != NULL) {
        $pid = $_POST['comments'];
        $_SESSION['pid'] = $pid;
    }
?>

<HTML>
<HEAD>
    <link rel="stylesheet" type="text/css" href="style.css">
    <TITLE>Comments</TITLE>
</HEAD>
<BODY>
    <div class="header">
        <h2>CHEESE!</h2>
        <div class="nav">
            <a href="home.php">HOME</a>   |   
            <a href="uploads.php">UPLOADS</a>   |   
            <a href="profile.php">PROFILE</a>   |   
            <a href="index.php">LOG OUT</a>
        </div>
        <div class="welcome">
            <?PHP if ($name != NULL) { ?>
                Logged in as <?PHP echo $name;?>
            <?PHP } else { ?>
                Not logged in
            <?PHP } ?> 
        </div>
    </div>
    <div class="form">
        <h3>COMMENTS</h3>
        <?PHP 
            $stmt = $pdo->prepare('SELECT file_name FROM uploads WHERE pid = :pid');
            $stmt->execute(['pid' => $_SESSION['pid']]);
            $db = $stmt->fetch();
            $picture = $db['file_name'];
        ?>
        <img src=uploads/<?= $picture ?>>
        <form method="POST" action="postcomment.php">
            <textarea name="message" placeholder="Write a comment..."></textarea> </br>
            <input class="button button-block" type="submit" name="submit"></input>
        </form>
        </br>
            <?PHP
                $stmt = $pdo->prepare('SELECT * FROM comments WHERE pid = :pid');
                $stmt->execute(['pid' => $_SESSION['pid']]);
                $db_count = $stmt->rowCount();
                if ($db_count > 0) {
                    $db = $stmt->fetchAll();
                    $count = 0;
                    while ($db[$count]['comment_data']) { 
                            $newstmt = $pdo->prepare('SELECT * FROM users WHERE uid = :uid');
                            $newstmt->execute(['uid' => $db[$count]['userid']]);
                            $userdb = $newstmt->fetch();
                            ?>
                                <div class='usernames'>
                            <?PHP
                                echo $userdb['username'];
                            ?>
                                </div>
            <div class="comment_block">
                            <?PHP 
                            echo $db[$count]['comment_data'];
                            $count++;
                        ?>
                        </div> </br>
                        <?PHP
                    }
                }
                        ?>
    </div>
</BODY>
</HTML>