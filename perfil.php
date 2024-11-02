<?php
session_start();
include "conexion.php";

$id_usuario = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0);

if ($id_usuario === 0) {
    echo "<script>
                    alert('Perfil no especificado.');
                    window.location.href = 'index.php';
                </script>";
    exit;
}

$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    $sql_hilos = "SELECT * FROM hilos WHERE id_usuario = ? AND eliminado = 0 ORDER BY fecha_creacion DESC";
    $stmt_hilos = $conexion->prepare($sql_hilos);
    $stmt_hilos->bind_param("i", $id_usuario);
    $stmt_hilos->execute();
    $result_hilos = $stmt_hilos->get_result();
} else {
    echo "<script>
                    alert('Usuario no encontrado.');
                    window.location.href = 'index.php';
                </script>";
    exit;
}

$nombre_usuario_actual = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Invitado';

function tiempoTranscurrido($fecha)
{
    $fecha_inicio = new DateTime($fecha);
    $fecha_actual = new DateTime();
    $diferencia = $fecha_inicio->diff($fecha_actual);

    if ($diferencia->y > 0) {
        return $diferencia->y . ' años';
    } elseif ($diferencia->m > 0) {
        return $diferencia->m . ' meses';
    } elseif ($diferencia->d > 0) {
        return $diferencia->d . ' días';
    } elseif ($diferencia->h > 0) {
        return $diferencia->h . ' horas';
    } elseif ($diferencia->i > 0) {
        return $diferencia->i . ' minutos';
    } else {
        return 'hace unos momentos';
    }
}

$tiempo_registro = tiempoTranscurrido($usuario['fecha_registro']);
$tiempo_edicion = !empty($usuario['fecha_edicion']) ? tiempoTranscurrido($usuario['fecha_edicion']) : null;

$sql_comentarios = "SELECT c.*, h.titulo AS titulo_hilo FROM comentarios c 
                    INNER JOIN hilos h ON c.id_hilo = h.id_hilo 
                    WHERE c.id_usuario = ? AND c.eliminado = 0 
                    ORDER BY c.fecha_comentario DESC";

$stmt_comentarios = $conexion->prepare($sql_comentarios);
$stmt_comentarios->bind_param("i", $id_usuario);
$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();

$sql_comentarios = "SELECT c.*, u.nombre_usuario, u.foto_perfil, h.titulo AS titulo_hilo 
                    FROM comentarios c 
                    INNER JOIN hilos h ON c.id_hilo = h.id_hilo 
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario 
                    WHERE c.id_usuario = ? AND c.eliminado = 0 
                    ORDER BY c.fecha_comentario DESC";

$stmt_comentarios = $conexion->prepare($sql_comentarios);
$stmt_comentarios->bind_param("i", $id_usuario);
$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();

$comentarios_formateados = [];

while ($comentario = $result_comentarios->fetch_assoc()) {
    $comentario['tiempo_comentario'] = tiempoTranscurrido($comentario['fecha_comentario']);
    $comentario['tiempo_edicion'] = !empty($comentario['fecha_edicion']) ? tiempoTranscurrido($comentario['fecha_edicion']) : null;
    $comentarios_formateados[] = $comentario;
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/custom.css">
    <link rel="stylesheet" href="style/style.css">
</head>

<?php include "header.php"; ?>
<br>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

<body>
    <div class="container">
        <h1 class="center-text">
            Perfil de <?php echo htmlspecialchars($usuario['nombre_usuario']); ?>
        </h1>

        <div class="center-text">
            <?php if (!empty($usuario['foto_perfil'])): ?>
                <img src="<?php echo 'uploads/perfil/' . htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de Perfil"
                    style="max-height: 150px; width: auto; border-radius: 50%;">
            <?php else: ?>
                <img src="uploads/perfil/default.png" alt="Foto de Perfil Predeterminada"
                    style="max-height: 150px; width: auto; border-radius: 50%;">
            <?php endif; ?>
        </div>

        <?php if ($nombre_usuario_actual === $usuario['nombre_usuario']): ?>
            <div class="center-text">
                <form action="actualizar_foto_perfil.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                    <div class="row">
                        <div class="col">
                            <input type="file" id="nueva_foto_perfil" name="nueva_foto_perfil" accept="image/*" required>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="button primary">Actualizar foto de perfil</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="row">
                <div class="col">
                    <strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?>
                </div>
                <div class="col">
                    Registrado hace <strong><?php echo $tiempo_registro; ?></strong>
                </div>
                <?php if ($tiempo_edicion): ?>
                    <div class="col">
                        Última edición hace <strong><?php echo $tiempo_edicion; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="col">
                    <?php if ($nombre_usuario_actual === $usuario['nombre_usuario']): ?>
                        <a class="button secondary" href="reset_password.php">Cambiar contraseña <img
                                src="https://icongr.am/feather/edit.svg?size=16&color=currentColor"
                                alt="cambiar contraseña"></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <br>

        <div class="container">
            <h1 class="center-text">Mis Hilos</h1>
            <div class="hilos-grid">
                <?php if ($result_hilos->num_rows > 0): ?>
                    <?php while ($hilo = $result_hilos->fetch_assoc()): ?>
                        <?php include "hilo.php"; ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No has creado ningún hilo.</p>
                <?php endif; ?>
            </div>
        </div>
        <br>
        <div class="container">
            <h1 class="center-text">Mis comentarios</h1>
            <?php if (count($comentarios_formateados) > 0): ?>
                <?php include "comentario.php"; ?>
            <?php else: ?>
                <p class="center-text">No has hecho ningún comentario.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

<?php include "footer.php"; ?>

</html>