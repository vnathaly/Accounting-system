<?php
include_once "conexion.php"; 

session_start();

if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
    echo "ID recibido: " . $ID;
    
    $sql = $conexion->query("SELECT * FROM usuario WHERE ID = $ID");
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Usuario no encontrado.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID de usuario no especificado.</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
    $apellidos_usuarios = $_POST['apellidos_usuarios'];
    $usuario_nombre = $_POST['usuario'];
    $clave = $_POST['clave'];
    $nivel_acceso = $_POST['nivel_acceso'];
    $email_usuario = $_POST['email_usuario'];

    $sql = "UPDATE usuario SET 
            usuario = '$usuario_nombre',
            clave = '$clave',
            nivel_acceso = $nivel_acceso,
            nombre = '$nombre',
            apellidos_usuarios = '$apellidos_usuarios',
            email_usuario = '$email_usuario'
            WHERE ID = $ID";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => $conexion->error]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css"> <!-- Enlace a la hoja de estilo externa -->
    <title>Editar Usuario</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Usuario</h2>
        <form id="editUserForm" action="editar.php?ID=<?php echo htmlspecialchars($usuario['ID']); ?>" method="post">
            <!-- Formulario de edición -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="apellidos_usuarios">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos_usuarios" name="apellidos_usuarios" value="<?php echo htmlspecialchars($usuario['apellidos_usuarios']); ?>" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>
            </div>
            <div class="form-group">
                <label for="clave">Clave:</label>
                <input type="password" class="form-control" id="clave" name="clave" value="<?php echo htmlspecialchars($usuario['clave']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nivel_acceso">Nivel de Acceso:</label>
                <input type="number" class="form-control" id="nivel_acceso" name="nivel_acceso" value="<?php echo htmlspecialchars($usuario['nivel_acceso']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email_usuario">Email:</label>
                <input type="email" class="form-control" id="email_usuario" name="email_usuario" value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="cliente.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Modal para mostrar mensaje de éxito -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¡Usuario actualizado exitosamente!</p>
                </div>
                <div class="modal-footer">
                    <a href="cliente.php" class="btn btn-primary">Aceptar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script para manejar el formulario y mostrar el modal -->
    <script>
        $(document).ready(function () {
            $('#editUserForm').on('submit', function (e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#successModal').modal('show'); // Mostrar el modal de éxito
                        } else {
                            alert(response.message); // Mostrar mensaje de error
                        }
                    },
                    error: function() {
                        alert('Error al actualizar el usuario.');
                    }
                });
            });
        });
    </script>
</body>
</html>
