<!DOCTYPE HTML>

<?PHP
    session_start();
    include 'config/database.php';
    if ($_SESSION['email'] == NULL) {
        header('location: index.php?error=notloggedin');
    }
    $email = $_SESSION['email'];
    $_SESSION['uploaded'] = "";
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();
    $name = $db['username'];
?>

<HTML>
    <HEAD>
        <link rel="stylesheet" type="text/css" href="style.css">
        <TITLE>Upload</TITLE>
    </HEAD>
    <BODY onload="init();">
        <div class="header">
            <h2>CHEESE!</h2>
            <div class="nav">
                <a href="home.php">HOME</a>   |   
                <a href="uploads.php">UPLOADS</a>   |   
                <a href="profile.php">PROFILE</a>   |   
                <a href="logout.php">LOG OUT</a>
            </div>
            <div class="welcome">
                <?PHP if ($name != NULL) { ?>
                    Logged in as <?PHP echo $name;?>
                <?PHP } else { ?>
                    Not logged in
                <?PHP } ?> 
            </div>
        </div>
        <div class="user_ul">
        <h1>Your Uploads</h1>
        <?PHP 
            $uid = $_SESSION['uid'];
            $stmt = $pdo->prepare('SELECT file_name FROM uploads WHERE userid = :uid');
            $stmt->execute(['uid' => $uid]);
            $db_row = $stmt->rowCount();
            if ($db_row > 0) {
                $db = $stmt->fetchAll();
                $count = 0;
                while ($db[$count]['file_name']) {
                    $db_file = $db[$count]['file_name']; ?>
                    <img class=user_imgs src=uploads/<?= $db_file ?>> </br>
                    <form method=POST action="delete.php">
                            <button name='delete' value=<?= $db_file ?> class='deleteimg'>DELETE</button>
                        </form> </br>
                    <?PHP
                    $count++;
                }
            }
            else {
                echo "You have no uploads. Post a picture to see it here!";
            }
        ?>
        </div>
        <div class="home_form">
            <h3>Upload</h3>
            
            <div method="POST" class="camera_form">
                <div class="cam">
                    <div class="overlay_div">
                        <img id="overlay">
                    </div>
                    <div class="video_div">
                        <video id="video" width=400 height=300 autoplay></video>
                    </div>
                </div>
                <button disabled id="camera_button" onclick="snapshot();"><img src="resources/camera.png"></button>
            </div>
            </br>
            <!-- Choose File -->
            <h1>SCREENSHOTS</h1>
            <div class="canvas-wrap">
                <canvas id="myOverlay" ></canvas>
                <canvas id="myCanvas"></canvas>
            </div>
                <input class="button button-block" onclick="saveImg();" type="submit" name="upload">
                <p class="success">
                    <?PHP echo $_SESSION['uploaded']; ?>
                </p>
            <div class='camera_form'>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input class="button button-block" type="file" name="file">
                    <input class="button button-block" type="submit" name="submit">
                </form>
            </div>
        </div>
        <div class="small_form">
                <h1>OVERLAYS</h1>
                <button class="overlay_button" id="Thuglife" onclick="changeOverlay('resources/overlays/Thuglife.png');"><img src="resources/overlays/Thuglife.png"></button>
                <button class="overlay_button" id="spliff" onclick="changeOverlay('resources/overlays/spliff.png');"><img src="resources/overlays/spliff.png"></button>
        </div>
    </BODY>
    <script src="js/scripts.js">
      
  </script>
</HTML>