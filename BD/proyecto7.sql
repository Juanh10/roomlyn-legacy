-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2023 a las 20:48:18
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
-- Estructura de tabla para la tabla `clientes_registrados`
--

CREATE TABLE `clientes_registrados` (
  `id_cliente_registrado` int(11) NOT NULL,
  `id_info_cliente` int(10) NOT NULL COMMENT 'Identificador de la información del cliente',
  `id_rol` int(10) NOT NULL COMMENT 'Rol del cliente registrado',
  `usuario` varchar(15) NOT NULL COMMENT 'Nombre de usuario del cliente registrado',
  `contraseña` varchar(255) NOT NULL COMMENT 'Contraseña del cliente registrado',
  `estado` tinyint(1) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha y hora de registro en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id_habitaciones` int(11) NOT NULL COMMENT 'Identificador único de la habitación',
  `id_hab_estado` int(10) DEFAULT NULL COMMENT 'Identificador del estado de la habitación',
  `id_hab_tipo` int(11) DEFAULT NULL COMMENT 'Identificador del tipo de habitación',
  `nHabitacion` int(2) DEFAULT NULL COMMENT 'Número de la habitación',
  `tipoCama` varchar(30) DEFAULT NULL COMMENT 'Tipo de cama en la habitación',
  `cantidadPersonasHab` int(5) DEFAULT NULL COMMENT 'Capacidad máxima de personas en la habitación',
  `tipoServicio` tinyint(1) DEFAULT NULL COMMENT 'Tipo de servicio en la habitación (0: ventilador, 1: aire acondicionado)',
  `observacion` varchar(600) DEFAULT NULL COMMENT 'Observaciones sobre la habitación',
  `estado` tinyint(2) DEFAULT NULL COMMENT 'Estado de habilitación (0: inhabilitado, 1: habilitado)',
  `fecha` date DEFAULT NULL COMMENT 'Fecha de registro de la habitación',
  `hora` time DEFAULT NULL COMMENT 'Hora de registro de la habitación',
  `fecha_sys` datetime DEFAULT NULL COMMENT 'Fecha y hora de registro en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id_habitaciones`, `id_hab_estado`, `id_hab_tipo`, `nHabitacion`, `tipoCama`, `cantidadPersonasHab`, `tipoServicio`, `observacion`, `estado`, `fecha`, `hora`, `fecha_sys`) VALUES
