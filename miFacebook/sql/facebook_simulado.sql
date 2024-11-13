-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2024 a las 17:31:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facebook_simulado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_comentario` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `comentario`, `id_publicacion`, `id_usuario`, `fecha_comentario`) VALUES
(1, 'hola', 10, 2, '2024-11-11 02:11:21'),
(2, 'hola', 10, 2, '2024-11-11 02:12:33'),
(3, 'buenos dias', 10, 2, '2024-11-11 02:13:26'),
(4, 'buenoas alsdfjalñjk', 10, 2, '2024-11-11 02:14:44'),
(5, 'buenoas alsdfjalñjk', 10, 2, '2024-11-11 02:16:00'),
(6, 'buenos dias', 17, 2, '2024-11-11 02:19:14'),
(7, 'buenos dias', 17, 2, '2024-11-11 02:21:07'),
(8, 'jkhlkhl\r\n', 17, 4, '2024-11-11 03:44:43'),
(9, 'lskjdflañjfañ', 17, 4, '2024-11-11 03:45:42'),
(10, 'hola', 17, 4, '2024-11-11 03:55:24'),
(11, 'si', 18, 4, '2024-11-11 04:29:00'),
(12, 'buenas', 18, 4, '2024-11-11 04:41:29'),
(13, 'hola', 18, 6, '2024-11-11 04:51:27'),
(14, 'hola', 2, 6, '2024-11-11 05:01:40'),
(15, 'que hondaaa', 2, 6, '2024-11-11 05:02:16'),
(16, 'ya es de dia', 19, 7, '2024-11-11 05:31:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id_publicacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_publicacion` datetime DEFAULT current_timestamp(),
  `color` varchar(7) DEFAULT '#808080'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id_publicacion`, `id_usuario`, `contenido`, `fecha_publicacion`, `color`) VALUES
(1, 2, 'hola', '2024-11-10 14:54:52', '#808080'),
(2, 3, 'hola', '2024-11-10 14:59:42', '#808080'),
(3, 3, 'hola🥲', '2024-11-10 15:02:03', '#808080'),
(5, 2, 'jovenes  adolescentes', '2024-11-10 17:31:19', '#808080'),
(6, 1, 'buenos dias', '2024-11-10 17:35:43', '#808080'),
(7, 1, 'buenos diasx2', '2024-11-10 17:36:08', '#808080'),
(8, 1, 'hola mundoo', '2024-11-10 23:06:12', '#7b1e1e'),
(9, 1, 'hola mundo 123', '2024-11-10 23:06:24', '#808080'),
(10, 2, 'buenos dias', '2024-11-10 23:11:46', '#0b49ad'),
(17, 2, 'buenos dias', '2024-11-11 02:18:34', '#808080'),
(18, 4, 'ya es de dia', '2024-11-11 04:28:52', '#0e0101'),
(19, 7, 'ya es de dia', '2024-11-11 05:13:55', '#808080'),
(20, 7, 'buenoas dias', '2024-11-11 05:31:52', '#187000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reacciones`
--

