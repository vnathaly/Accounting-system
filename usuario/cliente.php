<?php

include_once "conexion.php"; 

// Obtener el término de búsqueda
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Obtener la lista de usuarios con la opción de búsqueda
$sql = "SELECT * FROM usuario WHERE nombre LIKE ? OR apellidos_usuarios LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('ss', $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

$isDirectAccess = basename($_SERVER['PHP_SELF']) == basename(__FILE__);

// session_start();
// if (!isset($_SESSION['usuario'])) {
//     header('Location: ../login/login.php');
//     exit;
// }

$loggedInUser = $_SESSION['usuario'];
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
                                <th>Clave</th>
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
                                <td><?php echo htmlspecialchars($row['clave']); ?></td>
                                <td><?php echo htmlspecialchars($row['nivel_acceso']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['apellidos_usuarios']); ?></td>
                                <td><?php echo htmlspecialchars($row['email_usuario']); ?></td>
                                <td class="col-acciones">
                                    <a href="#" class="btn btn-warning btn-sm btn-edit-user" data-id="<?php echo $row['ID']; ?>" data-toggle="modal" data-target="#editUserModal"><i class="fa-solid fa-pen-to-square"></i></a>
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
                    <!-- Contenido del formulario para agregar usuario -->
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
                    <!-- Contenido del formulario para editar usuario -->
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
