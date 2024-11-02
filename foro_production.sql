-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2024 a las 15:50:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `foro_production`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'Sobre el foro'),
(2, 'Modelos 3D'),
(3, 'General'),
(4, 'Política'),
(5, 'Películas / Series'),
(6, 'Deportes'),
(7, 'Anime / Manga'),
(8, 'Educación'),
(9, 'LGBTTTQI+'),
(10, 'Comercio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_hilo` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `contenido` text NOT NULL,
  `fecha_comentario` datetime DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `imagen_ruta` varchar(255) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hilos`
--

CREATE TABLE `hilos` (
  `id_hilo` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `imagen_ruta` varchar(255) DEFAULT NULL,
  `visitas` int(11) DEFAULT 0,
  `eliminado` tinyint(1) DEFAULT 0,
  `obj_ruta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hilos`
--

INSERT INTO `hilos` (`id_hilo`, `id_usuario`, `titulo`, `contenido`, `fecha_creacion`, `fecha_edicion`, `id_categoria`, `imagen_ruta`, `visitas`, `eliminado`, `obj_ruta`) VALUES
(1, 1, 'Bienvenida', '# ¡Bienvenido/a al Foro! 🎉\r\n\r\n> Nos alegra que estés aquí para **compartir**, **aprender** y **debatir** en esta comunidad. Explora las categorías, encuentra temas de interés y no dudes en iniciar tus propias conversaciones.\r\n\r\n> **Consejo:** No olvides leer las [Políticas de uso justo](https://quidproquo.great-site.net/politica.php) para una convivencia respetuosa y enriquecedora para todos.\r\n\r\n¡Esperamos que disfrutes de la experiencia y contribuyas con tus ideas! 🚀', '2024-10-29 08:24:24', NULL, 1, NULL, 30, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `radio`
--

CREATE TABLE `radio` (
  `id_radio` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `radio`
--

INSERT INTO `radio` (`id_radio`, `nombre`, `url`) VALUES
(1, 'JAZZGROOVE.org - LAID-BACK JAZZ - The Jazz Groove. Ad Free. (East)', 'https://audio-edge-es6pf.mia.g.radiomast.io/8a384ff3-6fd1-4e5d-b47d-0cbefeffe8d7?icy=https'),
(2, 'JAZZGROOVE.org - LAID-BACK JAZZ - The Jazz Groove. Ad Free. (West)', 'https://audio-edge-es6pf.mia.g.radiomast.io/f0ac4bf3-bbe5-4edb-b828-193e0fdc4f2f?icy=https'),
(3, 'EXA FM', 'https://18213.live.streamtheworld.com/XHEXA_SC'),
(4, 'Horizonte radio', 'https://s2.mexside.net/8014/stream/1/'),
(6, 'Proton Radio Live', ' https://shoutcast.protonradio.com:7000/stream?icy=https'),
(7, 'ANTENNE BAYERN Chillout (Germany)', ' https://s7-webradio.antenne.de/chillout?icy=https'),
(8, 'OPUS 94.5 FM', 'https://s2.mexside.net/8016/stream/1/'),
(11, 'Classical FM Radio', ' https://cheetah.streemlion.com:2460/stream'),
(12, 'ADR.FM - Electronic Dance Experience (EDE)', 'http://patmos.cdnstream.com:9683/stream2'),
(13, '..:: RUSSIAN WAVE - РУССКАЯ ВОЛНА ::.. AMG RADIO', 'https://ru1.amgradio.ru/RuWave48'),
(14, 'Naya Ballad - Soul Kpop (Broad) https://sCast.kr/', 'http://e79.kr/soul'),
(15, 'Jazz Cafe', 'https://radio.wanderingsheep.net:8000/jazzcafe'),
(16, 'Classical FM Radio', 'https://cheetah.streemlion.com:2460/stream'),
(17, 'RadioMonster.FM - Evergreens (320kbps)', 'https://ic.radiomonster.fm/evergreens.ultra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_objeto` enum('hilo','comentario') NOT NULL,
  `id_objeto` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `fecha_reporte` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_edicion` datetime DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `advertencias` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email`, `contrasena`, `fecha_registro`, `fecha_edicion`, `foto_perfil`, `advertencias`, `activo`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$/uoJKLtYn5BT5NcLahJYcO.YMABS4bE/hWUMCvdAfxPpaRclIfSh.', '2024-10-29 08:20:10', NULL, 'Vecteur.jpg', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_hilo` (`id_hilo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `hilos`
--
ALTER TABLE `hilos`
  ADD PRIMARY KEY (`id_hilo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `hilos_ibfk_2` (`id_categoria`);

--
-- Indices de la tabla `radio`
--
ALTER TABLE `radio`
  ADD PRIMARY KEY (`id_radio`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hilos`
--
ALTER TABLE `hilos`
  MODIFY `id_hilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `radio`
--
ALTER TABLE `radio`
  MODIFY `id_radio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_hilo`) REFERENCES `hilos` (`id_hilo`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL;

--
-- Filtros para la tabla `hilos`
--
ALTER TABLE `hilos`
  ADD CONSTRAINT `hilos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `hilos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
