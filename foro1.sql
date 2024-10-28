-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2024 a las 17:16:36
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
-- Base de datos: `foro1`
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
(3, 'Diversión'),
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

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_hilo`, `id_usuario`, `contenido`, `fecha_comentario`, `fecha_edicion`, `imagen_ruta`, `eliminado`) VALUES
(1, 2, 1, 'XD?', '2024-08-22 07:27:09', '2024-08-22 07:27:12', NULL, 0),
(2, 2, 2, 'Soy admin?\r\nno', '2024-08-22 07:27:36', '2024-08-22 07:59:40', NULL, 0),
(3, 2, 2, 'Si soy admin', '2024-08-22 07:27:48', NULL, NULL, 0),
(4, 1, 2, 'Merezco ser admin!', '2024-08-22 07:28:03', '2024-09-10 08:57:58', NULL, 0),
(5, 1, 1, 'si\r\n\r\nLorem ipsum dolor sit amet consectetur adipiscing elit hendrerit, vel quisque nulla felis faucibus aenean tortor, dapibus suscipit tellus leo eget hac morbi. Vulputate magna a tristique ornare vitae sodales non litora ridiculus ullamcorper tempor phasellus, proin curae imperdiet malesuada tortor accumsan quis libero fames penatibus. Leo massa pretium magna facilisi egestas auctor suspendisse senectus rhoncus, vehicula eros nascetur ullamcorper hac cum faucibus per augue vestibulum, sodales congue ridiculus tortor justo interdum ultrices iaculis. Interdum porta sapien iaculis dui pharetra rutrum felis, magnis purus blandit congue volutpat fermentum, pulvinar semper euismod placerat vitae lobortis.', '2024-08-22 07:35:50', '2024-08-27 08:48:13', NULL, 1),
(6, 3, 1, 'si?', '2024-08-22 07:35:56', '2024-08-22 07:36:03', NULL, 0),
(7, 2, 2, 's', '2024-08-22 07:58:22', '2024-08-22 08:11:29', NULL, 0),
(8, 7, 2, 'Si?', '2024-08-22 08:12:54', '2024-08-22 08:12:57', NULL, 0),
(9, 7, 1, 'No?', '2024-08-22 08:13:22', '2024-08-22 08:13:26', NULL, 0),
(26, 10, 3, 'Lorem\r\nLorem', '2024-08-27 14:03:54', '2024-08-27 14:04:07', NULL, 1),
(27, 8, 3, 'si', '2024-08-27 14:29:36', NULL, NULL, 0),
(28, 9, 3, 'si', '2024-08-29 08:10:14', NULL, 'uploads/peakpx.jpg', 0),
(29, 9, 3, 'AAAAAAAAAAAAAA', '2024-08-29 08:11:37', NULL, 'uploads/peakpx.jpg', 0),
(30, 9, 3, 'Si', '2024-08-29 08:18:13', NULL, 'uploads/descarga.png', 0),
(31, 12, 3, 'xs', '2024-08-29 08:26:05', '2024-08-29 08:48:42', 'uploads/pang-yuhao-wCi28eq8TF4-unsplash.jpg', 0),
(32, 13, 3, 'DDD', '2024-08-29 08:29:34', '2024-08-29 08:35:20', 'uploads/pang-yuhao-wCi28eq8TF4-unsplash.jpg', 0),
(33, 12, 3, 'se', '2024-08-29 08:43:07', NULL, NULL, 0),
(34, 14, 2, 'ADMIN', '2024-08-29 08:54:13', NULL, 'uploads/paisaje-forestal.jpg', 0),
(35, 12, 2, 'IMG', '2024-08-29 08:59:26', NULL, 'uploads/comentarios/peakpx.jpg', 0),
(36, 9, 2, 'S', '2024-08-29 09:03:23', '2024-09-12 08:05:32', 'uploads/comentarios/default.png', 0),
(37, 16, 2, 'AAAASASSDGSGDFhsyuidfyhUI8', '2024-08-29 09:11:09', NULL, 'uploads/comentarios/peakpx.jpg', 0),
(38, 14, 2, 'IMAGEN\r\nIMAGEN\r\nIMAGEN\r\n', '2024-08-30 13:26:53', '2024-08-30 13:47:56', 'uploads/comentarios/descarga.png', 0),
(39, 15, 2, 's', '2024-08-30 13:55:03', NULL, NULL, 0),
(40, 16, 2, '- Si\r\n- No', '2024-09-02 10:39:47', NULL, NULL, 0),
(41, 18, 2, '> Markdown', '2024-09-02 10:42:27', NULL, NULL, 0),
(42, 18, 2, 'No markdown', '2024-09-02 10:42:35', NULL, NULL, 0),
(43, 15, 2, 'Si', '2024-09-03 08:04:18', NULL, 'uploads/comentarios/practicaNo5_RodriguezGarcia_MariaFernanda.png', 0),
(44, 20, 1, 'IMGGGG', '2024-09-03 08:12:30', NULL, 'uploads/comentarios/eca456b6290cdf07cd4ccce525d3c780.jpg', 0),
(45, 21, 1, '```\r\n{\r\n  \"firstName\": \"John\",\r\n  \"lastName\": \"Smith\",\r\n  \"age\": 25\r\n}\r\n```', '2024-09-03 08:29:48', '2024-09-12 09:19:45', NULL, 0),
(46, 21, 1, '- [x] Write the press release\r\n- [ ] Update the website\r\n- [ ] Contact the media', '2024-09-03 08:30:24', NULL, NULL, 0),
(47, 21, 1, 'I need to highlight these ==very important words==.', '2024-09-03 08:34:19', NULL, NULL, 0),
(48, 10, 1, '# a', '2024-09-03 08:37:07', NULL, NULL, 1),
(49, 21, 4, '~~The world is flat.~~ We now know that the world is round.', '2024-09-03 08:50:32', NULL, 'uploads/comentarios/eca456b6290cdf07cd4ccce525d3c780.jpg', 0),
(50, 21, 4, '.', '2024-09-03 08:55:17', NULL, 'uploads/comentarios/ufhioahiofda.jpg', 0),
(51, 22, 4, 'Img', '2024-09-03 08:58:30', NULL, NULL, 0),
(52, 22, 4, 'IMG', '2024-09-03 08:58:46', NULL, 'uploads/comentarios/eca456b6290cdf07cd4ccce525d3c780.jpg', 0),
(53, 23, 2, 'Hbgggggfdg', '2024-09-05 07:45:59', '2024-09-10 08:34:47', NULL, 0),
(54, 23, 3, 'Si', '2024-09-05 08:51:19', NULL, NULL, 0),
(55, 24, 3, 'IMG', '2024-09-05 08:51:53', NULL, NULL, 0),
(56, 24, 3, 'img', '2024-09-05 08:53:30', NULL, NULL, 0),
(57, 24, 2, 'IMG', '2024-09-05 08:55:59', NULL, NULL, 0),
(58, 24, 2, 'BAYMAX:D', '2024-09-05 09:07:50', NULL, NULL, 0),
(59, 24, 2, 'xdddddddddddddddddddddddddddd', '2024-09-10 08:21:33', NULL, NULL, 0),
(60, 25, 2, 'Lorem ipsum dolor sit amet consectetur adipiscing elit rhoncus vitae, nam magnis scelerisque phasellus ultrices fusce nascetur litora. Placerat turpis sapien nullam pharetra dui orci hendrerit metus enim diam, purus morbi felis mus varius egestas faucibus nulla eros praesent ad, vivamus ut a mi pulvinar libero tristique odio phasellus.', '2024-09-10 08:40:02', '2024-09-12 08:04:54', 'uploads/comentarios/descarga (2).jpg', 0),
(61, 21, 2, 'fdgfdgfdgfdgfdg', '2024-09-10 08:51:45', '2024-09-10 08:51:53', 'uploads/peakpx.jpg', 0),
(62, 25, 2, 'lroem', '2024-09-10 08:58:55', '2024-09-12 08:05:04', 'uploads/comentarios/descarga.jpg', 0),
(63, 26, 2, 'si', '2024-09-12 07:49:17', NULL, NULL, 0),
(64, 9, 2, 'xd', '2024-09-12 07:55:59', '2024-09-12 07:58:08', 'uploads/comentarios/descarga (1).jpg', 0),
(65, 9, 2, 'IMAGEN', '2024-09-12 07:58:41', NULL, 'uploads/comentarios/descarga (2).jpg', 0),
(66, 17, 2, 'XD', '2024-09-12 08:06:12', NULL, NULL, 0),
(67, 27, 2, 'Cita', '2024-09-12 08:09:43', NULL, NULL, 1),
(68, 25, 2, '😋😋😋😋', '2024-09-17 08:23:10', '2024-09-17 08:23:31', NULL, 0),
(69, 25, 2, 'Emoji:D \r\n\r\n😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘😘', '2024-09-17 08:23:59', NULL, NULL, 0),
(70, 25, 2, '🐩🐩🐩🐩🥝📲', '2024-09-17 08:24:36', NULL, NULL, 0),
(71, 29, 1, '😘🐩🥝📲😘', '2024-09-17 08:25:43', NULL, NULL, 0),
(72, 29, 1, 'sdfsdfsdf😋🐩🥝', '2024-09-17 08:26:41', NULL, NULL, 1),
(73, 30, 1, '😁😁😁😁😁😁😁🐩🥝😁🐩\r\n\r\n> 😌😌😌😌😌😌😌😌', '2024-09-17 08:31:11', '2024-09-17 08:33:18', NULL, 0),
(74, 30, 1, 'Este ', '2024-09-17 08:33:24', NULL, NULL, 1),
(75, 30, 2, 'a', '2024-09-19 08:10:46', NULL, NULL, 1),
(76, 25, 2, 'Si😁😁😁😁', '2024-09-24 07:46:50', NULL, NULL, 0),
(77, 25, 2, 'XDg', '2024-09-24 09:24:25', '2024-09-24 08:24:58', NULL, 0),
(78, 25, 2, 'Xd', '2024-09-24 08:25:32', NULL, NULL, 0),
(79, 35, 2, 'FECHA!', '2024-09-24 08:25:50', NULL, NULL, 1),
(80, 30, 2, 'Texto', '2024-09-24 08:26:35', '2024-10-08 07:38:20', NULL, 1),
(81, 35, 2, 'fecha', '2024-10-03 07:28:12', NULL, NULL, 1),
(82, 35, 2, 'XD', '2024-10-08 08:41:48', NULL, NULL, 0),
(83, 27, 2, 'xd', '2024-10-08 09:00:58', NULL, NULL, 1),
(84, 27, 2, 'se', '2024-10-08 09:01:12', NULL, NULL, 0),
(85, 35, 3, 'Si😚😚😚d😚', '2024-10-08 09:11:27', '2024-10-08 09:11:48', NULL, 0),
(86, 14, 3, 'admin', '2024-10-08 09:12:18', NULL, 'uploads/comentarios/PracticaNo7_Longinos_Chavez_JoseManuel.png', 1),
(87, 37, 7, 'IMAGEN🤠', '2024-10-15 08:00:50', NULL, 'uploads/comentarios/PracticaNo9_Rodriguez_Garcia_MariaFernanda.png', 1),
(88, 24, 3, 'Si 😅😅😅', '2024-10-17 07:56:07', NULL, NULL, 0),
(89, 37, 3, 'sdf', '2024-10-17 08:51:43', NULL, NULL, 0),
(90, 37, 3, 'bhifbhisbisvbi', '2024-10-17 08:56:49', NULL, NULL, 0),
(91, 37, 3, 'jhfgjfghd', '2024-10-17 08:58:01', NULL, NULL, 0),
(92, 39, 3, 'x', '2024-10-22 07:47:25', '2024-10-22 07:48:00', NULL, 0),
(93, 11, 7, 'shdhfds', '2024-10-22 08:06:32', NULL, NULL, 1),
(94, 11, 7, 'dfgfgdfg', '2024-10-22 08:07:11', NULL, NULL, 1),
(95, 11, 7, 'fgdfgdfgd', '2024-10-22 08:10:43', NULL, NULL, 0),
(96, 11, 7, 'fgdfgdfgd', '2024-10-22 08:10:46', NULL, NULL, 1),
(97, 40, 9, 'comentario', '2024-10-22 08:15:58', NULL, NULL, 1),
(98, 40, 9, 'xd', '2024-10-22 08:16:01', NULL, NULL, 1),
(99, 40, 9, 'x', '2024-10-22 08:16:54', NULL, NULL, 0),
(100, 30, 9, 'a', '2024-10-22 08:17:52', NULL, NULL, 1),
(101, 22, 4, 'f', '2024-10-22 08:38:04', NULL, NULL, 0),
(102, 37, 8, 'si', '2024-10-22 08:56:28', NULL, NULL, 0),
(103, 22, 4, 'xd', '2024-10-24 08:04:30', NULL, NULL, 0),
(104, 11, 10, 'Comentario Prueba 😜😜😜😜😜😜', '2024-10-24 08:34:45', NULL, NULL, 0),
(105, 11, 10, 'Imagen en comentario', '2024-10-24 08:35:21', '2024-10-24 08:51:59', 'uploads/comentarios/descarga (2).jpg', 0),
(106, 24, 10, 'f', '2024-10-24 08:42:08', NULL, NULL, 0),
(107, 44, 10, 'Haz dieta', '2024-10-24 08:51:31', '2024-10-24 08:53:23', NULL, 1);

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
(1, 1, 'Lorem ipsum dolor sit amet consectetur adipiscing elit, malesuada convallis ante diam arcu lectus sociosqu, nullam ornare purus fusce fames etiam. Mi arcu mus hendrerit netus accumsan turpis lectus senectus, pellentesque torquent porttitor enim libero nis', 'XD\r\n\r\nLorem ipsum dolor sit amet consectetur adipiscing elit, malesuada convallis ante diam arcu lectus sociosqu, nullam ornare purus fusce fames etiam. ', '2024-08-22 15:26:47', '2024-08-27 08:36:45', NULL, NULL, 12, 0, NULL),
(2, 1, 'Hilo', 'Hilo', '2024-08-22 15:27:02', NULL, NULL, NULL, 1, 0, NULL),
(3, 2, 'Prueba', 'Lorem', '2024-08-22 07:31:40', NULL, 3, NULL, 1, 0, NULL),
(4, 2, 'Amin', 'd', '2024-08-22 07:57:33', NULL, 3, NULL, 4, 0, NULL),
(5, 2, 'hilos', 'xy', '2024-08-22 07:59:19', '2024-08-22 08:00:20', 1, NULL, 0, 0, NULL),
(6, 2, 'Admin', 'admin', '2024-08-22 08:01:37', NULL, 1, NULL, 0, 0, NULL),
(7, 2, 'El hilo1', 'XD?', '2024-08-22 08:12:41', '2024-08-22 08:12:48', 1, NULL, 1, 0, NULL),
(8, 2, '.', '.', '2024-08-22 09:22:41', '2024-09-05 07:48:25', 4, NULL, 0, 0, NULL),
(9, 2, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet consectetur adipiscing elit, conubia mollis inceptos lacus tortor cubili', '2024-08-27 07:15:13', '2024-08-29 09:00:14', 1, 'uploads/descarga.png', 22, 0, NULL),
(10, 3, 'Lorem ipsum dolor sit amet consectetur adipiscing elit vehicula urn', 'Lorem\r\nLorem', '2024-08-27 14:03:07', '2024-08-29 08:00:47', 1, 'uploads/paisaje-forestal.jpg', 16, 1, NULL),
(11, 3, 'hilo con imagen: phasellus duis et mus dui eget habitant.', 'Hilo con imagenG\r\n\r\nLorem ipsum dolor sit amet consectetur adipiscing elit lacinia, aliquet accumsan scelerisque commodo fusce dui semper, malesuada laoreet porta nascetur iaculis aliquam fringilla.', '2024-08-29 07:39:57', '2024-10-24 08:47:22', 1, 'uploads/peakpx.jpg', 27, 0, NULL),
(12, 3, 'hilo IMG', 'AS\r\nLorem ipsum dolor sit amet consectetur adipiscing elit lacinia, aliquet accumsan scelerisque commodo fusce dui semper, malesuada laoreet ', '2024-08-29 08:20:36', '2024-08-29 08:50:09', 2, 'uploads/paisaje-forestal.jpg', 2, 1, NULL),
(13, 3, 'IMG', 'IMG', '2024-08-29 08:28:25', '2024-08-29 08:28:50', 1, 'uploads/pang-yuhao-wCi28eq8TF4-unsplash.jpg', 0, 0, NULL),
(14, 3, 'sadsadsdf', '> Lorem ipsum dolor sit amet consectetur adipiscing elit lacinia, aliquet accumsan scelerisque commodo fusce dui semper, malesuada laorsdfsdf', '2024-08-29 08:51:44', '2024-10-08 09:12:03', 3, 'uploads/hilos/PracticaNo9_Rodriguez_Garcia_MariaFernanda.png', 10, 1, NULL),
(15, 2, 'HILO NUEVA IMG', 'HILO....', '2024-08-29 08:55:46', '2024-09-03 08:03:58', 3, 'uploads/practicaNo5_RodriguezGarcia_MariaFernanda.png', 0, 0, NULL),
(16, 2, '> Si', '## Si\r\n# - Si', '2024-08-29 09:07:27', '2024-09-02 10:41:15', 2, 'uploads/peakpx.jpg', 0, 0, NULL),
(17, 2, 'HILOOOOOOO', 'HILOOOOO', '2024-08-29 09:14:37', NULL, 2, 'uploads/hilos/paisaje-forestal.jpg', 4, 0, NULL),
(18, 2, 'Hilo con Markdown', '# titulo\r\n- Texto\r\n> Cita', '2024-09-02 10:42:10', NULL, 1, NULL, 4, 0, NULL),
(19, 2, 'imggg', 'XD', '2024-09-03 08:08:19', '2024-09-03 08:09:02', 3, 'uploads/descarga.png', 0, 0, NULL),
(20, 2, 'IMGG', 'IMGG', '2024-09-03 08:09:29', '2024-09-03 08:11:48', 1, 'uploads/hilos/eca456b6290cdf07cd4ccce525d3c780.jpg', 20, 0, NULL),
(21, 1, 'Markdown', '> Markdown\r\n> I need to highlight these ==very important words==.\r\n\r\n| Syntax | Description|\r\n| -------- | --------------|\r\n| Header      | Title |\r\n| Paragraph   | Text |\r\n\r\n| Syntax      | Description | Test Text     |\r\n| :---        |    :----:   |          ---: |\r\n| Header      | Title       | Here\'s this   |\r\n| Paragraph   | Text        | And more      |', '2024-09-03 08:20:49', '2024-09-03 08:34:33', 3, 'uploads/hilos/eca456b6290cdf07cd4ccce525d3c780.jpg', 48, 0, NULL),
(22, 4, 'XD', 'XD', '2024-09-03 08:55:46', NULL, 1, 'uploads/hilos/dolar.jpg', 7, 0, NULL),
(23, 2, 'H', 'H', '2024-09-05 07:45:53', '2024-09-05 07:46:25', 1, 'uploads/hilos/Captura de pantalla (1).png', 2, 1, NULL),
(24, 3, 'HILO IMG', 'IMG', '2024-09-05 08:51:50', '2024-10-17 07:33:41', 1, 'uploads/hilos/PracticaNo7_Longinos_Chavez_JoseManuel.png', 23, 0, NULL),
(25, 2, 'LOREMDFGDFGD', '> Lorem ipsum dolor sit amet consectetur adipiscing elit rhoncus vitae, nam magnis scelerisque ph\r\n\r\n# n quis non.', '2024-09-10 08:39:30', '2024-09-17 09:24:08', 2, NULL, 95, 0, NULL),
(26, 1, 'dfgfdgfdg', 'dfgfdgfd', '2024-09-10 09:03:39', NULL, 2, NULL, 101, 0, NULL),
(27, 2, 'Hilo', '> Cita', '2024-09-12 08:09:30', NULL, 2, 'uploads/hilos/descarga.jpg', 24, 1, NULL),
(28, 2, 's', 's', '2024-09-12 08:17:30', NULL, 4, NULL, 12, 0, NULL),
(29, 2, 'S', 's', '2024-09-12 08:17:42', '2024-09-12 09:06:24', 4, NULL, 43, 1, NULL),
(30, 1, 'XD', '😘😋🥝😁😁😁😁😁\r\n\r\n> Markdown\r\n\r\n# 😅😅', '2024-09-17 08:29:54', '2024-09-17 09:13:37', 4, NULL, 191, 1, NULL),
(35, 2, 'fECHA', 'XD', '2024-09-24 08:11:10', '2024-09-24 08:26:01', 8, NULL, 67, 0, NULL),
(36, 2, 'test', 'dsf', '2024-10-08 07:46:43', NULL, 1, NULL, 3, 1, NULL),
(37, 7, 'hilo', '> cita\r\n### Texto🤠🤠\r\n\r\n- h\r\n- H', '2024-10-15 07:59:46', '2024-10-15 08:00:37', 5, NULL, 31, 0, NULL),
(38, 3, 'OBJ', 'VRML', '2024-10-17 07:44:45', '2024-10-17 08:23:05', 8, NULL, 26, 0, 'uploads/obj/model.obj'),
(39, 3, 'obj', 'obj', '2024-10-17 08:01:42', '2024-10-17 08:06:33', 3, NULL, 53, 0, 'uploads/obj/Wooden chair.obj'),
(40, 9, 'Hilo prueba', '> XD', '2024-10-22 08:15:53', NULL, 2, NULL, 9, 1, NULL),
(41, 6, 'xd', 'sad', '2024-10-22 08:24:58', NULL, 3, NULL, 3, 1, NULL),
(42, 4, 'f', 'sfd', '2024-10-22 08:41:23', NULL, 3, NULL, 1, 0, NULL),
(43, 8, 'Modelo obj', '> OBJ: WOLF', '2024-10-22 09:05:11', '2024-10-24 07:36:51', 2, NULL, 68, 0, 'uploads/obj/wolf.obj'),
(44, 10, 'Abro hilo: soy gordofóbico', '# xd', '2024-10-24 08:39:29', '2024-10-24 08:52:43', 2, 'uploads/hilos/descarga (2).jpg', 31, 1, NULL);

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

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `id_usuario`, `tipo_objeto`, `id_objeto`, `motivo`, `fecha_reporte`) VALUES
(1, 1, 'hilo', 2, 'Contenido inapropiado', '2024-09-02 12:00:00'),
(2, 2, 'comentario', 4, 'Spam o publicidad no deseada', '2024-09-02 13:00:00'),
(3, 1, 'hilo', 21, 'Terrorismo', '2024-09-03 08:43:28'),
(4, 1, 'hilo', 21, 'Terrorismo', '2024-09-03 08:43:56'),
(5, 1, 'comentario', 45, 'Terrorismo XD', '2024-09-03 08:45:40'),
(6, 1, 'hilo', 21, 'XD', '2024-09-03 08:48:27'),
(7, 1, 'comentario', 46, 'XD', '2024-09-03 08:48:37'),
(8, 1, 'comentario', 46, 'XD', '2024-09-03 08:49:14'),
(9, 4, 'hilo', 21, 'TERRORISMO', '2024-09-03 08:50:56'),
(10, 3, 'comentario', 38, 'terrorismo', '2024-09-05 08:48:33'),
(11, 2, 'hilo', 25, 'AHHHHHHHHHHHHHHHHHHHHH', '2024-09-10 08:40:59'),
(12, 2, 'hilo', 21, 'TERRORISMO', '2024-09-10 08:53:36'),
(13, 2, 'comentario', 12, 'FFDGDFG', '2024-09-10 08:58:28'),
(14, 2, 'hilo', 21, 'TERRORISMO:D', '2024-09-12 09:22:15'),
(15, 6, 'hilo', 23, 'Violencia', '2024-09-19 07:25:49'),
(16, 2, 'hilo', 35, 'Acoso', '2024-09-24 09:00:35'),
(17, 3, 'comentario', 82, 'Infracción de derechos de autor', '2024-10-08 09:11:34'),
(18, 7, 'comentario', 87, 'Spam', '2024-10-15 08:01:10'),
(19, 3, 'hilo', 11, 'Información falsa', '2024-10-22 08:06:10'),
(20, 10, 'hilo', 11, 'Violencia', '2024-10-24 08:33:16'),
(21, 10, 'hilo', 11, 'Violencia', '2024-10-24 08:33:25'),
(22, 10, 'hilo', 11, 'Violencia', '2024-10-24 08:34:20'),
(23, 10, 'hilo', 11, 'Fraude', '2024-10-24 08:34:29'),
(24, 10, 'comentario', 95, 'Contenido inapropiado', '2024-10-24 08:34:56'),
(25, 10, 'hilo', 44, 'Violencia', '2024-10-24 08:51:25'),
(26, 10, 'comentario', 107, 'Infracción de derechos de autor', '2024-10-24 08:53:28'),
(27, 8, 'hilo', 44, 'Incitación al odio', '2024-10-24 08:59:18');

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
(1, 'Alexei', 'alc@as.as', '$2y$10$NWTTkHZuHGtV.gdfVv5lHOLW008vgpP5xUWjyu8v7nb3WlGUTco3m', '2024-08-22 07:26:41', NULL, NULL, 5, 0),
(2, 'admin2', 'admin@admin.madi', '$2y$10$S7qvxJIhdWSoVlpIvjD6ZeAmtpe7A0i6cPxLKPnR5EAoGjpqjwIiW', '2024-08-22 07:27:29', NULL, 'asasdescarga.png', 10, 0),
(3, '-', 'asdasd@kasdksd.sda', '$2y$10$g9BQzYlk20BVysneOv8xSe5u8An6k4O7ahUF1.Ic74lmfwTTpMqdK', '2024-08-27 14:02:51', NULL, 'paisaje-forestal.jpg', 5, 0),
(4, 'q', 'qasd@ada.asd', '$2y$10$tTAjNnVzNqmFgLJCjofYXuynkMo.jVZ3f24.R/h7kI250N/B4HVNO', '2024-09-03 08:50:03', NULL, 'descarga (1).jpg', 0, 1),
(5, 'sdfsdfsdf', 'sdfsdf@sadsad.sadasd', '$2y$10$WD4Cf5Fzhm3iP3quWo7XB.1a8Dg6PSnF6Wifm6mdoJ816lhV0Gmn6', '2024-09-10 09:02:19', NULL, NULL, 0, 1),
(6, 'admin1', 'admaiofhdioeq@dhiosaid.jasdgha', '$2y$10$fZYsE7BQ6cvI/GMbSU02q.tTit9XxzIIWt0Q3wb0tbFG.22iHFyQO', '2024-09-19 07:22:56', NULL, NULL, 1, 1),
(7, 'adminn', 'admin@admin.madiiii', '$2y$10$0gDI1E.NlXZaXz5mnOmeQeTW5JsVQhLaSUiJsmHLgIDBjKVqkM62O', '2024-10-15 07:45:55', NULL, NULL, 4, 0),
(8, 'admin', 'jopapi6077@chysir.com', '$2y$10$UwaPEr0cJ/KBIHekDNrmJ.MHXSNIBpWpW9OIp9FvSwcSrEw5hMami', '2024-10-22 08:11:50', NULL, 'Vecteur Dicône Mâle PNG , Clipart De Travail, Utilisateur, Icône PNG et vecteur pour téléchargement gratuit.jpg', 0, 1),
(9, 'pruebaaa', 'peueba@klfoe.com', '$2y$10$7uaxLFpGrUmt5GchojztkelXUwMCyJ3LAcsixJ8Q1E7KfaQMbMiUa', '2024-10-22 08:15:40', NULL, NULL, 4, 0),
(10, 'prueba', 'prueba@prueba.comn', '$2y$10$p4bdc.1B32gkMH3JrV3mn.zR2isbNeEfmLw2s5wPB2E54X.lHtg.S', '2024-10-24 08:32:50', NULL, 'asasdescarga.png', 2, 1);

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
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `hilos`
--
ALTER TABLE `hilos`
  MODIFY `id_hilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `radio`
--
ALTER TABLE `radio`
  MODIFY `id_radio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
