<?php
session_start();
include 'conexion.php';

if ($_SESSION['nombre_usuario'] === 'admin') {
    if (isset($_GET['id_comentario'])) {
        $id_comentario = intval($_GET['id_comentario']);

        // Obtener el id del usuario al que pertenece el comentario
        $sqlUsuarioComentario = "SELECT id_usuario FROM comentarios WHERE id_comentario = ?";
        $stmtUsuarioComentario = $conexion->prepare($sqlUsuarioComentario);
        $stmtUsuarioComentario->bind_param("i", $id_comentario);
        $stmtUsuarioComentario->execute();
        $resultUsuarioComentario = $stmtUsuarioComentario->get_result();
        $rowUsuarioComentario = $resultUsuarioComentario->fetch_assoc();

        if ($rowUsuarioComentario) {
            $id_usuario = $rowUsuarioComentario['id_usuario'];

            // Marcar el comentario como eliminado
            $sql = "UPDATE comentarios SET eliminado = 1 WHERE id_comentario = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $id_comentario);

            if ($stmt->execute()) {
                // Incrementar la advertencia para el usuario en la tabla usuarios
                $sqlAdvertencias = "UPDATE usuarios SET advertencias = advertencias + 1 WHERE id_usuario = ?";
                $stmtAdvertencias = $conexion->prepare($sqlAdvertencias);
                $stmtAdvertencias->bind_param("i", $id_usuario);

                if ($stmtAdvertencias->execute()) {
                    echo "<script>
                    alert('Comentario eliminado correctamente y advertencia agregada al usuario.'); 
                    window.location.href = 'ver_hilo.php?id=" . intval($_GET['id_hilo']) . "';
                    </script>";
                } else {
                    echo "<script>
                    alert('Error al agregar la advertencia al usuario'); 
                    window.history.back();
                    </script>";
                }
            } else {
                echo "<script>
                alert('Error al eliminar el comentario'); 
                window.history.back();
                </script>";
            }
        } else {
            echo "<script>
            alert('No se encontró el comentario o el usuario asociado'); 
            window.history.back();
            </script>";
        }
    }
} else {
    echo "<script>
    alert('No tienes permiso para eliminar comentarios'); 
    window.history.back();
    </script>";
}
