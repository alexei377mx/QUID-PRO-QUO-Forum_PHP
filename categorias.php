<?php
session_start();
include "conexion.php";

// Definir cuántos hilos por página se mostrarán
$hilosPorPagina = 8;

// Obtener la categoría desde la URL y la página actual
$id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $paginaActual = (int) $_GET['page'];
} else {
    $paginaActual = 1;
}

// Calcular el offset para la consulta SQL
$offset = ($paginaActual - 1) * $hilosPorPagina;

// Consulta SQL para obtener las categorías
$sql_categorias = "SELECT id_categoria, nombre FROM categorias ORDER BY nombre";
$resultado_categorias = $conexion->query($sql_categorias);

if ($resultado_categorias === false) {
    echo "<script>
        alert('Error en la consulta de categorías: " . $conexion->error . "');
        window.history.back();
    </script>";
    exit;
}

// Consulta SQL con paginación para obtener los hilos de la categoría seleccionada
$sql_hilos = "SELECT h.*, c.nombre AS categoria_nombre 
              FROM hilos h
              LEFT JOIN categorias c ON h.id_categoria = c.id_categoria
              WHERE c.id_categoria = ? OR ? = 0
              ORDER BY h.fecha_creacion DESC
              LIMIT ? OFFSET ?";
$stmt = $conexion->prepare($sql_hilos);
if ($stmt === false) {
    echo "<script>
        alert('Error en la preparación de la consulta de hilos: " . $conexion->error . "');
        window.history.back();
    </script>";
    exit;
}
$stmt->bind_param('iiii', $id_categoria, $id_categoria, $hilosPorPagina, $offset);
$stmt->execute();
$resultado_hilos = $stmt->get_result();

if ($resultado_hilos === false) {
    echo "<script>
        alert('Error en la consulta de hilos: " . $conexion->error . "');
        window.history.back();
    </script>";
    exit;
}

// Obtener el número total de hilos en la categoría seleccionada (sin paginación)
$sql_total_hilos = "SELECT COUNT(*) as total FROM hilos WHERE id_categoria = ? OR ? = 0";
$stmt_total = $conexion->prepare($sql_total_hilos);
if ($stmt_total === false) {
    echo "<script>
        alert('Error en la preparación de la consulta del total de hilos: " . $conexion->error . "');
        window.history.back();
    </script>";
    exit;
}
$stmt_total->bind_param('ii', $id_categoria, $id_categoria);
$stmt_total->execute();
$resultado_total_hilos = $stmt_total->get_result();
$total_hilos = $resultado_total_hilos->fetch_assoc()['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($total_hilos / $hilosPorPagina);

// Obtener el nombre de la categoría seleccionada
$nombre_categoria = "todas las categorías";
if ($id_categoria > 0) {
    $sql_nombre_categoria = "SELECT nombre FROM categorias WHERE id_categoria = ?";
    $stmt_categoria = $conexion->prepare($sql_nombre_categoria);
    if ($stmt_categoria === false) {
        echo "<script>
            alert('Error en la consulta del nombre de la categoría: " . $conexion->error . "');
            window.history.back();
        </script>";
        exit;
    }
    $stmt_categoria->bind_param('i', $id_categoria);
    $stmt_categoria->execute();
    $resultado_categoria = $stmt_categoria->get_result();

    if ($resultado_categoria->num_rows > 0) {
        $fila_categoria = $resultado_categoria->fetch_assoc();
        $nombre_categoria = $fila_categoria['nombre'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías del Foro</title>
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
        <h2 class="center-text">Hilos sobre <?php echo htmlspecialchars($nombre_categoria); ?>:</h2>
        <div class="hilos-grid">
            <?php if ($resultado_hilos->num_rows > 0): ?>
                <?php while ($hilo = $resultado_hilos->fetch_assoc()): ?>
                    <?php include "hilo.php"; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay hilos en esta categoría.</p>
            <?php endif; ?>
        </div>

        <!-- Paginación -->
        <div class="pagination">
            <?php if ($paginaActual > 1): ?>
                <a href="categorias.php?id=<?php echo $id_categoria; ?>&page=<?php echo $paginaActual - 1; ?>">&laquo;
                    Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a href="categorias.php?id=<?php echo $id_categoria; ?>&page=<?php echo $i; ?>" <?php if ($i === $paginaActual)
                          echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <a href="categorias.php?id=<?php echo $id_categoria; ?>&page=<?php echo $paginaActual + 1; ?>">Siguiente
                    &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</body>

<?php include "footer.php"; ?>

</html>

<?php
$conexion->close();
?>