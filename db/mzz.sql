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
# Data for the `news_news` table  (LIMIT 0,500)
#

INSERT INTO `news_news` (`id`, `obj_id`, `title`, `editor`, `text`, `folder_id`, `created`, `updated`) VALUES 
  (2,48,'sadf',2,'1111111111',2,1161647727,1161817920),
  (3,50,'qweqwer',2,'dsff',3,1161647948,1161647948);

COMMIT;

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
  (2,6,'root',1,'root'),
  (3,49,'zzz',2,'root/zzz');

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
  (1,1,4,1),
  (2,2,3,2);

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
  `action_id` int(11) unsigned default NULL,
  `class_section_id` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `uid` int(11) default NULL,
  `gid` int(11) default NULL,
  `allow` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `class_action_id` (`class_section_id`,`obj_id`,`uid`,`gid`),
  KEY `obj_id_gid` (`obj_id`,`gid`),
  KEY `obj_id_uid` (`obj_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access` table  (LIMIT 0,500)
#

INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `obj_id`, `uid`, `gid`, `allow`) VALUES 
  (334,1,1,0,1,NULL,0),
  (333,3,1,0,1,NULL,0),
  (413,9,3,0,NULL,1,0),
  (388,9,1,0,0,NULL,1),
  (387,2,1,0,0,NULL,1),
  (259,9,2,49,2,NULL,1),
  (238,6,2,49,NULL,2,1),
  (237,5,2,49,NULL,2,1),
  (244,6,2,49,NULL,1,0),
  (236,4,2,49,NULL,2,1),
  (412,2,3,0,NULL,1,0),
  (411,12,3,0,NULL,1,0),
  (394,9,2,0,0,NULL,1),
  (391,6,2,0,0,NULL,1),
  (390,5,2,0,0,NULL,1),
  (206,4,2,6,2,NULL,1),
  (375,2,1,48,2,NULL,1),
  (204,3,1,48,NULL,2,1),
  (203,3,1,48,NULL,1,1),
  (374,1,1,48,2,NULL,1),
  (386,1,1,0,0,NULL,1),
  (389,4,2,0,0,NULL,1),
  (211,9,1,6,2,NULL,1),
  (210,8,2,6,2,NULL,1),
  (209,7,2,6,2,NULL,1),
  (208,6,2,6,2,NULL,1),
  (207,5,2,6,2,NULL,1),
  (373,3,1,48,2,NULL,0),
  (258,8,2,49,2,NULL,1),
  (257,7,2,49,2,NULL,1),
  (219,1,1,50,2,NULL,1),
  (220,2,1,50,2,NULL,2),
  (221,3,1,50,NULL,1,1),
  (222,3,1,50,NULL,2,1),
  (223,9,1,50,2,NULL,1),
  (243,5,2,49,NULL,1,0),
  (242,4,2,49,NULL,1,1),
  (241,9,2,49,NULL,2,0),
  (240,8,2,49,NULL,2,0),
  (239,7,2,49,NULL,2,0),
  (245,7,2,49,NULL,1,0),
  (246,8,2,49,NULL,1,0),
  (247,9,2,49,NULL,1,0),
  (256,6,2,49,2,NULL,0),
  (255,5,2,49,2,NULL,0),
  (254,4,2,49,2,NULL,0),
  (393,8,2,0,0,NULL,1),
  (392,7,2,0,0,NULL,1),
  (336,9,1,0,1,NULL,0),
  (335,2,1,0,1,NULL,1),
  (410,1,3,0,NULL,1,0),
  (409,5,3,0,NULL,1,1),
  (408,11,3,0,NULL,1,0),
  (407,10,3,0,NULL,1,1),
  (385,3,1,0,0,NULL,1),
  (376,9,1,48,2,NULL,1),
  (372,9,2,0,NULL,1,0),
  (371,8,2,0,NULL,1,0),
  (370,7,2,0,NULL,1,0),
  (369,6,2,0,NULL,1,0),
  (368,5,2,0,NULL,1,1),
  (367,4,2,0,NULL,1,0),
  (355,4,2,0,NULL,2,1),
  (356,5,2,0,NULL,2,1),
  (357,6,2,0,NULL,2,1),
  (358,7,2,0,NULL,2,0),
  (359,8,2,0,NULL,2,0),
  (360,9,2,0,NULL,2,0),
  (414,10,3,0,NULL,2,0),
  (415,11,3,0,NULL,2,1),
  (416,5,3,0,NULL,2,1),
  (417,1,3,0,NULL,2,0),
  (418,12,3,0,NULL,2,0),
  (419,2,3,0,NULL,2,0),
  (420,9,3,0,NULL,2,0),
  (421,10,3,12,1,NULL,0),
  (422,11,3,12,1,NULL,0),
  (423,5,3,12,1,NULL,0),
  (424,1,3,12,1,NULL,1),
  (425,12,3,12,1,NULL,0),
  (426,2,3,12,1,NULL,0),
  (427,9,3,12,1,NULL,0);

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
  (8,'deleteFolder'),
  (9,'editACL'),
  (10,'login'),
  (11,'exit'),
  (12,'memberOf'),
  (13,'groupDelete'),
  (14,'groupsList'),
  (15,'groupEdit'),
  (16,'membersList'),
  (17,'addToGroup');

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
  (2,'newsFolder',1),
  (3,'user',2),
  (4,'group',2);

