<?php
session_start();
include "conexion.php";
require 'libs/Parsedown.php';

$parsedown = new Parsedown();

$id_hilo = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT hilos.*, usuarios.nombre_usuario, usuarios.foto_perfil, categorias.nombre AS categoria
        FROM hilos
        INNER JOIN usuarios ON hilos.id_usuario = usuarios.id_usuario
        LEFT JOIN categorias ON hilos.id_categoria = categorias.id_categoria
        WHERE hilos.id_hilo = ? AND hilos.eliminado = 0";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_hilo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hilo = $result->fetch_assoc();

    $sql_update_visitas = "UPDATE hilos SET visitas = visitas + 1 WHERE id_hilo = ?";
    $stmt_update_visitas = $conexion->prepare($sql_update_visitas);
    $stmt_update_visitas->bind_param("i", $id_hilo);
    $stmt_update_visitas->execute();

    $sql_comentarios = "SELECT comentarios.*, usuarios.nombre_usuario, usuarios.foto_perfil 
                    FROM comentarios
                    INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id_usuario
                    WHERE comentarios.id_hilo = ?
                    ORDER BY comentarios.fecha_comentario DESC";
    $stmt_comentarios = $conexion->prepare($sql_comentarios);
    $stmt_comentarios->bind_param("i", $id_hilo);
    $stmt_comentarios->execute();
    $result_comentarios = $stmt_comentarios->get_result();
} else {
    echo "<script>
        alert('Hilo no encontrado.');
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

$tiempo_creacion = tiempoTranscurrido($hilo['fecha_creacion']);
$tiempo_edicion = !empty($hilo['fecha_edicion']) ? tiempoTranscurrido($hilo['fecha_edicion']) : null;

$comentarios_formateados = [];
while ($comentario = $result_comentarios->fetch_assoc()) {
    $tiempo_comentario = tiempoTranscurrido($comentario['fecha_comentario']);
    $tiempo_edicion_comentario = !empty($comentario['fecha_edicion']) ? tiempoTranscurrido($comentario['fecha_edicion']) : null;

    $contenido_convertido = $parsedown->text($comentario['contenido']);

    $comentarios_formateados[] = [
        'id_comentario' => $comentario['id_comentario'],
        'nombre_usuario' => htmlspecialchars($comentario['nombre_usuario']),
        'tiempo_comentario' => $tiempo_comentario,
        'tiempo_edicion' => $tiempo_edicion_comentario,
        'contenido' => $contenido_convertido,
        'imagen_ruta' => htmlspecialchars($comentario['imagen_ruta']),
        'foto_perfil' => htmlspecialchars($comentario['foto_perfil']),
        'eliminado' => isset($comentario['eliminado']) ? $comentario['eliminado'] : 0
    ];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hilo: <?php echo htmlspecialchars($hilo['titulo']); ?></title>
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/custom.css">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css" rel="stylesheet">
</head>

<?php include "header.php"; ?>
<br>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

<body>
    <script type="importmap">
    {
        "imports": {
            "three": "https://unpkg.com/three@0.153.0/build/three.module.js",
            "three/addons/": "https://unpkg.com/three@0.153.0/examples/jsm/"
        }
    }
    </script>

    <div class="container">
        <h1 class="center-text">
            Hilo:
            <?php echo htmlspecialchars($hilo['titulo']); ?>
            <small>(<?php echo htmlspecialchars($hilo['visitas']); ?> visitas)</small>
            <?php if ($nombre_usuario_actual === $hilo['nombre_usuario']): ?>
                <a href="editar_hilo.php?id=<?php echo htmlspecialchars($id_hilo); ?>" class="button secondary"><img
                        src="https://icongr.am/feather/edit.svg?size=16&color=currentColor" alt="icon"></a>
            <?php endif; ?>

            <a href="reporte.php?tipo=hilo&id=<?php echo htmlspecialchars($id_hilo); ?>" class="button error"><img
                    src="https://icongr.am/feather/alert-triangle.svg?size=16&color=currentColor" alt="Reportar">
                Reportar</a>

            <?php if (isset($_SESSION['nombre_usuario']) && $_SESSION['nombre_usuario'] === 'admin' && !$hilo['eliminado']): ?>
                <a href="eliminar_hilo.php?id_hilo=<?php echo htmlspecialchars($id_hilo); ?>" class="button error"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este hilo?');">
                    <img src="https://icongr.am/feather/trash-2.svg?size=16&color=currentColor" alt="Eliminar"> Eliminar
                    Hilo
                </a>
            <?php endif; ?>
        </h1>

        <div class="row">
            <div class="col">
                <?php if (!empty($hilo['foto_perfil'])): ?>
                    <img src="<?php echo 'uploads/perfil/' . htmlspecialchars($hilo['foto_perfil']); ?>"
                        alt="Foto de perfil"
                        style="max-height: 30px; width: auto; border-radius: 50%; vertical-align: middle;">
                <?php else: ?>
                    <img src="uploads/perfil/default.png" alt="Foto de perfil predeterminada"
                        style="max-height: 30px; width: auto; border-radius: 50%; vertical-align: middle;">
                <?php endif; ?>

                <strong><?php echo htmlspecialchars($hilo['nombre_usuario']); ?></strong> inició este hilo hace
                <?php echo $tiempo_creacion; ?>
            </div>
            <div class="col">
                <?php if ($tiempo_edicion): ?>
                    Última edición hace <strong><?php echo $tiempo_edicion; ?></strong>
                <?php endif; ?>
            </div>
            <div class="col">
                Categoría: <strong><?php echo htmlspecialchars($hilo['categoria']); ?></strong>
            </div>
            <div class="col-1">
                <small>#<?php echo htmlspecialchars($id_hilo); ?></small>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($hilo['imagen_ruta'])): ?>
                <div class="col-is-left">
                    <div class="imagen-hilo">
                        <img src="<?php echo htmlspecialchars($hilo['imagen_ruta']); ?>" alt="Imagen del hilo"
                            style="max-height: 300px; width: auto;">
                    </div>
                </div>
            <?php elseif (!empty($hilo['obj_ruta'])): ?>
                <div class="col">
                    <div id="viewer-container"
                        style="position: relative; width: 100%; height: 500px; border: 1px solid #ccc; padding: 10px;">
                        <!-- Contenedor del visor 3D -->
                        <div id="obj-viewer" style="width: 100%; height: 100%;"></div>

                        <!-- Contenedor del contador de FPS -->
                        <div id="fps-counter"
                            style="position: absolute; top: 10px; right: 10px; background-color: rgba(0, 0, 0, 0.5); color: white; padding: 5px; border-radius: 5px;">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col">
                <div class="contenido">
                    <p><?php echo $parsedown->text($hilo['contenido']); ?></p>
                </div>
            </div>
        </div>

        <hr>

        <h2 class="center-text">Comentarios</h2>

        <?php include "comentario.php"; ?>

        <h2 class="center-text">Agregar Comentario</h2>

        <form action="agregar_comentario.php" method="POST" enctype="multipart/form-data" class="comment-form">
            <label for="comentario">Puedes usar <a href="https://www.markdownguide.org/extended-syntax/">Markdown</a>
                para dar formato a tus
                textos</label>
            <input type="hidden" name="id_hilo" value="<?php echo htmlspecialchars($id_hilo); ?>">
            <textarea style="color: rgb(29, 29, 29);" class="comment-form" id="contenido" name="contenido" rows="10"
                cols="50" required></textarea>

            <label for="imagen">Agregar Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <button type="submit" class="button primary">Agregar Comentario</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.js"></script>
    <script>
        $("#contenido").emojioneArea({
            pickerPosition: "bottom"
        });
    </script>

    <?php if (!empty($hilo['obj_ruta'])): ?>
        <script type="module">
            import * as THREE from 'three';
            import { OBJLoader } from 'three/addons/loaders/OBJLoader.js';
            import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
            import Stats from 'three/addons/libs/stats.module.js';

            let container, stats, controls;
            let camera, scene, renderer, mesh;

            init();
            animate();

            function init() {
                container = document.getElementById('obj-viewer');

                scene = new THREE.Scene();

                camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 1, 10000);
                camera.position.z = 1000;

                renderer = new THREE.WebGLRenderer({ antialias: true });
                renderer.setClearColor(0x000000);

                renderer.setPixelRatio(window.devicePixelRatio);
                renderer.setSize(container.clientWidth, container.clientHeight);
                container.appendChild(renderer.domElement);

                stats = new Stats();
                container.appendChild(stats.dom);

                const ambientLight = new THREE.AmbientLight(0x404040, 0.5);
                scene.add(ambientLight);

                const directionalLight1 = new THREE.DirectionalLight(0xffffff, 0.5);
                directionalLight1.position.set(1, 1, 1).normalize();
                scene.add(directionalLight1);

                const directionalLight2 = new THREE.DirectionalLight(0xffffff, 0.5);
                directionalLight2.position.set(-1, -1, -1).normalize();
                scene.add(directionalLight2);

                controls = new OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true;
                controls.dampingFactor = 0.25;
                controls.screenSpacePanning = false;

                window.addEventListener('resize', onWindowResize);

                loadOBJModel('<?php echo htmlspecialchars($hilo['obj_ruta']); ?>');
            }

            function loadOBJModel(filePath) {
                const loader = new OBJLoader();
                loader.load(
                    filePath,
                    (object) => {
                        if (mesh) {
                            scene.remove(mesh);
                        }

                        mesh = object;

                        mesh.traverse(function (child) {
                            if (child.isMesh) {
                                child.material.side = THREE.DoubleSide;
                            }
                        });

                        scene.add(mesh);

                        const box = new THREE.Box3().setFromObject(mesh);
                        const size = box.getSize(new THREE.Vector3());
                        const center = box.getCenter(new THREE.Vector3());

                        mesh.position.x = -center.x;
                        mesh.position.y = -center.y;
                        mesh.position.z = -center.z;

                        const maxDim = Math.max(size.x, size.y, size.z);
                        const fov = camera.fov * (Math.PI / 180);
                        let cameraZ = Math.abs(maxDim / 2 / Math.tan(fov / 2));
                        camera.position.set(0, 0, cameraZ * 1.2);
                        camera.lookAt(new THREE.Vector3(0, 0, 0));
                        controls.update();
                    },
                    (xhr) => {
                        console.log((xhr.loaded / xhr.total) * 100 + '% cargado');
                    },
                    (error) => {
                        console.error('Error al cargar el archivo OBJ:', error);
                    }
                );
            }

            function onWindowResize() {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            }

            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
                stats.update();
            }
        </script>


    <?php endif; ?>

</body>

<?php include "footer.php"; ?>

</html>