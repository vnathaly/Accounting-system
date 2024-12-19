<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre Diario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Estilo del formulario -->
</head>
<body>
    <div class="container">
        <h2>Cierre Diario por Fechas</h2>
        <form action="cierre_diario.php" method="POST">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <button type="submit" class="btn-primary">Ejecutar Cierre</button>
        </form>
    </div>
</body>
</html>
