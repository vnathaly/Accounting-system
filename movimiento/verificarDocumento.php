<?php
include_once 'conexion.php';

$nro_docu = $_POST['nro_docu'];

// Verificar si el documento existe y si ha sido actualizado
$query = "SELECT * FROM cabecera_transaccion_contable WHERE nro_docu = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $nro_docu);
$stmt->execute();
$result = $stmt->get_result();

$response = ['existe' => false, 'actualizado' => false, 'tipo_documento' => '', 'cuenta_contable' => '', 'monto_transaccion' => 0];

if ($row = $result->fetch_assoc()) {
    $response['existe'] = true;
    $response['actualizado'] = $row['status_actualizacion'];
    $response['tipo_documento'] = $row['tipo_docu']; // Número de tipo de documento
    $response['descripcion_docu'] = $row['descripcion_docu'];
    $response['monto_transaccion'] = $row['monto_transaccion'];
}

$stmt->close();
$mysqli->close();

echo json_encode($response);
?>
