<?php
include_once 'conexion.php';

if (isset($_GET['tipo_doc'])) {
    $tipo_doc = $_GET['tipo_doc'];
    $sql = "SELECT descripcion FROM tipos_entrada WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $tipo_doc);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo $row['descripcion'];
}
?>
