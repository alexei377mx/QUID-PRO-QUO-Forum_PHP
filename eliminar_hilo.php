<?php
session_start();
include "conexion.php";

if ($_SESSION['nombre_usuario'] === 'admin') {
    $id_hilo = isset($_GET['id_hilo']) ? intval($_GET['id_hilo']) : 0;

    $sqlUsuarioHilo = "SELECT id_usuario FROM hilos WHERE id_hilo = ?";
    $stmtUsuarioHilo = $conexion->prepare($sqlUsuarioHilo);
    $stmtUsuarioHilo->bind_param("i", $id_hilo);
    $stmtUsuarioHilo->execute();
    $resultUsuarioHilo = $stmtUsuarioHilo->get_result();
    $rowUsuarioHilo = $resultUsuarioHilo->fetch_assoc();

    if ($rowUsuarioHilo) {
        $id_usuario = $rowUsuarioHilo['id_usuario'];

        $sql = "UPDATE hilos SET eliminado = 1 WHERE id_hilo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_hilo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $sqlAdvertencias = "UPDATE usuarios SET advertencias = advertencias + 1 WHERE id_usuario = ?";
            $stmtAdvertencias = $conexion->prepare($sqlAdvertencias);
            $stmtAdvertencias->bind_param("i", $id_usuario);

            if ($stmtAdvertencias->execute()) {
                echo "<script>
                    alert('Hilo eliminado con éxito y advertencia agregada al usuario.');
                    window.location.href = 'index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Error al agregar la advertencia al usuario.');
                    window.location.href = 'index.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Error al eliminar el hilo.');
                window.location.href = 'index.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('No se encontró el hilo o el usuario asociado.');
            window.location.href = 'index.php';
        </script>";
    }
} else {
    echo "<script>
        alert('No tienes permisos para eliminar este hilo.');
        window.location.href = 'index.php';
    </script>";
}

$conexion->close();
