<?php
include 'conexion.php'; // Ajusta la ruta al archivo de conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $nivel_acceso = $_POST['nivel_acceso'];
    $nombre = $_POST['nombre'];
    $apellidos_usuarios = $_POST['apellidos_usuarios'];
    $email_usuario = $_POST['email_usuario'];

    // Preparar la consulta de inserción
    $sql = "INSERT INTO usuario (usuario, clave, nivel_acceso, nombre, apellidos_usuarios, email_usuario) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisss', $usuario, $clave, $nivel_acceso, $nombre, $apellidos_usuarios, $email_usuario);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el usuario.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Agregar Usuario</title>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="insert-form-title">Agregar Usuario</h2>
            <form id="insertUserForm" class="insert-form">
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
                        <a href="cliente.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para mostrar mensaje de éxito -->
    <div class="modal fade insert-modal" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¡Usuario guardado exitosamente!</p>
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
            $('#insertUserForm').on('submit', function (e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                $.ajax({
                    url: 'insertar.php',
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
                        alert('Error al guardar el usuario.');
                    }
                });
            });
        });
    </script>
</body>
</html>
