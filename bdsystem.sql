-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2023 a las 02:35:56
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
(77, 'Servicio'),
(86, 'Ejemplo'),
(87, 'Otro Mas'),
(88, 'Nuevo');

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
(72, 1, 32),
(76, 174, 32),
(77, 174, 33);

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
(24, 'Funeraria', 43, 'true'),
(39, 'Nueva Aula', 64, 'true');

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
(44, 24, 176),
(45, 39, 176);

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
(65, 39, 174),
(71, 24, 174);

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
(1213, 1, 10, '2023-03-17 03:04:48', 'Registro de Permisos'),
(1214, 1, 2, '2023-04-16 03:11:43', 'EliminaciÃ³n'),
(1215, 1, 2, '2023-04-16 03:12:11', 'Registro'),
(1216, 1, 2, '2023-04-16 03:12:30', 'Modificacion'),
(1217, 1, 3, '2023-04-16 03:46:07', 'Registro'),
(1218, 1, 3, '2023-04-16 03:56:00', 'EliminaciÃ³n'),
(1219, 1, 3, '2023-04-16 03:56:11', 'Registro'),
(1220, 1, 3, '2023-04-16 03:56:18', 'Modificacion'),
(1221, 1, 5, '2023-04-16 04:46:53', 'Modificacion'),
(1222, 1, 5, '2023-04-16 04:46:58', 'EliminaciÃ³n'),
(1223, 1, 5, '2023-04-16 04:47:08', 'Registro'),
(1224, 1, 4, '2023-04-16 04:50:43', 'Modificacion'),
(1225, 1, 4, '2023-04-16 04:50:50', 'Modificacion'),
(1226, 1, 4, '2023-04-16 04:51:03', 'Registro'),
(1227, 1, 4, '2023-04-16 04:51:07', 'EliminaciÃ³n'),
(1228, 1, 9, '2023-04-16 04:58:07', 'Modificacion'),
(1229, 1, 9, '2023-04-16 04:58:13', 'Registro'),
(1230, 1, 9, '2023-04-16 04:58:18', 'EliminaciÃ³n'),
(1231, 1, 10, '2023-04-16 05:49:31', 'Registro de Permisos'),
(1232, 1, 10, '2023-04-16 05:52:17', 'Registro de Rol'),
(1233, 1, 10, '2023-04-16 05:52:22', 'EliminaciÃ³n de Rol'),
(1234, 1, 10, '2023-04-16 05:56:03', 'Registro de Permisos'),
(1235, 1, 12, '2023-04-16 06:03:04', 'Modificacion'),
(1236, 1, 12, '2023-04-16 06:03:23', 'Registro'),
(1237, 1, 12, '2023-04-16 06:03:30', 'EliminaciÃ³n'),
(1238, 1, 17, '2023-04-16 03:49:32', 'EliminaciÃ³n'),
(1239, 1, 17, '2023-04-16 03:50:45', 'EliminaciÃ³n'),
(1240, 1, 17, '2023-04-16 03:51:03', 'EliminaciÃ³n'),
(1241, 1, 17, '2023-04-16 04:40:08', 'EliminaciÃ³n'),
(1242, 1, 2, '2023-04-16 04:40:51', 'Registro'),
(1243, 1, 2, '2023-04-16 04:41:00', 'EliminaciÃ³n'),
(1244, 1, 2, '2023-04-16 11:33:06', 'Registro'),
(1245, 1, 2, '2023-04-16 11:33:17', 'Registro'),
(1246, 1, 17, '2023-04-16 11:38:06', 'EliminaciÃ³n'),
(1247, 1, 17, '2023-04-16 11:39:48', 'EliminaciÃ³n'),
(1248, 1, 17, '2023-04-16 11:39:56', 'EliminaciÃ³n'),
(1249, 1, 17, '2023-04-16 11:40:39', 'EliminaciÃ³n'),
(1250, 1, 12, '2023-04-16 11:42:03', 'Modificacion'),
(1251, 1, 12, '2023-04-16 11:42:57', 'Modificacion'),
(1252, 1, 12, '2023-04-16 11:43:15', 'Modificacion'),
(1253, 1, 12, '2023-04-16 11:43:35', 'EliminaciÃ³n'),
(1254, 1, 12, '2023-04-16 11:44:32', 'Modificacion'),
(1255, 1, 12, '2023-04-16 11:44:37', 'Modificacion'),
(1256, 1, 7, '2023-04-16 11:45:59', 'Modificacion'),
(1257, 1, 7, '2023-04-16 11:46:05', 'Modificacion'),
(1258, 1, 6, '2023-04-16 11:48:08', 'EliminaciÃ³n'),
(1259, 1, 6, '2023-04-16 11:48:18', 'Modificacion'),
(1260, 1, 6, '2023-04-16 11:49:30', 'EliminaciÃ³n'),
(1261, 1, 6, '2023-04-16 11:50:28', 'Registro'),
(1262, 1, 3, '2023-04-16 11:52:18', 'Registro'),
(1263, 1, 8, '2023-04-16 11:57:32', 'Modificacion'),
(1264, 1, 8, '2023-04-17 12:09:04', 'Registro'),
(1265, 1, 8, '2023-04-17 12:56:52', 'EliminaciÃ³n'),
(1266, 1, 8, '2023-04-17 12:57:21', 'Modificacion'),
(1267, 1, 9, '2023-04-17 12:57:51', 'EliminaciÃ³n'),
(1268, 1, 9, '2023-04-17 12:59:35', 'Registro'),
(1269, 1, 9, '2023-04-17 12:59:42', 'Registro'),
(1270, 1, 9, '2023-04-17 01:00:32', 'Registro'),
(1271, 1, 9, '2023-04-17 01:01:02', 'EliminaciÃ³n'),
(1272, 1, 9, '2023-04-17 01:01:09', 'Modificacion'),
(1273, 1, 5, '2023-04-17 01:01:57', 'Registro'),
(1274, 1, 12, '2023-04-17 01:18:57', 'EliminaciÃ³n de rol'),
(1275, 0, 12, '2023-04-17 01:19:03', 'Registro de rol'),
(1276, 209, 10, '2023-04-17 01:19:22', 'Permisos Eliminados'),
(1277, 209, 10, '2023-04-17 01:23:00', 'Modificacion de Rol'),
(1278, 209, 10, '2023-04-17 01:23:44', 'Modificacion de Rol'),
(1279, 209, 12, '2023-04-17 01:24:19', 'Modificacion'),
(1280, 209, 13, '2023-04-17 01:24:35', 'Registro'),
(1281, 209, 13, '2023-04-17 01:24:58', 'Registro'),
(1282, 209, 13, '2023-04-17 01:25:14', 'Modificacion'),
(1283, 209, 13, '2023-04-17 01:25:36', 'Modificacion'),
(1284, 209, 13, '2023-04-17 01:25:58', 'Registro'),
(1285, 209, 13, '2023-04-17 01:26:21', 'Registro'),
(1286, 209, 13, '2023-04-17 01:26:27', 'Registro'),
(1287, 209, 13, '2023-04-17 01:26:38', 'Registro'),
(1288, 209, 13, '2023-04-17 01:27:04', 'Registro'),
(1289, 209, 13, '2023-04-17 01:28:36', 'Registro'),
(1290, 209, 13, '2023-04-17 01:29:37', 'Registro'),
(1291, 209, 13, '2023-04-17 01:30:07', 'Registro'),
(1292, 209, 13, '2023-04-17 01:30:16', 'Modificacion'),
(1293, 209, 13, '2023-04-17 01:35:29', 'Registro'),
(1294, 209, 17, '2023-04-17 01:51:31', 'EliminaciÃ³n'),
(1295, 209, 2, '2023-04-17 01:52:33', 'EliminaciÃ³n'),
(1296, 209, 2, '2023-04-17 01:52:38', 'EliminaciÃ³n'),
(1297, 209, 10, '2023-04-18 12:10:18', 'Registro de Permisos'),
(1298, 209, 10, '2023-04-18 12:10:20', 'Registro de Permisos'),
(1299, 209, 10, '2023-04-18 12:10:20', 'Permisos Actualizados'),
(1300, 209, 10, '2023-04-18 12:10:21', 'Permisos Actualizados'),
(1301, 209, 10, '2023-04-18 12:10:21', 'Permisos Actualizados'),
(1302, 209, 10, '2023-04-18 12:10:22', 'Permisos Actualizados'),
(1303, 209, 10, '2023-04-18 12:10:23', 'Permisos Actualizados'),
(1304, 209, 10, '2023-04-18 12:10:23', 'Permisos Actualizados'),
(1305, 209, 10, '2023-04-18 12:10:24', 'Permisos Actualizados'),
(1306, 209, 10, '2023-04-18 12:10:24', 'Permisos Actualizados'),
(1307, 209, 10, '2023-04-18 12:10:58', 'Permisos Actualizados'),
(1308, 209, 10, '2023-04-18 12:10:58', 'Permisos Actualizados'),
(1309, 209, 10, '2023-04-18 12:11:00', 'Permisos Actualizados'),
(1310, 209, 10, '2023-04-18 12:11:00', 'Permisos Actualizados'),
(1311, 209, 10, '2023-04-18 12:11:01', 'Permisos Actualizados'),
(1312, 209, 10, '2023-04-18 12:11:07', 'Registro de Permisos'),
(1313, 209, 12, '2023-04-18 12:25:00', 'EliminaciÃ³n de rol'),
(1314, 209, 12, '2023-04-18 12:25:05', 'EliminaciÃ³n de rol'),
(1315, 209, 12, '2023-04-18 12:25:10', 'EliminaciÃ³n de rol'),
(1316, 0, 12, '2023-04-18 12:25:14', 'Registro de rol'),
(1317, 210, 12, '2023-04-18 12:27:20', 'EliminaciÃ³n de rol'),
(1318, 210, 12, '2023-04-18 12:27:33', 'EliminaciÃ³n'),
(1319, 210, 12, '2023-04-18 12:39:00', 'EliminaciÃ³n'),
(1320, 210, 2, '2023-04-18 01:58:11', 'Registro'),
(1321, 210, 9, '2023-04-18 02:04:02', 'Modificacion'),
(1322, 210, 9, '2023-04-18 02:04:23', 'Modificacion'),
(1323, 210, 9, '2023-04-18 02:04:28', 'EliminaciÃ³n'),
(1324, 210, 5, '2023-04-18 02:25:18', 'Registro'),
(1325, 210, 6, '2023-04-18 02:25:48', 'Registro'),
(1326, 210, 4, '2023-04-18 02:26:39', 'Modificacion'),
(1327, 210, 13, '2023-04-18 02:29:39', 'EliminaciÃ³n'),
(1328, 210, 13, '2023-04-18 02:29:53', 'EliminaciÃ³n'),
(1329, 210, 13, '2023-04-18 02:30:02', 'EliminaciÃ³n'),
(1330, 210, 10, '2023-04-18 03:26:41', 'Registro de Permisos'),
(1331, 210, 10, '2023-04-18 03:26:42', 'Registro de Permisos'),
(1332, 210, 10, '2023-04-18 03:26:43', 'Permisos Actualizados'),
(1333, 210, 10, '2023-04-18 03:26:44', 'Permisos Actualizados'),
(1334, 210, 10, '2023-04-18 03:26:45', 'Permisos Actualizados'),
(1335, 210, 10, '2023-04-18 03:26:46', 'Permisos Actualizados'),
(1336, 210, 10, '2023-04-18 03:26:51', 'Registro de Permisos'),
(1337, 210, 10, '2023-04-18 03:26:52', 'Permisos Actualizados'),
(1338, 210, 10, '2023-04-18 03:26:53', 'Permisos Actualizados'),
(1339, 210, 10, '2023-04-18 03:26:53', 'Permisos Actualizados'),
(1340, 210, 10, '2023-04-18 03:26:54', 'Permisos Actualizados'),
(1341, 210, 10, '2023-04-18 03:26:56', 'Registro de Permisos'),
(1342, 210, 7, '2023-04-18 04:19:54', 'Registro'),
(1343, 210, 7, '2023-04-18 04:19:59', 'EliminaciÃ³n'),
(1344, 210, 2, '2023-04-19 07:55:51', 'Registro'),
(1345, 210, 3, '2023-04-19 08:15:17', 'Modificacion'),
(1346, 210, 3, '2023-04-19 08:15:40', 'Modificacion'),
(1347, 210, 3, '2023-04-19 08:17:14', 'EliminaciÃ³n'),
(1348, 210, 1, '2023-04-19 08:20:12', 'Modificacion'),
(1349, 210, 1, '2023-04-19 08:20:20', 'Modificacion'),
(1350, 210, 10, '2023-04-19 08:26:44', 'Permisos Actualizados'),
(1351, 210, 10, '2023-04-19 08:26:46', 'Permisos Actualizados'),
(1352, 210, 10, '2023-04-19 08:26:46', 'Permisos Actualizados'),
(1353, 210, 10, '2023-04-19 08:26:47', 'Permisos Actualizados'),
(1354, 210, 10, '2023-04-19 08:26:48', 'Permisos Actualizados'),
(1355, 210, 10, '2023-04-19 08:26:49', 'Permisos Actualizados'),
(1356, 210, 10, '2023-04-19 08:26:49', 'Permisos Actualizados'),
(1357, 210, 10, '2023-04-19 08:26:50', 'Permisos Actualizados'),
(1358, 210, 10, '2023-04-19 08:26:53', 'Registro de Permisos'),
(1359, 210, 10, '2023-04-19 08:26:53', 'Permisos Actualizados'),
(1360, 210, 10, '2023-04-19 08:26:54', 'Permisos Actualizados'),
(1361, 210, 10, '2023-04-19 08:26:55', 'Permisos Actualizados'),
(1362, 210, 10, '2023-04-19 08:26:55', 'Permisos Actualizados'),
(1363, 210, 10, '2023-04-19 08:26:56', 'Permisos Actualizados'),
(1364, 210, 10, '2023-04-19 08:26:57', 'Permisos Actualizados'),
(1365, 210, 10, '2023-04-19 08:26:57', 'Permisos Actualizados'),
(1366, 210, 10, '2023-04-19 08:26:57', 'Permisos Actualizados'),
(1367, 210, 10, '2023-04-19 08:29:14', 'Permisos Actualizados'),
(1368, 210, 10, '2023-04-19 08:29:15', 'Permisos Actualizados'),
(1369, 210, 10, '2023-04-19 08:29:17', 'Permisos Actualizados'),
(1370, 210, 10, '2023-04-19 08:29:19', 'Permisos Actualizados'),
(1371, 210, 10, '2023-04-19 08:29:20', 'Permisos Actualizados'),
(1372, 210, 10, '2023-04-19 08:29:21', 'Permisos Eliminados'),
(1373, 210, 12, '2023-04-19 08:29:39', 'Registro de rol'),
(1374, 210, 12, '2023-04-19 08:29:40', 'EliminaciÃ³n de rol'),
(1375, 210, 12, '2023-04-19 08:29:41', 'Registro de rol'),
(1376, 210, 12, '2023-04-19 08:29:41', 'EliminaciÃ³n de rol'),
(1377, 210, 12, '2023-04-19 08:29:43', 'Registro de rol'),
(1378, 210, 12, '2023-04-19 08:30:14', 'Registro'),
(1379, 210, 12, '2023-04-19 08:30:35', 'Registro'),
(1380, 210, 12, '2023-04-19 08:30:48', 'EliminaciÃ³n'),
(1381, 210, 12, '2023-04-19 08:30:58', 'Modificacion'),
(1382, 210, 12, '2023-04-19 08:31:17', 'Registro de rol'),
(1383, 210, 12, '2023-04-19 08:31:18', 'Registro de rol'),
(1384, 210, 12, '2023-04-19 08:31:21', 'Registro de rol'),
(1385, 210, 12, '2023-04-19 08:31:22', 'Registro de rol'),
(1386, 210, 12, '2023-04-19 08:31:23', 'EliminaciÃ³n de rol'),
(1387, 210, 12, '2023-04-19 08:31:24', 'EliminaciÃ³n de rol'),
(1388, 210, 12, '2023-04-19 08:31:28', 'Registro de rol'),
(1389, 210, 12, '2023-04-19 08:31:29', 'Registro de rol'),
(1390, 210, 9, '2023-04-19 08:33:28', 'Registro'),
(1391, 210, 9, '2023-04-19 08:33:40', 'Registro'),
(1392, 210, 9, '2023-04-19 08:33:45', 'EliminaciÃ³n'),
(1393, 210, 9, '2023-04-19 08:33:51', 'EliminaciÃ³n'),
(1394, 210, 6, '2023-04-19 08:41:40', 'EliminaciÃ³n'),
(1395, 210, 2, '2023-04-19 09:08:30', 'EliminaciÃ³n'),
(1396, 210, 2, '2023-04-19 09:08:35', 'EliminaciÃ³n'),
(1397, 210, 17, '2023-04-19 09:12:35', 'EliminaciÃ³n'),
(1398, 210, 6, '2023-04-19 09:16:15', 'Registro'),
(1399, 210, 12, '2023-04-19 09:18:05', 'EliminaciÃ³n de rol'),
(1400, 210, 12, '2023-04-19 09:18:05', 'EliminaciÃ³n de rol'),
(1401, 210, 12, '2023-04-19 09:18:06', 'EliminaciÃ³n de rol'),
(1402, 210, 12, '2023-04-19 09:18:23', 'EliminaciÃ³n de rol'),
(1403, 210, 12, '2023-04-19 09:18:23', 'EliminaciÃ³n de rol'),
(1404, 210, 12, '2023-04-19 09:18:23', 'EliminaciÃ³n de rol'),
(1405, 210, 12, '2023-04-19 09:18:24', 'EliminaciÃ³n de rol'),
(1406, 210, 12, '2023-04-19 09:18:29', 'EliminaciÃ³n'),
(1407, 210, 10, '2023-04-19 09:20:34', 'Permisos Actualizados'),
(1408, 210, 10, '2023-04-19 09:20:35', 'Permisos Actualizados'),
(1409, 210, 10, '2023-04-19 09:20:36', 'Permisos Actualizados'),
(1410, 210, 10, '2023-04-19 09:20:36', 'Permisos Actualizados'),
(1411, 210, 10, '2023-04-19 09:20:37', 'Permisos Actualizados'),
(1412, 210, 13, '2023-04-19 09:26:29', 'Registro'),
(1413, 210, 6, '2023-04-19 05:13:21', 'Registro'),
(1414, 210, 12, '2023-04-22 08:34:07', 'Registro de rol'),
(1415, 210, 12, '2023-04-22 08:34:08', 'EliminaciÃ³n de rol'),
(1416, 210, 12, '2023-04-22 08:34:09', 'EliminaciÃ³n de rol'),
(1417, 0, 12, '2023-04-22 08:34:10', 'Registro de rol'),
(1418, 225, 12, '2023-04-22 08:34:11', 'Registro de rol'),
(1419, 225, 10, '2023-04-23 12:08:57', 'Permisos Actualizados'),
(1420, 225, 10, '2023-04-23 12:08:58', 'Permisos Actualizados'),
(1421, 225, 10, '2023-04-23 12:08:58', 'Permisos Actualizados'),
(1422, 225, 10, '2023-04-23 12:08:59', 'Permisos Actualizados'),
(1423, 225, 10, '2023-04-23 12:08:59', 'Permisos Actualizados'),
(1424, 225, 10, '2023-04-23 12:09:01', 'Registro de Permisos'),
(1425, 225, 10, '2023-04-23 12:09:02', 'Registro de Permisos'),
(1426, 225, 10, '2023-04-23 12:09:02', 'Registro de Permisos'),
(1427, 225, 10, '2023-04-23 12:09:03', 'Permisos Actualizados'),
(1428, 225, 10, '2023-04-23 12:09:03', 'Permisos Actualizados'),
(1429, 225, 10, '2023-04-23 12:09:04', 'Permisos Actualizados'),
(1430, 225, 10, '2023-04-23 12:16:33', 'Permisos Actualizados'),
(1431, 225, 10, '2023-04-23 12:16:34', 'Permisos Actualizados'),
(1432, 225, 10, '2023-04-23 12:16:34', 'Permisos Actualizados'),
(1433, 225, 10, '2023-04-23 12:16:35', 'Permisos Actualizados'),
(1434, 225, 3, '2023-04-24 04:06:34', 'Registro'),
(1435, 225, 3, '2023-04-26 03:44:25', 'Registro'),
(1436, 225, 3, '2023-04-26 03:44:35', 'EliminaciÃ³n'),
(1437, 225, 2, '2023-04-26 03:45:46', 'Registro'),
(1438, 225, 2, '2023-04-26 03:45:53', 'EliminaciÃ³n'),
(1439, 225, 2, '2023-04-26 03:46:11', 'Modificacion'),
(1440, 225, 12, '2023-04-26 03:47:37', 'Registro de rol'),
(1441, 225, 12, '2023-04-26 03:50:23', 'EliminaciÃ³n de rol'),
(1442, 225, 12, '2023-04-26 03:50:24', 'Registro de rol'),
(1443, 225, 12, '2023-04-26 03:50:47', 'EliminaciÃ³n de rol'),
(1444, 0, 12, '2023-04-26 03:50:54', 'Registro de rol'),
(1445, 229, 12, '2023-04-26 03:51:00', 'EliminaciÃ³n de rol'),
(1446, 229, 12, '2023-04-26 03:51:01', 'EliminaciÃ³n de rol'),
(1447, 229, 12, '2023-04-26 03:51:08', 'EliminaciÃ³n de rol'),
(1448, 229, 12, '2023-04-26 03:51:15', 'Registro de rol'),
(1449, 229, 12, '2023-04-26 03:51:16', 'Registro de rol'),
(1450, 229, 12, '2023-04-26 03:51:16', 'Registro de rol'),
(1451, 229, 8, '2023-04-29 05:06:53', 'Modificacion'),
(1452, 229, 10, '2023-04-30 03:06:14', 'Modificacion de Rol'),
(1453, 229, 10, '2023-04-30 03:06:22', 'Permisos Actualizados'),
(1454, 229, 10, '2023-04-30 03:06:25', 'Permisos Actualizados'),
(1455, 229, 10, '2023-04-30 03:06:26', 'Permisos Actualizados'),
(1456, 229, 10, '2023-04-30 03:06:28', 'Permisos Eliminados'),
(1457, 229, 10, '2023-04-30 03:06:31', 'Registro de Permisos'),
(1458, 229, 12, '2023-04-30 04:55:14', 'Registro'),
(1459, 229, 12, '2023-04-30 04:57:46', 'Registro'),
(1460, 229, 12, '2023-04-30 04:57:54', 'EliminaciÃ³n'),
(1461, 229, 12, '2023-04-30 05:01:08', 'EliminaciÃ³n de rol'),
(1462, 229, 12, '2023-04-30 05:01:09', 'EliminaciÃ³n de rol'),
(1463, 229, 12, '2023-04-30 05:01:17', 'Registro de rol'),
(1464, 229, 12, '2023-04-30 05:01:18', 'Registro de rol'),
(1465, 229, 12, '2023-04-30 05:09:47', 'Modificacion'),
(1466, 229, 12, '2023-04-30 05:15:21', 'Modificacion'),
(1467, 229, 12, '2023-04-30 05:15:54', 'Modificacion'),
(1468, 229, 12, '2023-04-30 05:16:30', 'Modificacion'),
(1469, 229, 12, '2023-04-30 05:17:06', 'Modificacion'),
(1470, 229, 12, '2023-04-30 05:17:32', 'EliminaciÃ³n de rol'),
(1471, 0, 12, '2023-04-30 05:17:33', 'EliminaciÃ³n de rol'),
(1472, 0, 12, '2023-04-30 05:17:56', 'EliminaciÃ³n de rol'),
(1473, 0, 12, '2023-04-30 05:17:56', 'EliminaciÃ³n de rol'),
(1474, 0, 12, '2023-04-30 05:18:00', 'EliminaciÃ³n'),
(1475, 0, 12, '2023-04-30 05:18:12', 'Registro de rol'),
(1476, 235, 12, '2023-04-30 08:27:11', 'Modificacion'),
(1477, 235, 5, '2023-04-30 09:05:41', 'Registro'),
(1478, 235, 12, '2023-04-30 09:34:46', 'Registro'),
(1479, 235, 12, '2023-04-30 09:42:05', 'EliminaciÃ³n'),
(1480, 235, 12, '2023-04-30 09:43:10', 'Modificacion'),
(1481, 235, 3, '2023-04-30 10:09:31', 'Registro'),
(1482, 235, 5, '2023-05-01 05:21:57', 'Modificacion'),
(1483, 235, 5, '2023-05-01 05:22:10', 'Modificacion'),
(1484, 235, 5, '2023-05-01 05:22:16', 'Modificacion'),
(1485, 235, 5, '2023-05-01 05:24:37', 'Modificacion'),
(1486, 235, 5, '2023-05-01 05:42:28', 'Modificacion'),
(1487, 235, 5, '2023-05-01 05:42:52', 'Modificacion'),
(1488, 235, 5, '2023-05-01 05:44:34', 'Modificacion'),
(1489, 235, 5, '2023-05-01 05:44:40', 'Modificacion'),
(1490, 235, 12, '2023-05-01 05:48:27', 'Modificacion'),
(1491, 235, 12, '2023-05-01 05:48:38', 'Modificacion'),
(1492, 235, 12, '2023-05-01 05:48:45', 'Modificacion'),
(1493, 235, 5, '2023-05-01 05:57:50', 'Registro'),
(1494, 235, 5, '2023-05-01 05:58:12', 'Registro'),
(1495, 235, 5, '2023-05-01 05:58:19', 'EliminaciÃ³n'),
(1496, 235, 5, '2023-05-01 05:58:25', 'EliminaciÃ³n'),
(1497, 235, 6, '2023-05-01 06:17:26', 'Registro'),
(1498, 235, 6, '2023-05-01 06:17:41', 'Registro'),
(1499, 235, 6, '2023-05-01 06:17:49', 'EliminaciÃ³n'),
(1500, 235, 6, '2023-05-01 06:22:50', 'Registro'),
(1501, 235, 6, '2023-05-01 06:22:57', 'EliminaciÃ³n'),
(1502, 235, 2, '2023-05-01 04:15:48', 'Modificacion'),
(1503, 235, 17, '2023-05-01 05:11:00', 'EliminaciÃ³n'),
(1504, 235, 17, '2023-05-02 06:27:32', 'EliminaciÃ³n'),
(1505, 235, 10, '2023-05-02 06:29:47', 'Permisos Actualizados'),
(1506, 235, 10, '2023-05-02 06:29:50', 'Permisos Actualizados'),
(1507, 235, 10, '2023-05-02 06:29:51', 'Permisos Actualizados'),
(1508, 235, 10, '2023-05-02 06:29:51', 'Permisos Actualizados'),
(1509, 235, 10, '2023-05-02 06:29:52', 'Permisos Actualizados'),
(1510, 235, 10, '2023-05-02 06:29:53', 'Permisos Actualizados'),
(1511, 235, 10, '2023-05-02 06:29:53', 'Permisos Actualizados'),
(1512, 235, 10, '2023-05-02 06:29:54', 'Permisos Actualizados'),
(1513, 235, 10, '2023-05-02 06:29:57', 'Permisos Actualizados'),
(1514, 235, 10, '2023-05-02 06:29:58', 'Permisos Actualizados'),
(1515, 235, 10, '2023-05-02 06:29:58', 'Permisos Actualizados'),
(1516, 235, 10, '2023-05-02 06:30:02', 'Permisos Actualizados'),
(1517, 235, 10, '2023-05-02 06:30:03', 'Permisos Actualizados'),
(1518, 235, 10, '2023-05-02 06:30:03', 'Permisos Actualizados'),
(1519, 235, 10, '2023-05-02 06:30:05', 'Registro de Permisos'),
(1520, 235, 10, '2023-05-02 06:30:05', 'Registro de Permisos'),
(1521, 235, 10, '2023-05-02 06:30:06', 'Registro de Permisos'),
(1522, 235, 14, '2023-05-15 05:42:05', 'Agregar Contenido'),
(1523, 235, 10, '2023-05-15 05:47:02', 'Permisos Actualizados'),
(1524, 235, 10, '2023-05-15 05:47:03', 'Permisos Actualizados'),
(1525, 235, 10, '2023-05-15 05:47:03', 'Permisos Actualizados'),
(1526, 235, 10, '2023-05-15 05:47:04', 'Permisos Actualizados'),
(1527, 239, 13, '2023-05-15 06:51:00', 'Modificacion'),
(1528, 239, 4, '2023-05-15 06:57:03', 'Registro'),
(1529, 239, 7, '2023-05-21 05:29:43', 'Registro'),
(1530, 235, 7, '2023-05-21 07:16:07', 'Eliminación'),
(1531, 235, 7, '2023-05-24 05:49:49', 'Eliminación'),
(1532, 235, 7, '2023-05-24 08:05:16', 'Eliminación'),
(1533, 235, 7, '2023-06-02 01:06:17', 'Registro'),
(1534, 235, 7, '2023-06-02 01:06:23', 'Eliminación'),
(1535, 235, 7, '2023-06-02 03:05:37', 'Registro'),
(1536, 235, 7, '2023-06-02 03:05:43', 'Eliminación'),
(1537, 235, 7, '2023-06-02 03:36:25', 'Registro'),
(1538, 235, 7, '2023-06-02 03:36:31', 'Eliminación'),
(1539, 235, 7, '2023-06-02 03:45:26', 'Registro'),
(1540, 235, 7, '2023-06-02 03:45:31', 'Eliminación'),
(1541, 235, 7, '2023-06-02 03:48:47', 'Registro'),
(1542, 235, 6, '2023-06-02 04:03:00', 'Registro'),
(1543, 235, 1, '2023-06-02 04:25:28', 'Registro'),
(1544, 235, 1, '2023-06-02 04:40:26', 'Modificacion'),
(1545, 235, 1, '2023-06-02 04:40:46', 'Modificacion'),
(1546, 235, 1, '2023-06-02 04:56:20', 'Modificacion'),
(1547, 235, 12, '2023-06-09 07:10:45', 'Modificacion'),
(1548, 235, 7, '2023-06-19 03:11:13', 'Registro'),
(1549, 235, 3, '2023-06-19 04:37:37', 'Registro'),
(1550, 235, 7, '2023-07-03 07:39:14', 'Registro'),
(1551, 235, 1, '2023-07-15 12:40:03', 'Modificacion'),
(1552, 235, 13, '2023-07-15 12:40:22', 'Registro'),
(1553, 235, 0, '2023-07-15 12:40:32', 'Eliminación'),
(1554, 235, 13, '2023-07-15 12:40:59', 'Registro'),
(1555, 235, 0, '2023-07-15 12:41:12', 'Eliminación'),
(1556, 235, 14, '2023-07-15 12:42:38', 'Agregar Contenido'),
(1557, 235, 14, '2023-07-15 12:42:48', 'Agregar Contenido');

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
(32423450, 1, '2023-04-29 09:40:00', '2023-05-04 10:40:00', 'aaaaa');

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

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id`, `nombre`, `descripcion`, `archivo_adjunto`) VALUES
(33, 'Forochat', 'dsadsadsa', 'EXCEL-EntornosSistema.xlsx'),
(34, 'Cesar', 'dsadsadsa', 'Ejecucion de pruebas[1].pdf'),
(36, 'Alejandro', 'dfsgfdgfdgfd', 'asignarrol.png'),
(37, 'MI ejemplo', 'Para probar', 'calidad.png');

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
(32, 'Marketing', 77, 'true'),
(33, 'Nuevo', 77, 'true');

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
(43, 32, 16),
(64, 32, 28);

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

--
-- Volcado de datos para la tabla `estudiante_evaluacion`
--

INSERT INTO `estudiante_evaluacion` (`id`, `id_usuario`, `id_unidad_evaluacion`, `descripcion`, `archivo_adjunto`, `fecha_entrega`, `calificacion`, `retroalimentacion`) VALUES
(41, 175, 4980, 'documento.doc', 'fdgdfgdf', '2023-05-15 06:47:17', '10.00', NULL);

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
(20, 'Nueva evaluación', 'Conociendo el modulo', 'Estudiantes.png'),
(22, 'Evaluación prueba', 'ejemplo de acento', 'Gestion de inscripciones.xlsx');

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
(16, 'Funeraria'),
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
(226, 7, 13, 'true', 'true', 'true', 'true'),
(227, 7, 14, 'true', 'null', 'null', 'true'),
(228, 7, 15, 'true', 'null', 'null', 'true'),
(229, 7, 16, 'null', 'null', 'null', 'null'),
(231, 5, 2, 'true', 'true', 'true', 'true'),
(232, 5, 3, 'true', 'true', 'true', 'true'),
(233, 5, 1, 'true', 'true', 'true', 'true'),
(234, 7, 17, 'null', 'null', 'null', 'null'),
(235, 5, 5, 'true', 'true', 'true', 'true'),
(237, 5, 13, 'true', 'true', 'true', 'true'),
(238, 5, 9, 'true', 'true', 'true', 'true'),
(239, 5, 4, 'true', 'true', 'true', 'true'),
(240, 5, 7, 'true', 'true', 'true', 'true'),
(242, 5, 8, 'true', 'true', 'true', 'true'),
(243, 5, 6, 'true', 'true', 'true', 'true'),
(244, 5, 14, 'true', 'null', 'null', 'true'),
(245, 5, 15, 'true', 'null', 'null', 'true'),
(246, 5, 16, 'null', 'null', 'null', 'null');

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
(16, 'Concepto de pan', 'Aprendiendo hacer pan', 24, '2023-04-18 01:09:43', '28055655');

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
(17, 'Ejemplo ', 'La unidad nueva a usar', 24),
(21, 'Cesar', 'asdsadsad', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_contenido`
--

