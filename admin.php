<?php
session_start();
include "conexion.php";
require 'libs/Parsedown.php';

$parsedown = new Parsedown();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] !== 'admin') {
    echo "<script>
        alert('No tienes permiso para acceder a esta página.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['revisado'])) {
    $id_reporte = intval($_POST['id_reporte']);
    $revisado = intval($_POST['revisado']);

    $stmt_update = $conexion->prepare("UPDATE reportes SET revisado = ? WHERE id_reporte = ?");
    $stmt_update->bind_param("ii", $revisado, $id_reporte);
    $stmt_update->execute();
    $stmt_update->close();
}

$tipo_objeto = isset($_GET['tipo_objeto']) ? $_GET['tipo_objeto'] : '';
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
$revisado_filtro = isset($_GET['revisado']) ? $_GET['revisado'] : '';

$sql = "SELECT r.*, 
               u.nombre_usuario, 
               h.titulo AS hilo_titulo, 
               c.contenido AS comentario_contenido, 
               COALESCE(h.id_hilo, c.id_hilo) AS id_hilo,
               c.id_comentario 
        FROM reportes r
        LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
        LEFT JOIN hilos h ON r.tipo_objeto = 'hilo' AND r.id_objeto = h.id_hilo
        LEFT JOIN comentarios c ON r.tipo_objeto = 'comentario' AND r.id_objeto = c.id_comentario
        WHERE 1=1";

if (!empty($tipo_objeto)) {
    $sql .= " AND r.tipo_objeto = ?";
}
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $sql .= " AND r.fecha_reporte BETWEEN ? AND ?";
}
if ($revisado_filtro !== '') {
    $sql .= " AND r.revisado = ?";
}

$sql .= " ORDER BY r.fecha_reporte DESC";

$params = [];
$types = '';
if (!empty($tipo_objeto)) {
    $params[] = $tipo_objeto;
    $types .= 's';
}
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $params[] = $fecha_inicio;
    $params[] = $fecha_fin;
    $types .= 'ss';
}
if ($revisado_filtro !== '') {
    $params[] = intval($revisado_filtro);
    $types .= 'i';
}

$stmt = $conexion->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_radio'], $_POST['url_radio'])) {
    $nombre_radio = $_POST['nombre_radio'];
    $url_radio = $_POST['url_radio'];

    $stmt = $conexion->prepare("INSERT INTO radio (nombre, url) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre_radio, $url_radio);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit();
}

if (isset($_GET['eliminar_radio'])) {
    $id_radio = $_GET['eliminar_radio'];

    $stmt = $conexion->prepare("DELETE FROM radio WHERE id_radio = ?");
    $stmt->bind_param("i", $id_radio);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit();
}

