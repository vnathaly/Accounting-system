<?php
include_once "../conexion.php"; 

$searchTerm = isset($_GET['search']) ? $_GET['search'] : ''; // Filtro de búsqueda

// Consulta para buscar cuentas contables por descripción
$sql = "SELECT * FROM catalogo_cuenta_contable WHERE descripcion_cta LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

// Inserción de nuevas cuentas contables
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nro_cta'])) {
    // Recibiendo los datos de la cuenta contable
    $nro_cta = $_POST['nro_cta'];
    $descripcion_cta = $_POST['descripcion_cta'];
    $tipo_cta = $_POST['tipo_cta'];
    $nivel_cta = $_POST['nivel_cta'];
    $cta_padre = $_POST['cta_padre']; 
    $grupo_cta = $_POST['grupo_cta'];
    $debito_acum_cta = $_POST['debito_acum_cta'];
    $credito_acum_cta = $_POST['credito_acum_cta'];

    // Insertar nueva cuenta contable
    $sqlInsert = "INSERT INTO catalogo_cuenta_contable 
                  (nro_cta, descripcion_cta, tipo_cta, nivel_cta, cta_padre, grupo_cta, debito_acum_cta, credito_acum_cta) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('dsdddddd', $nro_cta, $descripcion_cta, $tipo_cta, $nivel_cta, $cta_padre, $grupo_cta, $debito_acum_cta, $credito_acum_cta);

    if ($stmtInsert->execute()) {
        echo "<script>alert('Cuenta contable agregada exitosamente');</script>";
        echo "<script>window.location.href = 'catalogo.php';</script>"; // Redirige a catalogo.php
    } else {
        echo "<script>alert('Error al agregar cuenta contable.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Catálogo de Cuentas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="contenido" class="container mt-5 pt-3">
        <div class="row mb-4 d-flex align-items-center">
            <div class="col-md-6">
                <h2>Gestión de Catálogo de Cuentas</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addAccountModal">Agregar<i class="fa-solid fa-plus"></i></button>
            </div>
            <div class="col-md-6 text-right">
                <form method="GET" action="" class="form-inline justify-content-end">
                    <div class="form-group mr-2">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por descripción" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    </div>                    
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nro Cuenta</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Nivel</th>
                        <th>Cuenta Padre</th>
                        <th>Grupo</th>
                        <th>Débito Acum.</th>
                        <th>Crédito Acum.</th>
                        <th>Balance</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nro_cta']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion_cta']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_cta'] ? 'Activa' : 'Pasiva'); ?></td>
                        <td><?php echo htmlspecialchars($row['nivel_cta']); ?></td>
                        <td><?php echo htmlspecialchars($row['cta_padre'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['grupo_cta']); ?></td>
                        <td><?php echo htmlspecialchars($row['debito_acum_cta']); ?></td>
                        <td><?php echo htmlspecialchars($row['credito_acum_cta']); ?></td>
                        <td><?php echo htmlspecialchars($row['debito_acum_cta'] - $row['credito_acum_cta']); ?></td>
                        <td>
                            <a href="editar.php?nro_cta=<?php echo $row['nro_cta']; ?>" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar.php?nro_cta=<?php echo $row['nro_cta']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar cuenta -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" role="dialog" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel">Agregar Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="catalogo.php" method="post">
                        <div class="form-group">
                            <label for="nro_cta">Nro Cuenta:</label>
                            <input type="number" class="form-control" id="nro_cta" name="nro_cta" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_cta">Descripción:</label>
                            <input type="text" class="form-control" id="descripcion_cta" name="descripcion_cta" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_cta">Tipo de Cuenta:</label>
                            <select class="form-control" id="tipo_cta" name="tipo_cta" required>
                                <option value="1">Activo</option>
                                <option value="0">Pasivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nivel_cta">Nivel:</label>
                            <input type="number" class="form-control" id="nivel_cta" name="nivel_cta" required>
                        </div>
                        <div class="form-group">
                            <label for="cta_padre">Cuenta Padre:</label>
                            <input type="number" class="form-control" id="cta_padre" name="cta_padre">
                        </div>
                        <div class="form-group">
                            <label for="grupo_cta">Grupo:</label>
                            <input type="number" class="form-control" id="grupo_cta" name="grupo_cta" required>
                        </div>
                        <div class="form-group">
                            <label for="debito_acum_cta">Débito Acumulado:</label>
                            <input type="number" class="form-control" id="debito_acum_cta" name="debito_acum_cta" required oninput="calcularBalance()">
                        </div>
                        <div class="form-group">
                            <label for="credito_acum_cta">Crédito Acumulado:</label>
                            <input type="number" class="form-control" id="credito_acum_cta" name="credito_acum_cta" required oninput="calcularBalance()">
                        </div>
                        <div class="form-group">
                            <label for="balance_cta">Balance:</label>
                            <input type="number" class="form-control" id="balance_cta" name="balance_cta" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calcularBalance() {
            const debito = parseFloat(document.getElementById('debito_acum_cta').value) || 0;
            const credito = parseFloat(document.getElementById('credito_acum_cta').value) || 0;
            document.getElementById('balance_cta').value = debito - credito;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
