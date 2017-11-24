<?PHP
    session_start();
    include 'config/database.php';

    $email = $_SESSION['email'];
    echo $_SESSION['uid'];
    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 200000) {
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $stmt = $pdo->prepare('INSERT INTO uploads (userid, file_name)
                                            VALUES (:userid, :file_name)');
                    $stmt->execute(['userid' => $_SESSION['uid'],
                                    'file_name' => $fileNameNew]);
                    header("Location: home.php?$fileDestination");
                } else {
                    //$_SESSION['ul_error'] = "File is too large. Must be less than 20MB";
                    echo "File is too large. Must be less than 20MB";
                }
            } else {
                //$_SESSION['ul_error'] = "There was an error uploading this file";
                echo "There was an error uploading this file";
            }
        } else {
            //$_SESSION['ul_error'] = "You can't upload files of this type.";
            echo "You can't upload files of this type.";
        }
    }


?>