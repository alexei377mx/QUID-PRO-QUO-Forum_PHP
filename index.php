<?php
session_start();
include "conexion.php";

$hilosPorPagina = 8;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $paginaActual = (int) $_GET['page'];
} else {
    $paginaActual = 1;
}

$offset = ($paginaActual - 1) * $hilosPorPagina;

$sql_hilos = "
    SELECT hilos.*, 
           GREATEST(hilos.fecha_creacion, IFNULL(MAX(comentarios.fecha_comentario), hilos.fecha_creacion)) AS ultima_actividad 
    FROM hilos
    LEFT JOIN comentarios ON hilos.id_hilo = comentarios.id_hilo
    WHERE hilos.eliminado = 0
    GROUP BY hilos.id_hilo
    ORDER BY ultima_actividad DESC
    LIMIT $hilosPorPagina OFFSET $offset";

$resultado_hilos = $conexion->query($sql_hilos);

if ($resultado_hilos === false) {
    die("Error en la consulta: " . $conexion->error);
}

$sql_total_hilos = "SELECT COUNT(*) as total FROM hilos WHERE eliminado = 0"; 
$resultado_total_hilos = $conexion->query($sql_total_hilos);
$total_hilos = $resultado_total_hilos->fetch_assoc()['total'];

$totalPaginas = ceil($total_hilos / $hilosPorPagina);

$sql_radios = "SELECT * FROM radio";
$resultado_radios = $conexion->query($sql_radios);

if ($resultado_radios === false) {
    die("Error al obtener las radios: " . $conexion->error);
}

$radios = [];
while ($radio = $resultado_radios->fetch_assoc()) {
    $radios[] = $radio;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUID PRO QUO Forum</title>
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
        <h2 class="center-text">Hilos más recientes</h2>
        <div class="hilos-grid">
            <?php if ($resultado_hilos->num_rows > 0): ?>
                <?php while ($hilo = $resultado_hilos->fetch_assoc()): ?>
                    <?php include "hilo.php"; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay hilos disponibles.</p>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <?php if ($paginaActual > 1): ?>
                <a href="index.php?page=<?php echo $paginaActual - 1; ?>">&laquo; Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a href="index.php?page=<?php echo $i; ?>" <?php if ($i === $paginaActual)
                       echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <a href="index.php?page=<?php echo $paginaActual + 1; ?>">Siguiente &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

</body>

<?php include "footer.php"; ?>

</html>