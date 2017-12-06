<?PHP
    session_start();
    include 'config/database.php';

    if ( (isset($_POST['picture'])) ) {
        if (isset($_POST['overlay'])) {
            $email = $_SESSION['email'];
            
            $overlay = json_decode($_POST['overlay']);
            $overlay = explode(',', $overlay);
            $overlay = base64_decode($overlay[1]);        

            $photo = json_decode($_POST['picture']);
            $photo = explode(',', $photo);
            $photo = base64_decode($photo[1]);

            $dest = imagecreatefromstring($photo);
            $src = imagecreatefromstring($overlay);

            $width = imagesx($src);
            $height = imagesy($src);

            echo $width;
            echo $height;

            // imagealphablending($dest, false);
            // imagesavealpha($dest, true);
            // imagealphablending($src, false);
            // imagesavealpha($src, true);

            imagecopy($dest, $src, 110, 75, 0, 0, $width, $height);
            $fileName = uniqid('', true).".png";
            $fileDest = "uploads/".$fileName;
            imagepng($dest, $fileDest);

            file_put_contents($fileDest, $dest);
            $stmt = $pdo->prepare('INSERT INTO uploads (userid, file_name, date)
            VALUES (:userid, :file_name, NOW())');
            $stmt->execute([
                'userid' => $_SESSION['uid'],
                'file_name' => $fileName]);
            $_SESSION['uploaded'] = "Uploaded! Now its there forever!";
            //header("location: home.php?$fileDest");
        }
        else { echo "OVERLAY NOT FUCKIN SET";}
    }
    else {
        echo "fuck";
    }

?>