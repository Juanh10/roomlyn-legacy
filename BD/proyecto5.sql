-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2023 a las 01:25:10
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
  `id_habitaciones` int(11) NOT NULL,
  `id_hab_estado` int(10) NOT NULL COMMENT 'id de los estados de las habitaciones',
  `id_hab_tipo` int(11) NOT NULL COMMENT 'id del tipo de habitación',
  `nHabitacion` int(2) NOT NULL COMMENT 'Numero de la habitación',
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

INSERT INTO `habitaciones` (`id_habitaciones`, `id_hab_estado`, `id_hab_tipo`, `nHabitacion`, `tipoCama`, `cantidadPersonasHab`, `tipoServicio`, `observacion`, `estado`, `fecha`, `hora`, `fecha_sys`) VALUES
(1, 1, 1, 1, '1 simple', 1, 0, 'Muy comodo', 1, '2023-10-20', '19:31:20', '2023-10-20 19:31:20'),
(2, 1, 1, 2, '1 simple', 1, 1, 'Muy comodo', 1, '2023-10-20', '19:31:46', '2023-10-20 19:31:46'),
(3, 1, 2, 3, '1 simple,1 doble', 3, 0, 'Muy comodo', 1, '2023-10-20', '19:31:59', '2023-10-20 19:31:59'),
(4, 1, 2, 4, '2 doble', 4, 1, 'Muy comodo', 1, '2023-10-20', '19:32:11', '2023-10-20 19:32:11'),
(5, 1, 3, 5, '1 simple,2 doble', 5, 0, 'Muy comodo', 1, '2023-10-20', '19:32:21', '2023-10-20 19:32:21'),
(6, 1, 3, 6, '3 doble', 6, 1, 'Muy comodo', 1, '2023-10-20', '19:32:35', '2023-10-20 19:32:35'),
(7, 1, 4, 7, '2 simple,2 doble', 6, 0, 'Muy comodo', 1, '2023-10-20', '19:32:47', '2023-10-20 19:32:47'),
(8, 1, 4, 8, '1 simple,3 doble', 7, 1, 'Muy comodo', 1, '2023-10-20', '19:32:58', '2023-10-20 19:32:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_elementos`
--

CREATE TABLE `habitaciones_elementos` (
  `id_hab_elemento` int(11) NOT NULL,
  `elemento` varchar(30) NOT NULL COMMENT 'Elemento de la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_elementos`
--

INSERT INTO `habitaciones_elementos` (`id_hab_elemento`, `elemento`, `fecha_sys`) VALUES
(1, 'Ventilador', '2023-10-20 18:46:09'),
(2, 'Aire acondicionado', '2023-10-20 18:46:17'),
(3, 'Baño privado', '2023-10-20 19:00:20'),
(4, 'Televisor', '2023-10-20 19:00:28'),
(5, 'Caja fuerte', '2023-10-20 19:00:35'),
(6, 'Escritorio y silla', '2023-10-20 19:11:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_estado`
--

CREATE TABLE `habitaciones_estado` (
  `id_hab_estado` int(10) NOT NULL,
  `estado_habitacion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_estado`
--

INSERT INTO `habitaciones_estado` (`id_hab_estado`, `estado_habitacion`) VALUES
(1, 'Disponible'),
(2, 'Limpieza'),
(3, 'Mantenimiento'),
(4, 'Ocupado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_imagenes`
--

CREATE TABLE `habitaciones_imagenes` (
  `id_hab_imagen` int(11) NOT NULL,
  `id_hab_tipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la imagen	',
  `ruta` varchar(200) NOT NULL COMMENT 'Ruta de la imagen',
  `estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_imagenes`
--

INSERT INTO `habitaciones_imagenes` (`id_hab_imagen`, `id_hab_tipo`, `nombre`, `ruta`, `estado`) VALUES
(1, 1, '1camaAire2', '1camaAire2.jpg', 1),
(2, 2, '2camas', '2camas.jpg', 1),
(3, 3, '3camas', '3camas.jpg', 1),
(4, 4, 'multiple', 'multiple.jpg', 1),
(5, 1, 'entradaPrincipal', 'entradaPrincipal.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos`
--

CREATE TABLE `habitaciones_tipos` (
  `id_hab_tipo` int(11) NOT NULL,
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

INSERT INTO `habitaciones_tipos` (`id_hab_tipo`, `tipoHabitacion`, `cantidadCamas`, `capacidadPersonas`, `precioVentilador`, `precioAire`, `estado`, `fecha_sys`) VALUES
(1, 'Habitaciones individuales', 1, 2, 25000, 35000, 1, '2023-10-20 19:10:14'),
(2, 'Habitaciones dobles', 2, 4, 40000, 50000, 1, '2023-10-20 19:10:51'),
(3, 'Habitaciones triples', 3, 6, 65000, 75000, 1, '2023-10-20 19:11:32'),
(4, 'Habitaciones familiares', 4, 8, 105000, 120000, 1, '2023-10-20 19:12:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos_elementos`
--

CREATE TABLE `habitaciones_tipos_elementos` (
  `id_hab_tipo_elemento` int(11) NOT NULL,
  `id_hab_tipo` int(11) NOT NULL,
  `id_hab_elemento` int(11) NOT NULL,
  `estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones_tipos_elementos`
--

INSERT INTO `habitaciones_tipos_elementos` (`id_hab_tipo_elemento`, `id_hab_tipo`, `id_hab_elemento`, `estado`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 2, 1, 1),
(4, 2, 2, 1),
(5, 2, 3, 1),
(6, 2, 4, 1),
(7, 3, 1, 1),
(8, 3, 2, 1),
(9, 3, 3, 1),
(10, 3, 4, 1),
(11, 3, 5, 1),
(12, 4, 1, 1),
(13, 4, 2, 1),
(14, 4, 3, 1),
(15, 4, 4, 1),
(16, 4, 5, 1),
(17, 4, 6, 1),
(18, 1, 5, 1),
(19, 1, 6, 1);

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
(3, 2, '1105674486', 'Leidy', 'Vanessa', 'Barrero', '', '12345678908', 'vane@gmail.com'),
(4, 1, '1105674486', 'Madheleenk', 'Yeink', 'Venegas', 'Perdomo', '3106046657', 'madhe@gmail.com');

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
  `id_tipoDocumento` int(10) NOT NULL,
  `documento` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipoDocumento`, `documento`) VALUES
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
(1, 2, 'juan', '$2y$10$NgV5jz6GWYBA1clW5REXBuV5yeTrUYjYuQLfYtDCXp6jffKoWMHWq', 'Administrador', 1, '2023-09-08', '22:22:42', '2023-10-08 12:51:51'),
(2, 3, 'vanessa', '$2y$10$gFBZgjFao3Nu4Uen0v4sjuFHcBO/mWpRpnVZqyP/ueyN/E2ij/Jqm', 'Recepcionista', 1, '2023-09-08', '22:24:05', '2023-09-09 07:18:03'),
(3, 4, 'madheleenk', '$2y$10$gFZkna4mK3gZT2n1xayAS.ds1wu1iPRrBo/8RKa4cPh3o98nA3geC', 'Recepcionista', 1, '2023-10-15', '21:11:36', '2023-10-15 21:12:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id_habitaciones`),
  ADD KEY `habitacionesFK` (`id_hab_estado`),
  ADD KEY `tipoHabKey` (`id_hab_tipo`);

--
-- Indices de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  ADD PRIMARY KEY (`id_hab_elemento`);

--
-- Indices de la tabla `habitaciones_estado`
--
ALTER TABLE `habitaciones_estado`
  ADD PRIMARY KEY (`id_hab_estado`);

--
-- Indices de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  ADD PRIMARY KEY (`id_hab_imagen`),
  ADD KEY `fk_tipo_habitacion` (`id_hab_tipo`);

--
-- Indices de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  ADD PRIMARY KEY (`id_hab_tipo`);

--
-- Indices de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  ADD PRIMARY KEY (`id_hab_tipo_elemento`),
  ADD KEY `id_habitacion_tipo` (`id_hab_tipo`),
  ADD KEY `id_elemento` (`id_hab_elemento`);

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
  ADD PRIMARY KEY (`id_tipoDocumento`);

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
  MODIFY `id_habitaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  MODIFY `id_hab_elemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `habitaciones_estado`
--
ALTER TABLE `habitaciones_estado`
  MODIFY `id_hab_estado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  MODIFY `id_hab_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  MODIFY `id_hab_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  MODIFY `id_hab_tipo_elemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  MODIFY `id_infoUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id de la Informacion del usuario', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipoDocumento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id del usuario', AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `habitacionesFK` FOREIGN KEY (`id_hab_estado`) REFERENCES `habitaciones_estado` (`id_hab_estado`),
  ADD CONSTRAINT `tipoHabKey` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`);

--
-- Filtros para la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  ADD CONSTRAINT `fk_tipo_habitacion` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`);

--
-- Filtros para la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  ADD CONSTRAINT `habitaciones_tipos_elementos_ibfk_1` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`),
  ADD CONSTRAINT `habitaciones_tipos_elementos_ibfk_2` FOREIGN KEY (`id_hab_elemento`) REFERENCES `habitaciones_elementos` (`id_hab_elemento`);

--
-- Filtros para la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  ADD CONSTRAINT `tipo_documentoFK` FOREIGN KEY (`id_tipoDocumento`) REFERENCES `tipo_documento` (`id_tipoDocumento`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_habitaciones`) REFERENCES `habitaciones` (`id_habitaciones`),
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
