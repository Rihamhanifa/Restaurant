<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = file_get_contents('database.sql');
    $pdo->exec($sql);
    
    echo "Database initialized successfully!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
