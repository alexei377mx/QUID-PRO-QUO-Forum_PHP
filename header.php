<?php
include "conexion.php";

$sql_categorias = "SELECT id_categoria, nombre FROM categorias";
$result_categorias = $conexion->query($sql_categorias);

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
    <link rel="stylesheet" href="style/chota.css">
    <link rel="stylesheet" href="style/custom.css">

    <link rel="stylesheet" href="style/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" href="style/file-1t53CpMro539FfpGYoSEO6Hd.jpg" type="image/png">
</head>

<body>
    <header>
        <div style="display: flex; align-items: center;">
            <a href="index.php" style="display: flex; align-items: center;">
                <img src="style/file-1t53CpMro539FfpGYoSEO6Hd.jpg" alt="Logo del foro"
                    style="width: 40px; height: 40px; margin-right: 10px;">
                <h4>Quid Pro Quo FORUM</h4>
            </a>
        </div>
        <div>
            <audio id="reproductor" hidden autoplay>
                <source id="audioSource" src="" type="audio/mpeg">
                Tu navegador no soporta el elemento de audio.
            </audio>

            <div style="display: flex; flex-direction: column; align-items: center;">
                <div class="radio-controls">
                    <div class="row">
                        <button onclick="cambiarEmisoraAnterior()" class="button">
                            <img src="https://icongr.am/feather/skip-back.svg?size=15&color=currentColor"
                                alt="Anterior">
                        </button>
                        <button onclick="toggleMute()" id="muteButton" class="button">
                            <img id="muteIcon" src="https://icongr.am/feather/volume-2.svg?size=15&color=currentColor"
                                alt="Mute">
                        </button>
                        <button onclick="cambiarEmisoraSiguiente()" class="button">
                            <img src="https://icongr.am/feather/skip-forward.svg?size=15&color=currentColor"
                                alt="Siguiente">
                        </button>
                    </div>
                </div>

                <small id="nombreRadio" style="margin-top: 5px; font-size: 12px; color: #333;"></small>
            </div>
        </div>

        <button id="menuButton" class="button hide-md">
            <img src="https://icongr.am/feather/menu.svg?size=15&color=currentColor" alt="Menú">
        </button>

        <nav>
            <?php if (isset($_SESSION['nombre_usuario'])): ?>
                <p style="color: rgb(29, 29, 29);">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>!</p>

                <div class="menu">
                    <p class="button">Categorías</p>
                    <div class="menu-content">
                        <?php while ($row = $result_categorias->fetch_assoc()): ?>
                            <a href="categorias.php?id=<?php echo htmlspecialchars($row['id_categoria']); ?>">
                                <?php echo htmlspecialchars($row['nombre']); ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <p><a href="crear_hilo.php" class="button primary">Crear un nuevo hilo</a></p>

                <?php if ($_SESSION['nombre_usuario'] === 'admin'): ?>
                    <p><a href="admin.php" class="button dark">Administración</a></p>
                <?php endif; ?>

                <div class="menu">
                    <p class="button">Menú</p>
                    <div class="menu-content">
                        <a href="perfil.php">Mi perfil</a>
                        <a href="logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <p><a href="login.php" class="button primary">Iniciar sesión</a></p>
            <?php endif; ?>
            <div class="col"></div>
            <div class="col"></div>

            <!-- Ícono de modo oscuro/claro -->
            <!--     <button id="darkModeToggle" class="button secondary">
                <i class="fas fa-moon"></i>
            </button> -->
        </nav>

        <div class="mobile-menu" id="mobileMenu">
            <?php if (isset($_SESSION['nombre_usuario'])): ?>
                <p>Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>!</p>
                <a href="crear_hilo.php">Crear un nuevo hilo</a>
                <?php if ($_SESSION['nombre_usuario'] === 'admin'): ?>
                    <a href="admin.php">Panel de Administración</a>
                <?php endif; ?>
                <a href="perfil.php">Mi perfil</a>
                <a href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <script>
        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
        });


        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
        });
    </script>
    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const rootElement = document.documentElement;
        const darkModeIcon = darkModeToggle.querySelector('i');

        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            rootElement.classList.add('dark-mode');
            darkModeIcon.classList.remove('fa-moon');
            darkModeIcon.classList.add('fa-sun');
        }

        darkModeToggle.addEventListener('click', () => {
            if (rootElement.classList.contains('dark-mode')) {
                rootElement.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                darkModeIcon.classList.remove('fa-sun');
                darkModeIcon.classList.add('fa-moon');
            } else {
                rootElement.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
            }
        });
    </script>
    <script>
        var radios = <?php echo json_encode($radios); ?>;
        var indiceActual = 0;

        document.addEventListener("DOMContentLoaded", function () {
            var reproductor = document.getElementById("reproductor");
            var audioSource = document.getElementById("audioSource");
            var nombreRadio = document.getElementById("nombreRadio");

            var savedRadioIndex = localStorage.getItem("selectedRadioIndex");
            if (savedRadioIndex !== null) {
                indiceActual = parseInt(savedRadioIndex, 10);
            }

            audioSource.src = radios[indiceActual].url;
            nombreRadio.textContent = radios[indiceActual].nombre;
            reproductor.load();
            reproductor.play().catch(function () {
                console.log("Autoplay bloqueado, esperando interacción del usuario.");
                document.addEventListener("click", function () {
                    reproductor.play();
                }, { once: true });
            });
        });

        function actualizarEmisora() {
            var reproductor = document.getElementById("reproductor");
            var audioSource = document.getElementById("audioSource");
            var nombreRadio = document.getElementById("nombreRadio");

            audioSource.src = radios[indiceActual].url;
            nombreRadio.textContent = radios[indiceActual].nombre;
            reproductor.load();
            reproductor.play();

            localStorage.setItem("selectedRadioIndex", indiceActual);
        }

        function cambiarEmisoraSiguiente() {
            indiceActual = (indiceActual + 1) % radios.length;
            actualizarEmisora();
        }

        function cambiarEmisoraAnterior() {
            indiceActual = (indiceActual - 1 + radios.length) % radios.length;
            actualizarEmisora();
        }

        function toggleMute() {
            var reproductor = document.getElementById("reproductor");
            var muteIcon = document.getElementById("muteIcon");

            if (reproductor.muted) {
                reproductor.muted = false;
                muteIcon.src = "https://icongr.am/feather/volume-2.svg?size=15&color=currentColor";
                localStorage.setItem("isMuted", "false");
            } else {
                reproductor.muted = true;
                muteIcon.src = "https://icongr.am/feather/volume-x.svg?size=15&color=currentColor";
                localStorage.setItem("isMuted", "true");
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            var reproductor = document.getElementById("reproductor");
            var muteIcon = document.getElementById("muteIcon");

            var isMuted = localStorage.getItem("isMuted");

            if (isMuted === "true") {
                reproductor.muted = true;
                muteIcon.src = "https://icongr.am/feather/volume-x.svg?size=15&color=currentColor";
            } else {
                reproductor.muted = false;
                muteIcon.src = "https://icongr.am/feather/volume-2.svg?size=15&color=currentColor";
            }
        });

    </script>

</body>

</html>