CREATE TABLE `reacciones` (
  `id_reaccion` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_reaccion` enum('me gusta','me encanta','me enoja','me sorprende') NOT NULL,
  `fecha_reaccion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reacciones`
--

INSERT INTO `reacciones` (`id_reaccion`, `id_publicacion`, `id_usuario`, `tipo_reaccion`, `fecha_reaccion`) VALUES
(1, 10, 2, 'me gusta', '2024-11-11 05:37:24'),
(2, 10, 2, 'me encanta', '2024-11-11 05:37:26'),
(3, 10, 2, 'me enoja', '2024-11-11 05:37:28'),
(4, 10, 2, 'me sorprende', '2024-11-11 05:37:29'),
(5, 10, 2, 'me gusta', '2024-11-11 05:37:33'),
(6, 10, 2, 'me encanta', '2024-11-11 05:37:34'),
(7, 9, 2, 'me gusta', '2024-11-11 05:37:37'),
(8, 9, 2, 'me encanta', '2024-11-11 05:37:39'),
(9, 9, 2, 'me enoja', '2024-11-11 05:37:40'),
(10, 9, 2, 'me sorprende', '2024-11-11 05:37:41'),
(11, 10, 2, 'me enoja', '2024-11-11 06:05:35'),
(12, 7, 2, 'me enoja', '2024-11-11 06:05:41'),
(13, 7, 2, 'me enoja', '2024-11-11 06:05:43'),
(14, 7, 2, 'me gusta', '2024-11-11 06:05:46'),
(15, 7, 2, 'me sorprende', '2024-11-11 06:05:49'),
(16, 17, 4, 'me gusta', '2024-11-11 07:44:24'),
(17, 17, 4, 'me encanta', '2024-11-11 07:44:26'),
(18, 17, 4, 'me enoja', '2024-11-11 07:44:29'),
(19, 17, 4, 'me sorprende', '2024-11-11 07:44:31'),
(20, 18, 4, 'me gusta', '2024-11-11 08:29:05'),
(21, 18, 4, 'me encanta', '2024-11-11 08:29:13'),
(22, 18, 4, 'me enoja', '2024-11-11 08:29:14'),
(23, 18, 4, 'me sorprende', '2024-11-11 08:29:16'),
(24, 2, 6, 'me gusta', '2024-11-11 09:01:34'),
(25, 19, 7, 'me encanta', '2024-11-11 09:19:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('Masculino','Femenino','Otro') NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto_perfil` varchar(255) DEFAULT 'default-profile.jpg',
  `estado_sentimental` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `email`, `contraseña`, `fecha_creacion`, `foto_perfil`, `estado_sentimental`, `telefono`) VALUES
(1, 'admin', '123', '2002-01-25', 'Masculino', 'admin@gmail.com', '$2y$10$8F5PPvv2TlN10pDsxJ1Q/.U1KNKPfV8iwi/7LSlRb.tzkx6Mz3wwm', '2024-11-10 18:32:24', './img/3fa42388bc76a0dcecb36d9b2e081f92.png', 'Casado/a', '73160438'),
(2, 'pablo', 'martinez', '1997-10-10', 'Masculino', 'pablo123@gmail.com', '$2y$10$t6wMiWlPxhikW.dn7IECwuGV3TiDawgsaOfuo7GpQa01XEXag9a3W', '2024-11-10 18:34:01', './img/10f48b4310bbc1b8260ad57799df651d.png', 'Comprometido/a', '73160438'),
(3, 'juan', 'guzman', '2000-11-11', 'Masculino', 'juan321@gmail.com', '$2y$10$2jrBYt26Mrj3wXbB7RXC0eu1xa5LC9eXTBd2joWQpoR0Y/GQwbDWK', '2024-11-10 18:57:02', './img/36af2c25aa9b488dc7823af8ae582e8a.png', 'Soltero/a', '89898989'),
(4, 'rut', 'mamani', '1999-12-05', 'Femenino', 'rut@gmail.com', '$2y$10$/X/UaUV82Q5YmZ4SNLHo5ul0VZDh5B6fiCyJSYYVx6sSB57B0tHpu', '2024-11-11 06:34:33', './img/9567236b31b5a4c85d365bab3632dc43.png', 'Soltero/a', '70725144'),
(6, 'fulanito', 'jajjaja', '2000-12-22', 'Masculino', 'fulanito@gmail.com', '$2y$10$ACFNSfiRU8iFOqnE3uk4TugshuKc6SY2bkxy.9BaLpSGO5aTNu/6S', '2024-11-11 08:49:13', './img/18ee4f2baa5d15afd2c4dbb8030d9c6c.png', 'Soltero/a', '98765434'),
(7, 'fuu', 'raa', '2002-02-12', 'Masculino', 'fu@gmail.com', '$2y$10$pscGEa8z.4IOBNsaR/KfjOk9uadNUYRprsDmK5Z4o4iLVD50UktgK', '2024-11-11 09:09:21', './img/08de573330a82c90dfdfb27718191a95.png', 'Soltero/a', '87766666');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_publicacion` (`id_publicacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `reacciones`
--
ALTER TABLE `reacciones`
  ADD PRIMARY KEY (`id_reaccion`),
  ADD KEY `id_publicacion` (`id_publicacion`),
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
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `reacciones`
--
ALTER TABLE `reacciones`
  MODIFY `id_reaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones` (`id_publicacion`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reacciones`
--
ALTER TABLE `reacciones`
  ADD CONSTRAINT `reacciones_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones` (`id_publicacion`),
  ADD CONSTRAINT `reacciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
