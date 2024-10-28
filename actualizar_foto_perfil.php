<?php
session_start();
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nueva_foto_perfil']) && isset($_POST['id_usuario'])) {
    $id_usuario = intval($_POST['id_usuario']);
    $nombre_usuario_actual = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : null;

    // Verifica si el usuario tiene permisos para actualizar la foto
    if ($id_usuario !== intval($_SESSION['id_usuario'])) {
        echo "<script>
        alert('No tienes permisos para actualizar esta foto de perfil.');
        window.location.href = 'index.php';
    </script>";
        exit;
    }

    // Verifica si no hubo errores en la subida del archivo
    if ($_FILES['nueva_foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['nueva_foto_perfil']['tmp_name'];
        $nombre_archivo = basename($_FILES['nueva_foto_perfil']['name']);
        $directorio_destino = 'uploads/perfil/';
        $ruta_archivo = $directorio_destino . $nombre_archivo;

        // Mueve el archivo al directorio de destino
        if (move_uploaded_file($nombre_temporal, $ruta_archivo)) {
            $sql = "UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("si", $nombre_archivo, $id_usuario);

            // Si la actualización es exitosa, redirige al perfil
            if ($stmt->execute()) {
                echo "<script>
                window.location.href = 'perfil.php?id=" . $id_usuario . "';
            </script>";
            } else {
                echo "<script>
                alert('Error al actualizar la foto de perfil en la base de datos.');
                window.history.back();
            </script>";
            }
        } else {
            echo "<script>
            alert('Error al subir el archivo.');
            window.history.back();
        </script>";
        }
    } else {
        echo "<script>
        alert('Error en la carga del archivo.');
        window.history.back();
    </script>";
    }
} else {
    echo "<script>
    alert('Solicitud no válida.');
    window.history.back();
</script>";
}

$conexion->close();
