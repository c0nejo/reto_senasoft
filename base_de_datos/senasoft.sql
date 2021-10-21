-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2021 a las 00:31:08
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `senasoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `esp_id` int(10) NOT NULL,
  `esp_nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `ser_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`esp_id`, `esp_nombre`, `ser_id`) VALUES
(1, 'General', 4),
(2, 'Paciente infante', 4),
(3, 'Administración de medicamentos', 4),
(4, 'Paciente ventilado', 4),
(5, 'Recepción', 2),
(6, 'Facturación', 2),
(7, 'Aseo General', 3),
(8, 'bodega', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `per_id` int(10) NOT NULL,
  `per_nombres` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `rol_id` int(2) NOT NULL,
  `esp_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`per_id`, `per_nombres`, `rol_id`, `esp_id`) VALUES
(1, 'luis santo', 1, 1),
(2, 'jhan', 1, 1),
(3, 'david', 2, 1),
(4, 'jhonatan', 2, 2),
(5, 'nicolas', 2, 3),
(6, 'freddy', 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `rol_id` int(2) NOT NULL,
  `rol_nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `rol_nombre`) VALUES
(1, 'Doctor'),
(2, 'Enfermero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `ser_id` int(10) NOT NULL,
  `ser_nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`ser_id`, `ser_nombre`) VALUES
(1, 'Medicina'),
(2, 'Administrativo'),
(3, 'Logístico'),
(4, 'Enfermería');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`esp_id`),
  ADD KEY `ser_id` (`ser_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`per_id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `esp_id` (`esp_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`ser_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD CONSTRAINT `especialidad_ibfk_1` FOREIGN KEY (`ser_id`) REFERENCES `servicio` (`ser_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`esp_id`) REFERENCES `especialidad` (`esp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