(1, 1, 1, 1, '1 simple', 1, 0, 'Muy cómoda con grandes ventanas', 1, '2023-10-27', '17:25:26', '2023-10-28 20:42:13'),
(2, 1, 1, 2, '1 doble', 2, 1, 'muy cómoda y fresca', 1, '2023-10-27', '17:26:36', '2023-10-28 20:42:32'),
(3, 1, 2, 3, '2 simple', 2, 0, 'Agradable', 1, '2023-10-27', '17:27:02', '2023-10-27 17:27:02'),
(4, 1, 3, 4, '1 simple,2 doble', 5, 1, 'Agradable y muy comoda', 1, '2023-10-27', '17:28:14', '2023-10-27 17:28:14'),
(5, 1, 4, 5, '2 simple,2 doble', 6, 0, 'cómoda y amplia para compartir', 1, '2023-10-27', '17:28:59', '2023-10-27 17:37:26'),
(6, 1, 5, 6, '2 simple,2 doble', 6, 0, 'Muy comodo', 0, '2023-10-27', '17:36:39', '2023-10-27 17:36:39'),
(7, 1, 5, 7, '2 simple,2 doble', 6, 0, 'Muy comodo', 0, '2023-10-27', '17:38:13', '2023-10-27 17:38:13'),
(8, 1, 5, 8, '2 simple,2 doble', 6, 0, 'Muy comodo', 0, '2023-10-27', '17:46:44', '2023-10-27 17:46:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_elementos`
--

CREATE TABLE `habitaciones_elementos` (
  `id_hab_elemento` int(11) NOT NULL COMMENT 'Identificador único del elemento de la habitación',
  `elemento` varchar(30) NOT NULL COMMENT 'Nombre del servicio en la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha y hora de registro en el sistema'
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
  `id_hab_estado` int(10) NOT NULL COMMENT 'Identificador único del estado de la habitación',
  `estado_habitacion` varchar(30) NOT NULL COMMENT 'Nombre del estado de la habitación'
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
(1, 1, '1camaAire2', '1camaAire2.webp', 1),
(2, 2, '2camas', '2camas.webp', 1),
(3, 3, '3camas', '3camas.webp', 1),
(4, 4, 'multiple', 'multiple.webp', 1),
(5, 5, '3camas', '3camas.webp', 1),
(6, 1, 'Submodulo habitaciones', 'Submodulo habitaciones.png', 0),
(7, 1, 'editar habitacion', 'editar habitacion.png', 0),
(8, 2, 'conocenos2', 'conocenos2.jpg', 1),
(9, 2, 'salaRecepcion2 - copia', 'salaRecepcion2 - copia.jpg', 1);

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
(1, 'Habitaciones individuales', 1, 2, 60000, 70000, 1, '2023-10-27 17:21:01'),
(2, 'Habitaciones dobles', 2, 4, 80000, 100000, 1, '2023-10-27 17:22:30'),
(3, 'Habitaciones triples', 3, 6, 120000, 150000, 1, '2023-10-27 17:23:12'),
(4, 'habitaciones familiares', 4, 8, 170000, 200000, 1, '2023-10-27 17:23:52'),
(5, 'Nuevo', 4, 8, 120000, 160000, 0, '2023-10-27 17:33:02');

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
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 2, 1, 1),
(6, 2, 2, 1),
(7, 2, 3, 1),
(8, 2, 4, 1),
(9, 2, 6, 1),
(10, 3, 1, 1),
(11, 3, 2, 1),
(12, 3, 6, 1),
(13, 4, 1, 1),
(14, 4, 2, 1),
(15, 4, 3, 1),
(16, 4, 4, 1),
(17, 5, 1, 1),
(18, 5, 2, 1),
(19, 5, 3, 1),
(20, 5, 4, 1);

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
(1, 1, '1105671510', 'Madheleenk', 'Yeink', 'Venegas', 'Perdomo', '3133276377', 'madheleenkvenegas0726@gmail.com'),
(2, 1, '1105674598', 'Juan', 'David', 'Hernandez', 'Molina', '3145678909', 'juan@gmail.com'),
(3, 1, '1105674597', 'Leidy', 'Vanessa', 'Barrero', 'Lozano', '3183683155', 'vane@gmail.com'),
(4, 1, '1105674597', 'Leidy', 'Vanessa', 'Barrero', 'Lozano', '3183683155', 'vane@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_clientes`
--

CREATE TABLE `info_clientes` (
  `id_info_cliente` int(10) NOT NULL COMMENT 'Identificador único de la información del cliente registrado',
  `documento` char(15) NOT NULL COMMENT 'Número de documento del cliente registrado',
  `nombres` char(50) NOT NULL COMMENT 'Nombres del cliente registrado',
  `apellidos` char(50) NOT NULL COMMENT 'Apellidos del cliente registrado',
  `celular` char(15) NOT NULL COMMENT 'Número de celular del cliente registrado',
  `sexo` char(15) NOT NULL COMMENT 'Género del cliente registrado',
  `nacionalidad` varchar(30) NOT NULL COMMENT 'Nacionalidad del cliente registrado',
  `ciudad_origen` char(30) NOT NULL COMMENT 'Ciudad de origen del cliente registrado',
  `email` varchar(40) NOT NULL COMMENT 'Correo electrónico del cliente registrado',
  `estadoRegistro` tinyint(1) NOT NULL,
  `estado` tinyint(1) NOT NULL COMMENT 'Estado del cliente registrado (1: habilitado, 0: inhabilitado)',
  `fecha` date NOT NULL COMMENT 'Fecha de registro del cliente',
  `hora` time NOT NULL COMMENT 'Hora de registro del cliente',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha y hora de registro en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(10) NOT NULL COMMENT 'Identificador único de la reserva',
  `id_cliente` int(10) NOT NULL COMMENT 'Identificador de la información del cliente',
  `id_habitaciones` int(10) NOT NULL COMMENT 'Identificador de la habitación reservada',
  `fecha_ingreso` date NOT NULL COMMENT 'Fecha de ingreso a la reserva',
  `fecha_salida` date NOT NULL COMMENT 'Fecha de salida de la reserva',
  `estado` tinyint(5) NOT NULL COMMENT 'Estado de la reserva',
  `fecha_sys` int(11) NOT NULL COMMENT 'Fecha y hora de registro en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(10) NOT NULL COMMENT 'Identificador único del rol',
  `rol` char(30) NOT NULL COMMENT 'Nombre del rol'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'administrador'),
(2, 'recepcionista'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipoDocumento` int(10) NOT NULL COMMENT 'Identificador único del tipo de documento',
  `documento` char(50) NOT NULL COMMENT 'Nombre del tipo de documento'
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
  `id_rol` int(10) NOT NULL COMMENT 'tipo de usuario (administrador, recepcionista)',
  `estado` tinyint(2) NOT NULL COMMENT 'habilitado o inhabilitado',
  `fecha` date NOT NULL COMMENT 'fecha de registro',
  `hora` time NOT NULL COMMENT 'hora de registro',
  `fecha_sys` datetime NOT NULL COMMENT 'fecha del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `id_infoUsuario`, `usuario`, `contraseña`, `id_rol`, `estado`, `fecha`, `hora`, `fecha_sys`) VALUES
(1, 1, 'madhe', '$2y$10$sQ9bhww9JSUFPKVoA.UioeXL4xxSWZ7XBtDegOTcgNUXnZC6e9T6S', 1, 1, '2023-10-27', '16:39:33', '2023-10-27 16:39:33'),
(4, 4, 'vanessa', '$2y$10$3/3ZsxpkUDClVY0Pv/KOaec4HQr6aAP2z1P7RCwKdiInazEv2/2TK', 2, 1, '2023-10-27', '18:00:36', '2023-10-27 18:00:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes_registrados`
--
ALTER TABLE `clientes_registrados`
  ADD PRIMARY KEY (`id_cliente_registrado`),
  ADD KEY `fk_rolCliente` (`id_rol`),
  ADD KEY `fk_infoCliente` (`id_info_cliente`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id_habitaciones`),
  ADD KEY `habitacionesFK` (`id_hab_estado`),
  ADD KEY `fk_tipoHabitacion` (`id_hab_tipo`);

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
-- Indices de la tabla `info_clientes`
--
ALTER TABLE `info_clientes`
  ADD PRIMARY KEY (`id_info_cliente`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_habitacion` (`id_habitaciones`),
  ADD KEY `fk_CLiente_no_regsitrado` (`id_cliente`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

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
  ADD UNIQUE KEY `id_infoUsuario` (`id_infoUsuario`),
  ADD KEY `FK_Usuarios_rolUsuarios` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes_registrados`
--
ALTER TABLE `clientes_registrados`
  MODIFY `id_cliente_registrado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id_habitaciones` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la habitación', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  MODIFY `id_hab_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  MODIFY `id_hab_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_elementos`
--
ALTER TABLE `habitaciones_tipos_elementos`
  MODIFY `id_hab_tipo_elemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `infousuarios`
--
ALTER TABLE `infousuarios`
  MODIFY `id_infoUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id de la Informacion del usuario', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(4) NOT NULL AUTO_INCREMENT COMMENT 'id del usuario', AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes_registrados`
--
ALTER TABLE `clientes_registrados`
  ADD CONSTRAINT `fk_infoCliente` FOREIGN KEY (`id_info_cliente`) REFERENCES `info_clientes` (`id_info_cliente`),
  ADD CONSTRAINT `fk_rolCliente` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `fk_tipoHabitacion` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`),
  ADD CONSTRAINT `habitacionesFK` FOREIGN KEY (`id_hab_estado`) REFERENCES `habitaciones_estado` (`id_hab_estado`);

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
  ADD CONSTRAINT `fk_tipoDocumento` FOREIGN KEY (`id_tipoDocumento`) REFERENCES `tipo_documento` (`id_tipoDocumento`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_clienteRegistrado` FOREIGN KEY (`id_cliente`) REFERENCES `info_clientes` (`id_info_cliente`),
  ADD CONSTRAINT `fk_habitacion` FOREIGN KEY (`id_habitaciones`) REFERENCES `habitaciones` (`id_habitaciones`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_infoUsuario` FOREIGN KEY (`id_infoUsuario`) REFERENCES `infousuarios` (`id_infoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
