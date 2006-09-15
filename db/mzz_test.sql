# SQL Manager 2005 for MySQL 3.7.5.1
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `title` varchar(255) default NULL,
  `text` text,
  `editor` int(11) unsigned default NULL,
  `created` int(11) unsigned default NULL,
  `updated` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `news_news_old` table : 
#

DROP TABLE IF EXISTS `news_news_old`;

CREATE TABLE `news_news_old` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) default NULL,
  `title` varchar(255) NOT NULL default '',
  `editor` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `folder_id` int(11) default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `news_newsfolder_old` table : 
#

DROP TABLE IF EXISTS `news_newsfolder_old`;

CREATE TABLE `news_newsfolder_old` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) default NULL,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_newsfolder_old` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder_old` (`id`, `obj_id`, `name`, `parent`, `path`) VALUES 
  (1,105,'name1',1,'name1'),
  (2,106,'name2',2,'name1/name2'),
  (3,107,'name3',3,'name1/name3'),
  (4,108,'name4',4,'name1/name4'),
  (5,109,'name5',5,'name1/name2/name5'),
  (6,110,'name6',6,'name1/name2/name6'),
  (7,111,'name7',7,'name1/name3/name7'),
  (8,112,'name8',8,'name1/name3/name8');

COMMIT;

#
# Structure for the `news_newsfolder_tree_old` table : 
#

DROP TABLE IF EXISTS `news_newsfolder_tree_old`;

CREATE TABLE `news_newsfolder_tree_old` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_newsfolder_tree_old` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder_tree_old` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,16,1),
  (2,2,7,2),
  (3,8,13,2),
  (4,14,15,2),
  (5,3,4,3),
  (6,5,6,3),
  (7,9,10,3),
  (8,11,12,3);

COMMIT;

#
# Structure for the `page_page` table : 
#

DROP TABLE IF EXISTS `page_page`;

CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `obj_id` int(11) default NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_simple_tree` table : 
#

DROP TABLE IF EXISTS `simple_simple_tree`;

CREATE TABLE `simple_simple_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_stub2simple` table : 
#

DROP TABLE IF EXISTS `simple_stub2simple`;

CREATE TABLE `simple_stub2simple` (
  `somefield` int(11) default NULL,
  `otherfield` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `simple_stubsimple` table : 
#

DROP TABLE IF EXISTS `simple_stubsimple`;

CREATE TABLE `simple_stubsimple` (
  `id` int(11) NOT NULL auto_increment,
  `foo` varchar(10) default NULL,
  `bar` varchar(10) default NULL,
  `path` varchar(255) default NULL,
  `obj_id` int(11) default NULL,
  `rel` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_access` table : 
#

DROP TABLE IF EXISTS `sys_access`;

CREATE TABLE `sys_access` (
  `id` int(11) NOT NULL auto_increment,
  `module_section_action` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `uid` int(11) default NULL,
  `gid` int(11) default NULL,
  `allow` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_action_id` (`module_section_action`,`obj_id`,`uid`,`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

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
# Structure for the `sys_access_modules` table : 
#

DROP TABLE IF EXISTS `sys_access_modules`;

CREATE TABLE `sys_access_modules` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_access_modules_sections` table : 
#

DROP TABLE IF EXISTS `sys_access_modules_sections`;

CREATE TABLE `sys_access_modules_sections` (
  `id` int(11) NOT NULL auto_increment,
  `module_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_section` (`section_id`,`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_access_modules_sections_actions` table : 
#

DROP TABLE IF EXISTS `sys_access_modules_sections_actions`;

CREATE TABLE `sys_access_modules_sections_actions` (
  `id` int(11) NOT NULL auto_increment,
  `module_section_id` int(11) default NULL,
  `action_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_action_unique` (`module_section_id`,`action_id`),
  KEY `action_id` (`action_id`),
  KEY `module_id` (`module_section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

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
  (23);

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
# Data for the `sys_sessions` table  (LIMIT 0,500)
#

INSERT INTO `sys_sessions` (`id`, `sid`, `ts`, `valid`, `data`) VALUES 
  (276,'c4f018f19e5a23a8b3e341226ea147e2',1158030058,'no','');

COMMIT;

#
# Structure for the `user_group_group` table : 
#

DROP TABLE IF EXISTS `user_group_group`;

CREATE TABLE `user_group_group` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `user_usergrouprel` table : 
#

DROP TABLE IF EXISTS `user_usergrouprel`;

CREATE TABLE `user_usergrouprel` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;