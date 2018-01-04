<!DOCTYPE HTML>
<?PHP
    session_start ();
    echo $_SESSION['uid'];
    echo $_POST['password'];
    $_SESSION['error'] = '';
    $_SESSION['success'] = '';
    include 'config/database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login'])) {
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['hash'] = $_POST['hash'];
        
            $email = $_POST['email'];
            $password = hash("whirlpool", $_POST['password']);
            $hash = $_POST['hash'];
        
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $db = $stmt->fetch();
        
            if ($email == $db['email']) {
                if ($password == $db['password']) {
                    if ($db['active'] == 1) {
                        $_SESSION['uid'] = $db['uid'];
                        $_SESSION['username'] = $db['username'];
                        $_SESSION['email'] = $db['email'];
                        header("location: home.php");
                    }
                    else {
                        $_SESSION['error'] = 'User has not been activated';
                    }
                }
                else {
                    $_SESSION['error'] = 'Incorrect Password';
                }
            }
            else {
                $_SESSION['error'] = 'User does not exist. Please Register';
            }
        }
        else if (isset($_POST['signup'])) {
        
            $username = strip_tags($_POST['username']);
            $email = $_POST['email'];
            //Encrypts password and user hash(pk)
            $pattern = "^(?=.*[A-Z]+)\S{6,}$";
            $password = $_POST['password'];
            $password_check = preg_match('/^[a-zA-Z0-9!@#$%^&*()_]{4,200}$/i', $password);
            if (!preg_match('/[A-Z]/', $password))
            {
                header("Location: index.php?password=noUpper");
                exit();
            }
            if (!preg_match('/[a-z]/', $password))
            {
                header("Location: index.php?password=noLower");
                exit();
            }
            if (!$password_check)
            {
                header("Location: index.php?password=invalid");
                exit();
            }
            $password = hash("whirlpool", $password);
            $verifid = rand();
            //Query to check email existence
            
        
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $db = $stmt->fetch();
            //Checks email. If empty display message
            if ($db['email'] != NULL) {
                $_SESSION['error'] = 'User already exists';
            }
            //User doesnt exist. Continues
            else {
                $stmt = $pdo->prepare('INSERT INTO users (username, email, password, verifid)
                                        VALUES (:username, :email, :password, :verifid)');
                $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'verifid' => $verifid]);
        
                $subject = 'Registration to Cheese';
                $message_body = "
                Hello ".$username."
                
                Please click the link below to verify your account.
                
                http://localhost:8080/camagru/verify.php?email=$email&verifid=$verifid";
        
                mail($email, $subject, $message_body, 'From: donotreply@cheeseprod.com');
                $_SESSION['succheader'] = "You've successfully registered!";
                $_SESSION['succbody'] = "Please follow the link sent to $email to verify your account";
                header("location: success.php");
            }
        }
    }
?>

<HTML>
    <HEAD>
        <link rel="stylesheet" type="text/css" href="style.css">
        <TITLE>
            Login
        </TITLE>
    </HEAD>
    
    <BODY>
    <div class="header">
        <div>
            <h3>CHEESE!</h3>
        </div>
        <div class='public'>
                <a href="uploads.php">PUBLIC GALLERY</a>
            </div>
            <p class="error">
                <?PHP echo $_SESSION['error']; ?>
            </p>
            <p class="success">
                <?PHP echo $_SESSION['success']; ?>
            </p>

        </div>
    <div class="form">
        <a href="#signup">
            <button class="tablink" id="defaultOpen" onclick="openTab('signup', this)">Sign Up</button>
        </a>
        <a href="#login">
            <button class="tablink" onclick="openTab('login', this)">Log In</button>
        </a>
        <div id="login" class="tabcontent">
            <h1>WELCOME BACK!</h1>

            <form method="POST" autocomplete="off">
                <div class="field-wrap">
                    <!--label id="Email">Email</label-->
                    <input type="email" name="email" placeholder="Email Address">
                </div>

                <div class="field-wrap">
                    <!--label id="Password">Password</label-->
                    <input type="password" name="password" placeholder="Password">    
                </div>
                <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
          
                <button class="button button-block" name="login"/>Log In</button>
            </form>

        </div>
            
        <div id="signup" class="tabcontent">
            <h1>SIGN UP TO CHEESE</h1>
            
            <form method="POST" autocomplete="off">
                <div class="field-wrap">
                    <input type="text" placeholder="User Name" name="username">
                </div>
                <div class="field-wrap">
                    <input type="email" placeholder="Email Address" name="email">
                </div>
                <div class="field-wrap">
                    <input type="password" placeholder="Password" name="password">
                </div>

                <button class="button button-block" name="signup"/>Sign Up</button>
            </form>

        </div>
    </div>
    </BODY>
    <script src="js/scripts.js">

    </script>
</HTML>