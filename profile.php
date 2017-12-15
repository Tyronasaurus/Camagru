<!DOCTYPE HTML>

<?PHP
    session_start();
    include 'config/database.php';
    $email = $_SESSION['email'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();
    $name = $db['username'];
    $emailnotif = $db['email_notif'];
    if ($emailnotif == 1) {
        $checked = 'ON';
    }
    else {
        $checked = 'OFF';
    }
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
                <?PHP if ($name != NULL) { ?>
                    Logged in as <?PHP echo $name;?>
                <?PHP } else { ?>
                    Not logged in
                <?PHP } ?> 
            </div>
            <div class="form">
                <h3>YOUR PROFILE</h3>
                </br>
                <h1>
                    USERNAME </br>
                    <div class="profile">
                        <?PHP echo $name; ?> </br>
                    </div>
                    </br>
                    EMAIL ADDRESS </br>
                    <div class="profile">
                        <?PHP echo $email; ?> </br>
                    </div>
                    </br>
                    NOTIFICATIONS <br>
                    <div class="profile">
                        <?= $checked ?>
                    </div>
                    </br>
                    <a href="editprof.php"><button class="button button-block" name="change">EDIT</button></a>
                </h1>
            </div>
        </div>
    </BODY>
</HTML>