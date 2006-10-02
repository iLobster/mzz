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
  (1,1,'новость 1',2,'текст 1',1,1140071407,1158647424),
  (2,2,'новость 2',2,'текст 21',1,1140071307,1158644194),
  (4,3,'новость 3',2,'текст 31',3,1140071207,1151126312),
  (5,4,'новость 4',2,'текст 4',2,1140071107,1140071117),
  (6,16,'тестовая новость',2,'... текст',1,1158725119,1158725119),
  (7,17,'цйу',2,'йцу',1,1158725156,1158725156),
  (8,18,'qwe',2,'asdqwe',1,1159144215,1159144215);

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
  (1,6,'root',1,NULL),
  (2,7,'parent1',2,NULL),
  (3,8,'parent2',3,NULL);

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
  (1,1,6,1),
  (2,2,3,2),
  (3,4,5,2);

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
  (1,9,'main','Первая страница','Это первая, главная страница'),
  (2,10,'404','404 Not Found','Запрашиваемая страница не найдена!'),
  (3,11,'test','test','test');

COMMIT;

#
# Structure for the `sys_access` table : 
#

DROP TABLE IF EXISTS `sys_access`;

CREATE TABLE `sys_access` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `module_section_action` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  `uid` int(11) unsigned default NULL,
  `gid` int(11) unsigned default NULL,
  `allow` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_action_id` (`module_section_action`,`obj_id`,`uid`,`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access` table  (LIMIT 0,500)
#

INSERT INTO `sys_access` (`id`, `module_section_action`, `obj_id`, `uid`, `gid`, `allow`) VALUES 
  (1,1,NULL,NULL,NULL,1),
  (2,2,NULL,NULL,NULL,1);

COMMIT;

#
# Structure for the `sys_access_actions` table : 
#

DROP TABLE IF EXISTS `sys_access_actions`;

CREATE TABLE `sys_access_actions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_actions` (`id`, `name`) VALUES 
  (1,'edit'),
  (2,'delete');

COMMIT;

#
# Structure for the `sys_access_modules` table : 
#

DROP TABLE IF EXISTS `sys_access_modules`;

CREATE TABLE `sys_access_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_modules` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_modules` (`id`, `name`) VALUES 
  (1,'news');

COMMIT;

#
# Structure for the `sys_access_modules_sections` table : 
#

DROP TABLE IF EXISTS `sys_access_modules_sections`;

CREATE TABLE `sys_access_modules_sections` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `module_id` int(11) unsigned default NULL,
  `section_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_section` (`section_id`,`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_modules_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_modules_sections` (`id`, `module_id`, `section_id`) VALUES 
  (1,1,1);

COMMIT;

#
# Structure for the `sys_access_modules_sections_actions` table : 
#

DROP TABLE IF EXISTS `sys_access_modules_sections_actions`;

CREATE TABLE `sys_access_modules_sections_actions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `module_section_id` int(11) unsigned default NULL,
  `action_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_action_unique` (`module_section_id`,`action_id`),
  KEY `action_id` (`action_id`),
  KEY `module_id` (`module_section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access_modules_sections_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_modules_sections_actions` (`id`, `module_section_id`, `action_id`) VALUES 
  (1,1,1),
  (2,1,2);

COMMIT;

#
# Structure for the `sys_access_sections` table : 
#

DROP TABLE IF EXISTS `sys_access_sections`;

CREATE TABLE `sys_access_sections` (
  `id` int(11) unsigned NOT NULL auto_increment,
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
  (18);

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
  PRIMARY KEY  (`id`)
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
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_usergroup_rel` table  (LIMIT 0,500)
#

INSERT INTO `user_usergroup_rel` (`id`, `group_id`, `user_id`, `obj_id`) VALUES 
  (1,1,1,NULL),
  (2,2,2,NULL);

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;