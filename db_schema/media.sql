
CREATE TABLE `adelante_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` char(20) NOT NULL DEFAULT '',
  `modid` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp NOT NULL,
  `updated_at` timestamp DEFAULT current_timestamp NOT NULL on update current_timestamp,
  PRIMARY KEY (`id`),
  KEY `modulo` (`modulo`),
  KEY `modid` (`modid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8