
<?php
$host = '127.0.0.1';
$port = '3307';
$dbname = 'ecole';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>