CREATE TABLE `unidad_contenido` (
  `id` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_contenido`
--

INSERT INTO `unidad_contenido` (`id`, `id_unidad`, `id_contenido`) VALUES
(36, 17, 37);

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
(4980, 17, 20, '2023-03-16 10:03:00', '2023-07-25 10:03:00'),
(4981, 17, 22, '2023-07-18 16:32:36', '2023-07-25 16:32:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
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
  `imagen` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `cedula`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `genero`, `correo`, `token`, `fecha_expiracion`, `preguntas_seguridad`, `direccion`, `telefono`, `clave`, `imagen`) VALUES
(1, '28055655', 'Cesar', 'Alejandro', 'Vides', 'Gonzalez', 'Masculino', 'cesaralejandrovides2@gmail.com', '52756ee331ab4e59b12226231690066e1bd3fa04356bbaea485d3dd4234cbc02', '2023-07-20 17:16:33', 'VkZaRk9WQlRUazVhZWpBNVNUQXhNMUJVTUdwVVZrVTVVRk5PVGxwNk1EbEpNREV6VUZRd2FsUldSVGxRVTA1T1dub3dPVWt3TVROUVZEQnE=', 'Yucatan', '04120318406', '$2y$10$dyNth8E..o5q/hv2E1GM1.rEotuAfF55YajN3P1ccUayMJdR2Tr9W', NULL),
(174, '0000000', 'Cesar', 'Alejandro', 'Vides', 'gonzalez', 'Femenino', 'ejemplo@gmail.com', 'b93afa86cb221149fe141cf6d13cba3a37f7fbf24e5d47584ada070dd58b212b', '2023-07-20 17:18:04', NULL, 'yucatan p19', '04120318406', '$2y$10$dyNth8E..o5q/hv2E1GM1.rEotuAfF55YajN3P1ccUayMJdR2Tr9W', NULL),
(175, '26197135', 'Maria', 'Jose', 'Diaz', 'Cazorla', 'femenino', '', '7ac8dd16821da51628debb0172e3e22e889899b8c920b1456f7a4e376e9ae7bd', '2023-05-23 06:49:08', NULL, '', '', '$2y$10$dyNth8E..o5q/hv2E1GM1.rEotuAfF55YajN3P1ccUayMJdR2Tr9W', NULL),
(176, '10479729', 'Jose', 'Gregorio', 'Diaz', 'Arguinzones', 'Masculino', 'jose@gmail.com', NULL, NULL, NULL, 'Av Antonio Benitez', '04120235422', 'Vld0Rk9WQlRUbWhWVkRBNVNUSk9RbEJVTUdwWmEwVTVVRk5PYVdSNk1EbEpNa3BTVUZRd2FsZFdSVGxRVTA1aFVWUXdPVWt5U2pOUVZEQnE=', NULL);

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
(235, 1, 1),
(236, 1, 7),
(239, 1, 5),
(242, 175, 7),
(243, 176, 5),
(244, 174, 7);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `aspirante_emprendimiento`
--
ALTER TABLE `aspirante_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `aula_docente`
--
ALTER TABLE `aula_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `aula_estudiante`
--
ALTER TABLE `aula_estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1558;

--
-- AUTO_INCREMENT de la tabla `censo`
--
ALTER TABLE `censo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32423451;

--
-- AUTO_INCREMENT de la tabla `chat_virtual`
--
ALTER TABLE `chat_virtual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `emprendimiento`
--
ALTER TABLE `emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `emprendimiento_modulo`
--
ALTER TABLE `emprendimiento_modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `entorno_sistema`
--
ALTER TABLE `entorno_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `estudiante_evaluacion`
--
ALTER TABLE `estudiante_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `unidad_contenido`
--
ALTER TABLE `unidad_contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `unidad_evaluaciones`
--
ALTER TABLE `unidad_evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4982;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

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
