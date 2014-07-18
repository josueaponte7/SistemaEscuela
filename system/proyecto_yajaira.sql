-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.0.10-MariaDB-1~squeeze-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema proyecto_yajaira
--

CREATE DATABASE IF NOT EXISTS proyecto_yajaira;
USE proyecto_yajaira;

--
-- Definition of table `proyecto_yajaira`.`acceso_alimentacion`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`acceso_alimentacion`;
CREATE TABLE  `proyecto_yajaira`.`acceso_alimentacion` (
  `id_acceso` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_acceso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_acceso`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`acceso_alimentacion`
--

/*!40000 ALTER TABLE `acceso_alimentacion` DISABLE KEYS */;
LOCK TABLES `acceso_alimentacion` WRITE;
INSERT INTO `proyecto_yajaira`.`acceso_alimentacion` VALUES  (1,'Siempre'),
 (2,'Ocasionalmente'),
 (3,'Fácilmente'),
 (4,'Difícilmente');
UNLOCK TABLES;
/*!40000 ALTER TABLE `acceso_alimentacion` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`actividad`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`actividad`;
CREATE TABLE  `proyecto_yajaira`.`actividad` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `actividad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`actividad`
--

/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
LOCK TABLES `actividad` WRITE;
INSERT INTO `proyecto_yajaira`.`actividad` VALUES  (1,'Madera','Realizar actividad de Carpinteria'),
 (2,'Peluqueria','Corte de cabello y secado'),
 (3,'Electricidad','Instalación electrica');
UNLOCK TABLES;
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`actividad_docente`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`actividad_docente`;
CREATE TABLE  `proyecto_yajaira`.`actividad_docente` (
  `id_actividad` int(11) DEFAULT NULL,
  `cedula_docente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`actividad_docente`
--

/*!40000 ALTER TABLE `actividad_docente` DISABLE KEYS */;
LOCK TABLES `actividad_docente` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `actividad_docente` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`actividad_estudiante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`actividad_estudiante`;
CREATE TABLE  `proyecto_yajaira`.`actividad_estudiante` (
  `id_actividad` int(11) DEFAULT NULL,
  `cedula_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`actividad_estudiante`
--

/*!40000 ALTER TABLE `actividad_estudiante` DISABLE KEYS */;
LOCK TABLES `actividad_estudiante` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `actividad_estudiante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`alimentacion_regular`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`alimentacion_regular`;
CREATE TABLE  `proyecto_yajaira`.`alimentacion_regular` (
  `id_regular` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_regular` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_regular`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`alimentacion_regular`
--

/*!40000 ALTER TABLE `alimentacion_regular` DISABLE KEYS */;
LOCK TABLES `alimentacion_regular` WRITE;
INSERT INTO `proyecto_yajaira`.`alimentacion_regular` VALUES  (1,'Una vez'),
 (2,'Dos Veces'),
 (3,'Tres Veces'),
 (4,'Solo'),
 (5,'Con Ayuda');
UNLOCK TABLES;
/*!40000 ALTER TABLE `alimentacion_regular` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`amerita_ayuda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`amerita_ayuda`;
CREATE TABLE  `proyecto_yajaira`.`amerita_ayuda` (
  `id_ayuda` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ayuda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_ayuda`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`amerita_ayuda`
--

/*!40000 ALTER TABLE `amerita_ayuda` DISABLE KEYS */;
LOCK TABLES `amerita_ayuda` WRITE;
INSERT INTO `proyecto_yajaira`.`amerita_ayuda` VALUES  (1,'Vestirse'),
 (2,'Ir al Baño'),
 (3,'Asearse'),
 (4,'Subir o Bajar Escalones');
UNLOCK TABLES;
/*!40000 ALTER TABLE `amerita_ayuda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`anio_escolar`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`anio_escolar`;
CREATE TABLE  `proyecto_yajaira`.`anio_escolar` (
  `id_anio` int(11) NOT NULL AUTO_INCREMENT,
  `anio_escolar` year(4) DEFAULT NULL,
  PRIMARY KEY (`id_anio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`anio_escolar`
--

/*!40000 ALTER TABLE `anio_escolar` DISABLE KEYS */;
LOCK TABLES `anio_escolar` WRITE;
INSERT INTO `proyecto_yajaira`.`anio_escolar` VALUES  (1,2011),
 (2,2012),
 (3,2013),
 (4,2014);
UNLOCK TABLES;
/*!40000 ALTER TABLE `anio_escolar` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`anioescolar_estudiante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`anioescolar_estudiante`;
CREATE TABLE  `proyecto_yajaira`.`anioescolar_estudiante` (
  `id_anio` int(11) DEFAULT NULL,
  `cedula_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`anioescolar_estudiante`
--

/*!40000 ALTER TABLE `anioescolar_estudiante` DISABLE KEYS */;
LOCK TABLES `anioescolar_estudiante` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `anioescolar_estudiante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`automovil`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`automovil`;
CREATE TABLE  `proyecto_yajaira`.`automovil` (
  `placa` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `modelo` text COLLATE utf8_spanish_ci,
  `color` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cedula_chofer` int(11) DEFAULT NULL,
  PRIMARY KEY (`placa`),
  KEY `cedula_chofer` (`cedula_chofer`),
  CONSTRAINT `automovil_ibfk_1` FOREIGN KEY (`cedula_chofer`) REFERENCES `chofer` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`automovil`
--

/*!40000 ALTER TABLE `automovil` DISABLE KEYS */;
LOCK TABLES `automovil` WRITE;
INSERT INTO `proyecto_yajaira`.`automovil` VALUES  ('14MBGD12','Fiat','Verde Agua',13575772),
 ('GF54HY','Fiat','Azul',22859393),
 ('HG56GD','Fiat','Azul',7186419),
 ('MIYB125P','Fiat','Azul y Rojo',22589393),
 ('MJ566MNM','FIAT','Azul',25698777),
 ('MY125OK','For','Amarillo',15649504);
UNLOCK TABLES;
/*!40000 ALTER TABLE `automovil` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`ayuda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`ayuda`;
CREATE TABLE  `proyecto_yajaira`.`ayuda` (
  `cod_ayuda` int(11) NOT NULL AUTO_INCREMENT,
  `ayuda` varchar(30) DEFAULT NULL COMMENT 'nombre de la ayuda',
  PRIMARY KEY (`cod_ayuda`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proyecto_yajaira`.`ayuda`
--

/*!40000 ALTER TABLE `ayuda` DISABLE KEYS */;
LOCK TABLES `ayuda` WRITE;
INSERT INTO `proyecto_yajaira`.`ayuda` VALUES  (1,'Finaciera'),
 (2,'Medica'),
 (3,'T&eacute;cnica');
UNLOCK TABLES;
/*!40000 ALTER TABLE `ayuda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`chofer`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`chofer`;
CREATE TABLE  `proyecto_yajaira`.`chofer` (
  `nacionalidad` int(11) DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` text COLLATE utf8_spanish_ci,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_celular` int(11) DEFAULT NULL,
  `celular` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`chofer`
--

/*!40000 ALTER TABLE `chofer` DISABLE KEYS */;
LOCK TABLES `chofer` WRITE;
INSERT INTO `proyecto_yajaira`.`chofer` VALUES  (1,7186419,'maria','linares','sfdjsfgb',1,'4545676',4,'2222222'),
 (2,13575772,'yergiroska','aguirre ','yergiroska@gmail.com',1,'2677735',6,'3255148'),
 (1,15649504,'Luis ','Perez Gomez','luisp@hotmail.com',1,'2677735',6,'3255148'),
 (1,22589393,'carmen luisa','ruiz romero','carmen@.com',1,'2677557',5,'2563695'),
 (1,22859393,'camien ','aponte','carmen@gmail.com',1,'4546467',4,'4654656'),
 (1,25698777,'carlos','colmenares','carlos@gmail.com',1,'2521545',4,'5121212');
UNLOCK TABLES;
/*!40000 ALTER TABLE `chofer` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`chofer_estudiante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`chofer_estudiante`;
CREATE TABLE  `proyecto_yajaira`.`chofer_estudiante` (
  `cedula_chofer` int(11) DEFAULT NULL,
  `cedula_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`chofer_estudiante`
--

/*!40000 ALTER TABLE `chofer_estudiante` DISABLE KEYS */;
LOCK TABLES `chofer_estudiante` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `chofer_estudiante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`ciudad`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`ciudad`;
CREATE TABLE  `proyecto_yajaira`.`ciudad` (
  `id_ciudad` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `nombre_ciudad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`ciudad`
--

/*!40000 ALTER TABLE `ciudad` DISABLE KEYS */;
LOCK TABLES `ciudad` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `ciudad` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`codigo_telefono`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`codigo_telefono`;
CREATE TABLE  `proyecto_yajaira`.`codigo_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`codigo_telefono`
--

/*!40000 ALTER TABLE `codigo_telefono` DISABLE KEYS */;
LOCK TABLES `codigo_telefono` WRITE;
INSERT INTO `proyecto_yajaira`.`codigo_telefono` VALUES  (1,'0243',1),
 (2,'0244',1),
 (4,'0412',2),
 (5,'0416',2),
 (6,'0424',2),
 (7,'0414',2);
UNLOCK TABLES;
/*!40000 ALTER TABLE `codigo_telefono` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`concepto_ingreso`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`concepto_ingreso`;
CREATE TABLE  `proyecto_yajaira`.`concepto_ingreso` (
  `id_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ingreso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_ingreso`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`concepto_ingreso`
--

/*!40000 ALTER TABLE `concepto_ingreso` DISABLE KEYS */;
LOCK TABLES `concepto_ingreso` WRITE;
INSERT INTO `proyecto_yajaira`.`concepto_ingreso` VALUES  (1,'Trabajo Formal'),
 (2,'Trabajo Informal'),
 (3,'Pensión IVSS'),
 (4,'Asignacion de Misiones'),
 (5,'Becas'),
 (6,'Pensión Alimentaria');
UNLOCK TABLES;
/*!40000 ALTER TABLE `concepto_ingreso` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`destrezas_habilidades`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`destrezas_habilidades`;
CREATE TABLE  `proyecto_yajaira`.`destrezas_habilidades` (
  `id_destreza` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_destreza` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_destreza`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`destrezas_habilidades`
--

/*!40000 ALTER TABLE `destrezas_habilidades` DISABLE KEYS */;
LOCK TABLES `destrezas_habilidades` WRITE;
INSERT INTO `proyecto_yajaira`.`destrezas_habilidades` VALUES  (1,'Artesanales'),
 (2,'Deportivas'),
 (3,'Culturales'),
 (4,'Cocina'),
 (5,'Agrícolas'),
 (6,'Tecnológicas');
UNLOCK TABLES;
/*!40000 ALTER TABLE `destrezas_habilidades` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`diversidad_funcional`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`diversidad_funcional`;
CREATE TABLE  `proyecto_yajaira`.`diversidad_funcional` (
  `id_diversidad` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_diversidad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_diversidad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`diversidad_funcional`
--

/*!40000 ALTER TABLE `diversidad_funcional` DISABLE KEYS */;
LOCK TABLES `diversidad_funcional` WRITE;
INSERT INTO `proyecto_yajaira`.`diversidad_funcional` VALUES  (1,'Compromiso Cognitivo'),
 (2,'Impedimento Físico'),
 (3,'Deficiencias Visuales'),
 (4,'Deficiencias Auditivas'),
 (5,'Autismo'),
 (6,'Lenguaje');
UNLOCK TABLES;
/*!40000 ALTER TABLE `diversidad_funcional` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`docente`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`docente`;
CREATE TABLE  `proyecto_yajaira`.`docente` (
  `nacionalidad` int(11) DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fech_naci` date DEFAULT NULL,
  `lugar_naci` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` int(1) DEFAULT '0',
  `calle` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `casa` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `edificio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `barrio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_celular` int(11) DEFAULT NULL,
  `celular` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_parroquia` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `id_actividad` int(11) DEFAULT NULL,
  PRIMARY KEY (`cedula`),
  KEY `nacionalidad` (`nacionalidad`),
  KEY `cod_telefono` (`cod_telefono`),
  KEY `cod_celular` (`cod_celular`),
  KEY `id_parroquia` (`id_parroquia`),
  CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`nacionalidad`) REFERENCES `nacionalidad` (`id_nacionalidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `docente_ibfk_2` FOREIGN KEY (`cod_telefono`) REFERENCES `codigo_telefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `docente_ibfk_3` FOREIGN KEY (`cod_celular`) REFERENCES `codigo_telefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `docente_ibfk_4` FOREIGN KEY (`id_parroquia`) REFERENCES `parroquia` (`id_parroquia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`docente`
--

/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
LOCK TABLES `docente` WRITE;
INSERT INTO `proyecto_yajaira`.`docente` VALUES  (1,13575772,'maria','lara ruiz','mariala.com','1960-05-17','maracay',1,'suvre','36','no','la pica',1,'2677557',4,'6690401',2,1,3),
 (1,13575775,'yergiroska','aguirre','yergi@fgh.com','1977-04-24','mariara',1,'ghfhgh','ghghg','ghhgh','hghghg',1,'5465564',4,'3323321',2,1,3),
 (1,14659825,'luis','morales','dsgdgdgfg@gg.com','1978-07-12','cagua',2,'gfgfgf','gfgfgfg','fgfgfg','gfgfgf',1,'5456445',4,'2212151',2,1,2),
 (1,15649504,'joanlit del carmen','aponte  segovia','yolilipu@gmail.com','1982-11-30','españa',1,'orinoco','no ','edificio numero 04','la pica',1,'2677557',4,'6690401',4,1,2),
 (1,15649505,'josue','aponte','josueaponte7@gmail.com','1994-05-18','gfdfgdgdgfdg',2,'dfgd','dfgdg','dfgdg','dfgdgdgd',1,'2677532',4,'1417532',2,1,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_alimentacion`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_alimentacion`;
CREATE TABLE  `proyecto_yajaira`.`dt_alimentacion` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_acceso` int(11) DEFAULT NULL,
  `id_regular` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_alimentacion`
--

/*!40000 ALTER TABLE `dt_alimentacion` DISABLE KEYS */;
LOCK TABLES `dt_alimentacion` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_alimentacion` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_ayuda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_ayuda`;
CREATE TABLE  `proyecto_yajaira`.`dt_ayuda` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_ayuda` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_ayuda`
--

/*!40000 ALTER TABLE `dt_ayuda` DISABLE KEYS */;
LOCK TABLES `dt_ayuda` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_ayuda` VALUES  (22958393,4);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_ayuda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_destreza`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_destreza`;
CREATE TABLE  `proyecto_yajaira`.`dt_destreza` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_destreza` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_destreza`
--

/*!40000 ALTER TABLE `dt_destreza` DISABLE KEYS */;
LOCK TABLES `dt_destreza` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_destreza` VALUES  (22958393,1),
 (22958393,3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_destreza` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_diversidad`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_diversidad`;
CREATE TABLE  `proyecto_yajaira`.`dt_diversidad` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `alimentacion` int(11) DEFAULT NULL,
  `alimentacion_regular` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_diversidad`
--

/*!40000 ALTER TABLE `dt_diversidad` DISABLE KEYS */;
LOCK TABLES `dt_diversidad` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_diversidad` VALUES  (22958393,1,3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_diversidad` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_diversidad_funcional`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_diversidad_funcional`;
CREATE TABLE  `proyecto_yajaira`.`dt_diversidad_funcional` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_diversidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_diversidad_funcional`
--

/*!40000 ALTER TABLE `dt_diversidad_funcional` DISABLE KEYS */;
LOCK TABLES `dt_diversidad_funcional` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_diversidad_funcional` VALUES  (22958393,5);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_diversidad_funcional` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_enfermedad`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_enfermedad`;
CREATE TABLE  `proyecto_yajaira`.`dt_enfermedad` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_enfermedades` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_enfermedad`
--

/*!40000 ALTER TABLE `dt_enfermedad` DISABLE KEYS */;
LOCK TABLES `dt_enfermedad` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_enfermedad` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_ingreso_familiar`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_ingreso_familiar`;
CREATE TABLE  `proyecto_yajaira`.`dt_ingreso_familiar` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_ingreso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_ingreso_familiar`
--

/*!40000 ALTER TABLE `dt_ingreso_familiar` DISABLE KEYS */;
LOCK TABLES `dt_ingreso_familiar` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_ingreso_familiar` VALUES  (22958393,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_ingreso_familiar` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_padres`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_padres`;
CREATE TABLE  `proyecto_yajaira`.`dt_padres` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `padre_f` int(1) DEFAULT '0',
  `madre_f` int(1) DEFAULT '0',
  `padre_pl` int(1) DEFAULT '0',
  `madre_pl` int(1) DEFAULT '0',
  `padre_al` int(1) DEFAULT '0',
  `madre_al` int(2) DEFAULT '0',
  `represent_al` int(2) DEFAULT '0',
  `padre_fd` int(1) DEFAULT '0',
  `madre_fd` int(1) DEFAULT '0',
  `represent_fd` int(1) DEFAULT '0',
  `padre_alf` varchar(2) DEFAULT '0',
  `madre_alf` varchar(2) DEFAULT '0',
  `represent_alf` varchar(2) DEFAULT '0',
  `padre_nivel` int(11) DEFAULT '0',
  `madre_nivel` int(11) DEFAULT '0',
  `represent_nivel` int(11) DEFAULT '0',
  `padre_set` int(1) DEFAULT '0',
  `madre_set` int(1) DEFAULT '0',
  `padre_see` int(1) DEFAULT '0',
  `madre_see` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_padres`
--

/*!40000 ALTER TABLE `dt_padres` DISABLE KEYS */;
LOCK TABLES `dt_padres` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_padres` VALUES  (22958393,0,0,0,0,0,0,0,0,0,0,'si','si','si',2,3,4,1,2,1,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_padres` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_padres2`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_padres2`;
CREATE TABLE  `proyecto_yajaira`.`dt_padres2` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `fallecidos` int(11) DEFAULT '0',
  `privados_liber` int(11) DEFAULT '0',
  `alcoholicos` int(11) DEFAULT '0',
  `farmaco_dep` int(11) DEFAULT '0',
  `alfabetas` int(11) DEFAULT '0',
  `analfabetas` int(11) DEFAULT '0',
  `nivel_instruccion` int(11) DEFAULT '0',
  `trabajan` int(11) DEFAULT '0',
  `estudiante` int(11) DEFAULT '0',
  `ingreso_familiar` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_padres2`
--

/*!40000 ALTER TABLE `dt_padres2` DISABLE KEYS */;
LOCK TABLES `dt_padres2` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_padres2` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_programa_social`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_programa_social`;
CREATE TABLE  `proyecto_yajaira`.`dt_programa_social` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_programa_social`
--

/*!40000 ALTER TABLE `dt_programa_social` DISABLE KEYS */;
LOCK TABLES `dt_programa_social` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_programa_social` VALUES  (22958393,13);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_programa_social` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_servicio`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_servicio`;
CREATE TABLE  `proyecto_yajaira`.`dt_servicio` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_servicio`
--

/*!40000 ALTER TABLE `dt_servicio` DISABLE KEYS */;
LOCK TABLES `dt_servicio` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_servicio` VALUES  (22958393,2);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_servicio` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_tecnologia`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_tecnologia`;
CREATE TABLE  `proyecto_yajaira`.`dt_tecnologia` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_tecnologia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_tecnologia`
--

/*!40000 ALTER TABLE `dt_tecnologia` DISABLE KEYS */;
LOCK TABLES `dt_tecnologia` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_tecnologia` VALUES  (22958393,1),
 (22958393,3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_tecnologia` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`dt_vivienda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`dt_vivienda`;
CREATE TABLE  `proyecto_yajaira`.`dt_vivienda` (
  `cedula_estudiante` int(11) DEFAULT '0',
  `ubicacion_vivienda` int(11) DEFAULT '0',
  `tipo_vivienda` int(11) DEFAULT '0',
  `estado_vivienda` int(11) DEFAULT '0',
  `cant_habitacion` int(11) DEFAULT '0',
  `cama` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`dt_vivienda`
--

/*!40000 ALTER TABLE `dt_vivienda` DISABLE KEYS */;
LOCK TABLES `dt_vivienda` WRITE;
INSERT INTO `proyecto_yajaira`.`dt_vivienda` VALUES  (23658148,1,1,1,4,2),
 (15649505,1,1,1,0,2),
 (11111111,1,1,1,4,1),
 (22958393,2,2,1,3,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `dt_vivienda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`edo_civil`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`edo_civil`;
CREATE TABLE  `proyecto_yajaira`.`edo_civil` (
  `cod_civil` int(11) NOT NULL AUTO_INCREMENT,
  `edo_civil` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cod_civil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proyecto_yajaira`.`edo_civil`
--

/*!40000 ALTER TABLE `edo_civil` DISABLE KEYS */;
LOCK TABLES `edo_civil` WRITE;
INSERT INTO `proyecto_yajaira`.`edo_civil` VALUES  (1,'Soltero'),
 (2,'Casado'),
 (3,'Concubino'),
 (4,'Viudo'),
 (5,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `edo_civil` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`enfermedades`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`enfermedades`;
CREATE TABLE  `proyecto_yajaira`.`enfermedades` (
  `id_enfermedad` int(11) NOT NULL AUTO_INCREMENT,
  `enfermedad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_enfermedad`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`enfermedades`
--

/*!40000 ALTER TABLE `enfermedades` DISABLE KEYS */;
LOCK TABLES `enfermedades` WRITE;
INSERT INTO `proyecto_yajaira`.`enfermedades` VALUES  (1,'Respiratorias Crónicas'),
 (2,'Insuficiencia Renal'),
 (3,'Insuficiencia Cardíaca'),
 (4,'Diabetes'),
 (5,'Parálisis Cerebral'),
 (6,'Epilepsia'),
 (7,'Psiquiátricos'),
 (8,'Cáncer');
UNLOCK TABLES;
/*!40000 ALTER TABLE `enfermedades` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estado`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estado`;
CREATE TABLE  `proyecto_yajaira`.`estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estado`
--

/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
LOCK TABLES `estado` WRITE;
INSERT INTO `proyecto_yajaira`.`estado` VALUES  (1,'Aragua'),
 (2,'Carabobo'),
 (3,'Apure');
UNLOCK TABLES;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estado_vivienda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estado_vivienda`;
CREATE TABLE  `proyecto_yajaira`.`estado_vivienda` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado_vivienda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estado_vivienda`
--

/*!40000 ALTER TABLE `estado_vivienda` DISABLE KEYS */;
LOCK TABLES `estado_vivienda` WRITE;
INSERT INTO `proyecto_yajaira`.`estado_vivienda` VALUES  (1,'Buena'),
 (2,'Regular'),
 (3,'Satisfactoria'),
 (4,'Mala');
UNLOCK TABLES;
/*!40000 ALTER TABLE `estado_vivienda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estatus_chofer`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estatus_chofer`;
CREATE TABLE  `proyecto_yajaira`.`estatus_chofer` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estatus_chofer`
--

/*!40000 ALTER TABLE `estatus_chofer` DISABLE KEYS */;
LOCK TABLES `estatus_chofer` WRITE;
INSERT INTO `proyecto_yajaira`.`estatus_chofer` VALUES  (1,'Activo'),
 (2,'Inactivo');
UNLOCK TABLES;
/*!40000 ALTER TABLE `estatus_chofer` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estatus_docente`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estatus_docente`;
CREATE TABLE  `proyecto_yajaira`.`estatus_docente` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estatus_docente`
--

/*!40000 ALTER TABLE `estatus_docente` DISABLE KEYS */;
LOCK TABLES `estatus_docente` WRITE;
INSERT INTO `proyecto_yajaira`.`estatus_docente` VALUES  (1,'Activo'),
 (2,'Inactivo');
UNLOCK TABLES;
/*!40000 ALTER TABLE `estatus_docente` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estatus_estudiante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estatus_estudiante`;
CREATE TABLE  `proyecto_yajaira`.`estatus_estudiante` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estatus_estudiante`
--

/*!40000 ALTER TABLE `estatus_estudiante` DISABLE KEYS */;
LOCK TABLES `estatus_estudiante` WRITE;
INSERT INTO `proyecto_yajaira`.`estatus_estudiante` VALUES  (1,'Registrado'),
 (2,'Pre-Inscrito'),
 (3,'Inscrito'),
 (4,'En Reposo'),
 (5,'En Espera'),
 (6,'Suspendido'),
 (7,'Desmatriculado');
UNLOCK TABLES;
/*!40000 ALTER TABLE `estatus_estudiante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estatus_representante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estatus_representante`;
CREATE TABLE  `proyecto_yajaira`.`estatus_representante` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estatus_representante`
--

/*!40000 ALTER TABLE `estatus_representante` DISABLE KEYS */;
LOCK TABLES `estatus_representante` WRITE;
INSERT INTO `proyecto_yajaira`.`estatus_representante` VALUES  (1,'Firmante'),
 (2,'Absoluto'),
 (3,'Acompañante'),
 (4,'Fallecido'),
 (5,'Suspendido');
UNLOCK TABLES;
/*!40000 ALTER TABLE `estatus_representante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estudiante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estudiante`;
CREATE TABLE  `proyecto_yajaira`.`estudiante` (
  `nacionalidad` int(11) DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` text COLLATE utf8_spanish_ci,
  `fech_naci` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lugar_naci` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` int(1) DEFAULT '0',
  `calle` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `casa` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `edificio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `barrio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_celular` int(11) DEFAULT NULL,
  `celular` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_parroquia` int(11) DEFAULT NULL,
  `id_estatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`cedula`),
  KEY `cod_habitacion` (`cod_telefono`),
  KEY `cod_celular` (`cod_celular`),
  KEY `id_parroquia` (`id_parroquia`),
  KEY `nacionalidad` (`nacionalidad`),
  KEY `id_estatus` (`id_estatus`),
  CONSTRAINT `estudiante_ibfk_3` FOREIGN KEY (`id_parroquia`) REFERENCES `parroquia` (`id_parroquia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiante_ibfk_4` FOREIGN KEY (`nacionalidad`) REFERENCES `nacionalidad` (`id_nacionalidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiante_ibfk_5` FOREIGN KEY (`cod_telefono`) REFERENCES `codigo_telefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiante_ibfk_6` FOREIGN KEY (`cod_celular`) REFERENCES `codigo_telefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiante_ibfk_7` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_estudiante` (`id_estatus`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estudiante`
--

/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
LOCK TABLES `estudiante` WRITE;
INSERT INTO `proyecto_yajaira`.`estudiante` VALUES  (1,11111111,'ggfgggfggg','fghghfgffff','jjjj@gmail.com','1999-07-13','ggggggggggggggg',2,'yyyyyyy','hhhhhh','jjjjj','fffffff',1,'1233211',4,'2434424',2,3),
 (1,22958393,'carmen','silva','ghghgh@dhg.com','1996-07-18','maracay',1,'sucre','casa numero 48','hghghgh','libertador',1,'2154544',4,'5454548',2,3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`estudiante_representante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`estudiante_representante`;
CREATE TABLE  `proyecto_yajaira`.`estudiante_representante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_estudiante` int(11) DEFAULT NULL,
  `cedula_representante` int(11) DEFAULT NULL,
  `parentesco` int(11) DEFAULT NULL,
  `representante` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cedula_representante` (`cedula_representante`),
  KEY `cedula_estudiante` (`cedula_estudiante`),
  CONSTRAINT `estudiante_representante_ibfk_1` FOREIGN KEY (`cedula_representante`) REFERENCES `representante` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiante_representante_ibfk_2` FOREIGN KEY (`cedula_estudiante`) REFERENCES `estudiante` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`estudiante_representante`
--

/*!40000 ALTER TABLE `estudiante_representante` DISABLE KEYS */;
LOCK TABLES `estudiante_representante` WRITE;
INSERT INTO `proyecto_yajaira`.`estudiante_representante` VALUES  (73,11111111,15649505,1,1),
 (74,22958393,15649505,5,0),
 (75,22958393,12569325,3,0),
 (76,22958393,7186419,1,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `estudiante_representante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`grupo_usuario`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`grupo_usuario`;
CREATE TABLE  `proyecto_yajaira`.`grupo_usuario` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`grupo_usuario`
--

/*!40000 ALTER TABLE `grupo_usuario` DISABLE KEYS */;
LOCK TABLES `grupo_usuario` WRITE;
INSERT INTO `proyecto_yajaira`.`grupo_usuario` VALUES  (1,'Administrador'),
 (2,'Informatica'),
 (3,'Reporte');
UNLOCK TABLES;
/*!40000 ALTER TABLE `grupo_usuario` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`historial_inscripcion`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`historial_inscripcion`;
CREATE TABLE  `proyecto_yajaira`.`historial_inscripcion` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `id_anio` int(11) DEFAULT NULL,
  `id_actividad` int(11) DEFAULT NULL,
  `area_descripcion` text,
  `cedula_representante` int(11) DEFAULT NULL,
  `id_medio` int(11) DEFAULT NULL,
  `cedula_chofer` int(11) DEFAULT NULL,
  KEY `cedula_estudiante` (`cedula_estudiante`),
  KEY `id_anio` (`id_anio`),
  CONSTRAINT `historial_inscripcion_ibfk_1` FOREIGN KEY (`cedula_estudiante`) REFERENCES `inscripcion` (`cedula_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `historial_inscripcion_ibfk_2` FOREIGN KEY (`id_anio`) REFERENCES `anio_escolar` (`id_anio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`historial_inscripcion`
--

/*!40000 ALTER TABLE `historial_inscripcion` DISABLE KEYS */;
LOCK TABLES `historial_inscripcion` WRITE;
INSERT INTO `proyecto_yajaira`.`historial_inscripcion` VALUES  (22958393,'2014-07-17',4,3,'cableado',7186419,3,13575772);
UNLOCK TABLES;
/*!40000 ALTER TABLE `historial_inscripcion` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`inscripcion`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`inscripcion`;
CREATE TABLE  `proyecto_yajaira`.`inscripcion` (
  `cedula_estudiante` int(11) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `id_anio` int(11) DEFAULT NULL,
  `id_actividad` int(11) DEFAULT NULL,
  `area_descripcion` text,
  `cedula_representante` int(11) DEFAULT NULL,
  `id_medio` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `tipo` varchar(15) DEFAULT NULL,
  `cedula_chofer` int(11) DEFAULT NULL,
  PRIMARY KEY (`cedula_estudiante`),
  KEY `id_anio` (`id_anio`),
  CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`id_anio`) REFERENCES `anio_escolar` (`id_anio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`inscripcion`
--

/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
LOCK TABLES `inscripcion` WRITE;
INSERT INTO `proyecto_yajaira`.`inscripcion` VALUES  (11111111,'2014-07-17',4,2,'hhhhhhhhh',15649505,1,NULL,'Ingreso',0),
 (22958393,'2014-07-17',4,3,'cableado',7186419,3,NULL,'Ingreso',13575772);
UNLOCK TABLES;
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`medio_transporte`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`medio_transporte`;
CREATE TABLE  `proyecto_yajaira`.`medio_transporte` (
  `id_medio` int(11) NOT NULL AUTO_INCREMENT,
  `medio` varchar(25) DEFAULT NULL,
  KEY `id_medio` (`id_medio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proyecto_yajaira`.`medio_transporte`
--

/*!40000 ALTER TABLE `medio_transporte` DISABLE KEYS */;
LOCK TABLES `medio_transporte` WRITE;
INSERT INTO `proyecto_yajaira`.`medio_transporte` VALUES  (1,'Solo'),
 (2,'Acompañado'),
 (3,'Transporte Particular');
UNLOCK TABLES;
/*!40000 ALTER TABLE `medio_transporte` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`municipio`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`municipio`;
CREATE TABLE  `proyecto_yajaira`.`municipio` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_municipio` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `municipio_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`municipio`
--

/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
LOCK TABLES `municipio` WRITE;
INSERT INTO `proyecto_yajaira`.`municipio` VALUES  (1,'Girardot',1),
 (2,'Libertador',1),
 (3,'Guacara',2),
 (4,'Santiago Mariño',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`nacionalidad`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`nacionalidad`;
CREATE TABLE  `proyecto_yajaira`.`nacionalidad` (
  `id_nacionalidad` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`nacionalidad`
--

/*!40000 ALTER TABLE `nacionalidad` DISABLE KEYS */;
LOCK TABLES `nacionalidad` WRITE;
INSERT INTO `proyecto_yajaira`.`nacionalidad` VALUES  (1,'V'),
 (2,'E'),
 (3,'P');
UNLOCK TABLES;
/*!40000 ALTER TABLE `nacionalidad` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`nivel_academico`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`nivel_academico`;
CREATE TABLE  `proyecto_yajaira`.`nivel_academico` (
  `id_nivel` int(11) NOT NULL,
  `nombre_nivel` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`nivel_academico`
--

/*!40000 ALTER TABLE `nivel_academico` DISABLE KEYS */;
LOCK TABLES `nivel_academico` WRITE;
INSERT INTO `proyecto_yajaira`.`nivel_academico` VALUES  (1,'Primaria'),
 (2,'Secundaria'),
 (3,'Bachillerato'),
 (4,'T.S.U'),
 (5,'Ingeniero'),
 (6,'Licenciatura'),
 (7,'Post-Grado'),
 (8,'Doctorado');
UNLOCK TABLES;
/*!40000 ALTER TABLE `nivel_academico` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`parroquia`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`parroquia`;
CREATE TABLE  `proyecto_yajaira`.`parroquia` (
  `id_parroquia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_parroquia` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id_municipio` int(11) NOT NULL,
  PRIMARY KEY (`id_parroquia`),
  KEY `id_municipio` (`id_municipio`),
  CONSTRAINT `parroquia_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `municipio` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`parroquia`
--

/*!40000 ALTER TABLE `parroquia` DISABLE KEYS */;
LOCK TABLES `parroquia` WRITE;
INSERT INTO `proyecto_yajaira`.`parroquia` VALUES  (1,'San Martin de Porres',2),
 (2,'Las Delicias',1),
 (4,'Choroni',1),
 (5,'Madre Maria',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `parroquia` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`perfil`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`perfil`;
CREATE TABLE  `proyecto_yajaira`.`perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `grupo_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `confirmar_contrasena` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`perfil`
--

/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
LOCK TABLES `perfil` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`pre_inscripcion`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`pre_inscripcion`;
CREATE TABLE  `proyecto_yajaira`.`pre_inscripcion` (
  `nacionalidad` int(11) DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `num_registro` int(11) DEFAULT NULL,
  `fecha_actual` date DEFAULT NULL,
  PRIMARY KEY (`cedula`),
  UNIQUE KEY `UNIQUE` (`num_registro`),
  CONSTRAINT `pre_inscripcion_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `estudiante` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`pre_inscripcion`
--

/*!40000 ALTER TABLE `pre_inscripcion` DISABLE KEYS */;
LOCK TABLES `pre_inscripcion` WRITE;
INSERT INTO `proyecto_yajaira`.`pre_inscripcion` VALUES  (1,11111111,1,'2014-07-17'),
 (1,22958393,2,'2014-07-17');
UNLOCK TABLES;
/*!40000 ALTER TABLE `pre_inscripcion` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`profesion`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`profesion`;
CREATE TABLE  `proyecto_yajaira`.`profesion` (
  `id_profesion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_profesion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_profesion`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`profesion`
--

/*!40000 ALTER TABLE `profesion` DISABLE KEYS */;
LOCK TABLES `profesion` WRITE;
INSERT INTO `proyecto_yajaira`.`profesion` VALUES  (1,'Becado'),
 (2,'Sin Empleo'),
 (3,'Con Empleo'),
 (4,'Estudiante'),
 (5,'Jubilado'),
 (6,'Pensionado'),
 (7,'Becado');
UNLOCK TABLES;
/*!40000 ALTER TABLE `profesion` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`programa_social`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`programa_social`;
CREATE TABLE  `proyecto_yajaira`.`programa_social` (
  `id_programa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_programa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_programa`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`programa_social`
--

/*!40000 ALTER TABLE `programa_social` DISABLE KEYS */;
LOCK TABLES `programa_social` WRITE;
INSERT INTO `proyecto_yajaira`.`programa_social` VALUES  (1,'Misión Robinson'),
 (2,'Misión Barrio Adentro'),
 (3,'Misión Guaicaipuro'),
 (4,'Misión Negra Hipolita'),
 (5,'Misión Gran Vivienda'),
 (6,'Misión Hijos e Hijas de Venezuela'),
 (7,'Misión Ribas'),
 (8,'Mercal'),
 (9,'Misión Identidad'),
 (10,'Misión José Gregorio Hernández'),
 (11,'Misión Agro Venezuela'),
 (12,'Misión Gran Saber y Trabajo'),
 (13,'Misión Súcre'),
 (14,'Misión Milagro'),
 (15,'Misión Cultura'),
 (16,'Misión Madres del Barrio'),
 (17,'Misión Sonrisa'),
 (18,'Misión Gran Amor Mayor'),
 (19,'Mision Bolivar');
UNLOCK TABLES;
/*!40000 ALTER TABLE `programa_social` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`representante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`representante`;
CREATE TABLE  `proyecto_yajaira`.`representante` (
  `nacionalidad` int(11) DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `fech_naci` date NOT NULL,
  `lugar_naci` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` int(1) DEFAULT '0',
  `calle` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `casa` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `edificio` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `barrio` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `antecedente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fuente_ingreso` int(11) DEFAULT NULL,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_celular` int(11) DEFAULT NULL,
  `celular` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_parroquia` int(11) NOT NULL,
  `id_estatus` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `id_profesion` int(11) NOT NULL,
  `condicion` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`cedula`),
  KEY `id_parroquia` (`id_parroquia`),
  KEY `id_estatus` (`id_estatus`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_profesion` (`id_profesion`),
  KEY `cod_habitacion` (`cod_telefono`),
  KEY `cod_celular` (`cod_celular`),
  KEY `nacionalidad` (`nacionalidad`),
  CONSTRAINT `representante_ibfk_1` FOREIGN KEY (`id_parroquia`) REFERENCES `parroquia` (`id_parroquia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `representante_ibfk_2` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_representante` (`id_estatus`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `representante_ibfk_3` FOREIGN KEY (`id_nivel`) REFERENCES `nivel_academico` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `representante_ibfk_4` FOREIGN KEY (`id_profesion`) REFERENCES `profesion` (`id_profesion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `representante_ibfk_5` FOREIGN KEY (`cod_telefono`) REFERENCES `codigo_telefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `representante_ibfk_6` FOREIGN KEY (`cod_celular`) REFERENCES `codigo_telefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `representante_ibfk_7` FOREIGN KEY (`nacionalidad`) REFERENCES `nacionalidad` (`id_nacionalidad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`representante`
--

/*!40000 ALTER TABLE `representante` DISABLE KEYS */;
LOCK TABLES `representante` WRITE;
INSERT INTO `proyecto_yajaira`.`representante` VALUES  (1,7186419,'maria','linres','','1952-09-03','Turmero',1,'Los Proceres','cas numero 45','','bolivar libertador','',4500,1,'2677557',6,'3255148',2,1,2,3,1),
 (1,12569325,'luisa','perez','','1952-09-25','Maracay',1,'Bolivar','casa numero 25','','bolivar','',3500,1,'2677725',4,'2545454',2,1,3,4,1),
 (1,15649505,'sfdsfsfd','sdfsfsfsf','','1994-07-06','sfsffsdffds',1,'wrwrwwerr','3243244','sfsf','wrwrwrr','wewwr',223424,1,'3424242',4,'2342442',2,1,2,1,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `representante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`servicio_publico`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`servicio_publico`;
CREATE TABLE  `proyecto_yajaira`.`servicio_publico` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `servicio` text COLLATE utf8_spanish_ci,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_parroquia` int(11) DEFAULT NULL,
  `id_tiposervicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`servicio_publico`
--

/*!40000 ALTER TABLE `servicio_publico` DISABLE KEYS */;
LOCK TABLES `servicio_publico` WRITE;
INSERT INTO `proyecto_yajaira`.`servicio_publico` VALUES  (1,'Residencias Palo Negro',1,'2222222',1,2),
 (2,'Madre Maria de San Jose',1,'6690401',4,4),
 (3,'ASODIAM',1,'2677557',2,3),
 (4,'Centro Medico',1,'4444444',2,4);
UNLOCK TABLES;
/*!40000 ALTER TABLE `servicio_publico` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`sexo`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`sexo`;
CREATE TABLE  `proyecto_yajaira`.`sexo` (
  `id_sexo` int(11) DEFAULT NULL,
  `sexo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`sexo`
--

/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
LOCK TABLES `sexo` WRITE;
INSERT INTO `proyecto_yajaira`.`sexo` VALUES  (1,'Femenino'),
 (2,'Masculino');
UNLOCK TABLES;
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`tecnologia`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`tecnologia`;
CREATE TABLE  `proyecto_yajaira`.`tecnologia` (
  `id_tecnologia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tecnologia` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tecnologia`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`tecnologia`
--

/*!40000 ALTER TABLE `tecnologia` DISABLE KEYS */;
LOCK TABLES `tecnologia` WRITE;
INSERT INTO `proyecto_yajaira`.`tecnologia` VALUES  (1,'Teléfono Móvil'),
 (2,'Teléfono Fijo'),
 (3,'TV'),
 (4,'Video'),
 (5,'Computador'),
 (6,'Internet');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tecnologia` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`tipo_cama`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`tipo_cama`;
CREATE TABLE  `proyecto_yajaira`.`tipo_cama` (
  `id_cama` int(11) NOT NULL AUTO_INCREMENT,
  `cama` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_cama`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`tipo_cama`
--

/*!40000 ALTER TABLE `tipo_cama` DISABLE KEYS */;
LOCK TABLES `tipo_cama` WRITE;
INSERT INTO `proyecto_yajaira`.`tipo_cama` VALUES  (1,'Cama'),
 (2,'Litera'),
 (3,'Hamaca'),
 (4,'Piso');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tipo_cama` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`tipo_estudiante`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`tipo_estudiante`;
CREATE TABLE  `proyecto_yajaira`.`tipo_estudiante` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_estudiante` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`tipo_estudiante`
--

/*!40000 ALTER TABLE `tipo_estudiante` DISABLE KEYS */;
LOCK TABLES `tipo_estudiante` WRITE;
INSERT INTO `proyecto_yajaira`.`tipo_estudiante` VALUES  (1,'Ingreso'),
 (2,'Regular'),
 (3,'Reintegro');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tipo_estudiante` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`tipo_vivienda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`tipo_vivienda`;
CREATE TABLE  `proyecto_yajaira`.`tipo_vivienda` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_vivienda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`tipo_vivienda`
--

/*!40000 ALTER TABLE `tipo_vivienda` DISABLE KEYS */;
LOCK TABLES `tipo_vivienda` WRITE;
INSERT INTO `proyecto_yajaira`.`tipo_vivienda` VALUES  (1,'Edificio'),
 (2,'Casa'),
 (3,'Refugio'),
 (4,'Rancho');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tipo_vivienda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`tiposervicio`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`tiposervicio`;
CREATE TABLE  `proyecto_yajaira`.`tiposervicio` (
  `id_tiposervicio` int(11) NOT NULL AUTO_INCREMENT,
  `tiposervicio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tiposervicio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`tiposervicio`
--

/*!40000 ALTER TABLE `tiposervicio` DISABLE KEYS */;
LOCK TABLES `tiposervicio` WRITE;
INSERT INTO `proyecto_yajaira`.`tiposervicio` VALUES  (1,'Modulo de Salud'),
 (2,'Centro de Diagnóstico Integral'),
 (3,'Servicio de Rehabilitación Integral'),
 (4,'Hospital'),
 (5,'Ambulatorio Público');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tiposervicio` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`ubicacion_vivienda`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`ubicacion_vivienda`;
CREATE TABLE  `proyecto_yajaira`.`ubicacion_vivienda` (
  `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT,
  `ubicacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_ubicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`ubicacion_vivienda`
--

/*!40000 ALTER TABLE `ubicacion_vivienda` DISABLE KEYS */;
LOCK TABLES `ubicacion_vivienda` WRITE;
INSERT INTO `proyecto_yajaira`.`ubicacion_vivienda` VALUES  (1,'Urbano'),
 (2,'Barrio'),
 (3,'Sector'),
 (4,'Zona');
UNLOCK TABLES;
/*!40000 ALTER TABLE `ubicacion_vivienda` ENABLE KEYS */;


--
-- Definition of table `proyecto_yajaira`.`usuario`
--

DROP TABLE IF EXISTS `proyecto_yajaira`.`usuario`;
CREATE TABLE  `proyecto_yajaira`.`usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` text COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `id_grupo` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo_usuario` (`id_grupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proyecto_yajaira`.`usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
LOCK TABLES `usuario` WRITE;
INSERT INTO `proyecto_yajaira`.`usuario` VALUES  (1,'administrador','Administrador','Administrador','91f5167c34c400758115c2a6826ec2e3',1,1),
 (3,'informatica','Informatica','Informatica','e28e9b2242e579f40bc78d08628c7297',1,2);
UNLOCK TABLES;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
