<?php
include_once "../conexion.php"; 

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM usuario WHERE nombre LIKE ? OR apellidos_usuarios LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('ss', $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT); // Cifrado de clave
    $nivel_acceso = $_POST['nivel_acceso'];
    $nombre = $_POST['nombre'];
    $apellidos_usuarios = $_POST['apellidos_usuarios'];
    $email_usuario = $_POST['email_usuario'];

    $sqlInsert = "INSERT INTO usuario (usuario, clave, nivel_acceso, nombre, apellidos_usuarios, email_usuario) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('ssdsss', $usuario, $clave, $nivel_acceso, $nombre, $apellidos_usuarios, $email_usuario);

    if ($stmtInsert->execute()) {
        echo "<script>alert('usuario agregado exitosamente');</script>";
        echo "<script>window.location.href = 'usuario.php';</script>";
    } else {
        echo "<script>alert('Error al agregar usuario.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="contenido" class="container mt-5 pt-3">
        <div class="row mb-4 d-flex align-items-center">
            <div class="col-md-6">
                <h2>Gestión de usuarios</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Agregar <i class="fa-solid fa-plus"></i></button>
            </div>
            <div class="col-md-6 text-right">
                <form method="GET" action="" class="form-inline justify-content-end">
                    <div class="form-group mr-2">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por nombre o apellido" value="<?php echo htmlspecialchars($searchTerm); ?>">
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
                        <th>usuario</th>
                        <th>Nivel de Acceso</th>
                        <th>nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['nivel_acceso'] == 1 ? 'Admin' : 'usuario'); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellidos_usuarios']); ?></td>
                        <td><?php echo htmlspecialchars($row['email_usuario']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $row['ID']; ?>" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar.php?id=<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Agregar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="usuario">usuario</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="clave">clave</label>
                            <input type="password" class="form-control" name="clave" required>
                        </div>
                        <div class="form-group">
                            <label for="nivel_acceso">Nivel de Acceso</label>
                            <input type="number" class="form-control" name="nivel_acceso" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos_usuarios">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos_usuarios" required>
                        </div>
                        <div class="form-group">
                            <label for="email_usuario">Email</label>
                            <input type="email" class="form-control" name="email_usuario">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
