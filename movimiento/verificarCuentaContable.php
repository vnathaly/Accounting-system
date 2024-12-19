<?php
include_once 'conexion.php';
$cuentaContable = $_POST['cuenta_contable'];

// Verificar si la cuenta es válida y de tipo "detalle"
$query = "SELECT * FROM catalogo_cuenta_contable WHERE nro_cta = ? AND tipo_cta = 1";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $cuentaContable);
$stmt->execute();
$result = $stmt->get_result();

$response = ['valida' => false];

if ($result->num_rows > 0) {
    $response['valida'] = true;
}

$stmt->close();
$mysqli->close();

echo json_encode($response);
?>
