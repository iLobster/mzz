# MySQL-Front 3.2  (Build 12.3)


# Host: localhost    Database: mzz
# ------------------------------------------------------
# Server version 5.0.18-nt

DROP DATABASE IF EXISTS `mzz`;
CREATE DATABASE `mzz` /*!40100 DEFAULT CHARACTER SET cp1251 */;
USE `mzz`;

/*!40101 SET NAMES cp1251 */;

#
# Table structure for table news_news
#

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
# Dumping data for table news_news
#

INSERT INTO `news_news` VALUES (1,'новость 1',1,'текст 1',1,1140071407,1151144817);
INSERT INTO `news_news` VALUES (2,'новость 2',2,'текст 21',1,1140071307,1151124950);
INSERT INTO `news_news` VALUES (4,'новость 3',2,'текст 31',3,1140071207,1151126312);
INSERT INTO `news_news` VALUES (5,'новость 4',2,'текст 4',2,1140071107,1140071117);
INSERT INTO `news_news` VALUES (9,'`',1,'`',3,1149103108,1149103218);

#
# Table structure for table news_news_folder
#

CREATE TABLE `news_news_folder` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_news_folder
#

INSERT INTO `news_news_folder` VALUES (1,'root',1,NULL);
INSERT INTO `news_news_folder` VALUES (2,'parent1',2,NULL);
INSERT INTO `news_news_folder` VALUES (3,'parent2',3,NULL);

#
# Table structure for table news_news_folder_tree
#

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
# Dumping data for table news_news_folder_tree
#

INSERT INTO `news_news_folder_tree` VALUES (1,1,6,1);
INSERT INTO `news_news_folder_tree` VALUES (2,2,3,2);
INSERT INTO `news_news_folder_tree` VALUES (3,4,5,2);

#
# Table structure for table news_news_tree
#

CREATE TABLE `news_news_tree` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_news_tree
#

INSERT INTO `news_news_tree` VALUES (1,'root',0);
INSERT INTO `news_news_tree` VALUES (2,'folder2',0);

#
# Table structure for table page_page
#

CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table page_page
#

INSERT INTO `page_page` VALUES (1,'main','Первая страница','Это первая, главная страница');
INSERT INTO `page_page` VALUES (2,'404','404 Not Found','Запрашиваемая страница не найдена!');
INSERT INTO `page_page` VALUES (3,'test','test','test');

#
# Table structure for table sys_cfg
#

CREATE TABLE `sys_cfg` (
  `id` int(11) NOT NULL auto_increment,
  `section` varchar(255) NOT NULL default '',
  `module` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `section_module` (`section`,`module`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_cfg
#

INSERT INTO `sys_cfg` VALUES (1,'','common');
INSERT INTO `sys_cfg` VALUES (2,'','news');

#
# Table structure for table sys_cfg_values
#

CREATE TABLE `sys_cfg_values` (
  `id` int(11) NOT NULL auto_increment,
  `cfg_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cfg_id_name` (`cfg_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_cfg_values
#

INSERT INTO `sys_cfg_values` VALUES (1,1,'cache','true');
INSERT INTO `sys_cfg_values` VALUES (2,2,'items_per_page','10');

#
# Table structure for table user_user
#

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_user
#

INSERT INTO `user_user` VALUES (1,'guest','');
INSERT INTO `user_user` VALUES (2,'admin','098f6bcd4621d373cade4e832627b4f6');

#
# Table structure for table user_user_group
#

CREATE TABLE `user_user_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_user_group
#

INSERT INTO `user_user_group` VALUES (1,'unauth');
INSERT INTO `user_user_group` VALUES (2,'auth');

#
# Table structure for table user_user_group_rel
#

CREATE TABLE `user_user_group_rel` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_user_group_rel
#

INSERT INTO `user_user_group_rel` VALUES (1,1,1);
INSERT INTO `user_user_group_rel` VALUES (2,2,2);

