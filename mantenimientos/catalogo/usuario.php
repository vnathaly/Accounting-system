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
        echo "<script>alert('Usuario agregado exitosamente." . $_POST['clave'] ." hhh');</script>";
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
    <title>Gestión de Usuarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilo.css">
    <style>
        .col-acciones {
            text-align: center;
        }
        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>
<div id="contenido" class="container mt-5 pt-5">
<body class="cuerpo">
    <div class="container mt-5">
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

        <div class="row">
            <!-- Tabla de usuarios -->
            <div class="col-md-12">
                <div class="table-wrapper">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nivel de Acceso</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th class="col-acciones">Acciones</th>
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
                                <td class="col-acciones">
                                <a href="editar.php?id=<?php echo $row['ID']; ?>" class="btn btn-warning btn-sm btn-edit-user" 
                                data-id="<?php echo $row['ID']; ?>" 
                                data-usuario="<?php echo htmlspecialchars($row['usuario']); ?>"
                                data-nivel_acceso="<?php echo htmlspecialchars($row['nivel_acceso']); ?>"
                                data-nombre="<?php echo htmlspecialchars($row['nombre']); ?>"
                                data-apellidos_usuarios="<?php echo htmlspecialchars($row['apellidos_usuarios']); ?>"
                                data-email_usuario="<?php echo htmlspecialchars($row['email_usuario']); ?>"
                              >
                                <i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="eliminar.php?id=<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');"><i class="fa-solid fa-delete-left"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
                    <form method="POST" action="" class="insert-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Usuario:</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                                </div>
                                <div class="form-group">
                                    <label for="clave">Clave:</label>
                                    <input type="password" class="form-control" id="clave" name="clave" required>
                                </div>
                                <div class="form-group">
                                    <label for="nivel_acceso">Nivel de Acceso:</label>
                                    <input type="number" class="form-control" id="nivel_acceso" name="nivel_acceso" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="apellidos_usuarios">Apellidos:</label>
                                    <input type="text" class="form-control" id="apellidos_usuarios" name="apellidos_usuarios" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_usuario">Email:</label>
                                    <input type="email" class="form-control" id="email_usuario" name="email_usuario">
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="usuario.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- El formulario de edición se llenará con los datos correspondientes -->
                <form method="POST" action="editar.php" class="edit-form">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-usuario">Usuario:</label>
                        <input type="text" class="form-control" id="edit-usuario" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-nivel_acceso">Nivel de Acceso:</label>
                        <input type="number" class="form-control" id="edit-nivel_acceso" name="nivel_acceso" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-nombre">Nombre:</label>
                        <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-apellidos_usuarios">Apellidos:</label>
                        <input type="text" class="form-control" id="edit-apellidos_usuarios" name="apellidos_usuarios" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-email_usuario">Email:</label>
                        <input type="email" class="form-control" id="edit-email_usuario" name="email_usuario">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Enlace a Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</div>
</html>
