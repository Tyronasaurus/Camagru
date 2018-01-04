<?PHP 
    session_start();
    include 'config/database.php';
    $uid = $_SESSION['uid'];
    if ($_POST['delete'] != NULL) {
        $img = $_POST['delete'];
        $stmt = $pdo->prepare('SELECT * FROM uploads WHERE file_name = :file_name');
        $stmt->execute(['file_name' => $img]);
        $uploaddb = $stmt->fetch();
        $pid = $uploaddb['pid'];
        $stmt2 = $pdo->prepare('DELETE FROM likes WHERE pid = :pid');
        $stmt2->execute(['pid' => $pid]);
        $stmt = $pdo->prepare('DELETE FROM comments WHERE pid = :pid');
        $stmt->execute(['pid' => $pid]);
        $stmt = $pdo->prepare('DELETE FROM uploads WHERE pid = :pid');
        $stmt->execute(['pid' => $pid]);
        header("location: home.php");
    }
?>