-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2023 a las 05:26:49
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `area_emprendimiento`
--

INSERT INTO `area_emprendimiento` (`id`, `nombre`) VALUES
(1, 'Servicios'),
(2, 'Comercialización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante_emprendimiento`
--

CREATE TABLE `aspirante_emprendimiento` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_emprendimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `aspirante_emprendimiento`
--

INSERT INTO `aspirante_emprendimiento` (`id`, `id_usuario`, `id_emprendimiento`) VALUES
(1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `id_emprendimiento_modulo` int(11) NOT NULL,
  `estatus` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id`, `nombre`, `id_emprendimiento_modulo`, `estatus`) VALUES
(1, 'Filosofia', 1, 'true'),
(2, 'Marketing', 3, 'true');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula_docente`
--

CREATE TABLE `aula_docente` (
  `id` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aula_docente`
--

INSERT INTO `aula_docente` (`id`, `id_aula`, `id_docente`) VALUES
(1, 1, 2),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula_estudiante`
--

CREATE TABLE `aula_estudiante` (
  `id` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aula_estudiante`
--

INSERT INTO `aula_estudiante` (`id`, `id_aula`, `id_estudiante`) VALUES
(1, 1, 3),
(2, 2, 3),
(3, 1, 2);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `id_usuario_roles`, `id_entorno`, `fecha`, `accion`) VALUES
(1, 285, 6, '2023-08-02 06:33:01', 'Registro'),
(2, 285, 7, '2023-08-02 06:35:31', 'Registro'),
(3, 285, 8, '2023-08-02 06:39:29', 'Registro'),
(4, 285, 9, '2023-08-02 06:41:15', 'Modificacion'),
(5, 285, 5, '2023-08-02 06:44:12', 'Registro'),
(6, 285, 1, '2023-08-02 06:44:42', 'Registro'),
(7, 1, 7, '2023-08-04 12:43:14', 'Registro'),
(8, 1, 8, '2023-08-04 12:43:48', 'Registro'),
(9, 1, 1, '2023-08-03 09:43:12', 'Registro'),
(10, 1, 10, '2023-08-06 09:06:21', 'Respaldo de BD'),
(11, 1, 10, '2023-08-06 09:06:34', 'Respaldo de BD'),
(12, 1, 12, '2023-08-06 09:09:46', 'Registro'),
(13, 1, 12, '2023-08-21 02:26:37', 'Modificacion'),
(14, 1, 17, '2023-08-21 03:08:14', 'Eliminación'),
(15, 1, 3, '2023-08-24 04:06:46', 'Registro');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `censo`
--

INSERT INTO `censo` (`id`, `id_usuario`, `fecha_apertura`, `fecha_cierre`, `descripcion`) VALUES
(32423451, 1, '2023-07-30 23:36:00', '2023-08-31 23:36:00', 'Censo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_virtual`
--

CREATE TABLE `chat_virtual` (
  `id` int(11) NOT NULL,
  `cedula_usuario` varchar(10) CHARACTER SET latin1 NOT NULL,
  `mensajes` varchar(200) NOT NULL,
  `facha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `id_estado`, `nombre`) VALUES
(574445, 1854, 'Barquisimeto'),
(575162, 1854, 'Cabudare'),
(577641, 1854, 'Duaca'),
(584419, 1856, 'La Palmita');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(2550) NOT NULL,
  `archivo_adjunto` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id`, `nombre`, `descripcion`, `archivo_adjunto`) VALUES
(1, 'Ejemplo', 'Para saber', 'Cesar.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendimiento`
--

CREATE TABLE `emprendimiento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_area` int(11) NOT NULL,
  `estatus` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emprendimiento`
--

INSERT INTO `emprendimiento` (`id`, `nombre`, `id_area`, `estatus`) VALUES
(1, 'Batender', 1, 'true'),
(2, 'Asesorias', 1, 'true');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendimiento_modulo`
--

CREATE TABLE `emprendimiento_modulo` (
  `id` int(11) NOT NULL,
  `id_emprendimiento` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emprendimiento_modulo`
--

INSERT INTO `emprendimiento_modulo` (`id`, `id_emprendimiento`, `id_modulo`) VALUES
(1, 1, 16),
(2, 1, 28),
(3, 2, 16),
(4, 2, 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entorno_sistema`
--

CREATE TABLE `entorno_sistema` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `id_pais`, `nombre`) VALUES
(1852, 95, 'Falcón'),
(1854, 95, 'Lara '),
(1856, 95, 'Miranda');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `archivo_adjunto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id`, `nombre`) VALUES
(16, 'Filosofía de gestión'),
(28, 'Marketing');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nombre`) VALUES
(95, 'Venezuela ');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(170, 1, 9, 'true', 'true', 'true', 'true'),
(172, 1, 14, 'true', 'null', 'null', 'true'),
(173, 1, 15, 'true', 'true', 'true', 'true'),
(174, 1, 16, 'null', 'null', 'null', 'null'),
(175, 1, 17, 'null', 'true', 'true', 'true'),
(228, 7, 15, 'true', 'true', 'true', 'true'),
(229, 7, 16, 'null', 'null', 'null', 'null'),
(232, 5, 3, 'true', 'true', 'true', 'true'),
(235, 5, 5, 'true', 'true', 'true', 'true'),
(237, 5, 13, 'true', 'true', 'true', 'true'),
(238, 5, 9, 'true', 'true', 'true', 'true'),
(239, 5, 4, 'true', 'true', 'true', 'true'),
(240, 5, 7, 'true', 'true', 'true', 'true'),
(242, 5, 8, 'true', 'true', 'true', 'true'),
(243, 5, 6, 'true', 'true', 'true', 'true'),
(244, 5, 14, 'true', 'null', 'null', 'true'),
(245, 5, 15, 'true', 'true', 'true', 'true'),
(246, 5, 16, 'null', 'null', 'null', 'null'),
(250, 1, 13, 'true', 'true', 'true', 'true'),
(251, 1, 7, 'true', 'true', 'true', 'true'),
(253, 2, 1, 'true', 'true', 'true', 'true'),
(254, 2, 2, 'true', 'true', 'true', 'true'),
(255, 2, 3, 'true', 'true', 'true', 'true'),
(256, 2, 4, 'true', 'true', 'true', 'true'),
(257, 2, 5, 'true', 'true', 'true', 'true'),
(258, 2, 6, 'true', 'true', 'true', 'true'),
(259, 2, 7, 'true', 'true', 'true', 'true'),
(261, 2, 8, 'true', 'true', 'true', 'true'),
(262, 2, 9, 'true', 'true', 'true', 'true'),
(263, 2, 13, 'true', 'true', 'true', 'true'),
(264, 2, 14, 'true', 'null', 'null', 'true'),
(265, 2, 15, 'true', 'true', 'true', 'true'),
(266, 2, 16, 'null', 'null', 'null', 'null'),
(267, 2, 17, 'null', 'true', 'true', 'true'),
(268, 5, 17, 'null', 'true', 'true', 'true'),
(280, 7, 14, 'false', 'null', 'null', 'true'),
(281, 5, 1, 'true', 'true', 'true', 'true'),
(282, 5, 2, 'true', 'true', 'true', 'true');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`id`, `titulo`, `mensaje`, `id_aula`, `fecha`, `cedula_usuario`) VALUES
(1, 'Este es un saludo', 'Solo es prueba', 1, '2023-08-25 19:37:56', '%??3XM??!???|??;.'),
(2, 'Ejemplo', 'Una prueba', 1, '2023-08-27 05:11:24', '28055655');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_contenido`
--

CREATE TABLE `unidad_contenido` (
  `id` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `primer_nombre` varchar(50) NOT NULL,
  `segundo_nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `token` text DEFAULT NULL,
  `fecha_expiracion` datetime DEFAULT NULL,
  `preguntas_seguridad` text DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `clave` varchar(300) DEFAULT 'd9aj2Z/Qkciin2OfYw==',
  `publickey` text DEFAULT NULL,
  `privatekey` text DEFAULT NULL,
  `imagen` varchar(30) DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `id_ciudad`, `cedula`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `genero`, `correo`, `token`, `fecha_expiracion`, `preguntas_seguridad`, `direccion`, `telefono`, `clave`, `publickey`, `privatekey`, `imagen`, `ultimo_acceso`) VALUES
(1, 574445, '28055655', 'Cesar', 'Alejandro', 'Vides', 'Gonzalez', 'Masculino', 'cesaralejandrovides2@gmail.com', 'd161c34381f5ecdb07b95439b107d6d11cddf8d4f6fbe34670718882666470c1', '2023-08-27 00:12:47', 'VkZaRk9WQlRUazVhZWpBNVNUQXhNMUJVTUdwVVZrVTVVRk5PVGxwNk1EbEpNREV6VUZRd2FsUldSVGxRVTA1T1dub3dPVWt3TVROUVZEQnE=', 'Yucatan', '04120318406', '$2y$10$e/Sx0Roa.v4LANdMQQkKX.GTJShz28HU0K8V.Ak/wCkfJPb.hxmrW', 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUF6TmdKK1hHYVhRRnpQd2JnWldsbQpqdnU2bXdBODBSeVNZN1JoUHowcmF2dDRMTjRyTzMzOHZnTTdwUU92RTFXYjc5aVZUWDN3NGplRnA3ZUZTR2pVClF5MjRyQnRrdGxvSjlXTXJzQmJqa3pIeWdPWCtDMndNLzU2N2pDWUdzRVhFSWszaWkvTXpqbG12alM1d21lZk8KZTcyZGdKZFNjdGJIV1U0QjI2Y2VEeGtEL0YzRzdoK3VqdmhQV0lpam1aZXptb3F3MFhLQmZzczN3cjdMK2dnMApabGZuTFdKaGJKMjllcXQweDdQeTgrNXdJM0s5WTU4d3RLWi85NTA5RVpzNFdnSzdxbkVUU1BHeUZ5Vkg2bkhZCmxTWm1JOWF0YTF2dzUxcHhsUzlXWGZGaUZQVm04V25vZDlLTXhqRXdMZVhtYUhjN0JYemtnOXM2U1c3Z1lTeUIKK3dJREFRQUIKLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0tCg==', 'LS0tLS1CRUdJTiBQUklWQVRFIEtFWS0tLS0tCk1JSUV2Z0lCQURBTkJna3Foa2lHOXcwQkFRRUZBQVNDQktnd2dnU2tBZ0VBQW9JQkFRRE0yQW41Y1pwZEFYTS8KQnVCbGFXYU8rN3FiQUR6UkhKSmp0R0UvUFN0cSszZ3MzaXM3ZmZ5K0F6dWxBNjhUVlp2djJKVk5mZkRpTjRXbgp0NFZJYU5SRExiaXNHMlMyV2duMVl5dXdGdU9UTWZLQTVmNExiQXovbnJ1TUpnYXdSY1FpVGVLTDh6T09XYStOCkxuQ1o1ODU3dloyQWwxSnkxc2RaVGdIYnB4NFBHUVA4WGNidUg2Nk8rRTlZaUtPWmw3T2FpckRSY29GK3l6ZkMKdnN2NkNEUm1WK2N0WW1Gc25iMTZxM1RIcy9MejduQWpjcjFqbnpDMHBuLzNuVDBSbXpoYUFydXFjUk5JOGJJWApKVWZxY2RpVkptWWoxcTFyVy9EblduR1ZMMVpkOFdJVTlXYnhhZWgzMG96R01UQXQ1ZVpvZHpzRmZPU0QyenBKCmJ1QmhMSUg3QWdNQkFBRUNnZ0VCQUtzWEhtMmJ0d1JMZThoK285blFDUHNQd2JKSXBvTTV6QU0rMjZLSUlzVisKTjhleDRJWVdHbzFTQWZVM2VIazduYnpjTndlOFV2OSt4RUZyQlFXUG1RcHJHNzJVTzdBYTBBcUd4Q3lWVVlyVgp3dWhxTUorMXBiMnpCSTV3REZJYVUxRWJvRWFuNEwzYXBzZlNxL1hBS1RRdEVXb2YrWnMxVE5lSVVnRDJPaUw4Cmo3d2ZVUzZnQmpCRTFIa3BuQmNha0U0THBIcTh0RkxXTDdYd1pGeGF5ajdmRDBXd3pPYTVVVW5rNFBIOTNlS0wKaTBaT1JWQmZyMmtDbnRxd01FK1dHb0tDeHN3NENaL3VqaytZa2lNQ2tFWmhncS96U08vQkkvSlhNQVZRbEh5LwpROXM3VzAxL3hkZGtiRVQ1Tkt4ODdGYkg2TndSdVhJUkdFZ2pOOVdueTdFQ2dZRUErc2xIK1VXc09ZTU9CdmIwCmVsZkNUUGlTbzdaRFZzTXpGcS9Mb2o5cjlUemRabXU4dmdBa0orVG96eHM5UFk5MU43M0VQU3N5KzN4UXNldjcKYXFxZFJZMm5vSVM2RldjampGNzVJaytVVkhPZit0MmtmZm9KTm1jZTFqTU5Od2Ryc1g2OVlaYy9yVW1MYUxORgpvcTBRUDl2bStydURvRER0Q2tnbnVaUWM5aFVDZ1lFQTBSby9EbUt4K1NNc1JPNEJNenZ5ZE1OaFk3Z2RQWWtvCk1RZmY2V3RMblkrRlRrVnk3ZkpMNjNTR3F1ckJWU0hVMlhlOGZ1WUZqOXp1WWRoOXAvQVR2ZktBM3JWd1pvVisKUm9EVkJ6eFF1blk5K0ZScDZRT2g3OFc1b3VhOHRnbXFHY2p5aFZNbmNBRTE5YmhWSHFMS1NwaEJIdlpHUnhwYgpaaXFNYnlXOEs4OENnWUVBeVhya1pCUGhwZUx3WmhBSm9qRFhYVmRuR0RmYUtkNXhNUXpUSU9xckpUOWM4R2dtCkhzK21QSmJmbzJSUzh4NUtJaHBIaW8wbVRIMDNwM25iWjNyakYzb1M3aGMwR1BYZnpXcVA1VXpoOG1kaVkvMmwKcGNBM25vbUNjTHhiSlpiRW9ya2NGVWVhVlBIOUdvVE1zVUV4Q056MjJRSEZZZkZzdnhIeE9Gc1NXWEVDZ1lBaQpNTVIydWJTWUpDUXM4UzNKRHRoS04xaEpVZVdXRmtNNElTMS9vVWV2NzdQQVpLS3lQWmdrVzkxWlBTRjNwaHlECm9veHp3M0ROWVRhcFVSamF5T3F4ZUdHU0NPRGtJcGZQTjJtZDBVTHgranVQeTEyMStCNFdjcUl6L0w2R2xYWDIKMldDdVpEWmluaEFRcVo5aGJ3VGN4YUNBUzR5YU83a09MNDdlN2JDakNRS0JnSHVRUEZQQzlTR2JaSzI2NzA0UQozWTdsYUVjZUlVcEp0MGZlUnR4ZC9DOXJNcVRyT2dZR1c3dnh3SXlMTnNRTlB4VkJVZWtGTHNyTTkralg3aTd3Cm84RXlNVUV4YWhHekIzRlRyWXdDQmNHRGxiVG05M0gxRFpXZk05MTJNNXVWWU1sdjdEanBoU2g3WEFDUm1HQ2EKNUMyMmc0V2lwOWRoaFVremZXQWFyckZVCi0tLS0tRU5EIFBSSVZBVEUgS0VZLS0tLS0K', NULL, '2023-08-26 23:12:47'),
(2, 575162, '26197135', 'Maria', 'Jose', 'Diaz', 'Cazorla', 'Femenino', 'mjcazorla@gmail.com', 'f64205d009005d141f9f5b1e4e100189c34b5cbc700a8f3c359f929d0ca44a3c', '2023-08-13 01:11:29', NULL, 'Av Antonio benitez', '04245044351', '123456', NULL, NULL, NULL, '2023-08-13 00:11:29'),
(3, 574445, '23811323', 'Mary', 'Paz', 'Guedez', 'Paz', 'Femenino', 'mary@gmail.com', 'b9eb1135dfbffe2d42562833fefff93b469dc2a70cf874084bf803c730b79042', '2023-08-03 19:29:00', NULL, 'una nueva direccion', '04123123123', '$2y$10$Q.M0FNRVVJwVF/8IUbZ0cODvmJuUWkMCSYAnLt37m7mcyVtTEEopS', NULL, NULL, NULL, NULL),
(4, 574445, '9528304', 'Danny', 'Jose', 'Martinez', 'Martinez', 'Masculino', 'danny@gmail.com', 'cc3b8be31a1946ccca6b8824a79198662224e591632e330ce3fedce45e4bf5a4', '2023-08-06 16:11:19', NULL, 'En la nueva', '04122313423', '$2y$10$YBBjU47zHib4AuPoapp1NOvSA.K3kXn8Yde56BpEEcIRy1lC9UAs6', NULL, NULL, NULL, '2023-08-06 15:11:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_roles`
--

CREATE TABLE `usuarios_roles` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios_roles`
--

INSERT INTO `usuarios_roles` (`id`, `id_usuario`, `id_rol`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 7),
(4, 2, 5),
(5, 3, 7),
(6, 4, 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_area_emprendimiento`
-- (Véase abajo para la vista actual)
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuario`
-- (Véase abajo para la vista actual)
--

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_area_emprendimiento`
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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `censo`
--
ALTER TABLE `censo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat_virtual`
--
ALTER TABLE `chat_virtual`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entorno_sistema`
--
ALTER TABLE `entorno_sistema`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pais` (`id_pais`);

--
-- Indices de la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ciudad` (`id_ciudad`);

--
-- Indices de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area_emprendimiento`
--
ALTER TABLE `area_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `aspirante_emprendimiento`
--
ALTER TABLE `aspirante_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `aula_docente`
--
ALTER TABLE `aula_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `aula_estudiante`
--
ALTER TABLE `aula_estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `censo`
--
ALTER TABLE `censo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32423452;

--
-- AUTO_INCREMENT de la tabla `chat_virtual`
--
ALTER TABLE `chat_virtual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `entorno_sistema`
--
ALTER TABLE `entorno_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
