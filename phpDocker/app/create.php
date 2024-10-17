<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['cantidad']]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Añadir Nuevo Producto</h1>
    <form action="create.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required>
        <br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
