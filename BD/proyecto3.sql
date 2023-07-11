-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2023 a las 13:26:20
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
-- Base de datos: `proyecto3`
--

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
  `fechaRegistro` date NOT NULL COMMENT 'fecha de registro del usuario',
  `horaRegistro` time NOT NULL COMMENT 'Hora del registro de usuario',
  `fechaSys` datetime NOT NULL COMMENT 'fecha del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `tipoIdentificacion`, `numIdentificacion`, `pNombre`, `sNombre`, `pApellido`, `sApellido`, `celular`, `email`, `tipoUsuario`, `usuario`, `contraseña`, `estado`, `fechaRegistro`, `horaRegistro`, `fechaSys`) VALUES
(1, 'ti', '1105674597', 'Juan', 'David', 'Hernandez', '', '3106046654', 'juandavidh052@gmail.com', 'administrador', 'juancho2005', '2005', 1, '0000-00-00', '00:00:00', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

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
  MODIFY `idUsuario` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id del usuario', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
