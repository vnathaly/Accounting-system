<?php
include_once "conexion.php"; 
session_start();
if (!empty($_POST["btningresar"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];
        
        $sql = $conexion->query("SELECT * FROM usuario WHERE usuario='$usuario'");
        
        if ($datos = $sql->fetch_object()) {

            //verificar password

            $verify = password_verify($password, $datos->clave);
           var_dump($datos);
            if ($verify){

                echo "<div class='alert alert-danger'>VALIDO</div> ";

            } else {
                echo "<div class='alert alert-danger'>NOOOOO VALIDO</div>";
            }

            // $_SESSION["ID"]=$datos->ID;
            // $_SESSION["nombre"]=$datos->nombre;
            // $_SESSION["apellidos_usuarios"]=$datos->apellidos_usuarios;
            // header("location: ./inicio.php");
        } else {
            echo "<div class='alert alert-danger'>Acceso Denegado</div>";
        }
    } else {
        echo "Campos vacíos";
    }
}
?>
