# SQL Manager 2005 for MySQL 3.7.5.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mzz


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES cp1251 */;

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `mzz`;

CREATE DATABASE `mzz`
    CHARACTER SET 'cp1251'
    COLLATE 'cp1251_general_ci';

USE `mzz`;

#
# Structure for the `news_news` table : 
#

DROP TABLE IF EXISTS `news_news`;

CREATE TABLE `news_news` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `editor` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `folder_id` int(11) default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  KEY `id` (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `news_newsfolder` table : 
#

DROP TABLE IF EXISTS `news_newsfolder`;

CREATE TABLE `news_newsfolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_newsfolder` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder` (`id`, `obj_id`, `name`, `parent`, `path`) VALUES 
  (1,6,'root',1,'root');

COMMIT;

#
# Structure for the `news_newsfolder_tree` table : 
#

DROP TABLE IF EXISTS `news_newsfolder_tree`;

CREATE TABLE `news_newsfolder_tree` (
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
# Data for the `news_newsfolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,2,1);

COMMIT;

#
# Structure for the `page_page` table : 
#

DROP TABLE IF EXISTS `page_page`;

CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `page_page` table  (LIMIT 0,500)
#

INSERT INTO `page_page` (`id`, `obj_id`, `name`, `title`, `content`) VALUES 
  (1,9,'main','ѕерва€ страница','Ёто перва€, главна€ страница'),
  (2,10,'404','404 Not Found','«апрашиваема€ страница не найдена!'),
  (3,11,'test','test','test');

COMMIT;

#
# Structure for the `sys_access` table : 
#

DROP TABLE IF EXISTS `sys_access`;

CREATE TABLE `sys_access` (
  `id` int(11) NOT NULL auto_increment,
  `class_section_action` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `uid` int(11) default NULL,
  `gid` int(11) default NULL,
  `allow` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `class_action_id` (`class_section_action`,`obj_id`,`uid`,`gid`),
  KEY `obj_id` (`obj_id`,`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access` table  (LIMIT 0,500)
#

INSERT INTO `sys_access` (`id`, `class_section_action`, `obj_id`, `uid`, `gid`, `allow`) VALUES 
  (146,3,0,NULL,1,1),
  (147,3,0,NULL,2,1),
  (148,4,0,NULL,2,1),
  (149,1,0,0,NULL,1),
  (150,2,0,0,NULL,2),
  (157,4,6,NULL,2,1),
  (158,5,6,NULL,2,0),
  (159,6,6,NULL,2,0),
  (160,7,6,NULL,2,0),
  (161,8,6,NULL,2,0),
  (163,5,0,NULL,2,1),
  (164,5,0,NULL,1,1),
  (165,6,0,NULL,2,1),
  (166,7,0,0,NULL,1),
  (167,8,0,0,NULL,1);

COMMIT;

#
# Structure for the `sys_access_actions` table : 
#

DROP TABLE IF EXISTS `sys_access_actions`;

CREATE TABLE `sys_access_actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_actions` (`id`, `name`) VALUES 
  (1,'edit'),
  (2,'delete'),
  (3,'view'),
  (4,'create'),
  (5,'list'),
  (6,'createFolder'),
  (7,'editFolder'),
  (8,'deleteFolder');

COMMIT;

#
# Structure for the `sys_access_classes` table : 
#

DROP TABLE IF EXISTS `sys_access_classes`;

CREATE TABLE `sys_access_classes` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `module_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_classes` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_classes` (`id`, `name`, `module_id`) VALUES 
  (1,'news',1),
  (2,'newsFolder',1);

COMMIT;

#
# Structure for the `sys_access_classes_sections` table : 
#

DROP TABLE IF EXISTS `sys_access_classes_sections`;

CREATE TABLE `sys_access_classes_sections` (
  `id` int(11) NOT NULL auto_increment,
  `class_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_section` (`section_id`,`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_classes_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_classes_sections` (`id`, `class_id`, `section_id`) VALUES 
  (1,1,1),
  (2,2,1);

COMMIT;

#
# Structure for the `sys_access_classes_sections_actions` table : 
#

DROP TABLE IF EXISTS `sys_access_classes_sections_actions`;

CREATE TABLE `sys_access_classes_sections_actions` (
  `id` int(11) NOT NULL auto_increment,
  `class_section_id` int(11) default NULL,
  `action_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_action_unique` (`class_section_id`,`action_id`),
  KEY `action_id` (`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_classes_sections_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_classes_sections_actions` (`id`, `class_section_id`, `action_id`) VALUES 
  (1,1,1),
  (2,1,2),
  (3,1,3),
  (4,2,4),
  (5,2,5),
  (6,2,6),
  (7,2,7),
  (8,2,8);

COMMIT;

#
# Structure for the `sys_access_modules` table : 
#

DROP TABLE IF EXISTS `sys_access_modules`;

CREATE TABLE `sys_access_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_modules` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_modules` (`id`, `name`) VALUES 
  (1,'news');

COMMIT;

#
# Structure for the `sys_access_sections` table : 
#

DROP TABLE IF EXISTS `sys_access_sections`;

CREATE TABLE `sys_access_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_sections` (`id`, `name`) VALUES 
  (1,'news');

COMMIT;

#
# Structure for the `sys_cfg` table : 
#

DROP TABLE IF EXISTS `sys_cfg`;

CREATE TABLE `sys_cfg` (
  `id` int(11) NOT NULL auto_increment,
  `section` varchar(255) NOT NULL default '',
  `module` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `section_module` (`section`,`module`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_cfg` table  (LIMIT 0,500)
#

INSERT INTO `sys_cfg` (`id`, `section`, `module`) VALUES 
  (1,'','common'),
  (2,'','news');

COMMIT;

#
# Structure for the `sys_cfg_values` table : 
#

DROP TABLE IF EXISTS `sys_cfg_values`;

CREATE TABLE `sys_cfg_values` (
  `id` int(11) NOT NULL auto_increment,
  `cfg_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cfg_id_name` (`cfg_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_cfg_values` table  (LIMIT 0,500)
#

INSERT INTO `sys_cfg_values` (`id`, `cfg_id`, `name`, `value`) VALUES 
  (1,1,'cache','true'),
  (2,2,'items_per_page','10');

COMMIT;

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
  (45);

COMMIT;

#
# Structure for the `user_group` table : 
#

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_group` table  (LIMIT 0,500)
#

INSERT INTO `user_group` (`id`, `obj_id`, `name`) VALUES 
  (1,14,'unauth'),
  (2,15,'auth');

COMMIT;

#
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_user` table  (LIMIT 0,500)
#

INSERT INTO `user_user` (`id`, `obj_id`, `login`, `password`) VALUES 
  (1,12,'guest',''),
  (2,13,'admin','098f6bcd4621d373cade4e832627b4f6');

COMMIT;

#
# Structure for the `user_usergroup_rel` table : 
#

DROP TABLE IF EXISTS `user_usergroup_rel`;

CREATE TABLE `user_usergroup_rel` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_usergroup_rel` table  (LIMIT 0,500)
#

INSERT INTO `user_usergroup_rel` (`id`, `group_id`, `user_id`, `obj_id`) VALUES 
  (1,1,1,50);

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;