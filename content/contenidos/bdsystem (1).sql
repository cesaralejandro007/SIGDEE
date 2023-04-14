-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2023 a las 00:59:01
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdsystem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_emprendimiento`
--

CREATE TABLE `area_emprendimiento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `area_emprendimiento`
--

INSERT INTO `area_emprendimiento` (`id`, `nombre`) VALUES
(1, 'Servicio'),
(2, 'Producción'),
(3, 'Ejemplo'),
(4, 'Aasdasda'),
(5, 'Listo'),
(6, 'Otrsdfa'),
(9, 'ASDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante_emprendimiento`
--

CREATE TABLE `aspirante_emprendimiento` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_emprendimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aspirante_emprendimiento`
--

INSERT INTO `aspirante_emprendimiento` (`id`, `id_usuario`, `id_emprendimiento`) VALUES
(5, 49, 3),
(6, 49, 2),
(7, 78, 3),
(8, 78, 1),
(9, 78, 3),
(10, 78, 1),
(11, 46, 3),
(12, 80, 2),
(13, 80, 1),
(14, 46, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `id_emprendimiento_modulo` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id`, `nombre`, `id_emprendimiento_modulo`, `status`) VALUES
(1, 'MarkFil01', 5, 1),
(2, 'TelImag01', 27, 1),
(3, 'CocFil01', 1, 1),
(4, 'CocIma01', 2, 1),
(5, 'MarkIma01', 6, 1),
(6, 'TeleMarke001', 28, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula_docente`
--

CREATE TABLE `aula_docente` (
  `id` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `aula_docente`
--

INSERT INTO `aula_docente` (`id`, `id_aula`, `id_docente`) VALUES
(1, 1, 45),
(2, 2, 76),
(3, 3, 45),
(4, 4, 45),
(5, 5, 76),
(6, 6, 76);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula_estudiante`
--

CREATE TABLE `aula_estudiante` (
  `id` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `aula_estudiante`
--

INSERT INTO `aula_estudiante` (`id`, `id_aula`, `id_estudiante`) VALUES
(1, 1, 50),
(2, 1, 49),
(3, 2, 72),
(4, 2, 45),
(5, 3, 78),
(6, 4, 78),
(7, 5, 49),
(8, 6, 43),
(9, 6, 72),
(10, 6, 49),
(11, 6, 78),
(12, 6, 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `id_usuario_roles` int(12) NOT NULL,
  `id_entorno` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `accion` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `id_usuario_roles`, `id_entorno`, `fecha`, `accion`) VALUES
(356, 45, 9, '2023-02-28 10:42:59', 'Eliminación'),
(355, 45, 9, '2023-02-28 10:42:48', 'Registro'),
(354, 45, 9, '2023-02-28 10:38:47', 'Modificacion'),
(353, 45, 9, '2023-02-28 10:38:42', 'Registro'),
(352, 45, 9, '2023-02-28 10:38:35', 'Eliminación'),
(351, 45, 9, '2023-02-28 10:31:54', 'Registro'),
(350, 45, 9, '2023-02-28 10:26:52', 'Eliminación'),
(349, 45, 9, '2023-02-28 10:26:48', 'Eliminación'),
(348, 45, 9, '2023-02-28 10:26:43', 'Eliminación'),
(347, 45, 9, '2023-02-28 10:26:38', 'Eliminación'),
(346, 45, 9, '2023-02-28 10:25:20', 'Eliminación'),
(344, 45, 9, '2023-02-28 10:25:07', 'Eliminación'),
(345, 45, 9, '2023-02-28 10:25:12', 'Eliminación'),
(343, 45, 9, '2023-02-28 10:25:02', 'Eliminación'),
(342, 45, 9, '2023-02-28 10:24:58', 'Eliminación'),
(341, 45, 9, '2023-02-28 10:24:53', 'Eliminación'),
(340, 45, 9, '2023-02-28 10:24:48', 'Eliminación'),
(339, 45, 9, '2023-02-28 10:17:28', 'Registro'),
(338, 45, 9, '2023-02-28 10:09:17', 'Modificacion'),
(337, 45, 9, '2023-02-28 10:09:09', 'Modificacion'),
(336, 45, 9, '2023-02-28 10:09:03', 'Modificacion'),
(335, 45, 9, '2023-02-28 10:08:54', 'Modificacion'),
(334, 45, 10, '2023-02-28 09:42:36', 'Eliminación de Rol'),
(333, 45, 10, '2023-02-28 09:42:15', 'Modificacion de Rol'),
(332, 45, 10, '2023-02-28 09:41:59', 'Registro de Rol'),
(331, 45, 10, '2023-02-28 09:41:39', 'Eliminación de Rol'),
(330, 45, 10, '2023-02-28 09:41:31', 'Registro de Rol'),
(329, 45, 10, '2023-02-28 09:41:20', 'Registro de Permisos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `censo`
--

CREATE TABLE `censo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `censo`
--

INSERT INTO `censo` (`id`, `id_usuario`, `fecha_apertura`, `fecha_cierre`, `descripcion`) VALUES
(5, 45, '2023-02-07 18:40:00', '0000-00-00 00:00:00', 'sdfsdf'),
(6, 45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'asdfsadsad'),
(7, 45, '2023-02-08 12:15:00', '2023-02-23 12:15:00', 'sadsadsad'),
(8, 45, '2023-02-17 12:16:00', '2023-02-07 18:40:00', 'asdsadsad'),
(9, 45, '2023-02-07 18:40:00', '2023-02-07 18:40:00', 'fdgfdgdfg'),
(10, 45, '2023-02-07 18:40:00', '2023-02-07 18:40:00', 'asdsadsa'),
(11, 45, '2023-02-09 12:18:00', '2023-02-07 18:40:00', 'asdsadsad'),
(12, 45, '2023-02-10 12:19:00', '2023-02-07 18:40:00', 'fsdfdsfds'),
(13, 45, '2023-02-22 12:26:00', '2023-02-09 12:26:00', 'asdsadsa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `mensaje` varchar(30) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cedula_usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(2550) NOT NULL,
  `archivo_adjunto` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id`, `nombre`, `descripcion`, `archivo_adjunto`) VALUES
(1, 'Conceptos', 'Descripción de la filosofía ', 'jhg.png'),
(2, 'Ejeasd', 'Kjknakjsnd', 'Imagen3.jpg'),
(3, 'Forochat', 'Ddsadsad', 'EJERCICIO MVC CON AJAX CESAR VIDES.pdf'),
(4, 'Forochat', 'Ddsadsad', 'EJERCICIO MVC CON AJAX CESAR VIDES.pdf'),
(5, 'Forochat', 'Ddsadsad', 'EJERCICIO MVC CON AJAX CESAR VIDES.pdf'),
(6, 'Forochat', 'Ddsadsad', 'EJERCICIO MVC CON AJAX CESAR VIDES.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendimiento`
--

CREATE TABLE `emprendimiento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_area` int(11) NOT NULL,
  `estatus` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `emprendimiento`
--

INSERT INTO `emprendimiento` (`id`, `nombre`, `id_area`, `estatus`) VALUES
(1, 'Cocteleria', 2, 'true'),
(2, 'Marketing', 1, 'true'),
(3, 'Telecomunicacion', 1, 'true');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendimiento_modulo`
--

CREATE TABLE `emprendimiento_modulo` (
  `id` int(11) NOT NULL,
  `id_emprendimiento` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `emprendimiento_modulo`
--

INSERT INTO `emprendimiento_modulo` (`id`, `id_emprendimiento`, `id_modulo`) VALUES
(1, 1, 1),
(2, 1, 2),
(5, 2, 1),
(6, 2, 2),
(27, 3, 2),
(28, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entorno_sistema`
--

CREATE TABLE `entorno_sistema` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `entorno_sistema`
--

INSERT INTO `entorno_sistema` (`id`, `nombre`) VALUES
(1, 'Aula'),
(2, 'Censo'),
(3, 'Contenidos'),
(4, 'Evaluaciones'),
(5, 'Estudiantes'),
(6, 'Docentes'),
(7, 'Area de Emprendimiento'),
(8, 'Emprendimiento'),
(9, 'Modulo'),
(10, 'Permisos'),
(11, 'Entornos del Sistema'),
(12, 'Usuarios'),
(13, 'Unidad'),
(14, 'Agregar Contenido'),
(15, 'Agregar Evaluacion'),
(16, 'Chat Virtual'),
(17, 'Aspirantes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_evaluacion`
--

CREATE TABLE `estudiante_evaluacion` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_unidad_evaluacion` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `archivo_adjunto` varchar(150) NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `retroalimentacion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `estudiante_evaluacion`
--

INSERT INTO `estudiante_evaluacion` (`id`, `id_usuario`, `id_unidad_evaluacion`, `descripcion`, `archivo_adjunto`, `fecha_entrega`, `calificacion`, `retroalimentacion`) VALUES
(1, 43, 2, 'Mi ejemplo est 43', 'cualquiera', '2022-12-20 14:24:28', '13.00', NULL),
(2, 45, 2, 'Mi ejemplo est 45', 'cualquiera', '2022-12-20 14:24:28', '10.00', NULL),
(3, 49, 2, 'Mi ejemplo est 49', 'cualquiera', '2022-12-20 14:24:28', '14.00', NULL),
(4, 78, 2, 'Mi ejemplo est 78', 'cualquiera', '2022-12-20 14:24:28', '9.00', NULL),
(5, 46, 2, 'Mi ejemplo est 46', 'cualquiera', '2022-12-20 14:24:28', '20.00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `archivo_adjunto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id`, `nombre`, `descripcion`, `archivo_adjunto`) VALUES
(1, 'Evaluacion1', 'Conceptos de la filosofía', 'MER final.png'),
(2, 'Evaluacion2', 'Clases de Filosofia', 'Imagen1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id`, `nombre`) VALUES
(1, 'Filosofía de Gestión'),
(2, 'Imagen Corporativa'),
(4, 'Marketing Digital'),
(11, 'Dsadsdsadsadsd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `mensaje` varchar(100) NOT NULL,
  `id_unidad_evaluaciones` int(11) NOT NULL,
  `id_usuarios_roles` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `mensaje`, `id_unidad_evaluaciones`, `id_usuarios_roles`, `fecha`) VALUES
(23, 'Evaluación creada', 35, 45, '2023-02-28 08:17:21'),
(24, 'Evaluación creada', 36, 45, '2023-02-28 08:17:47'),
(25, 'Evaluación creada', 37, 45, '2023-02-28 08:18:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_entorno` int(11) NOT NULL,
  `registrar` varchar(5) NOT NULL,
  `modificar` varchar(5) NOT NULL,
  `eliminar` varchar(5) NOT NULL,
  `consultar` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `id_rol`, `id_entorno`, `registrar`, `modificar`, `eliminar`, `consultar`) VALUES
(162, 1, 1, 'true', 'true', 'true', 'true'),
(163, 1, 2, 'true', 'true', 'true', 'true'),
(164, 1, 3, 'true', 'true', 'true', 'true'),
(165, 1, 4, 'true', 'true', 'true', 'true'),
(166, 1, 5, 'true', 'true', 'true', 'true'),
(167, 1, 6, 'true', 'true', 'true', 'true'),
(168, 1, 8, 'true', 'true', 'true', 'true'),
(169, 1, 7, 'true', 'true', 'true', 'true'),
(170, 1, 9, 'true', 'true', 'true', 'true'),
(171, 1, 13, 'true', 'true', 'true', 'true'),
(172, 1, 14, 'true', 'null', 'null', 'true'),
(173, 1, 15, 'true', 'null', 'null', 'true'),
(174, 1, 16, 'null', 'null', 'null', 'null'),
(175, 1, 17, 'null', 'null', 'null', 'null'),
(177, 2, 2, 'true', 'true', 'true', 'true'),
(178, 2, 16, 'null', 'null', 'null', 'null'),
(197, 5, 2, 'true', 'true', 'true', 'true'),
(198, 7, 15, 'true', 'null', 'null', 'true'),
(199, 7, 16, 'null', 'null', 'null', 'null'),
(200, 7, 13, 'true', 'true', 'true', 'true'),
(201, 7, 14, 'true', 'null', 'null', 'true'),
(202, 5, 1, 'true', 'true', 'true', 'false'),
(203, 5, 3, 'true', 'false', 'false', 'false');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `mensaje` varchar(300) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cedula_usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id`, `titulo`, `mensaje`, `id_aula`, `fecha`, `cedula_usuario`) VALUES
(2, 'Ddsadsad', 'DSdsadsadsad', 2, '2023-02-28 01:27:53', 'V-28055655'),
(5, 'Dsdasds', 'asdsadsa', 1, '2023-02-28 23:24:50', 'V-28055655');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'Super Usuario'),
(2, 'Administrador'),
(5, 'Docente'),
(7, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `id_aula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `nombre`, `descripcion`, `id_aula`) VALUES
(1, 'Conociendo la filosofía ', 'Conociendo y aprendiendo de la filosofía', 3),
(2, 'Ejemplo', 'Ejemplo de crear evaluacion para el reporte estadistico', 6),
(11, 'Ddsadsadsdfsaf', 'sadsad', 1),
(12, 'Ccxcxzcxz', 'cxzcxzc', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_contenido`
--

CREATE TABLE `unidad_contenido` (
  `id` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `unidad_contenido`
--

INSERT INTO `unidad_contenido` (`id`, `id_unidad`, `id_contenido`) VALUES
(3, 1, 1),
(21, 11, 1),
(22, 11, 2),
(23, 11, 3),
(24, 12, 1),
(25, 12, 2),
(26, 12, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_evaluaciones`
--

CREATE TABLE `unidad_evaluaciones` (
  `id` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_evaluacion` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `unidad_evaluaciones`
--

INSERT INTO `unidad_evaluaciones` (`id`, `id_unidad`, `id_evaluacion`, `fecha_inicio`, `fecha_cierre`) VALUES
(2, 2, 2, '2022-12-20 09:20:00', '2022-12-26 13:14:00'),
(13, 11, 2, '2023-02-07 18:40:00', '2023-02-07 18:40:00'),
(14, 11, 2, '2023-02-07 18:40:00', '2023-02-07 18:40:00'),
(35, 11, 2, '2023-02-07 18:40:00', '2023-02-07 18:40:00'),
(36, 11, 1, '2023-02-07 18:40:00', '2023-02-07 18:40:00'),
(37, 12, 1, '2023-02-07 18:40:00', '2023-02-07 18:40:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `imagen` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `cedula`, `nombre`, `apellido`, `correo`, `direccion`, `telefono`, `clave`, `imagen`) VALUES
(43, 'V-23811323', 'Marcosasdsa', 'Alvaresdasdsa', 'marcos@gmail.com', 'asdsadsa', '43543543543', '123456', ''),
(45, 'V-28055655', 'Cesar', 'Vides', 'jbrcesasdsadarvides@gmail.com', 'Tamaca', '32432423432', '123456', NULL),
(46, 'V-26197135', 'Maria', 'Diaz', 'mjcazorla@gmail.com', 'Florencio Jimenez', '04120223541', '123456', NULL),
(49, 'V-28204985', 'Luis', 'Quevedo', 'luis@gmail.com', 'Barrio Union', '04122254785', '123456', NULL),
(50, 'V-18811323', 'Juanse', 'Salazar', 'juan@gmail.com', 'Barrio Union', '04120230948', '123456', NULL),
(72, 'V-28055653', 'Cesar', 'Vides', 'jbrcesarvides@gmail.com', 'Urbanzacion yucatan', '04120230948', '123456', NULL),
(76, 'V-43322331', 'Juanse', 'Salazar', 'jfdsfdsfuan@gmail.com', 'Urbanizacion yucatan', '04120244444', '123123', NULL),
(78, 'V-21213123', 'Angelica', 'Vale', 'angelica@gmail.com', NULL, NULL, NULL, NULL),
(80, 'V-12312312', 'Josue', 'Duran', 'josue@gmail.com', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_roles`
--

CREATE TABLE `usuarios_roles` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_roles`
--

INSERT INTO `usuarios_roles` (`id`, `id_usuario`, `id_rol`) VALUES
(42, 43, 1),
(44, 76, 5),
(45, 45, 1),
(48, 78, 7),
(53, 78, 7),
(63, 45, 2),
(65, 72, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area_emprendimiento`
--
ALTER TABLE `area_emprendimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `aspirante_emprendimiento`
--
ALTER TABLE `aspirante_emprendimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_emprendimiento` (`id_emprendimiento`);

--
-- Indices de la tabla `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_tipo_modulo` (`id_emprendimiento_modulo`);

--
-- Indices de la tabla `aula_docente`
--
ALTER TABLE `aula_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aula` (`id_aula`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `aula_estudiante`
--
ALTER TABLE `aula_estudiante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aula` (`id_aula`),
  ADD KEY `id_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_entorno` (`id_entorno`),
  ADD KEY `id_usuario_roles` (`id_usuario_roles`);

--
-- Indices de la tabla `censo`
--
ALTER TABLE `censo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_modulo` (`id_modulo`),
  ADD KEY `id_emprendimeinto` (`id_emprendimiento`) USING BTREE;

--
-- Indices de la tabla `entorno_sistema`
--
ALTER TABLE `entorno_sistema`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_unidad_evaluacion` (`id_unidad_evaluacion`);

--
-- Indices de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_unidad_evaluaciones` (`id_unidad_evaluaciones`),
  ADD KEY `id_usuarios_roles` (`id_usuarios_roles`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_entorno` (`id_entorno`) USING BTREE;

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aula` (`id_aula`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aula` (`id_aula`);

--
-- Indices de la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_contenido` (`id_contenido`),
  ADD KEY `id_unidad` (`id_unidad`);

--
-- Indices de la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evaluacion` (`id_evaluacion`),
  ADD KEY `id_unidad` (`id_unidad`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD KEY `correo` (`correo`);

--
-- Indices de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area_emprendimiento`
--
ALTER TABLE `area_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `aspirante_emprendimiento`
--
ALTER TABLE `aspirante_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `aula_docente`
--
ALTER TABLE `aula_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `aula_estudiante`
--
ALTER TABLE `aula_estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT de la tabla `censo`
--
ALTER TABLE `censo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `entorno_sistema`
--
ALTER TABLE `entorno_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aspirante_emprendimiento`
--
ALTER TABLE `aspirante_emprendimiento`
  ADD CONSTRAINT `aspirante_emprendimiento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `aspirante_emprendimiento_ibfk_2` FOREIGN KEY (`id_emprendimiento`) REFERENCES `emprendimiento` (`id`);

--
-- Filtros para la tabla `aula`
--
ALTER TABLE `aula`
  ADD CONSTRAINT `aula_ibfk_6` FOREIGN KEY (`id_emprendimiento_modulo`) REFERENCES `emprendimiento_modulo` (`id`);

--
-- Filtros para la tabla `aula_docente`
--
ALTER TABLE `aula_docente`
  ADD CONSTRAINT `aula_docente_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`),
  ADD CONSTRAINT `aula_docente_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `aula_estudiante`
--
ALTER TABLE `aula_estudiante`
  ADD CONSTRAINT `aula_estudiante_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`),
  ADD CONSTRAINT `aula_estudiante_ibfk_2` FOREIGN KEY (`id_estudiante`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `censo`
--
ALTER TABLE `censo`
  ADD CONSTRAINT `censo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  ADD CONSTRAINT `emprendimiento_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area_emprendimiento` (`id`);

--
-- Filtros para la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  ADD CONSTRAINT `emprendimiento_modulo_ibfk_3` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id`),
  ADD CONSTRAINT `emprendimiento_modulo_ibfk_4` FOREIGN KEY (`id_emprendimiento`) REFERENCES `emprendimiento` (`id`);

--
-- Filtros para la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  ADD CONSTRAINT `estudiante_evaluacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `estudiante_evaluacion_ibfk_2` FOREIGN KEY (`id_unidad_evaluacion`) REFERENCES `unidad_evaluaciones` (`id`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_unidad_evaluaciones`) REFERENCES `unidad_evaluaciones` (`id`),
  ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_usuarios_roles`) REFERENCES `usuarios_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `permiso_ibfk_4` FOREIGN KEY (`id_entorno`) REFERENCES `entorno_sistema` (`id`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`);

--
-- Filtros para la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD CONSTRAINT `unidad_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`);

--
-- Filtros para la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  ADD CONSTRAINT `unidad_contenido_ibfk_1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `unidad_contenido_ibfk_2` FOREIGN KEY (`id_contenido`) REFERENCES `contenido` (`id`);

--
-- Filtros para la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  ADD CONSTRAINT `unidad_evaluaciones_ibfk_1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id`),
  ADD CONSTRAINT `unidad_evaluaciones_ibfk_2` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluaciones` (`id`);

--
-- Filtros para la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD CONSTRAINT `usuarios_roles_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `usuarios_roles_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
