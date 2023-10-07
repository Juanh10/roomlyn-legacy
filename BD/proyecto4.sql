-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2023 a las 04:35:59
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
  `id_hab_estado` int(10) NOT NULL COMMENT 'id de los estados de las habitaciones',
  `tipoCama` varchar(30) NOT NULL COMMENT 'Tipo de cama de la habitacion',
  `cantidadPersonasHab` int(5) NOT NULL COMMENT 'Cantidad de personas en la habitacion',
  `tipoServicio` tinyint(1) NOT NULL COMMENT '0: ventilador  1: aire acondicionado',
  `observacion` varchar(600) NOT NULL COMMENT 'Observaciones de la habitación',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de la habitación',
  `fecha` date NOT NULL COMMENT 'Fecha de registro de la habitación',
  `hora` time NOT NULL COMMENT 'Hora de registro de la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `nHabitacion`, `id_tipo`, `id_hab_estado`, `tipoCama`, `cantidadPersonasHab`, `tipoServicio`, `observacion`, `estado`, `fecha`, `hora`, `fecha_sys`) VALUES
(1, 1, 1, 1, 'Simple', 1, 1, 'La habitación queda al lado del parqueadero, tiene dos ventanas y es muy cómoda', 1, '2023-09-23', '14:45:04', '2023-10-01 19:23:45'),
(2, 2, 2, 1, 'Simple,Doble', 3, 0, 'Es una habitación muy cómoda con dos ventanas', 1, '2023-09-23', '14:48:14', '2023-10-01 22:04:56'),
(3, 3, 3, 1, 'Simple,Simple,Doble', 4, 0, 'Muy bonito', 1, '2023-09-23', '15:26:07', '2023-09-24 12:38:14'),
(4, 4, 2, 1, 'Simple,Doble', 3, 0, 'Muy comodo\r\n', 1, '2023-09-24', '12:35:11', '2023-09-24 12:35:11'),
(5, 5, 3, 1, 'Simple,Doble,Simple', 4, 0, 'Muy comodo', 0, '2023-09-24', '12:35:39', '2023-09-24 12:35:39'),
(6, 5, 1, 1, 'Simple', 1, 0, 'GG', 0, '2023-09-24', '12:46:09', '2023-09-24 12:46:09'),
(7, 5, 1, 1, 'Simple', 1, 0, 'La habitación queda al lado del parqueadero, tiene dos ventanas y es muy cómoda. Las ventanas permiten que entre mucha luz natural, lo que la hace sentir aún más acogedora. Además, su ubicación cercana al parqueadero la hace muy conveniente para quienes deseen acceder rápidamente a su vehículo.', 1, '2023-09-24', '12:46:32', '2023-10-01 22:10:06'),
(8, 6, 1, 1, 'Simple', 1, 1, 'aFFFF', 1, '2023-10-01', '19:08:01', '2023-10-01 19:08:01'),
(9, 7, 1, 1, 'Simple', 1, 0, 'La habitación queda al lado del parqueadero, tiene dos ventanas y es muy cómoda. Las ventanas permiten que entre mucha luz natural, lo que la hace sentir aún más acogedora. Además, su ubicación cercana al parqueadero la hace muy conveniente para quienes deseen acceder rápidamente a su vehículo.', 1, '2023-10-01', '22:17:11', '2023-10-01 22:17:11'),
(10, 8, 1, 1, 'Simple', 1, 0, 'La habitación queda al lado del parqueadero, tiene dos ventanas y es muy cómoda. Las ventanas permiten que entre mucha luz natural, lo que la hace sentir aún más acogedora. Además, su ubicación cercana al parqueadero la hace muy conveniente para quienes deseen acceder rápidamente a su vehículo.', 1, '2023-10-01', '22:17:34', '2023-10-01 22:17:34'),
(11, 9, 4, 1, 'Simple,Doble,Doble,Doble', 7, 0, 'GGGG\r\n', 1, '2023-10-02', '09:27:19', '2023-10-02 09:27:19'),
(12, 10, 6, 1, 'Simple,Simple,Simple,Simple,Do', 6, 1, '4 dobles 1 sencilla\r\n\r\njhgjhjgjf', 1, '2023-10-02', '18:43:22', '2023-10-02 18:44:56');

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
(1, 'Baño privado', '2023-08-27 15:12:16'),
(2, 'Mesa', '2023-08-27 15:12:20'),
(3, 'Televisor', '2023-08-27 15:12:25'),
(4, 'Aire acondicionado', '2023-08-27 15:12:31'),
(5, 'Ventilador', '2023-08-27 15:12:37'),
(6, 'dasff', '2023-09-21 15:48:48'),
(7, 'nada', '2023-09-29 17:22:33'),
(8, 'cama', '2023-09-29 17:25:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_estado`
--

CREATE TABLE `habitaciones_estado` (
  `id` int(10) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_estado`
--

INSERT INTO `habitaciones_estado` (`id`, `estado`) VALUES
(1, 'Disponible'),
(2, 'Limpieza'),
(3, 'Mantenimiento'),
(4, 'Ocupado');

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
(1, 1, '1camaAire2', '1camaAire2.webp', 1),
(2, 2, '2camas', '2camas.webp', 1),
(3, 3, '3camas', '3camas.webp', 1),
(4, 4, 'multiple', 'multiple.webp', 1),
(5, 2, 'parqueadero', 'parqueadero.webp', 1),
(6, 1, '2camas', '2camas.webp', 0),
(7, 1, '2camas', '2camas.webp', 1),
(8, 5, 'fondo_n', 'fondo_n.jpg', 1),
(9, 4, 'reservar', 'reservar.webp', 1),
(10, 4, 'entradaPrincipal', 'entradaPrincipal.webp', 1),
(11, 4, 'entrada3', 'entrada3.webp', 1),
(12, 6, 'entradaPrincipal', 'entradaPrincipal.webp', 1);

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
(1, 'Habitación tipo 1', 1, 2, 60000, 70000, 1, '2023-09-22 17:19:30'),
(2, 'Habitación tipo 2', 2, 4, 80000, 90000, 1, '2023-09-22 17:19:53'),
(3, 'Habitación tipo 3', 3, 6, 90000, 100000, 1, '2023-09-22 17:20:19'),
(4, 'Habitación multiple', 4, 8, 200000, 300000, 1, '2023-09-22 17:20:50'),
(5, 'qwdewfr', 2, 24, 345, 3457, 0, '2023-09-29 17:43:43'),
(6, 'TPO7', 5, 10, 123409, 22220987, 1, '2023-10-02 18:40:07');

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
(1, 1, 1, 0),
(2, 1, 2, 1),
(3, 1, 3, 0),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 2, 1, 1),
(7, 2, 3, 1),
(8, 2, 4, 1),
(9, 2, 5, 1),
(10, 3, 3, 1),
(11, 3, 4, 1),
(12, 3, 5, 1),
(13, 4, 1, 1),
(14, 4, 2, 1),
(15, 4, 3, 1),
(16, 4, 4, 1),
(17, 4, 5, 1),
(18, 1, 3, 1),
(19, 5, 4, 1),
(20, 6, 3, 1),
(21, 6, 4, 1),
(22, 6, 5, 1),
(23, 6, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infousuarios`
--

CREATE TABLE `infousuarios` (
  `id_infoUsuario` int(4) NOT NULL COMMENT 'id de la Informacion del usuario',
  `id_tipoDocumento` int(10) NOT NULL COMMENT 'tipo de documento del usuario',
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

INSERT INTO `infousuarios` (`id_infoUsuario`, `id_tipoDocumento`, `documento`, `pNombre`, `sNombre`, `pApellido`, `sApellido`, `celular`, `email`) VALUES
(2, 2, '1105674597', 'Juan', 'David', 'Hernandez', '', '3106046654', 'juandavidh052@gmail.com'),
(3, 2, '1105674486', 'Leidy', 'Vanessa', 'Barrero', '', '12345678908', 'vane@gmail.com');

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
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(10) NOT NULL,
  `documento` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `documento`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Tarjeta de identidad'),
(3, 'Cédula de Extranjería'),
(4, 'Pasaporte'),
(5, 'NIT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(4) NOT NULL COMMENT 'id del usuario',
  `id_infoUsuario` int(4) NOT NULL COMMENT 'id de la informacion del usuario',
  `usuario` varchar(15) NOT NULL COMMENT 'usuario',
  `contraseña` varchar(255) NOT NULL COMMENT 'contraseña del usuario',
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
(1, 2, 'juan', '$2y$10$NgV5jz6GWYBA1clW5REXBuV5yeTrUYjYuQLfYtDCXp6jffKoWMHWq', 'Administrador', 1, '2023-09-08', '22:22:42', '2023-09-20 16:57:27'),
(2, 3, 'vanessa', '$2y$10$gFBZgjFao3Nu4Uen0v4sjuFHcBO/mWpRpnVZqyP/ueyN/E2ij/Jqm', 'Recepcionista', 1, '2023-09-08', '22:24:05', '2023-09-09 07:18:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitacionesFK` (`id_hab_estado`),
  ADD KEY `tipoHabKey` (`id_tipo`);

--
-- Indices de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitaciones_estado`
--
ALTER TABLE `habitaciones_estado`
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
  ADD PRIMARY KEY (`id_infoUsuario`),
  ADD KEY `tipo_documentoFK` (`id_tipoDocumento`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reservas`),
  ADD UNIQUE KEY `id_habitaciones` (`id_habitaciones`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `habitaciones_estado`
--
ALTER TABLE `habitaciones_estado`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  MODIFY `id_infoUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id de la Informacion del usuario', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `habitacionesFK` FOREIGN KEY (`id_hab_estado`) REFERENCES `habitaciones_estado` (`id`),
  ADD CONSTRAINT `tipoHabKey` FOREIGN KEY (`id_tipo`) REFERENCES `habitaciones_tipos` (`id`);

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
-- Filtros para la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  ADD CONSTRAINT `tipo_documentoFK` FOREIGN KEY (`id_tipoDocumento`) REFERENCES `tipo_documento` (`id`);

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
