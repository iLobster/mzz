# EMS MySQL Manager Pro 3.3.0.2
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mzz


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

INSERT INTO `news_news` (`id`, `title`, `editor`, `text`, `folder_id`, `created`, `updated`) VALUES 
  (1,'новость 1',1,'текст 1',1,1140071407,1151144817),
  (2,'новость 2',2,'текст 21',1,1140071307,1151124950),
  (4,'новость 3',2,'текст 31',3,1140071207,1151126312),
  (5,'новость 4',2,'текст 4',2,1140071107,1140071117),
  (9,'`',1,'`',3,1149103108,1149103218);

COMMIT;

#
# Structure for the `news_news_folder_tree` table : 
#

DROP TABLE IF EXISTS `news_news_folder_tree`;

CREATE TABLE `news_news_folder_tree` (
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
# Data for the `news_news_folder_tree` table  (LIMIT 0,500)
#

INSERT INTO `news_news_folder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,6,1),
  (2,2,3,2),
  (3,4,5,2);

COMMIT;

#
# Structure for the `news_news_tree` table : 
#

DROP TABLE IF EXISTS `news_news_tree`;

CREATE TABLE `news_news_tree` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_news_tree` table  (LIMIT 0,500)
#

INSERT INTO `news_news_tree` (`id`, `name`, `parent`) VALUES 
  (1,'root',0),
  (2,'folder2',0);

COMMIT;

#
# Structure for the `news_newsfolder_folder` table : 
#

DROP TABLE IF EXISTS `news_newsfolder_folder`;

CREATE TABLE `news_newsfolder_folder` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_newsfolder_folder` table  (LIMIT 0,500)
#

INSERT INTO `news_newsfolder_folder` (`id`, `name`, `parent`, `path`) VALUES 
  (1,'root',1,NULL),
  (2,'parent1',2,NULL),
  (3,'parent2',3,NULL);

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
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `page_page` table  (LIMIT 0,500)
#

INSERT INTO `page_page` (`id`, `name`, `title`, `content`) VALUES 
  (1,'main','Первая страница','Это первая, главная страница'),
  (2,'404','404 Not Found','Запрашиваемая страница не найдена!'),
  (3,'test','test','test');

COMMIT;

#
# Structure for the `relate2_related` table : 
#

DROP TABLE IF EXISTS `relate2_related`;

CREATE TABLE `relate2_related` (
  `id` int(11) NOT NULL default '0',
  `data` char(255) default NULL,
  `obj_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `relate2_related` table  (LIMIT 0,500)
#

INSERT INTO `relate2_related` (`id`, `data`, `obj_id`) VALUES 
  (2,'foobar',10),
  (3,'zzz',11);

COMMIT;

#
# Structure for the `relate_relate` table : 
#

DROP TABLE IF EXISTS `relate_relate`;

CREATE TABLE `relate_relate` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `related_id` int(11) unsigned default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `relate_relate` table  (LIMIT 0,500)
#

INSERT INTO `relate_relate` (`id`, `name`, `related_id`, `obj_id`) VALUES 
  (1,'sad',2,7),
  (2,'sada',3,NULL);

COMMIT;

#
# Structure for the `relate_related2` table : 
#

DROP TABLE IF EXISTS `relate_related2`;

CREATE TABLE `relate_related2` (
  `relate_id` int(11) unsigned NOT NULL auto_increment,
  `foobar` char(255) default NULL,
  PRIMARY KEY  (`relate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `relate_related2` table  (LIMIT 0,500)
#

INSERT INTO `relate_related2` (`relate_id`, `foobar`) VALUES 
  (1,'qqqqq');

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
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_user` table  (LIMIT 0,500)
#

INSERT INTO `user_user` (`id`, `login`, `password`, `obj_id`) VALUES 
  (1,'guest','',NULL),
  (2,'admin','098f6bcd4621d373cade4e832627b4f6',NULL);

COMMIT;

#
# Structure for the `user_user_group` table : 
#

DROP TABLE IF EXISTS `user_user_group`;

CREATE TABLE `user_user_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_user_group` table  (LIMIT 0,500)
#

INSERT INTO `user_user_group` (`id`, `name`) VALUES 
  (1,'unauth'),
  (2,'auth');

COMMIT;

#
# Structure for the `user_user_group_rel` table : 
#

DROP TABLE IF EXISTS `user_user_group_rel`;

CREATE TABLE `user_user_group_rel` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_user_group_rel` table  (LIMIT 0,500)
#

INSERT INTO `user_user_group_rel` (`id`, `group_id`, `user_id`) VALUES 
  (1,1,1),
  (2,2,2);

COMMIT;

