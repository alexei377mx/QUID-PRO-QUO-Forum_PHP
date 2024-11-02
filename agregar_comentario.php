<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>
        alert('Debe de iniciar sesión para poder comentar.');
        window.history.back();
    </script>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_hilo = isset($_POST['id_hilo']) ? intval($_POST['id_hilo']) : 0;
$contenido = isset($_POST['contenido']) ? trim($_POST['contenido']) : '';

if (empty($contenido)) {
    echo "<script>
        alert('El contenido del comentario no puede estar vacío.');
        window.history.back();
    </script>";
    exit;
}

$imagen_ruta = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $imagen = $_FILES['imagen'];
    $nombre_imagen = basename($imagen['name']);
    $directorio_destino = 'uploads/comentarios/';

    if (!file_exists($directorio_destino)) {
        mkdir($directorio_destino, 0777, true);
    }

    $ruta_destino = $directorio_destino . $nombre_imagen;

    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($imagen['type'], $tipos_permitidos)) {
        if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
            $imagen_ruta = $ruta_destino;
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

$sql = "INSERT INTO comentarios (id_hilo, id_usuario, contenido, imagen_ruta) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt === false) {
    echo "<script>
        alert('Error en la preparación de la consulta: " . $conexion->error . "');
        window.history.back();
    </script>";
    exit;
}

$stmt->bind_param("iiss", $id_hilo, $id_usuario, $contenido, $imagen_ruta);

if ($stmt->execute()) {
    echo "<script>
        window.location.href = 'ver_hilo.php?id=$id_hilo';
    </script>";
    exit;
} else {
    echo "<script>
        alert('Error al agregar comentario: " . $stmt->error . "');
        window.history.back();
    </script>";
    exit;
}