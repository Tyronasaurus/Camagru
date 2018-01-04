<!DOCTYPE HTML>

<?PHP
    session_start ();
    include 'config/database.php';
    $_SESSION['succheader'] = '';
    $_SESSION['succbody'] = '';
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['error'] = "";
    $email = $_POST['email'];
    $verifid = rand();

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email =:email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();
    if ($email == NULL) {
        $_SESSION['error'] = 'Enter an email address below';
    }
    else if ($db['email'] != NULL) {
        $stmt = $pdo->prepare('UPDATE users SET verifid =:verifid WHERE email =:email');
        $stmt->execute([
            'verifid' => $verifid,
            'email' => $email]);
        $message_body = "Please click the link below to reset your password
        
        http://localhost:8080/camagru/reset.php?email=$email&verifid=$verifid";
        mail($email, "Password Reset", $message_body, "From: donotreply@cheeseprod.com");
        $_SESSION['succheader'] = "Password Reset";
        $_SESSION['succbody'] = "Please follow the link sent to $email to reset your password"; 
    
        header("location: success.php");
    }
    else {
        $_SESSION['error'] = "Invalid email address";
    }
?>

<HTML>
    <HEAD>
    <link rel="stylesheet" type="text/css" href="style.css">
        <TITLE>
            Password Reset
        </TITLE>
    </HEAD>
    <BODY>
        <div class="header">
            <h3>CHEESE!</h3>
            <p class="error">
                <?PHP echo $_SESSION['error']; $_SESSION['error'] = ''; ?>
            </p>
        </div>
        <div class="form">
            <h1>RESET YOUR PASSWORD</h1>
            <form method="POST" autocomplete="off">
                <div class="field-wrap">
                    <input type="email" placeholder="Email Address" name="email">
                </div>
                <button class="button button-block" name="forgot">CONTINUE</button>
                
            </form>
        </div>
    </BODY>
</HTML>