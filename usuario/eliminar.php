<?php
include 'conexion.php'; // Ajusta la ruta al archivo de conexión

if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Verificar si el usuario existe antes de intentar eliminar
    $sql = "SELECT * FROM usuario WHERE ID = $idUsuario";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sql_delete = "DELETE FROM usuario WHERE ID = $idUsuario";
            if ($conexion->query($sql_delete) === TRUE) {
                header("Location: cliente.php?msg=Usuario eliminado exitosamente");
                exit();
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $conexion->error . "</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Usuario no encontrado.</div>";
        exit();
    }
} else {
      echo "<div class='alert alert-danger' role='alert'>ID de usuario no especificado.</div>";
      exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Eliminar Usuario</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Usuario</h2>
        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
        <form action="eliminar.php?id=<?php echo htmlspecialchars($idUsuario); ?>" method="post">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="cliente.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
