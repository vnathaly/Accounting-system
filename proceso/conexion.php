<?php
// Parámetros de conexión
$host = 'localhost';  // o tu host de base de datos
$dbname = 'sistemacontable'; // Nombre de tu base de datos
$username = 'root';  // Tu usuario de la base de datos
$password = ''; // Tu contraseña (si tienes una)

// Establecer la conexión PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die(); // Detener la ejecución si no se puede conectar
}
?>
