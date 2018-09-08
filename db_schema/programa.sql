CREATE TABLE `adelante_programa_categorias` (
	`id` VARCHAR(9) NOT NULL,
	`codigo` VARCHAR(2) NULL DEFAULT NULL,
	`orden` INT(11) NOT NULL,
	`nombre` VARCHAR(100) NOT NULL,
	`padre` VARCHAR(9) NULL DEFAULT NULL,
	`intro` TEXT NULL,
	`icono` VARCHAR(100) NULL DEFAULT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `adelante_programa_propuestas` (
	`id` VARCHAR(9) NOT NULL,
	`cat` VARCHAR(9) NOT NULL,
	`texto` TEXT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `FK_adelante_programa_propuestas_adelante_programa_categorias` (`cat`),
	CONSTRAINT `FK_adelante_programa_propuestas_adelante_programa_categorias` FOREIGN KEY (`cat`) REFERENCES `adelante_programa_categorias` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `adelante_programa_enmiendas` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`idCategoria` VARCHAR(9) NULL DEFAULT NULL,
	`idPropuesta` VARCHAR(9) NULL DEFAULT NULL,
	`nombre` VARCHAR(50) NULL DEFAULT NULL,
	`apellidos` VARCHAR(50) NULL DEFAULT NULL,
	`cp` VARCHAR(5) NULL DEFAULT NULL,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`telefono` VARCHAR(50) NULL DEFAULT NULL,
	`ip` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'Select INET_NTOA(ip);',
	`tipo` VARCHAR(50) NULL DEFAULT NULL,
	`motivacion` VARCHAR(50) NULL DEFAULT NULL,
	`redacion` TEXT NULL,
	`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `FK_adelante_programa_enmiendas_adelante_programa_categorias` (`idCategoria`),
	INDEX `FK_adelante_programa_enmiendas_adelante_programa_propuestas` (`idPropuesta`),
	CONSTRAINT `FK_adelante_programa_enmiendas_adelante_programa_categorias` FOREIGN KEY (`idCategoria`) REFERENCES `adelante_programa_categorias` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK_adelante_programa_enmiendas_adelante_programa_propuestas` FOREIGN KEY (`idPropuesta`) REFERENCES `adelante_programa_propuestas` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
