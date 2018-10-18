-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2018 a las 23:39:48
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `millonario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anios`
--

CREATE TABLE `anios` (
  `id` int(11) NOT NULL,
  `anio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `anios`
--

INSERT INTO `anios` (`id`, `anio`) VALUES
(10, '2011'),
(9, '2012'),
(6, '2013'),
(5, '2014'),
(4, '2015'),
(3, '2016'),
(2, '2017'),
(1, '2018'),
(8, '2019');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `grados` (
  `id` int(11) NOT NULL,
  `grado` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`id`, `grado`) VALUES
(1, 6),
(2, 7),
(3, 8),
(4, 9),
(5, 10),
(6, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `pregunta`) VALUES
(1, '¿Cuanto es 2+3*2?'),
(2, 'El alba es...'),
(3, 'Warning en español significa...'),
(4, '¿Quien descubrió América?'),
(17, '¿Cuantas notas tiene una escala cromatica?'),
(18, 'La niña, la pinta y la...'),
(19, 'El simbolo quimico \"Na\" representa...'),
(22, 'Bon Scott fue vocalista de la banda...'),
(23, '¿Cual es el 6to planeta en el sistema solar?'),
(24, 'Banda famosa por ser iconica en los 70\'s y 80\'s...'),
(25, 'Descubrio la gravedad...'),
(26, 'Estructura repetitiva que primero evalua y despues repite.'),
(27, '¿Cual de los siguientes archivos no es de audio?'),
(28, 'Año de fundacion de Windows 7'),
(29, '¿Cual es el dia de independencia de colombia?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relaciones_preguntas`
--

CREATE TABLE `relaciones_preguntas` (
  `anio_id` int(11) NOT NULL,
  `grado_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relaciones_preguntas`
--

INSERT INTO `relaciones_preguntas` (`anio_id`, `grado_id`, `pregunta_id`) VALUES
(1, 6, 1),
(1, 6, 2),
(1, 6, 3),
(1, 6, 4),
(1, 6, 17),
(1, 6, 18),
(1, 6, 19),
(1, 6, 22),
(1, 6, 23),
(1, 6, 24),
(1, 6, 25),
(1, 6, 26),
(1, 6, 27),
(1, 6, 28),
(1, 6, 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  `respuesta_correcta` tinyint(1) NOT NULL,
  `pregunta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `respuesta`, `respuesta_correcta`, `pregunta_id`) VALUES
(1, '5', 0, 1),
(2, '8', 1, 1),
(3, '10', 0, 1),
(4, '9', 0, 1),
(5, 'Amanecer', 1, 2),
(6, 'Atardecer', 0, 2),
(7, 'Anochecer', 0, 2),
(8, 'Medio dia', 0, 2),
(9, 'Exito', 0, 3),
(10, 'Informacion', 0, 3),
(11, 'Peligro', 0, 3),
(12, 'Advertencia', 1, 3),
(13, 'Cristobal Colon', 1, 4),
(14, 'Nicolas Makiavelo', 0, 4),
(15, 'Benjamin Franklin', 0, 4),
(16, 'Jhon Lennon', 0, 4),
(65, '12', 1, 17),
(66, '7', 0, 17),
(67, '8', 0, 17),
(68, '5', 0, 17),
(69, 'Santa Maria', 1, 18),
(70, 'Santa Mariana', 0, 18),
(71, 'Santa Cacucha', 0, 18),
(72, 'Santa Barbara', 0, 18),
(73, 'Sodio', 1, 19),
(74, 'Hidrogeno', 0, 19),
(75, 'Agua', 0, 19),
(76, 'Yodo', 0, 19),
(85, 'AC/DC', 1, 22),
(86, 'Led Zeppelin', 0, 22),
(87, 'Nirvana', 0, 22),
(88, 'Aerosmith', 0, 22),
(89, 'Saturno', 1, 23),
(90, 'Jupiter', 0, 23),
(91, 'Venus', 0, 23),
(92, 'Marte', 0, 23),
(93, 'Queen', 1, 24),
(94, 'Nirvana', 0, 24),
(95, 'The Beatles', 0, 24),
(96, 'The Strokes', 0, 24),
(97, 'Isaac Newon', 1, 25),
(98, 'Nikola Tesla', 0, 25),
(99, 'Benjamin Franklin', 0, 25),
(100, 'Leonhard Euler', 0, 25),
(101, 'do while', 1, 26),
(102, 'while', 0, 26),
(103, 'for', 0, 26),
(104, 'for each', 0, 26),
(105, 'OGG', 1, 27),
(106, 'MP3', 0, 27),
(107, 'WAV', 0, 27),
(108, 'FLAC', 0, 27),
(109, '2009', 1, 28),
(110, '2007', 0, 28),
(111, '2012', 0, 28),
(112, '2010', 0, 28),
(113, '20 de Julio', 1, 29),
(114, '15 de Julio', 0, 29),
(115, '20 de Agosto', 0, 29),
(116, '13 de Julio', 0, 29);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anios`
--
ALTER TABLE `anios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anio` (`anio`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grado` (`grado`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `relaciones_preguntas`
--
ALTER TABLE `relaciones_preguntas`
  ADD PRIMARY KEY (`anio_id`,`grado_id`,`pregunta_id`),
  ADD KEY `grado_id` (`grado_id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anios`
--
ALTER TABLE `anios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `relaciones_preguntas`
--
ALTER TABLE `relaciones_preguntas`
  ADD CONSTRAINT `relaciones_preguntas_ibfk_1` FOREIGN KEY (`anio_id`) REFERENCES `anios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relaciones_preguntas_ibfk_2` FOREIGN KEY (`grado_id`) REFERENCES `grados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relaciones_preguntas_ibfk_3` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
