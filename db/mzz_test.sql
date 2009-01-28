# SQL Manager 2007 for MySQL 4.4.0.5
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mzz_test


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `mzz_test`;

CREATE DATABASE `mzz_test`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `mzz_test`;

#
# Structure for the `news_news` table : 
#

DROP TABLE IF EXISTS `news_news`;

CREATE TABLE `news_news` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `editor` INTEGER(11) NOT NULL DEFAULT '0',
  `annotation` TEXT COLLATE utf8_general_ci,
  `text` TEXT COLLATE utf8_general_ci NOT NULL,
  `folder_id` INTEGER(11) DEFAULT NULL,
  `created` INTEGER(11) DEFAULT NULL,
  `updated` INTEGER(11) DEFAULT NULL,
  KEY `id` (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `news_newsFolder` table : 
#

DROP TABLE IF EXISTS `news_newsFolder`;

CREATE TABLE `news_newsFolder` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent` INTEGER(11) DEFAULT '0',
  `path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `news_newsFolder_tree` table : 
#

DROP TABLE IF EXISTS `news_newsFolder_tree`;

CREATE TABLE `news_newsFolder_tree` (
  `id` INTEGER(10) NOT NULL AUTO_INCREMENT,
  `lkey` INTEGER(10) NOT NULL DEFAULT '0',
  `rkey` INTEGER(10) NOT NULL DEFAULT '0',
  `level` INTEGER(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `left_key` (`lkey`, `rkey`, `level`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `ormRelated` table : 
#

DROP TABLE IF EXISTS `ormRelated`;

CREATE TABLE `ormRelated` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `baz` CHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `ormSimple` table : 
#

DROP TABLE IF EXISTS `ormSimple`;

CREATE TABLE `ormSimple` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `foo` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `bar` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `related` INTEGER(11) DEFAULT NULL,
  `deleted` TINYINT(1) DEFAULT '0',
  `version` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `ormSimpleRelated` table : 
#

DROP TABLE IF EXISTS `ormSimpleRelated`;

CREATE TABLE `ormSimpleRelated` (
  `simple_id` INTEGER(11) DEFAULT NULL,
  `related_id` INTEGER(11) DEFAULT NULL
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `ormSimple_tree` table : 
#

DROP TABLE IF EXISTS `ormSimple_tree`;

CREATE TABLE `ormSimple_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` TEXT COLLATE utf8_general_ci,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `ormSimple_version` table : 
#

DROP TABLE IF EXISTS `ormSimple_version`;

CREATE TABLE `ormSimple_version` (
  `id` INTEGER(11) UNSIGNED NOT NULL,
  `foo` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `bar` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `related` INTEGER(11) DEFAULT NULL,
  `deleted` TINYINT(1) DEFAULT '0',
  `version` INTEGER(11) DEFAULT NULL
)ENGINE=MyISAM
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `page_page` table : 
#

DROP TABLE IF EXISTS `page_page`;

CREATE TABLE `page_page` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `compiled` TINYINT(1) UNSIGNED DEFAULT '0',
  `obj_id` INTEGER(11) DEFAULT NULL,
  `folder_id` INTEGER(11) NOT NULL DEFAULT '0',
  `allow_comment` TINYINT(4) DEFAULT '1',
  `keywords_reset` TINYINT(1) DEFAULT '0',
  `description_reset` TINYINT(1) DEFAULT '0',
  KEY `id` (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `page_pageFolder` table : 
#

DROP TABLE IF EXISTS `page_pageFolder`;

CREATE TABLE `page_pageFolder` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent` INTEGER(11) DEFAULT '0',
  `path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `page_pageFolder_tree` table : 
#

DROP TABLE IF EXISTS `page_pageFolder_tree`;

CREATE TABLE `page_pageFolder_tree` (
  `id` INTEGER(10) NOT NULL AUTO_INCREMENT,
  `lkey` INTEGER(10) NOT NULL DEFAULT '0',
  `rkey` INTEGER(10) NOT NULL DEFAULT '0',
  `level` INTEGER(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `left_key` (`lkey`, `rkey`, `level`),
  KEY `level` (`level`, `lkey`),
  KEY `rkey` (`rkey`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `page_page_lang` table : 
#

DROP TABLE IF EXISTS `page_page_lang`;

CREATE TABLE `page_page_lang` (
  `id` INTEGER(11) NOT NULL DEFAULT '0',
  `lang_id` INTEGER(11) NOT NULL DEFAULT '0',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` TEXT COLLATE utf8_general_ci NOT NULL,
  `keywords` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `description` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_catalogue` table : 
#

DROP TABLE IF EXISTS `simple_catalogue`;

CREATE TABLE `simple_catalogue` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `editor` INTEGER(11) DEFAULT NULL,
  `created` INTEGER(11) DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_catalogue_data` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_data`;

CREATE TABLE `simple_catalogue_data` (
  `id` INTEGER(11) NOT NULL DEFAULT '0',
  `property_type` INTEGER(11) UNSIGNED DEFAULT NULL,
  `text` TEXT COLLATE utf8_general_ci,
  `char` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `float` FLOAT(9,3) DEFAULT NULL,
  `date` DATETIME DEFAULT NULL,
  UNIQUE KEY `property_type` (`property_type`, `id`)
)ENGINE=MyISAM
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_catalogue_properties` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_properties`;

CREATE TABLE `simple_catalogue_properties` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `type_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `args` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_catalogue_properties_types` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_properties_types`;

CREATE TABLE `simple_catalogue_properties_types` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_catalogue_types` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_types`;

CREATE TABLE `simple_catalogue_types` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_catalogue_types_props` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_types_props`;

CREATE TABLE `simple_catalogue_types_props` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `property_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `sort` INTEGER(11) NOT NULL DEFAULT '0',
  `isShort` TINYINT(1) UNSIGNED DEFAULT '0',
  `isFull` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_id` (`type_id`, `property_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_stubSimple` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple`;

CREATE TABLE `simple_stubSimple` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `foo` VARCHAR(10) COLLATE utf8_general_ci DEFAULT NULL,
  `bar` VARCHAR(10) COLLATE utf8_general_ci DEFAULT NULL,
  `path` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `tree_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_stubSimple2` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple2`;

CREATE TABLE `simple_stubSimple2` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `foo` VARCHAR(10) COLLATE utf8_general_ci DEFAULT NULL,
  `bar` VARCHAR(10) COLLATE utf8_general_ci DEFAULT NULL,
  `path` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `some_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_stubSimple2_tree` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple2_tree`;

CREATE TABLE `simple_stubSimple2_tree` (
  `id` INTEGER(10) NOT NULL AUTO_INCREMENT,
  `lkey` INTEGER(10) NOT NULL DEFAULT '0',
  `rkey` INTEGER(10) NOT NULL DEFAULT '0',
  `level` INTEGER(10) NOT NULL DEFAULT '0',
  `some_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `left_key` (`lkey`, `rkey`, `level`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_stubSimple3` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple3`;

CREATE TABLE `simple_stubSimple3` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `foo` VARCHAR(10) COLLATE utf8_general_ci DEFAULT NULL,
  `bar` VARCHAR(10) COLLATE utf8_general_ci DEFAULT NULL,
  `path` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `joinfield` INTEGER(11) UNSIGNED DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_stubSimple_lang` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple_lang`;

CREATE TABLE `simple_stubSimple_lang` (
  `id` INTEGER(11) DEFAULT NULL,
  `lang_id` INTEGER(11) DEFAULT NULL,
  `foo` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `simple_stubSimple_tree` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple_tree`;

CREATE TABLE `simple_stubSimple_tree` (
  `id` INTEGER(10) NOT NULL AUTO_INCREMENT,
  `lkey` INTEGER(10) NOT NULL DEFAULT '0',
  `rkey` INTEGER(10) NOT NULL DEFAULT '0',
  `level` INTEGER(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `left_key` (`lkey`, `rkey`, `level`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_access` table : 
#

DROP TABLE IF EXISTS `sys_access`;

CREATE TABLE `sys_access` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `action_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `class_section_id` INTEGER(11) DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `uid` INTEGER(11) DEFAULT NULL,
  `gid` INTEGER(11) DEFAULT NULL,
  `allow` TINYINT(1) UNSIGNED DEFAULT '0',
  `deny` TINYINT(1) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `class_action_id` (`class_section_id`, `obj_id`, `uid`, `gid`),
  KEY `obj_id_gid` (`obj_id`, `gid`),
  KEY `obj_id_uid` (`obj_id`, `uid`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_access_registry` table : 
#

DROP TABLE IF EXISTS `sys_access_registry`;

CREATE TABLE `sys_access_registry` (
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `class_section_id` INTEGER(11) UNSIGNED DEFAULT NULL
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_actions` table : 
#

DROP TABLE IF EXISTS `sys_actions`;

CREATE TABLE `sys_actions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_cfg` table : 
#

DROP TABLE IF EXISTS `sys_cfg`;

CREATE TABLE `sys_cfg` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `section` INTEGER(11) NOT NULL DEFAULT '0',
  `module` INTEGER(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_module` (`section`, `module`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_cfg_titles` table : 
#

DROP TABLE IF EXISTS `sys_cfg_titles`;

CREATE TABLE `sys_cfg_titles` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_cfg_types` table : 
#

DROP TABLE IF EXISTS `sys_cfg_types`;

CREATE TABLE `sys_cfg_types` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_cfg_values` table : 
#

DROP TABLE IF EXISTS `sys_cfg_values`;

CREATE TABLE `sys_cfg_values` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `cfg_id` INTEGER(11) NOT NULL DEFAULT '0',
  `name` INTEGER(11) NOT NULL DEFAULT '0',
  `title` INTEGER(11) UNSIGNED DEFAULT NULL,
  `type_id` INTEGER(11) NOT NULL DEFAULT '0',
  `value` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cfg_id_name` (`cfg_id`, `name`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_cfg_vars` table : 
#

DROP TABLE IF EXISTS `sys_cfg_vars`;

CREATE TABLE `sys_cfg_vars` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_classes` table : 
#

DROP TABLE IF EXISTS `sys_classes`;

CREATE TABLE `sys_classes` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `module_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_classes_actions` table : 
#

DROP TABLE IF EXISTS `sys_classes_actions`;

CREATE TABLE `sys_classes_actions` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `action_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_classes_sections` table : 
#

DROP TABLE IF EXISTS `sys_classes_sections`;

CREATE TABLE `sys_classes_sections` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `class_id` INTEGER(11) DEFAULT NULL,
  `section_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_section` (`section_id`, `class_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_lang` table : 
#

DROP TABLE IF EXISTS `sys_lang`;

CREATE TABLE `sys_lang` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_lang_lang` table : 
#

DROP TABLE IF EXISTS `sys_lang_lang`;

CREATE TABLE `sys_lang_lang` (
  `id` INTEGER(11) UNSIGNED NOT NULL,
  `lang_id` INTEGER(11) UNSIGNED NOT NULL,
  `name` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_obj_id` table : 
#

DROP TABLE IF EXISTS `sys_obj_id`;

CREATE TABLE `sys_obj_id` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=68 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_obj_id` table  (LIMIT 0,500)
#

INSERT INTO `sys_obj_id` (`id`) VALUES 
  (1),
  (2),
  (3),
  (4),
  (5),
  (6),
  (7),
  (8),
  (9),
  (10),
  (11),
  (12),
  (13),
  (14),
  (15),
  (16),
  (17),
  (18),
  (19),
  (20),
  (21),
  (22),
  (23),
  (24),
  (25),
  (26),
  (27),
  (28),
  (29),
  (30),
  (31),
  (32),
  (33),
  (34),
  (35),
  (36),
  (37),
  (38),
  (39),
  (40),
  (41),
  (42),
  (43),
  (44),
  (45),
  (46),
  (47),
  (48),
  (49),
  (50),
  (51),
  (52),
  (53),
  (54),
  (55),
  (56),
  (57),
  (58),
  (59),
  (60),
  (61),
  (62),
  (63),
  (64),
  (65),
  (66),
  (67);
COMMIT;

#
# Structure for the `sys_obj_id_named` table : 
#

DROP TABLE IF EXISTS `sys_obj_id_named`;

CREATE TABLE `sys_obj_id_named` (
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_sections` table : 
#

DROP TABLE IF EXISTS `sys_sections`;

CREATE TABLE `sys_sections` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=4 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_sections` (`id`, `name`) VALUES 
  (1,'page'),
  (2,'simple'),
  (3,'user');
COMMIT;

#
# Structure for the `sys_sessions` table : 
#

DROP TABLE IF EXISTS `sys_sessions`;

CREATE TABLE `sys_sessions` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `ts` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `valid` ENUM('yes','no') NOT NULL DEFAULT 'yes',
  `data` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`),
  KEY `valid` (`valid`),
  KEY `sid` (`sid`)
)ENGINE=MyISAM
AUTO_INCREMENT=311 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `treeNS` table : 
#

DROP TABLE IF EXISTS `treeNS`;

CREATE TABLE `treeNS` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lkey` INTEGER(11) UNSIGNED DEFAULT NULL,
  `rkey` INTEGER(11) UNSIGNED DEFAULT NULL,
  `level` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `user_group` table : 
#

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `is_default` TINYINT(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `password` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `obj_id` INTEGER(11) DEFAULT NULL,
  `created` INTEGER(11) DEFAULT NULL,
  `confirmed` INTEGER(11) DEFAULT NULL,
  `last_login` INTEGER(11) DEFAULT NULL,
  `language_id` INTEGER(11) DEFAULT NULL,
  `timezone` INTEGER(11) DEFAULT '3',
  `skin` INTEGER(11) UNSIGNED DEFAULT '1',
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `user_userGroup_rel` table : 
#

DROP TABLE IF EXISTS `user_userGroup_rel`;

CREATE TABLE `user_userGroup_rel` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `group_id` INTEGER(11) DEFAULT NULL,
  `user_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`, `user_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `user_userOnline` table : 
#

DROP TABLE IF EXISTS `user_userOnline`;

CREATE TABLE `user_userOnline` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER(11) DEFAULT NULL,
  `session` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  `last_activity` DATETIME DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`, `session`),
  KEY `last_activity` (`last_activity`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;