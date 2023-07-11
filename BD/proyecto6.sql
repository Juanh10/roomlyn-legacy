-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2023 a las 18:40:12
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
  `id` int(11) NOT NULL,
  `nHabitacion` int(2) NOT NULL COMMENT 'Numero de la habitación',
  `id_tipo` int(11) NOT NULL COMMENT 'id del tipo de habitación',
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
  `id` int(11) NOT NULL,
  `elemento` varchar(30) NOT NULL COMMENT 'Elemento de la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_servicios`
--

CREATE TABLE `habitaciones_servicios` (
  `id` int(11) NOT NULL,
  `id_habitacion` int(2) NOT NULL COMMENT 'id de la habitación',
  `id_elemento` int(2) NOT NULL COMMENT 'id del elemento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos`
--

CREATE TABLE `habitaciones_tipos` (
  `id` int(11) NOT NULL,
  `tipoHabitacion` varchar(30) NOT NULL COMMENT 'Tipo de habitación',
  `cantidadCamas` tinyint(2) NOT NULL COMMENT 'cantidad de camas de ese tipo',
  `imagen` tinytext NOT NULL,
  `estado` tinyint(2) NOT NULL,
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos_elementos`
--

CREATE TABLE `habitaciones_tipos_elementos` (
  `id` int(11) NOT NULL,
  `id_habitacion_tipo` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infousuarios`
--

CREATE TABLE `infousuarios` (
  `id_infoUsuario` int(4) NOT NULL COMMENT 'id de la Informacion del usuario',
  `tipoDocumento` char(15) NOT NULL COMMENT 'tipo de documento del usuario',
  `documento` char(15) NOT NULL COMMENT 'numero de documento del usuario',
  `pNombre` varchar(30) NOT NULL COMMENT 'primer nombre',
  `sNombre` varchar(30) NOT NULL COMMENT 'segundo nombre',
  `pApellido` varchar(30) NOT NULL COMMENT 'primer apellido',
  `sApellido` varchar(30) NOT NULL COMMENT 'segundo apellido',
  `celular` char(12) NOT NULL COMMENT 'celular',
  `email` varchar(40) NOT NULL COMMENT 'correo electronico '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(4) NOT NULL COMMENT 'id del usuario',
  `id_infoUsuario` int(4) NOT NULL COMMENT 'id de la informacion del usuario',
  `usuario` varchar(15) NOT NULL COMMENT 'usuario',
  `contraseña` char(15) NOT NULL COMMENT 'contraseña del usuario',
  `tipoUsuario` varchar(15) NOT NULL COMMENT 'tipo de usuario (administrador, recepcionista)',
  `estado` tinyint(2) NOT NULL COMMENT 'habilitado o inhabilitado',
  `fecha` date NOT NULL COMMENT 'fecha de registro',
  `hora` time NOT NULL COMMENT 'hora de registro',
  `fecha_sys` datetime NOT NULL COMMENT 'fecha del sistema'
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
-- Indices de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_habitacion_tipo` (`id_habitacion_tipo`),
  ADD KEY `id_elemento` (`id_elemento`);

--
-- Indices de la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  ADD PRIMARY KEY (`id_infoUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `id_infoUsuario` (`id_infoUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones_servicios`
--
ALTER TABLE `habitaciones_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  MODIFY `id_infoUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id de la Informacion del usuario';

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id del usuario';

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

--
-- Filtros para la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  ADD CONSTRAINT `habitaciones_tipos_elementos_ibfk_1` FOREIGN KEY (`id_habitacion_tipo`) REFERENCES `habitaciones_tipos` (`id`),
  ADD CONSTRAINT `habitaciones_tipos_elementos_ibfk_2` FOREIGN KEY (`id_elemento`) REFERENCES `habitaciones_elementos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_infoUsuario`) REFERENCES `infousuarios` (`id_infoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
