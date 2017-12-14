<?PHP
    include "config/database.php";
    session_start ();
    $currentuser = $_SESSION['uid'];

    if (($_POST['like']) != NULL) {
        $pid = $_POST['like'];
            $stmt = $pdo->prepare('SELECT * FROM likes WHERE pid = :pid AND userid = :userid');
            $stmt->execute([
                'pid' => $pid,
                'userid' => $currentuser]);
            $ifliked = $stmt->fetch();
            if ($ifliked['id'] == NULL) {
                $stmt = $pdo->prepare('INSERT INTO likes (pid, userid, id)
                                        VALUES (:pid, :userid, NULL)');
                echo $currentuser;
                $stmt->execute([
                    'pid' => $pid,
                    'userid' => $currentuser]);
            }
    }
    header("location: uploads.php");

?>