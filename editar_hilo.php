<?php 
session_start();
include "conexion.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>
        alert('Debes iniciar sesión para editar un hilo.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Verificar si se ha proporcionado un ID de hilo válido
$id_hilo = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta para verificar si el hilo pertenece al usuario actual
$sql = "SELECT * FROM hilos WHERE id_hilo = ? AND id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_hilo, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hilo = $result->fetch_assoc();
} else {
    echo "<script>
        alert('Hilo no encontrado o no autorizado para editar.');
        window.history.back();
    </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $contenido = isset($_POST['contenido']) ? trim($_POST['contenido']) : '';
    $eliminar_archivo = isset($_POST['eliminar_archivo']) ? true : false;
    $nueva_imagen_ruta = $hilo['imagen_ruta'];
    $nuevo_obj_ruta = $hilo['obj_ruta'];

    // Verifica si el título y el contenido no están vacíos
    if (empty($titulo) || empty($contenido)) {
        echo "<script>
            alert('El título y el contenido no pueden estar vacíos.');
            window.history.back();
        </script>";
        exit;
    }

    // Eliminar la imagen o el archivo OBJ si se selecciona
    if ($eliminar_archivo) {
        if (!empty($hilo['imagen_ruta']) && file_exists($hilo['imagen_ruta'])) {
            unlink($hilo['imagen_ruta']);
            $nueva_imagen_ruta = null;
        }
        if (!empty($hilo['obj_ruta']) && file_exists($hilo['obj_ruta'])) {
            unlink($hilo['obj_ruta']);
            $nuevo_obj_ruta = null;
        }
    }

    // Verificar si se subieron ambos archivos (imagen y obj) al mismo tiempo
    if (!empty($_FILES['imagen']['name']) && !empty($_FILES['obj']['name'])) {
        echo "<script>
            alert('Error: No puedes subir una imagen y un archivo OBJ al mismo tiempo.');
            window.history.back();
        </script>";
        exit;
    } else {
        // Proceso para manejar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $imagen = $_FILES['imagen'];
            $nombre_imagen = basename($imagen['name']);
            $ruta_destino_imagen = 'uploads/hilos/' . $nombre_imagen;

            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($imagen['type'], $tipos_permitidos)) {
                if (!file_exists('uploads/hilos/')) {
                    mkdir('uploads/hilos/', 0777, true);
                }

                if (move_uploaded_file($imagen['tmp_name'], $ruta_destino_imagen)) {
                    if (!empty($hilo['imagen_ruta']) && file_exists($hilo['imagen_ruta'])) {
                        unlink($hilo['imagen_ruta']);
                    }
                    $nueva_imagen_ruta = $ruta_destino_imagen;
                    $nuevo_obj_ruta = null; // Eliminar cualquier archivo .obj anterior si se sube una imagen nueva
                } else {
                    echo "<script>
                        alert('Error al mover el archivo de imagen.');
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

        // Proceso para manejar el archivo OBJ (máximo 10 MB)
        if (isset($_FILES['obj']) && $_FILES['obj']['error'] == 0) {
            $obj = $_FILES['obj'];
            $nombre_obj = basename($obj['name']);
            $ruta_destino_obj = 'uploads/obj/' . $nombre_obj;

            // Verificar si el archivo .obj no supera los 10 MB
            if ($obj['size'] > 10 * 1024 * 1024) {
                echo "<script>
                    alert('Error: El archivo OBJ supera el límite de tamaño de 10 MB.');
                    window.history.back();
                </script>";
                exit;
            } else {
                // Verificar si el archivo es un archivo .obj
                if (mime_content_type($obj['tmp_name']) == 'application/x-tgif' || pathinfo($nombre_obj, PATHINFO_EXTENSION) === 'obj') {
                    if (!file_exists('uploads/obj/')) {
                        mkdir('uploads/obj/', 0777, true);
                    }

                    if (move_uploaded_file($obj['tmp_name'], $ruta_destino_obj)) {
                        if (!empty($hilo['obj_ruta']) && file_exists($hilo['obj_ruta'])) {
                            unlink($hilo['obj_ruta']);
                        }
                        $nuevo_obj_ruta = $ruta_destino_obj;
                        $nueva_imagen_ruta = null; // Eliminar cualquier imagen anterior si se sube un archivo .obj nuevo
                    } else {
                        echo "<script>
                            alert('Error al mover el archivo OBJ.');
                            window.history.back();
                        </script>";
                        exit;
                    }
                } else {
                    echo "<script>
                        alert('Formato de archivo OBJ no permitido.');
                        window.history.back();
                    </script>";
                    exit;
                }
            }
        }

        // Actualizar el hilo en la base de datos
        $sql_update = "UPDATE hilos SET titulo = ?, contenido = ?, imagen_ruta = ?, obj_ruta = ?, fecha_edicion = NOW() WHERE id_hilo = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $titulo, $contenido, $nueva_imagen_ruta, $nuevo_obj_ruta, $id_hilo);

        if ($stmt_update->execute()) {
            echo "<script>
                window.location.href = 'ver_hilo.php?id=$id_hilo';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Error al actualizar el hilo: " . $stmt_update->error . "');
                window.history.back();
            </script>";
            exit;
        }
    }
}

$conexion->close();
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Hilo</title>
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
        <h1 class="center-text">Editar Hilo #<?php echo htmlspecialchars($id_hilo); ?></h1>
        <form action="editar_hilo.php?id=<?php echo htmlspecialchars($id_hilo); ?>" method="POST"
            enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input style="color: rgb(29, 29, 29);" class="comment-form" type="text" name="titulo" id="titulo"
                value="<?php echo htmlspecialchars($hilo['titulo']); ?>" required>

            <label for="contenido">Contenido (recuerda que puedes usar <a
                    href="https://www.markdownguide.org/extended-syntax/">Markdown </a>para dar formato a tus
                textos):</label>
            <textarea style="color: rgb(29, 29, 29);" class="comment-form" name="contenido" id="contenido" rows="10"
                cols="50" required><?php echo htmlspecialchars($hilo['contenido']); ?></textarea>

            <?php if (!empty($hilo['imagen_ruta'])): ?>
                <div class="archivo-actual">
                    <p>Imagen actual:</p>
                    <img src="<?php echo htmlspecialchars($hilo['imagen_ruta']); ?>" alt="Imagen del hilo"
                        style="max-height: 300px; width: auto;">
                </div>
            <?php elseif (!empty($hilo['obj_ruta'])): ?>
                <div class="archivo-actual">
                    <p>Archivo OBJ actual: <?php echo htmlspecialchars(basename($hilo['obj_ruta'])); ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($hilo['imagen_ruta']) || !empty($hilo['obj_ruta'])): ?>
                <label><input type="checkbox" name="eliminar_archivo"> Eliminar
                    <?php echo !empty($hilo['imagen_ruta']) ? 'imagen' : 'archivo OBJ'; ?> actual</label>
            <?php endif; ?>

            <div class="row">
                <div class="col">
                    <label for="imagen">Nueva Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <div class="col">
                    <label for="obj">Nuevo Archivo OBJ (máx. 10MB):</label>
                    <input type="file" id="obj" name="obj" accept=".obj">
                </div>
            </div>

            <button type="submit">Actualizar Hilo</button>
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

<?php include "footer.php"; ?>

</html>