$result_radios = $conexion->query("SELECT * FROM radio");
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administrador</title>
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
        <h1 class="center-text">Panel de administrador</h1>
        <form method="GET" action="">
            <div class="row">
                <div class="col">
                    <label for="tipo_objeto">Tipo de reporte:</label>
                    <select name="tipo_objeto" id="tipo_objeto" class="container">
                        <option value="">Todos</option>
                        <option value="hilo" <?php if ($tipo_objeto == 'hilo')
                            echo 'selected'; ?>>Hilos</option>
                        <option value="comentario" <?php if ($tipo_objeto == 'comentario')
                            echo 'selected'; ?>>Comentarios
                        </option>
                    </select>
                </div>
                <div class="col">
                    <label for="fecha_inicio">Fecha de inicio:</label>
                    <input class="container" type="date" name="fecha_inicio" id="fecha_inicio"
                        value="<?php echo htmlspecialchars($fecha_inicio); ?>">
                </div>
                <div class="col">
                    <label for="fecha_fin">Fecha de fin:</label>
                    <input class="container" type="date" name="fecha_fin" id="fecha_fin"
                        value="<?php echo htmlspecialchars($fecha_fin); ?>">
                </div>
                <div class="col">
                    <label for="revisado">Estado de revisión:</label>
                    <select name="revisado" id="revisado" class="container">
                        <option value="">Todos</option>
                        <option value="1" <?php if ($revisado_filtro === '1')
                            echo 'selected'; ?>>Revisado</option>
                        <option value="0" <?php if ($revisado_filtro === '0')
                            echo 'selected'; ?>>No revisado</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="Filtrar" class="button primary">
            <a href="admin.php" class="button error">Borrar filtro</a>
        </form>
        <?php if ($result->num_rows > 0): ?>
            <br>
            <ul class="reportes-list">
                <?php while ($reporte = $result->fetch_assoc()): ?>
                    <li class="reporte-item">
                        <div class="reporte-header">
                            <div class="row">
                                <div class="col-6">
                                    <strong><?php echo htmlspecialchars($reporte['nombre_usuario']); ?></strong> reportó
                                    <?php echo htmlspecialchars($reporte['tipo_objeto']); ?>
                                    <?php if ($reporte['tipo_objeto'] === 'hilo'): ?>
                                        <a href="ver_hilo.php?id=<?php echo htmlspecialchars($reporte['id_hilo']); ?>">
                                            "<?php echo htmlspecialchars($reporte['hilo_titulo']); ?>"
                                        </a>
                                    <?php elseif ($reporte['tipo_objeto'] === 'comentario'): ?>
                                        <a
                                            href="http://localhost:3000/ver_hilo.php?id=<?php echo htmlspecialchars($reporte['id_hilo']); ?>#comentario-<?php echo htmlspecialchars($reporte['id_comentario']); ?>">
                                            Comentario #<?php echo htmlspecialchars($reporte['id_comentario']); ?>
                                        </a>
                                    <?php endif; ?>

                                    <br>
                                    Motivo: <strong><?php echo htmlspecialchars($reporte['motivo']); ?></strong>
                                </div>
                                <div class="col-4">
                                    Reportado hace
                                    <strong><?php echo tiempoTranscurrido($reporte['fecha_reporte']); ?></strong>
                                </div>
                                <div class="col-2 is-right">
                                    <form method="POST" action="admin.php" style="display: inline;">
                                        <input type="hidden" name="id_reporte" value="<?php echo $reporte['id_reporte']; ?>">
                                        <input type="hidden" name="revisado"
                                            value="<?php echo $reporte['revisado'] ? 0 : 1; ?>">
                                        <input type="checkbox"
                                            onclick="return confirm('¿Estás seguro de que deseas cambiar el estado de revisión?');"
                                            onchange="this.form.submit();" <?php echo $reporte['revisado'] ? 'checked' : ''; ?>>
                                        <label>Revisado</label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="center-text">No hay reportes en este momento.</p>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1 class="center-text">Administración de Radios</h1>
        <form method="POST" action="admin.php">
            <div class="row">
                <div class="col">
                    <label for="nombre_radio">Nombre de la Radio:</label>
                    <input type="text" name="nombre_radio" id="nombre_radio" required class="container">
                </div>
                <div class="col">
                    <label for="url_radio">URL de la Radio:</label>
                    <input type="text" name="url_radio" id="url_radio" required class="container">
                </div>
            </div>
            <input type="submit" value="Agregar Radio" class="button primary">
        </form>

        <?php if ($result_radios->num_rows > 0): ?>
            <br>
            <ul class="list">
                <?php while ($radio = $result_radios->fetch_assoc()): ?>
                    <li class="list-item">
                        <div class="row">
                            <div class="col-4">
                                <strong>Nombre de la Radio:</strong>
                                <?php echo htmlspecialchars($radio['nombre']); ?>
                            </div>
                            <div class="col-6">
                                <strong>URL:</strong>
                                <a href="<?php echo htmlspecialchars($radio['url']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($radio['url']); ?>
                                </a>
                            </div>
                            <div class="col-2 is-right">
                                <a href="admin.php?eliminar_radio=<?php echo $radio['id_radio']; ?>" class="button error"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta radio?');">
                                    Eliminar
                                </a>
                            </div>
                        </div>

                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay radios registradas.</p>
        <?php endif; ?>

        <?php $conexion->close(); ?>
    </div>
</body>

<?php include "footer.php"; ?>

</html>