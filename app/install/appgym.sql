-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2020 a las 03:28:42
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
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `aforo` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `descripcion`, `aforo`) VALUES
(1, 'Bodybalance', 'Combina yoga, estiramientos, pilates y taichi para entrenar de forma suave pero efectiva, relajarse y equilibrar cuerpo y mente.', 7),
(2, 'Dance', 'Haz cardio con los movimientos de baile de nuestros monitores', 10),
(3, 'Yoga', 'Conjunto de técnicas de concentración derivadas de esta doctrina filosófica que se practican para conseguir un mayor control físico y mental.', 10),
(4, 'Taichí', 'Arte marcial milenario de origen chino que otorga muchos beneficios para la salud. El taichi es una disciplina ancestral que ofrece relajación, reduce', 7),
(5, 'Ciclo', 'Conjunto de actividades que mejoran la resistencia.', 8),
(10, 'Pilates', 'Breve desc', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias`
--

CREATE TABLE `dias` (
  `id` int(11) NOT NULL,
  `dia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dias`
--

INSERT INTO `dias` (`id`, `dia`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sábado');

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
-- Estructura de tabla para la tabla `tramos`
--

CREATE TABLE `tramos` (
  `id` int(11) NOT NULL,
  `dia` int(50) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tramos`
--

INSERT INTO `tramos` (`id`, `dia`, `hora_inicio`, `hora_fin`, `actividad_id`, `fecha_alta`, `fecha_baja`) VALUES
(1, 3, '07:15:00', '08:15:00', 2, '2020-12-07', NULL),
(3, 3, '07:00:00', '08:15:00', 5, '2020-12-07', NULL),
(5, 1, '07:15:00', '08:15:00', 10, '2020-12-05', NULL),
(8, 1, '07:15:00', '08:00:00', 3, '2020-12-05', NULL),
(9, 5, '07:15:00', '08:00:00', 4, '2020-12-05', NULL);

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
(8, '49086023K', 'mara', 'cam', 'maria@gmail.com', 'dc468c70fb574ebd07287b38d0d0676d', 34617719981, 'calle blah', 1, 'miusuer.png', 1),
(41, '29747147M', 'asdd', 'asdd', 'asd@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd4d16f321ee1.64925263.png', 2),
(43, '29747147M', 'asdd', 'asdd', 'asasad@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd4d74cbe55b9.33678262.png', 2),
(44, '29747147M', 'asdd', 'asdd', 'a123sd@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd4d75d5f73f6.40314120.png', 1),
(45, '29747147M', 'asdd', 'asdd', 'asas22ad@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd4d76885ef38.23574082.png', 1),
(46, '29747147M', 'asdd', 'asdd', 'asd3@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd4d776295527.22284836.png', 1),
(47, '29747147M', 'asdd', 'asdd', 'asa33sad@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 0, 'avatar5fd4d7832db867.10570291.png', 2),
(48, '29747147M', 'asdd', 'asdd', 'a123s333d@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 0, 'avatar5fd4d78ed31115.94284723.png', 2),
(49, '29747147M', 'asdd', 'asdd', 'asas22ad333@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 0, 'avatar5fd4d8d233cbb9.70696708.png', 2),
(51, '29747147M', 'asdd', 'asdd', 'a11sd3@asd.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd4d8685ab723.91289395.png', 1),
(55, '49086023K', 'MJ', 'Cam Gar', 'silecsis@gmail.com', '0bb440353f368ea6680333e925dad2d9', 34666666666, 'Calle cual', 1, 'avatar5fd6075f86b8e2.36240738.png', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias`
--
ALTER TABLE `dias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dia` (`dia`),
  ADD KEY `actividad_id` (`actividad_id`);

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
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `dias`
--
ALTER TABLE `dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tramos`
--
ALTER TABLE `tramos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tramos`
--
ALTER TABLE `tramos`
  ADD CONSTRAINT `tramos_ibfk_1` FOREIGN KEY (`dia`) REFERENCES `dias` (`id`),
  ADD CONSTRAINT `tramos_ibfk_2` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
