<?php

include "conexion.php";

// Función para calcular el tiempo transcurrido
if (!function_exists('tiempoTranscurrido')) {
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
}

$fecha = new DateTime($hilo['fecha_creacion']);
// Formatear la fecha en "hace N tiempo"
$fecha_formateada = tiempoTranscurrido($fecha->format('Y-m-d H:i:s'));

$titulo_preview = mb_strimwidth($hilo['titulo'], 0, 100, '...');
$contenido_preview = mb_strimwidth($hilo['contenido'], 0, 100, '...');

$sql_datos_adicionales = "SELECT COUNT(comentarios.id_comentario) AS num_comentarios, 
                                 MAX(comentarios.fecha_comentario) AS fecha_ultimo_comentario 
                          FROM comentarios 
                          WHERE comentarios.id_hilo = ?";
$stmt_datos_adicionales = $conexion->prepare($sql_datos_adicionales);
$stmt_datos_adicionales->bind_param("i", $hilo['id_hilo']);
$stmt_datos_adicionales->execute();
$result_datos_adicionales = $stmt_datos_adicionales->get_result();
$datos_adicionales = $result_datos_adicionales->fetch_assoc();

$num_comentarios = $datos_adicionales['num_comentarios'];
$fecha_ultimo_comentario = $datos_adicionales['fecha_ultimo_comentario'];

// Si hay fecha de último comentario, mostrar el tiempo transcurrido
$tiempo_ultimo_comentario = $fecha_ultimo_comentario ? tiempoTranscurrido($fecha_ultimo_comentario) : 'No hay comentarios aún';

// Consulta para obtener los 3 comentarios más recientes del hilo
$sql_comentarios = "SELECT contenido 
                    FROM comentarios 
                    WHERE id_hilo = ? AND eliminado = 0 
                    ORDER BY fecha_comentario DESC 
                    LIMIT 3";
$stmt_comentarios = $conexion->prepare($sql_comentarios);
$stmt_comentarios->bind_param("i", $hilo['id_hilo']);
$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();
$comentarios = [];

while ($comentario = $result_comentarios->fetch_assoc()) {
    // Limitar los comentarios a 20 caracteres
    $comentarios[] = mb_strimwidth($comentario['contenido'], 0, 20, '...');
}

?>

<div class="hilo">
    <div class="hilo-info">
        <div class="row">
            <div class="col">
                <h4>
                    <a href="ver_hilo.php?id=<?php echo $hilo['id_hilo']; ?>" class="hilo-titulo">
                        <?php echo htmlspecialchars($titulo_preview); ?>
                    </a>
                </h4>
            </div>
            <div class="col">
                <p class="hilo-fecha">Creado: hace <?php echo htmlspecialchars($fecha_formateada); ?></p>
            </div>
        </div>
        <p>
        <h5 class="hilo-contenido"><?php echo htmlspecialchars($contenido_preview); ?></h5>
        </p>
        <hr>

        <!-- Mostrar los 3 comentarios más recientes -->
        <?php if (count($comentarios) > 0): ?>
            <div class="hilo-comentarios-recientes">
                <h6>Comentarios recientes:</h6>
                <?php foreach ($comentarios as $comentario): ?>
                    <small>- <?php echo htmlspecialchars($comentario); ?></small><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="row hilo-adicional-info">
            <div class="col">
                <small><?php echo htmlspecialchars($hilo['visitas']); ?> visitas</small>
            </div>
            <div class="col">
                <small><?php echo htmlspecialchars($num_comentarios); ?> comentarios</small>
            </div>
            <div class="col">
                <small>Último comentario: hace <?php echo htmlspecialchars($tiempo_ultimo_comentario); ?></small>
            </div>
        </div>
    </div>
</div>