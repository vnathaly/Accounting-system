<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
</head>
<body>

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
                <!-- Formulario de edición -->
                <form method="POST" action="procesar_edicion.php" class="edit-form">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-usuario">Usuario:</label>
                        <input type="text" class="form-control" id="edit-usuario" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-clave">Clave:</label>
                        <input type="password" class="form-control" id="edit-clave" name="clave" required>
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

<script>
    // Script para llenar los datos del modal
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id = button.data('id');
        var usuario = button.data('usuario');
        var clave = button.data('clave');
        var nivel_acceso = button.data('nivel_acceso');
        var nombre = button.data('nombre');
        var apellidos_usuarios = button.data('apellidos_usuarios');
        var email_usuario = button.data('email_usuario');

        // Poner los valores en los campos del modal
        $('#edit-id').val(ID);
        $('#edit-usuario').val(usuario);
        $('#edit-clave').val(clave);
        $('#edit-nivel_acceso').val(nivel_acceso);
        $('#edit-nombre').val(nombre);
        $('#edit-apellidos_usuarios').val(apellidos_usuarios);
        $('#edit-email_usuario').val(email_usuario);
    });
</script>

</body>
</html>
