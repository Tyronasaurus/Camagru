<!DOCTYPE HTML>
<?PHP 
    session_start();
    include 'config/database.php';
    echo $_SESSION['uid'];
    if (isset($_SESSION['username'])) {
        $name = $_SESSION['username'];
    }
    else { $name = '';}
?>

<HTML>
<HEAD>
    <link rel="stylesheet" type="text/css" href="style.css">
    <TITLE>Uploads</TITLE>
</HEAD>
<BODY>
    <div class="header">
        <h2>CHEESE!</h2>
        <?PHP if (isset($_SESSION['uid'])) {;?>
        <div class="nav">
            <a href="home.php">HOME</a>   |   
            <a href="uploads.php">UPLOADS</a>   |   
            <a href="profile.php">PROFILE</a>   |   
            <a href="logout.php">LOG OUT</a>
        </div>
        <?PHP } else { ?>
        <div class="nav">
            <a href='index.php'> SIGN UP </a>
        </div>
        <?PHP } ?>
        <div class="welcome">
            <?PHP if ($name != NULL) { ?>
                Logged in as <?PHP echo $name;?>
            <?PHP } else { ?>
                Not logged in
            <?PHP } ?> 
        </div>
    </div>
    <div class="form">
    <h3>UPLOADS</h3>
    <h4>
    <?PHP
        $files = scandir( "uploads" );
        $allowed = array('jpg', 'jpeg', 'png');
        foreach( $files as $file ) {
            $fileExt = explode('.', $file);
            $fileActualExt = strtolower(end($fileExt));
            if (in_array($fileActualExt, $allowed)) {
                $stmt = $pdo->prepare('SELECT * FROM uploads WHERE file_name = :file_name ORDER BY `date` ASC');
                $stmt->execute(['file_name' => $file]);
                $db = $stmt->fetch ();
                $userid = $db['userid'];
                $pid = $db['pid'];
                $stmt = $pdo->prepare('SELECT * FROM users WHERE `uid` = :uid');
                $stmt->execute(['uid' => $userid]);
                $db = $stmt->fetch ();
                $newstmt = $pdo->prepare('SELECT * from likes WHERE pid = :pid');
                $newstmt->execute(['pid' => $pid]);
                $count = $newstmt->rowCount();
                if (isset($db['uid'])) { ?>
                    <div>
                        <form method='POST' action="likepic.php">
                            <?PHP echo $name?> </br>
                            <img class=images src=uploads/<?= $file ?>>
                            <?PHP 
                                if (isset($_SESSION['uid'])) {?>
                            <button value=<?= $pid ?> name='like' id='like_button'><img id=like src='resources/like.png'></button>
                                <?PHP ;} else {?>
                                    <button name='like' id='like_button'><image id=like src='resources/unlike.png'><br>
                            <?PHP ;} ?>
                            <?PHP echo $count; ?>
                        </form>
                        <form method="POST" action="comments.php">
                            <button class="button button-block" value=<?= $pid ?> name="comments">Comments</button>
                        </form>
                    </div> </br>
                <?PHP }
            }
        }
    ?>
    </h4>
    </div>
</BODY>
</HTML>