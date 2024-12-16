<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $nivel_acceso = $_POST['nivel_acceso'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE usuarios SET usuario=?, clave=?, nivel_acceso=?, nombre=?, apellidos_usuarios=?, email_usuario=? WHERE ID=?");
    $stmt->bind_param("ssisssi", $usuario, $clave, $nivel_acceso, $nombre, $apellidos, $email, $id);

    if ($stmt->execute()) {
        header("Location: usuario.php?mensaje=Usuario actualizado");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
