<?PHP
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];

    $email = $_POST['email'];
    $password = hash("whirlpool", $_POST['password']);
    echo $password;

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();

    if ($email = $db['email']) && ($db['password'] = $password) {
            header("location: home.php");
    }
    else {
            $_SESSION['message'] = 'Incorrect Password';
            header("location: error.php");
    }
?>