<?php
include_once "../conexion.php"; 

// Buscar por descripción
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta para obtener los registros de tipos_entrada
$sql = "SELECT * FROM tipos_entrada WHERE descripcion LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

// Procesar la inserción de nuevos registros
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['descripcion'])) {
    $descripcion = $_POST['descripcion'];

    $sqlInsert = "INSERT INTO tipos_entrada (descripcion) VALUES (?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('s', $descripcion);

    if ($stmtInsert->execute()) {
        echo "<script>alert('Tipo de entrada agregado exitosamente');</script>";
        echo "<script>window.location.href = 'tipo_diario.php';</script>";
    } else {
        echo "<script>alert('Error al agregar tipo de entrada.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de tipos de entrada</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="contenido" class="container mt-5 pt-3">
        <div class="row mb-4 d-flex align-items-center">
            <div class="col-md-6">
                <h2>Gestión de tipos de entrada</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addEntryModal">Agregar <i class="fa-solid fa-plus"></i></button>
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
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['idnum']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $row['idnum']; ?>" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar.php?id=<?php echo $row['idnum']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
        <form action="http://127.0.0.1/Yovanny/login/inicio.php" method="get">
                      <button type="submit" class="btn-salir">Salir</button>
                    </form>
        </div>
    </div>

    <div class="modal fade" id="addEntryModal" tabindex="-1" role="dialog" aria-labelledby="addEntryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEntryModalLabel">Agregar tipo de entrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
        <form action="http://127.0.0.1/Yovanny/login/inicio.php" method="get">
                      <button type="submit" class="btn-salir">Salir</button>
                    </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
