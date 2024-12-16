<?php
$conexion = new mysqli("localhost", "root", "", "sistemacontable");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
