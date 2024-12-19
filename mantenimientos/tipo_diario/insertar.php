<?php
include_once "../conexion.php"; 

// Obtener el término de búsqueda
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta para buscar tipos de entrada
$sql = "SELECT * FROM tipos_entrada WHERE descripcion LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('s', $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

// Procesar el formulario de inserción de nuevo tipo de entrada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['descripcion'])) {
    $descripcion = $_POST['descripcion'];

    $sqlInsert = "INSERT INTO tipos_entrada (descripcion) VALUES (?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('s', $descripcion);

    if ($stmtInsert->execute()) {
        echo "<script>alert('Tipo de entrada agregado exitosamente');</script>";
        echo "<script>window.location.href = 'tipo_diario.php';</script>";
    } else {
        echo "<script>alert('Error al agregar tipo de entrada.');</script>";
    }
}
?>