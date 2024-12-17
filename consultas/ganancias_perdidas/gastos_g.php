<?php
include_once '../conexion.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM catalogo_cuenta_contable WHERE nro_cta LIKE ? OR descripcion_cta LIKE ? ";
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
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Consulta De Catalogo De Actas</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="" class="form-inline mb-3 justify-content-end">
        <input type="text" name="search" class="form-control mr-2" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Tabla de clientes -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nro_cta</th>
                <th>Descripcion_cta</th>
                <th>Tipo_cta</th>
                <th>Nivel_cta</th>
                <th>Fecha_creacion_cta</th>
                <th>Debito_acum_cta</th>
                <th>Credito_acum_cta</th>
                <th>Balance_cta</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nro_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['nivel_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_creacion_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['debito_acum_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['credito_acum_cta']); ?></td>
                    <td><?php echo htmlspecialchars($row['balance_cta']); ?></td>
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
