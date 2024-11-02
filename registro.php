<?php
session_start();
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $email = trim($_POST['email']);
    $contrasena = $_POST['contrasena'];
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    $dominios_permitidos = [
        "gmail.com",
        "hotmail.com",
        "yahoo.com",
        "outlook.com",
        "icloud.com",
        "aol.com",
        "zoho.com",
        "mail.com",
        "yandex.com",
        "protonmail.com",
        "gmx.com",
        "live.com",
        "msn.com"
    ];
    $email_dominio = substr(strrchr($email, "@"), 1);

    if (!in_array($email_dominio, $dominios_permitidos)) {
        echo "<script>
            alert('Por favor, utiliza un email de un dominio permitido.');
            window.location.href = 'registro.php';
        </script>";
        exit();
    }

    if (!empty($nombre_usuario) && !empty($email) && !empty($contrasena)) {
        $sql = "SELECT id_usuario FROM usuarios WHERE nombre_usuario = ? OR email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre_usuario, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>
                alert('El nombre de usuario o el correo electrónico ya están en uso.');
                window.location.href = 'registro.php';
            </script>";
        } else {
            $sql = "INSERT INTO usuarios (nombre_usuario, email, contrasena) VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $nombre_usuario, $email, $contrasena);

                try {
                    if ($stmt->execute()) {
                        $id_usuario = $conexion->insert_id;

                        $_SESSION['id_usuario'] = $id_usuario;
                        $_SESSION['nombre_usuario'] = $nombre_usuario;

                        header("Location: index.php");
                        exit();
                    } else {
                        throw new Exception($stmt->error);
                    }
                } catch (Exception $e) {
                    echo "<p>Error al registrarse: " . $e->getMessage() . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p>Error al preparar la consulta: " . $conexion->error . "</p>";
            }
        }
        $stmt->close();
    } else {
        echo "<script>
            alert('Todos los campos son obligatorios.');
            window.location.href = 'registro.php';
        </script>";
    }
}

$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/custom.css">
</head>

<?php include "header.php"; ?>
<br>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

<body>
    <div class="container">
        <h1 class="center-text">Registro de Usuario</h1>
        <form action="registro.php" method="post">
            <fieldset>
                <legend>Registro</legend>
                <label for="nombre_usuario">Nombre de usuario:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="text" id="nombre_usuario"
                    name="nombre_usuario" required>

                <label for="email">Email:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="email" id="email" name="email"
                    required>

                <label for="contrasena">Contraseña:</label>
                <input style="color: rgb(29, 29, 29);" class="comment-form" type="password" id="contrasena"
                    name="contrasena" required>

                <button type="submit" class="button primary">Registrar</button>

                <button><a href="login.php">Ya tengo cuenta. Iniciar sesión</a></button>
            </fieldset>
        </form>
    </div>
</body>

</html>