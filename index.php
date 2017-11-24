<!DOCTYPE HTML>
<?PHP
    session_start ();
    $_SESSION['error'] = '';
    $_SESSION['success'] = '';
    include 'config/database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login'])) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['hash'] = $_POST['hash'];
        
            $email = $_POST['email'];
            $password = hash("whirlpool", $_SESSION['password']);
            $hash = $_POST['hash'];
        
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $db = $stmt->fetch();
        
            if ($email == $db['email']) {
                if ($password == $db['password']) {
                    if ($db['active'] == 1) {
                        $_SESSION['uid'] = $db['uid'];
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
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['first_name'] = $_POST['first_name'];
            $_SESSION['last_name'] = $_POST['last_name'];
        
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            //Encrypts password and user hash(pk)
            $password = hash("whirlpool", $_POST['password']);
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
                $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password, verifid)
                                        VALUES (:first_name, :last_name, :email, :password, :verifid)');
                $stmt->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password,
                'verifid' => $verifid]);
        
                $subject = 'Registration to Cheese';
                $message_body = "
                Hello ".$first_name."
                
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
            <h3>CHEESE!</h3>
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
                    <input type="text" placeholder="First Name" name="first_name">
                </div>
                <div class="field-wrap">
                    <input type="text" placeholder="Last Name" name="last_name">
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
    /*    function hidelabel(lname, element) {
            if (element.value.length > 0) {
                document.getElementById(lname).style.visibility = "hidden";
            }
            else if {
                document.getElementById(lname).style.visibility = "visible";
            }
        }

        function openTab(tabName, element) {
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = 'none';
            }

            // Remove the background color of all tablinks/buttons
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }

            // Show the specific tab content
            document.getElementById(tabName).style.display = "block";

            // Add the specific color to the button used to open the tab content
            element.style.backgroundColor = "rgba(80, 113, 128, 0.966)";
            element.style.color = "#ffffff";
            element.style.textShadow = "2px 2px #2c2c2c";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        */
    </script>
</HTML>