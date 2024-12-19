<?php
// Configurar conexión a la base de datos
$mysqli = new mysqli("localhost", "usuario", "clave", "sistemacontable");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Recibir los datos del formulario
$nro_docu = $_POST['nro_docu'];
$tipo_documento = $_POST['tipo_documento'];
$cuenta_contable = $_POST['cuenta_contable'];
$monto_transaccion = $_POST['monto_transaccion'];
$hecho_por = $_POST['hecho_por'];
$fecha_docu = $_POST['fecha_docu']; // Fecha actual

// Inserción en la tabla cabecera_transaccion_contable
$query = "INSERT INTO cabecera_transaccion_contable (nro_docu, tipo_entrada, fecha_docu, tipo_docu, descripcion_docu, hecho_por, monto_transaccion) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sissssd", $nro_docu, $tipo_documento, $fecha_docu, $tipo_documento, $descripcion_docu, $hecho_por, $monto_transaccion);
$descripcion_docu = "Descripción de la transacción"; // Puede ser modificada según el caso
$stmt->execute();
$stmt->close();

// Insertar transacciones contables (detalles)
$secuencia_doc = 1; // Número de secuencia para las transacciones contables
$query = "INSERT INTO transaccion_contable (nro_doc, secuencia_doc, cuenta_contable, valor_debito, valor_credito, comentario) 
          VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);

// Asumiendo que solo hay una transacción en el formulario por ahora (se puede ajustar según el caso)
$valor_debito = 1000; // Este valor debe venir de algún input o lógica en el formulario
$valor_credito = 0;  // Este valor debe venir de algún input o lógica en el formulario
$comentario = "Transacción de ejemplo";

$stmt->bind_param("siidss", $nro_docu, $secuencia_doc, $cuenta_contable, $valor_debito, $valor_credito, $comentario);
$stmt->execute();

$stmt->close();
$mysqli->close();

echo "Transacción guardada exitosamente!";
?>
