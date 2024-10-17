<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, cantidad = ? WHERE id = ?");
        $stmt->execute([$_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['cantidad'], $id]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="edit.php?id=<?= $id ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= $producto['nombre'] ?>" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?= $producto['descripcion'] ?></textarea>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" value="<?= $producto['precio'] ?>" required>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" value="<?= $producto['cantidad'] ?>" required>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
