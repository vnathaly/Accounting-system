<?php
include_once '../conexion.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT descripcion_cta, valor_credito FROM transaccion_contable
        INNER JOIN catalogo_cuenta_contable ON transaccion_contable.cuenta_contable = catalogo_cuenta_contable.nro_cta
        WHERE descripcion_cta LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance General</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Balance General de Gastos</h1>

    <!-- Formulario de búsqueda por descripción -->
    <form method="GET" action="" class="form-inline mb-3 justify-content-end">
        <input type="text" name="search" class="form-control mr-2" placeholder="Buscar por descripción" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Tabla de gastos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Crédito</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['descripcion_cta']); ?></td>
                    <td><?php echo number_format($row['valor_credito'], 2); ?></td>
                </tr>
                <?php $total += $row['valor_credito']; ?>
            <?php endwhile; ?>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>
    <form action="http://127.0.0.1/Yovanny/login/inicio.php" method="get">
                      <button type="submit" class="btn-salir">Salir</button>
                    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
