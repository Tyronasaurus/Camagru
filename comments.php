<!DOCTYPE HTML>
<?PHP 
    session_start();
    include 'config/database.php';
    $name = $_SESSION['username'];
    if ($_POST['comments'] != NULL) {
        $pid = $_POST['comments'];
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
            Logged in as <?PHP echo $name; ?>
        </div>
    </div>
    <div class="form">
        <h3>COMMENTS</h3>
        <?PHP 
            $stmt = $pdo->prepare('SELECT * FROM uploads WHERE pid = :pid');
            $stmt->execute(['pid' => $pid]);
            $db = $stmt->fetch();
            $picture = $db['file_name'];
        ?>
        <img src=uploads/<?= $picture ?>>
        <form method="POST">
            <textarea name="message"></textarea> </br>
            <input class="button button-block" type="submit" name="submit"></input>
        </form>
        </br>
        <div class="comment_block">
            <?PHP
                $stmt = $pdo->prepare('SELECT comment_data FROM comments WHERE pid = :pid');
                $stmt->execute(['pid' => $pid]);
                $db_count = $stmt->rowCount();
                if ($db_count > 0) {
                    $db = $stmt->fetchAll();
                    $count = 0;
                    while ($db[$count]['comment_data']) {
                        $newstmt = $pdo->prepare('SELECT * FROM users WHERE uid = :uid');
                        $newstmt->execute(['uid' => $db[$count]['uid']]);
                        $userdb = $newstmt->fetch();
                        echo $userdb['username'];
                        echo $db[$count]['uid'];
                        echo $db[$count]['comment_data'];
                        $count++;
                    }
                }
            ?> 
        </div>      
    </div>
</BODY>
</HTML>