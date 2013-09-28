# Дамп таблицы page_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page_page`;

CREATE TABLE `page_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `folder_id` int(11) unsigned DEFAULT NULL,
  `allow_comment` tinyint(4) DEFAULT '1',
  `compiled` int(11) DEFAULT NULL,
  `keywords_reset` tinyint(1) DEFAULT '0',
  `description_reset` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`(8)),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы page_page_lang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page_page_lang`;

CREATE TABLE `page_page_lang` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lang_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Дамп таблицы page_pageFolder
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page_pageFolder`;

CREATE TABLE `page_pageFolder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `page_pageFolder` WRITE;
/*!40000 ALTER TABLE `page_pageFolder` DISABLE KEYS */;

INSERT INTO `page_pageFolder` (`id`, `name`)
VALUES
	(1,'root');

/*!40000 ALTER TABLE `page_pageFolder` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы page_pageFolder_lang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page_pageFolder_lang`;

CREATE TABLE `page_pageFolder_lang` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lang_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `page_pageFolder_lang` WRITE;
/*!40000 ALTER TABLE `page_pageFolder_lang` DISABLE KEYS */;

INSERT INTO `page_pageFolder_lang` (`id`, `lang_id`, `title`)
VALUES
	(1,2,'root');

/*!40000 ALTER TABLE `page_pageFolder_lang` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы page_pageFolder_tree
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page_pageFolder_tree`;

CREATE TABLE `page_pageFolder_tree` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `path` text,
  `foreign_key` int(11) DEFAULT NULL,
  `level` int(11) unsigned DEFAULT NULL,
  `spath` text,
  PRIMARY KEY (`id`),
  KEY `path` (`path`(8)),
  KEY `spath` (`spath`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `page_pageFolder_tree` WRITE;
/*!40000 ALTER TABLE `page_pageFolder_tree` DISABLE KEYS */;

INSERT INTO `page_pageFolder_tree` (`id`, `path`, `foreign_key`, `level`, `spath`)
VALUES
	(1,'root/',1,1,'1/');

/*!40000 ALTER TABLE `page_pageFolder_tree` ENABLE KEYS */;
UNLOCK TABLES;
