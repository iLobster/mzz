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
# Structure for the `comments_comments` table : 
#

DROP TABLE IF EXISTS `comments_comments`;

CREATE TABLE `comments_comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `text` text,
  `author` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  `folder_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `comments_commentsfolder` table : 
#

DROP TABLE IF EXISTS `comments_commentsfolder`;

CREATE TABLE `comments_commentsfolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `parent_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=734 DEFAULT CHARSET=cp1251;

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
# Structure for the `sys_actions` table : 
#

DROP TABLE IF EXISTS `sys_actions`;

CREATE TABLE `sys_actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_cfg` table : 
#

DROP TABLE IF EXISTS `sys_cfg`;

CREATE TABLE `sys_cfg` (
  `id` int(11) NOT NULL auto_increment,
  `section` int(11) NOT NULL,
  `module` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `section_module` (`section`,`module`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_classes_sections` table : 
#

DROP TABLE IF EXISTS `sys_classes_sections`;

CREATE TABLE `sys_classes_sections` (
  `id` int(11) NOT NULL auto_increment,
  `class_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_section` (`section_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_obj_id` table : 
#

DROP TABLE IF EXISTS `sys_obj_id`;

CREATE TABLE `sys_obj_id` (
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=cp1251;

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
  UNIQUE KEY `name` (`name`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251;

#
# Structure for the `user_group` table : 
#

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=cp1251;

#
# Data for the `comments_commentsfolder` table  (LIMIT 0,500)
#

INSERT INTO `comments_commentsfolder` (`id`, `obj_id`, `parent_id`) VALUES 
  (1,76,66);

COMMIT;

#
# Data for the `news_news` table  (LIMIT 0,500)
#

INSERT INTO `news_news` (`id`, `obj_id`, `title`, `editor`, `text`, `folder_id`, `created`, `updated`) VALUES 
  (2,48,'sadf',2,'asdqw3423',2,1161647727,1163427724),
  (3,50,'qweqwer',2,'dsff',3,1161647948,1161647948),
  (4,66,'qweqwe',2,'234',2,1162960578,1163427143);

COMMIT;

#
# Data for the `news_newsfolder` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder` (`id`, `obj_id`, `name`, `parent`, `path`) VALUES 
  (2,6,'root',1,'root'),
  (3,49,'zzz',2,'root/zzz');

COMMIT;

#
# Data for the `news_newsfolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,4,1),
  (2,2,3,2);

COMMIT;

#
# Data for the `page_page` table  (LIMIT 0,500)
#

INSERT INTO `page_page` (`id`, `obj_id`, `name`, `title`, `content`) VALUES 
  (1,9,'main','Первая страница','Это первая, главная страница'),
  (2,10,'404','404 Not Found','Запрашиваемая страница не найдена!'),
  (3,11,'test','test','test'),
  (4,57,'403','Доступ запрещён','Доступ запрещён');

COMMIT;

#
# Data for the `sys_access` table  (LIMIT 0,500)
#

INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `obj_id`, `uid`, `gid`, `allow`) VALUES 
  (683,9,1,0,1,NULL,0),
  (682,2,1,0,1,NULL,0),
  (413,9,3,0,NULL,1,0),
  (388,9,1,0,0,NULL,1),
  (387,2,1,0,0,NULL,1),
  (665,9,2,49,2,NULL,1),
  (671,9,2,49,NULL,2,1),
  (670,8,2,49,NULL,2,1),
  (695,9,1,66,1,NULL,0),
  (669,7,2,49,NULL,2,1),
  (412,2,3,0,NULL,1,0),
  (411,12,3,0,NULL,1,0),
  (394,9,2,0,0,NULL,1),
  (391,6,2,0,0,NULL,1),
  (390,5,2,0,0,NULL,1),
  (441,9,2,6,2,NULL,1),
  (691,9,1,48,2,NULL,1),
  (659,9,1,48,NULL,2,1),
  (203,3,1,48,NULL,1,1),
  (690,2,1,48,2,NULL,1),
  (386,1,1,0,0,NULL,1),
  (389,4,2,0,0,NULL,1),
  (440,8,2,6,2,NULL,1),
  (439,7,2,6,2,NULL,1),
  (438,6,2,6,2,NULL,1),
  (437,5,2,6,2,NULL,1),
  (436,4,2,6,2,NULL,1),
  (689,1,1,48,2,NULL,1),
  (664,8,2,49,2,NULL,1),
  (663,7,2,49,2,NULL,1),
  (219,1,1,50,2,NULL,1),
  (220,2,1,50,2,NULL,1),
  (221,3,1,50,NULL,1,1),
  (222,3,1,50,NULL,2,1),
  (223,9,1,50,2,NULL,1),
  (724,9,1,66,2,NULL,1),
  (694,2,1,66,1,NULL,1),
  (668,6,2,49,NULL,2,1),
  (667,5,2,49,NULL,2,1),
  (666,4,2,49,NULL,2,1),
  (723,2,1,66,2,NULL,1),
  (693,1,1,66,1,NULL,0),
  (722,1,1,66,2,NULL,1),
  (662,6,2,49,2,NULL,1),
  (661,5,2,49,2,NULL,1),
  (660,4,2,49,2,NULL,1),
  (393,8,2,0,0,NULL,1),
  (392,7,2,0,0,NULL,1),
  (681,1,1,0,1,NULL,0),
  (680,3,1,0,1,NULL,1),
  (410,1,3,0,NULL,1,0),
  (409,5,3,0,NULL,1,1),
  (408,11,3,0,NULL,1,1),
  (407,10,3,0,NULL,1,1),
  (385,3,1,0,0,NULL,1),
  (688,3,1,48,2,NULL,1),
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
  (428,3,5,19,NULL,1,1),
  (429,3,5,19,NULL,2,1),
  (442,10,3,12,NULL,1,1),
  (589,9,3,13,NULL,2,1),
  (466,9,6,9,NULL,1,0),
  (465,2,6,9,NULL,1,0),
  (464,1,6,9,NULL,1,0),
  (463,4,6,9,NULL,1,0),
  (462,5,6,9,NULL,1,1),
  (468,5,6,9,NULL,2,0),
  (467,3,6,9,NULL,2,1),
  (461,3,6,9,NULL,1,1),
  (469,4,6,9,NULL,2,0),
  (470,1,6,9,NULL,2,1),
  (471,2,6,9,NULL,2,0),
  (472,9,6,9,NULL,2,1),
  (486,3,6,10,NULL,2,1),
  (485,9,6,10,NULL,1,0),
  (484,2,6,10,NULL,1,0),
  (483,1,6,10,NULL,1,0),
  (482,4,6,10,NULL,1,0),
  (481,5,6,10,NULL,1,1),
  (480,3,6,10,NULL,1,1),
  (487,5,6,10,NULL,2,1),
  (488,4,6,10,NULL,2,1),
  (489,1,6,10,NULL,2,1),
  (490,2,6,10,NULL,2,0),
  (491,9,6,10,NULL,2,1),
  (504,9,6,11,NULL,2,1),
  (503,2,6,11,NULL,2,1),
  (502,1,6,11,NULL,2,1),
  (501,4,6,11,NULL,2,1),
  (500,5,6,11,NULL,2,1),
  (499,3,6,11,NULL,2,1),
  (505,3,6,11,NULL,1,1),
  (506,5,6,11,NULL,1,1),
  (507,4,6,11,NULL,1,0),
  (508,1,6,11,NULL,1,0),
  (509,2,6,11,NULL,1,0),
  (510,9,6,11,NULL,1,0),
  (546,9,3,55,NULL,1,0),
  (539,9,3,55,NULL,2,1),
  (545,2,3,55,NULL,1,0),
  (538,2,3,55,NULL,2,1),
  (544,12,3,55,NULL,1,0),
  (537,12,3,55,NULL,2,1),
  (543,1,3,55,NULL,1,0),
  (536,1,3,55,NULL,2,1),
  (542,5,3,55,NULL,1,1),
  (535,5,3,55,NULL,2,1),
  (541,11,3,55,NULL,1,1),
  (534,11,3,55,NULL,2,1),
  (540,10,3,55,NULL,1,1),
  (533,10,3,55,NULL,2,1),
  (588,2,3,13,NULL,2,1),
  (587,12,3,13,NULL,2,1),
  (586,1,3,13,NULL,2,1),
  (585,5,3,13,NULL,2,1),
  (584,11,3,13,NULL,2,1),
  (583,10,3,13,NULL,2,1),
  (548,14,4,56,NULL,2,1),
  (549,15,4,56,NULL,2,1),
  (550,16,4,56,NULL,2,1),
  (551,17,4,56,NULL,2,1),
  (552,13,4,56,NULL,2,1),
  (553,9,4,56,NULL,2,1),
  (555,14,4,15,NULL,2,1),
  (556,15,4,15,NULL,2,1),
  (557,16,4,15,NULL,2,1),
  (558,17,4,15,NULL,2,1),
  (559,13,4,15,NULL,2,1),
  (560,9,4,15,NULL,2,1),
  (562,14,4,14,NULL,2,1),
  (563,15,4,14,NULL,2,1),
  (564,16,4,14,NULL,2,1),
  (565,17,4,14,NULL,2,1),
  (566,13,4,14,NULL,2,1),
  (567,9,4,14,NULL,2,1),
  (569,3,6,57,NULL,2,1),
  (570,5,6,57,NULL,2,1),
  (571,4,6,57,NULL,2,1),
  (572,1,6,57,NULL,2,1),
  (573,2,6,57,NULL,2,1),
  (574,9,6,57,NULL,2,1),
  (590,1,1,60,1,NULL,0),
  (591,1,1,60,2,NULL,1),
  (592,2,1,60,2,NULL,1),
  (593,2,1,60,1,NULL,1),
  (594,3,1,60,1,NULL,0),
  (595,3,1,60,2,NULL,1),
  (596,9,1,60,2,NULL,1),
  (597,9,1,60,1,NULL,0),
  (598,9,1,60,NULL,2,1),
  (599,4,2,61,NULL,1,0),
  (600,4,2,61,NULL,2,1),
  (601,4,2,61,2,NULL,1),
  (602,5,2,61,NULL,1,1),
  (603,5,2,61,NULL,2,1),
  (604,5,2,61,2,NULL,1),
  (605,6,2,61,NULL,1,0),
  (606,6,2,61,NULL,2,1),
  (607,6,2,61,2,NULL,1),
  (608,7,2,61,NULL,1,0),
  (609,7,2,61,NULL,2,0),
  (610,7,2,61,2,NULL,1),
  (611,8,2,61,NULL,1,0),
  (612,8,2,61,NULL,2,0),
  (613,8,2,61,2,NULL,1),
  (614,9,2,61,NULL,1,0),
  (615,9,2,61,NULL,2,0),
  (616,9,2,61,2,NULL,1),
  (630,18,7,62,NULL,2,1),
  (618,4,2,0,2,NULL,1),
  (619,5,2,0,2,NULL,1),
  (620,6,2,0,2,NULL,1),
  (621,7,2,0,2,NULL,1),
  (622,8,2,0,2,NULL,1),
  (623,9,2,0,2,NULL,1),
  (629,9,7,62,NULL,2,1),
  (632,9,7,63,NULL,2,1),
  (633,18,7,63,NULL,2,1),
  (635,9,7,64,NULL,2,1),
  (636,18,7,64,NULL,2,1),
  (637,3,6,0,0,NULL,1),
  (638,5,6,0,0,NULL,1),
  (639,4,6,0,0,NULL,0),
  (640,1,6,0,0,NULL,1),
  (641,2,6,0,0,NULL,1),
  (642,9,6,0,0,NULL,0),
  (687,9,5,65,NULL,2,1),
  (686,3,5,65,NULL,2,1),
  (646,3,5,65,NULL,1,1),
  (647,9,5,65,NULL,1,0),
  (658,2,1,48,NULL,2,1),
  (657,1,1,48,NULL,2,1),
  (656,3,1,48,NULL,2,1),
  (721,3,1,66,2,NULL,1),
  (692,3,1,66,1,NULL,0),
  (684,3,5,65,2,NULL,1),
  (685,9,5,65,2,NULL,1),
  (717,9,3,12,NULL,2,1),
  (697,10,3,12,2,NULL,0),
  (698,11,3,12,2,NULL,0),
  (699,5,3,12,2,NULL,0),
  (700,1,3,12,2,NULL,1),
  (701,12,3,12,2,NULL,1),
  (702,2,3,12,2,NULL,1),
  (703,9,3,12,2,NULL,1),
  (716,2,3,12,NULL,2,1),
  (715,12,3,12,NULL,2,0),
  (714,1,3,12,NULL,2,0),
  (713,5,3,12,NULL,2,0),
  (712,11,3,12,NULL,2,0),
  (711,10,3,12,NULL,2,0),
  (719,3,9,69,NULL,2,1),
  (720,9,9,69,NULL,2,1),
  (726,9,7,72,NULL,2,1),
  (727,18,7,72,NULL,2,1),
  (729,9,7,71,NULL,2,1),
  (730,18,7,71,NULL,2,1),
  (732,5,11,76,2,NULL,1),
  (733,9,11,76,2,NULL,1);

COMMIT;

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
  (15,4),
  (9,6),
  (10,6),
  (11,6),
  (55,3),
  (56,4),
  (57,6),
  (60,1),
  (61,2),
  (62,7),
  (63,7),
  (64,7),
  (65,5),
  (66,1),
  (69,9),
  (70,7),
  (71,7),
  (72,7),
  (73,7),
  (74,7),
  (75,7),
  (76,11);

COMMIT;

#
# Data for the `sys_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_actions` (`id`, `name`) VALUES 
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
  (17,'addToGroup'),
  (18,'editDefault'),
  (19,'post');

COMMIT;

#
# Data for the `sys_cfg` table  (LIMIT 0,500)
#

INSERT INTO `sys_cfg` (`id`, `section`, `module`) VALUES 
  (2,0,1),
  (3,0,2),
  (4,1,1),
  (5,7,6),
  (6,2,2),
  (1,0,0);

COMMIT;

#
# Data for the `sys_cfg_values` table  (LIMIT 0,500)
#

INSERT INTO `sys_cfg_values` (`id`, `cfg_id`, `name`, `value`) VALUES 
  (1,1,'cache','true'),
  (2,2,'items_per_page','10'),
  (3,3,'items_per_page','20'),
  (16,4,'items_per_page','50'),
  (13,5,'',''),
  (14,6,'items_per_page','20');

COMMIT;

#
# Data for the `sys_classes` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) VALUES 
  (1,'news',1),
  (2,'newsFolder',1),
  (3,'user',2),
  (4,'group',2),
  (5,'timer',3),
  (6,'page',4),
  (7,'access',5),
  (8,'userGroup',2),
  (9,'admin',6),
  (10,'comments',8),
  (11,'commentsFolder',8);

COMMIT;

#
# Data for the `sys_classes_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) VALUES 
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
  (23,4,9),
  (24,6,3),
  (25,6,9),
  (26,6,5),
  (27,6,4),
  (28,6,1),
  (29,6,2),
  (30,5,9),
  (31,7,18),
  (32,7,9),
  (33,5,3),
  (34,9,3),
  (35,9,9),
  (36,10,1),
  (37,10,2),
  (38,10,9),
  (39,11,5),
  (40,11,19),
  (41,11,9);

COMMIT;

#
# Data for the `sys_classes_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) VALUES 
  (1,1,1),
  (2,2,1),
  (3,3,2),
  (4,4,2),
  (5,5,3),
  (6,6,4),
  (7,7,6),
  (8,8,2),
  (9,9,7),
  (10,10,8),
  (11,11,8);

COMMIT;

#
# Data for the `sys_modules` table  (LIMIT 0,500)
#

INSERT INTO `sys_modules` (`id`, `name`) VALUES 
  (1,'news'),
  (2,'user'),
  (3,'timer'),
  (4,'page'),
  (5,'access'),
  (6,'admin'),
  (8,'comments');

COMMIT;

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
  (67),
  (68),
  (69),
  (70),
  (71),
  (72),
  (73),
  (74),
  (75),
  (76);

COMMIT;

#
# Data for the `sys_obj_id_named` table  (LIMIT 0,500)
#

INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) VALUES 
  (55,'user_userFolder'),
  (56,'user_groupFolder'),
  (58,'access_groupFolder'),
  (71,'access_user_group'),
  (60,'news_news'),
  (61,'news_newsFolder'),
  (62,'access_news_newsFolder'),
  (63,'access_news_news'),
  (64,'access_page_page'),
  (65,'timer_timer'),
  (69,'access_admin_admin'),
  (72,'access_user_user'),
  (73,'access_sys_access'),
  (74,'access_timer_timer'),
  (75,'access_user_userGroup');

COMMIT;

#
# Data for the `sys_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_sections` (`id`, `name`) VALUES 
  (7,'admin'),
  (8,'comments'),
  (1,'news'),
  (4,'page'),
  (6,'sys'),
  (3,'timer'),
  (2,'user');

COMMIT;

#
# Data for the `user_group` table  (LIMIT 0,500)
#

INSERT INTO `user_group` (`id`, `obj_id`, `name`) VALUES 
  (1,14,'unauth'),
  (2,15,'auth');

COMMIT;

#
# Data for the `user_user` table  (LIMIT 0,500)
#

INSERT INTO `user_user` (`id`, `obj_id`, `login`, `password`) VALUES 
  (1,12,'guest',''),
  (2,13,'admin','098f6bcd4621d373cade4e832627b4f6');

COMMIT;

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