<!DOCTYPE HTML>

<?PHP
    session_start();
    include 'config/database.php';
    $email = $_SESSION['email'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $db = $stmt->fetch();
    $name = $db['username'];
    
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
                    <a href="editprof.php"><button class="button button-block" name="change">EDIT</button></a>
                </h1>
            </div>
        </div>
    </BODY>
</HTML>