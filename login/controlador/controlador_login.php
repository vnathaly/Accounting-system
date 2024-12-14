<?php
include_once "conexion.php"; // Ajusta la ruta según la estructura de tu proyecto

if (!empty($_POST["btningresar"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];
        
        // Ejecutar la consulta
        $sql = $conexion->query("SELECT * FROM usuario WHERE usuario='$usuario' AND clave='$password'");
        
        if ($datos = $sql->fetch_object()) {
            header("location:inicio.php");
        } else {
            echo "<div class='alert alert-danger'>No existe el usuario o contraseña incorrecta</div>";
        }
    } else {
        echo "Campos vacíos";
    }
}
?>
