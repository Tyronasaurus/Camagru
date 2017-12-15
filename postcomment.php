<?PHP
    session_start ();
    include "config/database.php";

    if (($_POST['message'] != NULL) && ($_POST['submit'] != NULL)) {
        $message = $_POST['message'];
        $uid = $_SESSION['uid'];
        $pid = $_SESSION['pid'];
        $stmt = $pdo->prepare('INSERT INTO comments (pid, userid, comment_data)
                                VALUES (:pid, :userid, :comment_data)');
        $stmt->execute([
            'pid' => $pid,
            'userid' => $uid,
            'comment_data' => $message]);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE uid = :uid');
        $stmt->execute(['uid' => $uid]);
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
            $message_body = 'Say Cheese! Someone has commented on your picture!';
            mail($send_to, $subject, $message_body, 'From: donotreply@cheeseprod.com');
        }
    }
    header("location: comments.php");
?>