<!DOCTYPE HTML>
<?PHP 
    session_start();
    include 'config/database.php';
?>

<HTML>
<HEAD>
    <link rel="stylesheet" type="text/css" href="style.css">
    <TITLE>Uploads</TITLE>
</HEAD>
<BODY>
    <div class="header">
        <h2>CHEESE!</h2>
        <div class="nav">
            <a href="home.php">HOME</a>   |   
            <a href="uploads.php">UPLOADS</a>   |   
            <a href="index.php">LOG OUT</a>
        </div>
        <div class="welcome">
            Logged in as <?PHP echo $name; ?>
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
                $stmt = $pdo->prepare('SELECT * FROM uploads WHERE file_name = :file_name');
                $stmt->execute(['file_name' => $file]);
                $db = $stmt->fetch ();
                $userid = $db['userid'];
                $stmt = $pdo->prepare('SELECT * FROM users WHERE uid = :uid');
                $stmt->execute(['uid' => $userid]);
                $db = $stmt->fetch ();
                if (isset($db['uid'])) {
                    echo $db['first_name'] . "<br />";
                }
                else {
                    echo "Unknown"."<br />";
                }
                echo "<img class=images src=uploads/$file>" . "<br />";
           }
        }
    ?>
    </h4>
    </div>
</BODY>
</HTML>