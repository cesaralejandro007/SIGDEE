-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bdsystem
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area_emprendimiento`
--

DROP TABLE IF EXISTS `area_emprendimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_emprendimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_emprendimiento`
--

LOCK TABLES `area_emprendimiento` WRITE;
/*!40000 ALTER TABLE `area_emprendimiento` DISABLE KEYS */;
INSERT INTO `area_emprendimiento` VALUES (5,'Servicio'),(6,'Comercialización');
/*!40000 ALTER TABLE `area_emprendimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aspirante_emprendimiento`
--

DROP TABLE IF EXISTS `aspirante_emprendimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aspirante_emprendimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_emprendimiento` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_emprendimiento` (`id_emprendimiento`),
  CONSTRAINT `aspirante_emprendimiento_ibfk_1` FOREIGN KEY (`id_emprendimiento`) REFERENCES `emprendimiento` (`id`),
  CONSTRAINT `aspirante_emprendimiento_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aspirante_emprendimiento`
--

LOCK TABLES `aspirante_emprendimiento` WRITE;
/*!40000 ALTER TABLE `aspirante_emprendimiento` DISABLE KEYS */;
INSERT INTO `aspirante_emprendimiento` VALUES (2,51,34),(3,58,34),(4,51,35),(5,58,35);
/*!40000 ALTER TABLE `aspirante_emprendimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aula`
--

DROP TABLE IF EXISTS `aula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_emprendimiento_modulo` int(11) NOT NULL,
  `estatus` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_tipo_modulo` (`id_emprendimiento_modulo`),
  CONSTRAINT `aula_ibfk_1` FOREIGN KEY (`id_emprendimiento_modulo`) REFERENCES `emprendimiento_modulo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aula`
--

LOCK TABLES `aula` WRITE;
/*!40000 ALTER TABLE `aula` DISABLE KEYS */;
INSERT INTO `aula` VALUES (2,'FG001',35,'true');
/*!40000 ALTER TABLE `aula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aula_docente`
--

DROP TABLE IF EXISTS `aula_docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aula_docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aula` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_aula` (`id_aula`),
  KEY `id_docente` (`id_docente`),
  CONSTRAINT `aula_docente_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `usuario` (`id`),
  CONSTRAINT `aula_docente_ibfk_2` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aula_docente`
--

LOCK TABLES `aula_docente` WRITE;
/*!40000 ALTER TABLE `aula_docente` DISABLE KEYS */;
INSERT INTO `aula_docente` VALUES (2,2,79);
/*!40000 ALTER TABLE `aula_docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aula_estudiante`
--

DROP TABLE IF EXISTS `aula_estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aula_estudiante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aula` int(11) DEFAULT NULL,
  `id_estudiante` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_aula` (`id_aula`),
  KEY `id_estudiante` (`id_estudiante`),
  CONSTRAINT `aula_estudiante_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `usuario` (`id`),
  CONSTRAINT `aula_estudiante_ibfk_2` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aula_estudiante`
--

LOCK TABLES `aula_estudiante` WRITE;
/*!40000 ALTER TABLE `aula_estudiante` DISABLE KEYS */;
INSERT INTO `aula_estudiante` VALUES (2,2,51),(3,2,58);
/*!40000 ALTER TABLE `aula_estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_roles` int(11) NOT NULL,
  `id_entorno` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `accion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario_roles` (`id_usuario_roles`),
  KEY `id_entorno` (`id_entorno`),
  CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario_roles`) REFERENCES `usuarios_roles` (`id`),
  CONSTRAINT `bitacora_ibfk_2` FOREIGN KEY (`id_entorno`) REFERENCES `entorno_sistema` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `censo`
--

DROP TABLE IF EXISTS `censo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `censo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `descripcion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`id_usuario`),
  CONSTRAINT `censo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `censo`
--

LOCK TABLES `censo` WRITE;
/*!40000 ALTER TABLE `censo` DISABLE KEYS */;
INSERT INTO `censo` VALUES (2,46,'2023-09-21 00:00:00','2023-09-30 00:00:00','Primer censo');
/*!40000 ALTER TABLE `censo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_virtual`
--

DROP TABLE IF EXISTS `chat_virtual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_virtual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `mensaje` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `chat_virtual_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_virtual`
--

LOCK TABLES `chat_virtual` WRITE;
/*!40000 ALTER TABLE `chat_virtual` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_virtual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudades`
--

DROP TABLE IF EXISTS `ciudades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `ciudades_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudades`
--

LOCK TABLES `ciudades` WRITE;
/*!40000 ALTER TABLE `ciudades` DISABLE KEYS */;
INSERT INTO `ciudades` VALUES (67105,661,'Kabul'),(121353,836,'Hamburg'),(573524,1845,'Acetico'),(573586,1846,'Aguacate'),(573608,1847,'Agua Colorada'),(573666,1843,'Agua Linda'),(573929,1843,'Amauaca'),(574445,1854,'Barquisimeto'),(575162,1854,'Cabudare');
/*!40000 ALTER TABLE `ciudades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cedula_usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idpublicacion` (`id_publicacion`),
  CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenido`
--

DROP TABLE IF EXISTS `contenido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contenido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `archivo_adjunto` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenido`
--

LOCK TABLES `contenido` WRITE;
/*!40000 ALTER TABLE `contenido` DISABLE KEYS */;
/*!40000 ALTER TABLE `contenido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emprendimiento`
--

DROP TABLE IF EXISTS `emprendimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emprendimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `id_area` int(11) NOT NULL,
  `estatus` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idarea` (`id_area`) USING BTREE,
  CONSTRAINT `emprendimiento_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area_emprendimiento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emprendimiento`
--

LOCK TABLES `emprendimiento` WRITE;
/*!40000 ALTER TABLE `emprendimiento` DISABLE KEYS */;
INSERT INTO `emprendimiento` VALUES (31,'Asesorías',5,'true'),(32,'Funerarias',5,'true'),(33,'Transporte',5,'true'),(34,'Dulcería',6,'true'),(35,'Textil',6,'true');
/*!40000 ALTER TABLE `emprendimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emprendimiento_modulo`
--

DROP TABLE IF EXISTS `emprendimiento_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emprendimiento_modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_emprendimiento` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idemprendimiento` (`id_emprendimiento`),
  KEY `idmodulo` (`id_modulo`),
  CONSTRAINT `emprendimiento_modulo_ibfk_1` FOREIGN KEY (`id_emprendimiento`) REFERENCES `emprendimiento` (`id`),
  CONSTRAINT `emprendimiento_modulo_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emprendimiento_modulo`
--

LOCK TABLES `emprendimiento_modulo` WRITE;
/*!40000 ALTER TABLE `emprendimiento_modulo` DISABLE KEYS */;
INSERT INTO `emprendimiento_modulo` VALUES (23,31,36),(24,31,37),(25,31,38),(26,31,39),(27,32,36),(28,32,37),(29,32,38),(30,32,39),(31,33,36),(32,33,37),(33,33,38),(34,33,39),(35,34,36),(36,34,37),(37,34,38),(38,34,39),(39,35,36),(40,35,37),(41,35,38),(42,35,39);
/*!40000 ALTER TABLE `emprendimiento_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entorno_sistema`
--

DROP TABLE IF EXISTS `entorno_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entorno_sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entorno_sistema`
--

LOCK TABLES `entorno_sistema` WRITE;
/*!40000 ALTER TABLE `entorno_sistema` DISABLE KEYS */;
INSERT INTO `entorno_sistema` VALUES (1,'Aula'),(2,'Censo'),(3,'Contenidos'),(4,'Evaluaciones'),(5,'Estudiantes'),(6,'Docentes'),(7,'Area de Emprendimiento'),(8,'Emprendimiento'),(9,'Modulo'),(10,'Permisos'),(11,'Entornos del Sistema'),(12,'Usuarios'),(13,'Unidad'),(14,'Agregar Contenido'),(15,'Agregar Evaluacion'),(16,'Chat Virtual'),(17,'Aspirantes');
/*!40000 ALTER TABLE `entorno_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pais` (`id_pais`),
  CONSTRAINT `estados_ibfk_1` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (661,144,'Afghanistan'),(836,18,'Hamburg'),(1843,95,'Amazonas'),(1845,95,'Apure'),(1846,95,'Aragua'),(1847,95,'Barinas'),(1854,95,'Lara');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante_evaluacion`
--

DROP TABLE IF EXISTS `estudiante_evaluacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiante_evaluacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_unidad_evaluacion` int(11) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `archivo_adjunto` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `retroalimentacion` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`id_usuario`),
  KEY `idunidadevaluacion` (`id_unidad_evaluacion`),
  CONSTRAINT `estudiante_evaluacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `estudiante_evaluacion_ibfk_2` FOREIGN KEY (`id_unidad_evaluacion`) REFERENCES `unidad_evaluaciones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante_evaluacion`
--

LOCK TABLES `estudiante_evaluacion` WRITE;
/*!40000 ALTER TABLE `estudiante_evaluacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante_evaluacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluaciones`
--

DROP TABLE IF EXISTS `evaluaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evaluaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `archivo_adjunto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluaciones`
--

LOCK TABLES `evaluaciones` WRITE;
/*!40000 ALTER TABLE `evaluaciones` DISABLE KEYS */;
INSERT INTO `evaluaciones` VALUES (2,'Evaluacion','Conociendo la filosofia','cifrado.txt');
/*!40000 ALTER TABLE `evaluaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulo`
--

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (36,'Filosofía de gestión'),(37,'Imagen Corporativo'),(38,'Técnico Financiero'),(39,'Marketing Digital');
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_unidad_evaluaciones` int(11) NOT NULL,
  `id_usuarios_roles` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idunidadevaluacion` (`id_unidad_evaluaciones`),
  KEY `idusuarioroles` (`id_usuarios_roles`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuarios_roles`) REFERENCES `usuarios_roles` (`id`),
  CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_unidad_evaluaciones`) REFERENCES `unidad_evaluaciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (18,'Alemania'),(95,'Venezuela '),(144,'Afganistn');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_entorno` int(11) NOT NULL,
  `registrar` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `modificar` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `eliminar` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `consultar` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idrol` (`id_rol`),
  KEY `identorno` (`id_entorno`),
  CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`),
  CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`id_entorno`) REFERENCES `entorno_sistema` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=309 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (293,1,1,'true','true','true','true'),(295,1,3,'true','true','true','true'),(296,1,4,'true','true','true','true'),(297,1,5,'true','true','true','true'),(298,1,6,'true','true','true','true'),(299,1,7,'true','true','true','true'),(300,1,9,'true','true','true','true'),(301,1,8,'true','true','true','true'),(302,1,13,'true','true','true','true'),(303,1,14,'true','null','null','true'),(304,1,15,'true','true','true','true'),(305,1,16,'null','null','null','null'),(306,1,17,'null','true','true','true'),(307,1,2,'true','true','true','true');
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacion`
--

DROP TABLE IF EXISTS `publicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mensaje` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `id_aula` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cedula_usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idaula` (`id_aula`),
  CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacion`
--

LOCK TABLES `publicacion` WRITE;
/*!40000 ALTER TABLE `publicacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Super Usuario'),(2,'Administrador'),(5,'Docente'),(7,'Estudiante');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad`
--

DROP TABLE IF EXISTS `unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `id_aula` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idaula` (`id_aula`),
  CONSTRAINT `unidad_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad`
--

LOCK TABLES `unidad` WRITE;
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
INSERT INTO `unidad` VALUES (2,'Manipulación de alimentos','Unidad primordial',2);
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad_contenido`
--

DROP TABLE IF EXISTS `unidad_contenido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad_contenido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_unidad` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idunidad` (`id_unidad`),
  KEY `idcontenido` (`id_contenido`),
  CONSTRAINT `unidad_contenido_ibfk_1` FOREIGN KEY (`id_contenido`) REFERENCES `contenido` (`id`),
  CONSTRAINT `unidad_contenido_ibfk_2` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad_contenido`
--

LOCK TABLES `unidad_contenido` WRITE;
/*!40000 ALTER TABLE `unidad_contenido` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad_contenido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidad_evaluaciones`
--

DROP TABLE IF EXISTS `unidad_evaluaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad_evaluaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_unidad` int(11) NOT NULL,
  `id_evaluacion` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idunidad` (`id_unidad`),
  KEY `idevaluacion` (`id_evaluacion`),
  CONSTRAINT `unidad_evaluaciones_ibfk_1` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluaciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad_evaluaciones`
--

LOCK TABLES `unidad_evaluaciones` WRITE;
/*!40000 ALTER TABLE `unidad_evaluaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidad_evaluaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ciudad` int(11) NOT NULL,
  `cedula` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `primer_nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `segundo_nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primer_apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `segundo_apellido` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genero` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_expiracion` datetime DEFAULT NULL,
  `preguntas_seguridad` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clave` varchar(300) COLLATE utf8_unicode_ci DEFAULT 'd9aj2Z/Qkciin2OfYw==',
  `publickey` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `privatekey` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ciudad` (`id_ciudad`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (46,574445,'28055655','Cesar','Alejandro','Vides','Gonzalez','Masculino','cesaralejandrovides2@gmail.com','4600b176f7defefec281fa4eeeff077bcc151301ae7588a17990694d85f4b7d7','2023-09-26 01:42:21',NULL,'Urbanizacion Yucatan','04120318406','$2y$10$RKC39J8p6vhPt05nbAzHpebnia3XfrOznRzcTRvGz0gvuN1qILEuG','LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUE4QlRHZ0pGeFgraDJPS2cwVGM5YQoyRzVEZE5vdk91QjdHbU1USWdMVUhZMEFuendIYmVFSGp1VlJuVEIxUmpRS3J6ZElCVVZpajUyRGVFOTN5dlZRCmFuZWFKU2xTQmRtYjVIK3RtQ3JtdVBrUkcxRW5hdmF6bU0vcG1TVmQ3bHliM3JIeUVpd210cHo5QnpLcXBKcGsKRElQckpDTU1EWUdVOWI4enY5aTFnQVNtN3VENGFnOFR2Nnp4YWhzeUFhdG12WXZxM0pOb1lLc21tTHMvSERIUQpzNEY0L2FGWGdXaXdZeGtNeXpERnM3dWZrSUhrOWQ5Z1duT0ZHa2YwZm9sOWxpUmlsVzhEckl3L0dOQmVvYVA4ClByV0F2MlluaE9adXdFVGljMlBwUTFsQkhIUEZRcEdkanYzdHFrTE5KbTJjdi9qcjNpYkNMOGwyL3ExS0VFeUwKYlFJREFRQUIKLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0tCg==','LS0tLS1CRUdJTiBQUklWQVRFIEtFWS0tLS0tCk1JSUV2Z0lCQURBTkJna3Foa2lHOXcwQkFRRUZBQVNDQktnd2dnU2tBZ0VBQW9JQkFRRHdGTWFBa1hGZjZIWTQKcURSTnoxcllia04wMmk4NjRIc2FZeE1pQXRRZGpRQ2ZQQWR0NFFlTzVWR2RNSFZHTkFxdk4wZ0ZSV0tQbllONApUM2ZLOVZCcWQ1b2xLVklGMlp2a2Y2MllLdWE0K1JFYlVTZHE5ck9ZeittWkpWM3VYSnZlc2ZJU0xDYTJuUDBICk1xcWttbVFNZytza0l3d05nWlQxdnpPLzJMV0FCS2J1NFBocUR4Ty9yUEZxR3pJQnEyYTlpK3JjazJoZ3F5YVkKdXo4Y01kQ3pnWGo5b1ZlQmFMQmpHUXpMTU1XenU1K1FnZVQxMzJCYWM0VWFSL1IraVgyV0pHS1Zid09zakQ4WQowRjZoby93K3RZQy9aaWVFNW03QVJPSnpZK2xEV1VFY2M4VkNrWjJPL2UycVFzMG1iWnkvK092ZUpzSXZ5WGIrCnJVb1FUSXR0QWdNQkFBRUNnZ0VBRHArMVY2K0VVR3RBaUVMMnJLYXN5Zkl0ZWJpd2w4MkVzaDdHMDVPSWlDUkcKbld4eXAyYkZweGFnMmdwUm1tMGhHWHNzaitXaUUwMXM3SzhxaE5wY2c1KzFhLzRRV1ByZ1hCTEs2REgweTkrZwpBeUgyWExXYVN2eWZKZ3o0bzhSUVdraE1qbjdSL04yakxBVVNEK1MzbzJ1RnJ6WFRUaDlPaTRtU0JXV1Y2SzVCCnFOMU5ybVhIdE9QSmZPWEZlZFEyWXFoMmQxZkZKZ2I0aitwS25GVkY5UnRyREhHb1B3SngvRy9VdkFMZU1PYVYKUG02Yjdha0JRZ01tK2laUHUvdWRpakNNSk45b2tHODh1T1I5MGxQY054bzN4RHF0T0g2TDJwMGhWQTMxWE9MRQpUYis0ZWFTZGYwTng4ZEk5MGNCZUhHTXRnS011TytBaUluRnJzOEhrb1FLQmdRRDV3QVBib3RtQWFiQlF1YmsrCnA2UEhYdGg5aE5vN0IrUUMyOSsyOVp6NlpEU1FhcG1LL3QvV1hUUG1HNmQwbDJoY3pXNHZ2Z0FRRWhkK2F1cFMKYmdnalA3Q0hRajNsb0xDWG8xVW5ZVzZMS2ZhTUYrZ2VxYmxUd2I2UXpVWkxRU2FraGh5R0xmekZBUlpqSWdUdgpWME1PQzF5cm1GSnZ6RVBQYWU3Z3VJVTdvd0tCZ1FEMkZ0Rm45S1dKYXN2K2gyTldaQzZaU1RwSDUzdld5V0VqClM4OE9wdGhvNGZBS2NXSEthai93SjZOb25xSE5CWElwVFZqUXBkdEhYaU1FU3Z5TTRoNDl2NzdkaXVKR2xkL3cKMERXRzJIZzZncUpNZXpjazNvYWJMU1dlQTRnOFdlcTJOSnVYdnhlNUF0QmdvNjAzVlM2cnBKKzRsdGY4UXNzSwpiZ254L1NDTnJ3S0JnUURDd0pJQmxyYm01UU9objRJdHNvb0xjUkYrcDdlSmFyako1ZTFJL2JTQXFOMDRkSGZ4CkpKa2x6eDRtWlJBcTRkcDI2NWJ0MGNxNHZYTG1tTGJLdXBUTDcrRlhTRGQrTmRVZkdqWFA5TEZBQWVRSkVLZG8KS2MrajJhUWh4SUQ1TS8vUE1lbFNWTkFVUzZuS2VmL0JKNW5aZk5DeDJxRUdIeElOenJ5QkxrSnU0d0tCZ0UwVApESGNRcXFBRmNPckJJSjI0TnRnUGxVOWI4dTlzbHgzazZtN2VWcjFTdGttdkJUL09VMFEyUmZuSVpVaS9RZWdwCnIzMTUxTm5mWS93K09DY3YwdVRvSHpGb0JFS3pRalk4SCtlaCtOWHFnRWFQK005MVdwZFRab3E4OUhoaWVSNmsKRDI5UmpHNkhzUmZ6YTViKytPVU5aSEQ5M1p2R2w2MG1sYnJTMnRWRkFvR0JBUFdHMlVGUHBtbWd0UEM2aTBJQgpkdUV2SldpRTFNenRkcXp5TEszRk5PTldFeDlIU0svdHpDOWVwdTJxRFBzZ3lOeTgrSVczR1NBNUN6NGgzbFk4ClNOTDZzOEFheE5RWitPQ1V2UTNIUVdBb3pQSGQyUCtBM2FEc0JBeXN3MElCcDE0cVVBNlh6dEV1SHUyay9zN2UKdFF1czdadjFNS0Z0K0NUU20vdy9mOUcyCi0tLS0tRU5EIFBSSVZBVEUgS0VZLS0tLS0K',NULL,'2023-09-26 00:42:22'),(48,574445,'29747384','Luis','Alfonzo','Quevedo','Alfonzo','Masculino','luisquevedo@gmial.com',NULL,NULL,NULL,'Sector la paz','04120318406','$2y$10$RKC39J8p6vhPt05nbAzHpebnia3XfrOznRzcTRvGz0gvuN1qILEuG',NULL,NULL,NULL,NULL),(49,574445,'27830260','Maria','Jose','Diaz','Mendoza','Femenino','Mariajose@gmail.com','927fbeb13a26c05f5eb4fbd383c84ce9a3886b900d7b20eea1e56d82b24fff3f','2023-09-05 20:32:53',NULL,'Sector la carucieña','04120318406','$2y$10$RKC39J8p6vhPt05nbAzHpebnia3XfrOznRzcTRvGz0gvuN1qILEuG','LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUFtb3N4dW54WEtwVVdLL0dKTm9obQpMVUIzbHJXQml6aG1RUm5qVFhqN2JCUWNNTHVLMHNxbVdUZkZIVmE5aG5ZcFNuRmVyMWMwNEJYd2Zqa0M2a0t6Cms4VU1Ld3ZnODRVTVlVamlIOTdlVHJnamxWU3E1ZVIzWmJaRVZkd0JROWx5bmdnWmtVZ083K3MyaHZKcDhybVMKZGExUllobWllNGxMYVg3Y1BHRHZxM1lONEMyaE0yV3VkdWZQVGdKWmJoNldCbXhLay9CelQwT1E4ajdSN0hBSApCOStUNW9iYjZQZ0c1ZFZXZ00yRGR2MFVWTGdQR1h6Yi95SktaWlI3ODZRL3hsQ21DUkNOQ1VOcVV0OHYxcWM2CnYzZnJldmxMS2pqT00xaTVHOXpOZi9DemhGS1pDY1BLWTVwMVlTdU5PRHdqc1VVc0RsSzB5M1JMNWhQZkJKUEEKTFFJREFRQUIKLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0tCg==','LS0tLS1CRUdJTiBQUklWQVRFIEtFWS0tLS0tCk1JSUV2UUlCQURBTkJna3Foa2lHOXcwQkFRRUZBQVNDQktjd2dnU2pBZ0VBQW9JQkFRQ2Fpekc2ZkZjcWxSWXIKOFlrMmlHWXRRSGVXdFlHTE9HWkJHZU5OZVB0c0ZCd3d1NHJTeXFaWk44VWRWcjJHZGlsS2NWNnZWelRnRmZCKwpPUUxxUXJPVHhRd3JDK0R6aFF4aFNPSWYzdDVPdUNPVlZLcmw1SGRsdGtSVjNBRkQyWEtlQ0JtUlNBN3Y2emFHCjhtbnl1WkoxclZGaUdhSjdpVXRwZnR3OFlPK3JkZzNnTGFFelphNTI1ODlPQWxsdUhwWUdiRXFUOEhOUFE1RHkKUHRIc2NBY0gzNVBtaHR2bytBYmwxVmFBellOMi9SUlV1QThaZk52L0lrcGxsSHZ6cEQvR1VLWUpFSTBKUTJwUwozeS9XcHpxL2QrdDYrVXNxT000eldMa2IzTTEvOExPRVVwa0p3OHBqbW5WaEs0MDRQQ094UlN3T1VyVExkRXZtCkU5OEVrOEF0QWdNQkFBRUNnZ0VBSXcxY0w1aUJLc0xhM3dldklBUEs3UXVZdEVHaHlzSjFpdUdFeVM4ZUU1THkKRyttRm9LN2ZFUkJSc0loYWYxTndwUlpXcS8xakhFcE5uRXR4Q2xJcnFlSUJFd2hrTXNla0diS3V1eHpSSGxpcwpsWE81T1dCYTVtSnpXR2dJajJ1VUVCejFNNXI4N0ZUVXJzSHYzdUpSUWtpWDAyRE9GaWY3UjBmRFN4eVBiN3VCCjc2SnVSRzZIWEVJOUdoaUhtN3R6VXNzWFpObmg5cWhLRGtlYldJeit2ZnRrVFRWam4yOSsxR01HNURmU3d6czAKb2xDc1Y5cHNONlZmQldqYUtFTS9IeXZZbzE3YWQ5TXRsL0R4Y2NUSXVBbkpzbE5makdLdU5QYWNlVUxtc2N5OApoVUtqNFJHY2E2UFZxa0ZNeTg4RzNnRG5BckdEeE5rK0xuWlNFU09PQVFLQmdRRFpXcEJOVHJmR0xjL1J6cHN0ClZpV0NPcjQyK1NiaUVYV1U5WjhPS0RaSkpCSWRUNTRvd1JDU0hKVzQ1ckNHN01TQjV2Rlp5TDZ4RzJVN1gzSEMKZ3gvWjY0dENyMWxGeDJNU2FFUUdId1BReit1QnMvbHhVOGpjbkZyaHVmaUZUTkNEdzRwY1crVEVNeDczU2hudwpXSDZYMnJMcEJvcGpwcUhELzZPbmNMVlZBUUtCZ1FDMkJhb0tGdmpHcWFwc3V2ajBlb0FaUnRaemJpQVdJdHNuCjJjV214MXpjaVllb0Y5VFdQWmZ2d1VTNTBRRmpYM3dLM1JRSWpNODNZaGFFU1E0S0VEOGJMaXVZeFNYK2lyMjYKWmxheXFqb1ZNbDdrQ1R3bDdmNU5HUU9XQnJPOTdXL25IQlZIUUFLOEUrZ0RZNEtrTjZlR1NzWVZWRnhaOUpMMgppbmkzUFBqUExRS0JnRVZaOXpjamlkSExKa2RNaEFqb050bWh3cldwcy9Wb0dydG56OU5sazBTdEpMYURnL1IrCi9ibVJNMWluQ3VaU1A3VXZLZzA2MTFXTlp6U1ZsS2U2elB2c2d5Zkk2VlF4ZFhRWEhyVlJTaGRqY0VLWFdWMEcKbmMxK2VpVVNBTEVQdkd4K2hQUkpRZW8wWVlvSDg5VFRkN2tlUi8zQVg0SENWbFZDaVVaUTJSc0JBb0dBSlpqNwo2NE9kTldQY1dRTXg0MFhlYWRvdzk3emFrZGYzVHI3enphUkdjU05UU3d4SklVdXRzNDlIUTk2QkcrYWdONW84CnhodFh2Z2Zid00xYVFnZmpFUmt6VmlYNjJCNE9YSTlBL3p5Y0xMNnZ6UWgvVFJKZ3djb1Y3SXBMM0VKTUovK3MKQVlDZVQvMElvcEtPYko4MlVrM2xwb2c3WHpWZW1lQTJXUnNXQmEwQ2dZRUFsTlN3ZVlmQUdlN2Fxdy9Pa3V0MAowNXRzQ1gwemtXTlo2TjZPa3FyNm5EeUtWaTZJQ1lzcXYvUXp1QTBoQkZvV2JyVEQ1YWp2YkRzb1luQWVHU1QwCkFZbitpUkgwVFF2Wm11SzhLdGFUSno2ZnB4OTY1bDRDWlRTUW1vaHYreFRrMFJucXEvNzd6WXhIMkJXMk5rL0cKeHcwbjNwVzJNd1QrRmV5THpoTjVtWUE9Ci0tLS0tRU5EIFBSSVZBVEUgS0VZLS0tLS0K',NULL,NULL),(50,574445,'12431887','Danny','','Vasquez','','Masculino','dannyvasquez@gmail.com','56f1a990ee565974443f607bfdc61bc4c0fbd7c49f83813d7cecd24b6a2e8319','2023-09-05 21:28:41',NULL,'Carrera 15 con calle 57','04120318406','$2y$10$la5Aw/NdMSMD9r7qp2vkd.Z4TjjEMZvlibxOT8Uc/cuaG7oNZp.wa','LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUF3TDZGNmM0d2lYRWFKQ3RmMWt1UApHODU1dTlvYVZPS1ZRSldlQzZCTTFFL1lxN2l5T1lZUUsvNmFCT2J6d2ZmUEI3aDFGSzU4NklTQjRHUUZNU2VuCnloTGprbDhUY3BLN2ptUjNuQ1Q3MjlaM2wvOVJyU2trZ3lRdUoyOStjZGwxRFFkYkJzeHVsRGhpcE1ycExvcTkKSjFQQ1ZoNzJtZnZjNHBwMkg0c0NsWGRHeTA1UUtuSFVmREtGdW5lNkYrcDk2Z1hUN25WdFkvRUJYdEZMTm1GcgpvTTY0bU9HSHMrakM5YStWRlhpM1Jhbk1Ia3RKOENNQzIwem1HRlJBTnZuT0gxS25VT0NwVXZlRFRQbi9nWEY4CjRhYTRVNks0Rit6VEFyNE80cXNPa0NoOVNlc25KSnZTMkt2NkVPRlRLVFVnenIrRVl0OTIyNis3bVYxNUxYeFQKalFJREFRQUIKLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0tCg==','LS0tLS1CRUdJTiBQUklWQVRFIEtFWS0tLS0tCk1JSUV2UUlCQURBTkJna3Foa2lHOXcwQkFRRUZBQVNDQktjd2dnU2pBZ0VBQW9JQkFRREF2b1hwempDSmNSb2sKSzEvV1M0OGJ6bm03MmhwVTRwVkFsWjRMb0V6VVQ5aXJ1TEk1aGhBci9wb0U1dlBCOTg4SHVIVVVybnpvaElIZwpaQVV4SjZmS0V1T1NYeE55a3J1T1pIZWNKUHZiMW5lWC8xR3RLU1NESkM0bmIzNXgyWFVOQjFzR3pHNlVPR0trCnl1a3VpcjBuVThKV0h2YVorOXppbW5ZZml3S1ZkMGJMVGxBcWNkUjhNb1c2ZDdvWDZuM3FCZFB1ZFcxajhRRmUKMFVzMllXdWd6cmlZNFllejZNTDFyNVVWZUxkRnFjd2VTMG53SXdMYlRPWVlWRUEyK2M0ZlVxZFE0S2xTOTROTQorZitCY1h6aHByaFRvcmdYN05NQ3ZnN2lxdzZRS0gxSjZ5Y2ttOUxZcS9vUTRWTXBOU0RPdjRSaTMzYmJyN3VaClhYa3RmRk9OQWdNQkFBRUNnZ0VBWFhDZjVBS1pKakJtSDIzRnB0SjNuTi9peFM2TmdHUmVQZktxclhFM2ZkLzkKcHZaQnRNQm8rNk1RME5xVUJvOVgxeUxWNDhKWmZMR3NjdmVhU3NPeVJMVVdqVUc1WUZ5QlA1MDJIVVVTc25kTgpBQ3QvVWFhMTlEdW9nbWE3VW44OUR5Vm5QQ3NFV3FmaExvbk9OTWwrdk4rT3dZaCtQWlZMOXJFeUhjV2E2WkVUCmtSazhDb04rZUxTdGlUMVRSeE93alZPQTZ6N1VWOXk2bEZFSDlrb3kxcUdQc1NNemVhbHJOMUhoQStBTGRENlcKNXpRME5rR0xmVjZHNWFiZjllUVZXbFV5VGM1M3dCeCtLTTlGWUF4TkxrS3JmRmR0c3h5RVRGZnJjVTNjRGo2dAoxSnhyWVNybUtYSmdFQnRPTWV1NTkvcWpuVTRoYXlDZFdaOGVudm9xRXdLQmdRRFhyRldEbm1DT3hYRVNrRlVuCmdFblIwS3VITFpHZlpSUit3ckF6Q3djVk1Zd29MSGJqVVoreTFTVWhrVDFsbk45MWx3b0RkRTlqeWNrK1hWRzUKNHRhd0M3REpaWkVBck1GSFdOSm9XSTZxVXZBSXhpQXlUUEJWZ0MvVjVFazYwTC96bHpnbFlJTk41b2haZnBPQQpMYTI0SS9GOW01L2dMMUQ1d3FoU2FPL29Od0tCZ1FEa3lLVWc0UnhHWnJUMWIzcTBzRVNReHByODNucXFTb05UCmFabDk3T1hLMnZRdGh4bVhLSmtzQ0UrZzV3K1pwSjNCSks2b05MQkpmbm5vVDJwWFZMaVRJeUowdTJnc1lxT3YKZ2lsRjQ0cWNXNk5hanNta1l4WXV0Vm8vek8wMEdFYnMzaXZ5VWFvWW9DaFFCMHpzWGJERTRsRDZEMWhpUXREdgp5ZmNCKy8xNFd3S0JnSDRUZ1IzaTdLRXBiSE1rcXBMZjNNZHBpNHdIS0hTY1cwSEt2OFBtODJvQlArU1FNYU9yCktJY2JNSXlSNGVsUHJoV0lpTk1DSUJLK2VBVWIrbFdHOUdlUFBmWk5pRmx6bzd6NGdHOTlMVkVHRU1tZ1FGd0gKUEF0UFZ5ZGJQeS9CcmlSUXh3S2FpOGR6TjB2Undab1JtZGJtTkJwd2FpSmNwcUtLbDJrdGJPazdBb0dBVGQ4cApyWlpSekhpN0VXdGZoYzhWbDMyeVZXM1lyTXZ1QlY5Rk9vSisrTndzRHE4VWU4bjYwTzBIUllwQVdoaVpCWnZaCnd6RWo2L0FieUlIM2ZVQStEdjcvaEdJaHBESHk2eE5QdnhVaklmTmpGN2pRVTU3U2R4V05ZWGY4S1NZMlJmdWQKVTc2T09oR1JoeVBrLy9Nbjd1dmxpaWZjK3AwcGh1VGtxWTAvQ2s4Q2dZRUFuYmJFS1NGMUxWb0FTVEtYcVY1aQovUkFWQVcyQ1lRSE4wVkU1YmxNamY3dDRPd2FGcm9TRStnQzEzVXN2RmhTYzZEYlI1N2grRnkwWGhqUUJWbksxCm5XOWhjTVdZTFJXSW5KUDZSN3p5Z3BKSXdoVVpRRmZBTmtkRGFGdURoTlpRNi94SSsrZXJpTlB6bDlhSGZMRjcKSHQwRzdsNU9TVFdxMEZrREwyTE1VR0k9Ci0tLS0tRU5EIFBSSVZBVEUgS0VZLS0tLS0K',NULL,'2023-09-05 20:28:42'),(51,575162,'9324325','José','Manuel','Rodríguez','Gómez','Masculino','joserdiaz@gmail.com',NULL,NULL,NULL,'','04120318406','$2y$10$7Tyk085X0Nh0gKTmRrdvLuMLpx6zHqjCZbmkgmEoZy3I8F8McF38q',NULL,NULL,NULL,NULL),(58,573608,'10475729','Reina','Evelinda','Páez','','Femenino','cesaralejandrovides2@gmail.com',NULL,NULL,NULL,'','04120318406','$2y$10$QpbOpF5ikcow7tfhPURtyuGXD4xQhG2WqvPiBEVx/AXSv5MJpz.oq',NULL,NULL,NULL,NULL),(79,573666,'28055659','Cesar','Alejandro','Vides','Alejandro','Masculino','cesaralejandrovides2@gmail.com',NULL,NULL,NULL,'Urbanizacion Yucatan','04120318406','$2y$10$yiNG6W9AtBqalVwoDEeMH.Dbo97IFHcxq78OXhMMe8EZSMqoiI.tu',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_roles`
--

DROP TABLE IF EXISTS `usuarios_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`id_usuario`),
  KEY `idrol` (`id_rol`),
  CONSTRAINT `usuarios_roles_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `usuarios_roles_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_roles`
--

LOCK TABLES `usuarios_roles` WRITE;
/*!40000 ALTER TABLE `usuarios_roles` DISABLE KEYS */;
INSERT INTO `usuarios_roles` VALUES (152,46,1),(154,48,7),(174,49,5),(175,48,1),(176,49,1),(177,50,1),(178,51,7),(179,58,7),(180,79,5);
/*!40000 ALTER TABLE `usuarios_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vista_usuario`
--

DROP TABLE IF EXISTS `vista_usuario`;
/*!50001 DROP VIEW IF EXISTS `vista_usuario`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vista_usuario` (
  `id` tinyint NOT NULL,
  `cedula` tinyint NOT NULL,
  `primer_nombre` tinyint NOT NULL,
  `segundo_nombre` tinyint NOT NULL,
  `primer_apellido` tinyint NOT NULL,
  `segundo_apellido` tinyint NOT NULL,
  `genero` tinyint NOT NULL,
  `correo` tinyint NOT NULL,
  `direccion` tinyint NOT NULL,
  `telefono` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vista_usuario`
--

/*!50001 DROP TABLE IF EXISTS `vista_usuario`*/;
/*!50001 DROP VIEW IF EXISTS `vista_usuario`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_usuario` AS select `usuario`.`id` AS `id`,`usuario`.`cedula` AS `cedula`,`usuario`.`primer_nombre` AS `primer_nombre`,`usuario`.`segundo_nombre` AS `segundo_nombre`,`usuario`.`primer_apellido` AS `primer_apellido`,`usuario`.`segundo_apellido` AS `segundo_apellido`,`usuario`.`genero` AS `genero`,`usuario`.`correo` AS `correo`,`usuario`.`direccion` AS `direccion`,`usuario`.`telefono` AS `telefono` from `usuario` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-29  1:02:40
