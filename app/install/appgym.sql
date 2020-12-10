-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2020 a las 12:34:52
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appgym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `tipo`) VALUES
(1, 'admin'),
(2, 'socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nif` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `telefono` bigint(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nif`, `nombre`, `apellidos`, `email`, `password`, `telefono`, `direccion`, `estado`, `imagen`, `rol_id`) VALUES
(7, '49086023K', 'MEJORA', 'Campón', 'silecsis@gmail.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'miusuer.png', 2),
(8, '49086023K', 'mara', 'cam', 'maria@gmail.com', 'dc468c70fb574ebd07287b38d0d0676d', 34617719981, 'calle blah', 1, 'miusuer.png', 1),
(23, '49086023K', 'dasd', 'asd', 'cer@gmail.com', '0bb440353f368ea6680333e925dad2d9', 678788789, 'Calle cual', 0, 'avatar5fd12338bdeb76.11668672.png', 2),
(24, '49086023K', 'maria', 'wqwe', 'marinoje222t@outlook.com', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'ads', 0, 'avatar5fd10907618663.09455634.png', 2),
(25, '29747147M', 'Fran', 'Gar Cor', 'asd@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f3961c2137.63402057.png', 2),
(26, '29747147M', 'Fran', 'Gar Cor', 'fafa@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f42a64a636.95578953.png', 2),
(27, '29747147M', 'Fran', 'Gar Cor', 'cece@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f451838ba4.81861570.png', 1),
(28, '29747147M', 'Fran', 'Gar Cor', 'jare@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f4dcf244d0.32775598.png', 1),
(29, '29747147M', 'Fran', 'Gar Cor', 'tete@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f52c993733.57116677.png', 1),
(30, '29747147M', 'Fran', 'Gar Cor', 'pepe@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f55b6b0294.97129773.png', 1),
(31, '29747147M', 'Fran', 'Gar Cor', 'afu@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f5c2e9f028.37134669.png', 2),
(32, '29747147M', 'Fran', 'Gar Cor', 'prueba@asd.es', '0bb440353f368ea6680333e925dad2d9', 34617719981, 'Calle cual', 1, 'avatar5fd1f6607faa83.20464630.png', 1),
(33, '29747147M', 'mara', 'asd', 'asd@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'ads', 0, 'avatar5fd1f6c528af43.54726900.png', 2),
(34, '29747147M', 'mara', 'asd', 'dada@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'ads', 0, 'avatar5fd1f72b494ed4.59075759.png', 2),
(35, '29747147M', 'mara', 'asd', 'asasdasdd@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'ads', 0, 'avatar5fd1f749008aa0.88643477.png', 2),
(36, '29747147M', 'mara', 'asd', 'asasdasxaxaxdd@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'ads', 0, 'avatar5fd1f79f7c2732.26410641.png', 2),
(37, '49086023K', 'PruebaNom', 'PruebaApe', 'prueba@email.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle prueba', 1, 'avatar5fd204a9463d53.70881566.png', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario_rol` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
