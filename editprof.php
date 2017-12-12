<!DOCTYPE HTML>

<?PHP
    session_start();
    include 'config/database.php';
    $email = $_SESSION['email'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();
    $name = $db['username'];
    $uid = $db['uid'];    
?>

<HTML>
    <HEAD>
        <link rel="stylesheet" type="text/css" href="style.css">
        <TITLE>Profile</TITLE>
    </HEAD>
    <BODY onload="init();">
        <div class="header">
            <h2>CHEESE!</h2>
            <div class="nav">
                <a href="home.php">HOME</a>   |   
                <a href="uploads.php">UPLOADS</a>   |   
                <a href="profile.php">PROFILE</a>   |   
                <a href="index.php">LOG OUT</a>
            </div>
            <div class="welcome">
                Logged in as <?PHP echo $name; ?>
            </div>
            <div class="form">
                <form method="POST">
                    <h3>YOUR PROFILE</h3>
                    </br>
                    <h1>
                        USERNAME </br>
                        <div class="profile">
                            <input type="text" value="<?PHP echo $name; ?>" placeholder="User Name" name="username" > </br>
                        </div>
                        </br>
                        EMAIL ADDRESS </br>
                        <div class="profile">
                            <input type="email" value="<?PHP echo $email; ?>" placeholder="Email Address" name="email"> </br>
                        </div>
                        </br>
                        <button class="button button-block" name="change">SUBMIT</button>
                        <?PHP 
                            $newname = $_POST['username'];
                            $newmail = $_POST['email'];
                            if ($newname == NULL) {
                                $newname = $name;
                            }
                            if ($newmail == NULL) {
                                $newmail = $email;
                            }
                            $stmt = $pdo->prepare('UPDATE users SET username=:username, email=:email WHERE uid=:userid');
                            $stmt->execute([
                                'username' => $newname,
                                'email' => $newmail,
                                'userid' => $uid
                            ]);
                        ?>
                    </h1>
                    <p class="change"> <a href="forgot.php">Change Password</a> </p>
                </form>
            </div>
        </div>
    </BODY>
</HTML>