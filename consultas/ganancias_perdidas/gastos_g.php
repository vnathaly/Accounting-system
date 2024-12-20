<?php
include_once '../conexion.php';

$sql = "SELECT * FROM catalogo_cuenta_contable";
$result = $conexion->query($sql);

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
    <style>
        #searchBox {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Consulta De Catálogo De Cuentas</h1>

    <!-- Cuadro de búsqueda -->
    <input type="text" id="searchBox" class="form-control" placeholder="Buscar por número o descripción de cuenta...">

    <!-- Tabla de catálogo -->
    <table class="table table-bordered" id="catalogoTable">
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
                    <td class="nro_cta"><?php echo htmlspecialchars($row['nro_cta']); ?></td>
                    <td class="descripcion_cta"><?php echo htmlspecialchars($row['descripcion_cta']); ?></td>
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
