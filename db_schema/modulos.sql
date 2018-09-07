/**
REEMPLAZAR PREFIJO
*/

CREATE TABLE IF NOT EXISTS `adelante_modulos` (
  `modulo` varchar(50) NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `menu` int(1) NOT NULL DEFAULT '0',
  `publico` int(1) NOT NULL DEFAULT '0',
  `enlace` varchar(50) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL COMMENT 'fontawesome',
  `created_at` timestamp DEFAULT current_timestamp NOT NULL,
  `updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,
  PRIMARY KEY (`modulo`),
  UNIQUE KEY `modulo` (`modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELETE FROM `adelante_modulos`;
/*!40000 ALTER TABLE `adelante_modulos` DISABLE KEYS */;
INSERT INTO `adelante_modulos` (`modulo`, `titulo`, `menu`, `publico`, `enlace`, `orden`, `icono`) VALUES
	('index', 'Inicio', 1, 1, '/', 1, ' fa-home');