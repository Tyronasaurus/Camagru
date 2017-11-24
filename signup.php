<?PHP
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    //Encrypts password and user hash(pk)
    $password = hash("whirlpool", $_POST['password']);

    //Query to check email existence
    
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $row = $stmt->fetch();
    //Checks email. If empty display message
    if ($row['email'] != NULL) {
        $_SESSION['message'] = 'User already exists';
        header ("location: error.php");
    }
    //User doesnt exist. Continues
    else {
        $stmt = $pdo->prepare('INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`)
                                VALUES (:first_name, :last_name, :email, :password)');
        $stmt->execute([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => $password]);
    }
    $to      = $email;
    $subject = 'Account Verification';
    $message_body = '
    Hello '.$first_name.',

    Thank you for signing up!

    Please click this link to activate your account:

    http://localhost/camagru/verify.php?email='.$email.'&id='.$id;  

    mail( $to, $subject, $message_body );

    echo "sent";

?>