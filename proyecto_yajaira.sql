/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.12 : Database - proyecto_yajaira
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`proyecto_yajaira` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `proyecto_yajaira`;

/*Table structure for table `acceso_alimentacion` */

DROP TABLE IF EXISTS `acceso_alimentacion`;

CREATE TABLE `acceso_alimentacion` (
  `id_acceso` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_acceso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_acceso`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `acceso_alimentacion` */

insert  into `acceso_alimentacion`(`id_acceso`,`tipo_acceso`) values (1,'Siempre'),(2,'Ocasionalmente'),(3,'Fácilmente'),(4,'Difícilmente');

/*Table structure for table `actividad` */

DROP TABLE IF EXISTS `actividad`;

CREATE TABLE `actividad` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `actividad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `actividad` */

insert  into `actividad`(`id_actividad`,`actividad`,`descripcion`) values (1,'Madera','Realizar actividad de Carpinteria'),(2,'Peluqueria','Corte de cabello y secado'),(3,'Electricidad','Instalación electrica');

/*Table structure for table `actividad_docente` */

DROP TABLE IF EXISTS `actividad_docente`;

CREATE TABLE `actividad_docente` (
  `id_actividad` int(11) DEFAULT NULL,
  `cedula_docente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `actividad_docente` */

/*Table structure for table `actividad_estudiante` */

DROP TABLE IF EXISTS `actividad_estudiante`;

CREATE TABLE `actividad_estudiante` (
  `id_actividad` int(11) DEFAULT NULL,
  `cedula_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `actividad_estudiante` */

/*Table structure for table `alimentacion_regular` */

DROP TABLE IF EXISTS `alimentacion_regular`;

CREATE TABLE `alimentacion_regular` (
  `id_regular` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_regular` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_regular`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `alimentacion_regular` */

insert  into `alimentacion_regular`(`id_regular`,`tipo_regular`) values (1,'Una vez'),(2,'Dos Veces'),(3,'Tres Veces'),(4,'Solo'),(5,'Con Ayuda');

/*Table structure for table `amerita_ayuda` */

DROP TABLE IF EXISTS `amerita_ayuda`;

CREATE TABLE `amerita_ayuda` (
  `id_ayuda` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ayuda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_ayuda`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `amerita_ayuda` */

insert  into `amerita_ayuda`(`id_ayuda`,`tipo_ayuda`) values (1,'Vestirse'),(2,'Ir al Baño'),(3,'Asearse'),(4,'Subir o Bajar Escalones');

/*Table structure for table `anio_escolar` */

DROP TABLE IF EXISTS `anio_escolar`;

CREATE TABLE `anio_escolar` (
  `id_anio` int(11) NOT NULL AUTO_INCREMENT,
  `anio_escolar` year(4) DEFAULT NULL,
  PRIMARY KEY (`id_anio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `anio_escolar` */

insert  into `anio_escolar`(`id_anio`,`anio_escolar`) values (1,2011),(2,2012),(3,2013),(4,2014);

/*Table structure for table `anioescolar_estudiante` */

DROP TABLE IF EXISTS `anioescolar_estudiante`;

CREATE TABLE `anioescolar_estudiante` (
  `id_anio` int(11) DEFAULT NULL,
  `cedula_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `anioescolar_estudiante` */

/*Table structure for table `automovil` */

DROP TABLE IF EXISTS `automovil`;

CREATE TABLE `automovil` (
  `placa` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `modelo` text COLLATE utf8_spanish_ci,
  `color` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cedula_chofer` int(11) DEFAULT NULL,
  PRIMARY KEY (`placa`),
  KEY `cedula_chofer` (`cedula_chofer`),
  CONSTRAINT `automovil_ibfk_1` FOREIGN KEY (`cedula_chofer`) REFERENCES `chofer` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `automovil` */

insert  into `automovil`(`placa`,`modelo`,`color`,`cedula_chofer`) values ('14MBGD12','Fiat','Verde Agua',13575772),('GF54HY','Fiat','Azul',22859393),('HG56GD','Fiat','Azul',7186419),('MIYB125P','Fiat','Azul y Rojo',22589393),('MY125OK','For','Amarillo',15649504);

/*Table structure for table `chofer` */

DROP TABLE IF EXISTS `chofer`;

CREATE TABLE `chofer` (
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

/*Data for the table `chofer` */

insert  into `chofer`(`nacionalidad`,`cedula`,`nombre`,`apellido`,`email`,`cod_telefono`,`telefono`,`cod_celular`,`celular`) values (1,7186419,'maria','linares','sfdjsfgb',1,'4545676',4,'2222222'),(2,13575772,'yergiroska','aguirre ','yergiroska@gmail.com',1,'2677735',6,'3255148'),(1,15649504,'Luis ','Perez Gomez','luisp@hotmail.com',1,'2677735',6,'3255148'),(1,22589393,'carmen luisa','ruiz romero','carmen@.com',1,'2677557',5,'2563695'),(1,22859393,'camien ','aponte','carmen@gmail.com',1,'4546467',4,'4654656');

/*Table structure for table `chofer_estudiante` */

DROP TABLE IF EXISTS `chofer_estudiante`;

CREATE TABLE `chofer_estudiante` (
  `cedula_chofer` int(11) DEFAULT NULL,
  `cedula_estudiante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `chofer_estudiante` */

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `nombre_ciudad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `ciudad` */

/*Table structure for table `codigo_telefono` */

DROP TABLE IF EXISTS `codigo_telefono`;

CREATE TABLE `codigo_telefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `codigo_telefono` */

insert  into `codigo_telefono`(`id`,`codigo`,`tipo`) values (1,'0243',1),(2,'0244',1),(4,'0412',2),(5,'0416',2),(6,'0424',2),(7,'0414',2);

/*Table structure for table `concepto_ingreso` */

DROP TABLE IF EXISTS `concepto_ingreso`;

CREATE TABLE `concepto_ingreso` (
  `id_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_ingreso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_ingreso`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `concepto_ingreso` */

insert  into `concepto_ingreso`(`id_ingreso`,`tipo_ingreso`) values (1,'Trabajo Formal'),(2,'Trabajo Informal'),(3,'Pensión IVSS'),(4,'Asignacion de Misiones'),(5,'Becas'),(6,'Pensión Alimentaria');

/*Table structure for table `destrezas_habilidades` */

DROP TABLE IF EXISTS `destrezas_habilidades`;

CREATE TABLE `destrezas_habilidades` (
  `id_destreza` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_destreza` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_destreza`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `destrezas_habilidades` */

insert  into `destrezas_habilidades`(`id_destreza`,`tipo_destreza`) values (1,'Artesanales'),(2,'Deportivas'),(3,'Culturales'),(4,'Cocina'),(5,'Agrícolas'),(6,'Tecnológicas');

/*Table structure for table `diversidad_funcional` */

DROP TABLE IF EXISTS `diversidad_funcional`;

CREATE TABLE `diversidad_funcional` (
  `id_diversidad` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_diversidad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_diversidad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `diversidad_funcional` */

insert  into `diversidad_funcional`(`id_diversidad`,`tipo_diversidad`) values (1,'Compromiso Cognitivo'),(2,'Impedimento Físico'),(3,'Deficiencias Visuales'),(4,'Deficiencias Auditivas'),(5,'Autismo'),(6,'Lenguaje');

/*Table structure for table `docente` */

DROP TABLE IF EXISTS `docente`;

CREATE TABLE `docente` (
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

/*Data for the table `docente` */

insert  into `docente`(`nacionalidad`,`cedula`,`nombre`,`apellido`,`email`,`fech_naci`,`lugar_naci`,`sexo`,`calle`,`casa`,`edificio`,`barrio`,`cod_telefono`,`telefono`,`cod_celular`,`celular`,`id_parroquia`,`activo`,`id_actividad`) values (1,13575772,'maria','lara ruiz','mariala.com','1960-05-17','maracay',1,'suvre','36','no','la pica',1,'2677557',4,'6690401',2,1,3),(1,15649504,'joanlit del carmen','aponte  segovia','yolilipu@gmail.com','1982-11-30','españa',1,'orinoco','no ','edificio numero 04','la pica',1,'2677557',4,'6690401',4,1,2),(1,15649505,'josue','aponte','josueaponte7@gmail.com','1994-05-18','gfdfgdgdgfdg',2,'dfgd','dfgdg','dfgdg','dfgdgdgd',1,'2677532',4,'1417532',2,1,1);

/*Table structure for table `dt_alimentacion` */

DROP TABLE IF EXISTS `dt_alimentacion`;

CREATE TABLE `dt_alimentacion` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_acceso` int(11) DEFAULT NULL,
  `id_regular` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_alimentacion` */

/*Table structure for table `dt_ayuda` */

DROP TABLE IF EXISTS `dt_ayuda`;

CREATE TABLE `dt_ayuda` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_ayuda` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_ayuda` */

/*Table structure for table `dt_destreza` */

DROP TABLE IF EXISTS `dt_destreza`;

CREATE TABLE `dt_destreza` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_destreza` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_destreza` */

/*Table structure for table `dt_diversidad_funcional` */

DROP TABLE IF EXISTS `dt_diversidad_funcional`;

CREATE TABLE `dt_diversidad_funcional` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_diversidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_diversidad_funcional` */

/*Table structure for table `dt_enfermedad` */

DROP TABLE IF EXISTS `dt_enfermedad`;

CREATE TABLE `dt_enfermedad` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_enfermedades` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_enfermedad` */

/*Table structure for table `dt_ingreso_familiar` */

DROP TABLE IF EXISTS `dt_ingreso_familiar`;

CREATE TABLE `dt_ingreso_familiar` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_ingreso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_ingreso_familiar` */

/*Table structure for table `dt_padres` */

DROP TABLE IF EXISTS `dt_padres`;

CREATE TABLE `dt_padres` (
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

/*Data for the table `dt_padres` */

insert  into `dt_padres`(`cedula_estudiante`,`padre_f`,`madre_f`,`padre_pl`,`madre_pl`,`padre_al`,`madre_al`,`represent_al`,`padre_fd`,`madre_fd`,`represent_fd`,`padre_alf`,`madre_alf`,`represent_alf`,`padre_nivel`,`madre_nivel`,`represent_nivel`,`padre_set`,`madre_set`,`padre_see`,`madre_see`) values (23658148,0,0,0,0,0,0,0,0,0,0,'pn','ms','rs',0,0,0,0,0,0,0);

/*Table structure for table `dt_padres2` */

DROP TABLE IF EXISTS `dt_padres2`;

CREATE TABLE `dt_padres2` (
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

/*Data for the table `dt_padres2` */

/*Table structure for table `dt_programa_social` */

DROP TABLE IF EXISTS `dt_programa_social`;

CREATE TABLE `dt_programa_social` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_programa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_programa_social` */

/*Table structure for table `dt_servicio` */

DROP TABLE IF EXISTS `dt_servicio`;

CREATE TABLE `dt_servicio` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_servicio` */

/*Table structure for table `dt_tecnologia` */

DROP TABLE IF EXISTS `dt_tecnologia`;

CREATE TABLE `dt_tecnologia` (
  `cedula_estudiante` int(11) DEFAULT NULL,
  `id_tecnologia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_tecnologia` */

/*Table structure for table `dt_vivienda` */

DROP TABLE IF EXISTS `dt_vivienda`;

CREATE TABLE `dt_vivienda` (
  `cedula_estudiante` int(11) DEFAULT '0',
  `ubicacion_vivienda` int(11) DEFAULT '0',
  `tipo_vivienda` int(11) DEFAULT '0',
  `estado_vivienda` int(11) DEFAULT '0',
  `cant_habitacion` int(11) DEFAULT '0',
  `cama` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dt_vivienda` */

/*Table structure for table `enfermedades` */

DROP TABLE IF EXISTS `enfermedades`;

CREATE TABLE `enfermedades` (
  `id_enfermedad` int(11) NOT NULL AUTO_INCREMENT,
  `enfermedad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_enfermedad`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `enfermedades` */

insert  into `enfermedades`(`id_enfermedad`,`enfermedad`) values (1,'Respiratorias Crónicas'),(2,'Insuficiencia Renal'),(3,'Insuficiencia Cardíaca'),(4,'Diabetes'),(5,'Parálisis Cerebral'),(6,'Epilepsia'),(7,'Psiquiátricos'),(8,'Cáncer');

/*Table structure for table `estado` */

DROP TABLE IF EXISTS `estado`;

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estado` */

insert  into `estado`(`id_estado`,`nombre_estado`) values (1,'Aragua'),(2,'Carabobo'),(3,'apure');

/*Table structure for table `estado_vivienda` */

DROP TABLE IF EXISTS `estado_vivienda`;

CREATE TABLE `estado_vivienda` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado_vivienda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estado_vivienda` */

insert  into `estado_vivienda`(`id_estado`,`estado_vivienda`) values (1,'Buena'),(2,'Regular'),(3,'Satisfactoria'),(4,'Mala');

/*Table structure for table `estatus_chofer` */

DROP TABLE IF EXISTS `estatus_chofer`;

CREATE TABLE `estatus_chofer` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estatus_chofer` */

insert  into `estatus_chofer`(`id_estatus`,`nombre`) values (1,'Activo'),(2,'Inactivo');

/*Table structure for table `estatus_docente` */

DROP TABLE IF EXISTS `estatus_docente`;

CREATE TABLE `estatus_docente` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estatus_docente` */

insert  into `estatus_docente`(`id_estatus`,`nombre`) values (1,'Activo'),(2,'Inactivo');

/*Table structure for table `estatus_estudiante` */

DROP TABLE IF EXISTS `estatus_estudiante`;

CREATE TABLE `estatus_estudiante` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estatus_estudiante` */

insert  into `estatus_estudiante`(`id_estatus`,`nombre`) values (1,'Registrado'),(2,'Pre-Inscrito'),(3,'Inscrito'),(4,'En Reposo'),(5,'En Espera'),(6,'Suspendido'),(7,'Desmatriculado');

/*Table structure for table `estatus_representante` */

DROP TABLE IF EXISTS `estatus_representante`;

CREATE TABLE `estatus_representante` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estatus_representante` */

insert  into `estatus_representante`(`id_estatus`,`nombre`) values (1,'Firmante'),(2,'Absoluto'),(3,'Acompañante'),(4,'Fallecido'),(5,'Suspendido');

/*Table structure for table `estudiante` */

DROP TABLE IF EXISTS `estudiante`;

CREATE TABLE `estudiante` (
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

/*Data for the table `estudiante` */

insert  into `estudiante`(`nacionalidad`,`cedula`,`nombre`,`apellido`,`email`,`fech_naci`,`lugar_naci`,`sexo`,`calle`,`casa`,`edificio`,`barrio`,`cod_telefono`,`telefono`,`cod_celular`,`celular`,`id_parroquia`,`id_estatus`) values (1,13575772,'Pedro','Perez','jhgjhghh','1999-01-11','hjjhj',2,'hjhjh','hjhjhj','hjhjh','hhhj',1,'4657567',5,'6787887',2,2),(1,15649505,'Josue','Aponte','josueaponte@gmail.com','1999-04-08','maracay',2,'sucre','32','','la pica',1,'2677535',4,'1417532',2,3),(1,18562324,'juan','martinez','juan@gmail.com','1997-06-10','Marcaay',2,'el paseo','25','mis escantos','el trigal',1,'1256444',4,'4545545',2,2),(3,23658148,'yergiroska','aguirre','maraia@gmail.com','1999-04-12','maracay',1,'sucre','36','no','la pica',2,'5657676',6,'6576868',2,3);

/*Table structure for table `estudiante_representante` */

DROP TABLE IF EXISTS `estudiante_representante`;

CREATE TABLE `estudiante_representante` (
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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estudiante_representante` */

insert  into `estudiante_representante`(`id`,`cedula_estudiante`,`cedula_representante`,`parentesco`,`representante`) values (33,15649505,14599263,5,0),(34,15649505,13575771,3,1),(61,23658148,15649504,4,0),(62,23658148,14599263,1,1),(63,13575772,15649504,6,0),(64,13575772,14599263,1,0),(65,13575772,13575771,3,1),(66,18562324,15649504,4,0),(67,18562324,14599263,5,1),(68,18562324,13575772,1,0);

/*Table structure for table `grupo_usuario` */

DROP TABLE IF EXISTS `grupo_usuario`;

CREATE TABLE `grupo_usuario` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `grupo_usuario` */

insert  into `grupo_usuario`(`id_grupo`,`nombre_grupo`) values (1,'Administrador'),(2,'Root'),(3,'Admin'),(4,'Informatica'),(5,'Reporte'),(6,'Consulta');

/*Table structure for table `historial_inscripcion` */

DROP TABLE IF EXISTS `historial_inscripcion`;

CREATE TABLE `historial_inscripcion` (
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

/*Data for the table `historial_inscripcion` */

insert  into `historial_inscripcion`(`cedula_estudiante`,`fecha_inscripcion`,`id_anio`,`id_actividad`,`area_descripcion`,`cedula_representante`,`id_medio`,`cedula_chofer`) values (23658148,'2014-05-07',4,1,'Carpinteria',15649508,3,15649504),(15649505,'2014-05-07',4,1,'Carpinteria',14599263,3,15649504),(15649505,'2014-05-07',4,1,'Carpinteria',14599263,3,15649504);

/*Table structure for table `inscripcion` */

DROP TABLE IF EXISTS `inscripcion`;

CREATE TABLE `inscripcion` (
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

/*Data for the table `inscripcion` */

insert  into `inscripcion`(`cedula_estudiante`,`fecha_inscripcion`,`id_anio`,`id_actividad`,`area_descripcion`,`cedula_representante`,`id_medio`,`id_tipo`,`tipo`,`cedula_chofer`) values (15649505,'2014-05-07',3,1,'Carpinteria',14599263,3,NULL,'Ingreso',15649504),(23658148,'2014-07-07',4,1,'Carpinteria',15649508,3,NULL,'Ingreso',15649504);

/*Table structure for table `medio_transporte` */

DROP TABLE IF EXISTS `medio_transporte`;

CREATE TABLE `medio_transporte` (
  `id_medio` int(11) NOT NULL AUTO_INCREMENT,
  `medio` varchar(25) DEFAULT NULL,
  KEY `id_medio` (`id_medio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `medio_transporte` */

insert  into `medio_transporte`(`id_medio`,`medio`) values (1,'Solo'),(2,'Acompañado'),(3,'Transporte Particular');

/*Table structure for table `municipio` */

DROP TABLE IF EXISTS `municipio`;

CREATE TABLE `municipio` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_municipio` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `municipio_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `municipio` */

insert  into `municipio`(`id_municipio`,`nombre_municipio`,`id_estado`) values (1,'Girardot',1),(2,'Libertador',1),(3,'Guacara',2),(4,'Santiago Mariño',1);

/*Table structure for table `nacionalidad` */

DROP TABLE IF EXISTS `nacionalidad`;

CREATE TABLE `nacionalidad` (
  `id_nacionalidad` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `nacionalidad` */

insert  into `nacionalidad`(`id_nacionalidad`,`nombre`) values (1,'V'),(2,'E'),(3,'P');

/*Table structure for table `nivel_academico` */

DROP TABLE IF EXISTS `nivel_academico`;

CREATE TABLE `nivel_academico` (
  `id_nivel` int(11) NOT NULL,
  `nombre_nivel` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `nivel_academico` */

insert  into `nivel_academico`(`id_nivel`,`nombre_nivel`) values (1,'Primaria'),(2,'Secundaria'),(3,'Bachillerato'),(4,'T.S.U'),(5,'Ingeniero'),(6,'Licenciatura'),(7,'Post-Grado'),(8,'Doctorado');

/*Table structure for table `parroquia` */

DROP TABLE IF EXISTS `parroquia`;

CREATE TABLE `parroquia` (
  `id_parroquia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_parroquia` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `id_municipio` int(11) NOT NULL,
  PRIMARY KEY (`id_parroquia`),
  KEY `id_municipio` (`id_municipio`),
  CONSTRAINT `parroquia_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `municipio` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `parroquia` */

insert  into `parroquia`(`id_parroquia`,`nombre_parroquia`,`id_municipio`) values (1,'San Martin de Porres',2),(2,'Las Delicias',1),(4,'Choroni',1),(5,'Madre Maria',1);

/*Table structure for table `perfil` */

DROP TABLE IF EXISTS `perfil`;

CREATE TABLE `perfil` (
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

/*Data for the table `perfil` */

/*Table structure for table `pre_inscripcion` */

DROP TABLE IF EXISTS `pre_inscripcion`;

CREATE TABLE `pre_inscripcion` (
  `nacionalidad` int(11) DEFAULT NULL,
  `cedula` int(11) NOT NULL,
  `num_registro` int(11) DEFAULT NULL,
  `fecha_actual` date DEFAULT NULL,
  PRIMARY KEY (`cedula`),
  UNIQUE KEY `UNIQUE` (`num_registro`),
  CONSTRAINT `pre_inscripcion_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `estudiante` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `pre_inscripcion` */

insert  into `pre_inscripcion`(`nacionalidad`,`cedula`,`num_registro`,`fecha_actual`) values (1,13575772,1,'2014-05-10'),(1,18562324,2,'2014-05-10');

/*Table structure for table `profesion` */

DROP TABLE IF EXISTS `profesion`;

CREATE TABLE `profesion` (
  `id_profesion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_profesion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_profesion`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `profesion` */

insert  into `profesion`(`id_profesion`,`nombre_profesion`) values (1,'Becado'),(2,'Sin Empleo'),(3,'Con Empleo'),(4,'Estudiante'),(5,'Jubilado'),(6,'Pensionado'),(7,'Becado');

/*Table structure for table `programa_social` */

DROP TABLE IF EXISTS `programa_social`;

CREATE TABLE `programa_social` (
  `id_programa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_programa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_programa`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `programa_social` */

insert  into `programa_social`(`id_programa`,`nombre_programa`) values (1,'Misión Robinson'),(2,'Misión Barrio Adentro'),(3,'Misión Guaicaipuro'),(4,'Misión Negra Hipolita'),(5,'Misión Gran Vivienda'),(6,'Misión Hijos e Hijas de Venezuela'),(7,'Misión Ribas'),(8,'Mercal'),(9,'Misión Identidad'),(10,'Misión José Gregorio Hernández'),(11,'Misión Agro Venezuela'),(12,'Misión Gran Saber y Trabajo'),(13,'Misión Súcre'),(14,'Misión Milagro'),(15,'Misión Cultura'),(16,'Misión Madres del Barrio'),(17,'Misión Sonrisa'),(18,'Misión Gran Amor Mayor'),(19,'Mision Bolivar');

/*Table structure for table `representante` */

DROP TABLE IF EXISTS `representante`;

CREATE TABLE `representante` (
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

/*Data for the table `representante` */

insert  into `representante`(`nacionalidad`,`cedula`,`nombre`,`apellido`,`email`,`fech_naci`,`lugar_naci`,`sexo`,`calle`,`casa`,`edificio`,`barrio`,`antecedente`,`fuente_ingreso`,`cod_telefono`,`telefono`,`cod_celular`,`celular`,`id_parroquia`,`id_estatus`,`id_nivel`,`id_profesion`,`condicion`) values (2,13575771,'Maria Laura','Gutierrez Valderrama','sdfuidg','1998-10-06','amdbs',1,'sfcsdgfh','ghgj','hgjhgkj','hjhkhjl','hjghjhk',3000,1,'1234567',5,'7894561',2,1,2,2,0),(1,13575772,'yergiroska','aguirre','hghgj','1986-02-03','fgjhj',1,'ghghgh','ghghg','hghgh','ghgh','ghhgh',8769789,1,'4645656',4,'657576',2,3,3,2,0),(1,14599263,'Petra','Perez','petraperz@wfg','1954-09-03','valera',1,'los proceres','45','no','Bolovar Libertador',' dgfyj',115454,2,'1236542',4,'3255148',2,1,1,2,1),(2,15649504,'pedro','roman','sdfuidg','1998-10-06','amdbs',2,'sfcsdgfh','ghgj','hgjhgkj','hjhkhjl','hjghjhk',3000,2,'5555555',5,'6690401',2,1,2,2,1),(1,15649506,'josue ','aponte ','josueaponte7@gmail.com','1986-03-04','maracay',2,'sdfdfssf','234224','dsffsd','sdfgfsfwfe','fsdfsfsf',324424224,1,'5555555',4,'4444444',2,1,5,4,1),(1,22563125,'glenda','romero','glen@gmail.com','1974-07-18','maracay',1,'el sol','23','no','san juan','no posee',4250,1,'7676767',4,'8898989',2,3,3,3,0),(1,33333333,'dddddddddddddd','dddddddddddd','cbnvnnghgn','1986-05-06','gfdhghghgh',1,'gfgfgf','fgfgg','','fgfgfg','fgfgfgf',556556,1,'3333333',4,'3333333',2,1,1,1,1),(1,55555555,'vhghghg','gvbghgh','hghgghgh','1984-06-12','hghgh',2,'fghgh','ghgh','ghhg','hghg','ghghg',768787,1,'6787878',4,'6576767',2,1,1,2,0);

/*Table structure for table `servicio_publico` */

DROP TABLE IF EXISTS `servicio_publico`;

CREATE TABLE `servicio_publico` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `servicio` text COLLATE utf8_spanish_ci,
  `cod_telefono` int(11) DEFAULT NULL,
  `telefono` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_parroquia` int(11) DEFAULT NULL,
  `id_tiposervicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `servicio_publico` */

insert  into `servicio_publico`(`id_servicio`,`servicio`,`cod_telefono`,`telefono`,`id_parroquia`,`id_tiposervicio`) values (1,'Residencias Palo Negro',1,'2222222',1,2),(2,'Madre Maria de San Jose',1,'6690401',4,4),(3,'ASODIAM',1,'2677557',2,3),(4,'Centro Medico',1,'4444444',2,4);

/*Table structure for table `sexo` */

DROP TABLE IF EXISTS `sexo`;

CREATE TABLE `sexo` (
  `id_sexo` int(11) DEFAULT NULL,
  `sexo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `sexo` */

insert  into `sexo`(`id_sexo`,`sexo`) values (1,'Femenino'),(2,'Masculino');

/*Table structure for table `tecnologia` */

DROP TABLE IF EXISTS `tecnologia`;

CREATE TABLE `tecnologia` (
  `id_tecnologia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tecnologia` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tecnologia`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `tecnologia` */

insert  into `tecnologia`(`id_tecnologia`,`nombre_tecnologia`) values (1,'Teléfono Móvil'),(2,'Teléfono Fijo'),(3,'TV'),(4,'Video'),(5,'Computador'),(6,'Internet');

/*Table structure for table `tipo_cama` */

DROP TABLE IF EXISTS `tipo_cama`;

CREATE TABLE `tipo_cama` (
  `id_cama` int(11) NOT NULL AUTO_INCREMENT,
  `cama` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_cama`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `tipo_cama` */

insert  into `tipo_cama`(`id_cama`,`cama`) values (1,'Cama'),(2,'Litera'),(3,'Hamaca'),(4,'Piso');

/*Table structure for table `tipo_estudiante` */

DROP TABLE IF EXISTS `tipo_estudiante`;

CREATE TABLE `tipo_estudiante` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_estudiante` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `tipo_estudiante` */

insert  into `tipo_estudiante`(`id_tipo`,`tipo_estudiante`) values (1,'Ingreso'),(2,'Regular'),(3,'Reintegro');

/*Table structure for table `tipo_vivienda` */

DROP TABLE IF EXISTS `tipo_vivienda`;

CREATE TABLE `tipo_vivienda` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_vivienda` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `tipo_vivienda` */

insert  into `tipo_vivienda`(`id_tipo`,`tipo_vivienda`) values (1,'Edificio'),(2,'Casa'),(3,'Refugio'),(4,'Rancho');

/*Table structure for table `tiposervicio` */

DROP TABLE IF EXISTS `tiposervicio`;

CREATE TABLE `tiposervicio` (
  `id_tiposervicio` int(11) NOT NULL AUTO_INCREMENT,
  `tiposervicio` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tiposervicio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `tiposervicio` */

insert  into `tiposervicio`(`id_tiposervicio`,`tiposervicio`) values (1,'Modulo de Salud'),(2,'Centro de Diagnóstico Integral'),(3,'Servicio de Rehabilitación Integral'),(4,'Hospital'),(5,'Ambulatorio Público');

/*Table structure for table `ubicacion_vivienda` */

DROP TABLE IF EXISTS `ubicacion_vivienda`;

CREATE TABLE `ubicacion_vivienda` (
  `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT,
  `ubicacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_ubicacion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `ubicacion_vivienda` */

insert  into `ubicacion_vivienda`(`id_ubicacion`,`ubicacion`) values (1,'Urbano'),(2,'Barrio'),(3,'Sector'),(4,'Zona');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`usuario`,`nombre`,`apellido`,`contrasena`,`activo`,`id_grupo`) values (1,'administrador','Administrador','Administrador','91f5167c34c400758115c2a6826ec2e3',1,1),(2,'josue','josue','josue','0f130e9b5860c03af9fc2f5e56ec8950',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
