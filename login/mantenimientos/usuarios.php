<div class="container">
    <h2>Mantenimiento de Usuarios</h2>
    <form action="procesar_cliente.php" method="POST">  
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="form-group">
            <label for="clave">Clave</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
        </div>
        <div class="form-group">
            <label for="nivel_acceso">Nivel de Acceso</label>
            <input type="number" class="form-control" id="nivel_acceso" name="nivel_acceso" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
