-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2023 a las 13:26:44
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
-- Base de datos: `proyecto2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id_habitaciones` int(4) NOT NULL,
  `n_habitacion` int(4) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `capacidad` int(4) NOT NULL,
  `caracteristicas` varchar(30) NOT NULL,
  `precio` int(10) NOT NULL,
  `estado` tinyint(2) NOT NULL,
  `fecha_sys` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reservas` int(10) NOT NULL,
  `documento` varchar(15) NOT NULL,
  `p_nombre` varchar(30) NOT NULL,
  `s_nombre` varchar(30) NOT NULL,
  `p_apellido` varchar(30) NOT NULL,
  `s_apellido` varchar(30) NOT NULL,
  `celular` varchar(30) NOT NULL,
  `sexo` tinyint(2) NOT NULL,
  `nacionalidad` varchar(40) NOT NULL,
  `ciudad_origen` varchar(40) NOT NULL,
  `id_habitaciones` int(4) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `f_ingreso` date NOT NULL,
  `f_salida` date NOT NULL,
  `fecha_sys` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL COMMENT 'Es el ID del usuario',
  `tipo_identificacion` char(10) NOT NULL COMMENT 'Tipo de identificacion del usuario',
  `n_identificacion` char(15) NOT NULL COMMENT 'Numero de identificacion del usuario',
  `p_nombre` varchar(30) NOT NULL COMMENT 'Primer nombre del usuario',
  `s_nombre` varchar(30) NOT NULL COMMENT 'Segundo nombre del usuario',
  `p_apellido` varchar(30) NOT NULL COMMENT 'Primer apellido del usuario',
  `s_apellido` varchar(30) NOT NULL COMMENT 'Segundo apellido del usuario',
  `celular` char(12) NOT NULL COMMENT 'Numero de celular de los usuarios',
  `email` varchar(40) NOT NULL COMMENT 'Email de los usuarios',
  `usuario` varchar(15) NOT NULL COMMENT 'Usuario para el ingreso de la plataforma para los usuarios',
  `contraseña` char(15) NOT NULL COMMENT 'Contraseña',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado',
  `fecha_sys` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `tipo_identificacion`, `n_identificacion`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `celular`, `email`, `usuario`, `contraseña`, `estado`, `fecha_sys`) VALUES
(1, '0', '0', 'admin', 'admin', 'admin', 'admin', '0', 'admin', 'admin', 'admin', 1, '2023-05-26 06:31:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id_habitaciones`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reservas`),
  ADD UNIQUE KEY `n_habitacion` (`id_habitaciones`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id_habitaciones` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reservas` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Es el ID del usuario', AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_habitaciones`) REFERENCES `habitaciones` (`id_habitaciones`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
