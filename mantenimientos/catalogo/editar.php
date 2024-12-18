<?php
session_start();
if (empty($_SESSION["ID"])) {
    header("location: login.php");
}

include_once "../conexion.php";

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nro_cta = $_POST['nro_cta'];
    $descripcion_cta = $_POST['descripcion_cta'];
    $tipo_cta = $_POST['tipo_cta'];
    $nivel_cta = $_POST['nivel_cta'];
    $cta_padre = $_POST['cta_padre'];
    $grupo_cta = $_POST['grupo_cta'];
    $debito_acum_cta = $_POST['debito_acum_cta'];
    $credito_acum_cta = $_POST['credito_acum_cta'];
    // Calcular el balance
    $balance_cta = $debito_acum_cta - $credito_acum_cta;

    $sqlUpdate = "UPDATE catalogo_cuenta_contable 
                  SET descripcion_cta = ?, tipo_cta = ?, nivel_cta = ?, cta_padre = ?, grupo_cta = ?, 
                      debito_acum_cta = ?, credito_acum_cta = ?, balance_cta = ?
                  WHERE nro_cta = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param('sdddddddd', $descripcion_cta, $tipo_cta, $nivel_cta, $cta_padre, $grupo_cta, 
                            $debito_acum_cta, $credito_acum_cta, $balance_cta, $nro_cta);

    if ($stmtUpdate->execute()) {
        echo "<script>alert('Cuenta contable editada exitosamente');</script>";
        echo "<script>window.location.href = 'catalogo.php';</script>";
    } else {
        echo "<script>alert('Error al editar la cuenta contable.');</script>";
    }
}

// Consultar los datos de la cuenta
$sql = $conexion->query("SELECT * FROM catalogo_cuenta_contable WHERE nro_cta=" . $_GET['nro_cta']);
$cuenta = $sql->fetch_object();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cuenta Contable</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark">

<div class="modal-overlay">
    <div class="container mt-5">
        <h2>Editar Cuenta Contable</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nro_cta">Número de Cuenta:</label>
                <input type="text" class="form-control" id="nro_cta" name="nro_cta" readonly value="<?php echo $cuenta->nro_cta; ?>">
            </div>
            <div class="form-group">
                <label for="descripcion_cta">Descripción:</label>
                <input type="text" class="form-control" id="descripcion_cta" name="descripcion_cta" value="<?php echo $cuenta->descripcion_cta; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo_cta">Estado de la Cuenta:</label>
                <select class="form-control" id="tipo_cta" name="tipo_cta" required>
                    <option value="1" <?php echo $cuenta->tipo_cta == 1 ? 'selected' : ''; ?>>Activa</option>
                    <option value="0" <?php echo $cuenta->tipo_cta == 0 ? 'selected' : ''; ?>>Inactiva</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nivel_cta">Nivel:</label>
                <input type="number" class="form-control" id="nivel_cta" name="nivel_cta" value="<?php echo $cuenta->nivel_cta; ?>" required>
            </div>
            <div class="form-group">
                <label for="cta_padre">Cuenta Padre:</label>
                <input type="number" class="form-control" id="cta_padre" name="cta_padre" value="<?php echo $cuenta->cta_padre; ?>">
            </div>
            <div class="form-group">
                <label for="grupo_cta">Grupo de Cuenta:</label>
                <input type="number" class="form-control" id="grupo_cta" name="grupo_cta" value="<?php echo $cuenta->grupo_cta; ?>">
            </div>
            <div class="form-group">
                <label for="debito_acum_cta">Débito Acumulado:</label>
                <input type="number" class="form-control" id="debito_acum_cta" name="debito_acum_cta" value="<?php echo $cuenta->debito_acum_cta; ?>" required oninput="calcularBalance()">
            </div>
            <div class="form-group">
                <label for="credito_acum_cta">Crédito Acumulado:</label>
                <input type="number" class="form-control" id="credito_acum_cta" name="credito_acum_cta" value="<?php echo $cuenta->credito_acum_cta; ?>" required oninput="calcularBalance()">
            </div>
            <div class="form-group">
                <label for="balance_cta">Balance:</label>
                <input type="number" class="form-control" id="balance_cta" name="balance_cta" readonly value="<?php echo $cuenta->debito_acum_cta - $cuenta->credito_acum_cta; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
</div>

<script>
    function calcularBalance() {
        const debito = parseFloat(document.getElementById('debito_acum_cta').value) || 0;
        const credito = parseFloat(document.getElementById('credito_acum_cta').value) || 0;
        document.getElementById('balance_cta').value = debito - credito;
    }
</script>

</body>
</html>
