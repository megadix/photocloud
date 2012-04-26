CREATE TABLE `collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text,
  `path` varchar(256),
  `thumbnail_path` varchar(256),
  `thumbnail_width` smallint,
  `thumbnail_height` smallint,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128),
  `description` text,
  `collection_id` int(11) NOT NULL,
  `path` varchar(256),
  `width` smallint,
  `height` smallint,
  `thumbnail_path` varchar(256),
  `thumbnail_width` smallint,
  `thumbnail_height` smallint,
  
  PRIMARY KEY (`id`),
  KEY `collection_id` (`collection_id`),
  CONSTRAINT `collection_id` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`)
) ENGINE=InnoDB;

