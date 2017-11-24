 <!DOCTYPE HTML>
<?PHP
    session_start ();
    include 'config/databse.php';
    $email = $_GET['email'];
    $verifid = $_GET['verifid'];

    echo $email;

    $pass = hash("whirlpool", $_POST['password']);
    $confirm_pass = hash("whirlpool", $_POST['confirm_pass']);

    if ($pass == $confirm_pass) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $db = $stmt->fetch();

        if ($db['email'] != NULL) {
            $stmt = $pdo->prepare('UPDATE users SET password = :pass, verifid = 0 WHERE email = :email');
            $stmt->execute([
                'pass' => $pass,
                'email' => $email
            ]);
            $_SESSION['succheader'] = 'Password Reset';
            $_SESSION['succbody'] = "Password has been changed";
            header("location: success.php");
        }
        else {
            $_SESSION['error'] = "The email link is invalid :(";
        }
    }
    else
        $_SESSION['error'] = "Passwords do not match";
 ?>

<HTML>
    <HEAD>
        <link rel="stylesheet" type="text/css" href="style.css">
        <TITLE>Password Reset</TITLE>
    </HEAD>
    <BODY>
        <div class="header">
            <h3>CHEESE!</h3>
            <p class="error">
                <?PHP echo $_SESSION['error']; ?>
            </p>
            <p class="success">
                <?PHP echo $_SESSION['success']; ?>
            </p>
        </div>
        <div class="form">
            <h1>Enter a new password</h1>
            <form method="POST" autocomplete="off">
                <div class="field-wrap">
                    <input type="password" placeholder="Password" name="password">
                </div>
                <div class="field-wrap">
                    <input type="password" placeholder="Confirm password" name="confirm_pass">
                </div>

                <button class="button button-block" name="passreset">Confirm</button>
                <p class="error">
                    <?PHP echo $_SESSION['message']; ?>
                </p>
            </form>
        </div>
    </BODY>
</HTML>
