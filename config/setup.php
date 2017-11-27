<?PHP 
    session_start();
    include 'config/database.php';
    $string = file_get_contents(db_Create/db_Create.sql);
    $stmt= $pdo->prepare($string);
    $stmt->execute();
    
?>