# SQL Manager 2007 for MySQL 4.1.2.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mzz_test


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES cp1251 */;

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `mzz_test`;

CREATE DATABASE `mzz_test`
    CHARACTER SET 'cp1251'
    COLLATE 'cp1251_general_ci';

USE `mzz_test`;

#
# Structure for the `news_news` table : 
#

DROP TABLE IF EXISTS `news_news`;

CREATE TABLE `news_news` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) default NULL,
  `title` varchar(255) NOT NULL default '',
  `editor` int(11) NOT NULL default '0',
  `annotation` text,
  `text` text NOT NULL,
  `folder_id` int(11) default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `news_newsFolder` table : 
#

DROP TABLE IF EXISTS `news_newsFolder`;

CREATE TABLE `news_newsFolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) default NULL,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `news_newsFolder_tree` table : 
#

DROP TABLE IF EXISTS `news_newsFolder_tree`;

CREATE TABLE `news_newsFolder_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `page_page` table : 
#

DROP TABLE IF EXISTS `page_page`;

CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `compiled` tinyint(1) unsigned default '0',
  `obj_id` int(11) default NULL,
  `folder_id` int(11) NOT NULL default '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `page_pageFolder` table : 
#

DROP TABLE IF EXISTS `page_pageFolder`;

CREATE TABLE `page_pageFolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `page_pageFolder_tree` table : 
#

DROP TABLE IF EXISTS `page_pageFolder_tree`;

CREATE TABLE `page_pageFolder_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`),
  KEY `level` (`level`,`lkey`),
  KEY `rkey` (`rkey`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_catalogue` table : 
#

DROP TABLE IF EXISTS `simple_catalogue`;

CREATE TABLE `simple_catalogue` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `name` varchar(255) NOT NULL default '',
  `editor` int(11) default NULL,
  `created` int(11) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_catalogue_data` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_data`;

