<?php
$host = '127.0.0.1';
$port = '3307';
$user = 'root';
$dbname = 'ecole';

$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port"dbname=$dbname, $user, $pass);

    
    echo "MySQL Connected ✅";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>