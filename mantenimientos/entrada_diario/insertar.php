<?php
include_once "../conexion.php"; 

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM usuario WHERE nombre LIKE ? OR apellidos_usuarios LIKE ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param('ss', $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error en la consulta: " . $conexion->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT); // Cifrado de clave
    $nivel_acceso = $_POST['nivel_acceso'];
    $nombre = $_POST['nombre'];
    $apellidos_usuarios = $_POST['apellidos_usuarios'];
    $email_usuario = $_POST['email_usuario'];

    $sqlInsert = "INSERT INTO usuario (usuario, clave, nivel_acceso, nombre, apellidos_usuarios, email_usuario) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($sqlInsert);
    $stmtInsert->bind_param('ssiiss', $usuario, $clave, $nivel_acceso, $nombre, $apellidos_usuarios, $email_usuario);

    if ($stmtInsert->execute()) {
        echo "<script>alert('Usuario agregado exitosamente";
        echo "<script>window.location.href = 'entrada_diario.php';</script>";
    } else {
        echo "<script>alert('Error al agregar entrada_diario.');</script>";
    }
}
?>