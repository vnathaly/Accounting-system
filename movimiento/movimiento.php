<?php
include_once 'conexion.php';

session_start();

// Función para guardar los datos en el archivo txt
function guardarEnArchivoTxt($tipo_doc, $cta_contable, $debito, $credito, $comentario, $creado_por, $monto_transaccion)
{
    $archivo = fopen("transacciones.txt", "a");
    $contenido = "Tipo Doc: $tipo_doc, Cuenta Contable: $cta_contable, Débito: $debito, Crédito: $credito, Comentario: $comentario, Creado Por: $creado_por, Monto: $monto_transaccion\n";
    fwrite($archivo, $contenido);
    fclose($archivo);
}

function guardarTransaccion($tipo_doc, $cta_contable, $debito, $credito, $comentario, $creado_por)
{
    global $conexion;


    $stmt = $conexion->prepare("INSERT INTO cabecera_transaccion_contable (tipo_docu, tipo_entrada, fecha_docu, descripcion_docu, hecho_por, monto_transaccion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $monto_trans = $debito > 0 ? $debito : $credito; 
    $fecha_actualizacion = date('Y-m-d'); 
    $stmt->bind_param("ddsssds", $tipo_doc, $cta_contable, date('Y-m-d'), $comentario, $creado_por, $monto_trans, $fecha_actualizacion);

    if ($stmt->execute()) {
        $nro_doc = $conexion->insert_id;

                $stmt_secuencia = $conexion->prepare("SELECT COALESCE(MAX(Secuencia_Doc), 0) + 1 AS next_secuencia FROM detalle_transaccion_contable WHERE Nro_Doc = ?");
        $stmt_secuencia->bind_param("d", $nro_doc);
        $stmt_secuencia->execute();
        $result_secuencia = $stmt_secuencia->get_result();
        $row_secuencia = $result_secuencia->fetch_assoc();
        $secuencia_doc = $row_secuencia['next_secuencia'];

        // Insertar detalle
        $stmt_detalle = $conexion->prepare("INSERT INTO detalle_transaccion_contable (nro_doc, Secuencia_Doc, Cuenta_Contable, Valor_Debito, Valor_Credito, Comentario) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_detalle->bind_param("ddddds", $nro_doc, $secuencia_doc, $cta_contable, $debito, $credito, $comentario);

        if ($stmt_detalle->execute()) {
            return "<div class='alert alert-success'>Transacción registrada exitosamente.</div>";
        } else {
            return "<div class='alert alert-danger'>Error al registrar el detalle de la transacción: " . $stmt_detalle->error . "</div>";
        }
    } else {
        return "<div class='alert alert-danger'>Error al registrar la transacción: " . $stmt->error . "</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $tipo_doc = $_POST['tipo_doc'];
    $cta_contable = $_POST['cta_contable'];
    $comentario = $_POST['comentario'];
    $debito = $_POST['debito'] ? $_POST['debito'] : null;
    $credito = $_POST['credito'] ? $_POST['credito'] : null;
    $fecha_doc = date('Y-m-d'); 
    $hora_doc = date('H:i:s'); 

    if ($debito > 0) {
        $credito = 0; 
    } elseif ($credito > 0) {
        $debito = 0;
    } elseif ($debito == 0 && $credito == 0) {
        echo "<div class='alert alert-danger'>Por favor complete al menos uno de los campos: Débito o Crédito.</div>";
        exit;
    }

    $nro_doc = $_POST['nro_doc'];
    $stmt = $conexion->prepare("SELECT * FROM cabecera_transaccion_contable WHERE nro_docu = ? AND status_actualizacion = 0");
    $stmt->bind_param("d", $nro_doc);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>Transacción ha sido actualizada.</div>";
        exit;
    }

    //Validación de cuenta contable
    $stmt_cuenta = $conexion->prepare("SELECT * FROM catalogo_cuenta_contable WHERE nro_cta = ? AND tipo_cta = 'Detalle'");
    $stmt_cuenta->bind_param("s", $cta_contable);
    $stmt_cuenta->execute();
    $result_cuenta = $stmt_cuenta->get_result();

    if ($result_cuenta->num_rows == 0) {
        echo "<div class='alert alert-danger'>La cuenta contable no existe o no es de tipo detalle.</div>";
        exit;
    }

    // Verificación de que los débitos y créditos sumen lo mismo
    // if ($debito != $credito) {
    //     echo "<div class='alert alert-danger'>La suma de los débitos no es igual a la suma de los créditos.</div>";
    //     exit;
    // }

    $creado_por = $_SESSION['nombre']; // Nombre del usuario actual

    // Guardar la transacción
    $mensaje = guardarTransaccion($tipo_doc, $cta_contable, $debito, $credito, $comentario, $creado_por);

    // Guardar en archivo de texto
    $monto_transaccion = $debito > 0 ? $debito : $credito;
    guardarEnArchivoTxt($tipo_doc, $cta_contable, $debito, $credito, $comentario, $creado_por, $monto_transaccion);

    echo $mensaje; 
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimiento de Transacción</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tipo_doc').change(function() {
                var tipoDocId = $(this).val();
                if (tipoDocId) {
                    $.ajax({
                        url: 'obtener_descripcion.php',
                        method: 'GET',
                        data: { tipo_doc: tipoDocId },
                        success: function(response) {
                            $('#descripcion').val(response);
                        }
                    });
                } else {
                    $('#descripcion').val('');
                }
            });
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h1 id="tite">MOVIMIENTO DE TRANSACCIONES</h1>
            </div>
            <div class="card-body">
                <form id="formularioTransaccion" method="POST" action="movimiento.php">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="hecho_por" class="form-label">Creado por</label>
                            <input type="text" class="form-control" id="hecho_por" name="hecho_por"
                                placeholder="Nombre del creador" value="<?php echo $_SESSION['nombre']; ?>"
                                readonly disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha_doc" value="<?php echo date('Y-m-d'); ?>" readonly disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="hora" name="hora_doc" value="<?php echo date('H:i'); ?>" readonly disabled>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nro_doc" class="form-label">No. Documento</label>
                            <input type="text" class="form-control" id="nro_doc" name="nro_doc"
                                placeholder="Número de documento" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tipo_doc" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipo_doc" name="tipo_doc" required>
                                <option value="">Seleccione</option>
                                <?php
                                $sql = "SELECT idnum, descripcion FROM tipos_entrada";
                                $result = $conexion->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='". $row['idnum'] ."'>" . $row['descripcion'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cta_contable" class="form-label">Cuenta Contable</label>
                            <input type="text" class="form-control" id="cta_contable" name="cta_contable" placeholder="Cuenta contable" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="debito" class="form-label">Débito</label>
                            <input type="number" class="form-control" id="debito" name="debito" step="0.01" value="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="credito" class="form-label">Crédito</label>
                            <input type="number" class="form-control" id="credito" name="credito" step="0.01" value="0" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="comentario" class="form-label">Comentario</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="accion" class="btn btn-success">Registrar Transacción</button>
                    </div>
                    <form action="http://127.0.0.1/Yovanny/login/inicio.php" method="get">
                      <button type="submit" class="btn-salir">Salir</button>
                    </form>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
s