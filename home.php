<!DOCTYPE HTML>

<?PHP
    session_start();
    include 'config/database.php';
    $email = $_SESSION['email'];
    $_SESSION['uploaded'] = "";
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();
    $name = $db['first_name'];
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
                <a href="index.php">LOG OUT</a>
            </div>
            <div class="welcome">
                Logged in as <?PHP echo $name; ?>
            </div>
        </div>
        <div class="home_form">
            <h3>Upload</h3>
            
            <div method="POST" class="camera_form">
                <div class="cam">
                    <div class="overlay_div">
                        <img id="overlay">
                    </div>
                    <div class="video_div">
                        <video id="video" autoplay></video>
                    </div>
                </div>
                <button disabled id="camera_button" onclick="snapshot();"><img src="resources/camera.png"></button>
            </div>
            <!-- Choose File -->
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input class="button button-block" type="file" name="file">
                <input class="button button-block" type="submit" name="submit">
            </form>
            <h1>SCREENSHOTS</h1>
            <div class="canvas-wrap">
                <div class="overlay-cont">
                    <canvas id="myOverlay"></canvas>
                </div>
                <div class="video-cont">
                    <canvas id="myCanvas"></canvas>
                </div>
            </div>
                <input class="button button-block" onclick="saveImg();" type="submit" name="upload">
                <?PHP 

                ?>
                <p class="success">
                    <?PHP echo $_SESSION['uploaded']; ?>
                </p>
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