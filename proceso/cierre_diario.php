<?php
// Incluir la conexión a la base de datos
include_once 'conexion.php';

// Verificar si se enviaron las fechas desde el formulario
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    // Obtener las fechas de inicio y fin
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    try {
        // Preparar la llamada al procedimiento almacenado
        $stmt = $pdo->prepare("CALL cierre_diario_por_fechas(:fecha_inicio, :fecha_fin)");
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);

        // Ejecutar el procedimiento
        $stmt->execute();

        // Mensaje de éxito
        echo "<div class='alert-success'>Cierre realizado con éxito para las fechas $fecha_inicio a $fecha_fin.</div>";
    } catch (PDOException $e) {
        // Mensaje de error en caso de fallo
        echo "<div class='alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert-danger'>Por favor, ingresa un rango de fechas.</div>";
}
?>
