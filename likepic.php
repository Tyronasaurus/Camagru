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
            $stmt->execute([
                'pid' => $pid,
                'userid' => $currentuser]);
        }

        $stmt = $pdo->prepare('SELECT * FROM users WHERE uid = :uid');
        $stmt->execute(['uid' => $currentuser]);
        $db = $stmt->fetch();
        if ($db['email_notif'] == 1) {
            $stmt = $pdo->prepare('SELECT * FROM uploads WHERE pid = :pid');
            $stmt->execute(['pid' => $pid]);
            $db = $stmt->fetch();
            $uploader_uid = $db['userid'];
            $stmt = $pdo->prepare('SELECT * from users WHERE uid = :uid');
            $stmt->execute(['uid' => $uploader_uid]);
            $db = $stmt->fetch();
            $send_to = $db['email'];
            

            $subject = "Uploaded Image";
            $message_body = 'Say Cheese! Someone has liked your picture!';
            mail($send_to, $subject, $message_body, 'From: donotreply@cheeseprod.com');
        }
    }
    header("location: uploads.php");

?>