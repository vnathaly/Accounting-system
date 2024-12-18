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
        echo "<script>alert('Usuario agregado exitosamente');</script>";
        echo "<script>window.location.href = 'catalogo.php';</script>";
    } else {
        echo "<script>alert('Error al agregar al catalogo.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(to right, #2c3e50, #4ca1af);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: #ffffff;
            color: #333;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #2c3e50;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #4ca1af;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3b8d99;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-warning {
            background-color: #f39c12;
            border: none;
        }

        .table {
            color: #333;
            background: #ffffff;
            border-radius: 5px;
            overflow: hidden;
        }

        .table th {
            background: #2c3e50;
            color: #fff;
        }

        .table td {
            vertical-align: middle;
        }

        input.form-control {
            border: 1px solid #4ca1af;
        }

        .modal-content {
            color: #333;
        }

        .modal-header {
            background: #4ca1af;
            color: #fff;
            border-bottom: 2px solid #3b8d99;
        }

        .modal-title {
            font-weight: bold;
        }

        .close {
            color: #fff;
        }

        .form-control:focus {
            border-color: #3b8d99;
            box-shadow: 0 0 5px rgba(75, 161, 175, 0.8);
        }
    </style>
</head>
<body>
    <div id="contenido" class="container mt-5 pt-3">
        <div class="row mb-4 d-flex align-items-center">
            <!-- Botón para abrir el modal de agregar a la izquierda -->
            <div class="col-md-6">
                <h2>Gestión de Usuarios</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Agregar <i class="fa-solid fa-plus"></i></button>
            </div>
            <!-- Formulario de búsqueda a la derecha -->
            <div class="col-md-6 text-right">
                <form method="GET" action="" class="form-inline justify-content-end">
                    <div class="form-group mr-2">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por nombre o apellido" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nivel de Acceso</th>
                        <th>Nombre</th>
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
                        <td><?php echo htmlspecialchars($row['nivel_acceso'] == 1 ? 'Admin' : 'Usuario'); ?></td>
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

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="clave">Clave</label>
                            <input type="password" class="form-control" name="clave" required>
                        </div>
                        <div class="form-group">
                            <label for="nivel_acceso">Nivel de Acceso</label>
                            <input type="number" class="form-control" name="nivel_acceso" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
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
