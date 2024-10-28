<?php
session_start();
include "conexion.php";

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>
        alert('Debes iniciar sesión para crear un hilo.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $id_categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : null;
    $id_usuario = $_SESSION['id_usuario'];
    $imagen_ruta = null;
    $obj_ruta = null;

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
                    $imagen_ruta = $ruta_destino_imagen;
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
                        $obj_ruta = $ruta_destino_obj;
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

        // Inserción en la base de datos solo si el título y contenido no están vacíos
        if (!empty($titulo) && !empty($contenido)) {
            $sql = "INSERT INTO hilos (titulo, contenido, id_usuario, id_categoria, imagen_ruta, obj_ruta, fecha_creacion) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssisss", $titulo, $contenido, $id_usuario, $id_categoria, $imagen_ruta, $obj_ruta);

            if ($stmt->execute()) {
                $nuevo_id_hilo = $stmt->insert_id;
                $stmt->close();
                echo "<script>
                    window.location.href = 'ver_hilo.php?id=$nuevo_id_hilo';
                </script>";
                exit;
            } else {
                echo "<script>
                    alert('Error al crear el hilo: " . $stmt->error . "');
                    window.history.back();
                </script>";
                exit;
            }
        } else {
            echo "<script>
                alert('El título y el contenido no pueden estar vacíos.');
                window.history.back();
            </script>";
            exit;
        }
    }
}

// Obtener categorías desde la base de datos
$resultado = $conexion->query("SELECT id_categoria, nombre FROM categorias");
$categorias = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $categorias[] = $fila;
    }
}

$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Hilo</title>
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
        <h1 class="center-text">Crear un Nuevo Hilo</h1>
        <form action="crear_hilo.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Nuevo Hilo</legend>
                <label for="titulo">Título:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="text" id="titulo" name="titulo"
                    required>

                <label for="contenido">Contenido (recuerda que puedes usar <a
                        href="https://www.markdownguide.org/extended-syntax/">Markdown</a> para dar formato a tus
                    textos):</label>
                <textarea required style="color: rgb(29, 29, 29);" class="comment-form" id="contenido" name="contenido"
                    rows="4"></textarea>

                <label for="categoria">Categoría:</label>
                <select style="color: rgb(29, 29, 29);" class="comment-form" id="categoria" name="categoria" required>
                    <option value="">Selecciona una categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="row">
                    <div class="col">
                        <label for="imagen">Imagen:</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                    </div>
                    <div class="col">
                        <label for="obj">Archivo OBJ (máx. 10MB):</label>
                        <input type="file" id="obj" name="obj" accept=".obj">
                    </div>
                </div>

                <button type="submit" class="button primary">Crear Hilo</button>
                <button><a href="index.php">Volver a la lista de hilos</a></button>
            </fieldset>
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