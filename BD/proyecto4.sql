-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2023 a las 05:41:16
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto4`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(2) NOT NULL COMMENT 'id tabla habitaciones',
  `nHabitacion` int(2) NOT NULL COMMENT 'Numero de la habitación',
  `id_tipo` tinyint(2) NOT NULL COMMENT 'id del tipo de habitación',
  `precioHabitacion` varchar(10) NOT NULL COMMENT 'Precio de la habitación',
  `observacion` varchar(100) NOT NULL COMMENT 'Observaciones de la habitación',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de la habitación',
  `fecha` date NOT NULL COMMENT 'Fecha de registro de la habitación',
  `hora` time NOT NULL COMMENT 'Hora de registro de la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_elementos`
--

CREATE TABLE `habitaciones_elementos` (
  `id` int(2) NOT NULL COMMENT 'id de la tabla elementos de habitaciones',
  `elemento` varchar(30) NOT NULL COMMENT 'Elemento de la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_servicios`
--

CREATE TABLE `habitaciones_servicios` (
  `id` int(2) NOT NULL COMMENT 'id de la tabla servicios de habitaciones',
  `id_habitacion` int(2) NOT NULL COMMENT 'id de la habitación',
  `id_elemento` int(2) NOT NULL COMMENT 'id del elemento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos`
--

CREATE TABLE `habitaciones_tipos` (
  `id` tinyint(2) NOT NULL COMMENT 'id de la tabla tipos de habitaciones',
  `tipoHabitacion` varchar(2) NOT NULL COMMENT 'Tipo de habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(5) NOT NULL COMMENT 'id del usuario',
  `tipoIdentificacion` char(10) NOT NULL COMMENT 'tipo de identifiacion del usuario',
  `numIdentificacion` char(15) NOT NULL COMMENT 'numero de identificacion del usuario',
  `pNombre` varchar(30) NOT NULL COMMENT 'primer nombre',
  `sNombre` varchar(30) NOT NULL COMMENT 'segundo nombre',
  `pApellido` varchar(30) NOT NULL COMMENT 'primer apellido',
  `sApellido` varchar(30) NOT NULL COMMENT 'segundo apellido',
  `celular` char(12) NOT NULL COMMENT 'celular del usuario',
  `email` varchar(40) NOT NULL COMMENT 'email del usuario',
  `tipoUsuario` varchar(15) NOT NULL COMMENT 'tipo de usuario',
  `usuario` varchar(15) NOT NULL COMMENT 'nombre de usuario ',
  `contraseña` char(15) NOT NULL COMMENT 'contraseña del usuario',
  `estado` tinyint(2) NOT NULL COMMENT 'estado del usuario',
  `fechaSys` datetime NOT NULL COMMENT 'fecha del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitaciones_servicios`
--
ALTER TABLE `habitaciones_servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_habitacion` (`id_habitacion`),
  ADD UNIQUE KEY `id_elemento` (`id_elemento`);

--
-- Indices de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id del usuario';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `habitaciones_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `habitaciones_tipos` (`id`);

--
-- Filtros para la tabla `habitaciones_servicios`
--
ALTER TABLE `habitaciones_servicios`
  ADD CONSTRAINT `habitaciones_servicios_ibfk_1` FOREIGN KEY (`id_elemento`) REFERENCES `habitaciones_elementos` (`id`),
  ADD CONSTRAINT `habitaciones_servicios_ibfk_2` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
