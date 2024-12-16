<?php
$conexion = new mysqli("localhost", "root", "", "sistemacontable");

if ($conexion->conexionect_error) {
    die("Error en la conexión: " . $conexion->conexionect_error);
}
?>
