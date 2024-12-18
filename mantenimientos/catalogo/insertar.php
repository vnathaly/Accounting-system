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
    $cta_padre = $_POST['cta_padre']; // Puede ser NULL si no tiene cuenta padre
    $grupo_cta = $_POST['grupo_cta'];
    $fecha_creacion_cta = $_POST['fecha_creacion_cta'];
    $hora_creacion_cta = $_POST['hora_creacion_cta'];

    // Insertar nueva cuenta contable
    $sqlInsert = "INSERT INTO catalogo_cuenta_contable 
                  (nro_cta, descripcion_cta, tipo_cta, nivel_cta, cta_padre, grupo_cta, fecha_creacion_cta, hora_creacion_cta) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('isiiisis', $nro_cta, $descripcion_cta, $tipo_cta, $nivel_cta, $cta_padre, $grupo_cta, $fecha_creacion_cta, $hora_creacion_cta);

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Catálogo de Cuentas Contables</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Catálogo de Cuentas Contables</h2>
        
        <!-- Formulario de búsqueda -->
        <form method="get" action="catalogo.php" class="form-inline mb-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar por descripción" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit" class="btn btn-primary ml-2">Buscar</button>
        </form>

        <!-- Mostrar las cuentas contables -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th># Cuenta</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Nivel</th>
                    <th>Cuenta Padre</th>
                    <th>Grupo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['nro_cta']; ?></td>
                        <td><?php echo $row['descripcion_cta']; ?></td>
                        <td><?php echo $row['tipo_cta'] == 1 ? 'Activo' : 'Pasivo'; ?></td>
                        <td><?php echo $row['nivel_cta']; ?></td>
                        <td><?php echo $row['cta_padre'] ? $row['cta_padre'] : 'N/A'; ?></td>
                        <td><?php echo $row['grupo_cta']; ?></td>
                        <td>
                            <a href="editar.php?nro_cta=<?php echo $row['nro_cta']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar.php?nro_cta=<?php echo $row['nro_cta']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Formulario para agregar una nueva cuenta contable -->
        <h3>Agregar Nueva Cuenta</h3>
        <form action="catalogo.php" method="post">
            <div class="form-group">
                <label for="nro_cta"># Cuenta:</label>
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
                <label for="nivel_cta">Nivel de Cuenta:</label>
                <input type="number" class="form-control" id="nivel_cta" name="nivel_cta" required>
            </div>
            <div class="form-group">
                <label for="cta_padre">Cuenta Padre (Opcional):</label>
                <input type="number" class="form-control" id="cta_padre" name="cta_padre">
            </div>
            <div class="form-group">
                <label for="grupo_cta">Grupo de Cuenta:</label>
                <input type="number" class="form-control" id="grupo_cta" name="grupo_cta" required>
            </div>
            <div class="form-group">
                <label for="fecha_creacion_cta">Fecha de Creación:</label>
                <input type="date" class="form-control" id="fecha_creacion_cta" name="fecha_creacion_cta" required>
            </div>
            <div class="form-group">
                <label for="hora_creacion_cta">Hora de Creación:</label>
                <input type="time" class="form-control" id="hora_creacion_cta" name="hora_creacion_cta" required>
            </div>
            <button type="submit" class="btn btn-success">Agregar Cuenta</button>
        </form>
    </div>
</body>
</html>
