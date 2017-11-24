<?PHP
    session_start();
    echo $_SESSION['error'];
?>

<!DOCTYPE HTML>
<HTML>
    <link rel="stylesheet" type="text/css" href="style.css">
    <TITLE>Error</TITLE>
    <BODY>
        <div class="form">
            <h1>Error</h1>
            <p class="error">
                <?PHP
                if (isset($_SESSION['error']) AND !empty($_SESSION['error'])) {
                    echo $_SESSION['error'];
                }
                else {
                    echo "Nothing to see here...";
                }
                ?>
            </p>
        <a href="index.php"><button class="button button-block"/>Home</button></a>
        </div>
    </BODY>
</HTML>