<?php
include_once '../conexion.php';

$sql = "SELECT descripcion_cta, valor_debito, valor_credito FROM transaccion_contable
        INNER JOIN catalogo_cuenta_contable ON transaccion_contable.cuenta_contable = catalogo_cuenta_contable.nro_cta";
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
    <title>Balance de Comprobación</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        #searchBox {
            margin-bottom: 20px;
        }
        .total-final {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Balance de Comprobación</h1>

    <!-- Cuadro de búsqueda -->
    <input type="text" id="searchBox" class="form-control" placeholder="Buscar por descripción...">

    <!-- Tabla de balance -->
    <table class="table table-bordered" id="balanceTable">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Débito</th>
                <th>Crédito</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="descripcion"><?php echo htmlspecialchars($row['descripcion_cta']); ?></td>
                    <td><?php echo number_format($row['valor_debito'], 2); ?></td>
                    <td><?php echo number_format($row['valor_credito'], 2); ?></td>
                </tr>
                <?php 
                    $total_debito += $row['valor_debito']; 
                    $total_credito += $row['valor_credito']; 
                ?>
            <?php endwhile; ?>

            <!-- Total Débito y Total Crédito en una sola fila -->
            <tr>
                <td><strong>Total</strong></td>
                <td><?php echo number_format($total_debito, 2); ?></td>
                <td><?php echo number_format($total_credito, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Balance final fuera de la tabla -->
    <div class="total-final">
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
