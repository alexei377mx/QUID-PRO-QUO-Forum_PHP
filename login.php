<?php
session_start();
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*  
    $recaptcha_token = $_POST['g-recaptcha-response'];
    $recaptcha_secret = '6LchmTUqAAAAAFHcXkO6dxFWT05hzsySqM2hF0kc';

    // Verificar el token con Google reCAPTCHA
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_token;
    $recaptcha_response = file_get_contents($recaptcha_url);
    $recaptcha_data = json_decode($recaptcha_response);

    // Verificar el resultado de reCAPTCHA
    if (!$recaptcha_data->success || $recaptcha_data->score < 0.5) {
        echo "<p>Error en la verificación de reCAPTCHA. Inténtalo de nuevo.</p>";
        exit();
    }
 */
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    if (!empty($nombre_usuario) && !empty($contrasena)) {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            if (password_verify($contrasena, $usuario['contrasena'])) {
                $id_usuario = $usuario['id_usuario'];
                $queryEliminados = "SELECT 
                    (SELECT COUNT(*) FROM comentarios WHERE id_usuario = ? AND eliminado = 1) AS comentarios_eliminados,
                    (SELECT COUNT(*) FROM hilos WHERE id_usuario = ? AND eliminado = 1) AS hilos_eliminados";

                $stmtEliminados = $conexion->prepare($queryEliminados);
                if ($stmtEliminados === false) {
                    die('Error en la preparación de la consulta: ' . $conexion->error);
                }

                $stmtEliminados->bind_param("ii", $id_usuario, $id_usuario);
                $stmtEliminados->execute();
                $resultEliminados = $stmtEliminados->get_result();
                $rowEliminados = $resultEliminados->fetch_assoc();

                $comentarios_eliminados = $rowEliminados['comentarios_eliminados'];
                $hilos_eliminados = $rowEliminados['hilos_eliminados'];

                $total_eliminados = $comentarios_eliminados + $hilos_eliminados;

                $queryUpdateAdvertencias = "UPDATE usuarios SET advertencias = ? WHERE id_usuario = ?";
                $stmtUpdateAdvertencias = $conexion->prepare($queryUpdateAdvertencias);
                if ($stmtUpdateAdvertencias === false) {
                    die('Error en la preparación de la consulta: ' . $conexion->error);
                }

                $stmtUpdateAdvertencias->bind_param("ii", $total_eliminados, $id_usuario);
                $stmtUpdateAdvertencias->execute();

                if ($total_eliminados >= 4) {
                    $querySuspender = "UPDATE usuarios SET activo = 0 WHERE id_usuario = ?";
                    $stmtSuspender = $conexion->prepare($querySuspender);
                    if ($stmtSuspender === false) {
                        die('Error en la preparación de la consulta: ' . $conexion->error);
                    }

                    $stmtSuspender->bind_param("i", $id_usuario);
                    $stmtSuspender->execute();

                    echo "<script>
                            alert('Tu cuenta ha sido suspendida por infringir las políticas de uso.\\nTienes $total_eliminados advertencias.\\nPor favor contacta con Soporte.');
                            window.location.href = 'login.php';
                        </script>";
                    exit();
                } elseif ($total_eliminados > 0) {
                    echo "<script>
                            alert('ADVERTENCIA: Tienes $total_eliminados advertencias de 4 por infringir políticas de uso.');
                        </script>";
                }

                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                header("Location: index.php");
                exit();
            } else {
                echo "<script>
                    alert('Contraseña incorrecta.');
                    window.location.href = 'login.php';
                </script>";
            }
        } else {
            echo "<script>
                    alert('Nombre de usuario no encontrado.');
                    window.location.href = 'login.php';
                </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                    alert('Todos los campos son obligatorios.');
                    window.location.href = 'login.php';
                </script>";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/custom.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LchmTUqAAAAADSYfuXEbzeNWDjLcNouYe45NP1m"></script>
</head>

<?php include "header.php"; ?>
<br>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

<body>
    <div class="container">
        <h1 class="center-text">Iniciar Sesión</h1>
        <form action="login.php" method="post" id="loginForm">
            <fieldset>
                <legend>Iniciar Sesión</legend>
                <label for="nombre_usuario">Nombre de usuario:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="text" id="nombre_usuario"
                    name="nombre_usuario" required>

                <label for="contrasena">Contraseña:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="password" id="contrasena"
                    name="contrasena" required>

                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                <br>
                <button type="submit" class="button primary">Iniciar sesión</button>
                <button><a href="registro.php">No tengo cuenta. Registrarme</a></button>
            </fieldset>
        </form>
    </div>

    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LchmTUqAAAAADSYfuXEbzeNWDjLcNouYe45NP1m', {
                action: 'login'
            }).then(function (token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>
</body>

</html>