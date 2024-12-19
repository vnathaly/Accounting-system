<?php
include '../conexion.php'; // Ajusta la ruta al archivo de conexión

if (isset($_GET['id'])) {
    $idTipoEntrada = $_GET['id'];

    // Verificar si el tipo de entrada existe antes de intentar eliminar
    $sql = "SELECT * FROM tipos_entrada WHERE idnum = $idTipoEntrada";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        // Confirmar eliminación
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sql_delete = "DELETE FROM tipos_entrada WHERE idnum = $idTipoEntrada";
            if ($conexion->query($sql_delete) === TRUE) {
                header("Location: tipo_diario.php?msg=Tipo de entrada eliminado exitosamente");
                exit();
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $conexion->error . "</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Tipo de entrada no encontrado.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID de tipo de entrada no especificado.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Eliminar Tipo de Entrada</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Tipo de Entrada</h2>
        <p>¿Estás seguro de que deseas eliminar este tipo de entrada?</p>
        <form action="eliminar.php?id=<?php echo htmlspecialchars($idTipoEntrada); ?>" method="post">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="tipo_diario.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
