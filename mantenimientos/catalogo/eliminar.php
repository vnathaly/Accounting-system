<?php
include '../conexion.php'; // Ajusta la ruta al archivo de conexión

if (isset($_GET['nro_cta'])) {
    $nroCta = $_GET['nro_cta']; // ID de la cuenta contable (nro_cta)

    // Verificar si la cuenta contable existe antes de intentar eliminar
    $sql = "SELECT * FROM catalogo_cuenta_contable WHERE nro_cta = $nroCta";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        // Verificar si se ha enviado la solicitud de eliminación
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Eliminar la cuenta contable
            $sql_delete = "DELETE FROM catalogo_cuenta_contable WHERE nro_cta = $nroCta";
            if ($conexion->query($sql_delete) === TRUE) {
                header("Location: catalogo.php?msg=Cuenta eliminada exitosamente");
                exit();
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $conexion->error . "</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Cuenta contable no encontrada.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Número de cuenta no especificado.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Eliminar Cuenta Contable</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Cuenta Contable</h2>
        <p>¿Estás seguro de que deseas eliminar esta cuenta contable?</p>
        <form action="eliminar.php?nro_cta=<?php echo htmlspecialchars($nroCta); ?>" method="post">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="catalogo.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
