<?PHP
    session_start ();

    include 'config/database.php';
    $uid = $_SESSION['uid'];
    $name = $_SESSION['username'];
    $email = $_SESSION['email'];
    $newname = strip_tags($_POST['username']);
    $newmail = strip_tags($_POST['email']);
    if ($newname == NULL) {
        $newname = $name;
    }
    if ($newmail == NULL) {
        $newmail = $email;
    }
    if ($_POST['checkbox'] != NULL) {
        $email_notif = 1;
    }
    else {
        $email_notif = 0;
    }
    $stmt = $pdo->prepare('UPDATE users SET username=:username, email=:email, email_notif=:email_notif WHERE uid=:userid');
    $stmt->execute([
        'username' => $newname,
        'email' => $newmail,
        'userid' => $uid,
        'email_notif' => $email_notif
    ]);
    $_SESSION['email'] = $newmail;
    $_SESSION['username'] = $newname;
    header("location: profile.php");
?>