<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$id = $_GET['id'];

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
