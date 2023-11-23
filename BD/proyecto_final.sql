-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2023 a las 21:42:24
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
-- Base de datos: `proyecto_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_registrados`
--

CREATE TABLE `clientes_registrados` (
  `id_cliente_registrado` int(11) NOT NULL COMMENT 'Identificador único del cliente registrado',
  `id_info_cliente` int(10) NOT NULL COMMENT 'Identificador de la información del cliente',
  `id_rol` int(10) NOT NULL COMMENT 'Rol del cliente registrado',
  `usuario` varchar(40) NOT NULL COMMENT 'Nombre de usuario del cliente registrado',
  `contrasena` varchar(255) NOT NULL COMMENT 'Contraseña del cliente registrado',
  `estado` tinyint(1) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_update` datetime NOT NULL COMMENT 'Fecha y hora de actualización en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(10) NOT NULL COMMENT 'Identificador unico del departamento',
  `id_nacionalidad` int(10) NOT NULL COMMENT 'Identificador de la nacionalidad',
  `departamento` varchar(50) NOT NULL COMMENT 'Nombre del departamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `id_nacionalidad`, `departamento`) VALUES
(1, 1, 'No requerido'),
(2, 43, 'Amazonas'),
(3, 43, 'Antioquia'),
(4, 43, 'Arauca'),
(5, 43, 'Atlántico'),
(6, 43, 'Bolívar'),
(7, 43, 'Boyacá'),
(8, 43, 'Caldas'),
(9, 43, 'Caquetá'),
(10, 43, 'Casanare'),
(11, 43, 'Cauca'),
(12, 43, 'Cesar'),
(13, 43, 'Chocó'),
(14, 43, 'Córdoba'),
(15, 43, 'Cundinamarca'),
(16, 43, 'Guainía'),
(17, 43, 'Guaviare'),
(18, 43, 'Huila'),
(19, 43, 'La Guajira'),
(20, 43, 'Magdalena'),
(21, 43, 'Meta'),
(22, 43, 'Nariño'),
(23, 43, 'Norte de Santander'),
(24, 43, 'Putumayo'),
(25, 43, 'Quindío'),
(26, 43, 'Risaralda'),
(27, 43, 'San Andrés y Providencia'),
(28, 43, 'Santander'),
(29, 43, 'Sucre'),
(30, 43, 'Tolima'),
(31, 43, 'Valle del Cauca'),
(32, 43, 'Vaupés'),
(33, 43, 'Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(4) NOT NULL COMMENT 'Identificador único del empleado',
  `id_info_empleado` int(4) NOT NULL COMMENT 'Identificador de la información del empleado',
  `id_rol` int(10) NOT NULL COMMENT 'Tipo de usuario (administrador, recepcionista)',
  `usuario` varchar(15) NOT NULL COMMENT 'Nombre de usuario del empleado',
  `contrasena` varchar(255) NOT NULL COMMENT 'Contraseña del empleado',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_reg` date NOT NULL COMMENT 'Fecha de registro del empleado',
  `hora_reg` time NOT NULL COMMENT 'Hora de registro del empleado',
  `fecha_update` datetime NOT NULL COMMENT 'Fecha de actualización en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_reservas`
--

CREATE TABLE `estado_reservas` (
  `id_estado_reserva` int(5) NOT NULL COMMENT 'Identificador único del estado de la reserva',
  `nombre_estado` char(30) NOT NULL COMMENT 'Nombre de estado de la reserva'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_reservas`
--

INSERT INTO `estado_reservas` (`id_estado_reserva`, `nombre_estado`) VALUES
(1, 'Pendiente'),
(2, 'Confirmada'),
(3, 'Cancelada'),
(4, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id_habitacion` int(11) NOT NULL COMMENT 'Identificador único de la habitación',
  `id_hab_estado` int(10) DEFAULT NULL COMMENT 'Identificador del estado de la habitación',
  `id_hab_tipo` int(11) DEFAULT NULL COMMENT 'Identificador del tipo de habitación',
  `id_servicio` int(10) DEFAULT NULL COMMENT 'Identificador del tipo de servicio',
  `nHabitacion` int(2) DEFAULT NULL COMMENT 'Número de la habitación',
  `tipoCama` varchar(30) DEFAULT NULL COMMENT 'Tipo de cama en la habitación',
  `cantidadPersonasHab` int(5) DEFAULT NULL COMMENT 'Capacidad máxima de personas en la habitación',
  `observacion` varchar(600) DEFAULT NULL COMMENT 'Observaciones sobre la habitación',
  `estado` tinyint(2) DEFAULT NULL COMMENT 'Estado de habilitación (0: inhabilitado, 1: habilitado)',
  `fecha` date DEFAULT NULL COMMENT 'Fecha de registro de la habitación',
  `hora` time DEFAULT NULL COMMENT 'Hora de registro de la habitación',
  `fecha_update` datetime DEFAULT NULL COMMENT 'Fecha y hora de actualización en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_elementos`
--

CREATE TABLE `habitaciones_elementos` (
  `id_hab_elemento` int(11) NOT NULL COMMENT 'Identificado único del elemento',
  `elemento` varchar(30) NOT NULL COMMENT 'Nombre del elemento en la habitación',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha y hora de registro en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_elementos_selec`
--

CREATE TABLE `habitaciones_elementos_selec` (
  `id_hab_tipo_elemento` int(11) NOT NULL COMMENT 'Identificador único del elemento asociado al tipo de habitación',
  `id_habitacion` int(11) NOT NULL COMMENT 'Identificador de la habitación asociada',
  `id_hab_elemento` int(11) NOT NULL COMMENT 'Identificador del elemento asociado',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_sys` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Ocupado'),
(5, 'Reservada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_imagenes`
--

CREATE TABLE `habitaciones_imagenes` (
  `id_hab_imagen` int(11) NOT NULL COMMENT 'Identificador único de la imagen',
  `id_hab_tipo` int(11) NOT NULL COMMENT 'Identificador del tipo de habitación asociado',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la imagen	',
  `ruta` varchar(200) NOT NULL COMMENT 'Ruta de la imagen',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_servicios`
--

CREATE TABLE `habitaciones_servicios` (
  `id_servicio` int(10) NOT NULL COMMENT 'Identificador único del servicio',
  `servicio` varchar(30) NOT NULL COMMENT 'Nombre del servicio',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos`
--

CREATE TABLE `habitaciones_tipos` (
  `id_hab_tipo` int(11) NOT NULL COMMENT 'Identificador único del tipo de habitación',
  `tipoHabitacion` varchar(30) NOT NULL COMMENT 'Nombre del tipo de habitación',
  `cantidadCamas` tinyint(2) NOT NULL COMMENT 'Número de camas disponibles para este tipo de habitación',
  `capacidadPersonas` tinyint(2) NOT NULL COMMENT 'Capacidad máxima de huéspedes para este tipo de habitación',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha de registro del sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos_precios`
--

CREATE TABLE `habitaciones_tipos_precios` (
  `id_tipo_precio` int(10) NOT NULL COMMENT 'Identificador único del servicio asociado al tipo de habitación',
  `id_tipo_servicio` int(10) NOT NULL COMMENT 'Identificador de los servicios del tipo de habitación',
  `precio` int(10) NOT NULL COMMENT 'Precio del tipo de habitación con el servicio',
  `estado` tinyint(1) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_sys` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones_tipos_servicios`
--

CREATE TABLE `habitaciones_tipos_servicios` (
  `id_tipo_servicio` int(10) NOT NULL COMMENT 'Identificador único del servicio del tipo de habitación',
  `id_hab_tipo` int(10) NOT NULL COMMENT 'Identificador del tipo de habitación',
  `id_servicio` int(10) NOT NULL COMMENT 'Identificador de los servicios',
  `estado` tinyint(1) NOT NULL,
  `fecha_sys` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_clientes`
--

CREATE TABLE `info_clientes` (
  `id_info_cliente` int(11) NOT NULL COMMENT 'Identificador único de la información del cliente',
  `id_nacionalidad` int(10) NOT NULL COMMENT 'Nacionalidad del cliente',
  `id_departamento` int(10) NOT NULL COMMENT 'Departamento del cliente',
  `id_municipio` int(10) NOT NULL COMMENT 'Ciudad de origen del cliente ',
  `documento` char(15) NOT NULL COMMENT 'Número de documento del cliente',
  `nombres` char(50) NOT NULL COMMENT 'Nombres del cliente ',
  `apellidos` char(50) NOT NULL COMMENT 'Apellidos del cliente',
  `celular` char(15) NOT NULL COMMENT 'Número de celular del cliente',
  `sexo` char(15) NOT NULL COMMENT 'Género del cliente',
  `email` varchar(40) NOT NULL COMMENT 'Correo electrónico del cliente',
  `estadoRegistro` tinyint(1) NOT NULL COMMENT '(0: Cliente no registrado, 1: cliente registrado)',
  `estado` tinyint(1) NOT NULL COMMENT 'Estado del cliente (1: habilitado, 0: inhabilitado)',
  `fecha_reg` date NOT NULL COMMENT 'Fecha de registro del cliente',
  `hora_reg` time NOT NULL COMMENT 'Hora de registro del cliente',
  `fecha_update` datetime NOT NULL COMMENT 'Fecha y hora de actualizacion en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_empleados`
--

CREATE TABLE `info_empleados` (
  `id_info_empleado` int(4) NOT NULL COMMENT 'Identificador único de la Informacion del empleado',
  `id_tipoDocumento` int(10) NOT NULL COMMENT 'Tipo de documento del empleado',
  `documento` char(15) NOT NULL COMMENT 'Numero de documento del empleado',
  `pNombre` varchar(30) NOT NULL COMMENT 'Primer nombre del empleado',
  `sNombre` varchar(30) NOT NULL COMMENT 'Segundo nombre del empleado',
  `pApellido` varchar(30) NOT NULL COMMENT 'Primer apellido del empleado',
  `sApellido` varchar(30) NOT NULL COMMENT 'Segundo apellido del empleado',
  `celular` char(12) NOT NULL COMMENT 'Numero del celular del empleado',
  `email` varchar(40) NOT NULL COMMENT 'Correo electronico del empleado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municipio` int(10) NOT NULL COMMENT 'Identificador único del municipio',
  `id_departamento` int(10) NOT NULL COMMENT 'Identificador del departamento',
  `municipio` varchar(30) NOT NULL COMMENT 'Nombre del municipio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `id_departamento`, `municipio`) VALUES
(1, 1, 'No requerido'),
(2, 2, 'Leticia'),
(3, 2, 'Puerto Nariño'),
(4, 2, 'El Encanto'),
(5, 2, 'La Chorrera'),
(6, 2, 'La Pedrera'),
(7, 2, 'Mirití Paraná'),
(8, 2, 'Puerto Santander'),
(9, 2, 'Tarapacá'),
(10, 2, 'Puerto Arica'),
(11, 2, 'Puerto Alegría'),
(12, 2, 'La Victoria'),
(13, 3, 'Abejorral'),
(14, 3, 'Abriaquí'),
(15, 3, 'Alejandría'),
(16, 3, 'Amagá'),
(17, 3, 'Amalfi'),
(18, 3, 'Andes'),
(19, 3, 'Angelópolis'),
(20, 3, 'Angostura'),
(21, 3, 'Anorí'),
(22, 3, 'Anzá'),
(23, 3, 'Apartadó'),
(24, 3, 'Arboletes'),
(25, 3, 'Argelia'),
(26, 3, 'Armenia'),
(27, 3, 'Barbosa'),
(28, 3, 'Bello'),
(29, 3, 'Belmira'),
(30, 3, 'Betania'),
(31, 3, 'Betulia'),
(32, 3, 'Bolívar'),
(33, 3, 'Briceño'),
(34, 3, 'Buriticá'),
(35, 3, 'Cáceres'),
(36, 3, 'Caicedo'),
(37, 3, 'Caldas'),
(38, 3, 'Campamento'),
(39, 3, 'Cañasgordas'),
(40, 3, 'Caracolí'),
(41, 3, 'Caramanta'),
(42, 3, 'Carepa'),
(43, 3, 'Carmen de Viboral'),
(44, 3, 'Carolina del Príncipe'),
(45, 3, 'Caucasia'),
(46, 3, 'Chigorodó'),
(47, 3, 'Cisneros'),
(48, 3, 'Cocorná'),
(49, 3, 'Concepción'),
(50, 3, 'Concordia'),
(51, 3, 'Copacabana'),
(52, 3, 'Dabeiba'),
(53, 3, 'Donmatías'),
(54, 3, 'Ebéjico'),
(55, 3, 'El Bagre'),
(56, 3, 'El Carmen de Atrato'),
(57, 3, 'El Carmen de Viboral'),
(58, 3, 'El Peñol'),
(59, 3, 'El Retiro'),
(60, 3, 'El Santuario'),
(61, 3, 'Entrerríos'),
(62, 3, 'Envigado'),
(63, 3, 'Fredonia'),
(64, 3, 'Frontino'),
(65, 3, 'Giraldo'),
(66, 3, 'Girardota'),
(67, 3, 'Gómez Plata'),
(68, 3, 'Granada'),
(69, 3, 'Guadalupe'),
(70, 3, 'Guarne'),
(71, 3, 'Guatapé'),
(72, 3, 'Heliconia'),
(73, 3, 'Hispania'),
(74, 3, 'Itagüí'),
(75, 3, 'Ituango'),
(76, 3, 'Jardín'),
(77, 3, 'Jericó'),
(78, 3, 'La Ceja'),
(79, 3, 'La Estrella'),
(80, 3, 'La Pintada'),
(81, 3, 'La Unión'),
(82, 3, 'Liborina'),
(83, 3, 'Maceo'),
(84, 3, 'Marinilla'),
(85, 3, 'Medellín'),
(86, 3, 'Montebello'),
(87, 3, 'Murindó'),
(88, 3, 'Mutatá'),
(89, 3, 'Nariño'),
(90, 3, 'Necoclí'),
(91, 3, 'Nechí'),
(92, 3, 'Olaya'),
(93, 3, 'Peque'),
(94, 3, 'Pueblorrico'),
(95, 3, 'Puerto Berrío'),
(96, 3, 'Puerto Nare'),
(97, 3, 'Puerto Triunfo'),
(98, 3, 'Remedios'),
(99, 3, 'Rionegro'),
(100, 3, 'Sabanalarga'),
(101, 3, 'Sabaneta'),
(102, 3, 'Salgar'),
(103, 3, 'San Andrés de Cuerquia'),
(104, 3, 'San Carlos'),
(105, 3, 'San Francisco'),
(106, 3, 'San Jerónimo'),
(107, 3, 'San José de la Montaña'),
(108, 3, 'San Juan de Urabá'),
(109, 3, 'San Luis'),
(110, 3, 'San Pedro de los Milagros'),
(111, 3, 'San Pedro de Urabá'),
(112, 3, 'San Rafael'),
(113, 3, 'San Roque'),
(114, 3, 'San Vicente'),
(115, 3, 'Santa Bárbara'),
(116, 3, 'Santa Fe de Antioquia'),
(117, 3, 'Santa Rosa de Osos'),
(118, 3, 'Santo Domingo'),
(119, 3, 'Santuario'),
(120, 3, 'Segovia'),
(121, 3, 'Sonsón'),
(122, 3, 'Sopetrán'),
(123, 3, 'Tarazá'),
(124, 3, 'Tarso'),
(125, 3, 'Titiribí'),
(126, 3, 'Toledo'),
(127, 3, 'Turbo'),
(128, 3, 'Uramita'),
(129, 3, 'Urrao'),
(130, 3, 'Valdivia'),
(131, 3, 'Valparaíso'),
(132, 3, 'Vegachí'),
(133, 3, 'Venecia'),
(134, 3, 'Vigía del Fuerte'),
(135, 3, 'Yalí'),
(136, 3, 'Yarumal'),
(137, 3, 'Yolombó'),
(138, 3, 'Yondó'),
(139, 3, 'Zaragoza'),
(140, 4, 'Arauca'),
(141, 4, 'Arauquita'),
(142, 4, 'Cravo Norte'),
(143, 4, 'Fortul'),
(144, 4, 'Puerto Rondón'),
(145, 4, 'Saravena'),
(146, 4, 'Tame'),
(147, 5, 'Barranquilla'),
(148, 5, 'Baranoa'),
(149, 5, 'Campo de la Cruz'),
(150, 5, 'Candelaria'),
(151, 5, 'Galapa'),
(152, 5, 'Juan de Acosta'),
(153, 5, 'Luruaco'),
(154, 5, 'Malambo'),
(155, 5, 'Manatí'),
(156, 5, 'Palmar de Varela'),
(157, 5, 'Piojó'),
(158, 5, 'Polonuevo'),
(159, 5, 'Ponedera'),
(160, 5, 'Puerto Colombia'),
(161, 5, 'Repelón'),
(162, 5, 'Sabanagrande'),
(163, 5, 'Sabanalarga'),
(164, 5, 'Santa Lucía'),
(165, 5, 'Santo Tomás'),
(166, 5, 'Soledad'),
(167, 5, 'Suan'),
(168, 5, 'Tubará'),
(169, 5, 'Usiacurí'),
(170, 6, 'Achí'),
(171, 6, 'Altos del Rosario'),
(172, 6, 'Arenal'),
(173, 6, 'Arjona'),
(174, 6, 'Arroyohondo'),
(175, 6, 'Barranco de Loba'),
(176, 6, 'Calamar'),
(177, 6, 'Cantagallo'),
(178, 6, 'Carmen de Bolívar'),
(179, 6, 'Cartagena de Indias'),
(180, 6, 'Cicuco'),
(181, 6, 'Clemencia'),
(182, 6, 'Córdoba'),
(183, 6, 'El Guamo'),
(184, 6, 'El Peñón'),
(185, 6, 'Hatillo de Loba'),
(186, 6, 'Magangué'),
(187, 6, 'Mahates'),
(188, 6, 'Margarita'),
(189, 6, 'María La Baja'),
(190, 6, 'Montecristo'),
(191, 6, 'Morales'),
(192, 6, 'Norosí'),
(193, 6, 'Pinillos'),
(194, 6, 'Regidor'),
(195, 6, 'Río Viejo'),
(196, 6, 'San Cristóbal'),
(197, 6, 'San Estanislao'),
(198, 6, 'San Fernando'),
(199, 6, 'San Jacinto'),
(200, 6, 'San Jacinto del Cauca'),
(201, 6, 'San Juan Nepomuceno'),
(202, 6, 'San Martín de Loba'),
(203, 6, 'San Pablo'),
(204, 6, 'Santa Catalina'),
(205, 6, 'Santa Rosa'),
(206, 6, 'Simití'),
(207, 6, 'Soplaviento'),
(208, 6, 'Talaigua Nuevo'),
(209, 6, 'Tiquisio'),
(210, 6, 'Turbaco'),
(211, 6, 'Turbaná'),
(212, 6, 'Villanueva'),
(213, 6, 'Zambrano'),
(214, 6, 'Islas del Rosario'),
(215, 6, 'Isla Fuerte'),
(216, 6, 'Isla de San Bernardo'),
(217, 7, 'Almeida'),
(218, 7, 'Aquitania'),
(219, 7, 'Arcabuco'),
(220, 7, 'Belén'),
(221, 7, 'Berbeo'),
(222, 7, 'Betéitiva'),
(223, 7, 'Boavita'),
(224, 7, 'Boyacá'),
(225, 7, 'Briceño'),
(226, 7, 'Buenavista'),
(227, 7, 'Busbanzá'),
(228, 7, 'Caldas'),
(229, 7, 'Campohermoso'),
(230, 7, 'Cerinza'),
(231, 7, 'Chinavita'),
(232, 7, 'Chiquinquirá'),
(233, 7, 'Chíquiza'),
(234, 7, 'Chiscas'),
(235, 7, 'Chita'),
(236, 7, 'Chitaraque'),
(237, 7, 'Chivatá'),
(238, 7, 'Chivor'),
(239, 7, 'Ciénega'),
(240, 7, 'Cómbita'),
(241, 7, 'Coper'),
(242, 7, 'Corrales'),
(243, 7, 'Covarachía'),
(244, 7, 'Cubará'),
(245, 7, 'Cucaita'),
(246, 7, 'Cuítiva'),
(247, 7, 'Duitama'),
(248, 7, 'El Cocuy'),
(249, 7, 'El Espino'),
(250, 7, 'Firavitoba'),
(251, 7, 'Floresta'),
(252, 7, 'Gachantivá'),
(253, 7, 'Gámeza'),
(254, 7, 'Garagoa'),
(255, 7, 'Guacamayas'),
(256, 7, 'Guateque'),
(257, 7, 'Guayatá'),
(258, 7, 'Güicán'),
(259, 7, 'Iza'),
(260, 7, 'Jenesano'),
(261, 7, 'Jericó'),
(262, 7, 'La Capilla'),
(263, 7, 'La Uvita'),
(264, 7, 'La Victoria'),
(265, 7, 'Labranzagrande'),
(266, 7, 'Macanal'),
(267, 7, 'Maripí'),
(268, 7, 'Miraflores'),
(269, 7, 'Mongua'),
(270, 7, 'Monguí'),
(271, 7, 'Moniquirá'),
(272, 7, 'Motavita'),
(273, 7, 'Muzo'),
(274, 7, 'Nobsa'),
(275, 7, 'Nuevo Colón'),
(276, 7, 'Oicatá'),
(277, 7, 'Otanche'),
(278, 7, 'Pachavita'),
(279, 7, 'Páez'),
(280, 7, 'Paipa'),
(281, 7, 'Pajarito'),
(282, 7, 'Panqueba'),
(283, 7, 'Pauna'),
(284, 7, 'Paya'),
(285, 7, 'Paz de Río'),
(286, 7, 'Pesca'),
(287, 7, 'Pisba'),
(288, 7, 'Puerto Boyacá'),
(289, 7, 'Quípama'),
(290, 7, 'Ramiriquí'),
(291, 7, 'Ráquira'),
(292, 7, 'Rondón'),
(293, 7, 'Saboyá'),
(294, 7, 'Sáchica'),
(295, 7, 'Samacá'),
(296, 7, 'San Eduardo'),
(297, 7, 'San José de Pare'),
(298, 7, 'San Luis de Gaceno'),
(299, 7, 'San Mateo'),
(300, 7, 'San Miguel de Sema'),
(301, 7, 'San Pablo de Borbur'),
(302, 7, 'Santa María'),
(303, 7, 'Santa Rosa de Viterbo'),
(304, 7, 'Santa Sofía'),
(305, 7, 'Santana'),
(306, 7, 'Sativanorte'),
(307, 7, 'Sativasur'),
(308, 7, 'Siachoque'),
(309, 7, 'Soatá'),
(310, 7, 'Socha'),
(311, 7, 'Socotá'),
(312, 7, 'Sogamoso'),
(313, 7, 'Somondoco'),
(314, 7, 'Sora'),
(315, 7, 'Soracá'),
(316, 7, 'Sotaquirá'),
(317, 7, 'Susacón'),
(318, 7, 'Sutamarchán'),
(319, 7, 'Sutatenza'),
(320, 7, 'Tasco'),
(321, 7, 'Tenza'),
(322, 7, 'Tibaná'),
(323, 7, 'Tibasosa'),
(324, 7, 'Tinjacá'),
(325, 7, 'Tipacoque'),
(326, 7, 'Toca'),
(327, 7, 'Togüí'),
(328, 7, 'Tópaga'),
(329, 7, 'Tota'),
(330, 7, 'Tunja'),
(331, 7, 'Tununguá'),
(332, 7, 'Turmequé'),
(333, 7, 'Tuta'),
(334, 7, 'Tutazá'),
(335, 7, 'Úmbita'),
(336, 7, 'Ventaquemada'),
(337, 7, 'Villa de Leyva'),
(338, 7, 'Viracachá'),
(339, 7, 'Zetaquirá'),
(340, 8, 'Aguadas'),
(341, 8, 'Anserma'),
(342, 8, 'Aranzazu'),
(343, 8, 'Belalcázar'),
(344, 8, 'Chinchiná'),
(345, 8, 'Filadelfia'),
(346, 8, 'La Dorada'),
(347, 8, 'La Merced'),
(348, 8, 'Manizales'),
(349, 8, 'Manzanares'),
(350, 8, 'Marmato'),
(351, 8, 'Marquetalia'),
(352, 8, 'Marulanda'),
(353, 8, 'Neira'),
(354, 8, 'Norcasia'),
(355, 8, 'Palestina'),
(356, 8, 'Pensilvania'),
(357, 8, 'Pácora'),
(358, 8, 'Paleton'),
(359, 8, 'Riosucio'),
(360, 8, 'Risaralda'),
(361, 8, 'Salamina'),
(362, 8, 'Samaná'),
(363, 8, 'San José'),
(364, 8, 'Supía'),
(365, 8, 'Victoria'),
(366, 8, 'Villamaría'),
(367, 8, 'Viterbo'),
(368, 9, 'Albania'),
(369, 9, 'Belén de los Andaquíes'),
(370, 9, 'Cartagena del Chairá'),
(371, 9, 'Curillo'),
(372, 9, 'El Doncello'),
(373, 9, 'El Paujil'),
(374, 9, 'Florencia'),
(375, 9, 'La Montañita'),
(376, 9, 'Milán'),
(377, 9, 'Morelia'),
(378, 9, 'Puerto Rico'),
(379, 9, 'San José del Fragua'),
(380, 9, 'San Vicente del Caguán'),
(381, 9, 'Solano'),
(382, 9, 'Solita'),
(383, 9, 'Valparaíso'),
(384, 10, 'Aguazul'),
(385, 10, 'Chámeza'),
(386, 10, 'Hato Corozal'),
(387, 10, 'La Salina'),
(388, 10, 'Maní'),
(389, 10, 'Monterrey'),
(390, 10, 'Nunchía'),
(391, 10, 'Orocué'),
(392, 10, 'Paz de Ariporo'),
(393, 10, 'Pore'),
(394, 10, 'Recetor'),
(395, 10, 'Sabanalarga'),
(396, 10, 'Sácama'),
(397, 10, 'San Luis de Palenque'),
(398, 10, 'Támara'),
(399, 10, 'Tauramena'),
(400, 10, 'Trinidad '),
(401, 10, 'Villanueva'),
(402, 10, 'Yopal '),
(403, 11, 'Almaguer'),
(404, 11, 'Argelia'),
(405, 11, 'Balboa'),
(406, 11, 'Bolívar'),
(407, 11, 'Buenos Aires'),
(408, 11, 'Cajibío'),
(409, 11, 'Caldono'),
(410, 11, 'Caloto'),
(411, 11, 'Corinto'),
(412, 11, 'El Tambo'),
(413, 11, 'Florencia'),
(414, 11, 'Guachené'),
(415, 11, 'Inzá'),
(416, 11, 'Jambaló'),
(417, 11, 'La Sierra'),
(418, 11, 'La Vega'),
(419, 11, 'López de Micay'),
(420, 11, 'Mercaderes'),
(421, 11, 'Miranda'),
(422, 11, 'Morales'),
(423, 11, 'Padilla'),
(424, 11, 'Páez'),
(425, 11, 'Patía'),
(426, 11, 'Piamonte'),
(427, 11, 'Piendamó'),
(428, 11, 'Popayán '),
(429, 11, 'Puerto Tejada'),
(430, 11, 'Puracé'),
(431, 11, 'Rosas'),
(432, 11, 'San Sebastián'),
(433, 11, 'Santander de Quilichao'),
(434, 11, 'Santa Rosa'),
(435, 11, 'Silvia'),
(436, 11, 'Sotará'),
(437, 11, 'Suarez'),
(438, 11, 'Sucre'),
(439, 11, 'Timbío'),
(440, 11, 'Timbiquí'),
(441, 11, 'Toribio'),
(442, 11, 'Totoró'),
(443, 11, 'Villa Rica'),
(444, 12, 'Aguachica'),
(445, 12, 'Agustín Codazzi'),
(446, 12, 'Astrea'),
(447, 12, 'Becerril'),
(448, 12, 'Bosconia'),
(449, 12, 'Chiriguaná'),
(450, 12, 'Curumaní'),
(451, 12, 'El Copey'),
(452, 12, 'El Paso'),
(453, 12, 'Gamarra'),
(454, 12, 'González'),
(455, 12, 'La Gloria'),
(456, 12, 'La Jagua de Ibirico'),
(457, 12, 'La Paz'),
(458, 12, 'Manaure Balcón del Cesar'),
(459, 12, 'Pailitas'),
(460, 12, 'Pelaya'),
(461, 12, 'Pueblo Bello'),
(462, 12, 'Río de Oro'),
(463, 12, 'San Alberto'),
(464, 12, 'San Diego'),
(465, 12, 'San Martín'),
(466, 12, 'Tamalameque'),
(467, 12, 'Valledupar '),
(468, 13, 'Acandí'),
(469, 13, 'Alto Baudó'),
(470, 13, 'Atrato'),
(471, 13, 'Bagadó'),
(472, 13, 'Bahía Solano'),
(473, 13, 'Bajo Baudó'),
(474, 13, 'Belén de Bajirá'),
(475, 13, 'Bojayá'),
(476, 13, 'Cértegui'),
(477, 13, 'Condoto'),
(478, 13, 'El Carmen de Atrato'),
(479, 13, 'El Carmen del Darién'),
(480, 13, 'Istmina'),
(481, 13, 'Juradó'),
(482, 13, 'Lloró'),
(483, 13, 'Medio Atrato'),
(484, 13, 'Medio Baudó'),
(485, 13, 'Medio San Juan'),
(486, 13, 'Nóvita'),
(487, 13, 'Nuquí'),
(488, 13, 'Quibdó '),
(489, 13, 'Río Iró'),
(490, 13, 'Río Quito'),
(491, 13, 'Riosucio'),
(492, 13, 'San José del Palmar'),
(493, 13, 'Sipí'),
(494, 13, 'Tadó'),
(495, 13, 'Unguía'),
(496, 13, 'Unión Panamericana'),
(497, 14, 'Ayapel'),
(498, 14, 'Buenavista'),
(499, 14, 'Canalete'),
(500, 14, 'Cereté'),
(501, 14, 'Chimá'),
(502, 14, 'Chinú'),
(503, 14, 'Ciénaga de Oro'),
(504, 14, 'Cotorra'),
(505, 14, 'La Apartada'),
(506, 14, 'Lorica'),
(507, 14, 'Los Córdobas'),
(508, 14, 'Momil'),
(509, 14, 'Montelíbano'),
(510, 14, 'Montería (capital del departam'),
(511, 14, 'Moñitos'),
(512, 14, 'Planeta Rica'),
(513, 14, 'Pueblo Nuevo'),
(514, 14, 'Puerto Escondido'),
(515, 14, 'Puerto Libertador'),
(516, 14, 'Purísima'),
(517, 14, 'Sahagún'),
(518, 14, 'San Andrés de Sotavento'),
(519, 14, 'San Antero'),
(520, 14, 'San Bernardo del Viento'),
(521, 14, 'San Carlos'),
(522, 14, 'San Pelayo'),
(523, 14, 'Tierralta'),
(524, 14, 'Valencia'),
(525, 15, 'Anapoima'),
(526, 15, 'Arbeláez'),
(527, 15, 'Beltrán'),
(528, 15, 'Bituima'),
(529, 15, 'Bogotá'),
(530, 15, 'Bojacá'),
(531, 15, 'Cabrera'),
(532, 15, 'Cachipay'),
(533, 15, 'Cajicá'),
(534, 15, 'Caparrapí'),
(535, 15, 'Caqueza'),
(536, 15, 'Chaguaní'),
(537, 15, 'Chipaque'),
(538, 15, 'Choachí'),
(539, 15, 'Chocontá'),
(540, 15, 'Cogua'),
(541, 15, 'Cota'),
(542, 15, 'Cucunubá'),
(543, 15, 'El Colegio'),
(544, 15, 'El Rosal'),
(545, 15, 'Fomeque'),
(546, 15, 'Fosca'),
(547, 15, 'Funza'),
(548, 15, 'Fúquene'),
(549, 15, 'Gachala'),
(550, 15, 'Gachancipá'),
(551, 15, 'Gachetá'),
(552, 15, 'Girardot'),
(553, 15, 'Granada'),
(554, 15, 'Guachetá'),
(555, 15, 'Guaduas'),
(556, 15, 'Guasca'),
(557, 15, 'Guataquí'),
(558, 15, 'Guatavita'),
(559, 15, 'Guayabetal'),
(560, 15, 'Gutiérrez'),
(561, 15, 'Jerusalén'),
(562, 15, 'Junín'),
(563, 15, 'La Calera'),
(564, 15, 'La Mesa'),
(565, 15, 'La Palma'),
(566, 15, 'La Peña'),
(567, 15, 'La Vega'),
(568, 15, 'Lenguazaque'),
(569, 15, 'Macheta'),
(570, 15, 'Madrid'),
(571, 15, 'Manta'),
(572, 15, 'Medina'),
(573, 15, 'Mosquera'),
(574, 15, 'Nariño'),
(575, 15, 'Nemocón'),
(576, 15, 'Nilo'),
(577, 15, 'Nimaima'),
(578, 15, 'Nocaima'),
(579, 15, 'Venecia'),
(580, 15, 'Pacho'),
(581, 15, 'Paime'),
(582, 15, 'Pandi'),
(583, 15, 'Paratebueno'),
(584, 15, 'Pasca'),
(585, 15, 'Puerto Salgar'),
(586, 15, 'Pulí'),
(587, 15, 'Quebradanegra'),
(588, 15, 'Quetame'),
(589, 15, 'Quipile'),
(590, 15, 'Apulo'),
(591, 15, 'Ricaurte'),
(592, 15, 'San Bernardo'),
(593, 15, 'San Cayetano'),
(594, 15, 'San Francisco'),
(595, 15, 'Sesquilé'),
(596, 15, 'Sibaté'),
(597, 15, 'Silvania'),
(598, 15, 'Simijaca'),
(599, 15, 'Soacha'),
(600, 15, 'Subachoque'),
(601, 15, 'Suesca'),
(602, 15, 'Supatá'),
(603, 15, 'Susa'),
(604, 15, 'Sutatausa'),
(605, 15, 'Tabio'),
(606, 15, 'Tausa'),
(607, 15, 'Tena'),
(608, 15, 'Tenjo'),
(609, 15, 'Tibacuy'),
(610, 15, 'Tibirita'),
(611, 15, 'Tocaima'),
(612, 15, 'Tocancipá'),
(613, 15, 'Topaipí'),
(614, 15, 'Ubalá'),
(615, 15, 'Ubaque'),
(616, 15, 'Une'),
(617, 15, 'Útica'),
(618, 15, 'Vianí'),
(619, 15, 'Villagómez'),
(620, 15, 'Villapinzón'),
(621, 15, 'Villeta'),
(622, 15, 'Viotá'),
(623, 15, 'Zipacón'),
(624, 15, 'San Juan de Río Seco'),
(625, 15, 'Villa de San Diego de Ubate'),
(626, 15, 'Guayabal de Siquima'),
(627, 15, 'San Antonio del Tequendama'),
(628, 15, 'Agua de Dios'),
(629, 15, 'Carmen de Carupa'),
(630, 15, 'Vergara'),
(631, 15, 'Albán'),
(632, 15, 'Anolaima'),
(633, 15, 'Chía'),
(634, 15, 'El Peñón'),
(635, 15, 'Sopó'),
(636, 15, 'Gama'),
(637, 15, 'Sasaima'),
(638, 15, 'Yacopí'),
(639, 15, 'Fusagasugá'),
(640, 15, 'Zipaquirá'),
(641, 15, 'Facatativá'),
(642, 16, 'Inírida'),
(643, 16, 'Barranco Minas'),
(644, 16, 'Mapiripana'),
(645, 16, 'San Felipe'),
(646, 16, 'Puerto Colombia'),
(647, 16, 'La Guadalupe'),
(648, 16, 'Cacahual'),
(649, 16, 'Pana Pana'),
(650, 16, 'Morichal'),
(651, 17, 'Calamar'),
(652, 17, 'San José del Guaviare'),
(653, 17, 'Miraflores'),
(654, 17, 'El Retorno'),
(655, 18, 'Acevedo'),
(656, 18, 'Agrado'),
(657, 18, 'Aipe'),
(658, 18, 'Algeciras'),
(659, 18, 'Altamira'),
(660, 18, 'Baraya'),
(661, 18, 'Campoalegre'),
(662, 18, 'Colombia'),
(663, 18, 'Elías'),
(664, 18, 'Garzón'),
(665, 18, 'Gigante'),
(666, 18, 'Guadalupe'),
(667, 18, 'Hobo'),
(668, 18, 'Iquira'),
(669, 18, 'Isnos'),
(670, 18, 'La Argentina'),
(671, 18, 'La Plata'),
(672, 18, 'Nátaga'),
(673, 18, 'Neiva'),
(674, 18, 'Oporapa'),
(675, 18, 'Paicol'),
(676, 18, 'Palermo'),
(677, 18, 'Palestina'),
(678, 18, 'Pital'),
(679, 18, 'Pitalito'),
(680, 18, 'Rivera'),
(681, 18, 'Saladoblanco'),
(682, 18, 'San Agustín'),
(683, 18, 'Santa María'),
(684, 18, 'Suaza'),
(685, 18, 'Tarqui'),
(686, 18, 'Tello'),
(687, 18, 'Teruel'),
(688, 18, 'Tesalia'),
(689, 18, 'Timaná'),
(690, 18, 'Villavieja'),
(691, 18, 'Yaguará'),
(692, 19, 'Albania'),
(693, 19, 'Barrancas'),
(694, 19, 'Dibula'),
(695, 19, 'Distracción'),
(696, 19, 'El Molino'),
(697, 19, 'Fonseca'),
(698, 19, 'Hatonuevo'),
(699, 19, 'La Jagua del Pilar'),
(700, 19, 'Maicao'),
(701, 19, 'Manaure'),
(702, 19, 'Riohacha'),
(703, 19, 'San Juan del Cesar'),
(704, 19, 'Uribia'),
(705, 19, 'Urumita'),
(706, 19, 'Villanueva'),
(707, 20, 'Algarrobo'),
(708, 20, 'Aracataca'),
(709, 20, 'Ariguaní'),
(710, 20, 'Cerro San Antonio'),
(711, 20, 'Chivolo'),
(712, 20, 'Ciénaga'),
(713, 20, 'Concordia'),
(714, 20, 'El Banco'),
(715, 20, 'El Piñon'),
(716, 20, 'El Retén'),
(717, 20, 'Fundación'),
(718, 20, 'Guamal'),
(719, 20, 'Nueva Granada'),
(720, 20, 'Pedraza'),
(721, 20, 'Pijiño del Carmen'),
(722, 20, 'Pivijay'),
(723, 20, 'Plato'),
(724, 20, 'Pueblo Viejo'),
(725, 20, 'Remolino'),
(726, 20, 'Sabanas de San Angel'),
(727, 20, 'Salamina'),
(728, 20, 'San Sebastián de Buenavista'),
(729, 20, 'Santa Ana'),
(730, 20, 'Santa Bárbara de Pinto'),
(731, 20, 'Santa Marta'),
(732, 20, 'San Zenón'),
(733, 20, 'Sitionuevo'),
(734, 20, 'Tenerife'),
(735, 20, 'Zapayán'),
(736, 20, 'Zona Bananera'),
(737, 21, 'Acacias'),
(738, 21, 'Barranca de Upía'),
(739, 21, 'Cabuyaro'),
(740, 21, 'Castilla la Nueva'),
(741, 21, 'Cubarral'),
(742, 21, 'Cumaral'),
(743, 21, 'El Calvario'),
(744, 21, 'El Castillo'),
(745, 21, 'El Dorado'),
(746, 21, 'Fuente de Oro'),
(747, 21, 'Granada'),
(748, 21, 'Guamal'),
(749, 21, 'La Macarena'),
(750, 21, 'Lejanías'),
(751, 21, 'Mapiripán'),
(752, 21, 'Mesetas'),
(753, 21, 'Puerto Concordia'),
(754, 21, 'Puerto Gaitán'),
(755, 21, 'Puerto Lleras'),
(756, 21, 'Puerto López'),
(757, 21, 'Puerto Rico'),
(758, 21, 'Restrepo'),
(759, 21, 'San Carlos de Guaroa'),
(760, 21, 'San Juan de Arama'),
(761, 21, 'San Juanito'),
(762, 21, 'San Martín'),
(763, 21, 'Uribe'),
(764, 21, 'Villavicencio'),
(765, 21, 'Vista Hermosa'),
(766, 22, 'Albán'),
(767, 22, 'Aldana'),
(768, 22, 'Ancuyá'),
(769, 22, 'Arboleda'),
(770, 22, 'Barbacoas'),
(771, 22, 'Belén'),
(772, 22, 'Buesaco'),
(773, 22, 'Chachagüí'),
(774, 22, 'Colón'),
(775, 22, 'Consaca'),
(776, 22, 'Contadero'),
(777, 22, 'Córdoba'),
(778, 22, 'Cuaspud'),
(779, 22, 'Cumbal'),
(780, 22, 'Cumbitara'),
(781, 22, 'El Charco'),
(782, 22, 'El Peñol'),
(783, 22, 'El Rosario'),
(784, 22, 'El Tablón de Gómez'),
(785, 22, 'El Tambo'),
(786, 22, 'Francisco Pizarro'),
(787, 22, 'Funes'),
(788, 22, 'Guachucal'),
(789, 22, 'Guaitarilla'),
(790, 22, 'Gualmatán'),
(791, 22, 'Iles'),
(792, 22, 'Imués'),
(793, 22, 'Ipiales'),
(794, 22, 'La Cruz'),
(795, 22, 'La Florida'),
(796, 22, 'La Llanada'),
(797, 22, 'La Tola'),
(798, 22, 'La Unión'),
(799, 22, 'Leiva'),
(800, 22, 'Linares'),
(801, 22, 'Los Andes'),
(802, 22, 'Magüí'),
(803, 22, 'Mallama'),
(804, 22, 'Mosquera'),
(805, 22, 'Nariño'),
(806, 22, 'Olaya Herrera'),
(807, 22, 'Ospina'),
(808, 22, 'Pasto'),
(809, 22, 'Policarpa'),
(810, 22, 'Potosí'),
(811, 22, 'Providencia'),
(812, 22, 'Puerres'),
(813, 22, 'Pupiales'),
(814, 22, 'Ricaurte'),
(815, 22, 'Roberto Payán'),
(816, 22, 'Samaniego'),
(817, 22, 'San Andrés de Tumaco'),
(818, 22, 'San Bernardo'),
(819, 22, 'Sandoná'),
(820, 22, 'San Lorenzo'),
(821, 22, 'San Pablo'),
(822, 22, 'San Pedro de Cartago'),
(823, 22, 'Santa Bárbara'),
(824, 22, 'Santacruz'),
(825, 22, 'Sapuyes'),
(826, 22, 'Taminango'),
(827, 22, 'Tangua'),
(828, 22, 'Túquerres'),
(829, 22, 'Yacuanquer'),
(830, 23, 'Abrego'),
(831, 23, 'Arboledas'),
(832, 23, 'Bochalema'),
(833, 23, 'Bucarasica'),
(834, 23, 'Cachirá'),
(835, 23, 'Cácota'),
(836, 23, 'Chinácota'),
(837, 23, 'Chitagá'),
(838, 23, 'Convención'),
(839, 23, 'Cúcuta'),
(840, 23, 'Cucutilla'),
(841, 23, 'Durania'),
(842, 23, 'El Carmen'),
(843, 23, 'El Tarra'),
(844, 23, 'El Zulia'),
(845, 23, 'Gramalote'),
(846, 23, 'Hacarí'),
(847, 23, 'Herrán'),
(848, 23, 'Labateca'),
(849, 23, 'La Esperanza'),
(850, 23, 'La Playa'),
(851, 23, 'Los Patios'),
(852, 23, 'Lourdes'),
(853, 23, 'Mutiscua'),
(854, 23, 'Ocaña'),
(855, 23, 'Pamplona'),
(856, 23, 'Pamplonita'),
(857, 23, 'Puerto Santander'),
(858, 23, 'Ragonvalia'),
(859, 23, 'Salazar'),
(860, 23, 'San Calixto'),
(861, 23, 'San Cayetano'),
(862, 23, 'Santiago'),
(863, 23, 'Sardinata'),
(864, 23, 'Silos'),
(865, 23, 'Teorama'),
(866, 23, 'Tibú'),
(867, 23, 'Toledo'),
(868, 23, 'Villa Caro'),
(869, 23, 'Villa del Rosario'),
(870, 24, 'Colón'),
(871, 24, 'Leguízamo'),
(872, 24, 'Mocoa'),
(873, 24, 'Orito'),
(874, 24, 'Puerto Asís'),
(875, 24, 'Puerto Caicedo'),
(876, 24, 'Puerto Guzmán'),
(877, 24, 'San Francisco'),
(878, 24, 'San Miguel'),
(879, 24, 'Santiago'),
(880, 24, 'Sibundoy'),
(881, 24, 'Valle de Guamez'),
(882, 24, 'Villagarzón'),
(883, 25, 'Armenia'),
(884, 25, 'Buenavista'),
(885, 25, 'Calarcá'),
(886, 25, 'Circasia'),
(887, 25, 'Córdoba'),
(888, 25, 'Filandia'),
(889, 25, 'Génova'),
(890, 25, 'La Tebaida'),
(891, 25, 'Montenegro'),
(892, 25, 'Pijao'),
(893, 25, 'Quimbaya'),
(894, 25, 'Salento'),
(895, 26, 'Apía'),
(896, 26, 'Balboa'),
(897, 26, 'Belén de Umbría'),
(898, 26, 'Dosquebradas'),
(899, 26, 'Guática'),
(900, 26, 'La Celia'),
(901, 26, 'La Virginia'),
(902, 26, 'Marsella'),
(903, 26, 'Mistrató'),
(904, 26, 'Pereira'),
(905, 26, 'Pueblo Rico'),
(906, 26, 'Quinchía'),
(907, 26, 'Santa Rosa de Cabal'),
(908, 26, 'Santuario'),
(909, 27, 'Providencia'),
(910, 27, 'San Andrés'),
(911, 28, 'Aguada'),
(912, 28, 'Albania'),
(913, 28, 'Aratoca'),
(914, 28, 'Barbosa'),
(915, 28, 'Barichara'),
(916, 28, 'Barrancabermeja'),
(917, 28, 'Betulia'),
(918, 28, 'Bolívar'),
(919, 28, 'Bucaramanga'),
(920, 28, 'Cabrera'),
(921, 28, 'California'),
(922, 28, 'Capitanejo'),
(923, 28, 'Carcasí'),
(924, 28, 'Cepitá'),
(925, 28, 'Cerrito'),
(926, 28, 'Charalá'),
(927, 28, 'Charta'),
(928, 28, 'Chimá'),
(929, 28, 'Chipatá'),
(930, 28, 'Cimitarra'),
(931, 28, 'Concepción'),
(932, 28, 'Confines'),
(933, 28, 'Contratación'),
(934, 28, 'Coromoro'),
(935, 28, 'Curití'),
(936, 28, 'El Carmen de Chucurí'),
(937, 28, 'El Guacamayo'),
(938, 28, 'El Peñón'),
(939, 28, 'El Playón'),
(940, 28, 'Encino'),
(941, 28, 'Enciso'),
(942, 28, 'Florián'),
(943, 28, 'Floridablanca'),
(944, 28, 'Galán'),
(945, 28, 'Gambita'),
(946, 28, 'Girón'),
(947, 28, 'Guaca'),
(948, 28, 'Guadalupe'),
(949, 28, 'Guapotá'),
(950, 28, 'Guavatá'),
(951, 28, 'Güepsa'),
(952, 28, 'Hato'),
(953, 28, 'Jesús María'),
(954, 28, 'Jordán'),
(955, 28, 'La Belleza'),
(956, 28, 'Landázuri'),
(957, 28, 'La Paz'),
(958, 28, 'Lebríja'),
(959, 28, 'Los Santos'),
(960, 28, 'Macaravita'),
(961, 28, 'Málaga'),
(962, 28, 'Matanza'),
(963, 28, 'Mogotes'),
(964, 28, 'Molagavita'),
(965, 28, 'Ocamonte'),
(966, 28, 'Oiba'),
(967, 28, 'Onzaga'),
(968, 28, 'Palmar'),
(969, 28, 'Palmas del Socorro'),
(970, 28, 'Páramo'),
(971, 28, 'Piedecuesta'),
(972, 28, 'Pinchote'),
(973, 28, 'Puente Nacional'),
(974, 28, 'Puerto Parra'),
(975, 28, 'Puerto Wilches'),
(976, 28, 'Rionegro'),
(977, 28, 'Sabana de Torres'),
(978, 28, 'San Andrés'),
(979, 28, 'San Benito'),
(980, 28, 'San Gil'),
(981, 28, 'San Joaquín'),
(982, 28, 'San José de Miranda'),
(983, 28, 'San Miguel'),
(984, 28, 'Santa Bárbara'),
(985, 28, 'Santa Helena del Opón'),
(986, 28, 'San Vicente de Chucurí'),
(987, 28, 'Simacota'),
(988, 28, 'Socorro'),
(989, 28, 'Suaita'),
(990, 28, 'Sucre'),
(991, 28, 'Suratá'),
(992, 28, 'Tona'),
(993, 28, 'Valle de San José'),
(994, 28, 'Vélez'),
(995, 28, 'Vetas'),
(996, 28, 'Villanueva'),
(997, 28, 'Zapatoca'),
(998, 29, 'Buenavista'),
(999, 29, 'Caimito'),
(1000, 29, 'Chalán'),
(1001, 29, 'Coloso'),
(1002, 29, 'Corozal'),
(1003, 29, 'Coveñas'),
(1004, 29, 'El Roble'),
(1005, 29, 'Galeras'),
(1006, 29, 'Guaranda'),
(1007, 29, 'La Unión'),
(1008, 29, 'Los Palmitos'),
(1009, 29, 'Majagual'),
(1010, 29, 'Morroa'),
(1011, 29, 'Ovejas'),
(1012, 29, 'Palmito'),
(1013, 29, 'Sampués'),
(1014, 29, 'San Benito Abad'),
(1015, 29, 'San Juan de Betulia'),
(1016, 29, 'San Luis de Sincé'),
(1017, 29, 'San Marcos'),
(1018, 29, 'San Onofre'),
(1019, 29, 'San Pedro'),
(1020, 29, 'Santiago de Tolú'),
(1021, 29, 'Sincelejo'),
(1022, 29, 'Sucre'),
(1023, 29, 'Tolú Viejo'),
(1024, 30, 'Alpujarra'),
(1025, 30, 'Alvarado'),
(1026, 30, 'Ambalema'),
(1027, 30, 'Anzoátegui'),
(1028, 30, 'Armero'),
(1029, 30, 'Ataco'),
(1030, 30, 'Cajamarca'),
(1031, 30, 'Carmen de Apicala'),
(1032, 30, 'Casabianca'),
(1033, 30, 'Chaparral'),
(1034, 30, 'Coello'),
(1035, 30, 'Coyaima'),
(1036, 30, 'Cunday'),
(1037, 30, 'Dolores'),
(1038, 30, 'Espinal'),
(1039, 30, 'Falan'),
(1040, 30, 'Flandes'),
(1041, 30, 'Fresno'),
(1042, 30, 'Guamo'),
(1043, 30, 'Herveo'),
(1044, 30, 'Honda'),
(1045, 30, 'Ibagué'),
(1046, 30, 'Icononzo'),
(1047, 30, 'Lérida'),
(1048, 30, 'Líbano'),
(1049, 30, 'Mariquita'),
(1050, 30, 'Melgar'),
(1051, 30, 'Murillo'),
(1052, 30, 'Natagaima'),
(1053, 30, 'Ortega'),
(1054, 30, 'Palocabildo'),
(1055, 30, 'Piedras'),
(1056, 30, 'Planadas'),
(1057, 30, 'Prado'),
(1058, 30, 'Purificación'),
(1059, 30, 'Rio Blanco'),
(1060, 30, 'Roncesvalles'),
(1061, 30, 'Rovira'),
(1062, 30, 'Saldaña'),
(1063, 30, 'San Antonio'),
(1064, 30, 'San Luis'),
(1065, 30, 'Santa Isabel'),
(1066, 30, 'Suárez'),
(1067, 30, 'Valle de San Juan'),
(1068, 30, 'Venadillo'),
(1069, 30, 'Villahermosa'),
(1070, 30, 'Villarrica'),
(1071, 31, 'Alcalá'),
(1072, 31, 'Andalucía'),
(1073, 31, 'Ansermanuevo'),
(1074, 31, 'Argelia'),
(1075, 31, 'Bolívar'),
(1076, 31, 'Buenaventura'),
(1077, 31, 'Bugalagrande'),
(1078, 31, 'Caicedonia'),
(1079, 31, 'Cali'),
(1080, 31, 'Calima'),
(1081, 31, 'Candelaria'),
(1082, 31, 'Cartago'),
(1083, 31, 'Dagua'),
(1084, 31, 'El Águila'),
(1085, 31, 'El Cairo'),
(1086, 31, 'El Cerrito'),
(1087, 31, 'El Dovio'),
(1088, 31, 'Florida'),
(1089, 31, 'Ginebra'),
(1090, 31, 'Guacarí'),
(1091, 31, 'Guadalajara de Buga'),
(1092, 31, 'Jamundí'),
(1093, 31, 'La Cumbre'),
(1094, 31, 'La Unión'),
(1095, 31, 'La Victoria'),
(1096, 31, 'Obando'),
(1097, 31, 'Palmira'),
(1098, 31, 'Pradera'),
(1099, 31, 'Restrepo'),
(1100, 31, 'Riofrío'),
(1101, 31, 'Roldanillo'),
(1102, 31, 'San Pedro'),
(1103, 31, 'Sevilla'),
(1104, 31, 'Toro'),
(1105, 31, 'Trujillo'),
(1106, 31, 'Tuluá'),
(1107, 31, 'Ulloa'),
(1108, 31, 'Versalles'),
(1109, 31, 'Vijes'),
(1110, 31, 'Yotoco'),
(1111, 31, 'Yumbo'),
(1112, 31, 'Zarzal'),
(1113, 32, 'Carurú'),
(1114, 32, 'Mitú'),
(1115, 32, 'Pacoa'),
(1116, 32, 'Papunahua'),
(1117, 32, 'Taraira'),
(1118, 32, 'Yavaraté'),
(1119, 33, 'Cumaribo'),
(1120, 33, 'La Primavera'),
(1121, 33, 'Puerto Carreño'),
(1122, 33, 'Santa Rosalía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidades`
--

CREATE TABLE `nacionalidades` (
  `id_nacionalidad` int(10) NOT NULL COMMENT 'Identificador único de la nacionalidad',
  `nacionalidad` varchar(50) NOT NULL COMMENT 'Nombre de la nacionalidad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nacionalidades`
--

INSERT INTO `nacionalidades` (`id_nacionalidad`, `nacionalidad`) VALUES
(1, 'No requerido'),
(2, 'Afganistán'),
(3, 'Albania'),
(4, 'Alemania'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Antigua y Barbuda'),
(8, 'Arabia Saudita'),
(9, 'Argelia'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Australia'),
(13, 'Austria'),
(14, 'Azerbaiyán'),
(15, 'Bahamas'),
(16, 'Bangladés'),
(17, 'Barbados'),
(18, 'Baréin'),
(19, 'Bélgica'),
(20, 'Belice'),
(21, 'Benín'),
(22, 'Bielorrusia'),
(23, 'Birmania'),
(24, 'Bolivia'),
(25, 'Bosnia y Herzegovina'),
(26, 'Botsuana'),
(27, 'Brasil'),
(28, 'Brunéi'),
(29, 'Bulgaria'),
(30, 'Burkina Faso'),
(31, 'Burundi'),
(32, 'Bután'),
(33, 'Cabo Verde'),
(34, 'Camboya'),
(35, 'Camerún'),
(36, 'Canadá'),
(37, 'Catar'),
(38, 'Chad'),
(39, 'Chile'),
(40, 'China'),
(41, 'Chipre'),
(42, 'Ciudad del Vaticano'),
(43, 'Colombia'),
(44, 'Comoras'),
(45, 'Corea del Norte'),
(46, 'Corea del Sur'),
(47, 'Costa de Marfil'),
(48, 'Costa Rica'),
(49, 'Croacia'),
(50, 'Cuba'),
(51, 'Dinamarca'),
(52, 'Dominica'),
(53, 'Ecuador'),
(54, 'Egipto'),
(55, 'El Salvador'),
(56, 'Emiratos Árabes Unidos'),
(57, 'Eritrea'),
(58, 'Eslovaquia'),
(59, 'Eslovenia'),
(60, 'España'),
(61, 'Estados Unidos'),
(62, 'Estonia'),
(63, 'Etiopía'),
(64, 'Filipinas'),
(65, 'Finlandia'),
(66, 'Fiyi'),
(67, 'Francia'),
(68, 'Gabón'),
(69, 'Gambia'),
(70, 'Georgia'),
(71, 'Ghana'),
(72, 'Granada'),
(73, 'Grecia'),
(74, 'Guatemala'),
(75, 'Guyana'),
(76, 'Guinea'),
(77, 'Guinea-Bisáu'),
(78, 'Guinea Ecuatorial'),
(79, 'Haití'),
(80, 'Honduras'),
(81, 'Hungría'),
(82, 'India'),
(83, 'Indonesia'),
(84, 'Irak'),
(85, 'Irán'),
(86, 'Irlanda'),
(87, 'Islandia'),
(88, 'Islas Marshall'),
(89, 'Islas Salomón'),
(90, 'Israel'),
(91, 'Italia'),
(92, 'Jamaica'),
(93, 'Japón'),
(94, 'Jordania'),
(95, 'Kazajistán'),
(96, 'Kenia'),
(97, 'Kirguistán'),
(98, 'Kiribati'),
(99, 'Kuwait'),
(100, 'Laos'),
(101, 'Lesoto'),
(102, 'Letonia'),
(103, 'Líbano'),
(104, 'Liberia'),
(105, 'Libia'),
(106, 'Liechtenstein'),
(107, 'Lituania'),
(108, 'Luxemburgo'),
(109, 'Macedonia del Norte'),
(110, 'Madagascar'),
(111, 'Malasia'),
(112, 'Malaui'),
(113, 'Maldivas'),
(114, 'Mali'),
(115, 'Malta'),
(116, 'Marruecos'),
(117, 'Mauricio'),
(118, 'Mauritania'),
(119, 'México'),
(120, 'Micronesia'),
(121, 'Moldavia'),
(122, 'Mónaco'),
(123, 'Mongolia'),
(124, 'Montenegro'),
(125, 'Mozambique'),
(126, 'Namibia'),
(127, 'Nauru'),
(128, 'Nepal'),
(129, 'Nicaragua'),
(130, 'Níger'),
(131, 'Nigeria'),
(132, 'Noruega'),
(133, 'Nueva Zelanda'),
(134, 'Omán'),
(135, 'Países Bajos'),
(136, 'Pakistán'),
(137, 'Palaos'),
(138, 'Panamá'),
(139, 'Papúa Nueva Guinea'),
(140, 'Paraguay'),
(141, 'Perú'),
(142, 'Polonia'),
(143, 'Portugal'),
(144, 'Reino Unido'),
(145, 'República Centroafricana'),
(146, 'República Checa'),
(147, 'República del Congo'),
(148, 'República Democrática del Congo'),
(149, 'República Dominicana'),
(150, 'República Sudafricana'),
(151, 'Ruanda'),
(152, 'Rumanía'),
(153, 'Rusia'),
(154, 'Samoa'),
(155, 'San Cristóbal y Nieves'),
(156, 'San Marino'),
(157, 'San Vicente y las Granadinas'),
(158, 'Santa Lucía'),
(159, 'Santo Tomé y Príncipe'),
(160, 'Senegal'),
(161, 'Serbia'),
(162, 'Seychelles'),
(163, 'Sierra Leona'),
(164, 'Singapur'),
(165, 'Siria'),
(166, 'Somalia'),
(167, 'Sri Lanka'),
(168, 'Suazilandia'),
(169, 'Sudán'),
(170, 'Sudán del Sur'),
(171, 'Suecia'),
(172, 'Suiza'),
(173, 'Surinam'),
(174, 'Tailandia'),
(175, 'Tanzania'),
(176, 'Tayikistán'),
(177, 'Timor Oriental'),
(178, 'Togo'),
(179, 'Tonga'),
(180, 'Trinidad y Tobago'),
(181, 'Túnez'),
(182, 'Turkmenistán'),
(183, 'Turquía'),
(184, 'Tuvalu'),
(185, 'Ucrania'),
(186, 'Uganda'),
(187, 'Uruguay'),
(188, 'Uzbekistán'),
(189, 'Vanuatu'),
(190, 'Venezuela'),
(191, 'Vietnam'),
(192, 'Yemen'),
(193, 'Yibuti'),
(194, 'Zambia'),
(195, 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL COMMENT 'Identificador único de la reserva',
  `id_cliente` int(10) NOT NULL COMMENT 'Identificador del cliente asociado a la reserva',
  `id_habitacion` int(10) NOT NULL COMMENT 'Identificador de la habitación reservada',
  `id_estado_reserva` int(5) NOT NULL COMMENT 'Identificador del estado de la reserva',
  `fecha_ingreso` date NOT NULL COMMENT 'Fecha de ingreso de la reserva',
  `fecha_salida` date NOT NULL COMMENT 'Fecha de salida de la reserva',
  `total_reserva` int(10) NOT NULL COMMENT 'Total de la reserva',
  `estado` tinyint(2) NOT NULL COMMENT 'Estado de habilitación (1: habilitado, 0: inhabilitado)',
  `fecha_sys` datetime NOT NULL COMMENT 'Fecha y hora de registro en el sistema'
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes_registrados`
--
ALTER TABLE `clientes_registrados`
  ADD PRIMARY KEY (`id_cliente_registrado`),
  ADD KEY `fk_id_info_cliente` (`id_info_cliente`),
  ADD KEY `fk_id_rol` (`id_rol`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `fk_nacionalidad` (`id_nacionalidad`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `id_infoUsuario` (`id_info_empleado`),
  ADD KEY `FK_Usuarios_rolUsuarios` (`id_rol`);

--
-- Indices de la tabla `estado_reservas`
--
ALTER TABLE `estado_reservas`
  ADD PRIMARY KEY (`id_estado_reserva`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id_habitacion`),
  ADD KEY `fk_tipoHabitacion` (`id_hab_tipo`),
  ADD KEY `fk_idHabEstado` (`id_hab_estado`),
  ADD KEY `fk_habitacionServicio` (`id_servicio`);

--
-- Indices de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  ADD PRIMARY KEY (`id_hab_elemento`);

--
-- Indices de la tabla `habitaciones_elementos_selec`
--
ALTER TABLE `habitaciones_elementos_selec`
  ADD PRIMARY KEY (`id_hab_tipo_elemento`),
  ADD KEY `id_habitacion_tipo` (`id_habitacion`),
  ADD KEY `id_elemento` (`id_hab_elemento`);

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
-- Indices de la tabla `habitaciones_servicios`
--
ALTER TABLE `habitaciones_servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  ADD PRIMARY KEY (`id_hab_tipo`);

--
-- Indices de la tabla `habitaciones_tipos_precios`
--
ALTER TABLE `habitaciones_tipos_precios`
  ADD PRIMARY KEY (`id_tipo_precio`),
  ADD KEY `fk_tipoServicio` (`id_tipo_servicio`);

--
-- Indices de la tabla `habitaciones_tipos_servicios`
--
ALTER TABLE `habitaciones_tipos_servicios`
  ADD PRIMARY KEY (`id_tipo_servicio`),
  ADD KEY `fk_tipoHab` (`id_hab_tipo`),
  ADD KEY `fk_tipoSer` (`id_servicio`);

--
-- Indices de la tabla `info_clientes`
--
ALTER TABLE `info_clientes`
  ADD PRIMARY KEY (`id_info_cliente`),
  ADD KEY `fk_id_nacionalidad` (`id_nacionalidad`),
  ADD KEY `fk_id_departamento` (`id_departamento`),
  ADD KEY `fk_id_municipio` (`id_municipio`);

--
-- Indices de la tabla `info_empleados`
--
ALTER TABLE `info_empleados`
  ADD PRIMARY KEY (`id_info_empleado`),
  ADD KEY `tipo_documentoFK` (`id_tipoDocumento`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municipio`),
  ADD KEY `fk_departamento` (`id_departamento`);

--
-- Indices de la tabla `nacionalidades`
--
ALTER TABLE `nacionalidades`
  ADD PRIMARY KEY (`id_nacionalidad`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_id_cliente` (`id_cliente`),
  ADD KEY `fk_id_habitacion` (`id_habitacion`),
  ADD KEY `fk_estadoReservas` (`id_estado_reserva`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes_registrados`
--
ALTER TABLE `clientes_registrados`
  MODIFY `id_cliente_registrado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del cliente registrado';

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico del departamento', AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del empleado';

--
-- AUTO_INCREMENT de la tabla `estado_reservas`
--
ALTER TABLE `estado_reservas`
  MODIFY `id_estado_reserva` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del estado de la reserva', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la habitación';

--
-- AUTO_INCREMENT de la tabla `habitaciones_elementos`
--
ALTER TABLE `habitaciones_elementos`
  MODIFY `id_hab_elemento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificado único del elemento';

--
-- AUTO_INCREMENT de la tabla `habitaciones_elementos_selec`
--
ALTER TABLE `habitaciones_elementos_selec`
  MODIFY `id_hab_tipo_elemento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del elemento asociado al tipo de habitación';

--
-- AUTO_INCREMENT de la tabla `habitaciones_estado`
--
ALTER TABLE `habitaciones_estado`
  MODIFY `id_hab_estado` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del estado de la habitación', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  MODIFY `id_hab_imagen` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la imagen';

--
-- AUTO_INCREMENT de la tabla `habitaciones_servicios`
--
ALTER TABLE `habitaciones_servicios`
  MODIFY `id_servicio` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del servicio';

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos`
--
ALTER TABLE `habitaciones_tipos`
  MODIFY `id_hab_tipo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del tipo de habitación';

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_precios`
--
ALTER TABLE `habitaciones_tipos_precios`
  MODIFY `id_tipo_precio` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del servicio asociado al tipo de habitación';

--
-- AUTO_INCREMENT de la tabla `habitaciones_tipos_servicios`
--
ALTER TABLE `habitaciones_tipos_servicios`
  MODIFY `id_tipo_servicio` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del servicio del tipo de habitación', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `info_clientes`
--
ALTER TABLE `info_clientes`
  MODIFY `id_info_cliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la información del cliente';

--
-- AUTO_INCREMENT de la tabla `info_empleados`
--
ALTER TABLE `info_empleados`
  MODIFY `id_info_empleado` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la Informacion del empleado';

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municipio` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del municipio', AUTO_INCREMENT=1123;

--
-- AUTO_INCREMENT de la tabla `nacionalidades`
--
ALTER TABLE `nacionalidades`
  MODIFY `id_nacionalidad` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la nacionalidad', AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la reserva';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes_registrados`
--
ALTER TABLE `clientes_registrados`
  ADD CONSTRAINT `fk_id_info_cliente` FOREIGN KEY (`id_info_cliente`) REFERENCES `info_clientes` (`id_info_cliente`),
  ADD CONSTRAINT `fk_id_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `fk_nacionalidad` FOREIGN KEY (`id_nacionalidad`) REFERENCES `nacionalidades` (`id_nacionalidad`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_idRol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `fk_infoUsuario` FOREIGN KEY (`id_info_empleado`) REFERENCES `info_empleados` (`id_info_empleado`);

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `fk_habitacionServicio` FOREIGN KEY (`id_servicio`) REFERENCES `habitaciones_servicios` (`id_servicio`),
  ADD CONSTRAINT `fk_idHabEstado` FOREIGN KEY (`id_hab_estado`) REFERENCES `habitaciones_estado` (`id_hab_estado`),
  ADD CONSTRAINT `fk_tipoHabitacion` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`);

--
-- Filtros para la tabla `habitaciones_elementos_selec`
--
ALTER TABLE `habitaciones_elementos_selec`
  ADD CONSTRAINT `fk_habitacion` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id_habitacion`),
  ADD CONSTRAINT `fk_tiposElementos` FOREIGN KEY (`id_hab_elemento`) REFERENCES `habitaciones_elementos` (`id_hab_elemento`);

--
-- Filtros para la tabla `habitaciones_imagenes`
--
ALTER TABLE `habitaciones_imagenes`
  ADD CONSTRAINT `fk_tipo_habitacion` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`);

--
-- Filtros para la tabla `habitaciones_tipos_precios`
--
ALTER TABLE `habitaciones_tipos_precios`
  ADD CONSTRAINT `fk_tipoServicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `habitaciones_tipos_servicios` (`id_tipo_servicio`);

--
-- Filtros para la tabla `habitaciones_tipos_servicios`
--
ALTER TABLE `habitaciones_tipos_servicios`
  ADD CONSTRAINT `fk_tipoHab` FOREIGN KEY (`id_hab_tipo`) REFERENCES `habitaciones_tipos` (`id_hab_tipo`),
  ADD CONSTRAINT `fk_tipoSer` FOREIGN KEY (`id_servicio`) REFERENCES `habitaciones_servicios` (`id_servicio`);

--
-- Filtros para la tabla `info_clientes`
--
ALTER TABLE `info_clientes`
  ADD CONSTRAINT `fk_id_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`),
  ADD CONSTRAINT `fk_id_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`),
  ADD CONSTRAINT `fk_id_nacionalidad` FOREIGN KEY (`id_nacionalidad`) REFERENCES `nacionalidades` (`id_nacionalidad`);

--
-- Filtros para la tabla `info_empleados`
--
ALTER TABLE `info_empleados`
  ADD CONSTRAINT `fk_tipoDocumento` FOREIGN KEY (`id_tipoDocumento`) REFERENCES `tipo_documento` (`id_tipoDocumento`);

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `fk_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_estadoReservas` FOREIGN KEY (`id_estado_reserva`) REFERENCES `estado_reservas` (`id_estado_reserva`),
  ADD CONSTRAINT `fk_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `info_clientes` (`id_info_cliente`),
  ADD CONSTRAINT `fk_id_habitacion` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id_habitacion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
