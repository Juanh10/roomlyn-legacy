-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-08-2023 a las 04:31:44
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

--
-- Volcado de datos para la tabla `habitaciones_elementos`
--

INSERT INTO `habitaciones_elementos` (`id`, `elemento`, `fecha_sys`) VALUES
(1, 'Cama', '2023-08-12 17:29:45'),
(2, 'Mesa', '2023-08-12 17:29:48'),
(3, 'Wifi', '2023-08-12 17:29:51'),
(4, 'Aire acondicionado', '2023-08-12 17:29:56'),
(5, 'Ventilador', '2023-08-12 17:30:01'),
(6, 'Armario', '2023-08-14 11:20:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_imagenes`
--

CREATE TABLE `habitaciones_imagenes` (
  `id` int(11) NOT NULL,
  `idTipoHabitacion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la imagen	',
  `ruta` varchar(200) NOT NULL COMMENT 'Ruta de la imagen',
  `estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_imagenes`
--

INSERT INTO `habitaciones_imagenes` (`id`, `idTipoHabitacion`, `nombre`, `ruta`, `estado`) VALUES
(1, 1, '1camaAire2', '1camaAire2.jpg', 0),
(2, 2, '2camas', '2camas.jpg', 1),
(3, 2, 'conocenos2', 'conocenos2.jpg', 0),
(4, 2, 'entradaPrincipal', 'entradaPrincipal.jpg', 0),
(5, 3, '3camas', '3camas.jpg', 1),
(6, 3, 'entradaPrincipal', 'entradaPrincipal.jpg', 1),
(7, 3, 'salaRecepcion2', 'salaRecepcion2.jpg', 1),
(8, 3, 'segundoPiso - copia', 'segundoPiso - copia.jpg', 1),
(9, 4, 'multiple - copia', 'multiple - copia.jpg', 1),
(11, 2, 'zonaParqueadero', 'zonaParqueadero.jpg', 1),
(12, 2, 'segundoPiso - copia', 'segundoPiso - copia.jpg', 1),
(13, 2, 'salaRecepcion2 - copia', 'salaRecepcion2 - copia.jpg', 1),
(14, 2, 'segundoPiso', 'segundoPiso.jpg', 0),
(15, 2, 'segundoPiso - copia', 'segundoPiso - copia.jpg', 0),
(16, 2, 'segundoPiso', 'segundoPiso.jpg', 0),
(17, 2, 'multiple - copia', 'multiple - copia.jpg', 0),
(18, 2, 'parqueadero', 'parqueadero.jpg', 0),
(19, 2, 'multiple - copia', 'multiple - copia.jpg', 0),
(20, 2, 'entrada3', 'entrada3.jpg', 0),
(21, 1, 'entradaPrincipal', 'entradaPrincipal.jpg', 0),
(22, 1, '2camas', '2camas.jpg', 0),
(23, 1, 'multiple - copia', 'multiple - copia.jpg', 0),
(24, 1, 'entradaPrincipal', 'entradaPrincipal.jpg', 0),
(25, 1, '1camaAire2', '1camaAire2.jpg', 1),
(26, 1, '2camas', '2camas.jpg', 0),
(27, 2, 'parqueadero', 'parqueadero.jpg', 1),
(28, 1, 'entradaPrincipal', 'entradaPrincipal.jpg', 0),
(29, 1, 'Tarea 1', 'Tarea 1.pdf', 0),
(30, 1, '2camas', '2camas.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos`
--

CREATE TABLE `habitaciones_tipos` (
  `id` int(11) NOT NULL,
  `tipoHabitacion` varchar(30) NOT NULL COMMENT 'Tipo de habitación',
  `cantidadCamas` tinyint(2) NOT NULL COMMENT 'cantidad de camas de ese tipo',
  `capacidadPersonas` tinyint(2) NOT NULL COMMENT 'Capacidad maxima de huespedes',
  `precioVentilador` int(10) NOT NULL COMMENT 'Precio de la habitacion con ventilador',
  `precioAire` int(10) NOT NULL COMMENT 'Precio de la habitacion con aire acondicionado',
  `estado` tinyint(2) NOT NULL,
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_tipos`
--

INSERT INTO `habitaciones_tipos` (`id`, `tipoHabitacion`, `cantidadCamas`, `capacidadPersonas`, `precioVentilador`, `precioAire`, `estado`, `fecha_sys`) VALUES
(1, 'Habitación tipo 1', 1, 2, 25000, 30000, 1, '2023-08-12 17:30:40'),
(2, 'Habitación tipo 2', 2, 4, 35000, 45000, 1, '2023-08-12 17:31:42'),
(3, 'Habitación tipo 3', 3, 6, 65000, 75000, 1, '2023-08-12 17:32:20'),
(4, 'Habitación multiple', 4, 8, 85000, 105000, 1, '2023-08-12 17:32:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos_elementos`
--

CREATE TABLE `habitaciones_tipos_elementos` (
  `id` int(11) NOT NULL,
  `id_habitacion_tipo` int(11) NOT NULL,
  `id_elemento` int(11) NOT NULL,
  `estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_tipos_elementos`
--

INSERT INTO `habitaciones_tipos_elementos` (`id`, `id_habitacion_tipo`, `id_elemento`, `estado`) VALUES
(1, 1, 3, 0),
(2, 1, 4, 0),
(3, 1, 5, 0),
(4, 2, 1, 1),
(5, 2, 3, 1),
(6, 2, 4, 1),
(7, 2, 5, 0),
(8, 3, 1, 1),
(9, 3, 2, 1),
(10, 3, 3, 1),
(11, 3, 4, 1),
(12, 3, 5, 1),
(13, 4, 1, 1),
(14, 4, 2, 1),
(15, 4, 3, 1),
(16, 4, 4, 1),
(17, 4, 5, 1),
(18, 1, 1, 1),
(19, 1, 4, 0),
(20, 1, 5, 0),
(21, 1, 6, 0),
(22, 1, 2, 1),
(23, 1, 5, 0),
(24, 1, 6, 0),
(25, 1, 4, 0),
(26, 2, 5, 1),
(27, 2, 6, 1);

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

--
-- Volcado de datos para la tabla `infousuarios`
--

INSERT INTO `infousuarios` (`id_infoUsuario`, `tipoDocumento`, `documento`, `pNombre`, `sNombre`, `pApellido`, `sApellido`, `celular`, `email`) VALUES
(1, 'ti', '1105674597', 'Juan', 'David', 'Hernandez', '', '3106046654', 'juandavidh052@gmail.com'),
(2, 'ti', '1105674543', 'Leidy', 'Vanessa', 'Barrero', 'Lozano', '3124567898', 'vanessa@gmail.com');

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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `id_infoUsuario`, `usuario`, `contraseña`, `tipoUsuario`, `estado`, `fecha`, `hora`, `fecha_sys`) VALUES
(1, 1, 'Juan', '2005', 'Administrador', 1, '2023-08-12', '17:29:30', '2023-08-12 17:29:30'),
(2, 2, 'Vanessa', '2005', 'Recepcionista', 1, '2023-08-15', '18:51:28', '2023-08-18 10:31:37');

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
-- Indices de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tipo_habitacion` (`idTipoHabitacion`);

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
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reservas`),
  ADD UNIQUE KEY `id_habitaciones` (`id_habitaciones`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  MODIFY `id_infoUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id de la Informacion del usuario', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id del usuario', AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `habitaciones_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `habitaciones_tipos` (`id`);

--
-- Filtros para la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  ADD CONSTRAINT `fk_tipo_habitacion` FOREIGN KEY (`idTipoHabitacion`) REFERENCES `habitaciones_tipos` (`id`);

--
-- Filtros para la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  ADD CONSTRAINT `habitaciones_tipos_elementos_ibfk_1` FOREIGN KEY (`id_habitacion_tipo`) REFERENCES `habitaciones_tipos` (`id`),
  ADD CONSTRAINT `habitaciones_tipos_elementos_ibfk_2` FOREIGN KEY (`id_elemento`) REFERENCES `habitaciones_elementos` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_habitaciones`) REFERENCES `habitaciones` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_infoUsuario`) REFERENCES `infousuarios` (`id_infoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
