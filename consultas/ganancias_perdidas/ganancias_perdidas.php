<?php
include_once '../conexion.php';

$sql = "SELECT ccc.descripcion_cta, 
               SUM(tc.valor_debito) AS total_debito, 
               SUM(tc.valor_credito) AS total_credito, 
               (SUM(tc.valor_debito) - SUM(tc.valor_credito)) AS balance
        FROM transaccion_contable tc
        INNER JOIN catalogo_cuenta_contable ccc ON tc.cuenta_contable = ccc.nro_cta
        GROUP BY ccc.descripcion_cta";
$result = $conexion->query($sql);

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

$total_debito = 0;
$total_credito = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance de Ganancias y Pérdidas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        #searchBox {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Balance de Ganancias y Pérdidas</h1>

    <!-- Cuadro de búsqueda -->
    <input type="text" id="searchBox" class="form-control" placeholder="Buscar por descripción...">

    <!-- Tabla de balance -->
    <table class="table table-bordered" id="balanceTable">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Débito</th>
                <th>Crédito</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="descripcion"><?php echo htmlspecialchars($row['descripcion_cta']); ?></td>
                    <td><?php echo number_format($row['total_debito'], 2); ?></td>
                    <td><?php echo number_format($row['total_credito'], 2); ?></td>
                    <td><?php echo number_format($row['balance'], 2); ?></td>
                </tr>
                <?php 
                    $total_debito += $row['total_debito'];
                    $total_credito += $row['total_credito'];
                ?>
            <?php endwhile; ?>

            <!-- Fila de Totales -->
            <tr>
                <td><strong>Totales</strong></td>
                <td><?php echo number_format($total_debito, 2); ?></td>
                <td><?php echo number_format($total_credito, 2); ?></td>
                <td><?php echo number_format($total_debito - $total_credito, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Total fuera del cuadro -->
    <div class="text-right">
        <strong>Balance Final:</strong> $<?php echo number_format($total_debito - $total_credito, 2); ?>
    </div>
    <form action="http://127.0.0.1/Yovanny/login/inicio.php" method="get">
                      <button type="submit" class="btn-salir">Salir</button>
                    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Filtro de búsqueda -->
<script>
    document.getElementById('searchBox').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#balanceTable tbody tr');

        rows.forEach(row => {
            const descripcion = row.querySelector('.descripcion').textContent.toLowerCase();
            if (descripcion.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
