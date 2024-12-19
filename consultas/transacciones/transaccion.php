<?php
include_once '../conexion.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM cabecera_transaccion_contable WHERE nro_docu LIKE ? OR fecha_docu LIKE ? ";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('ss', $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
  die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Clientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Consulta de Transacciones</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="" class="form-inline mb-3 justify-content-end">
        <input type="text" name="search" class="form-control mr-2" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Tabla de clientes -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nro_doc</th>
                <th>Tipo Entrada</th>
                <th>Fecha</th>
                <th>Tipo Documento</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Actualización</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nro_docu']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_docu']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_docu']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion_docu']); ?></td>
                    <td><?php echo htmlspecialchars($row['monto_transaccion']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_actualizacion']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
