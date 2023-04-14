-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2023 a las 15:12:47
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
(77, 'Servicio');

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
(34, 153, 31),
(35, 155, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `id_emprendimiento_modulo` int(11) NOT NULL,
  `estatus` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`id`, `nombre`, `id_emprendimiento_modulo`, `estatus`) VALUES
(24, 'Funeraria', 39, 'true');

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
(43, 24, 154);

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
(62, 24, 153);

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
(1199, 1, 5, '2023-03-17 01:50:08', 'Registro'),
(1200, 1, 6, '2023-03-17 01:51:03', 'Registro'),
(1201, 1, 7, '2023-03-17 02:49:13', 'Registro'),
(1202, 1, 8, '2023-03-17 02:49:41', 'Registro'),
(1203, 1, 2, '2023-03-17 02:50:23', 'Registro'),
(1204, 1, 6, '2023-03-17 02:52:08', 'Registro'),
(1205, 1, 9, '2023-03-17 02:52:26', 'Registro'),
(1206, 1, 1, '2023-03-17 03:01:56', 'Registro'),
(1207, 1, 13, '2023-03-17 03:02:24', 'Registro'),
(1208, 1, 4, '2023-03-17 03:03:08', 'Registro'),
(1209, 1, 15, '2023-03-17 03:03:32', 'Agregar Evaluacion'),
(1210, 1, 10, '2023-03-17 03:04:46', 'Registro de Permisos'),
(1211, 1, 10, '2023-03-17 03:04:47', 'Registro de Permisos'),
(1212, 1, 10, '2023-03-17 03:04:47', 'Registro de Permisos'),
(1213, 1, 10, '2023-03-17 03:04:48', 'Registro de Permisos');

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
(32423448, 1, '2023-03-16 09:50:00', '2023-03-29 09:50:00', 'Nuevo Censo');

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
(31, 'Funeraria', 77, 'true');

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
(39, 31, 26);

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

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id`, `nombre`, `descripcion`, `archivo_adjunto`) VALUES
(20, 'Nueva evaluacion', 'Conociendo el modulo', 'INTEGRACION.docx');

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
(26, 'Imagen Corporativa');

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

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `mensaje`, `id_unidad_evaluaciones`, `id_usuarios_roles`, `fecha`) VALUES
(59, 'Evaluación creada', 4980, 1, '2023-03-17 10:03:32');

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
(169, 1, 7, 'true', 'true', 'true', 'true'),
(170, 1, 9, 'true', 'true', 'true', 'true'),
(171, 1, 13, 'true', 'true', 'true', 'true'),
(172, 1, 14, 'true', 'null', 'null', 'true'),
(173, 1, 15, 'true', 'null', 'null', 'true'),
(174, 1, 16, 'null', 'null', 'null', 'null'),
(175, 1, 17, 'null', 'null', 'null', 'null'),
(226, 7, 13, 'false', 'false', 'false', 'true'),
(227, 7, 14, 'false', 'null', 'null', 'true'),
(228, 7, 15, 'false', 'null', 'null', 'true'),
(229, 7, 16, 'null', 'null', 'null', 'null');

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

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `nombre`, `descripcion`, `id_aula`) VALUES
(17, 'Ejemplo ', 'La unidad nueva', 24);

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

--
-- Volcado de datos para la tabla `unidad_evaluaciones`
--

INSERT INTO `unidad_evaluaciones` (`id`, `id_unidad`, `id_evaluacion`, `fecha_inicio`, `fecha_cierre`) VALUES
(4980, 17, 20, '2023-03-16 10:03:00', '2023-03-22 10:03:00');

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
  `clave` varchar(50) NOT NULL DEFAULT 'd9aj2Z/Qkciin2OfYw==',
  `imagen` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `cedula`, `nombre`, `apellido`, `correo`, `direccion`, `telefono`, `clave`, `imagen`) VALUES
(1, '28055655', 'Alejandro', 'Vides', 'jbrcesarvides2018@gmail.com', 'Yucatan', '04120318406', 'ZJ9moWWZZ5xs', NULL),
(153, '26197135', 'Maria', 'Diaz', 'mjcazorla@gmail.com', NULL, NULL, 'ZJ9moWWZZ5xs', NULL),
(154, '10479729', 'Jose', 'Diaz', 'jose@gmail.com', 'Av las industrias', '04263542479', 'd9aj2Z/Qkciin2OfYw==', NULL),
(155, '9528304', 'Reina', 'Cazorla', 'reina@gmail.com', NULL, NULL, 'd9aj2Z/Qkciin2OfYw==', NULL);

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
(203, 1, 5),
(204, 154, 5),
(205, 153, 7);

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
-- Indices de la tabla `chat_virtual`
--
ALTER TABLE `chat_virtual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cedula` (`cedula_usuario`) USING BTREE;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `aspirante_emprendimiento`
--
ALTER TABLE `aspirante_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `aula_docente`
--
ALTER TABLE `aula_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `aula_estudiante`
--
ALTER TABLE `aula_estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1214;

--
-- AUTO_INCREMENT de la tabla `censo`
--
ALTER TABLE `censo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32423449;

--
-- AUTO_INCREMENT de la tabla `chat_virtual`
--
ALTER TABLE `chat_virtual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `entorno_sistema`
--
ALTER TABLE `entorno_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4981;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

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
-- Filtros para la tabla `chat_virtual`
--
ALTER TABLE `chat_virtual`
  ADD CONSTRAINT `chat_virtual_ibfk_1` FOREIGN KEY (`cedula_usuario`) REFERENCES `usuario` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_usuarios_roles`) REFERENCES `usuarios_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notificaciones_ibfk_3` FOREIGN KEY (`id_unidad_evaluaciones`) REFERENCES `unidad_evaluaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
