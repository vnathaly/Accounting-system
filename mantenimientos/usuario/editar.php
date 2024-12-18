<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
include_once "../conexion.php"; 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $usuario = $_POST['usuario'];
    $nivel_acceso = $_POST['nivel_acceso'];
    $nombre = $_POST['nombre'];
    $apellidos_usuarios = $_POST['apellidos_usuarios'];
    $email_usuario = $_POST['email_usuario'];

    $sqlInsert = "UPDATE usuario SET usuario = ?, nivel_acceso = ?, nombre = ?, apellidos_usuarios = ?, email_usuario = ? WHERE id =".$_GET['id'];
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('sdsss', $usuario, $nivel_acceso, $nombre, $apellidos_usuarios, $email_usuario);

    if ($stmtInsert->execute()) {
        echo "<script>alert('Usuario editado exitosamente);</script>";
        echo "<script>window.location.href = 'usuario.php';</script>";
    } else {
        echo "<script>alert('Error al editar usuario.');</script>";
    }

}

$sql = $conexion->query("SELECT * FROM usuario WHERE id=" . $_GET['id']);
$usuario = $sql->fetch_object();
?>

<!-- Modal para editar usuario -->
<div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de edición -->
                <form method="POST" action="" class="edit-form">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-usuario">Usuario:</label>
                        <input type="text" class="form-control" id="edit-usuario" name="usuario" required value=<?php echo $usuario->usuario?>>
                    </div>
                    <!-- <div class="form-group">
                        <label for="edit-clave">Clave:</label>
                        <input type="password" class="form-control" id="edit-clave" name="clave" required>
                    </div> -->
                    <div class="form-group">
                        <label for="edit-nivel_acceso">Nivel de Acceso:</label>
                        <input type="number" class="form-control" id="edit-nivel_acceso" name="nivel_acceso" required value=<?php echo $usuario->nivel_acceso?>>
                    </div>
                    <div class="form-group">
                        <label for="edit-nombre">Nombre:</label>
                        <input type="text" class="form-control" id="edit-nombre" name="nombre" required value=<?php echo $usuario->nombre?>>
                    </div>
                    <div class="form-group">
                        <label for="edit-apellidos_usuarios">Apellidos:</label>
                        <input type="text" class="form-control" id="edit-apellidos_usuarios" name="apellidos_usuarios" required value=<?php echo $usuario->apellidos_usuarios?>>
                    </div>
                    <div class="form-group">
                        <label for="edit-email_usuario">Email:</label>
                        <input type="email" class="form-control" id="edit-email_usuario" name="email_usuario" value=<?php echo $usuario->email_usuario?>>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para llenar los datos del modal
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id = button.data('id');
        var usuario = button.data('usuario');
        
        var nivel_acceso = button.data('nivel_acceso');
        var nombre = button.data('nombre');
        var apellidos_usuarios = button.data('apellidos_usuarios');
        var email_usuario = button.data('email_usuario');

        // Poner los valores en los campos del modal
        $('#edit-id').val(ID);
        $('#edit-usuario').val(usuario);
        
        $('#edit-nivel_acceso').val(nivel_acceso);
        $('#edit-nombre').val(nombre);
        $('#edit-apellidos_usuarios').val(apellidos_usuarios);
        $('#edit-email_usuario').val(email_usuario);
    });
</script>

</body>
</html>
