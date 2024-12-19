<?php
include_once "../conexion.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];

    // Actualizar tipo de entrada
    $sqlUpdate = "UPDATE tipos_entrada SET descripcion = ? WHERE idnum = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param('si', $descripcion, $_GET['id']);

    if ($stmtUpdate->execute()) {
        echo "<script>alert('Tipo de entrada editado exitosamente');</script>";
        echo "<script>window.location.href = 'tipo_diario.php';</script>";
    } else {
        echo "<script>alert('Error al editar tipo de entrada.');</script>";
    }
}

// Obtener el tipo de entrada a editar
$sql = $conexion->query("SELECT * FROM tipos_entrada WHERE idnum = " . $_GET['id']);
$tipoEntrada = $sql->fetch_object();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tipo de Entrada</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/cac498eeb2.js" crossorigin="anonymous"></script>
</head>
<body>

<!-- Modal para editar tipo de entrada -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editTipoEntradaModalLabel">Editar Tipo de Entrada</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Formulario de edición -->
            <form method="POST" action="" class="edit-form">
                <input type="hidden" name="id" id="edit-id" value="<?php echo $tipoEntrada->idnum; ?>">
                <div class="form-group">
                    <label for="edit-descripcion">Descripción:</label>
                    <input type="text" class="form-control" id="edit-descripcion" name="descripcion" required value="<?php echo $tipoEntrada->descripcion; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
