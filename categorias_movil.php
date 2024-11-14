<?php
session_start();
include "conexion.php";

$sql_categorias = "SELECT c.id_categoria, c.nombre, COUNT(h.id_hilo) AS numero_hilos
                   FROM categorias c
                   LEFT JOIN hilos h ON c.id_categoria = h.id_categoria AND h.eliminado = 0
                   GROUP BY c.id_categoria
                   ORDER BY c.id_categoria";

$resultado_categorias = $conexion->query($sql_categorias);

if ($resultado_categorias === false) {
    echo "<script>
        alert('Error en la consulta de categorías: " . $conexion->error . "');
        window.history.back();
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Categorías</title>
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
        <h2 class="center-text">Categorías del Foro</h2>
        <table class="centered">
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($categoria = $resultado_categorias->fetch_assoc()): ?>
                    <tr>
                        <td class="is-center">
                            <a href="categorias.php?id=<?php echo htmlspecialchars($categoria['id_categoria']); ?>">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                                (<?php echo $categoria['numero_hilos']; ?>)
                            </a>
                            <hr>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conexion->close();
?>