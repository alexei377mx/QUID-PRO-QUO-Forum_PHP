<?php 
session_start();
include "conexion.php";
require 'libs/Parsedown.php';

$parsedown = new Parsedown();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas de Uso Justo</title>
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
        <h1 class="center-text">Políticas de Uso Justo</h1>
        <hr>

        <div class="container">
            <h2>Introducción</h2>
            <p>Bienvenido a QuidProQuoForum. Este foro es un espacio donde los usuarios pueden interactuar, compartir ideas y debatir sobre diferentes temas de manera respetuosa y constructiva. Para mantener un ambiente adecuado para todos, hemos establecido estas <strong>Políticas de Uso Justo</strong>. Al participar en este foro, aceptas cumplir con estas normas. El incumplimiento puede resultar en advertencias, sanciones o la suspensión de tu cuenta.</p>

            <h2>1. Respeto y Buen Comportamiento</h2>
            <h3>1.1. Trato Respetuoso</h3>
            <p>Se espera que todos los usuarios mantengan un tono respetuoso en sus interacciones. No se tolerará el uso de lenguaje ofensivo, insultos, ataques personales, ni ninguna forma de acoso o comportamiento inapropiado.</p>

            <h3>1.2. No Discriminación</h3>
            <p>No se permitirá ningún contenido que promueva la discriminación o el odio en función de la raza, género, orientación sexual, religión, origen étnico, discapacidad u otra característica protegida.</p>

            <h2>2. Contenido Apropiado</h2>
            <h3>2.1. Publicación de Contenidos</h3>
            <p>El contenido publicado en el foro debe ser relevante para el tema de discusión y adecuado para todos los usuarios. Se prohíbe cualquier contenido explícito, violento o dañino.</p>

            <h3>2.2. Contenido Ilegal</h3>
            <p>Está prohibido publicar material ilegal, incluidas, pero no limitadas a:</p>
            <ul>
                <li>Contenido con derechos de autor sin permiso.</li>
                <li>Incitación a actividades ilegales.</li>
                <li>Material explícito o violento.</li>
            </ul>

            <h3>2.3. Spam y Publicidad</h3>
            <p>No se permite la publicación de spam o publicidad no autorizada. Todo contenido comercial debe contar con la autorización previa del equipo de administración del foro.</p>

            <h2>3. Confidencialidad y Privacidad</h2>
            <h3>3.1. Protección de Datos</h3>
            <p>Los usuarios no pueden publicar información personal de otros miembros sin su consentimiento. Esto incluye, pero no se limita a, nombres, direcciones, números de teléfono o cualquier otra información privada.</p>

            <h3>3.2. Seguridad de Cuentas</h3>
            <p>Es responsabilidad de los usuarios mantener la seguridad de sus cuentas. Si sospechas que tu cuenta ha sido comprometida, notifícalo a los administradores de inmediato.</p>

            <h2>4. Sistema de Reportes</h2>
            <h3>4.1. Reporte de Contenido Inapropiado</h3>
            <p>Cualquier usuario registrado puede reportar contenido que considere inapropiado o en violación de las Políticas de Uso Justo. Para hacerlo, simplemente accede al enlace de reporte asociado con el contenido en cuestión.</p>

            <h3>4.2. Consecuencias del Reporte</h3>
            <p>Dependiendo de la gravedad del reporte, el contenido podría ser eliminado, el usuario sancionado o incluso suspendido de la plataforma. La acumulación de <strong>4 o más advertencias</strong> resultará en la suspensión temporal o permanente de la cuenta, dependiendo del caso.</p>

            <h2>5. Moderación</h2>
            <h3>5.1. Intervención de Moderadores</h3>
            <p>Los moderadores tienen la autoridad para editar, eliminar o bloquear cualquier contenido que infrinja estas políticas. También pueden emitir advertencias o suspender temporalmente a los usuarios que incumplan las reglas.</p>

            <h3>5.2. Apelaciones</h3>
            <p>Si un usuario considera que una decisión de moderación ha sido injusta, puede presentar una apelación enviando un correo a quidproquo@forum.com. El equipo de administración revisará el caso y dará una respuesta final.</p>

            <h2>6. Cambios en las Políticas</h2>
            <h3>6.1. Modificaciones</h3>
            <p>Nos reservamos el derecho de modificar estas políticas en cualquier momento. Los cambios serán comunicados a los usuarios, y su continuación en el uso del foro indicará la aceptación de las nuevas condiciones.</p>

            <p><strong>Fecha de la última actualización:</strong> Octubre 2024</p>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>
