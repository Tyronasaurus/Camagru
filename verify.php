<?PHP
    include "index.php";
    $email = $_GET['email'];
    $verifid = $_GET['verifid'];

    $stmt = $pdo->prepare('SELECT * from users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();

    if ($db['email'] == $email) {
        if ($db['verifid'] == $verifid) { 
            $stmt = $pdo->prepare('UPDATE users SET active = 1, verifid = 0 WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $_SESSION['succheader'] = "Account has successfully been activated!";
            $_SESSION['succbody'] = "Please login to continue";
            header("location: success.php");
        }
        else {
            $_SESSION['message'] = "Please try retry";
            header("location: error.php");
        }
    }
    else {
        $_SESSION['message'] = "Fatal Error. The world is gonna end";
        header("location: error.php");
    }

?>