CREATE TABLE `simple_catalogue_data` (
  `id` int(11) NOT NULL default '0',
  `property_type` int(11) unsigned default NULL,
  `text` text,
  `char` varchar(255) default NULL,
  `float` float(9,3) default NULL,
  `date` datetime default NULL,
  UNIQUE KEY `property_type` (`property_type`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_catalogue_properties` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_properties`;

CREATE TABLE `simple_catalogue_properties` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `type_id` int(11) unsigned default NULL,
  `args` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_catalogue_properties_types` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_properties_types`;

CREATE TABLE `simple_catalogue_properties_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_catalogue_types` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_types`;

CREATE TABLE `simple_catalogue_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_catalogue_types_props` table : 
#

DROP TABLE IF EXISTS `simple_catalogue_types_props`;

CREATE TABLE `simple_catalogue_types_props` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `property_id` int(11) unsigned default NULL,
  `sort` int(11) NOT NULL default '0',
  `isShort` tinyint(1) unsigned default '0',
  `isFull` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_id` (`type_id`,`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_stubSimple` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple`;

CREATE TABLE `simple_stubSimple` (
  `id` int(11) NOT NULL auto_increment,
  `foo` varchar(10) default NULL,
  `bar` varchar(10) default NULL,
  `path` varchar(255) default NULL,
  `obj_id` int(11) default NULL,
  `tree_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `simple_stubSimple` table  (LIMIT 0,500)
#

INSERT INTO `simple_stubSimple` (`id`, `foo`, `bar`, `path`, `obj_id`, `tree_id`) VALUES 
  (1,'foo','bar',NULL,12,NULL);

COMMIT;

#
# Structure for the `simple_stubSimple2` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple2`;

CREATE TABLE `simple_stubSimple2` (
  `id` int(11) NOT NULL auto_increment,
  `foo` varchar(10) default NULL,
  `bar` varchar(10) default NULL,
  `path` varchar(255) default NULL,
  `obj_id` int(11) default NULL,
  `some_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `simple_stubSimple2` table  (LIMIT 0,500)
#

INSERT INTO `simple_stubSimple2` (`id`, `foo`, `bar`, `path`, `obj_id`, `some_id`) VALUES 
  (1,'foo1','bar1','foo1',NULL,1),
  (2,'foo2','bar2','foo1/foo2',NULL,2),
  (3,'foo3','bar3','foo1/foo3',NULL,3),
  (4,'foo4','bar4','foo1/foo4',NULL,4),
  (5,'foo5','bar5','foo1/foo2/foo5',NULL,5),
  (6,'foo6','bar6','foo1/foo2/foo6',NULL,6),
  (7,'foo7','bar7','foo1/foo3/foo7',NULL,7),
  (8,'foo8','bar8','foo1/foo3/foo8',NULL,8);

COMMIT;

#
# Structure for the `simple_stubSimple2_tree` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple2_tree`;

CREATE TABLE `simple_stubSimple2_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  `some_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `simple_stubSimple2_tree` table  (LIMIT 0,500)
#

INSERT INTO `simple_stubSimple2_tree` (`id`, `lkey`, `rkey`, `level`, `some_id`) VALUES 
  (1,1,16,1,1),
  (2,2,7,2,1),
  (3,8,13,2,1),
  (4,14,15,2,1),
  (5,3,4,3,1),
  (6,5,6,3,1),
  (7,9,10,3,1),
  (8,11,12,3,1);

COMMIT;

#
# Structure for the `simple_stubSimple3` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple3`;

CREATE TABLE `simple_stubSimple3` (
  `id` int(11) NOT NULL auto_increment,
  `foo` varchar(10) default NULL,
  `bar` varchar(10) default NULL,
  `path` varchar(255) default NULL,
  `joinfield` int(11) unsigned default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_stubSimple_tree` table : 
#

DROP TABLE IF EXISTS `simple_stubSimple_tree`;

CREATE TABLE `simple_stubSimple_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_access` table : 
#

DROP TABLE IF EXISTS `sys_access`;

CREATE TABLE `sys_access` (
  `id` int(11) NOT NULL auto_increment,
  `action_id` int(11) unsigned default NULL,
  `class_section_id` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `uid` int(11) default NULL,
  `gid` int(11) default NULL,
  `allow` tinyint(1) unsigned default '0',
  `deny` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `class_action_id` (`class_section_id`,`obj_id`,`uid`,`gid`),
  KEY `obj_id_gid` (`obj_id`,`gid`),
  KEY `obj_id_uid` (`obj_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_access_registry` table : 
#

DROP TABLE IF EXISTS `sys_access_registry`;

CREATE TABLE `sys_access_registry` (
  `obj_id` int(11) unsigned default NULL,
  `class_section_id` int(11) unsigned default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_registry` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES 
  (67,1),
  (68,1),
  (1,2),
  (2,1),
  (3,1);

COMMIT;

#
# Structure for the `sys_actions` table : 
#

DROP TABLE IF EXISTS `sys_actions`;

CREATE TABLE `sys_actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_cfg` table : 
#

DROP TABLE IF EXISTS `sys_cfg`;

CREATE TABLE `sys_cfg` (
  `id` int(11) NOT NULL auto_increment,
  `section` int(11) NOT NULL default '0',
  `module` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `section_module` (`section`,`module`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_cfg_titles` table : 
#

DROP TABLE IF EXISTS `sys_cfg_titles`;

CREATE TABLE `sys_cfg_titles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_cfg_values` table : 
#

DROP TABLE IF EXISTS `sys_cfg_values`;

CREATE TABLE `sys_cfg_values` (
  `id` int(11) NOT NULL auto_increment,
  `cfg_id` int(11) NOT NULL default '0',
  `name` int(11) NOT NULL default '0',
  `title` int(11) unsigned default NULL,
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cfg_id_name` (`cfg_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_cfg_vars` table : 
#

DROP TABLE IF EXISTS `sys_cfg_vars`;

CREATE TABLE `sys_cfg_vars` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_classes` table : 
#

DROP TABLE IF EXISTS `sys_classes`;

CREATE TABLE `sys_classes` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `module_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_classes` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) VALUES 
  (3,'stubSimpleForTree',NULL),
  (4,'stubSimple',1);

COMMIT;

#
# Structure for the `sys_classes_actions` table : 
#

DROP TABLE IF EXISTS `sys_classes_actions`;

CREATE TABLE `sys_classes_actions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `class_id` int(11) unsigned default NULL,
  `action_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_classes_sections` table : 
#

DROP TABLE IF EXISTS `sys_classes_sections`;

CREATE TABLE `sys_classes_sections` (
  `id` int(11) NOT NULL auto_increment,
  `class_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_section` (`section_id`,`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_classes_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) VALUES 
  (1,1,1),
  (2,2,1);

COMMIT;

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_obj_id` table : 
#

DROP TABLE IF EXISTS `sys_obj_id`;

CREATE TABLE `sys_obj_id` (
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

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
  (12);

COMMIT;

#
# Structure for the `sys_obj_id_named` table : 
#

DROP TABLE IF EXISTS `sys_obj_id_named`;

CREATE TABLE `sys_obj_id_named` (
  `obj_id` int(11) unsigned default NULL,
  `name` char(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_sections` table : 
#

DROP TABLE IF EXISTS `sys_sections`;

CREATE TABLE `sys_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_sections` (`id`, `name`) VALUES 
  (1,'simple'),
  (2,'page'),
  (3,'user');

COMMIT;

#
# Structure for the `sys_sessions` table : 
#

DROP TABLE IF EXISTS `sys_sessions`;

CREATE TABLE `sys_sessions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sid` varchar(50) NOT NULL default '',
  `ts` int(11) unsigned NOT NULL default '0',
  `valid` enum('yes','no') NOT NULL default 'yes',
  `data` text,
  PRIMARY KEY  (`id`),
  KEY `valid` (`valid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `treeNS` table : 
#

DROP TABLE IF EXISTS `treeNS`;

CREATE TABLE `treeNS` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `lkey` int(11) unsigned default NULL,
  `rkey` int(11) unsigned default NULL,
  `level` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `user_group` table : 
#

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `obj_id` int(11) default NULL,
  `is_default` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `obj_id` int(11) default NULL,
  `created` int(11) default NULL,
  `confirmed` int(11) default NULL,
  `last_login` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_user` table  (LIMIT 0,500)
#

INSERT INTO `user_user` (`id`, `login`, `password`, `obj_id`, `created`, `confirmed`, `last_login`) VALUES 
  (1,'GUEST','',NULL,NULL,NULL,NULL),
  (2,'GUEST','',NULL,NULL,NULL,NULL);

COMMIT;

#
# Structure for the `user_userGroup_rel` table : 
#

DROP TABLE IF EXISTS `user_userGroup_rel`;

CREATE TABLE `user_userGroup_rel` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `user_userOnline` table : 
#

DROP TABLE IF EXISTS `user_userOnline`;

CREATE TABLE `user_userOnline` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `session` char(32) default NULL,
  `last_activity` datetime default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`,`session`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;