<?php
session_start();
include "conexion.php";

$error_message = '';

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>
        alert('Debe iniciar sesión para poder reportar');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$tipo_objeto = isset($_GET['tipo']) ? $_GET['tipo'] : null;
$id_objeto = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$tipo_objeto || !$id_objeto) {
    $error_message = "Datos inválidos.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';

    if (empty($error_message)) {
        $sql = "INSERT INTO reportes (id_usuario, tipo_objeto, id_objeto, motivo) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isis", $_SESSION['id_usuario'], $tipo_objeto, $id_objeto, $motivo);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Reporte enviado con éxito.');
                    window.history.go(-2);
                  </script>";
            $stmt->close();
            $conexion->close();
            exit;
        } else {
            $error_message = "Error al enviar el reporte: " . $stmt->error;
        }

        $stmt->close();
    }
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportar <?php echo htmlspecialchars($tipo_objeto); ?></title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/custom.css">
    <link rel="stylesheet" href="style/style.css">
    <script>
        window.addEventListener('load', function () {
            var errorMessage = "<?php echo addslashes($error_message); ?>";
            if (errorMessage) {
                alert(errorMessage);
            }
        });
    </script>
</head>

<body>
    <?php include "header.php"; ?>
    <br>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="container">
        <h1 class="center-text">Reportar <?php echo htmlspecialchars($tipo_objeto); ?></h1>
        <form
            action="reporte.php?tipo=<?php echo htmlspecialchars($tipo_objeto); ?>&id=<?php echo htmlspecialchars($id_objeto); ?>"
            method="post">
            <fieldset>
                <legend>Motivo del Reporte</legend>

                <select style="color: rgb(29, 29, 29);" class="comment-form" name="motivo" id="motivo" required>
                    <option value="">Seleccione un motivo</option>
                    <option value="Spam">Spam</option>
                    <option value="Contenido ofensivo">Contenido ofensivo</option>
                    <option value="Acoso">Acoso</option>
                    <option value="Información falsa">Información falsa</option>
                    <option value="Incitación al odio">Incitación al odio</option>
                    <option value="Violencia">Violencia</option>
                    <option value="Contenido inapropiado">Contenido inapropiado</option>
                    <option value="Infracción de derechos de autor">Infracción de derechos de autor</option>
                    <option value="Fraude">Fraude</option>
                    <option value="Otros">Otros</option>
                </select>
                <br>
                <button type="submit" class="button danger">Enviar Reporte</button>
                <button class="button secondary"><a href="javascript:history.back()">Volver</a></button>
            </fieldset>
        </form>
    </div>
</body>

<?php include "footer.php"; ?>

</html>