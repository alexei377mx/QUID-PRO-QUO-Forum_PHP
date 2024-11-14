<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>
        alert('Debes iniciar sesión para editar un comentario.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_comentario = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_hilo = isset($_GET['hilo_id']) ? intval($_GET['hilo_id']) : 0;

$sql = "SELECT * FROM comentarios WHERE id_comentario = ? AND id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_comentario, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $comentario = $result->fetch_assoc();
} else {
    echo "<script>
        alert('Comentario no encontrado o no autorizado para editar.');
        window.history.back();
    </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contenido = isset($_POST['contenido']) ? trim($_POST['contenido']) : '';
    $eliminar_imagen = isset($_POST['eliminar_imagen']) ? true : false;
    $nueva_imagen_ruta = $comentario['imagen_ruta'];

    if (empty($contenido)) {
        echo "<script>
            alert('El contenido no puede estar vacío.');
            window.history.back();
        </script>";
        exit;
    }

    if ($eliminar_imagen && !empty($comentario['imagen_ruta'])) {
        if (file_exists($comentario['imagen_ruta'])) {
            unlink($comentario['imagen_ruta']);
        }
        $nueva_imagen_ruta = null;
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombre_imagen = basename($imagen['name']);
        $ruta_destino = 'uploads/comentarios/' . $nombre_imagen;

        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imagen['type'], $tipos_permitidos)) {
            if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
                if (!empty($comentario['imagen_ruta']) && file_exists($comentario['imagen_ruta'])) {
                    unlink($comentario['imagen_ruta']);
                }
                $nueva_imagen_ruta = $ruta_destino;
            } else {
                echo "<script>
                    alert('Error al mover el archivo.');
                    window.history.back();
                </script>";
                exit;
            }
        } else {
            echo "<script>
                alert('Formato de imagen no permitido. Solo se permiten JPG, PNG, y GIF.');
                window.history.back();
            </script>";
            exit;
        }
    }

    $sql_update = "UPDATE comentarios SET contenido = ?, imagen_ruta = ?, fecha_edicion = NOW() WHERE id_comentario = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("ssi", $contenido, $nueva_imagen_ruta, $id_comentario);

    if ($stmt_update->execute()) {
        echo "<script>
            window.location.href = 'ver_hilo.php?id=$id_hilo';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Error al actualizar el comentario: " . $stmt_update->error . "');
            window.history.back();
        </script>";
        exit;
    }
}

$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar hilo #<?php echo htmlspecialchars($id_comentario); ?></title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/custom.css">
    <link rel="stylesheet" href="style/style.css">

    <link href="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css" rel="stylesheet">
</head>

<?php include "header.php"; ?>
<br>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

<body>
    <div class="container">
        <h1 class="center-text">Editar Comentario</h1>
        <form
            action="editar_comentario.php?id=<?php echo htmlspecialchars($id_comentario); ?>&hilo_id=<?php echo htmlspecialchars($id_hilo); ?>"
            method="POST" enctype="multipart/form-data">
            <label for="contenido">Contenido:</label>
            <textarea style="color: rgb(29, 29, 29);" class="comment-form" id="contenido" name="contenido" rows="10"
                cols="50" required><?php echo htmlspecialchars($comentario['contenido']); ?></textarea>
            <?php if (!empty($comentario['imagen_ruta'])): ?>
                <div class="imagen-actual">
                    <p>Imagen actual:</p>
                    <img src="<?php echo htmlspecialchars($comentario['imagen_ruta']); ?>" alt="Imagen del comentario"
                        style="max-height: 200px; width: auto;">
                    <br>
                    <label><input type="checkbox" name="eliminar_imagen"> Eliminar imagen actual</label>
                </div>
            <?php endif; ?>

            <label for="imagen">Nueva Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">
            <br>
            <button type="submit">Actualizar Comentario</button>
            <button><a href="ver_hilo.php?id=<?php echo htmlspecialchars($id_hilo); ?>">Volver al hilo</a></button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.js"></script>

    <script>
        $("#contenido").emojioneArea({
            pickerPosition: "bottom"
        });
    </script>
</body>

</html>