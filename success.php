<!DOCTYPE HTML>

<?php
    session_start();

    $email = $_SESSION['email'];
    //if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
     //   header("Location: index.php");
   // }
?>
<HTML>
    <HEAD>
        <link rel="stylesheet" type="text/css" href="style.css">
    </HEAD>

    <BODY>
        <div class='form'>
            <h1><?PHP echo $_SESSION['succheader']; ?></h1>
            <p class="success">
                <?PHP echo $_SESSION['succbody']; ?>
            </p>
            <a href="index.php#login"><button class="button button-block" name="home">HOME</button></a>
        </div>
    </BODY>
        <script src="js/index.js"></script>
<HTML>