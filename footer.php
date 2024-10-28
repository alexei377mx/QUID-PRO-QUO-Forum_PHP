<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos personalizados para el footer */
        .footer {
            background-color: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            color: var(--font-color);
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--color-lightGrey);
            margin-top: 3rem;
        }

        .footer p {
            margin: 0.5rem 0;
        }

        .footer p a {
            color: var(--color-primary);
            text-decoration: none;
        }

        .footer p a:hover {
            opacity: 0.75;
        }
    </style>
</head>

<body>
    <footer class="footer">
        <p>Todo el contenido en esta página es propiedad y responsabilidad de sus respectivos autores.</p>
        <a href="politica.php"><p>Política de uso justo</p></a>
        <p>Contacto: quidproquo@forum.com</p>
        <hr>
        <p>QuidProQuoForum © <?php echo date("Y"); ?></p>
    </footer>
</body>

</html>