COMMIT;

#
# Structure for the `sys_access_classes_actions` table : 
#

DROP TABLE IF EXISTS `sys_access_classes_actions`;

CREATE TABLE `sys_access_classes_actions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `class_id` int(11) unsigned default NULL,
  `action_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_classes_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_classes_actions` (`id`, `class_id`, `action_id`) VALUES 
  (1,1,1),
  (2,1,2),
  (3,1,3),
  (4,1,9),
  (5,2,4),
  (6,2,5),
  (7,2,6),
  (8,2,7),
  (9,2,8),
  (10,2,9),
  (11,3,10),
  (12,3,11),
  (13,3,5),
  (14,3,1),
  (15,3,12),
  (16,3,2),
  (17,4,13),
  (18,4,14),
  (19,4,15),
  (20,4,16),
  (21,4,17),
  (22,3,9),
  (23,4,9);

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
  (2,2,1),
  (3,3,2),
  (4,4,2);

COMMIT;

#
# Structure for the `sys_access_classes_sections_actions_` table : 
#

DROP TABLE IF EXISTS `sys_access_classes_sections_actions_`;

CREATE TABLE `sys_access_classes_sections_actions_` (
  `id` int(11) NOT NULL auto_increment,
  `class_section_id` int(11) default NULL,
  `action_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_action_unique` (`class_section_id`,`action_id`),
  KEY `action_id` (`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_classes_sections_actions_` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_classes_sections_actions_` (`id`, `class_section_id`, `action_id`) VALUES 
  (1,1,1),
  (2,1,2),
  (3,1,3),
  (4,2,4),
  (5,2,5),
  (6,2,6),
  (7,2,7),
  (8,2,8),
  (9,1,9),
  (10,2,9);

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
  (1,'news'),
  (2,'user');

COMMIT;

#
# Structure for the `sys_access_registry` table : 
#

DROP TABLE IF EXISTS `sys_access_registry`;

CREATE TABLE `sys_access_registry` (
  `obj_id` int(11) unsigned default NULL,
  `class_section_id` int(11) unsigned default NULL,
  KEY `obj_id` (`obj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_registry` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES 
  (6,2),
  (46,1),
  (48,1),
  (49,2),
  (50,1),
  (12,3),
  (13,3),
  (14,4),
  (15,4);

COMMIT;

#
# Structure for the `sys_access_sections` table : 
#

DROP TABLE IF EXISTS `sys_access_sections`;

CREATE TABLE `sys_access_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_sections` (`id`, `name`) VALUES 
  (1,'news'),
  (2,'user');

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
  (45),
  (46),
  (47),
  (48),
  (49),
  (50),
  (51),
  (52);

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
  (1,1,1,50),
  (23,2,2,47);

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;