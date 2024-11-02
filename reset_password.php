<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>
        alert('Debes iniciar sesión para cambiar tu contraseña.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $contrasena_actual = $_POST['contrasena_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    if (!empty($contrasena_actual) && !empty($nueva_contrasena) && !empty($confirmar_contrasena)) {
        if ($nueva_contrasena === $confirmar_contrasena) {
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $nombre_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();

                if (password_verify($contrasena_actual, $usuario['contrasena'])) {
                    $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                    $sql_update = "UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?";
                    $stmt_update = $conexion->prepare($sql_update);
                    $stmt_update->bind_param("si", $nueva_contrasena_hash, $_SESSION['id_usuario']);

                    if ($stmt_update->execute()) {
                        echo "<script>
                            alert('Contraseña actualizada con éxito.');
                            window.history.go(-2);
                        </script>";
                        exit();
                    } else {
                        echo "<script>
                            alert('Error al actualizar la contraseña: " . $stmt_update->error . "');
                            window.history.back();
                        </script>";
                        exit();
                    }
                } else {
                    echo "<script>
                        alert('La contraseña actual es incorrecta.');
                        window.history.back();
                    </script>";
                    exit();
                }
            } else {
                echo "<script>
                    alert('Usuario no encontrado.');
                    window.history.back();
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('La nueva contraseña y su confirmación no coinciden.');
                window.history.back();
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Todos los campos son obligatorios.');
            window.history.back();
        </script>";
        exit();
    }
}

$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/custom.css">
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
        <h1 class="center-text">Restablecer Contraseña</h1>
        <form action="reset_password.php" method="post">
            <fieldset>
                <legend>Cambiar Contraseña</legend>
                <label for="contrasena_actual">Contraseña Actual:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="password" id="contrasena_actual"
                    name="contrasena_actual" required>

                <label for="nueva_contrasena">Nueva Contraseña:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="password" id="nueva_contrasena"
                    name="nueva_contrasena" required>

                <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="password" id="confirmar_contrasena"
                    name="confirmar_contrasena" required>

            </fieldset>
            <br>
            <button type="submit" class="button primary">Cambiar Contraseña</button>
            <button><a href="index.php">Volver a la página principal</a></button>
        </form>
    </div>
</body>

</html>