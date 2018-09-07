/**
REEMPLAZAR PREFIJO
*/


CREATE TABLE IF NOT EXISTS `adelante_seguridad_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT '0',
  `padre` int(11) DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp NOT NULL,
  `updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,  
  PRIMARY KEY (`id`),
  KEY `FK_permisos_grupos_permisos_grupos` (`padre`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

DELETE FROM `adelante_seguridad_grupos`;
/*!40000 ALTER TABLE `seguridad_grupos` DISABLE KEYS */;
INSERT INTO `adelante_seguridad_grupos` (`id`, `nombre`, `padre`) VALUES
	(1, 'Administración', 0);
/*!40000 ALTER TABLE `adelante_seguridad_grupos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `adelante_seguridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` int(11) DEFAULT '0',
  `modulo` char(50) DEFAULT NULL COMMENT 'Si es NULO se aplica a todos los módulos',
  `elemento` int(11) DEFAULT NULL COMMENT 'Si es NULO se aplica a cualquier elemento. Siempre prevalece cuando no es nulo',
  `nivel` int(11) NOT NULL DEFAULT '100',
  `comentario` char(250) DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp NOT NULL,
  `updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,  
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `grupo_modulo_elemento` (`grupo`,`modulo`,`elemento`),
  CONSTRAINT `FK_seguridad_seguridad_grupos` FOREIGN KEY (`grupo`) REFERENCES `adelante_seguridad_grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Establecemos ';

DELETE FROM `adelante_seguridad`;
/*!40000 ALTER TABLE `adelante_seguridad` DISABLE KEYS */;
INSERT INTO `adelante_seguridad` (`id`, `grupo`, `modulo`, `elemento`, `nivel`, `comentario`) VALUES
	(1, 1, NULL, NULL, 100, 'Permiso máximo por defecto al gurpo de Administración');
/*!40000 ALTER TABLE `adelante_seguridad` ENABLE KEYS */;


CREATE TABLE IF NOT EXISTS `adelante_seguridad_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(250) NOT NULL DEFAULT '',
  `tipo` enum('LDAP','Normal') NOT NULL DEFAULT 'LDAP',
  `nombre` varchar(250) DEFAULT NULL,
  `apellidos` varchar(250) DEFAULT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `pwd` char(250) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `karma` decimal(10,3) DEFAULT '1.000',
  `ultimoacceso` datetime DEFAULT NULL,
  `metodo` varchar(50) DEFAULT 'web',
  `avatar` varchar(100) DEFAULT NULL,
  `tlf1` varchar(20) DEFAULT NULL,
  `tlf2` varchar(20) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `circulo` varchar(100) DEFAULT NULL,
  `datosCompletos` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT current_timestamp NOT NULL,
  `updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,  
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `email2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DELETE FROM `adelante_seguridad_usuarios`;
/*!40000 ALTER TABLE `adelante_seguridad_usuarios` DISABLE KEYS */;
INSERT INTO `adelante_seguridad_usuarios` (`id`, `nick`, `tipo`, `nombre`, `apellidos`, `email`, `pwd`, `fecha`, `karma`, `ultimoacceso`, `metodo`, `avatar`, `tlf1`, `tlf2`, `localidad`, `cp`, `circulo`, `datosCompletos`) VALUES
	(1, 'admin', 'Normal', 'Administración', NULL, '', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', NULL, 1.000, NULL, 'web', NULL, NULL, NULL, NULL, NULL, NULL, 0);
/*!40000 ALTER TABLE `adelante_seguridad_usuarios` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `adelante_seguridad_usuarios_en_grupos` (
  `usuario` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT '1',
  `creado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp DEFAULT current_timestamp NOT NULL,
  `updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,  
  PRIMARY KEY (`usuario`,`grupo`),
  KEY `FK_seguridad_usuarios_en_grupos_seguridad_grupos` (`grupo`),
  CONSTRAINT `FK_seguridad_usuarios_en_grupos_seguridad_grupos` FOREIGN KEY (`grupo`) REFERENCES `adelante_seguridad_grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_seguridad_usuarios_en_grupos_seguridad_usuarios` FOREIGN KEY (`usuario`) REFERENCES `adelante_seguridad_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELETE FROM `adelante_seguridad_usuarios_en_grupos`;
/*!40000 ALTER TABLE `adelante_seguridad_usuarios_en_grupos` DISABLE KEYS */;
INSERT INTO `adelante_seguridad_usuarios_en_grupos` (`usuario`, `grupo`, `activo`, `creado`) VALUES
	(1, 1, 1, '2018-08-03 13:36:18');
	
	
CREATE TABLE IF NOT EXISTS 	`adelante_seguridad_usuarios_acceso` (
	`id_user` int(11) not null,
	`tipo` varchar(50),
	`created_at` timestamp DEFAULT current_timestamp NOT NULL,
	`updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,  	
)
	
	
	
/*!40000 ALTER TABLE `adelante_seguridad_usuarios_en_grupos` ENABLE KEYS */;
