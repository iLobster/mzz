# MySQL-Front 3.2  (Build 12.3)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;

/*!40101 SET NAMES cp1251 */;
/*!40103 SET TIME_ZONE='SYSTEM' */;

# Host: localhost    Database: mzz
# ------------------------------------------------------
# Server version 5.0.24-community-nt

DROP DATABASE IF EXISTS `mzz`;
CREATE DATABASE `mzz` /*!40100 DEFAULT CHARACTER SET cp1251 */;
USE `mzz`;

#
# Table structure for table catalogue_catalogue
#

CREATE TABLE `catalogue_catalogue` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `name` varchar(255) NOT NULL default '',
  `editor` int(11) default NULL,
  `created` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `folder_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_catalogue
#

INSERT INTO `catalogue_catalogue` VALUES (6,8,'Delphi: ���������������� �� ����� �������� ������',2,1175235587,489,12);
INSERT INTO `catalogue_catalogue` VALUES (7,8,'������� ����������� ����� ��� ����������� ������������� � �����',2,1175237052,490,12);
INSERT INTO `catalogue_catalogue` VALUES (8,7,'Nokia 6300',2,1175871646,501,5);
INSERT INTO `catalogue_catalogue` VALUES (9,7,'Nokia E65',2,1175871677,502,5);
INSERT INTO `catalogue_catalogue` VALUES (10,7,'Motorola KRZR K1',2,1175871755,503,5);
INSERT INTO `catalogue_catalogue` VALUES (11,8,'����� ���',2,1179562302,562,11);
INSERT INTO `catalogue_catalogue` VALUES (12,9,'���������-������������, 2 ��',2,1179565776,563,1);
INSERT INTO `catalogue_catalogue` VALUES (13,9,'����� ��������� \"������ ���������� ����\"',2,1179565863,564,1);
INSERT INTO `catalogue_catalogue` VALUES (14,8,'PHP5 ��� ��������������',2,1179566368,565,1);
INSERT INTO `catalogue_catalogue` VALUES (15,9,'��������� ��������� \"������\"',2,1179566669,566,1);
INSERT INTO `catalogue_catalogue` VALUES (17,11,'test',2,1183848304,775,1);

#
# Table structure for table catalogue_catalogue_data
#

CREATE TABLE `catalogue_catalogue_data` (
  `id` int(11) NOT NULL default '0',
  `property_type` int(11) unsigned default NULL,
  `text` text,
  `char` varchar(255) default NULL,
  `int` int(11) default NULL,
  `float` float(9,3) default NULL,
  UNIQUE KEY `id` (`id`,`property_type`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 ROW_FORMAT=FIXED;

#
# Dumping data for table catalogue_catalogue_data
#

INSERT INTO `catalogue_catalogue_data` VALUES (6,27,'����� ��������� �������� ������ Delphi  7 Studio. ����� �������� ��� ����� ���������������� � ����� Delphi, � ������� ��������� ����� - ������� �����������, ��������� ��������, ��������������� ��������������, ��� � ��� ���� ���������������� Delphi',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (6,24,NULL,'�.�. �������',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (6,25,NULL,NULL,640,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (6,26,NULL,'������������ ��� \"�����\"',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,24,NULL,'�.�. ���������, �.�. ���������, �.�. ���������',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,25,NULL,NULL,448,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,26,NULL,'������������ ���� ��. �.�. �������',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,27,'������� ������� �� 12 ������-���, ������������ ������ ��������� � ����������: �������� �����, ����������� �������� �������� �������� ������ ����������� ���������� �� �������������� �������- � ������������������� �����; �������������� ������ � ������� ��� ������������ �������, �������� ������� ����������������� �������� �� ��������� ��������; ���������� � ������ �������������� � ����������� ���������� ��������������� ��������������.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (8,28,NULL,'GSM 900/1800/1900',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (8,29,NULL,'91 �.',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (8,30,NULL,'106.4 x 43.6 x 11.7',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (9,28,NULL,'GSM 850/900/1800/1900',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (9,29,NULL,'115 �.',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (9,30,NULL,'105 x 49 x 15.5',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (10,28,NULL,'GSM 850/900/1800/1900',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (10,29,NULL,'',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (10,30,NULL,'103 x 42 x 16',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,24,NULL,'�. ����������',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,25,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,26,NULL,'',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,27,'�� ��������� ������� ����������� ����-������� \"������ �����\"! ��������� ������� ������������� ��� ������ ���������� � ���� � � ����, � ������� �������� ����. ��� ������ ����������, ��� ����� ���� ������, ��� ������� ��������� ������.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (12,49,NULL,NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (12,50,NULL,NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (12,51,'��� ����������-������������ - ��������� ������� ��� ��������� � ����� ������� ���� ��� �����! ������ ������� ����� �� ������� ������� ���� � ������� �� ������� �� ������� ������ �������� � ����� ��������� �������� ����������� ��������.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (13,49,NULL,NULL,2,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (13,50,NULL,NULL,1178543636,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (13,51,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,24,NULL,'�� ����-�������, ���� ����-������, ���� ����, ������ �. �������',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,25,NULL,NULL,604,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,26,NULL,'\"����������\"',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,27,'� ������ ������������ ����������� ������������������ ��� ���� � �������� ����� PHP � ���� �������� ������ �������������. � ���� ����� ��������, ��� ��������� �������������� � ���������������������� �������������� �� ����� PHP5...',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (15,49,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (15,50,NULL,NULL,1181014750,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (15,51,'��������� ��������� ������� ���������� �� ������� ���������. �� ��������� ����������� ������ �������������� �������� �������, �������� ������� ��������� � ������� ����������, � ��������� ������� ������, ������� ������������ ��������� ������. ������� ������������ ������ ������, ������ ���������� ���������� ��� ������� �������.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (17,55,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (17,56,NULL,NULL,1,NULL);

#
# Table structure for table catalogue_catalogue_properties
#

CREATE TABLE `catalogue_catalogue_properties` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `type_id` int(11) unsigned default NULL,
  `args` text,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_catalogue_properties
#

INSERT INTO `catalogue_catalogue_properties` VALUES (10,'author','�����',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (11,'pagescount','���������� �������',3,NULL);
INSERT INTO `catalogue_catalogue_properties` VALUES (12,'izdat','��������',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (13,'annotation','���������',4,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (14,'standart','��������',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (15,'weight','���',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (16,'size','�������',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (24,'madein','������ ������������',5,'a:3:{i:0;s:0:\"\";i:1;s:5:\"�����\";i:2;s:6:\"������\";}');
INSERT INTO `catalogue_catalogue_properties` VALUES (25,'storedata','���� ����������� �� �����',6,'%H:%M:%S %d/%B/%Y');
INSERT INTO `catalogue_catalogue_properties` VALUES (26,'about','��������',4,NULL);
INSERT INTO `catalogue_catalogue_properties` VALUES (31,'test1','������������ ������',7,'a:7:{s:7:\"section\";s:4:\"user\";s:6:\"module\";s:4:\"user\";s:2:\"do\";s:4:\"user\";s:12:\"searchMethod\";s:9:\"searchAll\";s:13:\"extractMethod\";s:8:\"getLogin\";s:4:\"args\";N;s:8:\"optional\";b:1;}');
INSERT INTO `catalogue_catalogue_properties` VALUES (32,'img','�����������',8,'a:2:{s:7:\"section\";s:11:\"fileManager\";s:8:\"folderId\";i:1;}');

#
# Table structure for table catalogue_catalogue_properties_types
#

CREATE TABLE `catalogue_catalogue_properties_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_catalogue_properties_types
#

INSERT INTO `catalogue_catalogue_properties_types` VALUES (1,'char','������');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (2,'float','����� � ��������� ������');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (3,'int','����� �����');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (4,'text','�����');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (5,'select','������� ������');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (6,'datetime','���� � �����');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (7,'dynamicselect','������������ ������');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (8,'img','�����������');

#
# Table structure for table catalogue_catalogue_types
#

CREATE TABLE `catalogue_catalogue_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_catalogue_types
#

INSERT INTO `catalogue_catalogue_types` VALUES (7,'mobile','��������� �������');
INSERT INTO `catalogue_catalogue_types` VALUES (8,'books','�����');
INSERT INTO `catalogue_catalogue_types` VALUES (9,'childrens','������� ���');
INSERT INTO `catalogue_catalogue_types` VALUES (11,'test1','test1');

#
# Table structure for table catalogue_catalogue_types_props
#

CREATE TABLE `catalogue_catalogue_types_props` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `property_id` int(11) unsigned default NULL,
  `sort` int(11) unsigned default '0',
  `isShort` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_id` (`type_id`,`property_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_catalogue_types_props
#

INSERT INTO `catalogue_catalogue_types_props` VALUES (24,8,10,2,1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (25,8,11,5,0);
INSERT INTO `catalogue_catalogue_types_props` VALUES (26,8,12,1,1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (27,8,13,4,1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (28,7,14,2,1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (29,7,15,1,1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (30,7,16,6,0);
INSERT INTO `catalogue_catalogue_types_props` VALUES (43,7,12,0,0);
INSERT INTO `catalogue_catalogue_types_props` VALUES (49,9,24,0,0);
INSERT INTO `catalogue_catalogue_types_props` VALUES (50,9,25,0,0);
INSERT INTO `catalogue_catalogue_types_props` VALUES (51,9,26,0,1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (55,11,31,0,0);
INSERT INTO `catalogue_catalogue_types_props` VALUES (56,11,32,0,0);

#
# Table structure for table catalogue_cataloguefolder
#

CREATE TABLE `catalogue_cataloguefolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) NOT NULL default '0',
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `default_type` int(10) unsigned NOT NULL default '0',
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_cataloguefolder
#

INSERT INTO `catalogue_cataloguefolder` VALUES (1,241,'root','��������',0,1,'root');
INSERT INTO `catalogue_cataloguefolder` VALUES (5,481,'mobile','��������',7,5,'root/mobile');
INSERT INTO `catalogue_cataloguefolder` VALUES (10,486,'books','�����',0,10,'root/books');
INSERT INTO `catalogue_cataloguefolder` VALUES (11,487,'fantazy','����������',0,11,'root/books/fantazy');
INSERT INTO `catalogue_cataloguefolder` VALUES (12,488,'tech','����������� ����������',11,12,'root/books/tech');

#
# Table structure for table catalogue_cataloguefolder_tree
#

CREATE TABLE `catalogue_cataloguefolder_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`),
  KEY `level` (`level`,`lkey`),
  KEY `rkey` (`rkey`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=cp1251;

#
# Dumping data for table catalogue_cataloguefolder_tree
#

INSERT INTO `catalogue_cataloguefolder_tree` VALUES (1,1,10,1);
INSERT INTO `catalogue_cataloguefolder_tree` VALUES (5,2,3,2);
INSERT INTO `catalogue_cataloguefolder_tree` VALUES (10,4,9,2);
INSERT INTO `catalogue_cataloguefolder_tree` VALUES (11,5,6,3);
INSERT INTO `catalogue_cataloguefolder_tree` VALUES (12,7,8,3);

#
# Table structure for table comments_comments
#

CREATE TABLE `comments_comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `text` text,
  `author` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  `folder_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=cp1251;

#
# Dumping data for table comments_comments
#

INSERT INTO `comments_comments` VALUES (25,135,'asdfsdfg',2,1164000450,14);

#
# Table structure for table comments_commentsfolder
#

CREATE TABLE `comments_commentsfolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `parent_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=cp1251;

#
# Dumping data for table comments_commentsfolder
#

INSERT INTO `comments_commentsfolder` VALUES (14,134,9);
INSERT INTO `comments_commentsfolder` VALUES (16,145,10);
INSERT INTO `comments_commentsfolder` VALUES (18,171,164);
INSERT INTO `comments_commentsfolder` VALUES (19,172,165);
INSERT INTO `comments_commentsfolder` VALUES (20,173,166);
INSERT INTO `comments_commentsfolder` VALUES (21,174,170);
INSERT INTO `comments_commentsfolder` VALUES (22,175,11);
INSERT INTO `comments_commentsfolder` VALUES (23,177,6);
INSERT INTO `comments_commentsfolder` VALUES (34,469,458);
INSERT INTO `comments_commentsfolder` VALUES (35,470,355);
INSERT INTO `comments_commentsfolder` VALUES (36,471,400);
INSERT INTO `comments_commentsfolder` VALUES (37,477,330);
INSERT INTO `comments_commentsfolder` VALUES (38,504,468);
INSERT INTO `comments_commentsfolder` VALUES (39,535,452);
INSERT INTO `comments_commentsfolder` VALUES (40,570,537);
INSERT INTO `comments_commentsfolder` VALUES (41,591,573);
INSERT INTO `comments_commentsfolder` VALUES (42,596,594);
INSERT INTO `comments_commentsfolder` VALUES (43,607,604);
INSERT INTO `comments_commentsfolder` VALUES (44,614,612);
INSERT INTO `comments_commentsfolder` VALUES (45,631,626);
INSERT INTO `comments_commentsfolder` VALUES (46,668,463);
INSERT INTO `comments_commentsfolder` VALUES (47,669,456);
INSERT INTO `comments_commentsfolder` VALUES (48,783,780);
INSERT INTO `comments_commentsfolder` VALUES (49,836,777);
INSERT INTO `comments_commentsfolder` VALUES (50,1160,331);
INSERT INTO `comments_commentsfolder` VALUES (51,1167,459);
INSERT INTO `comments_commentsfolder` VALUES (52,1171,445);

#
# Table structure for table faq_faq
#

CREATE TABLE `faq_faq` (
  `id` int(11) NOT NULL auto_increment,
  `question` varchar(255) default NULL,
  `answer` text,
  `category_id` int(10) unsigned default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

#
# Dumping data for table faq_faq
#

INSERT INTO `faq_faq` VALUES (1,'���� �� ��� ������ � �������� ��������, ����� ������������ mzz?','����������, �� ����� �������������',1,872);
INSERT INTO `faq_faq` VALUES (2,'������','�����',1,878);

#
# Table structure for table faq_faqcategory
#

CREATE TABLE `faq_faqcategory` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `obj_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table faq_faqcategory
#

INSERT INTO `faq_faqcategory` VALUES (1,'demo','����',870);

#
# Table structure for table filemanager_file
#

CREATE TABLE `filemanager_file` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `realname` varchar(255) default '��� � �� � �������� �� �������',
  `name` varchar(255) default '��� � ������� ���� ����� ���������� �������',
  `ext` varchar(20) default NULL,
  `size` int(11) default NULL,
  `modified` int(11) default NULL,
  `downloads` int(11) default NULL,
  `right_header` tinyint(4) default NULL,
  `about` text,
  `folder_id` int(11) unsigned default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `realname` (`realname`),
  KEY `folder_id` (`folder_id`,`name`,`ext`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=cp1251;

#
# Dumping data for table filemanager_file
#

INSERT INTO `filemanager_file` VALUES (1,'161577520fa51c296ac29682a28ab915','1.jpg','jpg',41037,1189865423,28,1,'�� ������� Fernandes',5,611);
INSERT INTO `filemanager_file` VALUES (6,'292cea736807441578ceacd47a5bb3e5','1.jpg','jpg',1553,1189865423,1,1,NULL,9,1099);
INSERT INTO `filemanager_file` VALUES (7,'dff0916ad4715c9c9825fbf2d161475d','programming_1.jpg','jpg',243556,1189980269,NULL,0,'',1,1140);
INSERT INTO `filemanager_file` VALUES (8,'7dcde1baecae706bfe1fc3afb9f9b3c2','tuning-bmw-1600.jpg','jpg',355712,1189980273,NULL,0,'',1,1141);
INSERT INTO `filemanager_file` VALUES (9,'ec32fed292c41c68c58990e503612bf8','bmw-m3-nfs-1600.jpg','jpg',361474,1189980276,NULL,0,'',1,1142);
INSERT INTO `filemanager_file` VALUES (10,'027f2551a85bda995a7110b2be785134','Need_for_Speed_Carbon_1.jpg','jpg',181283,1189980281,NULL,0,'',1,1143);
INSERT INTO `filemanager_file` VALUES (11,'bbc52e03c6a321716b6381f7d0e3c700','9.jpg','jpg',2034,1189995511,8,1,NULL,9,1144);
INSERT INTO `filemanager_file` VALUES (12,'3175823dd01efbd13a86915749630d02','10.jpg','jpg',2060,1189995513,11,1,NULL,9,1145);
INSERT INTO `filemanager_file` VALUES (13,'1013b5ad0466a8552ad58f194cb066af','7.jpg','jpg',1961,1189995512,10,1,NULL,9,1146);
INSERT INTO `filemanager_file` VALUES (14,'58dac82e1df8e925c31362aa5189e8c4','8.jpg','jpg',2106,1189995512,13,1,NULL,9,1147);

#
# Table structure for table filemanager_folder
#

CREATE TABLE `filemanager_folder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) unsigned default NULL,
  `path` char(255) default NULL,
  `obj_id` int(11) unsigned default NULL,
  `filesize` int(11) unsigned default NULL,
  `exts` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=cp1251;

#
# Dumping data for table filemanager_folder
#

INSERT INTO `filemanager_folder` VALUES (1,'root','/',1,'root',195,NULL,NULL);
INSERT INTO `filemanager_folder` VALUES (5,'gallery','�������',5,'root/gallery',533,0,'jpg');
INSERT INTO `filemanager_folder` VALUES (7,'extras','extras',7,'root/extras',1093,0,'');
INSERT INTO `filemanager_folder` VALUES (8,'thumbnails','Thumbnails',8,'root/extras/thumbnails',1094,0,'');
INSERT INTO `filemanager_folder` VALUES (9,'80x60','80x60',9,'root/extras/thumbnails/80x60',1097,NULL,NULL);

#
# Table structure for table filemanager_folder_tree
#

CREATE TABLE `filemanager_folder_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`),
  KEY `level` (`level`,`lkey`),
  KEY `rkey` (`rkey`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=cp1251;

#
# Dumping data for table filemanager_folder_tree
#

INSERT INTO `filemanager_folder_tree` VALUES (1,1,10,1);
INSERT INTO `filemanager_folder_tree` VALUES (5,2,3,2);
INSERT INTO `filemanager_folder_tree` VALUES (7,4,9,2);
INSERT INTO `filemanager_folder_tree` VALUES (8,5,8,3);
INSERT INTO `filemanager_folder_tree` VALUES (9,6,7,4);

#
# Table structure for table forum_category
#

CREATE TABLE `forum_category` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  `order` int(11) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

#
# Dumping data for table forum_category
#

INSERT INTO `forum_category` VALUES (1,'main',1,880);
INSERT INTO `forum_category` VALUES (2,'����� ���������2',100,935);

#
# Table structure for table forum_forum
#

CREATE TABLE `forum_forum` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  `category_id` int(11) default NULL,
  `order` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `threads_count` int(11) default '0',
  `posts_count` int(11) default '0',
  `last_post` int(11) default NULL,
  `description` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table forum_forum
#

INSERT INTO `forum_forum` VALUES (1,'����� �����',1,100,881,2,7,59,'��������');
INSERT INTO `forum_forum` VALUES (2,'lol2? :)',1,10,936,9,50,83,NULL);
INSERT INTO `forum_forum` VALUES (3,'��� ���� ����� �����',2,0,937,1,1,58,NULL);

#
# Table structure for table forum_post
#

CREATE TABLE `forum_post` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `text` text,
  `author` int(11) default NULL,
  `post_date` int(11) default NULL,
  `edit_date` int(11) default NULL,
  `thread_id` int(11) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `thread_id` (`thread_id`,`id`),
  KEY `post_date` (`post_date`,`thread_id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=cp1251;

#
# Dumping data for table forum_post
#

INSERT INTO `forum_post` VALUES (1,'���� 1',2,10,NULL,1,886);
INSERT INTO `forum_post` VALUES (2,'���� 2',2,231654,NULL,1,887);
INSERT INTO `forum_post` VALUES (3,'adfwqer',2,1187931976,NULL,4,896);
INSERT INTO `forum_post` VALUES (4,'sd',2,1187932074,NULL,5,900);
INSERT INTO `forum_post` VALUES (5,'tyr',2,1187932122,NULL,6,904);
INSERT INTO `forum_post` VALUES (6,'���� ���� ;)',2,1187932173,NULL,7,908);
INSERT INTO `forum_post` VALUES (7,'����',2,1188183439,NULL,7,911);
INSERT INTO `forum_post` VALUES (8,'��������',2,1188183538,NULL,7,912);
INSERT INTO `forum_post` VALUES (9,'����������',2,1188183541,NULL,7,913);
INSERT INTO `forum_post` VALUES (10,'��������',2,1188183547,NULL,7,914);
INSERT INTO `forum_post` VALUES (11,'���������������',2,1188183565,1188184207,7,915);
INSERT INTO `forum_post` VALUES (12,'�����sdfgfsdg�11123',2,1188184047,1188184202,7,916);
INSERT INTO `forum_post` VALUES (13,'fhdfh',2,1188184816,NULL,1,918);
INSERT INTO `forum_post` VALUES (14,'��, ����, ���',2,1188184821,1188184843,1,919);
INSERT INTO `forum_post` VALUES (15,'�������',2,1188185186,NULL,1,920);
INSERT INTO `forum_post` VALUES (16,'���������',2,1188185191,NULL,1,921);
INSERT INTO `forum_post` VALUES (17,'�',2,1188185213,NULL,8,924);
INSERT INTO `forum_post` VALUES (18,'���',2,1188185309,NULL,9,928);
INSERT INTO `forum_post` VALUES (19,'��������',2,1188185316,NULL,9,931);
INSERT INTO `forum_post` VALUES (20,'���������',2,1188185344,NULL,8,932);
INSERT INTO `forum_post` VALUES (21,'�����������',2,1188185811,NULL,1,933);
INSERT INTO `forum_post` VALUES (22,'�����������',2,1188185812,NULL,1,934);
INSERT INTO `forum_post` VALUES (23,'����� ���� � ����� �����',2,1188188069,NULL,10,939);
INSERT INTO `forum_post` VALUES (24,'wqerqwr',2,1188258626,1188273213,11,943);
INSERT INTO `forum_post` VALUES (25,'wqer',2,1188258638,NULL,11,946);
INSERT INTO `forum_post` VALUES (26,'et',2,1188258769,NULL,13,951);
INSERT INTO `forum_post` VALUES (27,'rqwerqwer',2,1188258878,NULL,14,956);
INSERT INTO `forum_post` VALUES (28,'�������',2,1188259934,NULL,15,962);
INSERT INTO `forum_post` VALUES (29,'��������',2,1188260003,NULL,16,966);
INSERT INTO `forum_post` VALUES (30,'��������',2,1188260016,NULL,11,969);
INSERT INTO `forum_post` VALUES (31,'��������������',2,1188260032,1188270981,11,970);
INSERT INTO `forum_post` VALUES (32,'������������213',2,1188260041,1188271043,11,971);
INSERT INTO `forum_post` VALUES (33,'fuck2',2,1188260115,1188269047,11,972);
INSERT INTO `forum_post` VALUES (34,'������',2,1188261500,NULL,17,974);
INSERT INTO `forum_post` VALUES (35,'��������',2,1188261508,NULL,18,978);
INSERT INTO `forum_post` VALUES (36,'sadfasdfasd',2,1188263244,NULL,11,981);
INSERT INTO `forum_post` VALUES (37,'sadfwe',2,1188267686,NULL,1,983);
INSERT INTO `forum_post` VALUES (38,'wrtwert',2,1188267690,NULL,1,984);
INSERT INTO `forum_post` VALUES (39,'asd',2,1188267692,1188267896,1,985);
INSERT INTO `forum_post` VALUES (40,'dsgertwet111111111111111',3,1188267913,1188267942,15,986);
INSERT INTO `forum_post` VALUES (41,'342341sgrt',3,1188267928,1188267938,15,987);
INSERT INTO `forum_post` VALUES (42,'��������',2,1188271348,NULL,19,989);
INSERT INTO `forum_post` VALUES (43,'��������',2,1188271367,NULL,20,993);
INSERT INTO `forum_post` VALUES (44,'pots11dsfgsdg',2,1188271395,1188272058,21,997);
INSERT INTO `forum_post` VALUES (45,'ewqrqwrqwr',2,1188271613,NULL,21,1002);
INSERT INTO `forum_post` VALUES (46,'��������, �������',3,1188272475,NULL,11,1003);
INSERT INTO `forum_post` VALUES (47,'af\r\nqwer\r\nwer\r\n<a href=\"\">asdsa</a>',2,1188273099,NULL,11,1007);
INSERT INTO `forum_post` VALUES (48,'qqqqqq',2,1188277016,NULL,11,1008);
INSERT INTO `forum_post` VALUES (49,'sdfgsdg',3,1188277068,NULL,11,1009);
INSERT INTO `forum_post` VALUES (50,'1',3,1188277743,NULL,11,1010);
INSERT INTO `forum_post` VALUES (51,'2',3,1188277744,NULL,11,1011);
INSERT INTO `forum_post` VALUES (52,'3',3,1188277746,NULL,11,1012);
INSERT INTO `forum_post` VALUES (53,'4',3,1188277748,NULL,11,1013);
INSERT INTO `forum_post` VALUES (54,'5',3,1188277750,NULL,11,1014);
INSERT INTO `forum_post` VALUES (55,'asdf',2,1188277831,NULL,11,1015);
INSERT INTO `forum_post` VALUES (56,'safd',2,1188427896,NULL,18,1016);
INSERT INTO `forum_post` VALUES (57,'sdaf',2,1188433087,NULL,18,1020);
INSERT INTO `forum_post` VALUES (58,'twetwert',2,1188433629,NULL,22,1026);
INSERT INTO `forum_post` VALUES (59,'etwetew',2,1188434684,NULL,23,1032);
INSERT INTO `forum_post` VALUES (60,'wqerqwer',3,1188435034,NULL,18,1037);
INSERT INTO `forum_post` VALUES (61,'sadfasdf',3,1188435037,NULL,18,1041);
INSERT INTO `forum_post` VALUES (62,'dsgsdfg',3,1188435039,NULL,18,1045);
INSERT INTO `forum_post` VALUES (63,'sadf',3,1188435064,NULL,18,1049);
INSERT INTO `forum_post` VALUES (64,'qwer',3,1188435066,NULL,18,1053);
INSERT INTO `forum_post` VALUES (65,'qwre',3,1188435069,NULL,18,1057);
INSERT INTO `forum_post` VALUES (66,'qwer',3,1188435071,NULL,18,1061);
INSERT INTO `forum_post` VALUES (67,'qwre',3,1188435073,NULL,18,1065);
INSERT INTO `forum_post` VALUES (68,'saf',3,1188435741,NULL,18,1069);
INSERT INTO `forum_post` VALUES (69,'asfd',3,1188435744,NULL,18,1073);
INSERT INTO `forum_post` VALUES (70,'qwre',3,1188435751,NULL,18,1077);
INSERT INTO `forum_post` VALUES (71,'wqr',3,1188435753,NULL,18,1081);
INSERT INTO `forum_post` VALUES (72,'wert',3,1188435756,NULL,18,1085);
INSERT INTO `forum_post` VALUES (73,'sdafwa',3,1188441492,NULL,18,1089);
INSERT INTO `forum_post` VALUES (74,'jhgjhg ��������� sadf ��������� dsfgdsg ��������� dh',2,1189549156,1189549990,18,1100);
INSERT INTO `forum_post` VALUES (75,'asd\r\n���������\r\nwerwqer\r\n\r\n���������\r\n\r\ndsfgdsg\r\n\r\n���������\r\n\r\nsgfsdgsdgsdfgdsfgdsfgdsfg',2,1189550150,1189550150,18,1104);
INSERT INTO `forum_post` VALUES (76,'eqrqewr',2,1189555660,NULL,24,1117);
INSERT INTO `forum_post` VALUES (77,'werwq',3,1189555862,NULL,18,1126);
INSERT INTO `forum_post` VALUES (78,'sdfgsdfg11',2,1189558203,1189569116,18,1130);
INSERT INTO `forum_post` VALUES (79,'sadfsdf\r\n\r\n���������\r\n\r\nq',2,1189569139,1189569139,18,1134);
INSERT INTO `forum_post` VALUES (80,'sadfsaf',3,1190000102,NULL,18,1149);
INSERT INTO `forum_post` VALUES (81,'sadf',3,1190000328,NULL,24,1153);
INSERT INTO `forum_post` VALUES (82,'asd',3,1190001030,NULL,17,1155);
INSERT INTO `forum_post` VALUES (83,'dsg',3,1190001045,NULL,21,1159);

#
# Table structure for table forum_thread
#

CREATE TABLE `forum_thread` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  `posts_count` int(11) default '-1',
  `post_date` int(11) default NULL,
  `author` int(11) default NULL,
  `forum_id` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `last_post` int(11) default NULL,
  `closed` tinyint(4) default NULL,
  `first_post` int(11) default NULL,
  `view_count` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `post_date` (`post_date`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=cp1251;

#
# Dumping data for table forum_thread
#

INSERT INTO `forum_thread` VALUES (1,'����� ����',7,15,2,1,885,39,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (4,'sadfsadf',1,1187931976,2,1,895,11,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (5,'q',1,1187932074,2,1,899,11,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (6,'fdhd',0,1187932122,2,1,903,11,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (7,'���� �����',0,1187932173,2,1,907,12,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (8,'�������',1,1188185213,2,1,923,20,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (9,'���',1,1188185309,2,1,927,19,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (10,'���� � ����� ������',0,1188188069,2,3,938,23,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (11,'asf2',16,1188258626,2,2,942,55,0,24,2);
INSERT INTO `forum_thread` VALUES (13,'ewrt',0,1188258769,2,2,950,26,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (14,'qwerqwe',0,1188258878,2,2,954,27,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (15,'����',2,1188259934,2,1,960,41,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (16,'���',0,1188260003,2,2,965,29,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (17,'��� ����',1,1188261500,2,2,973,82,NULL,NULL,1);
INSERT INTO `forum_thread` VALUES (18,'� ��� ����',22,1188261508,2,2,977,80,NULL,76,1006);
INSERT INTO `forum_thread` VALUES (21,'first post',2,1188271395,2,2,996,83,0,44,3);
INSERT INTO `forum_thread` VALUES (22,'wetwe',0,1188433629,2,3,1024,58,NULL,58,NULL);
INSERT INTO `forum_thread` VALUES (23,'etw',0,1188434684,2,1,1031,59,NULL,59,NULL);
INSERT INTO `forum_thread` VALUES (24,'qwrw',1,1189555660,2,2,1116,81,NULL,76,8);

#
# Table structure for table gallery_album
#

CREATE TABLE `gallery_album` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `gallery_id` int(11) unsigned default NULL,
  `name` char(255) default NULL,
  `pics_number` int(11) default NULL,
  `created` int(11) default NULL,
  `main_photo` int(11) NOT NULL default '0',
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table gallery_album
#

INSERT INTO `gallery_album` VALUES (1,1,'asd',1,NULL,0,537);

#
# Table structure for table gallery_gallery
#

CREATE TABLE `gallery_gallery` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `owner` int(11) unsigned default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table gallery_gallery
#

INSERT INTO `gallery_gallery` VALUES (1,2,1179050922,1179050922,536);

#
# Table structure for table gallery_photo
#

CREATE TABLE `gallery_photo` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `album_id` int(11) default NULL,
  `name` char(255) default NULL,
  `size_x` int(11) default NULL,
  `size_y` int(11) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `album_id` (`album_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table gallery_photo
#

INSERT INTO `gallery_photo` VALUES (1,1,'Collien',NULL,NULL,612);

#
# Table structure for table menu_menu
#

CREATE TABLE `menu_menu` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;

#
# Dumping data for table menu_menu
#

INSERT INTO `menu_menu` VALUES (5,'demo','����-����',660);

#
# Table structure for table menu_menuitem
#

CREATE TABLE `menu_menuitem` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(10) unsigned default '0',
  `type_id` int(10) unsigned default NULL,
  `menu_id` int(10) unsigned default NULL,
  `title` varchar(255) NOT NULL default '',
  `order` int(10) unsigned default '0',
  `obj_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251 PACK_KEYS=0;

#
# Dumping data for table menu_menuitem
#

INSERT INTO `menu_menuitem` VALUES (1,0,2,5,'�������',1,661);
INSERT INTO `menu_menuitem` VALUES (2,0,2,5,'��������',2,662);
INSERT INTO `menu_menuitem` VALUES (3,0,2,5,'�������',3,663);
INSERT INTO `menu_menuitem` VALUES (4,0,2,5,'�������',4,664);
INSERT INTO `menu_menuitem` VALUES (5,0,2,5,'������������',5,665);
INSERT INTO `menu_menuitem` VALUES (6,0,2,5,'������ ����������',7,666);
INSERT INTO `menu_menuitem` VALUES (7,0,2,5,'���������',8,815);
INSERT INTO `menu_menuitem` VALUES (8,0,2,5,'�����',9,888);

#
# Table structure for table menu_menuitem_data
#

CREATE TABLE `menu_menuitem_data` (
  `id` int(11) NOT NULL default '0',
  `property_type` int(11) unsigned default NULL,
  `text` text,
  `char` varchar(255) default NULL,
  `int` int(11) default NULL,
  `float` float(9,3) default NULL,
  UNIQUE KEY `id` (`id`,`property_type`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table menu_menuitem_data
#

INSERT INTO `menu_menuitem_data` VALUES (2,2,NULL,'/page',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (1,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (1,2,NULL,'/news',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (1,3,NULL,'news',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (2,3,NULL,'page',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (2,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (3,2,NULL,'/catalogue',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (3,3,NULL,'catalogue',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (3,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (4,2,NULL,'/gallery/admin/viewGallery',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (4,3,NULL,'gallery',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (4,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (5,2,NULL,'/user/list',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (5,3,NULL,'user',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (5,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (6,2,NULL,'/admin/admin',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (6,3,NULL,'admin',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (6,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (7,2,NULL,'/message/incoming/list',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (7,3,NULL,'message',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (7,4,NULL,'',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (8,2,NULL,'/forum/forum',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (8,3,NULL,'forum',NULL,NULL);
INSERT INTO `menu_menuitem_data` VALUES (8,4,NULL,'forum',NULL,NULL);

#
# Table structure for table menu_menuitem_properties
#

CREATE TABLE `menu_menuitem_properties` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `type_id` int(11) unsigned default NULL,
  `args` text,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

#
# Dumping data for table menu_menuitem_properties
#

INSERT INTO `menu_menuitem_properties` VALUES (1,'url','������',1,NULL);
INSERT INTO `menu_menuitem_properties` VALUES (2,'url','������',1,NULL);
INSERT INTO `menu_menuitem_properties` VALUES (3,'section','section',1,NULL);
INSERT INTO `menu_menuitem_properties` VALUES (4,'action','action',1,NULL);

#
# Table structure for table menu_menuitem_properties_types
#

CREATE TABLE `menu_menuitem_properties_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table menu_menuitem_properties_types
#

INSERT INTO `menu_menuitem_properties_types` VALUES (1,'char','������');

#
# Table structure for table menu_menuitem_types
#

CREATE TABLE `menu_menuitem_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

#
# Dumping data for table menu_menuitem_types
#

INSERT INTO `menu_menuitem_types` VALUES (1,'simple','�������');
INSERT INTO `menu_menuitem_types` VALUES (2,'advanced','Advanced');

#
# Table structure for table menu_menuitem_types_props
#

CREATE TABLE `menu_menuitem_types_props` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `property_id` int(11) unsigned default NULL,
  `sort` int(11) unsigned default '0',
  `isShort` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_id` (`type_id`,`property_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

#
# Dumping data for table menu_menuitem_types_props
#

INSERT INTO `menu_menuitem_types_props` VALUES (1,1,1,0,0);
INSERT INTO `menu_menuitem_types_props` VALUES (2,2,2,0,0);
INSERT INTO `menu_menuitem_types_props` VALUES (3,2,3,0,0);
INSERT INTO `menu_menuitem_types_props` VALUES (4,2,4,0,0);

#
# Table structure for table message_message
#

CREATE TABLE `message_message` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `text` text,
  `sender` int(11) default NULL,
  `recipient` int(11) default NULL,
  `time` int(11) default NULL,
  `watched` tinyint(4) default NULL,
  `category_id` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table message_message
#

INSERT INTO `message_message` VALUES (1,'������','������ ������',1,2,1184625784,1,1,812);

#
# Table structure for table message_messagecategory
#

CREATE TABLE `message_messagecategory` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  `name` char(20) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table message_messagecategory
#

INSERT INTO `message_messagecategory` VALUES (1,'��������','incoming',809);
INSERT INTO `message_messagecategory` VALUES (2,'���������','sent',810);
INSERT INTO `message_messagecategory` VALUES (3,'�������','recycle',811);

#
# Table structure for table news_news
#

CREATE TABLE `news_news` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `editor` int(11) NOT NULL default '0',
  `annotation` text,
  `text` text NOT NULL,
  `folder_id` int(11) default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  KEY `id` (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_news
#

INSERT INTO `news_news` VALUES (9,309,'�������������� ������������ ���',2,'����������� ������ ������������� ������������ ��� ������ �� ������� ����, ������� ������ ������� ������������� ������� �� ����� ������� � �������� ��� �� �������� ��� �������������� ������������. ��� ����������� �������������� � ��������� ��������, �������, ������������ � ���� �������� ����� ��� ��������� �����������.','����������� ������ � �������, 22 �����, ������������� ������������ ��� ������ �� ������� ����, ������� ������ ������� ������������� ������� �� ����� ������� � �������� ��� �� �������� ��� �������������� ������������, ���������� �� ����� ��������������. ��� ���������� � ������������� �����������, � ������������ � ������������ �. 3 ��. 10 ������������ ������ \"� ��������������� �������������� ������������\" ������������������ ��� ����� ���, � ����� ������������ � ������ ����������� ������������� ���� �����������. ���, � ���������, ����������� �������������� � ��������� ��������, �������, ������������, �������, ������������� � ���� �������� ����� ��� ��������� �����������, � ����� ������������ ���������� ������, �� ����������� ���������� ��������, ��������� � �� ������������� �������������. �������� �� ��, ��� ��� 29 ���� 2005 ���� ���� ������������� � ��������� �� ������� ���������������� ������� ����������� ���, ����������� ���������� ���� ������������. � ����� 2007 ���� ����������� �����-����������, ����������� ������� � ������������ ������ ���������� ������� ������� ��� �������������� � �������������� �������������� ��������. ������������� ��������������, ��� ���������� � ������������� �����������, �������� ����������� ���������� ��� ��������� ��� �������������� ������������ � ������� � ������������. ����� �������� ������ ������� ������� �������������� \"�����.��\", ��� ������������� ����������� � ������� ��� ����� ����������� � ���������� 29 ����� 2007 ����. ������ �������� �������������� ����������� ���� ������� �������� � ���. �� �������� ������������ ���������� ����� ����, ��� ��� ����������� ��������, ��� \"�������� ������ ������� ���������� �� �������\". ����� ��� �������, ��� �������� ����������� �������� ������ �������� ��������� ����� ����� �� �����������, ���, �� ��� ������, �������� �������� � ������ ������ \"�������� ��������� � ��������� ���������\".',29,1174588081,1174588081);
INSERT INTO `news_news` VALUES (10,310,'��������� ���� ������������� � ������������ � �������� � ���������� �����',2,'� ���� ����������� ������������ 22 ����� � �������������� ���������� ��� ��������, ������������� � ������������ � ������������ � ������������� �������� � ���������� �����. ���� ���� �������� ����� �������� � �������������� � �������� �������, �� ������� ����������� ������ � ��� ��� � ������ ����.','� ���� ����������� ������������ 22 ����� � �������������� ���������� ��� ��������, ������������� � ������������ � ������������ � ������������� �������� � ���������� ����� 7 ���� 2005 ����, �������� Sky News. ���� (23 � 30 ���) ���� �������� ����� �������� � �������������� � �������� �������, �� ������� (26 ���) ����������� ������ � ��� ��� � ������ ����. � ������ ���� �� �������� ���� ��������� ������ � ���� ����� � �����. ��� ������������� ���������� � ����������� ����������� ���������� �������, �� ��� ����������� �����������. �� ������ ������� �������, ����� �� ������ �������� ��������� ���, �� ������ ���������� � ���������� ���� ��������, �� � ��� �����, ��� ���� �� �� ����������, ������������ ������������ � �������� ����������� � ���������� ������������. �������������, �������� � �������, ������ �� ����������� � ����� ������������ � �����. ��������, ��� 7 ���� 2005 ���� ����������-��������� �������� �������� � �������� ���������� � �������� �����, ������ ��-�� ����������� ����������� �������� ���������� �� ���������, ��� ��������� ����� ������ �����.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (11,311,'���� ������������ ������� ����������� ������',2,'������-������� ���� ����� �������� ������� � ���������� ������. � ��������, ���������� 21 �����, ��������� �������, �������� ������ � ��������� �����. ����� ������ �������� ��������� �������� �� ������������ ���������� ������� - \"�������� �����\" ���������������� �������.','������-������� ���� ����� �������� ���������������� ������ � ���������� ������, �������� MIGnews. � �������� ��������� ������� �������� �������, ������ � ��������� �����. �� ���������� ���, �������� ���� ������������ �� ������� ������� ���������� ������� - \"�������� �����\" ���������������� �������. ��������� ������ ��������� ���������� ����� � ��������� �������. ����� ���� �������������� �� 25 ��������� ������� �������� �����. ������, ���������� � �����, 21 �����, ��������� �� 30 ����� 2007 ����. �� ������ ���������, ���� ������ - ������������ ���� � �������� �������������� ������� �������� ���. ������� ��������, ��� ��� ���������� ����������� ��� ��������� � ���������� ������� �������� ������ �����. ������-������� ���� ����� ����������� ���� ���������� �������� �������������� ����� 1500 ���� � 23 �������� ������. �������� ������������ ������ ��� �������� ��������� ����, ������������� ����� ���������� ������� 877��� ���������� ���������, �� ����� ��� ���������� � ������������ ���������� ������� ���� Dolphin.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (12,312,'�������� ������� ���� �� ������',2,'������������ ����� ����������� � ��� ��������� �������� ����� ��������������� ���������� ��������� � ����������� �������. ��-�� �������������� �������������� ���� ����� ������������ � ����������� ������ 51 ������� ��������� � ����������. ������� ������� ����� �� ������ ���������� 40-55 �����.','������������ ����� ����������� � ��� ��������� �������� ����� ��������������� ���������� ��������� � ����������� �������, �������� ��� �������. \"��-�� �������������� ��������� ������������ � ���������� �������������� �� ������ ������� ����� ������������ �������, �����������-����������� ����������� ������� ���� ��������� ������������ � ������ ���������� ���������� � ��������� ��������� �� ����� 51 �������� ����������� �������\", - ������� ����������� ������������� ������ ���������� � ������������ ������ �������� �����. ��� ����������� ������������ ������������ � ������ �������� ��� ���� ����������� ������������ ������������ ��������� ��-12, ��-24, ��-26, ��-72 � ������������ ���������� ��-8. ������� ����� �� ������ 2006 ���� �������� 55 ����� �� ��������� � 40 ����� �� ����������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (13,313,'\"������\" � \"���������\" ��������� � ���� ��� ����������� ���������',2,'�������� News Corp. � NBC Universal �������� � ������ �� �������� ������������ ������-������������. �� ������ ���������� ���� �� ���������� �������, �� ������ ������ ��������� ��������� ����������� ������������� Google � �������������� ��������� YouTube. �� ��������� ������, ������ � ������������ �� ����� ����� �������� ����� ����������.','�������� News Corp. � NBC Universal �������� � ������ �� �������� ������������ ������-������������. �� ������ ���������� ���� �� ���������� �������, �� ������ ������ ��������� ��������� ����������� ������������� Google � �������������� ��������� YouTube, �������� Reuters. �� ��������� ���������������� ������� ����� ����������� �� �������� ������ (������ �� 10 �����), ��� �� YouTube, � ����� ������������� ��� � ���� ���������� ������� �����������������. ���, ������������ ��������� �������� � ���� ����� \"���������\", � ����� ����������� \"������ ����� Prada\" � \"�����\". �� ��������� ������, ������ � ������������ �� ����� ����� �������� ����� ����������. ������� NBC � News Corp. ����� �������� �� ���� ���������� �������. ������ ������ ����� ��������� �� ������ �� ��������� �������, �� � �� ������ Yahoo! � MySpace. ������ �������������� ���������� YouTube ������� �� ���� 2007 ����.',30,1174588081,1174588081);
INSERT INTO `news_news` VALUES (14,314,'��� �������� ��������� ������������ ������ �����',2,'�� ������� ������� ������ ����� ��������� ��� ������� �������� �������������, ����������� ���������� ��������������� ����������, ���������� ���������� ������ � ���������������� ������� Promises. ������������� ����� �������, ��� ��� ��������� ������������� ����� �������������� ����������.','�� ������� ������� ������ ����� ��������� ��� ������� �������� �������������, ����������� ���������� ��������������� ����������, ���������� ���������� ������ � ���������������� ������� Promises, �������� Sky News. \"���� ����� ��������� ������������� ������ ���������, ������� ��� ������ � ������\" - ������ ������������� ���������������. ����� ������ ���������� � ���� � �������� ����������� �� ��������� ���������� ������� �������� ���������� ��������� �� ����������, \"����� ���������������� ����� ���\". ������ ��� (John Doe) � ����������� �������� �������� ��������, ��� �������� �� �����������. ��������� ������ ���������� �� ���������� �������� � ����� ���, �������������� ���������� ����� ��������� ������ ����� ���. ��������, ��� 25-������ ������ ���������� �� ����������������� ������ Promises � ���������� 21 ����� 2007 ����. � ������� ����� ��������� 22 �������, ����� ����� �������� ���������: ��������, ��� ��������� ������ � ������� ����� ���������� � ���� ��� �� ��������. ����� � ������ ���������� ���������� � ���, ��� �����, �������� � �������, �������� ��������� ����� �������������, � ����� ��������� ������ ���, ������� ��� ������ ������. ���� �������� ������� � ��� �� ������� ����, ������� ������ ����������, ����� ������� � ������� � ������ 2006 ���� � ��������� ����� � ������ ����������� ����������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (15,315,'��������� ��������� �����-�������������� ������������',2,'� �����-���������� ��������� ��������� �� �������� �����������-����������� ���� �������� ��������������� ��� �����. ������ ���� ���������� � �������� � �������� �� ����� ���� ����������� ��������, �� ����� �������� �� ���� ������ � 22 �����. ������ ��������� ��������� � ������������ ��������� \"������\".','� �����-���������� ��������� ��������� �� �������� �����������-����������� ���� �������� ��������������� ��� �����, ������� ����� ��������� ��� ��������� � ��������, �������� \"�������\" �� ������� �� �������� � ������������������ �������. ������ ���� ���������� � �������� � �������� �� ���������� ��� ������� ���� ����������� ��������, �� ����� �������� �� ���� ������ 22 �����. ������ ��������� ��������� � ������������ ��������� \"������\". � ������ ��������� ��������� �� ��� ���� ������ �� ��������. ������������������ ������ 5 ������� 2006 ���� ��������� ��������� ���� � ��������� ���� ����������� ����� �� ����� 4 ��. 160 �� �� (���������� ��� ��������, ����������� ������� ���). ���� ���� ���������� �� ������ ��������, ����������� ������������� �������������. � �� ���� ���� �������� ������������� ������������ �������� ������� �� ����� ����� 210,5 �������� ������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (16,316,'��������� �������� ���� ��������� �� ����������',2,'������ ��������� ��-8 �������� \"�����������\", ������� ������ � �����, 21 �����, � ���������� ����, ������������. �������� ����� ��������� �� ����������, ��� �� ����� �������������� ���� � ������������ �������. ����� 23 ����� � ������ ������������� ���������, ������� �������� ���������� � ��������������� ������.','������ �������������� �������� \"�����������\" ��������� ��-8, ������� ������ � �����, 21 �����, � ���������� ����, ������������. �������� ����� ��������� �� ����������, ��� �� ����� �������������� ���� � ������������ �������, �������� ��� �������. ����� ����������, ��� ������ ���������� ��������� � ������������ �� ��� ����� ���� ������ ������� � ������ ��������� �������� �������������� � ����� � ���������� ������������. ��� ����� �������� �� ���� ������������� ������������ ����� ������������� ���������� ��� ��������� ��������� ������ ��������� � ������ ������ ��� ������ ����� 23 �����, � ��� ������, ���� �������� ������. �� ����� ������������ �� 5 ����� ����. ��������� ������ ����� �������� ��������� ������ �� ������� �����, ����� ��������� ������ ����������� ��������������� ������. ��������, ��� ����� � ��-8 ���� �������� 21 ����� � 15:00 �� ����������� �������. �������� ����������� � ����, ����� ���� ��� �������� ������ ������� �� ����� �������������� �������� � ����������� ������. �� ������ ��� ��������� �������� �� �����������, ������� �������� �� �������� ���������� ��-8, �� ������ �� ���������. � ������������ ������� ������ ���� ����������. ���� ����� � �������, 22 �����, ��������-������������ �������� �������������. � ��� ���� ������������� ��� ��������� � ������ ���������� �� ����������. ����� ������� ��� ��������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (17,317,'��������� ����������� ������������� ���������� ����� ��������� ��� ��-27',2,'���������� ������ �� ������ � ����� �������� ������ ����������� ������-�������� ����������� ������� ������ ����������� � �������� �� ������� ������ ��� ������������ ��-27. ���������� � ������������ ���� ���������� � ������� ����� �����-����������. �������������� ���������� ��������� �� � ���� �� ����� ����.','���������� ������ �� ������ � ����� �������� ������ ����������� ������-�������� ����������� ������� ������ ����������� � �������� �� ������� ������ ��� ������������ ��-27, �������� \"���������\". ���������� � ������������ ���� ���������� � ������� ����� �����-����������. \"�� �������-���������������� ���������� ������������ ���� ��� ����������� ����������� �������. H� ����� �� ���� � ����������� ���� ���������� ����� 900 ����� ��� ������ ������������ ��-27. ��� ������������� ������������ ����������� � ��������� ��������� ���� ���������� ��� 600 ���� ���, ����������� � �������� �� �������. ��������������� ��������� ������������ ���������� �� ����� 5,5 ��������� ������\", - ���������� � �����-������ ������-�������� ����������� �������. ���� �������� ���� ��� ������ � ���� ���� � ������ 2007 ����. � ������� �� ���������-���������� ������� ��� �������� ������� � ��������� ������� � ������������ ��-27 � ���������� ��-27. � ���� ������� � ����������� ����� ���� ������ � ��������� ����� ���������� ������. �� ������ ����������� ������-�������� ����������� �������, \"�������� ���������� �������� ������ ��� ��� �� ����� ���� � ����� � ��� �� ����������� ���\".',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (18,318,'��� ��������� �������� EMI �� Starbucks',2,'��� ��������� ���� ������ ����������, ����������� ������� �� ����������������� ������� Hear Music, ���������� �������� �������� ���� ������ Starbucks. �������� �������, ��� ��� ����� ������ ����� ��������� � ������� ��� � ������ ���� 2007 ����, � ��������������� ��������� ��� \"����� ������\".','��� ��������� ���� ������ ����������, ����������� ������� �� ����������������� ������� Hear Music, ���������� �������� �������� ���� ������ Starbucks, �������� BBC News. ����� ��� ������ 12 ����� 2007 ���� ��������� �� ����������������� ��������� Concord Music Group. ����� ���� Starbucks ��� �������� ��� ���������������� ����������� ���������. ��������, ���������� ������ ����� ���������� ������� ������ ��� ������� Genius Loves Company � ������������ ������ ������� Jagged Little Pill ������ ������ ���������. ��������� �������, ��� ��� ����� ������ ����� ��������� � ������� ��� � ������ ���� 2007 ����. �������� ������ ��������� ��� \"����� ������\" � �������, ��� ����� ����� ����������� ������� � ���������. ��������, ��� ����� ������ ����� ��������� ������� ��������� � ������� Capitol/EMI, � ������� ����������� � ������ ������� ������� The Beatles � 1963 ����.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (19,319,'������������ ������� ������ ��������� � ��������� ������ � ��������',2,'������� ������ ������� ������ ���� ������� ������ �������� ������������ ������� ����� ������ ������� ���������� ��������� � ������������ ����� � �������� ����������� (1:4). ��� ���� ���������� 7 �������, �� � ��������� �������� � ������� ����� �������� ���� 22 �����, ����� �������� ������ �� ����������� �������.','������� ������ ������� ������ ���� ������� ������ �������� ������������ ������� ����� ������ ������� ���������� ��������� � ������������ ����� � �������� ����������� (1:4). ��� ���� ���������� 7 �������, �� � ��������� �������� � ������� ����� �������� ���� 22 �����, ����� �������� ������ �� ����������� �������. \"��������� � ����, ����� ��������� ���������� ������ ��������� ������� ��� � ���������, - ��������� ������������ ����������� \"������\" � ������� ������ ����� ������ � �������� ������� \"����\". - � ���������� ��������� ���� ��� ���������� �����������. �����, ��� �������� �������, ������ ����. ��� ��� ������ �������: \"���, ��� ����� �����, �� ���� ����������� ������, ���� ������ �������\". �� ����� ����� � �� ������ �������������� ������� ������ � ��������. ����, ����� �� ������� � ���� ��������� ��������. �� � ��� �������� ��������� ��� ����. ��������� �� ������ 1:4 ������� �� ���� ������\". ��������, ��� ���� � ������������ ���� ���� ��������� ��� ����� ������ � ������� ������� ������. ����� ������ ����������� ������� ����-2008 � �������� �������, ������� ��������� 24 ����� � 21:30, ����� ��������� �� ������ � �������. �� �������� ��������� �������� ������� ������� ������ ���������� �������� � �������, ��� � ������ ������ ��� ������ ���� ����� � ���������� �����. ���� ������� �� �����-����������� ����� ������ � �������� ������, ��� �� �������� � ��������� ������� ������. ����� ������ � ������� ������� ������ 41 ���� � ����� 7 �����.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (20,320,'���������� ����� � ��������� ������ �� ���� ��� �������� ������',2,'��������������� ���������� ���������� ����������� ���������� ����� � ������������ ��������� \"�����\" ������ ��������� � ���� ������ � 5-�� � 2,5 ����� ������� ������� � ������� �������� ������. �������� ������� �� ���������� ������������ ������ � ��������� ����������.','��������������� ���������� ���������� ����������� ���������� ����� � ������������ ��������� \"�����\" ������ ��������� � ���� ������ � 5-�� � 2,5 ����� ������� ������� � ������� �������� ������, �������� \"�������\". �������� ��������� �������� ��������� ��������������� �� ����� 2-� ������ 213-� � ����� 2-� ������ 116-� �� �� (����������� � �����), �������� ������ - �� ����� 2-� ������ 213-� �� ��. �������� ������� �� ���������� ������������ ������ � ��������� ����������. �������������������� ������� ������� � �������� ����� ������������ ���������� � ��������� ������. ��������, ��� ����� ���������� �����, � ���� ������� ���� ����� ���� �������, ������� ������ ������ ������� ���� � ��������� �������� � �������, ������� �������� � ���������� ���� �������. �� ���������� � ������������ � �������� � �������� ������ � ��������� ���� ��������� 109 �������, 25 ���������� �������� ����������� ���� ����������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (21,321,'��������������� �������� �� ����� ����� �� �������� � \"������\"',2,'��������������� ����� ��������������� �� ������ �������� �� ������������� ������ \"�������\" � ����� ������� ���������������� �������� ������ \"������\". ��������� ��������� �������� ������������� ���������� � ����� 2007 ����. �� ������ �����������, \"������\" �� ������ ������ � ������������� ����.','��������������� ����� ��������������� �� ������ �������� �� ������������� ������ \"�������\" � ����� ������� ���������������� �������� ������ \"������\". �� ���� �������� ��� ������� �� ������� �� �����-������ ������������ ��������� ��������. ��������������� �������� �������� ������������� ���������� � ����� 2007 ����. �� ������ �����������, \"������\" �� ������ ������ � ������������� ����. ����� ����, �������� �� ����������� ���������� ������������� � ������������� ��������� �� ���������� ����������� �����. ������������ ���������� ������������, ��� �������� ������������� ������ \"�������\" ����� ��������� � 31 ������� 2004 ����. \"������\" �������� 25 ��������� ������� � ����. � 2005 ���� �������� ����������� ����� ��������� �� 2,86 ��������� ��������. ��������� ����������� \"������\" �������� ������������ � ������������ �� ���������� ������������� ������. ������ \"�������\" ������� � 1955 ����. ��� ��������� � �������-���������� ������ �� ������-������ ������.',26,1174588081,1174588081);
INSERT INTO `news_news` VALUES (22,322,'���������� ����� �� 2 �������� ������ ����� � ����������',2,'������� ���������� �������� ������� �� �������� �������, ���������� � ������� 2,1 ��������� ������ ����������, ������� ���������� ����� � ���������� ������ ����������. ����� ��� ������� ���� ��� �����������. �� ������ ����� �����������, ������ ������ ����� �� ������������ � ������ ����������.','������� ���������� �������� ������� �� �������� �������, ���������� � ������� 2,1 ��������� ������ ����������, ������� ���������� ����� � ���������� ������ ����������, ����� ������ Daily Express. �� ������ ������, ������ ������ ����� �� ������������ � ������ ����������. � � ���� �� ����� ������ �������� ������ ������ ����� ������������ ������� ��������������. �� �������� ������ �����, ��� ����������� ��� ������ �������� ��� � ����������, ��������� ����� ������ ���� �� ���, � ����� ������ ��������� � �������� ����. � ����� �������� ������� ������ �� ��������� ����. ����� - ���� �� ���� � ����� �������� ������ � 4,2 ��������� ������ - �� �������, ��� �� ������� �����. �������� �������, �������������� �� ����� �� ������ ������ � ������, ����������, ��� �������� ������ �� ������� ����� �����, �����������, ����� � �������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (23,323,'������������� ����������� � ����� ������� ����� ���',2,'������ ������������ ������� ������� ��� ������������� ����������� ����������� � ����� ����� ���. �� ���� ������ � ������� ����������� ����������� ����� ��� �������� ������������. �� ����� �������, ��� ��� ������ ���� ������ ���������� �������� �� ������� ��������� ������������ ������������ ����������� � �����������.','������ ������������ ������� (���) ������� ��� ������������� ����������� ����������� � ����� ����� ���. �� ����, ��� ����� � ������� \"������ ��-�������\", ������ ����������� ����������� ����� ��� �������� ������������. �� �������� ��������, ����� ��������������� ��� � ������ ��� ������������� ��������� ������������ ����������� \"������\". \"�������� ����������� ������������ �� �������������� ������������ �� ����� �������������� ����������������� �������� ��� �������� �������\", - ������� ������������. �� ��� ������, � ��������� ����� � ��� �������� ���� � \"������������ ����� ��������\", � ����� �������, ��� ��� ������ �� ������������� ����������� \"����-�����������-������\". ������������ ����� �������, ��� ��� ������ ���� ������ ���������� �������� �� ������� ���������� ��������� ������������ ������ ������������ ����������� � �����������. \"�������� ������ ���������� �������� �� ��� ������. �������� ���������������� �������, �� ������� � ������� ��� � ��������� �����\", - ������� ������������. ��� ���������� �����, � ����������� ������, � ���������, ������, ��� ���� �����, ��� � ���� ���� � �����, � ���� ������������ ��������� ��� \"������� �� ������\" � ��� �������� \"�������� ����, �� ���������� � ������� ������� ����� �� ��� ���\". � ��� ������� �����, ��� ��� �������� ��� �������� ������ ����� ��� ����� ���������� �������. ��� �� �������� �������� � ����� ������������� �����������, ��, ��� ������ � ����� �� ������������ ������������ ����� \"�������\" ������� �������, ������ ������������ ������� ������ � ������ ������� � �������� ������� ���������� ������������ ��������������������� �������-���������� ��������. \"������ �����, ��� ������������, �������� ����������, �������������������, �������������� ����������� \"�������\". ��� ����� ��� �������� ������� � ����� �������� � ����� �������������� � ���������� ���������� ��������������� ������������ �������. ��� � ��� �������, � ��� �� ��� �������, �� ��� ����� ������\", - ������ ������� � �������� �� \"����� ������\".',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (24,324,'������� ����������� �������� \"������� ����\" � ��������',2,'50-������ ������������ ����������� ������� �����������, �������������� 354 ���������� �������, ������� � ������ �������� ����� ������. ��� ��� �������� � ����� �������: �� ������� ���������� ��������� ��������� ������ � ������������ ��������� �������� ��������� �����, ���������� �� ������ ������������.','50-������ ������������ ����������� ������� ����������� ������� � ������ �� �������� \"����� ������\" �������� ����� ������ ��� ��������� \"Art Grand Slam\" (\"������� ���� ��������\"). ���������� ���������� � ����� ����� ����� ���: ���������� ����������� � ��������� �������� ���� ������ (Juraj Kralik) ���������, ��� �� ���������� ���-��� �������, �������� ��������� France Presse. �� �������� ������������ ����� ����������� ������. ��� ��� �������� � ����� �������: �� ������� ���������� ��������� ��������� ������ � ������������ ��������� �������� ��������� �����, ���������� �� ������ ������������. \"��� ��������, ��� �� ����� ���� ���������� � ���, ���� ����� ���. � ������ ����� ���������\", - �������� �����������, �������������� 354 �������, ����������� �� 31 ���. ���� ������ ���������, ��� � ������� ����� ��������, ��� ���� ��������� ����� �� ��������� ������, � � 1999 ���� ������� ���������� ����������� ��� �� ������. ����������� ��������, ��� ����� �������� ��������, ����������� �� 20 ������� 2007 ����, ���������� ���������� � ���.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (25,325,'���������� ������� ������ � ����������� ��������� �� ���������',2,'� ������ ������������ ������� ��������� ���������� �� ������ ����� ������ ��� ���� ���������. � ����� ���������� � ������� �������� ����������� ����������� ����� ��� �������� ������������. \"��� ���������� ���������� ������� �����������\", - ������� ��. ������������ ����� �������� � ��������� ����� ���������� ������ �� ���������� ������� ������.','� ������ ������������ ������� (���) ��������� ���������� �� ������ ����� ������ ��� ���� ���������. � ����� ���������� � �������, ��� �������� ProUA, �������� ����������� ����������� ����� ��� �������� ������������. \"��� ���������� ���������� ������� �����������\", - ���������� ������������. ��� ���� �� ��������, ��� ��� ������������ ������������ ������ ��� ����������� � � ��������� ����������, ��������, ������� ��������� ���� � ������ ���, ������������ �������. ��������� �� � ����� ����� ���������, ������������ ��� �� �������. �� ������ ������������, ��� ����� ���� ������ ������������ �������������� ������������ ������ ��������� ���������. � ���������, �� ��� ������, � ������� ������ �������� ���������� � ����������� ������������� � ����������� ����� � ����� ������ �� ������������� �������������������. \"�� ������� ��� ������������, � ��������� ��������, � ������ ����������\", - ������� ������������, ����������� ��� ���� ������� ��� ���������, �������� �������� �����������. ����������� ����������� ����� ��� ����� ��������, ��� ��������� � ��������������� ������ � ��������� ����� ��� �������������� �������� � ���� ������������� ���� �� ���������� ���������� ������� ������. \"����� ��� ����������� �� ������� ������ ���������� ��� ���������������� ������ � ����������� ������������\", - ��������� ������������ � ������. ��� ��������, ������ ��� �������� ��������� ������ 2004 ����, ����� ��� ���������� � ���������� �������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (26,326,'����������� �������� ��������� �� ������� ��������� ��������',2,'��������� ��� ���� ��� ��������� � �������� ��������� ������� Charlie Hebdo ������� ����, ������� ����������� �� ��������� ������ ������� ���������� �� ������� ���������. ����� ������� ���� ��������� ������ ���� ��������� �����������, ���������� ���� � \"�������������� ���������\" �� ������������� ��������.','��������� ��� ���� ��� ��������� � �������� ��������� ������� \"����� ����\" (Charlie Hebdo) ������� ���� (Philippe Val), ������� ����������� � ������� �������� ���� �� ��������� ������ ������� ���������� �� ������� ���������, �������� Reuters. ����� ������� ���� ��������� ������ ����� ��������� ����������� ������� � ������� ��������� ������, ���������� ���������� � \"�������������� ���������\" �� ������������� �������� � \"����������� ������ ��� �� ������������ ��������\". � ��� ������, ���� �� ���� �������� ��������, ��� ������� ���������� �� ���� �� ����� ������� � ����� � 22 ������ ����. Charlie Hebdo ����������� ��� ���������� �� ������� ���������, � ��� ����� ���� �� ������� ������ Jyllands-Posten. ��������, ��� �������� �� ��������� �������� ������� �������� ������� ������ �� ������� ������ ��������� �� ����� ����. � ��������� Charlie Hebdo �������� ������� ���������� ��� ������� � �������� � ���������� ������ �������, ����������� � ����� ����������� ������ ���������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (27,327,'���� ������� ���� ����������� ������������ ����� �� �����',2,'����� ���������� ���������� ��������� ��� ���� ������� �� ����� ���������, ������� 21 ����� �� ������� ������� ����� � �������� ��� ���� ������� �������� XVI. �� ����� ��������� ���� ������ ��������� ����������� ����� �� ����� ���������� ������� � WBC, IBF � WBA, � ����� ����� �� ����������� � ����������� ���������.','����� ���������� ���������� ��������� ��� ���� ������� �� ����� ���������, ������� 21 ����� �� ������� ������� ����� � �������� ��� ���� ������� �������� XVI. �� ����� ��������� ���� ������ ��������� ����������� ����� �� ����� ���������� ������� � WBC (��������� ���������� �����), IBF (������������� ���������� ���������) � WBA (��������� ���������� ����������), � ����� ����� �� ����������� � ����������� ��������� ����������������� �����, �������� ���� Seconds Out. ���� ���������, ��� ������� ����������� �� ��������� � ������� ������ �� ����� ��������, �������� � ������� ���� ��������� ���� �����, ������ ���� �������� �������� ����������� � ������ � ��������. ����� ������������� �� ��������� ������ � ������. \"� ������� ��� ��� �����, ������ ��� ���� ��������� ������� �� ������, ��� � ������ �� ���� ����, - ��������� ����� ����. � � �������� ��� ���������� �� ���� ��������, �� ��� ����, �� ���������� ��� � ��� �������, �� ���� ������ � ���� ������, ������� ��������� �� ���\". ����� ��������, ��� ��� ���� �������� ���������, � �� ���������, �� ����� ���������� �� ������, ��� �� ������ ������� �������� ����� ���������. �������� ���� ������ ����� � ������ � ����������� ���������� ���������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (28,328,'�������� ��������� ������� ��������� ����� ���� �� ����� ����������',2,'������������� �������� ������������� ����������� ���������� ��������� ����� ���� � �������� ������������ � ������������ ����� ����� �� ����������� ��� ������ �� ���������� ����������. ������������� ��������� � �������, ����� �������������� ��������� � ��� ����� �� ������� ����������, ������� ��������� �������� �� ��������.','������������� �������� ������������� ����������� ���������� ��������� ����� ���� � �������� ������������ � ������������ ����� ����� �� ����������� ��� ������ �� ������������ ��������� ���������� ������ ������ ������� ����������. �� ���� �� \"24.kg\" �������� � �����-������ ��������������. ��� �����������, ��� �������������� �� ������ �������� �������� ���� ����������� � ����� � ����������� � ���� �������� ���������� ������. �� �� ������, ������������ � ���������� �������������� ����� ����� �� ��������� ����������� �������� � �������� ������������ ����������� ����� �������� �������� � �������� ����� �� �������� ����������� ����������� ���� � ������ �������� � ������ �������. ������ �����, �������� � �����-������ ����������, ������������� �������� ������� ������� �������� ������ �� ��� ���������� ��������� ����������� ����������� ��������� ���������� ��������� �������.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (29,329,'����������� ��������� ���� �� 250 ���',2,'������������� ��������� ����� ������� ����������, ��� ��� �� ��� �� 250 ��� �� ������� ���� ��������� ������ ������������� ������������� ������������� ��������� ��������. � �������������� ������� �������� ������������� ����� ������ XVI ����, ������� �������� ��������� ����������� ���������� ��������� ���������.','������������� ��������� ����� ������� (Peter Trickett) ����������, ��� ��� �� ��� �� 250 ��� �� ������� ���� ��������� ������ ������������� ������������� ������������� ��������� �������� (Cristovao Mendonca), ����� ���������� The Guardian. � �������������� ����� ���� ������� �������� ����� ������ XVI ����, ������� ��� �������� ������� ������ � ��������� � ��������. �����, �������� �������, �������� ������ � ��������� ����������� ���������� ��������� ���������, � ������������� �� ������������� �����. ����� ��������� �����, ��� �� ��� ��� ����� ����� ���������� ������ ��������������. �� ��� ����� �������� ����������� � ����� ��������� � ������ ������ ������ (Botany Bay) � ���������� ����, �������� �������. ��������� �������, ��� ����� ���� ���������� ����������� ������������ �� ������������ ������ ��������� ��������, ����������� �� �����������, ������� �� ���������� � 1520 ����. ������� ����������� ������� � ����� ����� Beyond Capricorn. C��������, ��� ��������� ������ ������ ������ ���, ������� ���������� �� ��������� ��������� � 1770 ���� � ������� ����� ����� �������������� ���������� ������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (30,330,'����������� �� ����������� ���������� ����� �������� ��������� �� ������',2,'� ���� �� 22 ����� � ���������� ���� ����������� \"�������\" ��������� �����. � ���� ���������� ���� �������������. ����� �� ����������� �� ���������, ��� 87 �������, ������������ � ������, ���� ������������. ����� � ����� \"�������\" ���� �������� ������ ��������� ���������� \"����\", ������� ������ � ����� �������.','� ���� �� 22 ����� � ���������� ���� ����������� \"�������\" ��������� �����, �������� NovoNews. ����� �� ����������� �� ���������, ��� 87 �������, ������������ � ������, ���� ������������. ��� �������� ���� liepajniekiem.lv, ����� � ����� \"�������\" ���� �������� ������ ��������� ���������� \"����\", ������� ������ � ����� �������. �������� ������, ������������� 22 �����, ������������� ��������������� �������-������������ ������ ������ ������� ������������ �������. ��������������� ����� ������ �������. � ���� ���������� ���� �������������. � ������������, ������� �������� ������, �� ����������, ������ ���� liepajniekiem.lv ��������, ��� �������������� �������� ��� ��������� � ���������.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (31,331,'����� �������� ���� � �������� \"������������ ���������������� ����������\"',2,'��������� ������ �������� ����� � ������� 22 ����� �������� ���� \"�� �������� ����������� �������� \"������������ ���������������� ����������\". ��� ��������� ��������������� ���������� ������ � ������������ - ��� 100-���������� �� ������, ��� � ��������� ������ � ������� ���������.','��������� ������ �������� ����� � ������� 22 ����� �������� ���� \"�� �������� ����������� �������� \"������������ ���������������� ����������\" (���), �������� ��� ������� �� ������� �� �����-������ ������. ��� ��������� ��������������� ���������� ������ � ������������ - ��� 100-���������� �� ������, ��� � ��������� ������ � ������� ���������, �������� ����-����. ���������, ��� ���������������� ���������� ��������� �������� ���������� �� ������-������������ �������� ��������� �������. ����-������� ������ ������ ����� �������, ��� � ����������� �������� ����� ����� ��� ������������ ��������-��������������� ������. � ������ ��� ����� ������� 3 ������������ �����������: �������� - �� ���� �������������� �����������, �������� - �� ���� �����-���������� � ������������, � ����� ���������������. �����-������ ������ ����� ��������, ��� ��������� �������� ���� \"�� �������� ����������� �������� ����� ���������� ������������ � �����������\", 100% ����� �������� ����� ������������ �����������.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (32,332,'�������������� ������� ���� �������� ��� � ������ �����',2,'��� ������ ������� ���������� ������ �������������� ������� ������ ���� ���� �� ������ �� ����������� ������ � ������������� ������� ������ ���������. � 2005 ���� ���� ���� �� ����������� ����������� � �������� \"��� ������� ������\", �������� ��������� ��������, ��������� ���� ������ ����� �� �����.','��� ������ ������� ���������� ������ �������������� ������� ������ ���� ���� �� ������ (Dame Kiri Te Kanawa) �� ����������� ������ � ������������� ������� ������ ��������� (John Farnham). � 2005 ���� ���� ���� �� ����������� ����������� � �������� \"��� ������� ������\", �������� ������������ ��������� ��������, ��������� ���� ������ ����� �� �����. \"����� �, ������������ ���������������, ���� ��������� ����� ���������? ��� ���������� �� ���\", - �������� ������ The Times ��������� ������. ��� ����� �� ��� �������� ������������ �������� ������ ���� ���� ������ ��������-��������� Leading Edge Productions, �����������, ��� ������ �������� �������� � ���������. ������ ��� ������� ������� ���� ����: ������ �� ����������� �� ������ �������� � �������������� ���. �������������, ��� ������� �� ��������� �� ������� \"��� ������� ������\": �� ����� ���� ���� �� ��������� ���� ������ (Tom Jones), ��������, � �������� ���������� ��������� ������� ��� ����� ����� ���, �������� ������������� The Times.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (33,333,'������ ����������� ����� �� ������ �� ������ \"�������\"',2,'������������� ������� ������������ ����� ������������ �� ������������� ��������� ������ �� ���������� ������ \"�������\". �������� �� ��������� ����� ������� �� ����� �������������. ������������ ��������� ���� ������ � ���������� ����� ����� � ������� ����� ����. ����� \"�������\" ������� � ���� �� 28 �������� 1994. ��� ���� ������� 852 ��������.','������������� ������� ������������ ����� ����������� �������� �� ������������� ��������� ������ �� ���������� ������ \"�������\". ��� ����� Postimees, ������� ������������ ��������� ������ ���� ������� � �������, ����� ���� ��� ������� ��������� ����������� � �������. �������� �� ��������� ����� ������� �� ����� �������������. ������� ��������� ����� ����� �������� ���������� ������������, ������� ����� �������� ��� ����� ������� �� ��� �� ����. ���������, ��� ����� �������� ����� ����������� ������������� �� ������� 15 ������� 2007 ����. ����� \"�������\", ����������� ������� � ���������, ������� � ���� �� 28 �������� 1994 ���� �� ����� �������� ������. � ���������� ��������������� ������� 852 ��������� � ����� �������, 137 ������� ���� �������. ������������ ��������� ���������� ���� ������� ������� ����������� � \"����������� �������� �������������\" - ���������, ��� � ������ �� ������ ���� ��������� ������� �������� ������. ���������� � ������ ������ ������ ������ �����. � ���������, ���� �������������, ��� ����� ��������� ���������� ��������� ������, ������� � ����� �������� ���������������. �� ��� ��� ������������ ����������� ������� ������� ������, ����� ������������ ���������� ������� ��� ������, ������ ��� ���������� �� ������� ��������� � ������� ������� � ������.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (34,334,'��������� PS3 ������������ ��������� ������ ����',2,'������������� ������� ������ �������, ��� ������� ��������� PS3 �� ��������� �������� ������� � ������. ���������� ������ ������ �������� �������� 23 ����� 2007 � ������� � ������. ����� ����������� � �������� ������� �� �������, �� ������� \"������ �����\", ��������� �� ����������� ���� ����� �� ������ ������� �����.','������������� ������� ������ �������, ��� ���������� ������� ��������� PlayStation 3 �� ��������� �������� ������� � ������. ���������� ������ ������ �������� �������� 23 ����� 2007 � ������� � ������, �������� AFP. ����������� ����� ������������� ������� ����� ��� 22 ����� �� ������. ������������� Sony ������, ��� �������� �������� ��������������� ������ �� PS3 �� ������ ����� ������������� �����������. ����������� � �������� �������� ����� ���������� ���������� ������������ ��� ����� ������; ����� ����, ����� ������ �� �������, �� ������� \"������ �����\", ��������� �� ����������� ���� ����� �� ������ ������� �����. � ������ ����������� ������� �������� �������� ������, 23 ����� 2007 ����, � ������ ����� ���� �� �������� (� ������� �� ������). ����������, ��� ������ �������, ���������� ������ ���������, �������� � �������� Virgin Megastore (��� ���������� ����������� ������ PS3) � ���� ���� 21 �����. ������� ��� ����� ����� ���� ������ � ������, ��� ��������� ������� ��������� ������ ������� � ����� �������� � Sony. ��������, ��� �������� Sony ����������� ������ ���������� ����� �������� ������� � ������ 2006 ���� ������������ �� ���� ��������. �� ��������� ��������� ����������� � ������������ �����������, � � ������� ���� PlayStation 3 ��������� ������ �� ������ � �������� �������.',31,1174588081,1174588081);
INSERT INTO `news_news` VALUES (35,335,'\"����\" ������ ��������� ������ 100 ����� SMS',2,'25 ����� � ������ ������� �������� ����� �������� \"����\" ��� ��������� \"������� ����������\", � ������ ������� ��� �������� ������ ��������� SMS-��������� ��������� ������. ������������ �������� ������� � ���� ������� �� ����� 100 ����� ������� �����. ����� ��������� 7-� ��������� ������������� ������.','25 ����� � ������ ������� �������� ����� ����������� �������� \"����\" ��� ��������� \"������� ����������\", � ������ ������� ��� �������� ������ ��������� SMS-��������� ��������� ������. ������������ �������� ������� � ���� ������� �� ����� ��� ����� ������� �����, �������� ��� \"�������\". ����� ����� ��������� ������� ��������� ������������� ������, ������� ��� ������ �� ���� ���� 26 ����� 2000 ����. ��� ������ � ������� �� �����-����������� ����� \"�����\" ������� ��������, ��������� ����� ����� 15 ����� ���������� �������� �� ������ �������� ������ - ��� ���������� \"������� ����������\". ����� �������� �������� �� ��������� ��������, ������� ��� �������������� ����������� ��������. ����� ��������� \"�����\" ��������������� �� ������ � ����� ���������� ������� �������� \"���� ������ ������������� ����� ������\", �������� ������ SMS-��������� �� ����������� ���������� �����. \"������� ����������\" ����� ���������� �������������� � 800 ������ �� ���� ������. ������ ���������� ��������� ����� ��������������� �� ��������� ������������� � ������ ������� �������. � ���������� �� ���� SMS ����� ���������� �������, ���� ��������� ������� ������������ �������� �������� ������. ����� ����, � ������ ����� ������������� \"�����\" ��������� ������� ������ ����� SIM-���� � ������� ��������, �� ������� �� ����������� ����� ����������� ��������� � ���������� ��������������� ��������, ��������� � �������, ������������ ��� ���������� \"�����\" � ��������� \"������ ����� ����������\". ��������, ��� � �������� ������ �������� ������ � ������ ����������� ���������� ���������� �������� �����. ���, 8 ������ \"������������� ����������� ��������\" ���������� �������� \"��������� ����\" � ���� �������� ������ \"����� �����������\". � 14 ������ ������� ����� ��� ����� - \"���� �����������\", �������������� ������������ ���������� �������������� ������ \"������ ������\", � ����� \"������� ������� ������ ������\", � �������, �� ��������������� ������, ������ ������� 15 ����� �������.',29,1174588081,1174588081);
INSERT INTO `news_news` VALUES (36,336,'�������� ������ ���� ��� ������������ ������������',2,'�������� ���������� ��������� ����������� ���������� ���������� \"�������� �����\", ������ ����������� ������������ ���������������� ��������� ������ � ����� ����� ��, � ����������� - � ����� ����� ���. ���������� ���������� ����������, ��� ��� ����������� ����������� ����� �������������� � �������� � ����������� ������.','�������� ���������� ��������� ����������� ���������� ���������� \"�������� �����\", ������ ����������� ������������ ���������������� ��������� ������ � ����� ����� ��, � ����������� - � ����� ����� ���, �������� BBC News. �� ������ �������������� ������������, ������������� ������ �� ���������� ���������� �������� �� 12 ���������� ����, �������� AFP. ����� ����, ��������� ��������� � ��������� ���� ��� ����� ��������� ����� ���������� ������������� 26 ��������� ����������, � ����� ������� 80 ����� ������� ���� ��� � ��, ��� � � ���. � �� �� �����, �������� BBC News, �������� ���������, ����������� �������� �� ������� ������ ���� � ������������� �� ���������� ��������� ���. ������������� ������� ������ ��� �������� � ���� � ������� 2007 ����, �� � ����������� ����� ���������� �� ���� 2008 ����. ��������� ������ ����� ��������� ��� 30 ������. ���������� ���������� ����������, ��� ��� ����������� ����������� ����� �������������� � � ����� ������ �������� � ����������� ������. ������ ���������, ������������� �� ��������� ��������� ������������������ ���������, ������������� ���������� �����������. � ��������� ����� ������������������ ��������� �� ����������� �������� ��������������, ��������� ������, ������������ ���� ������ ��������: BA, Virgin, American Airlines � United Airlines. ���������� �������� ������������ ����� ����� � ������ �������������. ��� ���� ����� ����� ������ �� ���������.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (37,337,'���������� ���������� �������� ��� ������ ���������',2,'� ������ ��������� ��������� ����������������� ���-�� � ������������� ����������� ������ ���-� ��� ��������-��������� �����. ����������� ������ ���������, ����������� �� ����� ���-3, �������� ������������������� ��������� � ����� ��������������� � ������� �������� ���������� ������.','� ������ ��������� ��������� ������������� ����������������� � ������������� ����������� ������ ��� ���, �������� �������. ������������ ���������������� ���-�� � ����������� ������ ���-� ��������� �� ����� �������� ������ ������ ������� ���-3. �� ������� ������ ����� ��� ����������, � ���������, ��������� �������� ������� � �������� ���������. ���������������� ������������ ��� ��������� ������ � ������� ������� ��� ������� ������ ��������, � ����� ��� ������� ��������� ������ ���������� - ��������������� �����, �������������� �����, ������� ���������� � ������������. ������������� ����������� ������ ������������� ��� ������, ����� � ������ ������� � ���� ��� � ��������� �� ������ ������. ��� �������� ����������-������������� ������������ ��� ���������� ������� �� ��������, �������� � ������ ��� ���������� ������� �� ��������������� ���� (������, �������, �������� �������). ��� ������������� ������ �������� ��������������� � ������� �������� ���������� ������. ��� ��������� ���-�� � ���-� �� ������� ����� �������������� �������� ��-12, ��-76 � �������� ��������� ��-26. ��� � ���-3, ��� ������ �������� ������������������� ���������, ����������� �������� �������� �������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (38,338,'���������� ������ ��������� �������� � ������ ��� ������',2,'������� � ����� ��������� ����� ������ ��������� ������� �� ������ ������� ���� ���, ������������� � �������� � �����������. � ����� ���������� �������� ������� ������������� ������� ����������������� ����� \"���� �������\" ������ ��������. �� ��� ������, ���������� ��� �������� ������������ �������, ��������� �� ����� � ������������� ������������.','������� � ����� ��������� ����� ������ ��������� ������� �� ������ ������� ������� ����������������� ���������� (���), ������������� � �������� � �����������. � ����� ����������, ��� ����� �� \"����� ������\", �������� ������� ������������� ������� ����������������� ����� \"���� �������\" ������ ��������. \"�� ������� �����������, ����� ��������� ���� ���� ��������� ������������� ��� ���������� ��������������� �������� � ���������� ���������� � ��� ������, ������������ ���������� ��� �� ����� ����������\", � ������ �������, �� ������ ��������, ���������� ������� ������� �������� ���������� ������������� ���������������� ������ ��� �������. \"������� ������ ��� ������� �� �� ���������� (������ ��� - ���������� Lenta.Ru) � ����� � ������, � �� ���� ���, ������� ������ ���������� ���������. �� ��������� � ��������� ���������� ����� � ������������� ������������, � ������ ��� ����� ���� ���������������� ������� ��� �������\", � ������� ��������. ��� � ����������� (����) � �������� (����������) �������� �������������� �������. � ������������ � ���������-���������� �����������, ���������� � ���� �������, ������� ���������� �� ����������� ������������� ��� ����������� � ����� �������, � ����� ����������������, ��������� �� ����������� ��������� ����� ����������� ����� ��. ����� ������� ��� ��������� �� ������ ��������� ����� �� ������ ���. � ������� ����� ����� ��������, ��� ��������� ���� ������� ��������� �������� ��������������� ������� ��� ���������� �� ����������� �������� � �������� ���������� �������� ��������������� �������. � ������� �������������, ������� ���� ������� ���������� �� ������, ����������, ��� ���������� ������ ��� �� ������ ���������� ��������� ��� �������� ������������ ������������ ������� � ��������� �� �������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (39,339,'������� ����� ����� ���� ��������� ���� �� ��������� �������',2,'� ������, ��� �������� ��������� ���� �� ��������� �������, ���������� ������� � ������������� ������. ����� ��������� ���� ���� ������� ����� �����, ������� ����� ��������� ������ ������� �������� � ����������� �������� ����, ��������� ������� ��������. ���������� ��������� � ������� ������ �� ������.','� ������, ��� �������� ��������� ���� �� ��������� �������, ���������� ������� � ������������� ������. ����� ��������� ���� ���� ������� ����� �����, ������� ����� ��������� ������ ������� �������� � ����������� �������� ����, ��������� ������� ��������. ���������� ��������� � ������� ������ �� ������. �������� �������� � ������ ������ ����� ������� ����������� � �������� ���������, �� ����� ������� �� �� �������� �� ������ ������. � ������������ ��������� ������� �������� ����� ��������, � ��� ��� ������, �������� � ���� ����������� ��� ������ � ������ �������, ��� �������� ���. ����� ����� ������������ ����� ���������� ��������, ������ �� ����� ����������� �� �������� �� ����� ������. ����������� �������� ������� ���� ��������� � ����� ���������� ���������, ��� �� ��������� ��� ������ ���� ������ �����. �� � ����� �������� ����� ���� ���� ��������, �������� ����� ��������� ����� ������� ������ �� ������������ ���������. �������� ������ ������� � ������ ����� � ����� ������ 19-� � 20-� �����. ��� ��������, ��� �� ��������� ���������� ���� ������ � ������� ��������� ������� ����� ������������ ������ ���� ���������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (40,340,'����� ����� ������� ���� �������� � ��������',2,'����������� ����� ����� ������� �� ����� ����� ����������� ������������ ������ ����, ���������� � ����� � �������� �����������, ������� ������� ������ � ������� 2006 ����. ��� ������� ����������� �� ��������� �������� ����� �������� ���� ������� ��������� � ����� �� ������ ������������� �������.','����������� ����� ����� ������� �� ����� ����� ����������� ������������ ������ ����, ���������� � ����� � �������� �����������, ������� ������� ������ � ������� 2006 ����, �������� AFP. ��� ������� ����������� �� ��������� �������� ����� �������� ���� ������� ��������� � ����� �� ������ ������������� �������. ��� ������ ����������� �� ����� ������������� ����������� ����� ����� ��� ��-��� (Shin Eon-Sang), 28 ����� �������� �������� ����� ��� ����� ����������, ������������ � �������� ����� ����� 2006 ����. � ������-���, �� ��� ������, � ���� ����� ���������� ����� ���������, ������ � ��������. ����� ���� ����� ������������ ��������� �������� ���� � ��������� � �������� ����������. ����� ��� 22 ����� �������������� ���������� �� ������� ��������� � ��������� ��� ���� �������. �������� ����� �������� � �������� ��������������� ��������������� ������ � ����� �����, ������� ����� ���� ���������� �� ���������� ���. ���� ���������� ���������� ����������, ���� �� ������� ������� � ���� ���������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (41,341,'���� �������� ������������ ��������� ����� ������������� � ����������',2,'����������� ������� �������� ������� ������� � �������� ������ \"����\" ������, ��� ������������ � ������������ ������ ������ � �������� ����� �� ���� ������� �������� � ������������, ��� �� ������ ������ �� ���������, - ��� ������ � ���� ���������� �������� ������� ����� - ���� ��������.','����������� ������� �������� ������� ������� � �������� ������ \"����\" ������, ��� ������������ � ������������ ������ ������ � �������� ����� �� ���� ������� �������� � ������������, ��� �� ������ ������ �� ���������, - ��� ������ � ���� ���������� �������� ������� ����� - ���� ��������. ������ � ���, �������� ������� �������, ��� �� �������� ������������ � �������� ������ ���������� ����� ����� ������ � ���������� ����� ���� �������� � ������������ ����. � ���� ����� �� ������� �������� �� ��������� \"Ut unum sint\" ������ ����� II, ������� ��������� ���� �������� \"� ����������� ����������� ��� ������ ������������� ������ �����\", �������, ��� ��� ����������� ��������� � �������. � ����� ������� ������� ������� ���������, ��� �������������� ������ ������� - ��� \"�������������� ��������\". �� ��� ������, � ����������� ���� ���� ����������� ���������� ��������, �� ������� ��������� �� ������ �����, �� � ������ �������� ����� �������. ������ �����, ���� � ������ ������ ���� � ��������������� ������������� ������������ ��������� � ����������� �������������� � ����. �� ����� �������, ������������� ������������ ������, ����� ������������ ������ ������� ��������� ������ �� ��������������� ���������� ��������� ����� �������, � �������� ��������� \"���������\" ������ ����� ������ �������� �������� \"�����������c���\". �� �������, ��� ����� ������������ �������� ����������� ������ �������������� �������������, ��� ����� ���������� � ������������� ��� ��������, ����� ��� �� ������� � ���� ����. ����� ���, �� ������ ��������, \"����� ��� ������������ ���������, ������ �� ������ � ������, �� � � ������ � ������ �������, �������� �� ������, ��� �������� ����\".',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (42,342,'���� ������ ��������� ���������� � �������� �������������',2,'���������� ���� �������� ������������, ��������� � ����������� �������������� ���������� ������, � ��� ����� � ����������, � ���������� �������� �������������, ���� � ��� ����������� �� ����� ����� �������� ������� ����������� ��������������. ������ ������ �������� ��������, ��� ������������� ������������� ����� �� ������������������� ��� � ������, �� ����������.','���������� ���� � ������� �������� ������������, ��������� � ����������� �������������� ���������� ������, � ��� ����� � ���������� � ���������� �������� ������������ ���������� � ������ ������������ �������� �� ����� �������������, ���� � ��� ����������� �� ����� ����� �������� ������� ����������� ��������������. ��� ����� ��������-������ NovoNews, �������� � ������ � ��������������� ����������� �������� ������������� ������� \"�� ����� �������� � ������ ������\" (������). ������ ��������� �������� ��������, � ���������, ��� ������������� ������������ ���������� �������� ������ �� �������������������, ��� � ������ ������ ������ � � ��� ������ ���� ����� �� �������������� ���������� ��������, ����������� �� ������� �����. ������ �� �������� ������������� �� ������������ ������������� �������� ������������� ������ 22 ��������, 23 ���� ������ � 37 ������������. ����� ���, ��� ���������� � ������, � ��������� ����� � ����������� ������� � ������� ������ ���������� ����������� ������������ ���������� ������������� � ������������� ������, ����� ������������ ���������� ���� �� �������� ���� ��������������� ���������� ������� �����, ��� ���� ������������� ����������� ������������� � ��������.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (43,343,'� ������ ��������� ������ ������������ ��������',2,'� ������ ��������� ��������� ������ ���������� ��������. ��� �������� ��������� �� ������� �� ���� ������������� �������, ��������� ���� ��������� �� ����������� ����������. ������������ �� �������� � ��������������. ���������� ��������� ���� �� ����� ��������� ������.','� ������ ��������� ��������� ������ ���������� ��������. ��� �������� \"���������\" �� ������� �� ���� ������������� �������, ��������� ���� ��������� �� ����������� ����������. ������� � ����� ������ ����������, ���������������� � ���������� 10 �������, ������ �� 18-������� �������� ������������� ��������������� ������������-������������ ��������. ���������� �������� � ���� �� �������� ����������, ����� ������� �������� �����������. ������������ �� �������� � ��������������. ���������� ��������� ���� �� ����� ��������� ������.',21,1174588081,1174588081);
INSERT INTO `news_news` VALUES (45,345,'� ���������� ������� ���� �� ���������',2,'� ���� ���������� ����� ������������� ��� ������� ��������� �������� �����, ��� ���� ��� � ������� ������� ������ ������� � ������� ����������. � ��� ������� ��������, ��� ����� ��� �����������, ���� ������ ��������, ���������� ������� ������ �������� ��� ������� � ������� ��� � �������. �������� ������ �����, �� ���� ���������, ������������ ��������� � �����.','� ���� ���������� ����� ������������� ���, �������������� � 8-10 ���������� �� ����� �������, ������� ��������� �������� �����, ��� ���� ��� � ������� ������� ������ ������� � ������� ����������. �� ���� ����� � ������� ��������-������� Telegraf.by. � ��� ������� ��������, ��� ����� �� ������� ����� 60 �������� ��� �����������, ���� ������ ��������. \"������ ����� � ���������, ������ � ������, �������, � ������ ����������� ��������������� ���\", - ������� ����������� ����� ��� �������� ������. �� ��� ������, �� ���������� ���������� \"���� ������ ������������� ���, ������ ��� �����, �� ���� ������, ���� � ������� ��������\". ������ ������� �����, ��� �������� ������, ������� ������ � ������ �������� ������, �� ������� �� ������ �������� ����� �� ������� ���������� ����, �����, �� ���� ���������, ������������ ��������� � �����. ������ ��� ��������� ���������� ���������� ������� ����������� ������������. ���������� ������� �������� ������ �������� ��� ������� � ������� ��� � �������. � ��������� ����� �� ����� ������ �������� 60 ����������� � 10 ������ ������� ��� �������.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (46,346,'��������� ������� ��������� ������� ������ �� ���-�����',2,'����� ���������, ���������� � ���������, �������� �� ������� ����� ���� Sotheby\'s � ���-����� ������� ������������ ��������������� ����� ����� \"����� �����\". ��������� ������� ������� � 40 ��������� ��������: ��� ����� ������� ���� �� ������������ ������������� ���������.','����� ���������, ���������� � ���������, �������� �� ������� ����� ���� Sotheby\'s � ���-����� ������� ������������ ��������������� ����� ����� \"����� �����\". ��������� ������� ������� � 40 ��������� ��������: ��� ����� ������� ���� �� ������������ ������������� ���������, �������� ��������� Bloomberg. ���������� �� ������ �������� 15 ��� 2007 ���� 91-������ ��������� ������� ��������������� ����� Sotheby\'s �����, �� �� �������� �� ������������. \"����� �����\", ���������� � 1950 ���� ������� ������� (����� ���� ������ � ������), ��������� �������� ������� �������� �����: � ��� �� ��������� �� ������, ������� ������� ��� ����������. ��������� �������� ������� � 1960 ����, ��� ��� ����� �����, \"������ � � ��������\" - �� ������������ ������ ������, �������� ���-��������� ����� ������������ ��������� (MoMA). ������ 47 ��� ������� ����� ������� �� ���-����� ����������� ������: � 2005 ���� ��� \"���������� �������\" ���� � ������� �� 22,4 �������� ��������, � � ���� ������� ������ ��������� ��� ����� ��������� 30 ���������. ����� ������ � ������ ����� ������� ������������ ���������� ������� � �������� �� �������� � ���� ��������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (47,347,'��� �������� �������� ������ \"������� �����������\" �������',2,'��� �������� ��������������� ��������� ������� ����������� �� �������. ����������� ��������� ����������� �� ������� � �������� ������, ������� ����������� � ������� ����������� ���� ������ ����� � ����� �������, �������������� ����� ��������� ������� � ������� �������� ����, ������, ��� �������� ������ �������� ������� ����������� ���� ������.','����������� ������������ ����� �������� ��������������� ��������� ������� ����������� �� �������. ��� ����� � ������� ProUA, �� ���� ��������� � �������, ������� ���������� ����������� ��������� ��� �� ������� � �������� ������, ������� ����������� � ������� ����������� ���� ������ ����� �� ������ ��������� ������� � ����� ������� 2006 ����. � ������� ����������, � ���������, ��� �� ������� ���������� ������� �����������, � �������� ������ �������� \"�������� ��������� � ������� �����������\". ����� ����������, ��� 10 ��������� ����� �������� ������ ���������� ���� � �������� �� 13 �� 18 ���, �������� ����� ���������� � �������� ������, � �������� � ������. \"���� ��������������� � ������� �������� � �������� �������� ��������, � �������� ���������, � �������� ���������, ���������� � ���������� ��� � ����� �������� ����������� �����\", - ��������� � �������. �������� ������ ���������� ����� ����� � �������� ������, ��� ���������� �� ���������� �������, ��������� � �������� � ������ ��������, ��� ������� � �����, ��� ���� ����������� ��������� �� ������ ���������� ������ �����. � ���� �������, �������� ������ ������������, ������������ ���������� ���������� ���������� ������������ ����� ������, ������������ ��������� ����������� ����� � ������������ �����, 11 ��������� ���������� ���� � �������� �� 12 �� 15 ��� � 20 ��������� - � �������� �� 16 �� 17 ���. ���� ������ ����� ������������ � ����� �������, ��� � ������� ��� ��� �������� �� ����������� �������� ����� ������� ���������� ����� �� �������� ����������� ��� ����-�������, � ������� ������������ � ����. �� ������, ������������� ���, ������� ���������� ����� ������������ ����� ������ ������ ���� �����, ����� ��� ���������� � �������������, ������� ����� �������� ����������� �� ������� ����������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (48,348,'�������� ���������� ������ �� 15 ����� �� ����� ����� ������ �� ���������',2,'�������� ���������� �������� � ����, ������� ������ ��������� � ���� ������ ��� ������ �� ����� �������� �� ����������, � ����� ��������� ������������ �� ������� ������������ ����������. ����������� ������������ ���������� �� ����� �� 10 �� 20 ����������� ���� ��� ���������� ��� ����� �� ���� �� 15 �����.','������������������� ����������� �������� � ���������������� ������ ��, ������� ������ ��������� � ���� ������ ��� ������ �� ����� �������� �� ����������, � ����� ��������� ������������ �� ������� ������������ ����������, ����� \"����������\". � ��, � ������ ��������� � ��������� ����� ����� ������������ ��������, ������ ���, ��� �� ��� ������������, ������ �������� ���������� ���������� �� ����� �� 10 �� 20 ����������� �������� ������ ����� (������ ����, �� �������� ��������� ������, ���������� 100 ������) ��� ���������� ��� ����� �� ���� �� 15 �����. ����������� �������� ��� ���������, ��� ��������� �������� ��������� �������� ����������, ������������ \"�������� ������������ ��������������\". � �� �� �����, ��� ����� \"����������\", ������������ ����� ����� ��������� ����� � ��������������� ������� ����������.',21,1174588081,1174588081);
INSERT INTO `news_news` VALUES (49,349,'������ ������� ��������� ������ ��-86 ��� � 1 ���',2,'������ ������ ��������� ��������� ������ �� ���� ���������� ���������� ��������� ��-86. ������ ����� ���� ������ � 1 ��� ��� 1 ���� 2007 ����. ��� �������� ������� ������������ ��� ��������� ��������� ��������, � ������ �� �� ������������� ����� ����� �������� ����������� ��� �������������� �����.','������ ������ ��������� ��������� ������ �� ���� ���������� ���������� ��������� ��-86. �� ���������� ������ \"����������\", ������ ����� ���� ������ � 1 ��� ��� 1 ���� 2007 ����. ��� �������� ������� ������������ ��� ��������� ��������� ��������, � ������ �� �� ������������� ����� ����� �������� ����������� ��� �������������� �����. � ���������, ���������� ��������� ������� � ��� ����������� ������. � ����������� ������� ������� ����� �������� �� ������ ��������� ������������ ����������� � ������� ����������� ������� ��������� ������ � ������������ ����������� ���������� ����������� ������� ������ ������ ������ ������ ����� �� 7 �����. � ������ ���������� ������� \"������� ���������� � ��������� ������� �������� �� ��������� ������� ������ 2007 ����\". ������ ����� ���� ������ �� ��������� ���������� \"������ ���������� �����\" � ��������� �� ���������� ����� ������������� ����������� ������� � ��������� ������������ ������. ������� ������ ������ �������� ������������ ��������������� ���������� ��-86 ������������� ������ �� ����� ��� � 2003 ����. ���������� ����� ��-86 ����������� ���������� ������������� \"������\", \"������-����\" � \"������������ ���������\". �� ������ ���������� �����, ���� ������ ����� ������, ��� �������� � ���������� ���������� ���������� �������� � ������, ����������� ������� � ����������������� ������������� ������ � ������ ��������, �������������� ������������ ����������� ��������, ��������, \"���������\". ������� �������� ��� ������������, ����� ������ ��-86 �� ����� ���������� ��������� ���� � ��������. ���������� ��������, �������������� �� ����, ����������� �� 25 ���������, � ��������� ��������� � �������� ����������� �� 15 ���������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (50,350,'������� �������� �������� ��� ������ �������������',2,'������������ ����������� \"������\" ����� ������ �� ������ ������� ������� � ����� ����������� ������� ����-2008 ������� - ������. � ����� 21 ����� � ���������� ��������� �����������, � ����� ������������ ������� ������� ������� ��������� ��� �� ������, ����� �������� �������� �������� �� ������ �������.','������������ ����������� \"������\" ����� ������ �� ������ ������� ������� � ����� ����������� ������� ����-2008 ������� - ������. � ����� 21 ����� � ���������� ��������� �����������, � ����� ������������ ������� ������� ������� ��������� ��� �� ������, ����� �������� �������� �������� �� ������ �������, �������� ����������� ���� ����������� ����������� ����� (���). ������ ������� ��� ������ ���������� �������� ������� ����������� ��������������. �� ������� ������������ ������� ����� �������� �� �������� ��������������� ������� ���� �����, � ������ �������� ������� ���������� �� ������ �������� ����������� \"��������\". ����� ����, �� ������ ����� ������� ������ �������, �� �������� ��� �������� ��������� ������� � ���� � ��������� ������������ ��������� ������ ��������. ����� ���������, ����������� ������ ����, ����� �� ���� ����������� ��� 50 �� 50. ������� ������ ������� � ������ � ������� � 17:00 ����� ����, ��� �������� ��������� ���������� �� �������� \"������\". ���� � ��������� ��������� 24 ����� (������ � 21:30 �� ����������� �������) � ����� ������� ������ ������� � ������ �����. ������������� ������ ������� ������ �� ���� � �������� �������: ����� �������� (����), �������� �������� (\"�����\"), ������� ������� (\"�������\"). ���������: ��������� ������ (\"�����\"), ������ ��������� (����), ������ ������ (\"���������\"), ����� ������� (������\"), ����� ������ (\"�������\" �). �������������: ������� �������, ���� ������ (��� - ����), �������� �������, ������� ���������� (��� - \"�������\" �), ������ ������������ (\"���������\"), ���������� �������, ����� ������� (��� - \"�����\"). ����������: ���� ������ (\"��������\", ��������), ������� ����� (\"���������\"), ������ ������� (\"�����\"), ��������� �������� (\"�������\", �������), ������� ����� (\"�����\").',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (51,351,'������������� ������ �������� �������� ��������� ����������� �������',2,'������������� ������ ������� �� ������ �������� ��������� ������������ ������� �� 2008-2010 ����. �������-������� ������ ������� ������� ������������� � ������� ���������� ������ ���������� ������, ����� �� 30 ������ ������ ��� � �������. � 2007 ���� ������� ������ ������ ����� ������� ����������� ����� �� ��� ����.','������������� ������ ������� �� ������ �������� ��������� ������������ ������� �� 2008-2010 ����. �������-������� ������ ������� ������� ������������� � ������� ���������� ������ ���������� ������, ����� �� 30 ������ ������ ��� � �������. �� ���� �������� ��� �������. � 2007 ���� ������� ������ ������ ����� ������� ����������� �� �� ���� ���, � ����� �� ���. �������� ������� ����������� �������, � 2008 ���� ������ ������������� �� ������ 6,67 ��������� ������ (19,1 �������� ���), ������� - 6,5 ��������� ������ (18,6 �������� ���). ����� �������, �������� � 2008 ���� ����� ��������� 173,2 ��������� ������ ��� 0,5 �������� ���. � 2006 ���� �������� �������� 7,5 �������� ���. � 2009 ���� ������ ������������� � ����� 7,4 ��������� ������ (18,8 �������� ���), ������� 7,4 ��������� ������ (18,6 �������� ���). �������� � 2009 ���� �������������� �� ������ 0,2 ��������, � � 2010 ���� - 0,1 �������� ���. ��� ���� ������ � 2010 ���� �������� ������ ���������� ������ (18,1 �������� ���), � ������� - 7,9 ��������� ������ (18 ��������� ���). ��� ���� ������� ��������, ��� ������ ���� ������������ ��� ����������� \"���������������\" �������. �� ������ ��������, ������������� ������ \"��������� ���� � ����� ������\", � ������� ��� ��������� ����� ���������� ��������������� ���������. \"���� �� ����� �� �������, �� �� ���� ���� �� ���� ������ �������� � ������ �� �������. � ��� ����� ��������� ���� �� ���� � ��� ���� ���� ������\", - ������� ���� ������� �������� �������. ����� ���������, ��� ������ ��� ���������� �������� � ������������� �������������� ��������� ��������� � ��������� ������, �������� �������� �� ��������� ���� � ���� ������� ��������� � �������� ������ �������� � ������������ ���������� � ��������� ���, ����� ������ �� 2008-2010 ���� �������� \"��������������\". ����� ����, ������������� ������� �� ������ �������� ����������� �������� �������� �� 2008-2010 ����. ����� ������ �������, ��� � 2009 ���� ������ ����������� ������� �������� 396,3 ��������� ������. � 2010 ���� - 524,8 ��������� ������.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (52,352,'�������� ���������� \"�����\" \"��������\" ������� ������ ����-���������',2,'\"��������\" ������� ������ ����-��������� �������� ������� ���������, �������, � ���������, ������� �� ��������� �������� � ����� ������� � ����������. ��������� �������� �������� �������� ��������� �� ������� ������� \"�����\", �� ������ �� ������� ����� ���������� 9,44 �������� ����� ����� \"��������\".','\"��������\" ������� ������ ����-��������� �������� ������� ���������, ������� ������� �� ��������� �������� � ����� ������� � ����������. �� ���� �������� �����-������ ��������. ������ \"���������\" �����, ��� �������� ��������� ������� \"��������\" � �� ������������ ������ ������������. ������ ������ ��������� �������� �������� �������� ��������� �� ������� ������� \"�����\". �� ������ ������� ���������� 9,44 �������� ����� ����� \"��������\" � ������� \"���������������\". ����� \"��������\" ��������� � ������ ����������� � ������ � ��� ������ 22 ��������� ��������. ��������� ��� ������������ ��������� ��������� �������� �, �� ����, ����������� ����������� ����������� \"���������\". � �������� 2005 ���� ��������� ��� ��������� ������� \"�� ������� ����� ���������� 2 �������\" �� ����� � �������� ������������ ��������������. ��������� �������� � ������������� � 1994 ����. \"���������\" ��������, ��� �������� ����� �������������� ��� ������ ���������: ��������� \"��������\" �� ������� ���������� �������� � ������ �� �� ��� ���� �� ��������. ����� ������������ ��������� ������� ����� ������� ����������� ��������. ������� \"��������\" �� ������ ������� 2006 ���� - 25,5 ���������, ������ ������� - 2,9 ��������� ��������. ���������������� \"������������\" ����������� ����� 75 ��������� ��������, \"�����\" - 9,44 ��������. ������������� � ��� - 88,3 ��������� ��������.',26,1174588081,1174588081);
INSERT INTO `news_news` VALUES (53,353,'��������� ������� ������� ����� �������� �� � ����������',2,'� ������ ����������� ������ ���������� ���������� � 2006 ���� ������� ������� ����� ��� ��������� \"� ����\" ���������� ����� ������������ ��������. �� ������ ����������� ��������, ����������� �� �������� ����, ��� �������� �����. �������� �������, ����������� � 1897 ����, ���������� �� �������.','� ������ ����������� ������ ���������� ���������� � 2006 ���� ������� ������� ����� ���������� ����� ������������ ��������. �� ��������� �������� ������ Kvaellsposten, �� ������� ��������� ��������� France Presse, �� ������ ����������� �������� ��� �������� �����, �� �� ����� ���, �� ������ �������������� ������ �� ����������. ������� 1897 ���� ��� ��������� \"� ����\" ���� �������� �� �������� ���� �� ��� ������ � ��� 2006 ����. �������� ������ ������ ����, � �� �������� ���������� ������� ���������. � �������� 2006 ���� � ���� ��� ������������ ��������������� ������� ��� ������� ������ ����� - \"����\" � \"�������\", ���������� � 2004 ���� �� ����� ���������. ���������� ������� ��������, ��� ������� ���� ���������� �� �����, � � ������ ��������� ���������, ��� ������� ��������� ��������� �������������� �� ���������� ��������� ����������� ������ �����.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (54,354,'���������� ������� �������� ������ ����� ���������',2,'��������� �����, � ������� ������� ������ ����� ������� ���������� �������, ����� �������� ��������� ������. ��������������� ��������� ������� � ��������� � ������� ����������� ������� ������ ������ ���������� �� ��������� ������. �������� ��� ��� ������� ����������, ��� � ��������.','��������� �����, � ������� ������� ������ ����� ������� ������� ���������� �����, ����� �������� ��������� ������. ��� ����� \"���������� ������\", ��������������� ��������� ������� � ��������� � ������� ����������� ������� ������ ������ ���������� �� ��������� ������. ��������� �������� � ������� ����������, � ��������. ��������, ������� ��������� ����� ����� �����, ������ �������� ��� ����, ������� �� ����������� ���������� ����� ����� ������� �����������, � �������������, ����� ������������ � ����������, ����������� ���� ���. ������� ��������� �������� ���������� ����� ������ � ����������� � ��������. ����� �� ��������� ���� ���������� ���������� ������������� ������. ����� ����� ������� ��������� ��� ��������� ������ ������, ����� ���������� ���� �������. ��������� ��������� ������� � ����������� ���������� �������������, � ����� ����������� ������� ������ �� ������� �� ������ ���� - ��������������� ���� ��� �������� �����. �� ���� �������-�������� �� ������ ����������� �� ������ ��������, � ��� ������������ ��������� ������ ��, ��� ������ �� ���������, �� ���� �������������. ����� ����, ������� ������� ��������� ���� �������� � ����, ��� ������� �������� ����������� ���������, �� ����� ������� �� ��� � �� ������� ������������ ��������. ���� ������� � ���� 1 ������ 2008 ����.',21,1174588081,1174588081);
INSERT INTO `news_news` VALUES (55,355,'���������� ����� ������� �� ������ ���������� ����� � ����',2,'������� �������� ������� ������ ������, ��� � 2009 ���� ���������� �����, ������� ����� ������ � 2008 ����, ����� �� ������� ������� �� �������� ����� � ���� ��� ����������� ������ ������ �� �������� ������ � ������ ��������� ���. � 2008 ���� ��� �������� �������� ����� 3,5 ��������� ������.','������� �������� ������� ������ ������, ��� � 2009 ���� ���������� �����, ������� ����� ������ � 2008 ����, ����� �� ������� ������� �� �������� ����� � ���� ��� ����������� ������ ������ �� �������� ������ � ������ ��������� ���, �������� ��� �������. ������ ������ ������������� ������� � ��������� ����� ������������� � ������� �� ����� �����. � ��������� ������������ ��������� �������� ������ �������� �� ����. ��������� ����, �������� ������������� �������, ����� ����������� �� ��������� 1 ������� 2008 ���� � ������� 10 ��������� �� ���. ��������� ����� ��������� ������ �� ����������� ��������� ������ �� ������������ ����� ������� ���������. � 2008 ���� �������� ����� �������� ����� 3,5 ��������� ������. ���������, ��� �������� ���������� ����� ����� ������������ � �������� ������ ������, � ����� ������� ��������� - � ����� ������� �������� ���������� ������������, ���������� � ���� ������ ����������, �������� �����-����. � ������� ����� ������������� ����������� �������������� ������� ����� ������� ��������� � ������������.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (56,356,'������������� ���� �� �������� ����� � ������� ����������',2,'�������� ���� �������� �����, ������� ������������ ������ �� �������������� ����������� �� ������� ��������� ����, ������� ������� � ������ � ������� � �������. ��������, �� ������� ���������� � ��������� ��� ���� ��������, ����� �������� � �������� ��������������� ������ ����, ����� ������������ �� ���������� ���.','�������� ���� �������� ����� ��� �� ����, ������� ������������ ������ �� �������������� ����������� �� ������� ��������� ����, ������� ������� � ������ � ������� � �������, �������� AFP. ��������, �� ������� ���������� � ��������� ��� ���� ��������, ����� �������� � �������� ��������������� ������ ����, ����� ������������ �� ���������� ���. 25 ��������� ��������, � ������� ���� ����, ���� ������������� � ����� ���������� ����� � 2005 ���� � ����� � ����������� � ������������������� � ��������� �����, � �������� � ����� �������� ����� ��������� ����������� �����. ������������ ��������� �� �������������, � ��� ���� �������� �� ������������ ������. ������ ���� ��� � �� ������ �������� ������ � ���� ���������: � ���������, �������� ��������� ��� ����� ��������� ��������������� ����������, ����������� ��� ����, ����� �� �������� �������� �� �����. ����� ���� ������ ����� �� ������ ��������� ��� ������, �������� ���������� ������� �� ������� ���. ����� ���������� ��������� �� �������������� ����������� ��������� �������, �� ����� �������, �� ������������ ���������� ������ ��������� ������� � ���� ���������. ��������, ��� � �������� ������� 2007 ���� ���� ����������� �������� ���������� � ������� ����� � ����� �� ������������� ������, ������ ������� � ��������� ���������� �, � ���������, �������������� ������ � �����. 20 ����� ������� ������, ��� ������������ �� ������� � �������������� ����������� �� ��� ���, ���� �� ������� ������ � ��������� � ��������� �����.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (57,357,'�������� \"�������\" ��������� ������� ���������������� ������',2,'������ � ������� �������������������� ��������� \"����� �������\" ��������� ������� �������� ������ �������, ���� ��������� ������� ��� ����� \"������\" ����� �������. �� ��� ������� ��� ��� �������� \"������� �����\" � ���������� �� \"����\". �������� ������ �� ����� � ���� ������� ����� ����, ������� ������ �����������.','������ � ������� �������������������� ��������� \"����� �������\" ��������� ������� �������� ������ �������, ���� ��������� ������� ��� ����� \"������\" ����� �������. ��������� ����������� ���������� � ������ 21 ����� 2007 ����, �������� \"����������\". ������ �������, ������������ � ������ 2007 ���� � �������� 42 ���, ��� ����� �� ����� ��������� ���������� �������������� ����: �� ���� ����� �������, ��� \"�����\" ������� ����������, \"����������� ������������ �����\", \"��������\", \"�������\" � \"�������\" ���������� ��������� (��������� �������� ��� ��������������� ������), \"�������� ������\" ������� ��������. ������ ��� \"��������\" �������� \"������� �����\" � ���������� �� \"����\". ����� �������� �� \"����� �������\" ���� ������������ ������ ���������� (\"�����\"), ������ ������� (\"����-�����\"), ������ ������� (\"��� �� ������\") � ��������� ������ (\"������ ������\"). �������� ������ �� ����� � ��������� ���� ������� ����� ����, ��������� � ������� ���������� \"������� �������\", \"������ �������\" � \"�������\", � ������� ����������� \"��� ��������� �� ������\" � ������ ��������� �������.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (58,358,'������ ��������� �������� ���� ����������� �����',2,'���������� ����� ������� ���, ������������ � ������������ ����� ��������� �� ������� ��������� �����, ��������� ���� �� �������� � ��������, ����������������� ���������� ����� ����������� � ������������ ���������� ����� � 60 �� 90 ����. ��� �������� ��������� ������������ ���� ������ ����� ������.','���������� ����� ������� ���, ������������ � ������������ ����� ��������� �� ������� ��������� �����, ��������� ���� �� �������� � ��������, ����������������� ���������� ����� ����������� � ������������ ���������� ����� � 60 �� 90 ����, �������� ��������� AFP. ��� �������� ��������� ������������ ���� ������ ����� ������. � �������, 23 �����, ������ ���������� ��� ��� �������� � ������������� ����� ���������, ������������ �� ������ ���������������� �����������, �� � ��������������� ������ � ���������. ���, � ���������, ���������� ������ ������������� ��������� �� ������� ����� ������������ ��������� ���������� ����� � ���������� �� ������� �� ������� ��������� ������. �������� ������ ������������ ������ ������� ��� ����� � �������� ������������� �������� � �������� �������� ���� ��������� � ����������� �������� ������������ ������ \"��������\" � ������. ���������� ������������� �� ��� ��� ������� ������ ������ ��� ������� � ���, ��� ��������� �� ������������ ������������� ������� �������� � ��������� �� ����� ������ ����� ����� �������. ������ � ���, �� ����������, ��� \"�������\" ���������� ������ � ������ ������� ������ � �����������, ������� ����� ����������� ����� ���������. \"���� ����������� �� ��������� �������� ����� ��������� ������������ ������ �� ���, ����� �������� �������� ��� �����������. ����, ����������, �� ���� �� ����������� ������\", - ������� ������. �� ����� ������, ��� ������ � ���� ������� ������������ �������� �� ���������� ������ ������� ������������ �������� ����, ��� ����� ������� � ��������� ����� �� �������� ������������ ��������� � �� ������� ������ ��������� ������. �������� �������, ��� ����� ��������� ����� ���� ����������� � ����� ������� ������. ������������� ������ � ��� ������ ��������� ���-������ (Nassir Abdulaziz al-Nasser) ����� ������ AFP, ��� �� ���� ������ �������� � ������������� �������� ���� �� ����� ��������� �� �����������, ��������� ��� ����������� ��� ������ ���������� ������ �������. ��������, � �������� ����� ������ ��� ���������� ����� ���������, ������� ���������� ������������� ������� ������ ��������. � ���������, ����������� �������� ���������� �� ������, � ����� �������������� ����� ���� �������� ���������� � �����������. � ������� 60 ���� ������ ������ ���������� ���������� �����. � ���������� ��������� ���� ����������� ��� ����� ��, ������ ������� ��� ��������������. ����� ������� ������ ������, ��� ����������� �� �������� ����� ����������� ����������, � ��� ����� ��������� �� �������������� ������� ��� � ������. �� ��������� ������� � ���-�����, �� ������� ����� ����������� ���������, ������� �������������� ��������� ����� ������ ������������. ��� ������ ������������ ��� ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (59,359,'�� ��������� ����� ������ ������� ������',2,'� ���������� ������� �� ��������� ����� ������� ������� ��������� ������. ���������� ���������� ������ � ����� ���������� ���� �����, ��� ������ �������� ��������� � ��������. ��� �������� ���������� ������, ��� ������ ���������� ������ ����� ���������� ������������.','� ���������� ������� �� ��������� ����� ������� ������� ��������� ������, �������� \"������������� ������ � �����\". ������ � ����������� ����� ����������� �� ����� � ���� ��������� ���������� ������ �������������� ������ ��� ��� ����� � ��������, �� �������� ����������� �����, �������������� ������� �� ���� ��������������. ���������� ������� ����� � ����� ���������� ���� �����, ��� ������ �������� ��������� � ��������. ��� �������� \"����� ��������\", ��� ���������� ������ ����� ���������� ������������. \"������ ���� �� �������, ������, ��� ����� ������ �� ����� � �����, ��� ��������� � ���������� � ��� ����������. � ��� ��� ��� ��������� � ������� 2008 ����\", � ��������� ������� � �������� �������������. � � ����� ��������� ���������� ����� ������� � ����� ��������� �����. �������� ������������ ��������� ��� ������ ����� ������ 158 �� �� � ����� ���� ��������������� ��� \"����� � ���������� �������������� � ���������\". ��� ������ ��������������� ��������� � ���� ������� ������� �� ���� ��� � ����� � ������� 200 ����� ������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (60,360,'�� ����������� ����� \"�����������\" ���������� ����',2,'�� ����������� ������� ����� \"�����������\", � ������� 19 ����� ��������� ����� ������, ������ ���������� ����. ����� ���� ������������ ������ �� ��������� ���������, �������������� ��������������� � ����������. �� ���, ��� ��������� � ����� � ������ ������, ���� ��-�������� ��������� ���������� ��� �����.','����� 22 ����� �� ����������� ������� ����� \"�����������\", � ������� 19 ����� ��������� ����� ������, �������� ������ �� ������� ����, �������� \"���������\". ��� ������� ��������� �����-������ ������������ ���������� ���������� ��� ������� ��������, ���������, �������� ���� ��������, ������� ��������� ���������� ��� �����, �������� �������� � ����� ������� ��������: ��������� � ����������� ����� ���� �����������, � ������������ ���� �������� ��������� ����� �� 50 ������. � ����� � ����, �� ������ ���������, � ���� ������� ������� �������� ����. ����� ����, ��� ������� ������������� ���, �� \"�����������\" ������������ ������ �� ��������� ���������, �������������� ��������������� � ����������. ��� ���������� �����, � ������ ������ � ����� ���������� 203 ��������: 93 �� ��� ���� �������, ������ ��� ����� ������������. 108 �������� �������, �� ���� ��� ������� �� �����������, 86 �� ��� ��������. �������� 60 �������� ���������� 22 �����. �� ������ �������������, �������� ������ � ����� ����� ����� ���������� ������ ������ ��� �� \"������������ ������\". ����� ������������� ��������� ������������, ��� ������ ����� ��������� ��-�� \"��������� ������ � ��������������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (61,361,'���� �� ������ ������� ������� \"����� 3\"',2,'������������ Universal Pictures �����������, ��� ���� �� ������� ���� �������� ������ � ������� ����� \"�����\", ������� ������ �������� ��� ����. �������� ������� ����� ����������� ����� ������ ������� ����� � �����. �� ��������� � ��� ���������� ������������ ������.','������������ Universal Pictures �����������, ��� ���� �� ������� ���� �������� ������ � ������� ����� \"�����\", ������� ������ �������� ��� ����. ����� ������� �������� � �������, ������, ��� �������� The Hollywood Reporter, ����� ��������, ��� �������� �� ����� ����������� ����� ������ ������� ����� � �����. �� ��������� � ��� ���������� ������������ ������, ���������� ������ ����������. ��������, ��� ����� ����������, ��� � ������ �������� ����������� ������� ����� ������� ������� � ������ �a��. �� ����� ����� ��������� ������ ����������� �� ���������� ����. ������ ������� ���������� �������� 100 ��������� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (62,362,'����� ������: ��� ��� �� �������� ������ ����������������',2,'������������ ����� 21 ����� ����������� ����������. Dow Jones ����� ����� �� 1,3 �������� �� 12447,52 ������, Nasdaq - �� 1,98 �������� �� 2455,92 ������, � S&P 500 - �� 1,71 �������� �� 1435,04 ������. �� ����� �������� ������� ��� ��� �������� ������ ���������������� ��� ���������.','������������ ����� 21 ����� ����������� ����������. Dow Jones ����� ����� �� 1,3 �������� �� 12447,52 ������, Nasdaq - �� 1,98 �������� �� 2455,92 ������, � S&P 500 - �� 1,71 �������� �� 1435,04 ������. ��� ���� �� ���-�������� �������� ����� NYSE ���������� 79 ��������� �����. ����������� ��������� ������� ��� ������� ������� � ��������� ����� �� ������ ������ ����������������, ��� ����������� ���������� � ������� ������ ����� ������������ ��������. ����������� ������� 21 ����� ��������� ����������������. ���������� FTSE 100 �������� �� 0,58 �������� �� 6256,8 ������, �������� DAX ���������� �� 0,18 �������� �� 6712,06 ������, � ����������� CAC-40, ��������, �������� �� 0,02 �������� �� 5502,18 ������. ����������� ������ �������� ���� ������ ��-�� ����, ��� ��� ���-��������� �������� �������� Total 21 ����� ��� �������� ���������� �������� �� ���������� � ���������. ��� ������� ��������� ��������� Total. ���������� ����� ��������� ����� 21 ����� � �����. ������ ��� �������� �� 0,88 �������� �� 1847,26 ������, ��������� ������� �������, ���������� ���� �����. ����� ������ ��� ������� - �� ������������ ����� �������� ��������� ������ �� 43,9 �������� ��������. ������ ������ �� ������ ������� ������� ����� ��� \"��� ������\", ������������ �� 3,07 ��������, � ������ ������ \"���������������\", �������� � ���� �� 4,91 ��������. �� ���������� �������� ����� ���� ��������� \"����� � ���\". ���� ���������� �������� �� 1,434 ��������. ������ ���� ���������� �� 1,02 �������� �� 1646,07 ������. ����������� ���� �� ��������� � 22 ����� ����������� ���� ������� � ������� 26,0335 ����� �� ���� ������, �� ��������� � ���������� ����������� �� ��������� �� 0,79 �������. ������ ������ ��� ������� ������ ������. ���� ���� �������� 34,6558 �����, ��� �� 1,29 ������� ������, ��� ���� �����. �� ������������� ����� ���� ���� ��������� �� ���� �� 1,3386 �������, ���������� ���� ������ ������� � 1,9680 �������, � �������� ���� - 117,47 ���� �� ������, �������� �������� NorthFinance �� ������ ������ �� NYMEX 21 ����� ������� ����� WTI � ��������� � ��� ��������� �� 36 ������ �� 59,61 �������. �� ���������� ������������������ ����� ICE ���������� �������� �� ����� ����� Brent, ����� � ���� �� 57 ������ �� 60,77 ������� �� �������. �� ����� ������ ������� ����� ������������ ���������� ��� � ���������� � ������ ������� �������������� �������. ��������� ��� � ��������� � ������ ��������� �� 3,6 �������� �� 7,16 ������� �� ������� ���������� ����������� ������, �������� �������� K2kapital. �� �������� ����� ������� �������� ���� �� ������ ����� ����� ����������������� ������� �������, � ����� �������� �������� ������ �� �������� ��� �� ������ � ������ ������ � ������.',27,1174588082,1174588082);
INSERT INTO `news_news` VALUES (63,363,'���������� \"������\" ��������� � ������������� ������������� ��������',2,'��������� \"������\" � �������� ����� ������� ���-16 ������������� �������� �������� ����������� \"��������\" �� ������ 68:65 � ��������� � ������������� �������. �� ���� ������ ������� ������� ������ �������� ������� � ��������� \"��������������\". ����� �������� ��������� ���� ����� � 1/4 ������ ���������� ����.','��������� \"������\" � �������� ����� ������� ���-16 ������������� �������� �������� ����������� \"��������\" �� ������ 68:65 � ��������� � ������������� �������. ������ ����� �������� � ���������, ������� ����-������� ������� ����-�������. ����� ��������, ��� \"��������\" ��������� ��������� ������� ������ ����� �����. �������� ���� � ������ ���������� ������� ����������� ���� �������, ��������� ������� ����� ����� � ��������� ������� ����� ��������. ��������� �������� \"������\" ������� ����� ������ 22 ���� � ������ 24 �������. ��������� ��������� ����-������� ������� ����������� ������ 24 ���� � ������ 11 ��������. ��� �������� ����������� ���� ��������, ����� ���� ������������ ������� �� �������� � ����� �����. ����� ������ ����������� ������� ������������� ���� ������� ������� � 23 �������. ����� ����, ����� ���� ����� ���� ������� ������� � ������� ��������, �������� � ����� ����� ������� ������� ����� 20 ����� � ������� ����� 20 ��������. � ����� ������ \"������\" ������� ���������� ���������� ����� � ��������� \"��������\", �� �������� ��������� �� �������������� �����������. � �������������� ������� ������ �������� ������� � ����� �� ������� ��������� �������, ��������� \"��������������\". ��������, ��� ����� � ��������� ���������� �������� �������� ����������� ������� ��������, ���������� ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (64,364,'������������ ������ � ���� �������� � ���������� ����������� ���������',2,'������������ ������ � ������ ������������ ��������� ���� ������������ � �������� 2006 ���� ����������� ��������� � ���������� ����������� ���������. � ����������� �������, ��� ���������� �������� ������� ���������� ���������� �� ���� ��������� ���� � ���������� ���������� ���������.','������������ ������ � ������ ������������ ��������� ���� ������������ � �������� 2006 ���� ����������� ��������� �� ������ 167 ����� 2 �� �� (���������� ����������� ��� ����������� ���������, ����������� ����� �������, ������ ��� ���� ����������� ��������), �������� � ������� ��� �������. ����� ������� ������ ������������ ���������� �������� ��� ��������� �������� ����. �� ������ ���������, �������� � ���� ��� ����������� � ������ ���������� ����� 3 �������� 2006 ���� ������ ����� ��������� � ����� ������ ������ � �������� ����� ������ ������� ���, ����� �������� ������ � �������� ��. ����� ��������� �����, ����������� ������ ���� �������� ���������� � �������� ������, ������ ������ ������ �� ����, ������� ������������ �� ���������. � ����������� �������, ��� ����� ������� 35-������ �������� ������� ���������� ���������� �� ���� ��������� ���� � ���������� ���������� ���������, ������������ �������� ������ ���� �������� � �������� ����. �����, ���������� ������, ����������� � 40 ��������� ������, ����� 40 ��������� ��� ���� �������� ��������� �����, � ���� ������� ���������. ������������ � ������ ���������� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (65,365,'������ ������������� ��������� � ����� � ������������� �������',2,'� �������� ����� ��� ������ ������ ������ ������� ������� ������� ����������� ��������, � ��������� ��� ���������� ��������� ���� �� ������ 335 �� �� (��������� �������� ������), ����������������� ������� ������� �� ���� �� ���� �� ������ ���. ��������� �� ������� ������������ ����� ������������ 19-������� �������.','� �������� ����� ��� ������ ������ ������ ������� ������� ������� ����������� ��������, � ��������� ��� ���������� ��������� ���� �� ������ 335 �� �� (��������� �������� ������), ����������������� ������� ������� �� ���� �� ���� �� ������ ���. ��� �������� � ������� ��� ������� �� ������� �� ������������� ����������� ������� �����������, ��������� �� ������� ������������ ����� ������������ 19-������� ������� ������� ���� ������. ��������� ����������� ������� �� �������� �������������� ���������� ������� ��������, � ����� ���������� ���������� ��������� 30. �����-������ ������������ ���������� ��� ������ �� ����������� ���� ���� �� ������������ ������������ ����������� � ��������� ������� �������������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (66,366,'������� �������� �������� ������������ ����� � �������',2,'� ����� ����� ����������� ������������ �������� ��� ������������ �������� ��� �������� ������ ����� ��������� ����������� �������� ������������� ��������� ������� � �������. �� ����� ���������� \"������ ��������� ������\", ������� ���� ������� ��� ��������� ��������� �������� ����������� ������.','� ����� ����� ����������� ������������ �������� ��� ������������ �������� ��� �������� ������ ����� (Yaacov Ederi) ��������� ����������� �������� ������������� ��������� ������� � �������. ��� ����� Ha\'aretz, �� ����� ���������� \"������ ��������� ������\". ��� ������������ �������� ��������� ������ ���������, ����� ������� ����������� \"����� �� ������\" � \"�������� ���\". ������� ���������� �������� ��������� ���������: ������ ������������ ������� ��� \"���������\", \"���������\" ��� \"�������� ����������\". ���� ��� ��������� ��������� ����������� ������, �������� � ���������� ���� ������� ��������, � ����������� ���� ������� ������� � �������� ��������� ������� �����. ������ �������� � ������� �� ��� ��� ����� ������ \"��������\", ��� � �������� ����� �� �������� ����������� ��������� ������� ������ ������������ � ���� ������������ \"������ ������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (67,367,'������ ������������ ������ ��� � ������ �� ������������� �������� �������',2,'� ����� ������� �������� ��� ���������� 20-������� �������� ������� ������� � ���� ����� ��������� ���������� �� ������� � ������������� � �������� 14-������ �������� ������� �� ������ ��������, � ����� ��������� ������ �� �����. ���� �� �������� ��� ������� ���������� �� �������������, �� �������� � ������ 27 �������.','� ����� ������� �������� ��� ���������� 20-������� �������� ������� ������� (Bryan Howard) � ���� ����� ��������� ���������� �� ������� � ������������� � �������� 14-������ �������� ������� �� ������ ��������, � ����� ��������� ����� ������ �� �����, �������� Associated Press. ������ ������� ���� ���� � �������� ��������� ���� ��������� ������ ������ ���������� ������������, ������� ����� ������� 15-������� �����. ���� �� �������� ��� ������� ����������, ������������ �� �������������, �� �������� � ������ ���� 27 �������. ����� ������� ������� ������ ������ (James P. Barker) � ������� ��� ������ (Paul E. Cortez) ������� ��� ��������, ��� 12 ����� 2006 ���� ��� ��������� ��� �� ������� ������������ ���� ����� ����� ���-�������. � ��� ����� ������� ������ ���� (Steven Green) ��������� ������ �� �����, � ����� � �� ����. ������ � ������� ������ �������� (Jesse V. Spielman) �� ��������� ����������������� ������� � ������������, �� ����� � ��� � ���������� �����. ������ ��� ���������� � 90 ����� ��������� ����������, � ������ - � 100 �����, ������ ��� ������ ���������� ��������� ������������ ����� ����, ��� ������� ������ ������ ���. ��������� �������� ���������, �� ������� ����� ������� �������� ���������, �������� �� 2 ������.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (68,368,'� ������ ������ ���� ������� ������� � ����������',2,'� ���������� �������-������������� ������������ �� ������� ������ � ������ � ���� �� ������� ������� ���� �������. � 2:15 �� ������-�������� ����� ��������� ������� ������������ ���������� \"������\" � ��������. ����� ������������ ���� �� ����������� ���������, � ��� �������� � ������ ��������� ������� ������.','� ���������� �������-������������� ������������ �� ������� ������ � ������ � ���� �� ������� ������� ���� �������, �������� ��������� \"���������\". �� ������ ������������������ ������� �������, � 2:15 ����� ���� 19 �� ������-�������� ����� �� ������� ������� ������ ��������� ������� ������������ ���������� \"������\" � ��������. ����� ������������ ���� �� ����������� ��������� (�� ������ ������, ���������� ���). �������� ����� �� ����� � ������ ��� ��������� �� ������ ��������� �� ������������� ���������� � ������� � ���. ������������� ��������� ����� ��������� ��� �������, ��� ���� �� ����� ������� �� ������ ���������� �������� �, �� ��������������� ������, �������� ��� ����� ������������ ���������� �������� ��������� ��������. �� ����� ������������ �������� ���������� ����������� � �������������, ������� �������� �������� �������������� ������������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (69,369,'������ ������ ��������� ����� ����� ������',2,'� ����� ��������� ������� ���������� �������� �����, ������ ������������� ����� �������������� �������� ����������� ETA, ����� ���� ��� ���� � ���� ��������� � ���������� � ���������� ���������� � ������ ����. ����� ������ ��������� ��� ��������� � ��������������� �� ��, ��� ������ ������ ETA ���������� ����������.','� ����� ��������� ������� ���������� �������� ����� (Arnaldo Otegi), ������ ������������� ����� �������������� �������� ����������� ETA, ����� ���� ��� ���� � ���� ��������� � ���������� � ���������� ���������� � ������ ����. ����� ����� ������� �������, �������� France Presse. ����� ������ \"��������\" ��� ��������� � ��������������� �� ��, ��� �� ��������� 22-������ ����������� ETA ����� ���������� (Olaya Castresana), �������� �� ������������� ��������� �� �����������, �� ������ ������ ETA ���������� ����������. �� ������ ���������, ���������� ������� \"���� ��������� ������� ������������, ������ ��� ���� ������, ������� ����� ���� �������, �� �� �������� ������������\". ����� �������� ����� ��� ������ ��� ������� ������� � ������ �� �������, ��� �������� ��� ���� 15-��������� ��������� ����������. �������, �� ������� ����� \"��������\" ��� ����� �� �� ����� - ��� ��������� �� ���� ����� ���� ��� � ������� ���������� �������� ����������. � ������ 2005 ���� ����� ��� ��� ���������� � ���� \"������\" �� ��, ��� ������ ������ ����� ������� \"������� ���������\" ������. ����� ����� ����� ��������� �� ������ ������������� ��������, ���������� ��� � ������� ���� �� �������� ��� � ������ ����� ETA, ���� ������ ���������� (Jose Miguel Benalaran). ��������� ��� ������� ���������� ��������� ����� ������������� ������� 27 ���, � ������� �������� ������� ������� \"��������\". ������������� �������� ��������� ������� ������������� ����� ETA � ������� ���� ����� ����, ��� ��� ������������� ���������� ������ �������������� ������ ������� ������. � ������� ����������� ��� ���������, ������������ ETA � ����������� �� ��� ����� ���� ��� - �� ������ ����� � ��������� ������� 30 ������� 2006 ���� ������� ��� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (70,370,'����������� ��������� � ������� �� ��������� ��������� �� �������',2,'����������� ���������� ������ ������ ���������� � �����, ��� �������� �� �� ������ ��������, ������������� � ��������, ������� ������ � ������ ���������, �������������� ��������, � ����� �������� ������ �� �����������. ��������������� ��������� ���������� � ����������� ������ \"� �������� �����\" � ���������� �������.','����������� ���������� ������ (���) ������ ��������� � �����, ��� �������� �� �� ������ ������������� �������� �� �����������, �������� ��������� \"���������\". ��� ��������� � ����������� ���, ��������� � ������������� �������� ����������� �� �����������. ����� �������� ����� ��������� ���������� �� ������� �� � ���������������� � ������������ ������, � ��� ����� ��������-�������������. � ����������� ��� ��������� �� ����� ������������ ������ \"� �������� �����\", ����������� �������, � ����� ������ �� 1991 ���� \"� ������� ������, ��������� � ������������ ������ ���������� ��������� � ����������� ������� � ��� ��� ����������� �� ���� �� �������\", �������� ���������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (71,371,'������������� ���������� �������� ���������� �� �������',2,'� ����� � ������������ ��������� ������ ���������� �������� ������� ���������� �� �������, ����� �� ��� �� ������. ����������� �������� ��������� ��� ���������� � ������, ����� �������� ����� �� �������. �� ���������� ����� ��� ���������� �� ���� � ��������.','� ����� � ������������� ������ ������ (Sintra) � ������������ ��������� ������ ���������� �������� ������� ���������� �� �������, ����� �� ��� �� ������, �������� ��������� France Presse. ����������� �������� ��������� ��� ���������� � ������, ����� �������� ����� �� 60-������ �������. �� ���������� ����� ��� ���������� �� ���� � ��������. ��� ����������, ��������, ����������� � ����� �� ��������� �����, ������ ��������� ��-�� ������ �� �����. �� ������� � ������� �����, ��� ������ ������. ���������� ��������� � ������ �� ���� ������� ����� �����, ���������� �������, � ������������ � �������� ����������, ���������������� �������� ��������. ������� ��������� ���������, ���� �� ����� �������� ������� ����������� �������� ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (72,372,'��� ������ � ���������� ���� ����� �������',2,'� ���������� ������ � ���� �� ���-������� ������ ����� �������. ���������� � ����������� ����, ������������� �� ����� ���������� �������� �� ������� ����� \"������\", ��������� ����� 24.00. � ������ ���������� �����, ������� ������ ��������� 300 ���������� ������. � ���������� ���������� ����������� 10 �������� ��������.','� ���������� ������ � ���� �� ���-������� ������ ����� �������, �������� � ������� ��� �������. ���������� � ����������� ����, ������������� �� ����� ���������� �������� �� ������� ����� \"������\", ��������� ����� ��������. �� ������ ������������� ���, � ������ ���������� �����, ������� ������ ��������� 300 ���������� ������. � ���������� ���������� ����������� 10 �������� ��������. ��� ������� ��� ���������� ���� ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (73,373,'������ ���������� � ���� ��-8 ������������ �����',2,'�������������� \"�����������\" �������� ��-8, ��������� � ����� ���� � ���������� ����, ����� � ������ ��� �������� ��������� �������. �� ������ ������������� \"��������\", ����� ���������� �� ������ \"�������������\", �� �������� �� ������� ����������� ���� �����������. �� ����� ��������� ���������� ����� �������.','�������������� \"�����������\" �������� ��-8, ��������� � ����� ���� � ���������� ����, ����� � ������ ��� �������� ��������� �������. �� ���� �������� ��� ������� � �������� \"�������\". ��������, �� ����� ��������� ���������� ���� ������ ������� � ���� ��������. �� ������ ������������� ��������, ����� ���������� �� ������ \"�������������\", �� �������� �� ������� ����������� ���� �����������. ����� � ��-8 ���� �������� � 15:00 �� ����������� �������, �������� ����������� � ���� ����� �������� ������ ������� �� ����� �������������� ��������. � ������������ ������� ������� ����� ������� �������� ��-8 ���� ����������, �� ������������� ������������� �� ���� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (74,374,'����� ���� ����������� ���� �������� � ���������',2,'����� ���� ����������� ���� ��������, ������� � ���� ����� ���������� ����� � �������� ��������. 25 ����� 2007 ���� ��������� ���������� 60 ���. ��� ����� ����� �������� ������������� ������ iTunes � 26 ����� �� 30 ������ 2007 ����. ����� 25 ����� � ������� �������� ��������� ����� Rocket Man : The Definitive Hits.','����� ���� ����������� ��������� ���� ��������, ������� � ���� ����� �������� ����� ��������, �������� International Herald Tribune. 25 ����� 2007 ���� ��������� ���������� 60 ���. � ����� ��������� ����� �������� ����� ���������� �����, ���������� �� ����� ����� ���. ��������, ��� ������ ��������� ������ ����� ��� ��������� Open Sky ��������� � 1969 ����. ��� ����� ����� �������� ������������� ������ iTunes � 26 ����� �� 30 ������ 2007 ����. ����� �������� ��������� �������������� ����� ������� ������� ���� ����� ���������� ����������, � ��������� �� ������� ���������� � ������� ��� ��������� ���������. ����� ����, � ���� �������� ����������� � ������� �������� ��������� ��� �����, ���������� ������ ����� � ������, ����������� ����������� �������� � ������������. ������� ������� �������� Rocket Man: The Definitive Hits.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (75,375,'������� ���� �� �������� �������� �������� �� ������������� ������',2,'�������� � ���������� ��� ���� ������� ������, ��� ��������� ��������, �������� �� ������ ��������� �������� ��� ����. ������� ��������, ��������, ����������, ��� � ��� ��������� ������� ���� �����, ����������� � 2004 ����, ������ ��� ��������� ������������ ������� ���� ���������� ������ �� ������� ���� ������.','�������-�������� ���� �������, ���������� � ������������ ����� �� ���� ���������� ���, ������ � ����� CNN, ��� ��������� ��������, �������� �� ������ ��������� �������� ��� ����. ������� ��������, ��������, ����������, ��� � ��� ��������� ������� ���� �����, ����������� � 2004 ����, ������ ��� ��������� ������������ ������� ���� ���������� ������ �� ������� ���� ������.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (76,376,'������� ������ \"���������\" ��������� ���������� \"����\"',2,'��������� ����������� \"���������\" ������� ������� �������� ����� � ����� �������� �� ��������� ��������� ������ � ���������� \"����\". �� ����������� ����� �������������� ����� �� ����������, ��� ��������� ���� ������ � \"���������\", ���� �������, ��� ����������� \"����\" � ������� ����� ��� ������ �������.','��������� ����������� \"���������\" ������� ������� �������� ����� � ����� �������� �� ��������� ��������� ������ � ���������� \"����\". �� ����������� ����� �������������� ����� �� ����������, ��� ��������� ���� ������ � \"���������\", ���� �������, ��� ����������� \"����\" � ������� ����� ��� ������ �������. \"���� ��������� ����������� � � ��������� �������� ���� ������ � \"���������\" � �� ��������� ������ �������. �������, �������� � \"�����\" � ������� �����, ��� ����� ��� ������ � ��� ������ �����, �� � �������� � ������ � �������, ��� ��� �������� ���� ���� �������� �������\". ����� �������� \"���������\" ��� ���� ������ �� ����� ����������� �������� ���������� ������� �������� � ��������� ������ � ��������� ��������� 31 �����, ����� ����������� ������� � \"���������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (77,377,'�������������� �������� �� �����������-������������� ����� ����������� �����',2,'�������� �� �����������-������������� ����� ����������� ������������� �������� �������������� ��-�� ������� �������� �� ������. ������ �� ���� � ����������� ������ �� ������� \"�����������\", ��� � ��������� ��������.','�������� �� ����� ����� ����������� ������������� �������� �������������� ��-�� ������� �������� �� ������, �������� ������������� Lenta.Ru. ������ �� ���� � ����������� ������ �� ������� \"�����������\", ��� � ��������� ��������. ��������, ��� ������������ - �������. � ��� ��������� ���� ������ �� ����������. ��� ������������� ��������, ��� �� ������� ��������� ������� ���������� �����. � ���� �� ������ ����� ������ � ���������� ����� - ������������ ���-���.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (78,378,'������������� ����� ��� ���� ������������ �� �������� �����������',2,'����������������� �������� �� �������������� �������� �������� ��� ��� �������, ������� ����� ��������� � ������� ������� �����������. ����������� ������� � ���������� �������������� ��������� � ���������� ����� ����-����, ������������� �������� ������������� � ���������� ������� � ������������� �������� ������ � ����.','����������������� �������� �������� ��� ��� �������, ������� ����� ��������� � ������� ������� �����������. ��������� ����� ���������������� ���� ����������� �������� ������ �� ���������� ���������������� �������������� ��������� \"��-2\" � ���������� ����� ����-����, ������������� � ������������� �������� ������������� � ���������� �������, � ����� �������� ������ � ����. �� ���� ������� ����� ����������������� �������� � ������� �������������� �������� ������ ����. ��� ����� �������� ��� �������. ����� ��������� ���� �������� ���������� 162 ��������� ������. 56 ���������� ������ ����� �������� �� �����������. ����� �� ��������� ���� 12 ��������, ������� ������������� � ������� ��������, ��������� �������� ������. �� ��� ����������� ������ 286 ���������� ������. �� ������ �����, ����� ������ �� ���������� �������� �������� ��������������� ����� �����-��������. ��� �������� ��������� ������� ���� ����� � ���� ��������������� ����� ������. ��������������, ��� ����� ���������� ������� ��� ���� ��������, � ��������� ���� ���������� � 4 ����. ������ � ����-���� ������������ �������� 700 ����� ������� ����, � ������ ����������� � ����������� ������ �������� 8 ���������� ������, ������� ����. �������� �� ������� �������� ��������� ���� � ��������� ������������ �� �����, ��� ������� �� �������� � ������ ����������� �������. ������ � ���������� ������� ������� ������� ��� ������������� 12 ����� ���������� ������ ������������, ��� �������� ���������� ������ ����� 400 ����� �������. ���������� ��� ��������� � ������ 2005 ����. �� ������� �� �������, ���������� �������� �� ������� ��� �� ����� �� ������� ������. �� ��� ���� ����������� ��������� 377 ���������� ������ �����������.',25,1174588082,1174588082);
INSERT INTO `news_news` VALUES (79,379,'�������� �350 �� ���� ��������� ����� �����������',2,'����������� ������� EADS � ��� \"������������ ���������������� ����������\" ��������� ����������, �������� �������� ������ ����� ��������� ���� ��������� ����� �� ������������ � �������������� ��������� �350. � ��������� ����� ������� ����� ���������� � ���, ����� ������ ���������� �350 ����� ������������� � ������.','����������� ������� EADS � ��� \"������������ ���������������� ����������\" ��������� ����������, �������� �������� ������ ����� ��������� ���� ��������� ����� �� ������������ � �������������� ��������� �350. �� ���� �������� \"���������\". � ��������� ����� ������� ����� ���������� � ���, ����� ������ ���������� �350 ����� ������������� � ������. ����� ���� ��������� ���������� � �������� � �������� ����������� ����������� ��� ����������� � ������������ ������ �������� � � �������� �������, � ������� ����� ������������ ������������ �������� A320 � ��������. ���������� � Airbus ����� ��������� ����� ����, ��� ������ ����� � ������ ���������� EADS � ������������� ��������� ��������. � �������� ���� ���������, ��� ��������������� ���� ��� ������ 5 ��������� ����� ������������ ��������.',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (80,380,'������������� ������� ��� ���������� ����������� ������������',2,'������������ ������������� ������� �������� ����������� ���������� ������������ ������� �� ���������� �������������� ���������� ������, ������� �� ������������� ������������ ������� �� ���������� ���. ����� ������� ���� ������� �� ����������� ������� ������������� ������, ��������� � ��������.','������������ ������������� ������� �������� ����������� ���������� ������������ ������� �� ���������� �������������� ���������� ������, ������� �� ������������� ������������ ������� �� ���������� ���. ��� �������� LA Times, ����� ������� ���� ������� �� ����������� ������� ������������� ������, ��������� � ��������. �� ��������� �� ����������������� ���������� ������������ ������ ���������� �������� ���������� � ��� ��� �������������� ����������� ���������� � ������������� ��������� ����������� ������. � �� �� �����, � ���������, �������� �� ������ �����������, ���������: \"�� �������������, ��� ��� ���� �����, � ��� ����� ��� � ���������, �������� ������������� ����������� ����� ������ ���������\". ����������� ��������������� ����� �������, ���������� �������� ������� ������������ ������, ������� ���� ������������� �������� ������ �� ���. \"��� ��� ��������� �������� ��� ������ �������. ����� ������ �� ������������, � ������ �������� ��� �������� ����������� � �������\", - ������ ��. ��������, ��� �� ��������� � ����� ������� � �������� ��������� ������� 38 ������������ ������� ���� ������� �������������, � ������� � ������������� ����� ���� ������������� ������������� ������ ��� ���������� �� �������� ������������� ����������������. ������������ ������� ������ ���� ����� �� 30 �������� 2007 ����.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (81,381,'��� ��������� � ������� ����� �������� ���������',2,'������-������� ���� ��� ��������� � ������� ����� ����� �������� ������� ��������� \"������� ������\" � ������������� ��������� �������� � ���� ��������. ���������� ������� ������ ������ ������� � ���������� ������� ����������� ��� ��� � ����� �����, ������� �������� 25 ����� 2007 ����.','��� ��� ��������� � ������� ����� ����� �������� ������� ���������, �������� Defencetalk. ��������� \"������� ������\" � ������������� ��������� �������� � ���� �������� ������ ������� � ���������� ������� ������� �� ���������� ����� �����. � ������� ����� ������������� ����� ������������ ������, ����������� �� �����������. ������, ������� ������ ���������� 25 �����, ������� ������ ������� �������� �����. ������� ������� ��� � ����� ����� � ���������� ������������� � ������� � ���������� ������� ������� �������������� ����������� �� ��������� ������� ��������. CVN-76 Ronald Reagan ����� � ����� � 2003 ���� � ���� ������� ���������� ���� \"������ ������\". ������������� ������� ��������� 100 ����� ����, �������� ������� ���� ���������� 32 ����. �� ��������� ���������� ����������� F/A-18 Hornet � Super Hornet, �������� ���������������� ������ EA-6B, \"�������� ������\" E-2C, ��������������� �������� Viking � ���������. ����������� ��������� ��������� 70 �����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (82,382,'����������� ���������� ������� ������������� � �������� � ������',2,'�������������� �� 22 ����� ���������� ������� ���������� ����, ������� 20 ����� ������� ���������� ���������� ���������������� ��������� �� ������ ���������� ���� ������ ������� ������������� � ������� �������� � ���� � ������ ������� �������� ������������ �������� � ������, �� ����� ��������������� ������.','����������� ����������� ������ 22 ����� ���������� ������� ���������� ����, ������� 20 ����� ������� ���������� ���������� ���������������� ��������� �� ������ ���������� ���� ������ ������� ������������� � ������� �������� � ����, �������� ��� �������. ��������� ��� ����������, ��� ������������ ����������� �� ���� ������� ����� \"�����\" ������������� � ������� ������������ ������ ���������� ������ \"�������\" �������� ������ ����������� � ������, �� ����� ��������������� �� ������. ������ �� ������������ ��������� ��������������� ������������� �� ������� ���������� ���� ������� �� ������ �������� � ����. �� ����� �������, ������� ������������� ���� ����� ����� �������, ��� ������� ������������� ����������� ����������� ��������� �������. \"��� ������� �������� ������������. � ������ �� ����������� � ���� ����� ����� ����������, ����� ��� ����������\", - ������� ��. ��������, ��� � ������ ������ ���������� ���� ���-����� \"�����\" � ������������ ��� \"�������\" ���������� � ���, ��� � ������ c 1998 �� 2004 ��� �������� ����� �� ��������������� ����� - 850 ���������� ������. ������ ������������� � �������� ��������� ���������� ��������� �� ������ ��� ���������, �� � ��� ��������. ���� ����� ������, ��� ���������� ������������ ����� - ������ ������� �������� � �������, ��� \"������� ����� ����� ���������� ������, ����� � �������\".',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (83,383,'���������� ��������� ��������� �������',2,'������������ ��������������� ����������� ������� ������ ����� ���-����� ������� �� �����-����������� � ������, ��� ������ � ������� ���������� ��������� ��-86 �� ���������� ���� ������ ��������. �������� ������� �����������, ���������� �� ������ ��������� ����� ���� ����� ��������. \"�','������������ ��������������� ����������� ������� ������ ����� ���-����� ������ �� �����-����������� � ������, ��� ������ � ������� ��-86 �� ���������� ���� ������ ����� ����� � ������ ������. ��� �������� ��� �������, �������� ������� �����������, ��� ���������� �� ������ ��������� ����� ���� ����� ��������. \"������� ��������� �� �����\", - ������ ��. \"� ��� ��� ����� ������������ � ��������������� ��������������� �������� ������ � ������, ����� �� ����� �� ������ ���������� ������� ��� �������������. �������, ��� �� ����� �������������\", - ������� ���-�����. ������������� ��-86 ��������� � ���� ����� ��-�� �������������� ����������� ���������� �� ������������� ����������. ���������� ������ ����� ������������ �������� ������������ �������� ���� ��������� �� ����� ����������. ������, �� ������ ���-������, �������� ������ ����� �� ������� ���������� �������������, ��������� ����������� �������� �� ������ ��������� ���������� ������� � �������������� ��-86. ����� ���������� ������� ������� �������� ������ �� ����� ������� 2007 ����, � ��� ������� ���� �������������. \"������ �� ���� ���������� �� ������ ��������� ���� �� ��������� ��-86 � ������\", - ������� ���������� ��������. �� ����� ���������, ��� ������������ ��������� ������ ��������� �������� ������������� ��������� ��� �� ���, ����� ������ ������� �� �� ����� �����������. �� ����� ������� ������ ������� ����������. � �� �� ����� ������������� ��� ������� �������� �� �����, �������� �� ��������� �������� � ������������ ����������� ������� ������, ��� ������� �� ��-86 ����� ������� �� ����� ������, ��������� ����������� ���������� ������������� 31 ����� 2007 ����. �������� ����� ��������, ��� \"����������� �� �����\". ����� ����������, ��� ���������� ������ �������� ��������� ������ ��-86 �� ����� ���������� ��� � 1 ��� 2007 ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (84,384,'������ ��� ������� ������� � ������ �����',2,'�� ����� �����-����������� � ������� � �������� ������� ��� ��� �� ���� � �������-�������� ����� ���� ���-������ �������� �� ������, ��� ��������� �������, ���������� ����. ����� ��� ��������� � ���������. ���������� ���� ���������� � 50 ������ �� ���������, ��� ��������� ������� � ������������.','�� ����� �����-����������� � ������� � �������� ������� ��� ��� �� ���� � �������-�������� ����� ���� ���-������ �������� �� ������, ��� ��������� �������, ���������� ����. ����� ���, ��� �������� ��������� AFP, ��������� � ���������. �� ��������� Sky News, ������� ����� �� ��������. �� ������ ���������, ���� ���������� � 50 ������ �� ���������, ��� ��������� ����������� ������� ���, ����� � ������ ���� ���-������. � ������������ ������ �� ����������. ��� �������� ���������, ������ �� ��� �� ���� ���������� ������ ������ ����������. ���� �� ����������� ������ ������������ ��������� ������ ���� ���-������, ������ �� ��������� �������, ������, ��� �� ����� ����� ������. ����� �� �������� ����� ������� �����-�����������, ������ ������ ��� ���� ����������. ������ ��� ������ � ������ ����������, ��������� ����� �� ����������� ������������ ���� ����� �� ����������. ���� ���� ������ ������� � ������������� ��������������� ������� ��� �� ����. �� ����� ������� �������� �������, ���������, ��������, ����� � ���������� ������. ��������� ��� � ������ 2005 ���� � ���� �������� ������� ������ ���� �����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (85,385,'������ ������� ������� ������������� ���������',2,'��������� �������� ��� ������ ������� ������� �� ����� � �������� ������������� �� ��������� ������������ �������������, ������� �������� 29 ������� 2007 ����. ������������ ��������� ������������� 5 �������� ���� ������� � ��������� ����������� ����� �������. �������� ���� ���� � ������� \"����� ����\".','��������� �������� ��� ������ ������� ������� �� ����� � �������� ������������� �� ��������� ������������ �������������, ������� �������� 29 ������� 2007 ����, �������� Reuters. ������������ ��������� ������������� 5 �������� ���� ������� � ��������� ����������� ����� �������. ������ ��������, ��� ���� ���� � �������� ������ \"����� ����\", ������� �������� ������� �� ������ ��������� ������. ������� ���� � ������� ������ ������ ����. ����� �� ����� ������������ ���������� ����������� ������������� �������� ����� ������� �������, ��� \"������ ����� ����������\" � \"���� �������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (86,386,'������ ���������� ��-8 �������� ����������',2,'������ ��������� ��-8, ���������� � ����� � ���������� ����, �������� ����������. ��� ������� � ���������� ������ � ����������� ������, ��� ������ ��������� ������. ����� � ���������� ���� �������� � 15 ����� �� ����������� �������. �� ����� ���������� ���� ������ ������� � ���� ��������.','������ ��������� ��-8, ���������� � ����� � ���������� ����, �������� ����������. ��� �������� \"���������\" �� ������� �� ������������� ������������ �����, ��� ������� � ���������� ������ � ����������� ������, ��� ������ ��������� ������. ����� � ����������, ������������� \"�����������\", ���� �������� 21 ����� � 15 ����� �� ����������� �������. �� ����� ���������� ���� ������ ������� � ���� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (87,387,'�������� ������� ��������� � ���������� ��������� Boeing',2,'�������� �� ��������� � ������ ��������� �������� ����������� ������� ������ ��� � ���, ��� ��� ������ ������������ Boeing �������� �� 23,7 ���������� �������� � 1990 ����. ����� ��������, ��� �������� ����� � ��� ������ � ����� �� �������� ����������, ������� �������� �������� � ������������ Airbus.','������������� ��������� �� ��������� � ������ ��������� �������� ����������� �������� ������ ��� � ���, ��� ��� ������ ������������ Boeing �������� �� 23,7 ��������� �������� � 1990 ����. �� ���� �������� AFP. ����� ��������, ��� �������� ����� � ��� ������ � ����� �� �������� ����������, ������� ������� �������� � ���������� ��������� ������������ Airbus. ���������� 21 ����� �������, ��� Airbus ������� �� ����� ��������� 15 ���������� �������� ��������. ��� ����, �� ������ ������� ���, ����� ����� �������� �� ��������� 30 ��� ��������� 100 ����������. � ���������� ����������, ��� ������ ��������� ������������� Airbus ������������ ������� �� ���������� �������. ���������, ��� ��� ������� ���� ������� �� ���������� ��� � Airbus � ����� 2007 ����, ������, �� ������ ������������, �������� ����� ����������. ������� ��� �� Boeing ��������� �� ����� ����� 2008 ����. ����� ��������, ��� � 2006 ���� Boeing ������� �� ����� ��� ������ Airbus �� ���������� ������� ����� ���������. ����������� ������������ ��������, ����� ������� ��������, ��������� ���� Power8, �������� �������� � ������� Airbus ����� ������� 10 ����� �������.',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (88,388,'������ �������� �������� �������������� �������� ��������� � ���',2,'������ �������� ������� �������� ���������, ������� ������������, ��� �� ����� ��������� ������ � ��� ����� ��� ���� ��������� ���� ��������� � ����� � ����� ������� �������-�������� ������� ����� ���������. �� ���� ������ ������� ��������� ���� �� ������� \"����������\" ������� �������. ��� ���� �� ������� ���������� ���, ��� ��������� ��������� �� ���.','������ �������� ������� �������� ���������, ������� ������������, ��� �� ����� ��������� ������ � ��� ����� ��� ���� ��������� ���� ��������� � ����� � ����� ������� �������-�������� ������� ����� ���������. �� ���� ������ ������� ��������� ����, ������ ����������� ����� ������� \"����������\" ������� �������. ��� ����� ����������, ��������� �������� ����������� ����� � ������ ����� ����� ����. �� ������ ��������, ����������� ����� ��� �� ������� ������� ������� � ���, ��� ������� ����� ����� ��������� � ��������� �� �����������, ������ �� ������. \"����� �� �������� ���������, ������� ������������, ��� ����� ���, � ���������, ������ �� ��� ������ ��� ��� ����� � �����������, ������ ��� � ��� � ����� ���������, ������� ������������, ��� ������� ��������� ���������� �� ������� ������������ ���������� ������ ����, ��� ��������� �������\", - ������� �������. �� ������� ���������� ���, ���, �������� �� ������� � ������� ��������� �� ������� ������������� ����������, ����� ��� ��� �� ���� �������� �� ���. ������� ����� ��������������, ��� ������ ��������� �������� ��� ������, ����� �� ���� �������� ��������� ����, \"������ ��� ��� ������ ���������������\". \"��� ������, ��� ���� �� ������� ��������� �� ����� ��, ��� � ���� ����� �� ������������� ������� ���� ����������, �� �� �������� ������ ����� � ����, ��� ������� ��� �����\", - ������ \"��������\", �������, ��� \"�������� �� ���� �����\". � ��������� ����� ����������� �������� ��������� ���� �������, ������� ���������� ������������ ���� ��������� � ������ �� ����������� \"������� ��������������� �������\" (����), ��������� ������������ ������ ������������ ������� ��� � ������������ ���� ��������� � �������� ��������������� ������� ��������� � ������ ���������. ��������, � �������� �������� ���� ������������ ��� ���������� ��������� � ������ ����� ������� ������� � ������ � 10 ��������� �������� �� �������������� � ��������� �����. ���-�������, ������������� ���������� ������������� � �������� 90-� �����, �������� ������������� ������� � ��� � 1999 ����, ������ ������ �������������� ������� ������������ ������ ������ ����� �� ��� �����. ���� ��������� ���������� ��������� ���� �� ����� ����������� ��������� � 90-� �����. ����� ������������� ������ �������� ������������ �������� ���������� ����� ����� ������������� ��������� � ������� ���, ������ ��� ��������� ���� ���������� �� ������ ���������, �� � ����������� � ���������� ���-���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (89,389,'�������� ���������� �� ���������� ������� ������� ��� ����',2,'���������� � ������������ �������� ���������� � �������� �� ������ ���������� � ������� � ������������� � �������������� �������� ��������, ���������������� �� ����������� �����������. ��������� �������������� � ��������� �������� \"Gay\'s The Word\" �� ����� �������� ������: ������ ������, � ������� ������.','���������� � ������������ �������� ���������� � �������� �� ������ ���������� � ������� � ������������� � �������������� �������� ��������, ���������������� �� ����������� �����������. ��� �������� ������ The Guardian, ��������� �������������� � ������ ��������� �������� \"Gay\'s The Word\" �� ����� �������� ������: �� ����� �� ��� ������ ������� 20 ����� ������ ���������� (���� ������ 40 ����� ��������), � ������� ���� ����� �����. ������������ ��� ���� (Ali Smith), ��������� ������������� ������, ����� ������ \"����� - ���\", �������, ��� �������� \"Gay\'s The Word\" �������� \"������������, ����������, ������������ � ������������ ������\". ������ ���������������� �� ����������� ������ ���� ������ (Sarah Waters), ����� \"������ ������\", �������������� � ����, �������, ��� ������� � ��������� - ���� �� ����� \"����������\" ���������������������� �������. ������ ���� (Edmund White), ���������� \"������� ������ ��������\", ������ \"Gay\'s The Word\" ���������� ��������� � ���������� ����������. ����������� ������������ �������� �������� ��������� ��������� ������� � �����, ����� � �������� ������ ������ � ������ ������. \"Gay\'s The Word\" �������� � 1979 ����. � 1984-�� ��� �������� ������� �� ������ \"���������� ������������� ����������\", �� ���� �����������: ��� �� ������� ������������� ���� ���� ����� ���������, ���� ������ � ������� ��������. ������� ������ �� ������ ������������� ������� ������������� ���� � ���������, �� � ����������� ��������� � ����������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (90,390,'���� ������� ��������� ������ � �����������',2,'�������� � ���������� ��� �� ��������������� ������ ���� ������� �������� � ������ ��� �������� �������� ����������� �������� �� ������ ��������� �������, ����� �� ��������� ��������������� ���������� � �������. �� ��� ������, ��� ������ �������� �������������� �������� ����������� � ����������.','�������� � ���������� ��� �� ��������������� ������ ���� ������� �������� � ������ ��� �������� �������� ����������� �������� �� ������ ��������� �������, ����� �� ��������� ��������������� ���������� � �������, �������� AP. �������� ����� ���������� �������������� ��� � 1961 ���� �������� � ������ ������, ����� ������� �������� ��������� ������ ������ ������, ������� ��������, ��� ������� ��� ������������������� ���������� � �������� ���������� ������ ������ � ������� � ������ ������ �������. �� ����� ��������, \"����� � ����� �������� �������� ��� �� �� ������������ ���������, � ������ ��� ��������� �������������� �� ���\". \"�� ��� ������ ��������, ��� ����� �������, ��������� � ������ ���������� ������ �����. ��� ����������� ���� �����, ��� �������� ���� �����. ��� ��� ����� ���������\", - ��������� �������. �� ��� ������, ��� ������ �������� �������������� � ��������� ������� �������� ����������� � ����������, ����� �������� \"��� ����� ����\".',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (91,391,'��������� �������� Nikko ����� ���������� ������� �� Citigroup',2,'Harris Associates LP, ���������� �������� ������� Nikko Cordial, �������� �� �������� � ������, ����� ��������� ������� �������� ������������ ���������� ������ Citigroup. � Harris, ������� ������� 7,5 ���������� ����� Nikko, �������, ��� �� �������� ��������� ����������� Citigroup � 13,4 ��������� ��������.','Harris Associates LP, ���������� �������� ������� Nikko Cordial, �������� �� �������� � ������, ����� ��������� ������� �������� ������������ ���������� ������ Citigroup. �� ���� �������� Bloomberg. � Harris, ������� ������� 7,5 ���������� ����� Nikko, �������, ��� �� �������� ��������� ����������� Citigroup � 13,4 ��������� ��������. �� ������ �������� �������, �������� ����� ������. ����� ��������, ��� �������� Mizuho Financial Group, ������� ������� 4,8 ���������� ������ ����� Nikko, ������� ����� ����������� Citigroup. ����� Citigroup ���������� �� ��������� ������� 10,8 ��������� ��������. ��������� ���� ��������� ����� ����, ��� ��������� �������� ����� ������ �� ������� ����� �������� � ������ ��-�� �������� ������ ���������� ���������� Nikko, �������������� � ������ � 2006 ����. � ��������� ����� Citigroup ��� ����������� 4,9 �������� ����� Nikko. ���� �������� ������� ����������� ����� � �������� ��������, �� �� ���������� ����� ��� ��������� ������� � ������.',27,1174588082,1174588082);
INSERT INTO `news_news` VALUES (92,392,'� ������ ������� ��� ��������� �������� ��������',2,'������� ��� ���� ������ ���� �� ������������ ������������������ �������� �������, ����������� �� ������ �� ��������� �����. ��� �������� MEMRI �� ������� �� �������� ������ Yeni Safak, \"��������\" ��� ��� ������� ����� ��������� ���������� - ��������� ���� �������� ������ � ������� �������� �������.','������� ��� ���� ������ ���� �� ������������ ������������������ �������� �������, ����������� �� ������ �� ��������� �����. ��� �������� MEMRI �� ������� �� �������� ������ Yeni Safak, \"��������\" ��� ��� ������� - ��������� ���� �������� ������ (Amir Muhammad Shirazi) � ������� �������� ������� (Muhammad Sultani). �� ������ �������, ��� ��������� � ���������� ���������� �������� ����������� � ������������ ��������� �� ���������� ������. \"��������, ��� ���� ������� ������� �� ����� � ������� 16 ����� � ������� � ������ �� ��������� ����. 18 ����� ��� ���� �������� � ���� ��� � \"�������\". ���� �� ����� ��� ������ � �������, ���� ����������\", - ����� ������. ����� ����, ������� ��������, ��� ���� ���������� � ����������� ������������� �������������� �������� �������� �������, �� �������� ����� ��������� � ��������� ������������, \"��� ��� ������ �������� ������������� � ������������ ��������� ��� ��������� ����� �� ����� ������������ � ����������� ����� ��� �������� ��������� � ����� ����� ����\". ������� ��� ���� ������ ������ 7 ������� �� ���� �� ������������� ��������� � ���������. �� ��������� ������, ������ �� ��������� � ����� �� �������� �����, ��� ������� ������������ � �������� ������������. ������� �������� �� ����������� � ���, ��� �� ��� ��� ������� � ����� ������ � ������������ � ����� ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (93,393,'\"������\" ��������� ��������� ����, \"�������\" � \"�����\" �� ����� ����',2,'�������� ����������� ����������� ����� (���) ������ ������� ��������� ������������� ����� \"�����\" ��������� �� ����� ���� ��� ������� ���������� ������ - ����, ���������� \"�������\" � \"�����\". ��� ���������� ���� ������ �������� �������� ������ ������ �������, ������� ���������� ������������ ���.','�������� ����������� ����������� ����� (���) ������ ������� ��������� ������������� ����� \"�����\" ��������� �� ����� ���� ��� ������� ���������� ������ - ����, ���������� \"�������\" � \"�����\". ��� ���������� ���� ������ �������� �������� ������ ������ �������, ������� ���������� ������������ ���, �������� ����������� ���� ���������� ���������� �������-����. 17 ����� \"�����\" ������� ������ �������� ���� ���������� ������ 2006 ����, ������� �� �������� \"������\" ������������� \"������\" (1:0). ���� � ������ ������ ���� ���������� � ������ ������ ���������, ������ �������� �����������, ����� �� ������ ����� � ������ ����� �����. �������������������� ��������� ������ ���� �������� ����� ����������� ���������� ���. ������ ���������� � ��������� ����, ������� \"������\" �� ����� ������� ������� ���������� ��������: �� ������, �������������� �� ����������� ����� �����, ����������� ����� ���������� 10054 ��������. ���� \"�����\" - ���� ������ ���������� ��� 8 ������. �������� ���� �� \"���������\" ������������� �� 25 ���, � � \"�������\" - �� 16 ����. � ������ ���� ����� ���������� ������ \"�����\" ������� ��� ���� � �������� ������� ����� � ��������� �������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (94,394,'\"����� �������\" ����������� ��������� ����� ������',2,'�������� ArenaNet ������������ Guild Wars 2, ����������� ����� ��������������������� ������� ����, ���������� � 2005 ����. ������� ������ ����� ����� ����������� � ���� ������������ ���� ��� ��������� �����, �� ����������� ������ �����. ������������ Guild Wars 2 �������� � 2008 ����.','�������� ArenaNet ������������ Guild Wars 2, ����������� ����� ��������������������� ������� ����, ���������� � 2005 ����, ���������� �� ����� Eurogamer. ������� ������ ����� ����� ����������� � ���� ������������ ���� ��� ��������� ����� (Tyria), �� ����������� ������ �����. ��������� ������ ����� ����. ����������� ���������� ������� ���������� ��������� �� 100 (��������, ���� ������); � ������������ Guild Wars ����� ����� ����������� ������ �� ���������� ������. ������������ Guild Wars 2 �������� � 2008 ����. ����������� ���� ������ ��� Eye of the North, ����������� � ������ ����� ����. ����������, ��� ����� ���������� ������ ����� ���������� ������ ����� ������ ������. �� �����������, �������� ����� �������, ������ � ���������. ��������, ��� ��������� ������ �� ������ ����� ���� �� ������ �� ���������. Eye of the North �������� ����� � ������ ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (95,395,'������ ���� ������ ����� � ��������',2,'������ ���� ������ ���������� ������� \"Bra Boys\", ����������� ����������� ���������� ��� ������ ���������. � ������ ������� ����� �������������� �����, �������������� � ���� �������, �������������� ����� ���������� ��������, ������� ������ ��������� ��������� �����������.','������ ���� ������ ���������� ������� \"Bra Boys\", ����������� ����������� ���������� ��� ������ ���������, �������� Variety. � ������ ������� ����� �������������� �����, �������������� � ���� �������, �������������� ����� ���������� ��������, ������� ������ ��������� ��������� �����������. ������ ���� �������� ������� � ����������� ����� ������. ����������� ������� ������ ������ ������� � ������ �����, ����� ����������� ������� � ��������� ����������� �����. � ��������� ������� � �������� ����, ������� ������ �� ������, ������ ����� \"������������ ��������\", ��� ��� ��������� �� ��������� �������� �������� ������ ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (96,396,'� ������ �������� ���� ����������� �����',2,'� ������ ����������� �������� ���� �������� ����������� ����� \"������������\" ��������� � ������������� ������. ��������� �� ������ ����� ������ ����� ����������� �� �������������� ���������� ������, � ���������� ���� ���������� ���� �����������. ������ �� ���������� ����� � ��� ����� � ����� �� ����.','� ������ ����������� �������� ���� �������� ����������� ����� \"������������\" ��������� � ������������� ������. ��������� �� ������ ����� ������ ����� ����������� �� �������������� ���������� ������, � ���������� ���� ���������� ���� �����������. ������ �� ���������� ����� � ��� ����� � ����� �� ����. ��� �������� ���� ������ \"���-�����\", �������� ������� �������� ����������. �� ���������� ������� �������, ���� �������� ����� ������� �����������, ����������� � ������ ����� �� ����������. ����� ������� �������������� �������� � ����� ������������, � ��������� �� �� �������. ����������� �����������, ��� ����������� �������� ��������, ��������� �� ������ ���������� ����. ����� �������������� ���������� \"�������������\" � ���������� ������ ��������� \"����������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (97,397,'���������� ������������ �������� ������� ���������� ����',2,'������� ������ �������� ��������� ������ ������� ������ �� ���������� � ��������� ���������� ���� �� ������ ����� ������. ��� ����� ������ � ������������� ������������-��������� � ������������ ���������. ������ ����� ���� ���� �������� ������� ��������� �������, ����������� �������� �����.','������� ������ �������� ��������� ������ ������� ������ �� ���������� � ��������� ���������� ���� �� ������ ����� ������. ��� ����� ������ � ������������� ������������-��������� � ������������ ���������. ������ ����� ���� ���� �������� ������� ��������� �������, ����������� �������� �����. �������, ��� ��������� � ��������� ��� ����� ���������� ����, �� � ����������� ���������, �� ������� � ������� ����� ����������. ����� ������� ������� ��� �� ������������� ���������� � �������� �������� ��������, ������� ���� ��� ���� ����� � ��������, ����� ����� ����� ����� ������, � ������ � ������. �������������, ��� ������������ ��������� � ������������ ��������� ����� ������� �� ������� �� ����������� ��������, � ������� ������ �������� �� ����������������� ������� ������. �� ����� � ������� ����� ��������� �������� ���������. ������������� ����� � ������������ ��������� ��������� ������: ����� � 99,500 �����; ������ � 98,500 �����; ������ ������ �������� � 98,000 ������. �� ����� ������� ������ ������ 11 ������� - 7 �������, 3 ���������� � 1 ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (98,398,'��������� ��������� ����� ����� ���',2,'����������� ����������� ��������� � ���������� �������� ���� ������������� ����� �� ������ ������, ������������� �����������. ������������� � �������� ������ ������ ��� �������� ����� �������� �������� � ������ \"� �����\", �������� ������� ��������� �������� ������ ������ ����� ������������ ������ �����������.','����������� ����������� ��������� � ���������� �������� ���� (���) ������������� ����� �� ������ ������, ������������� �����������, ����� \"����������\". ������������� � �������� ������ ������ ��� �������� ����� �������� �������� � ������ \"� �����\", �������� ������� ��������� ��������, ����� ������������ ����� ���������, ������ ������ ����� ������������ ������ �����������, � ���� ��� ����������������� � ��� (��������������� �������� ����). ������� ������������ ����������� � ����� ����������� ���� ������ ������, �������� ������� ���������� � ���������� ���������� � ��������. ������������ �������� �� ���������� ����������, ������� �������� ���������� � ������� \"�������� �������� ������������ �������������, ������� � ������� ���������� �����\" (���������� �� ������� \"������\") � ����������� ���� ������ ������. ��������� �������������� �������� ������ ����������� �� ���������� �� �����������. �������� ���������, ��������� �������� ���������� ��� �������� ����� �������� � ��������� ���, �� ������� ����������� ��������� ��� ���������������� � ���������� ����������. ������������� �������������� ��������� ��������� � ���������� ���������� ��� (������ ��� ����� ���������� ����� �����������) � ������ (���������� ����� �������������). � ������ ��������� ������ ������������� ������� ������ ����� ���������� �� ����� �������� ���. ��� �������� \"����������\", �������� ��������� � ��� ������ ������ �� ������� ���������� �������� - ���������, �����������������, ������������������� � �����������. �� ������ �������, � ���� ������ ���������� ����������� ���� ������ ��������� �������, � ���� � ������������������� � ����������� ������������� ������������� ������ ������ ������� ����������. � ������ ����������� ����������� ��������� ������������� ������� ������, ����������������� ���. � ��������� � ��������� �������, ��� \"������� ���������� � ����������� ����������\" ������� ���������, ���������� ���������� ������ �������� � ������� ����������, � �������� ���������������-���������� ������� ����� �������� ��������������� ������, ���������� �� �������������� ������� ������, � ���������, ���������� ������������ ������������ ������. ����������� ����� ��������, ��� � ������ �� ��������� ������� ���������� �������������� �������� � �� ���������� �������� �������� ��������. \"���������� � ������ ������ ����������� �� ������\", � ������������� ���������� �����-��������� ����������� ������� �������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (99,399,'NASA ������� ���� ������� ����',2,'�������� ��������� ��������� NASA (NIAC), ������� ����������������� ������������ ��� ����� 20 ���, ����� ������ ��-�� �������� �����. �������� �� 16 ���������� �������� ������� NASA ������ �������� ���������� ���������. NASA ���������� ��������� �������� � ������ �� �������� �������� �� ����.','�������� ��������� ��������� NASA (Nasa\'s Institute for Advanced Concepts (NIAC)), ������� ����������������� ������������ ��� ����� 20 ���, ����� ������ ��-�� �������� �����, �����  The Guardian. NIAC ��� ������� � 1988 ���� ��� ������ �� ���������� ���� ����� ��� ���������� �� �� ����� �������� ������ ����������, ����� ��� ���� � ������. �������� �� 16 ���������� �������� ������� NASA ������ �������� ���������� ��������� ��� �������������� ����� ������� ������������ ����������������� ��������, �� ������������� ������� ���� �� �� 10 �� 40 ���. ������ ������� �� �������������� ������� ���������� �� ����������� ����. ����� �������� ��������� ���� ����� ��� ����������� ���� ��� ���������������� ������ ��� �������� ��������� �������, ���������������� ����������� ����� ��� ������ ����� �� ��������� ����� � �������������� ����������� ����������, � ����� ����������� ���������������� ��������, ������� ������ ����� � ����������� ��������. � 2004 ���� NASA �������� �������������� ���� ������ ���, ����� ��������� �������� � ������ �� �������� �������� �� ����, � ����� � �� ����. ������ ������ ������ NASA ���� ������ (Keith Cowing) �������, ��� ���� �������� ��������� �� �������� ������ ��������, ��� ��� ��� ��� ������������� ���������� ������������� �� ������ ������� ��������� ����������� ������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (100,400,'����� ������� �������������� � ����',2,'����� ���� ��������� ����� ����� �������� ������������. ����� ������������ ������ ������ ����������� ����������� � ����� ������ ����������. � ���� �������, ���� ����� ���������� �������� ���� �������� �� ����-���������� \"�������� ��������\" ���������� ������� � ����� ���� ��������� ������.','����� ����������� ����� �������������� � ���������������� (����) ��������� ����� ����� �������� ������������, ����� ������ \"����������\". ����� ������������ ������ ������ ����������� ����������� � ����� ������ ����������. ������ � ��� �������� � ��������� ����� ����� �������� �������� ��������� �� ��� �� ����. � ���� �������, ���� ����� ���������� �������� ���� �������� �� ����-���������� \"�������� ��������\" ���������� ������� � ����� ���� ��������� ������. ����� ����� �������� ����� �������� ���������� �������. ����� ����, ������ �����������, ������� ������������ ����������� ������� �� ���� � ������� �� �������������� ��������������, ������ ����������� ��������� ���������� �������� �� \"�������������\". ��� ����� �������, ���� ��������� ���������� ������ � ������� �� �������� ���������������, ���, �� ������ ������ ����� �������� � ����������� ������ � ������ ������������� ����. ����, � ��������� �������� �������� �����.',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (101,401,'��������� ������� ������������� �� ������ � ��������� \"�����������\"',2,'� �����-���������� ��������� ������� ������������� � ���������� ������ � \"������������\". �������������, ����� ������� ���� � ������������������, ������� ���� � ������������� ����������� ������ \"�������� ����� ������� ����� ������� ����������\". ��� ������ � \"�����������\" 18 ������� ���������� ����� �������.','� �����-���������� ��������� ������� ������������� � ���������� ������ � \"�����������\", �������� ��������-���� \"��������.��\". ���������� ��������� � 15 �� 20 �����, ������ �������� � ��� ����� ������ ������. �������������, ����� ������� ���� � ������������������, ������� ���� � ������������� ����������� ������ \"�������� ����� ������� ����� ������� ����������\" (������ ����� ����������� Mad �rowd). ��� ������ �� ��������� �����������, ����������� ������� ��������� � ���������� ������ ������, ���������� ��� ������� ���� ����������� �������� ����������, ���������� � ���������� ��������������� �����. �������� �� ��, ��� � ����������� ������ �������� ������ ���� �������� ������ - �� �����, ��� �����������, �� ��������������� ������, ����������. �� ��������������� ������������, ����������� ��� ������ 205 �� �� (���������). �� ���������� ��������-�����, ����� �� ����������� ������� ����� ������ ���������������, ������������� � \"�����������\". �� ������ �����, ��� ������� ����������� ������� � �������� �� ������� �� ������ � ����������� �������� ����������. ��� ������ � ��������� ���� \"����������\" �� ����������� ����� ����������� � �������� ��������� 18 ������� ���������� ����� �������. ����������� ��������, ����������� ��������� �� ��, ��� �� ����� ���� ����������� ��� ����� ��� �������� ������ � ������������ � ������. � ������������������ ������� �������, ��� ����������� ����� ���� ����� ��������� � � ������ �������������, � ��� ����� � ������ �� ������� ����� \"������������\" �� ��� ������ �� ��������� � �����������. ����� ���������� ���� �������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (102,402,'���������� ����� ������������ ������ �������� � ������� �����������',2,'������� ������ ������� ������� ������ �� �������� �������� ������ ������� ���������� ����� ������������ ������ ���������� �������� � ���, ��� �� �������� �������, ������� ��������� �� ��������� �� ���������� ������. ���������� ������ �������� � ������� 22 ����� � ������������, ���� ����������� ����� ��� ��������.','������� ������ ������� ������� ������ �� �������� �������� ������ ������� ���������� ����� ������������ ������ (���) ���������� �������� � ���, ��� �� �������� �������, ������� ��������� �� ��������� �� ���������� ������. ���������� ������ �������� � ������� 22 ����� � ������������, ���� ����������� ����� ��� ��������. \"��������� ������ - ������� ������������ ������������, � ������� ������ ����������� ��� ���������� ���������� ������, - ������ �������� ������ � �������� ��������� ���������� ���������� \"���� �����\". - ��, ��-������, ��������� ������ ������ ��������� � ���������� �����, � �� � ����� ������, ����� ������ ��������� � �������������� �������� ����� ����������� ������\". \"����� ����� ������� � ����������� ��� ������� ���������� �� ������������ �������, - ������� ������� ������ ������� �������. - �� ������ ����� ���� � �����-��������� ������� ����� ������: ��� �� �������� �� ���������� ������, �� ����� ������� � ������� �� ��������� �����. �� ������� ������� ���������\". \"� �������: ��������� ������, � ���� �� ������� ��� �������? �� �������: ������ ��������, ��� ���� �����������, �������� � ������. � �������: � �� �� �������, ��� ������������ ������ ����������� �� ���������� ��������, ������, ��������, ��������, ������� ������ � ����������� - � �� ��� ����� �� ������� �� �����? �� �������: �� ����� ������ � ������, ���� �����!\". ��������, ��� � ����� ������ 2007 ���� ��������� ������� ��� ���������� �� ���� ���������� ���, �� �������-�������� ����������� �������������� ����������. ��� �������� ���������� ����������� ������� ������� ������, �� �� ������ ������-2006/07 ��� ������� � 1996 ���� �������� ����� �����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (103,403,'�� ����� ���������� ����� �������� ������������ �����',2,'� 2010 ���� �� ����� ������������� � 2006-� ���������� ����� �������� ����� ������, � ������� ����������� ����� ������ ����������� ��������� ���������� ����� ���������, �������, ������� ������� � ������������ �����. ���������� ����� ������������� �� ���������, �������������� � ���������.','� 2010 ���� �� ����� ������������� � 2006-� ���������� ����� �������� ����� ������, � ������� ����������� ����� ������ ����������� ��������� ���������� ����� ���������, �������, ������� ������� � ������������ �����. �� ���� �������� \"���������� ������\". ���������� �������������� ������� ����������������� � ��������������� �� ���������, �������������� � ���������. �������������� ������ �������������� ������ ����� ������ ������. ���������� ������� ������ ��� ��������. ����� ������ ���������� �����, ������������ � 1977 ����, ������� 23 ������� 2006 ����. ��� �������� ������� 66 �������, ��� 33 �������� �������. ������� ������ ���� ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (104,404,'������� ������ \"����������\" ��������������� �������',2,'������� ������ ������� �������� � ������������� ���������� ���������, ����������� ����� ���������� \"�����������\" �������� \"�����������������\". ������� \"�����������������\" ������ ���������� �������� �� ������ �������������� �����������, ����� ����� �������� ����� ������� � �������� � �������� ������� \"����������\".','������� ������ ������� �������� � ������������� ���������� ���������, ����������� ����� ���������� \"�����������\" �������� \"�����������������\", �������� ������ \"���������\". � ������� ������������ � ������������� ���������� ������� ��������� �����: ������� \"�����������������\" ������ ���������� �������� �� ������ �������������� �����������. ����� ����� \"������������������\" ����� ������� � �������� � �������� ������� \"����������\", ��� ���� ��������� ���� ����� �������� �������������� ������� �����. ������������ ��������, ������ �����, ��������� ��������� \"����������\" ����� ��������. ������, �� ������� �� ���� ��������������, ��� \"�����������������\" ����� ����� 35-37 ���������� ������. ����� 2006 ���� ����� ������������� ������ ��������� �������� ����� � ��������� ����������� ���� �����������. ����� ������� ������, ��� � ������ �� �������� ���� ���� ������� �������, ������� ������ ���������� ������. \"����������\" ���������� ��� ������������� ������������ ������, \"�����������������\" ���������������� �� ��������������� �������������� (�������, �������� � ���������� �������) �� ������� ���������������������. ����������� ����������� 100 ��������� ����� \"������������������\" � 75 ��������� ����� \"����������\".',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (105,405,'���������� ������ ������� ������ �� ����� ����� ����',2,'21-������ ���������� ������ ������ ����������-������� ������� ������ �� ����� ����� ���� � ����������. ��������� ������� ������������ ����� (���� ��������), �������� �� ������ ���� �������������� ������ - ����� �������� � ����� ��������. ����������� ��������� � ������ �������� ����� ������ (��������).','21-������ ���������� ������ ������ ����������-������� ������� ������ �� ����� ����� ���� � ����������. ��������� ������� ������������ ����� (���� ��������), �������� �� ������ ���� �������������� ������ - ����� �������� � ����� ��������. ����������� ��������� � ������ �������� ����� ������ (��������). ��� �������� ��������-������� fasterskier.com, ������ � ���������� ����� ��� �����������-�������� ������ �� ������ ����� ����. ��� ���� ������ ����������-������� � ������� ������� ���� �������� �� ����������� ����� 1988 ���� � �������. \"�� ���� ��������, ��� � ������� �����, ��� ������ ����������, - ��������� ������ �������� ����������-�������, - ������ ���� �������, �� � ��� ��������������� � ��� ������ �� ������ ������ � �������\". �������, ��� ������ ���������� � ��������� ������� ��������� ���������, �������� ������� ����� ��������. ��� �������� �������� �������, �� ����� �� ������ �������� ����� ��������� ����� �������� (���������) � ���� �������� (������).',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (106,406,'��������� � ���� ��-8 ������ ����������� �������� ����� �������',2,'������� �������� ��������� ���������� ���� ���� ������ �������, ��� ��������� � ����� ��-8 ������ ����������� ������ ����� �������. ������������ ��������, ����������� �������� �� �������� ��������� ������, ������ �� ���������. � ������� ������ ��-8 ������������.','��������� � ����� � ���������� ���� �������� ��-8 ������ ����������� ������ ����� �������, ������� ��� ������� ������� �������� ��������� ���������� ���� ������. �������� �������� \"�����������\" ������ �������� ����. �������� �� ���� � ����� �������������� �������� � ����������� ������ ������ �������, � 14:40 �� ����������� ������� ��-8 ������� �������. �� ��� ����� ���������� ���� ������ ������� � ���� ��������. � 15 ����� ��-8 ������ ��� ����� �� �����, ������ ����� �� ���������. ������������ ��������, ����������� �������� �� �������� ��������� ������, ������ �� ���������. � ������� ������ ��-8 ������������ - � ������������ �������� ��������� ������ ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (107,407,'��������� ���� ��������� ��������� \"�����\"',2,'������������ ������������ �������� �������� ����, ����������� � ��������� 80-� ��������� �������� ������ \"�����\". ��� ���������� � ����������� �����-������, ���� ��������� ��������� 24 ������� � ������� ����� � ������������� Kodak � ���������. ���������� ����� ������������ �������� ABC.','������������ ������������ �������� �������� ����, ����������� � ��������� 80-� ��������� �������� ������ \"�����\". ��� ���������� � ����������� �����-������, ���� ��������� ��������� 24 ������� � ������� ����� � ������������� Kodak � ���������. ���������� ����� ������������ �������� ABC. 26 ������� 2007 ���� ������ �������� ����� ��������� ��������� ��� �����������, 22 ������ 2008 ���� ��������� ������������� ���������� �� \"�����\", 30 ������ ���������� ����� ���������� ������� ����������� �� ������ ����������. ��������, ��� �������������� 79-� ��������� �������� ������ \"�����\" �������� � ��� 38,9 ��������� ��������. ��� ���������� Entertainment Television, ���, �������� �������� ���� ����������� ����� �� ��������, �� ������� �������� ������ ��������, ��� � ������� ����, � ��������� � �������� ������������ ��������� �����������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (108,408,'�������� ������������ ���� ���-29 ������� ������ �������������',2,'�������� ������������ � ������� ���� ��������� ���-29, ������������� 21 ����� � ���������� �������, ����� ����� ������ �������. ���� �� �������� �� ���������, ������ ������� �������������� ����������� ����. �������� ���������, �������� ���� � �������� ��������� ���������� � ��������� ��� ���������� ����������.','�������� ������������ � ������� ���� ��������� ���-29, ������������� 21 ����� � ���������� �������, ����� �������� ������ �������, �������� � ������� ��� ������� �� ������� �� ��������� �������� ��� �� ���������� �������������. ������������ ��������� � 16:02 �� ����������� ������� � 40 ���������� �� ������������� ��������� � ���� ���������� �������� �������. ������ ������������������, ���� �� ��� �� ���������, ������ ������� �������������� ����������� ����. ��������� ������ ��������� ��� ����� � ��������� ���������, ����� � ���������� �� ����. �� ����� �������� �������� �������� ������ ������������ ������� ���������� �� � ���, ������� ����������� ������ ��������. �������� ���������, ����������� � ������������������ ���������, � ����� �������� ���� � �������� ��������� ���������� � ��������� ��� ���������� ����������. ���� �� � ������� � 9.30 �������� � ������������� ��������� ���������� ����������������� ������-���������� ������ �� �������� ��������. �� ����� ������������ ��������� ������� ����������� ������-����������� �������� ������ ��������� ��������� ���� �� ������ 351 �� �� (\"��������� ������ ������� ��� ���������� � ���\"). ���-29 �������� ������ ��������� ������������, �� ������ ��� \"���\" � ������ 80-� ����� � ��������� �� ���������� � 27 �������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (109,409,'���������� ������� ����� ������ �� ����������',2,'��������� �������� ���������� �������������� �������� �������������� ���������� �� �������-��������� �������� ���������� ����� ������ �� ����������. ����� � ��������������� ������ ������� �������� \"������� ����\", � ��� ������������ ��� ����� �� �������� ������������ � ������� �������� ������� ������ ������� �����.','��������� �������� ���������� �������������� �������� �������������� (�����) ���������� �� �������-��������� �������� ���������� ����� ������ �� ��������, ����� 22 ����� \"����������� ������\". ����� � ��������������� ������ ������� �������� \"������� ����\", � ��� ������������ ��� ����� �� �������� ������������ � ������� �������� ������� ������ ������� �����. � ���������, ���������� ����������� �������� ��� ������� ������������� ����. �� ����� �� ������, ��������� ����� ����������� �� �������. ������ �������� �������� �������������� ����������� �� ���� �����, �������-��������� ������ ������. �� ��� ������, �������� ����� ���� ������� � ��������� ���������������� ����������. � ������ 2000 ���� ������ ��������� �������� �������� ������� ��� ����� �������������� �����, ������� ������� ���� ������ ��������� � ������� ���������� ������, ������ � 2001 ���� ��������� ������� ���� ������, ������� ������ ��� ���� � �������� �������� � ��������. �� ������ ���������� �������, �������� ������������ ����� ���� ������ � ��������� ���������� ������������ ����� �� �� ���� �����������. ��� ���������� ������, ���������� ����� ����������� ���������� ������������ ������� �� �� �������� �� ����������� ���������, ��������� ��� ������������ ����� �� ���������� ������� ���������, � ������-����������� ������������ �� ����������� ������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (110,410,'��� ��������� �������������� ������ ��� �������� ������� ���',2,'��� ��������� ������������������ �������������� ������ ��� �������� ������������� ��������� ������ ������� ��� � ����� ������. ������ Minuteman 2 ���������� � ����� ����� �� ����������� �������, �� ���������� ����������� ������� 85-��������� ������, ��������������� ��� ����������� �������� � ������ ����������.','������������ ������� ��������� ������������������ �������������� ������ ��� ���������� ��� �������� ������������� ������ �������� ����������� ������� ��� � ����� ������, �������� Associated Press. ������ Minuteman 2 ���������� � 21.27 �������� �� �������� ������� (� ����� ����� �� �����������), �� ���������� ����������� ������� 85-��������� ������, ��������������� ��� ����������� �������� � ������ ����������. � ���� ���������� ������� ����� ������-������������ �� ������������. �� ������������ � ������ ��������� ��������� - ������ � ������ ����� ����. ����� �������� ����������� SBX ��� �������� ��������� Raytheon ��� Boeing (��������� ���������� ���������� ���) � �������� � 815 ��������� ��������. �� �������� �� ���������� ������������� ��������� CS-50 (Moss Sirius), ����������� � �������, ������� ����� ������������ � ����� ����� �� �������������. ����� ���������� ���������� �� ���� ��� ��� �� �������, ������ � ����� 2006 ���� ��� ���������� ����� � ���������� ��������. �������� ���������� ���, ��� ���� ������� ��� ������������ � �������� �� ���������� ������� ����� � ����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (111,411,'������������ ������ ����������� ������������� � ������� �������������',2,'����������� ������ ��������� ��������� ���� � ��������� ������������ ������ ������������ ����� ��������������� ������� �� ��������� ��������. �� ������������� � ������������� � ����� ������� �������. �� ������ ���������, � 2005 ���� ������� ������� ��������� ����� �� Eurobank ���������� 17 ��������� ���� � ������������� ����������� �� �����.','����������� ������ ��������� ��������� ���� � ��������� ������������ ������ ������������ ����� ��������������� ������� �� (����������) ��������� ��������, ����� � ������� ������ \"������\". ������� ������������� � ��������� �� ������������� � ����� ������� �������. �� ������ ���������, �� ������� ���������� ����� �� Eurobank, 30 �������� 2005 ���� �� �������� ���� ������������ � �������� ���� ������� ���������� 17 ��������� ���� � ������������� ����������� �� ���������� ����� Centrecoop Ltd. ����� ���, ���������� �������, ����������� ���� ������ �������� �������� ��������� ������ ����� ����� ������ ������ � ������������ �� ����� Eurobank. ���� �������� �� ��� � 1925 ���� � ������� ������ ������ �� ������� � ��� �������������� �����������, � ��� ����� ��������� ���� �������� ��������������� ����������. ����� ������� ���� � 1992 ���� �� ������� ���������� ������ ����� ����� ���������� ����������� ���� �������� � ������������� ����������� ��� ������������� ��������������. ��� ���������� ���� ���������� Eurobank � ������� ���� ����� 9 ��������� �����. ������ �� ������� ���� 100-���������� ���������� ���������� ���������� ������, � ��������� ���������� �������� ������������. �� ������ ����� ������, �������� ����������� �� ����� ����� �� �����, ��� ��� ������� ������� � �������� ������������ �� �������. \"������\" ���������, ��� � ������� 2007 ���� � ������ ������ ������ ������� ����������� ������������ ����������� ������� ��������, ������������ ������������ �� ���� �����. ������� ���������� �������� ������������ ����������� � ��������� ��������������� �� ������� ������� ����� Eurobank \"������� �����\". ��� ���������� �����, ����� ����������� �� ����� Eurobank ���� ������������ � 1995 ���� �������� ����� ������. ������� ����� ����� ����������� � 40-50 ��������� ����.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (112,412,'�� ���������� ������� �������� ���������� ��������� ��� ������� �������',2,'�������� ������ ���� ������� ��� �������������� �� ��������� ����� HMS Tireless ���� ����� ��������� ��� ������� ������� � ������� ����� �����. ��� �������� � ���������� ������������ �������, �������� ��������� ����� 4:30 �� ������������ �������, ����� ����� ����������� � ������� � �������� ��������� ������.','�������� ������ ���� ������� ��� �������������� �� ��������� ����� HMS Tireless ���� ����� ��������� ��� ������� ������� � ������� ����� �����, �������� � ������� ��������� France Presse. ��� �������� � ���������� ������������ �������, �������� ��������� � ����� ����� 4:30 �� ������������ �������, ����� �������� ����������� � ������� � �������� ��������� ������. \"��������� �� ������������ ���������, �� ������� ������� �� ���������, ��� ������ ������� ����� � ����������\", - �������������� � �����-������ ������������. \"������� ����� ������� ������� � ���������������� ���� � ����������� ��������, � ���������� ���� ���������� ���� ������� ������� �������� ������\", - ����������� � ��������� �������. � ���������� ���������, ��� ����� ��������� ��������� ������������ ��� ������� ������� �� �������������, ������ �� ���������� ������������� ��� ������������� �� ���� ��������� ��� �������������� ����������. HMS Tireless ���� ������� �� ���� � 1984 ����, ������ ��������� ��� ������� ������� ��������� �� ��������� � 2001 ���� ����� �������. ��� ���������� AFP, � ��� 2000 ���� �������� ������ �� ������ � ���������� ����� ����, ��� � ������� ���������� �������� �������� ������������ ����. ������ ���������� ������� ��������, ��� ��� ������ �� ����� �������� ��������� � ���������� ������������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (113,413,'��������� ��������������� ������� ����� � \"�������\" ������ ���� �����',2,'� ����� ��������� ��������������� ������� ������� ����������� ������ �� ������� ���������� ����������� ���� \"�������\" � ����� � ������������ � ��� ����������� ���������� ����� �����. ��� ���������, � ����, ���������� �� ���������� 38 � 41, ��������� ���������� ������������ ����� �������� ��������� � ����� ���.','� ����� ��������� ��������������� ������� ������� ����������� ������ �� ������� ���������� ����������� ���� \"�������\" � ����� � ������������ � ��� ����������� ���������� ����� �����, �������� ��������-������� DELFI. ��� ���������, � ����, ���������� �� ���������� 38 � 41, ��������� ���������� ������������ ����� ����� ��������� � ����� ���. ������� ������������ ����� ����������� ���� �������� �� ��������, ������ ��� ���������� ����������� ���������� ���� ��������-���������� �����������. ���������� � �������������� \"�������\" �� ���������� 38 � 41 ���������� ������ ��������� �� ������, ��� ����������� ��������������� ��������. ����� ����, ��������� ������ �����������, ��� ���� �� ������ ���������� �� �������� � ������ ����������� ����������� ��� ����������� ��������, � ��� �������� ������������. ��������, ������� ���������� ����������� ���� �� ���������� ����� ���� ��������� � ��� 2006 ���� �� ���������� ����������������. ��� ���������� ����������, ���������� ������ ������ ����� �� ���� ��� ��-�� �������� ���������� ������������� ���������.',22,1174588082,1174588082);
INSERT INTO `news_news` VALUES (114,414,'������������ �������� � ���� ����������� ����������� �� �������',2,'������ �������������� ���� ������� ������� �� ����������� ����������� ������������� �������� � ���������� ������ � ���� ����������� � ������� �������������. ��� \"������� ����� �������� �� ��������� �����������\", ������� �� ������ ����������� �� �������. ���������� ������� ���� ��� ���� �������� ��������� - �� ������� 250 ����� ������.','������ �������������� ���� ������� ������� �� ����������� ����������� ������������� �������� �� ������� � ���������� ������ � ���� ����������� � ������� �������������, �������� ��� �������. ��� �������� � �����-������ ������������� �������, ���� \"������� ����� �������� �� ��������� �����������\", ������� �� ������ ����������� �� �������, �������� �� �������� ��������. ���������� ������� ���� ��� ����������������� ���� �������� ��������� ����� ���������� - �� ������� 250 ����� ������. ����� ����, ����� ��������� � ������������ �� ��������� ����� �������� � \"����� ������������ � ����������\", ��������� � �������������. ������, ������� ����� �� �������� ������������ ��������, ����������� ��������� �� ����������� ������������ ������� �����, ��������� � ����� � ���������� �������. ������ �������������� ���� �������� �������� �������������� �������������� �� ����������� ��������������� ������������ ���������� ��������. ��������, ����� � ���� ����������� � ������� ������������� ������� ����� ���� ���� 20 �����. � ���������� ������������ ������� 62 ��������, ��� ���� ������������ ����� ���������� � ��������. �� ���� ������� ������ 35 �������, �� ��� 30 ���� �����������������. � ������� ��� �������������� ��� ������ ������������ - ������������ ��������� � �����, �������� ��������� �������� � ������. ��� �������� ���������� ������ ��������� ������ ��������� ����� ������� ������ ���� ������� �������� ���� � ��������, ������ �������� � ������� \"���������� �����������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (115,415,'�������� ����������� ���������� ����������� \"�������� � ������\"',2,'������������ ����������� \"�������� � ������\" �������� � ������ ����������� ���������� �����������. �������������� ���������� �����, �����, �����, Mail.Ru, Ozon.ru, Rambler, ���, HeadHunter � ������, ������� � 18 �� 20 ������ 2007 ���� � ������������ ���������� \"���\".','������������ ����������� \"�������� � ������\" �������� � ������ ����������� ���������� �����������. ������������� �����������, ����������� �������� ������ � �������������� ���������� �����, �����, �����, Mail.Ru, Ozon.ru, Rambler, ���, HeadHunter � ������, ������� � 18 �� 20 ������ 2007 ���� � ������������ ���������� \"���\". ��� ������� � ����-2007 ���������� ��������� ������, ����������� �� ����� �����������. ����� �� ����� ������������ ��������� ��������� ����������� - � ��� ����� ������������ �� ����� ������.',30,1174588082,1174588082);
INSERT INTO `news_news` VALUES (116,416,'\"����-�����\" ������� \"����������\" � ������� ������',2,'������� \"����-�����\" � ����� �������, ��� ������������� ��������� �� ���������� ������� 60 ��������� � ����� ����� �� \"������������� ������\" ������ ��� ���������. ��� ���������, ������, ����������� ������� ��������� ������� \"�������-�����\", ����� ��������� ��������� � ������� ������.','������� \"����-�����\" � ����� �������, ��� ������������� ��������� �� ���������� ������� 60 ��������� � ����� ����� �� \"������������� ������\" ������ �������� ��� ���������, �������� ��������� \"���������\". ��� ���������, ������, ����������� ������� ��������� ������� \"�������-�����\", ����� ��������� ��������� � ������� ������. �� ������ �������� ��������� \"������������� ������\" ��������� ����������, � �������� ��������� � ������������� \"� ����� ���������\" � \"������ ������� �� ����\". ������� �� ������ � ����������� �������� ��������� ������� ����� ����� ������������, ��������� �������, ��� �� ������� ���������� ������������� �� ���� ����. � ������ 2006 ����, ���������� \"���������\", ������ �������� ��� ��������� �� \"���-�������\", ������� ������� ����������� ��������, ��������-��������, ��������� ���������� \"����������\" � ������ ������ \"�������-��\". \"����-�����\" � �������� �������� ���, ������ \"������������� ������\", ������� �� \"�����\", � � �������� ��������-������� - �������� Rambler Media. ������� ����� ��������� ����������� FM-�������������� � ������ � �����-����������, ������������ ��������� \"��-3\" � ����������� \"2�2\", ������� ������ � ���� � ������ 2007 ����. ����� ����, \"����-�����\" ����������� ������������ ���� ������������� ��� ������ \"������ ����\" � ����������� ����� ����� �������� \"������� ����������\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (117,417,'�� ������������� ����� � ������ ����������� �������',2,'������� � ����� �������� ���� 13 �� ������������� ����� �� ��� ������ ��� ��������� �������. ������������ ���� ��������� ����� ����������� ������� �������� � 21:00. ��� ���������� ��������, ���� ����������� �� ���������� ��������� ��� ���������� � ������ � ��������.','������� � ����� �������� ���� 13 �� ������������� ����� �� ��� ������ ��� ��������� �������, �������� ��� �������. �� ������ ������������� ������������������ ������� �������, ������������ ���� ��������� ����� ����������� ������� �������� � 21:00. ��� ���������� ��������, ���� ����������� �� ���������� ��������� ��� ���������� � ������ � ��������. ����� ���, �� ������ ��������� \"���������\", ������� �� ����, � ������ �����. ��� ������������� ������������������ ��������, ������� ������ ��������� ���� �����������, ��-�� ���� ���� �� ��� ������ �������� � ��������� � ��������� ��������. �������������, ������� ��������� � ������ ������� ���������, ����� ��������� ������ �� �����, ��������� \"���������\". ������� ��������������� �������� �� ��� ��������� ������� ������, �� ����� ������������ �������� ������������ ������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (118,418,'�� ���-������ ������ ���-2199 �� �������� ���� ������� � ��������',2,'������� � ����� ����� 20:30 � ������ ���� 154 �� ����������� ����� �������� ���������� ���-2199 ������� �������� �� �������� ������� � ��������� � �������� �� ��������� ���������. ���������� ��������� �������� � ����� ������������, � ��������� ��� ������� ���� � ������ ����� ��������� �����. �������� �����.','������� � ����� � ���������� �������-������������� ������������ � ������ ����� \"������ ����\" �� ���-������ ������ ����� ��������, �������� ��������� \"���������\". ��� ���������� � ���� �������, ��� ��������� �������� �� ���� 154 �� ����������� �����. ����� 20:30 �������� ���������� ���-2199 ������� �������� �� �������� ������� � ���������. ������������ �� ����������� � ��������� �������� � ����� ������������. �� �������� ������� �� ����������� ��������� ��������� � ��� �������� ���� � ������ ����� ��������� �����. � ��������� �������� �� ����������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (119,419,'�� ���������� ������� �������� ������� ��� ������',2,'� ���������� ������������ �� ����� ������� ��������� ����� ��� �������������� ������� ��� ������ � ��� ���� ���������. � ������������ ������� �� ��������, ��� ������� � ������ ��������������. ����� ��������� ���������� ������, �������� � �������� � 140 ������� ����������� � ������� � �������� ��������� ������.','� ���������� ������������ �� ����� ������� ��������� ����� ��� �������������� HMS Tireless ������� ��� ������ � ��� ���� ���������, ���������� �� ����� BBC News. � ������������ ������� �� ��������, ��� ������ ������� � ������ ��������������, ������, �� ��������������� ������, ��� \"������� � ������� ������� ����������������� ������� �� ���� ��������\", �������� ��������� France Presse. ����� ��������� ���������� ������, �������� � �������� � 140 ������� ����������� � ������� � �������� ��������� ������. ������ ����� ���������� ����� �� ������������. ������������ �� ���� ������� �� � ������� ��������� ��������, �� � ������������ �� ��� �������, ����������� � ���������� ����������. �������� ��������� �� �������, �� �� ������� �� ����������� ����� �������������. ������ ��� ������� �� �����������, �������� BBC News. ����� �������� ������� �� ����������, �� ������������ ��������� � ������������. ��� ���������� ��������� Sky News, 23-������ HMS Tireless (\"����������\") ����� � ����� � 2006 ���� ����� ���������� �������, �� ������� ������ � 2000 ����. ����� �� ������ ���������� �������� �������� ���� �������� �������. ��������� ������� �������� ���������� � ���� � ����������, ��� ������� ��������� ������������ ��������� �������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (120,420,'� ������ �����-���������� ��������� ��������� ������� �� �������',2,'� ������ �����-���������� ��������� ��������� ������� �� ����������� ������ ��������. � ���������� ���������� �� 150 �� 250 ���������� ������ ������ ������, ��� � ���� ������ ���������� 30 �������. �������, ����� �� ��� �� ���������, ���������� � ��������������� �� ����� ��������� ����� ������.','� ������ �����-���������� � ������ ������� ���������� �������� ��������� ��������� ������� �� ����������� ������ ��������, �������� ��������-������� \"��������.��\", �������� �� �������������� ���������� ���������� ��� ������. �� �� ������, � ���������� ��������� ���������� �� 150 �� 250 ���������� ������ ������ ������, ��� � ���� ������ ���������� 30 �������. �������, ����� �� ��� �� ���������, ��������� ����, ��� ��������� ��������� � ��������������� �� ��� ����� ������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (121,421,'����� � �������� ������ �������� ������� �����������',2,'���� � ����������� ������ ������������� ���������� ����������, ��������������� ���, �������� � ������� ������� �����������. \"������� ����������� ���� ���������, ��� ���� �������� � ��� �� ����������������� �� ����������� ���-���������� ������ ������\", - ������ ������� ������ �� ����������.','���� � ����������� ������ ������������� ���������� ����������, ��������������� ���, �������� � ������� ������� �����������, �������� ��� ������� �� ������� �� �������� ������ �� ���������� - ������� �������. \"������� ����������� ���� ���������, ��� ���� �������� � ������� ������� ����������� �� ����������������� �� ����������� ���-���������� ������ ������\", - ������ ��. �� ������ �������, ������ �����, ������������� ��� ����������� � ���, ��� ���� � ��������� �������������� ������ ��������������� ������� ������������. \"������, ������ ������� ������� ����������� ����� ������ - ����� ������ ������� ����������� ����� ������������� ������ ����\", - ������� �������. ��������, ��� �������� ��������� ����������� �����������, \"����������� ���-���������� ����������������� ������ ������ �� ������� ���� ���������� ��������� 37-������� ������������� ������� ����������, 27-������� ��������� ���������, 33-������� ����� �����, 42-������� ������� ������, 39-������� ���� �������, 33-������� ������ ������ � 38-������� ����� ������� �� ����� 3 ������ 127.1 (�������� ������) � ����� 2 ������ 210 (������� � ���������� ����������) �� ��\". �� ������ ���������, ��������� ���� ������������ � ���������� ������ � ����� ������� ����� � ���������� ������ ��� �������� ����� ��������� ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (122,422,'���������� ���������� �� ������������� � ���������� ��������',2,'�������������� ������ ����������, ��������������� �� ������ ��������, �������� ������ � �������������� ��������. �������� ����� �������� ����� ���������������� �������������� �� ���������� ��������� ���������� ��� ������� �������� ���������� �� ���������� ������ ���.','�������������� ������ ����������, ��������������� �� ������ ��������, �������� ������ � �������������� ��������, �������� Deutsche Welle. \"����� �������������� ����� ����������� ���� � ��������, ������� � �������� ������� ������������ � ������� ������������\", - ������� � ����� ������� ���������� �������������� �� ����� �������������� ��������� ����� (Rheinhold Robbe). ��� ������, ����������� ��� � 30-� ����, ��������� � ��������� ��������� �� ������� �������� ������ � ����� �� ����������������� ������������. �������� �������� �������� ����� ���������������� �������������� � ��������� 15 ��� ������������������ ������, ������� �����. ����� � ������� ��������������� ���������� �� �������������� �������� ���������� ��������� ��������������� ����������� � �����, ��� ������������ ����������� ������� ���� ������� �������� ������� �����.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (123,423,'����������� ����������� PS3 ��������������� ���������� �������������� �����������',2,'Sony ��������� ����������� ����, ����������� ������������� ����������� ������ ��������� PlayStation 3 � ������ ��� ���������� �������� ��������. ������������ ��������, ��� ���� ���� ������������� � ��������, �� ������� ������������� �������� (1.6 �� ����������� ����) ������ ���������� ������������ �����������.','Sony ��������� ����������� ����, ����������� ������������� ����������� ������ ��������� PlayStation 3 � ������ ��� ���������� �������� ��������, PlayStation � PlayStation 2, ���������� �� ����� 1up. ������������ ��������, ��� ���� ���� ������������� � ��������, �� ������� ������������� �������� (1.6 �� ����������� ����) ������ ���������� ������������ �����������. �� ����� �������� �������� ������ ���, �������� ������ �� ������� ����� ���� �� ���� �������: \"�������� �� ����������\", \"������������� � ������� PlayStation 3 � ��������������� ����������\" � \"������������� � ������� PlayStation 3 � ��������� ����������\". ��� ���� Sony �� ��������, ����� ������ �������� ��������������� ��� \"���������������\" ��� \"���������\". ����, ������� ������ �� ����� ���������������, � ������� � ����� �� ��������. ����������, ��� �� ����������� PS3 �� ����� �����������, ��������, ������ ����� Silent Hill, Metal Gear Solid 2, Bully � Gran Turismo 4. � ������ �������� ������ Devil May Cry 2, Okami � ������� Final Fantasy. ��� ����������� ������ ��� � ���������� �������� ����������� ����������� PS3 ����������� \"�� ���������� � ������� PS3 ���������� USB, ������� �� ��������� ��� ����\", \"�������� ������������� ������ 60Hz � ������� ������� ����\" � \"���������� �������������� �����������\". ��������, ��� ������ � ������������� PS3 � ������ ��� ���������� ��������� �������� ������ ����� ����, ��� ����������, ��� � ����������� ������ �� ����� ������� ��� ���������� Emotion Engine, ����������� ���������� PS2. ��� ���� ����� ����������� ������������� ��������� ����������� ��������. ����� ������� Sony �������� � ������� � ������ 23 ����� 2007 ����. ���� ����������� PS3 ����� ����� �������. ��������� ���������, ���������� 60-����������� ������� ������, �������� 599 ����. ��� ���������, � ��� PS3 ������� � �� �� �����, �� � ������������ ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (124,424,'� ������� ������������ �������� ����������',2,'������������ ����������� ���������� ���������� ��������� ������� � �����, 21 �����, �������� �� ��������� �������� ����������, ������� �� ������ ����� ����������� ������������ ����� ������. ���������� ������� ������ � ���������� � �������������� �� ������� � ��������� ������������� ������������� �� ��������.','������������ ����������� ���������� ���������� ��������� (Histadrut) ������� � �����, 21 �����, �������� �� ��������� �������� ����������, ������� �� ������ ����� ����������� ������������ ����� ������, �������� �������� AFP. ����������, ��� ���������� ������� ������ � ���������� � �������������� �� ������� � ��������� ������������� ������������� �� �������� ������������� ��������, ������� ��������� ������� �������� ���������� ����������. \"���������� ��������, ��� ������� ����� �������� � ���������� ������������\", - ������ ����� ���������� ��������� ���� ���� (Ofer Eini). � ����������, ���������� � 9:00 �� �������� �������, ������� ������� ����� 400 ����� ������� � ��������. ������ �������������� ��������� ���-������� (Ben-Gurion), ������� ������, � ������ ����������� � ��������������� ���������� �� ��� ������ ���� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (125,425,'��������� ���������� �������� ���� �� ����� � ���� ����������� �� �������� ������',2,'���������� �������������� ���� ��������� ������ ������� ���� � �������� ����� ������� ������, ��� 20 ����� ��� ������ � ���� ����������� ������� 62 ��������. \"������, ��� ��� ���������� ���� � ����� �����. �� �� ���������� �� ������ �������������\", - ������ ���������� �� ��������� ������������ �������� ����.','���������� �������������� ���� ��������� ������ ������� ���� � �������� ����� ������� ������, ��� 20 ����� ��� ������ � ���� ����������� ������� 62 ��������, �������� ��� �������. \"������, ��� ��� ���������� ���� � ����� �����. �� �� ���������� �� ������ �������������\", - ������ ���������� �� ��������� ������������ �������� ����. �� ������ �������, �������� \"���������\", ������ ������ ������� ��������������� ���������� � ��������������� �������� � ������������� ����������� �������� ������������. \"�� ��������� ��������, ��� ��� �������� �������� �� �����. �� ������� ������������� ������ - ��� ���������� ����������\", - ������ ����� �������. �� ����� �������� ����� ���� �� ������������ �� ����������� �������� �� �������� ������������, ������� �������� � �������������� �������� ������ ��� ������� ���� �����������. ��������, ��� ��� ������ ������� 62 ��������, ��� ���� ������� ������� ���������� � ��������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (126,426,'��� �������� ��� ������ � ���� ����������� ��������',2,'��������� ��������� ���� �������� � ���������� ������ � ���� ����������� � ������� ������������� ������� ������ �������������� ����. ����� ��� ��������� ��������� � ���� ����������� ��������� �������� ����� ���� ���������� 62 ����. � ����� �� ������ ������ �������� 38 ��������.','��������� ��������� ���� �������� � ���������� ������ � ���� ����������� � ������� ������������� ������� ������ �������������� ����. �� ����, �������� \"���������\", ������ � ����� ����-���������� �������������� ���� ����� �������. �� ��� ������, � ����� �� ������ ������ �������� 38 ��������. ��� ������� ������������� ����������� ��������� �������� �����, ����� ��� ��������� ��������� � ���� �������� ���� ���������� 62 ����. � �� �� �����, ����� �������� � ���������� ������ � ���� �� ����� �������� �� 63 �������. � ������ ����������� �������� �������� ���������� �� �������� 66-������ �������. ����� � ����������� ��������� ������ ���� ����������� �������� �� �������, � 01:11 �� ����������� �������. �� ���� ������� ������ 35 �������. ������ ����� ��� ������ � ���� ����������� � ������� ������������� ����� ����� �� ������, �� ������� 21 ����� ��������� � ������ ���� ������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (127,427,'�������� Google ���������� ����� � �������� \"���������\"',2,'������ �������, ����������� �������� ���������� ������������� Google, ������, ��� ����� ��������� ��������� �� ������������ �������� ��� ��������. \"�� ������ ������ ��� ������ ���������� ����������� �����������, ������ ��������� ��������,\" - ������ �������.','�������� Google ���������� ����� � �������� ������������ ���������� ��������, ���������� �� ����� Gizmodo. ������ �������, ����������� �������� ���������� ������������� Google, ������, ��� ����� ��������� ��������� �� ������������ �������� ��� ��������. \"�� ������ ������ ��� ������ ���������� ����������� �����������, ������ ��������� ��������,\" - ������ �������. ��� ������������ �������� ��������� ������� �����, ����-���������� Google, � ���, ��� \"������������ ��������� ��������� �� ������������� ������-������ ��������\". ��� �� ����� �� �������, �� ���� �� ������ �� ����������� � ���, ���������� \"��������\" ��� ���. ��������, ��� ����� � �������� �������� �� Google ��������� ��� � 2006 ����. ������ �������� �������� Nokia, ������������� ������� �������, ��� \"��������\" �� ����� ����� ������ �� ����� � �������� �� ����� ���������� ������ ��� ��������-�������������.',31,1174588082,1174588082);
INSERT INTO `news_news` VALUES (128,428,'��������� ��� ���������� ���������� ������ ������ ������',2,'��������������� ��� ������� ���������� �� ������� ���������� �������� �����, ������ ������ \"��������\", ������������� ����� �������������� �������� ����������� ETA, �� ����� ������� �� �������, ��� �� �������� ���������� � ���������� ����������. ��� ����� ������, ��� �� ����� �������� � ������ ��-�� �������� ���������.','��������������� ��� ������� ���������� �� ������� ���������� ���������� �������� ����� (Arnaldo Otegi), ������ ������ \"��������\", ������������� ����� �������������� �������� ����������� ETA, �������� ��������� Associated Press. ������� ���� ������������ ������� ����� ������ � ������ �� �������, ��� �� ������ ��������� � �������� ����������� �� ���������� � ���������� ���������� - ������������, ������� � ������� ��������� ����������. ��� ����� ������, ��� �� ����� ������� � ��� ��-�� �������� ���������, ������� ���������� ��� ������ �� ������ �� ������ Elgoibar, ��� �� �����, � ������. ������ ����� �����, ��� � ������ ������ ������ �������� ������� �� ����� ��������� ����������� ��� ������. ����������, ��� ��������������� ��� ��������� � �� ������������ ������������� � �������� �������, ������� �������, ��� �������� �� �������� ��������� ������������, ��� �������������� � ������ �� ����������. ��������, ��� ����� ���������� � ���, ��� �� ��������� 22-������ ����������� ETA ����� ���������� (Olaya Castresana), �������� �� ������������� ��������� �� �����������, �� �������� ����, � ������� ��������� ������ ETA ��� ��������� ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (129,429,'\"���������������\" ������� �� \"���� �����������\" ������������ ������',2,'\"������� ������� ������ ������\" (����) ��������� 14 ������, ������������ � \"������ �����������\", ������� �� ����� ������ 15 ����� �������. ����� ����� ��������� \"����� ������������ �����\". ����� ����, �� ���������, ��� ���� ����� ������� ������� � \"��������� �����\", ����������� �� 8 ������.','\"������� ������� ������ ������\" (����) ��������� �������� 14 ������ � ������ �����, � �������, �� ��������������� ������, ������ ������� 15 ����� �������. ����� ��������� ������ � ����� �� �����-����������� ���� ���������������� � ������������� ������� ���� ������ ������, �������� ������������� �����.��. �������, ��� � ���� �� ����, 14 ������, � ������ ����������� ���������� ���������� \"����� �����������\". ������, �� ������ �������, ����� \"����������������\" �� ������� � ������ ��������� � �� ����� ����������������� ��. \"��� ����� ����� ��������� ����� ������������ �����\", - ������ ������, �������, ��� \"���������������\" �� ���������� �������� ������� ���������� � ��������� \"����� �����������\". � �� �� ����� �� �� ��������, ��� \"������� �������\" ����� ������� ������� � \"��������� �����\", ������� ������� � ������ 8 ������. �� ������ �������, � ��������� ����� � �������������� ����� ������� � \"������������� ����������� ���������\" - ������� ������������. ��������, ��� ���������� \"���������� �����\" ���������� �������� ��� ����� � ���� �������� ������ \"����� �����������\".',29,1174588082,1174588082);
INSERT INTO `news_news` VALUES (130,430,'������������ ������� ����� ����� �� ������',2,'���������� ������ �������������� ��������� ��� �� �������� ������������� � ����������������� ���������������� ������������ �� ����������� ��� ���� ��������� ���������� ���������� ����. ������������ �������� ������������������ ����� ����� � ������� ������ �� ������ �� ���� � ���������� ��������� ����������� ����������.','���������� ������ �������������� ��������� ��� �� �������� ������������� � ����������������� ���������������� ������������ �� ����������� ��� ���� ��������� ���������� ���������� ����. ��� �������� AP, ������������ �������� ������������������ ����� �����, ������� ������, � ����� �� ���������� �� ������ �� ���� � ���������� ��������� ����������� ����������. ����� ����������� ������ ����, ������������� ����� ���������� ������� ��������� ������������ ��������� ����� ��������. ��� ��� ����� �������� �� ������� ��������, ������������ ��������������, ��������� � ��������, �������� � ��� ��������. ��������, ��� ���� ����� ��������� ��� ������, ��� �������� ����� ����������� �������� ����� ���������� ������ � ��� ������, ���� �� ��������� �� ����� ������������, � ��� �� ����� ������ �������.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (131,431,'� ��������� ���������� ��-134 ����� �������� ������������',2,'�������� ���������� �������� ��-134 ������������ UTair, ������� ��������� 17 ����� � ��������� ���������, ����� ����� �������������������� ������ �����������. \"������������� ������ ��������� �������� ��������������, �� ��������� �� ���� ����������� ���������� �� �����������\", - ������� �������� ��� �������.','�������� ���������� �������� ��-134 ������������ UTair, ������� ��������� 17 ����� � ��������� ��������� \"�������\", ����� ����� �������������������� ������ �����������. \"������ �� ���� ��������� ���������� � ��������� ������ �� ������ ����������. ������������� ������ ��������� \"�������\" �������� ��������������, �� ��������� �� ���� ����������� ���������� �� �����������\", - �������� ��� ������� ����� ������������������� ���������, ��������� � ����� ������������� ����������������. �� ��� ������, ������ � ��������� ��������� � ������ ������ �������� ��-134 �� ������� ����������. \"� ���������, �� ��������� ��������������, ��� ������ � ��������� �������� �������� � ������ ����� ������������. ������ �������������, ��� � ������ ���������� ������ �������� �������� ��� ���� ����� ��������� �����\", - ������� ��������. � ���������� �������� ����������� ������� ����� �������, ������� �������� �������. �������� ����� ����� ������� �������� ��������� ����, ��� ���������� � ������� �������� ������� �������������� �������� ���������� �����. ���������� ��������������� ������ ������ ��������������: ������ �������, ����������� ������������, ������ �������� �������, ������ �������� �����. ��� ���� ����������� \"������ ������\" ��-134 �� ����������� ������ � ������������� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (132,432,'����������� � ���������� ������� ���� �� ���� ���������',2,'������ �� ����� ����������� � ���������� ������� ������������ ���-29 �� ����. �� ���� ������� �������� �������� ��� ������ ��������� ��������� ������������. �� ��� ������, \"������� ������������ ����� �����, �������� ���������� �� �����������\". �� �������, ��� ����� ������� ������������� ��������� ��������, ����� � ���������� �� ����� ���.','������ �� ����� ����������� � ���������� ������� ������������ ���-29 �� ����. �� ����, ��� �������� ��������� \"���������\", ������� �������� �������� ��� ������ ��������� ��������� ������������. �� ��� ������, \"������� ������������ ����� �����, �������� ���������� �� �����������\". �� �������, ��� �������� ����������� �� ������ ����� ���� ����� ������, �������, ��� ����� ������� ������������ ��������, � ����� � ���������� �� ����� ���. ������� ��� ������������ ������ ������������������ � ������ �� ��������� ������������ ���������, ����������� ������� � �����������, ��� �� ��������� ������� ��� ������������������. ��������, ��� �� ����� ������������ ���� ������� ���������, ������������ 21 ����� � 40 ���������� �� ������������� ��������� � ���������� �������, ������� ����������� ������-����������� �������� ������ ��������� ��������� ���� �� ������ 351 �� �� (\"��������� ������ ������� ��� ���������� � ���\").',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (133,433,'������������� ������ ���� ����� ��������� �� �����',2,'20 ����� � �������� �������� (���������) ��������� ������� ������ ���� ��� �����. �� ���� ���� �� ������ �� �������� ��������� �� ������ ����, ������ ��� ��� ���������� � ������ ������, ����� ����� �������� �������������� � ����� � ����������� ������� ���. ����� �������� �� ������ � ����, �� ������ ����.','20 ����� � �������� �������� (���������) ��������� ������� ������ ���� ��� �����. �� ���� ���� �� ������ �� �������� ��������� �� ������ ����, ������ ��� ��� ���������� � ������ ������, ����� ����� �������� �������������� � ����� � ����������� ������� ���. ����� �������� �� ������ � ����, �� ������ ����. ��� �������� ��������-������� fightnews.com, ����� ���������� � ����� ��� �������� ����� � �������������� ����������. ����� ����� ������ ������ � �������� � ������� � ������� � ��������. ����������� �������, ��� �������� ������ ����� ����� ��������� �����. ���������� ��� ���� ������������� ������ ���������� ������� ����������� � ����� �����. ��������� ������� ��������, ��� ������� ���� ������ � ����� ���������� ����� ��������� � 200 ����� � ����� � ���������� ���������� �� 56 ����� (���������� ����������� �������� 200-400 �����). ������ ��������� ����� ����� �������� � ����������� ������� �����. ����� ���� ��� ������� ������������� ��������, �������� ��������������� ����� ���. � 2005 ���� ����� �������� ��������� ������� ����, � � 2006 - ����� ������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (134,434,'����� ���������� � ���������� ��� �� ��� � ������',2,'����� �������� ���� �����������, ������� ��������� � ������ �� ����������� ���� � ��������� ������ ������� Volta. ��� �������� � ���������� 1 ������ 2007 ����. ����� ������ ���������� � ��� � ����� �������� � ������ ����� ���������� Glastonbury. ����� ��������� ����� �������� � ������� 6 ��� 2007 ����.','���������� ������ ����� �������� ���� �����������, ������� ��������� � ������ �� ����������� ����, ���������� �� ����� Gigwise. ��� �������� � ���������� 1 ������ 2007 ����. 27 ������ ������ �������� �� ��������� Coachella, � ����� ���� ��� ��������� ��������� � ���. ����� ����� ��������� ��������� ����������� � ������, ������ �� ������� ��������� �� ��������� Glastonbury 22 ���� 2007 ����. ���������� ��� ����� ����� �������� ������ ������ ���������� ������� ������. ��������� ��� ��������� Volta �������� � ������� 6 ��� 2007 � ����� ��������� ������ ������. � ������ ����� ��������� ������� ������ ������� (����� ������������ ���-������ Antony and the Johnsons), �������� Timbaland, ����� �������������� � ����� ������, ��������� ������������ � Jay-Z, � ��������� �� ������ �������� ���������� ������� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (135,435,'������� ������� ���� ��� PlayStation 3',2,'��������� �������� SplitFish ��������� FragFX, ����� ������ ������ ����������� EdgeFX ��� PlayStation 3. ��������� ������ ����� ����������� ������������ ����� ��������������� ���������� ���� �� ������������ �������� PlayStation �� ������� �����. � �������� ����� ������ ����������� ������� ������ ��� ����.','��������� �������� SplitFish ��������� FragFX, ����� ������ ������ ����������� EdgeFX ��� PlayStation 3, ���������� �� ����� Gizmodo. ����� ����� FragFX �������� ������������ �������� ���������� - ����� ����������� �����������. ��������� ������ ����� ����������� ������������ ����� ��������������� ���������� ���� �� ������������ �������� PlayStation �� ������� �����. � �������� ����� ������ ����������� ������� ������ ��� ����. ���������� ����������� � ���� ��������� - USB � Bluetooth. ��������� ������������ ����� �������� � ������� ������� Home ��� PlayStation 3, ������� �������� ������ 2007 ����. Sony PlayStation 3 ��������� � ������� �� ���������� ��� � ������ 2006 ����. � ������ ������� ���������� ��� �� �����.',31,1174588082,1174588082);
INSERT INTO `news_news` VALUES (136,436,'����������� �������� �� \"�������\" ������ ��������� �� ��������� �������',2,'�� ���� �������� �� ��������� ������� ��������� ����������� ������������ �� \"�������\" H������ ����������. ��� ����� �������� �� ���������� � ��������� ����������, ����������� ���������� ����� ���������� �� ������ ����� ������� ������ ���������� ���������� ��������, ������� ��������� 23 �����.','H� ���� �������� �� ��������� ������� ��������� ����������� ������������ ��������� �� \"�������\" H������ ����������. �� ���� ��������� \"���������\" ����� �������� �� ���������� � ��������� ����������. ��� ������� ��������, ����������� ���������� ����� ���������� �� ������ ����� ������� ������ ���������� ���������� ��������, ������� ��������� 23 �����. ��� �������� ������������ � ��������� ��������� ����������. ������� ��������� �������� 15 ������� 1957 ���� � ����������. �������� ��������� ������������ �������������� ���������������� ������������. �������� ��������������� ������ \"�����\", ������� ���������� ������ \"��������� �����\". � 1990 �� 2004 ��� ���� ������� ���������� ������ \"��� ���\" (\"������������� ��� ���\"). � ��������� ����� ����������� �� \"�������\" � ����� ���������� ��� \"������������� ��� ���\". ��� ������� ����������, ������ �������� - �������� ����������� ������ �� �� �������� �� �������� ����������. ����� ������ �������� ��� ����������� �������������� ���������� �� ������-��������� ������������ ������.',29,1174588082,1174588082);
INSERT INTO `news_news` VALUES (137,437,'������������� ���� ����� �������� ������� �����������',2,'�� ����� ������������ ���� ������� ��������� ���-29, ������������ 21 ����� � ���� �������� ������� � 40 ���������� �� ������������� ��������� � ���������� �������, ������� ����������� ������-����������� �������� ������ ��������� ��������� ���� �� ������ �� ��������� ������ ������� ��� ���������� � ���.','�� ����� ������������ ���� ������� ��������� ���-29, ������������ 21 ����� � ���� �������� ������� � 40 ���������� �� ������������� ��������� � ���������� �������, ������� ����������� ������-����������� �������� ������ ��������� ��������� ����, �������� ��� �������. ������������� ������� ����������� �������, ��� ��������� ���� ���������� �� ������ 351 �� �� (\"��������� ������ ������� ��� ���������� � ���\"). ��� ����� ��������, �� ����� ������������ ��� �������� ���������� ��������� ������������ ������ �� �������������� ������� �����������. ��������, ���, �� ������ ��������� �������� ��� ������ ���������� ���������� �������������, ������������ ��������� 21 ����� � 16:02 �� ����������� ������� � 40 ���������� �� ������������� ��������� � ���� ���������� �������� �������. ����������, ��� ��� ������������ ������� ������ ������������������. ������� ��� ��������� ������������ ��������� � ��������� � �����������. �� ��������� ������������� ��� ������������������. �� ��������� ������, � ���������� ��������� ����� � ���������� �� ����� ���.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (138,438,'��������� ��� ��������� ��������� ����� �������� \"��������\"',2,'��������� ��� ������� ����� �� ��������� ����� �������� \"��������\" ����� �������, ����������� � ���������� ���������� ������������ � ��������� �������� �������. ��� ���������� ������� ������� ������ �����, ������������ ����� ����� � ��� � ������ \"������ ������������� �������\", �� �� ����������� ��� � ����������������.','��������� ��� ������ ������� ����� �� ��������� ����� �������� \"��������\" ����� �������, ����������� � ���������� ���������� ������������ � ��������� �������� �������, �������� ��� �������, �������� �� �������� ������� ������� �����. �� ��� ������, ����� ��� ������� �� ����� � ��� � ������. � �� �� ����� ������� ����������, ��� \"��� ��������� ���������, ������� ������ ������������� �������\". \"������������� ����� ��������� �� �� ��������\", - ������ �����, �������, ��� ������ ������� �������� �� 23 ����� ���������� ��� ������� ��� ����������. ��������, ��� ��������� �� ���� ������� �� ���� ����������� ������� � �������� ������ 2006 ����. �� ������ ���������, ����� �������� \"��������\" \"� ������� �������������� ������ �������� ���������� ���������� �������� � ������� � ���������� ���������� ����� � ������� 57 ���������� ������\". ��� ���������� ���������, 610 ��������� ������ ������ ����� �����������\". C ������� 2006 ���� ������ ��������� � ����������� � ������������� �������, � 1 ����� ���� �� ���� ��������� ��� ������� ������ ����� ������� �� ����� �������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (139,439,'��������� Duke Nukem Forever �������� ���� ������',2,'��������� ������ Duke Nukem Forever ���������� � ���, ��� �������� ������ ��� ���������� ����. ��������� ���������������� ���������� ������ ����� ������, ���������� �������� Apogee Software. ������ ����� ������, ��� ������������ ����������� ���� �����������, ����������� ������� \"������ � ���� ����\".','��������� ������ Duke Nukem Forever ���������� � ���, ��� �������� ������ ��� ���������� ����, ���������� �� ����� The Inquirer. ��������� ���������������� ���������� ������ ����� ������ (Scott Miller), ���������� �������� Apogee Software. ������ ����� ������, ��� ������������ ����������� ���� �����������, ����������� ������� \"������ � ���� ����\". ���������� Duke Nukem Forever (\"��� ����� ��������\"), ������� � ������ �� ������� ���� Duke Nukem 3D, �������� � 1997 ����. ��������� �� ��� ��� �� �������� ����� � ������ ����������. ����� ����, \"������\", �� ������ �������� ��������� ����, ������������ �������. \"�� ��������, ��� �������� ������, � ���� ������������ � ����� ��� ��������. � ��������� ������� ���� �� ����� ����� ����������� �������� �� ����, � ������, �����, �������� � ���������� �����������\" - ������ ������. ��� �� �����, ��������������� ���� ��������� ������� ���� �� ��� ��� �� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (140,440,'������� ������ Falcon �������� �� �������',2,'� ��� ����������� ������������� ����� ������� ������ Falcon 1, ����������� Space Exploration Technologies Corp. 21-�������� Falcon 1 ������� ���� �� ���������� �����, ������ ����� ���� ����� ����� � ������� ���� ��������. ��� �� �����, ���������� ����� ������� ���������� ��������� � ��������� ������������ ������������.','� ��� ����������� ������������� ����� ������� ������ Falcon 1, ����������� Space Exploration Technologies Corp. (SpaceX). ������� ��� ������� �� ������������ ��������� ��������� �� ����� �� ������� � ������ ����������� ��������. ����� ������ �� ������ �������. ������������� ���������������� ���� ��� ������������� ������� �� 90 ������ �� ���������������� ������� ������� ��-�� ������������ ����. 21-�������� Falcon 1 ������� ���� �� ���������� �����, ������ ����� ���� ����� ����� � ������� ���� ��������. ����������������, ��-�� ���������� �������� ������ ������� �� ��������� ������������� ����������, � ���, �� ��������� ������ ������, ��������� � ������� ���� ���������. ��� �� �����, ���������� ����� ������� ���������� ��������� � ��������� ������������ ������������. ����������� �������� ��������� ����������� ������ ��� ��������. ��� ����� ����������� ������ ������ � ������ ������ ��������������� ����� ������ �� �����. � �����������, �������� SpaceX ��������� �������� �� NASA �������� �� �������� ������ �� ���, ����� �������� ���������� 278 ��������� ��������. �� ��������� ����� ������ Falcon, ���������� � ��������, ������ � �������� ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (141,441,'��������� ���������� ��������� ������������� ����������� ���������',2,'�������� ������������ ���������� ���������� �� ���� �������������� �������� ������������ ����������� ���������. �� ���� ������� ������������ �������� �� ������ �������� ������ ������ ���������� ���������� ���� �����������. �� ��� ������, �������� �� � ����� ��������� �������� ��������� �����, ��� ����������� �� �� ����������� ���������.','�������� ������������ ���������� ���������� �� ���� �������������� �������� ������������ ����������� ���������. �� ����, ��� ����� � ����� Telegraf.by, ������� ������������ �������� �� ������ �������� ������ ������ ���������� ���������� ���� �����������. �� ��� ������, ����� ������� �� ���� ��������� �����������, ��� ����� ��� �������� �� ������ ������ ����� ����������� ������� �����, ��� ����������� �� �� ����������� ���������. ��������, ������� �����������, ��� ������� ��������� ����� ���� ����� ����� ������� ��������� ���� �����. ��� ��� ���� ����� ������� ������ �������������� (������ ������ ����������) ������������� �������� ���������� ������ ������ ��������� �� ������������� ������� � ���������� ����� � �������������� ������������ ����������� ���. ������� ��������� ��������� ���� ����� � ��������� �������, ����� �� �������� ������� ��������������� ��� ���, ��� \"����� ����������� ������� ����� �����\".',22,1174588082,1174588082);
INSERT INTO `news_news` VALUES (142,442,'���������� ������ ������ ������ ������ �������� ��������',2,'���������� ���������� ������� ����� ������ �������� � ������������� ����������� ������� 10 ��������� ������ �� ������ ���������� �����. ��� �������� � �����-������ ����� �����������, ������ ������������� ��� �������� ������ ������������� ��������, �������� � ���������� ������ �� ����� \"�����������\".','���������� ���������� ������� ����� ������ �������� � ������������� ����������� ������� 10 ��������� ������ �� ������ ���������� �����. ��� �������� ��� ������� �� ������� �� �����-������ ����� �����������, ������ ������������� ��� �������� ������ ������������� �������� ��������. \"��� ������ ������������ � �������� ������ �� ���� ������� ���������� �������\", - ����������� � �����-������. ����� ��������� ���������� ��� �� ����� ���������� �������, ��� ����� �������� ������� �� 1,3 �� 2 ��������� ������. ��������, �� �������� ����� ������� �������, �� ���������. ����� ����������, ��� �� ���������� ����� �������������� ����������� ������� � ��������� \"��������������\", ������� ����������� �����, ������������ ������� ������, ����������� ������ ������� �������� ������� ������. ����� �������� ������� �� ���� ������ �������� ����� ��������. ������ �� ����� \"�����������\" � ����������� ������� ��������� ����� 19 �����. ��������������� ��������� ������ � ������, ��� �� �������� ���� ����� ������. ����� ��������, �� ��������� ������, ���������� 108 �������. ����� �� ������ ������ � ����� ���������� 203 �������.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (143,443,'��������� ��������� �������� ���� ������������� �����',2,'������ ���� ������� ��������� ���-29, ������������� 21 ����� � ������� �������� �� ������������� ���������, ��������� ����������� � ���������� �� ��������� � �����������. ��������� �������� �������� ������������� ��� ������������������.','������ ���� ������� ��������� ���-29, ������������� 21 ����� � ������� �������� �� ������������� ���������, ��������� ����������� � ���������� �� ��������� � �����������, �������� ��������� \"���������\" �� ������� �� ��������� �������� ��� ������ ���������� ���������� �������������. �� ������ �������������, ��������� ������� ������������� ��� ������������������. ��� ������������ ��� ������� ������ ������������������. ��������� ������������ ����� �������, ��� ������������ ��������� � 16:02 �� ����������� ������� � 40 ���������� �� ������������� ��������� � ���� ���������� �������� �������. \"����� � ���������� �� ����� ���\", - ������ �������� ��������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (144,444,'��������� �������� ���� ���������� ����� \"�������-������\"',2,'�������� ��������� ������� ������������� ������� ���������� �� ���� � ������� ����� 2005 ���� ������ \"�������-������\". ������������ ������� ������ �������� � �������� ������ ���� �������� ��������� �� ���� �������, � ��� ����� ������ 205 (\"���������\") �� ��.','�������� ��������� ������� ������������� ������� ������� ��������� � ��������� ������� - ���������� �� ���� � ������� ����� 2005 ���� ������ \"�������-������\", �������� ��� �������. \"������������ ������� ��� ��� ���� �������� ��������� �� ���� �������, � ��� ����� ������ 205 (\"���������\") �� ��\", - ������ ������� ������ �� ���������� ������� ����������. ������ � ���, �������� �����, ��� ��������� ���� ����������� ������������. �� 2 ������ ��� �������� ���������, � ���� �������� ����� ����������� ����������� �������� ���������. �������� ������, �� ������ ������ �������� �������� ��������� ����� ��������� ����������, ����� ����� ����� ������������� ������� ������. ����� ����������� ������ ��� �������� �� ��������� ���������.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (145,445,'Google �������� ������� ����������� �������',2,'�� �������� ����� ������� Google, ������������� ������ ������ � ��� ������, ���� ����� �������� �� ��������� ������ ������������ ����������������� � ������������� �������, �������� ������ ��� �������� ��������� �����. ����� ������� �������� �������������� ���������� �� ������-������� � ��������� ���� ��������� �������.','�������� Google ��������� ����� ������� ����������� �������. �� ����� ��������, ������������� ������ ������ � ��� ������, ���� ����� �������� �� ��������� ������ ������������ ����������������� � ������������� �������, �������� ������ ��� �������� ��������� �����, �������� The New York Times. �������� ������� ������-������� ������������� ������ ������� ������ ������� ��� �������� �� ������ �� ���� �������������, ���������� �� ����, ������� �� ��� ������� �� ����� �������. ������������� � ����������� ���������� ���� Google. ��-������, ����� ������� �������� ���������� �� ������-�������, ��������� ��������� �� �������� ������� �� ����������, �� ������ ���������� �������. � ��-������, ����� ������� ��������� ���� ��������� ��������� ������� ������� � ���������� �������.',30,1174588083,1174588083);
INSERT INTO `news_news` VALUES (146,446,'� ����� \"�����������\" ������ ��� ���� ��������',2,'���� ��� ������ ��������� ���������� � ���� ������������ ����� � ����� \"�����������\", ��� 20 ����� ��������� ����� ������������ ������. ����� ������� ����� ����� ����� �������� 108 �������. � ����� ������������ ������ ��� ���� ��������, ������� ���� �������� ���������� ��� �����.','���� ��� ������ ��������� ���������� � ���� ������������ ����� � ����� \"�����������\", ��� 20 ����� ��������� ����� ������������ ������. �� ����, ��� �������� ����-����, �������� � ���������� ��� �� ����������� �������. ����� �������, ����� ����� ����� �������� 108 �������. � ����� ������������ ������ ��� ���� ��������, ������� ���� �������� ���������� ��� �����. ��������, ��� ������ ����� ������ ������� 93 ��������, �� ������������ � ����� �� ������ ������. ������, �� ������ ������������, ����� ����� ��������� �����, � ��� ����������� ������� ������������ ������. ��������������, ��� ��������� ������ ��������� ��� ��� ���. � �� �� ����� ������������� ��� \"������������ �������� �������� \"��������������\", ������� ����������� \"�����������\", ��������� �������, ��� ��� ����� ����� �������������. �������, ������������, ��� \"������ � ������ ����� �������� ����� ����, ��� ������� ������������� � ����� �������, � ����� ��������� ��� ���������\".',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (147,447,'�������������� ��������� ������������� ��������� �����',2,'������������� �������������� ��������� ������������� ������������� ��������� ����������� � ����� � ������� ������ ����� ����� ������� ���������. � ����������, ���������� ����������� ���� ����� ������������ ������ �� ��������� ����������, ������� �������� �������� ���������� � �������������� � ������ ��������������.','���������� ������������� ��������� ������������� ������������� ��������� �����������, �������� Defencetalk. �������� ������� ����� ����������������� �������� ������������� ��������� �����������, ���������� � �������� ���������� ����� ����� ������� ��������� ��� � ������ ������� �����, ��� � ������������, �� ������ ������������� �����������. ������ ���������� ����������� ���� ����� ������������ ������ ��������� ����� � �������, ���������� �������� ���������� � ��������������, �������������� ����������� ����������� � ������ �������������� ����������. ������������ ������� ����� ������������� �����������, � ��� ����� \"������������� ��������\", ������������� ������ � ������� ���������� �������� ������ ������� �� ������������� �����������, ������ ����� ����� ��� ����� ��������� ������������ ���������. ������� ��������, ��� �������������� ������ �� ������� ������ ��������� ������������� ������������� ��������� �����������.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (148,448,'��������� ���� ������ ���� ������� ��������������',2,'���������� �������� ��� ����� ������������ ������������� ���������� ���� ������ ������� �������� ���������� ���, ������ ������������ ����������� \"�������� �����������\" ���� ������� ��� ����������� ���������� ��� �����������. �� ���� ������� ������� ������� ���� ����������. ������� ������������� � ���������� ������ 51 ������� ������.','���������� �������� ��� ����� ������������ ������������� ���������� ���� ������ ������� �������� ���������� ���, ������ ������������ ����������� \"�������� �����������\" ���� ������� ��� ����������� ���������� ��� �����������. �� ����, ��� �������� ProUA, ������� ������� ������� ���� ����������. �� ��� ������, ��� �� ������� � ��� ���� ������ ������ ������� ������� �� ������������� �������������� � ����������� ���������� ���� ������ ������� ���� ���. ��� ������ ������������ �� ������ ������ � ������������ ��������� ��������������. ��� ���������� �����, 2 ����� ����������� ����������� ��������� � ��������� ������� ��������� ���� �� ���� ������� ���������� �������, � ������ ����� 3 ������ 364 � ��������������� ������� ��� ��������� ����������, ����������� ���������� ������������������� ������ � ��������� ������� �����������, � ����� 1 ������ 263 - ���������� ��������� � ������� � ������������. ������� �������������, � ���������, � ���������� ������ ����������� ��� 51 ������� ������. ����� 20 ����� ���������� ����������� � ������ ������������� ���������� ���� ������ ������� ������� ����� � ��� �������� � ��������� ������. ����� ����� ������ ������� ��� ������ �� ������. � �����, 21 ����� ������� ����� ����� �� ������ � ��������������, ����� ���� ��� �������� ������� � ������������ ����.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (149,449,'��������� ������ ���������� ������������ ��������� ������������� � ����',2,'��������� ��������� ��� 21 ����� ����������, ��� ��������� ���-����� \"�����\" ������� ������������� � ���� �� ���������� ��������, ������� � ���� ����� ����� ��������, ���� ����������. ����� ����� �� ������� ���� �������� � ��������� ����� ��������������.','��������� ��������� ��� 21 ����� ����������, ��� ��������� ���-����� \"�����\" ������� ������������� � ���� �� ���������� ��������, ������� � ���� ����� ����� ��������, ���� ����������, �������� \"���������\" �� ������� �� �������� ������������� ������� ��������. ������� ��� ���������� ���-����� \"�����\" �� 10 ����� � ���� 3 ���� �������� ���� ����� ��� ������, ��������� � ���� ��� ������. ���������� ��� ��������� ���� ����� 15 ������ ����������� ���������� �������������� ����������, ����������� ����������� \"���������, ��������, ������, ��������� � ���, ��������� ���� �������� � ������ ������ ���������� ���� ����������� �������� �������, �������� � ��������, ����������� � ������ �����������\". ��������������� ��������� ��� �������� ��� ��������� �������������. ������������� ������� ������ ������ ���������� ������� ���� ������ ���������, ������, ��������� ��� ��������� � ������ ����������, ������� ��� ����� ������� � ����, ������� �������. ��������, ��� ������������� ��� ������ ������ � ���� �� ��������� � ��������� ����������, �� ��������������� ��� ��� ��� ���� ��������� ��� ��������� �����������.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (150,450,'������� �������������� ��� ��������� � 2009 ����',2,'����������� ��������� ����� ������ ��������� ��������� �� 2009 ����. � ���� \"����� �����\", ������������� � ��� �� ������, ��������� ��� ����� 1939 � 1960 ������. ��� �� ������� ���� ���������� ������� \"������ � ����\" � ������ ������������. ����� ������������ �������� ����� ���� �������� ���������� �������������.','����������� ��������� ����� ������ ��������� ��������� �� 2009 ����. �������� ��������� ������� �������� �������� ������������� ������ ��� ����� ���������� ����������, �� ������� �������� ����� �� �������, �������� ��������� Associated Press. �����, ������� ������ ���� ��������� �� ������, �� ������������, �� ��������, ��� ����������� ������ ��������� �������������. � ���� ��� ��������� \"����� �����\" (\"Finca Vigia\"), ������������� � ��� �� ������, ��������� ��� ����� 1939 � 1960 ������. ��� �� ������� ���� ���������� ������� \"������ � ����\" � ������ ������������. ����� ������������ �������� � 1961 ���� ��� ����� �������� ����� ������ ������, � ��� � 1962 ���� ��� �������� �����. ������ �� ����� ���� ������� ��� ��� ����, � �� ������ ���������. ��������������� �������� ��������� ��������� ������ ���������, ����������� � \"����� �����\": ���, ����� �������, ��������� ���������������� ������ � ���������� ������ \"�� ��� ������ �������\". � 2007 ���� ����� \"����� �����\" �������� 45-�����. ������������ �������� 1 ������ - � ��������� ������� ������ ��������� �� ���� (1928 ���), � ���������� 21 ���� - � ���� �������� ��������.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (151,451,'���������� PlayStation 3 ��������� �� ���� ����� ������ ����������� ��������',2,'����������� ������� ������� ����� ������� � ������, ��� ���� ���������� PAL-������ �������� ������� ������� �� Sony PlayStation 3. ������ ������ ������� �� ���� ����� �� ���������� ������������ ����� ����� ���������� ������� ������� ���������� �������� ���� �����. Sony ����� ����� ������ ���� ������ ���������.','����������� ������� ������� ����� ������� � ������, ��� ���� ���������� PAL-������ �������� ������� ������� �� Sony PlayStation 3. ������ ������ ������� �� ���� ����� �� ���������� ������������ ����� ����� ���������� ������� ������� ���������� �������� ���� �����, ���������� �� ����� The Register. ���� ������ ������� ������� ��������� �� ���� ������� ���� ��������� Darty, ������������� ������� ���������� � ������� ��� ���������� � ���, ��� ������� PS3 � �� �������� ������ �������� ����� ��� �� ����� �� �������, 23 ����� 2007 ���� - ����������� ���� ������, ��������� Sony. ���������� Darty, ���� Media World, ������ ��������� PS3 ��� ������� � 9 ���� �� �������� �������. ��������� �������� ����� ������ �� ��������� �� MW � ������ ��������� PS3 �� ���� ����� �� ������������ ������. �� ������ ������������, �������� ����������� ��������� ����� ������� �������� ���� �� Sony. ������������� ��������� �������� ��������� �� ������ ��������������� ������ PS3 � �������, ��� ���� ��� �����������, ����� �������� ����������� ������ ����������� ����������.',31,1174588083,1174588083);
INSERT INTO `news_news` VALUES (152,452,'���������� ��������� ����������� ��� � ������',2,'����� ��������� ����� �� ���� �������� ��� ���� ������������ ����� 21 ����� � ����� � ������� ������. ��� �������� ������������� ������������������ ������� ������, ����������� �������� � ������� � �������� � 13:00 �� �������� ������� �������� ��������������, ���� � ������� ������ �� ����� ������������ ����.','����� ��������� ����� �� ���� �������� ��� - \"��������\" (Forsmark), ������������� ���� ������ ������ (Uppsala) � ������ �� ����������, ���� ������������ ����� 21 ����� � ����� � ������� ������. ��������������� ��������� ���� ������������ �� ����� �������� ������ Aftonbladet �� ������� �� ������������� ������������ ���������� ������ ������� ��������� (Christer Nordstrom). �� ��� ������, ����������� �������� � ������� ����� ������ ����� ���� �� �������� ������� � �������� � 13:00 �������� ��������������, ���� � ������� ������ �� ����� ������������ ����. � ������� ���������� ������ ������� - ���� � ��� ���� ������������, � ����������� ������ ���������. � �� �� ����� ��������� �������, ��� ��� �������� ���� ���������������� ����������, � �� ����� ��� ���������������� �������� ������� �� ����� ������, � ���� ������� ���������� �������� � ������� ������.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (153,453,'��� ����� ������� ���������� ����� � ������',2,'��������� ������� ��� ����� ������� ���� ����� � ������, ������� ��� ������������ �� ����� �����. ����� ����� ������ � ��������� ����� ��������������� �� ��������������� �������. �������� ����� ���������� �������� � ��� \"������� ���� ��������\", � ��������� ���������� ��������������� ��������������.','��������� ������� ��� ����� ������� ���� ����� � ������, ������� ��� ������������ �� ����� �����, �������� ��������� \"���������\" �� ������� �� ��������������� �������� � ������. �� ��� ���������, ����� ����� ������ � ��������� ����� ��������������� �� ��������������� �������. ���������� ��������� �������� ����� � ���� ����������� ������� � ������� ������������ ������� � ���� ������� ������, ��� ����� �������� �� ����� ����������� �������� \"������� ���� ��������\", � ��������� ���������� ��������������� ��������������. � ��������, �� ������� ������� ������ � ������ ��������, ������ �� ����������. ������ � ���, � ����� ��������� ������� ������, ��� �� ����������� ������������� ������� �� ������ ��������� �������� ���������� ��� ������ �������. 26 ����� ����� ������������ ��� ������� ���� ����, ����� ����������� � ������������� ��������.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (154,454,'���������� ������������� ������� � ������� �������� ��������',2,'������������� ������ �������, ���������� � ������ ����� ������������� ������, ������� � ����� �������� ��������� 7 ���������. �� ���� ������� �������-������� ���������� ������ �����. ������ �������� � ������� ������ \"���� ���������\" � \"����������\" ������� ���� ���������, ������-��������� - 3 � ������� - ���� ������������ ����.','������������� ������ �������, ���������� � ������ ����� ������������� ������, ������� � ����� �������� ��������� ���� ���������. �� ����, ��� ����� � ����� Postimees, ������� �������-������� ���������� ������ ����� ����� �������� ����������� ������. �� ��� ������, ������ �������� � ������� ������ \"���� ���������\" � \"����������\" ������� ���� ���������, ������-��������� - 3 � ������� - ���� ������������ ����. ��� ���� ����� ����� ���� � �������� ������� ������� � ����� ������������� ������������� ������. ������ ��������� ��������� ������� � ����������� ���, ������� ����� �������, ���������� ������ �������� � ���� ����������� ������� ���������� ������. � ������ ������, �������� �����, ����� ������������ ������ ����� ������������ �� ����� ������� ���������������� �������� ����������. ������ � ��� ����� ����������, ��� � ����� �� ������������ ����������� ����������� ������ ����� ����������� �������. � ������, ���� ����� ������������� �������� ����� ���������� ����� ���������, ������ ����������� � ����������� ������ �������� � ������������� ������������ ������. ����� ����������, ��� ������ �� ��������� � ������ ����� � ������� ������� �������� ������������� ������, ������������� �������. ���������� ���������� ���������� 27,7 �������� ������� �����������. ����� �������, ������ �������� 31 �� 101 ������� � ����������.',22,1174588083,1174588083);
INSERT INTO `news_news` VALUES (155,455,'����� ����� ���������� ������� � ����� ���������',2,'����� ����� �������, ��� �� ��� ��� ������������ ��������� ���������� �� ����� ������ ����� ����� ���������. \"�� �������� ��������. ��� ��� ������ ���������� ����� � ������\" - ������� �����. ����� ����������, ��� ����� ��������� �� ��������� 3,4 ��������� ������ � ��� (�� ���� ����� 10000 ������ � ����).','����� ����� �������, ��� �� ��� ��� ������������ ��������� ���������� �� ����� ������ ����� ����� ���������, �������� AFP. \"�� �������� ��������. ��� ��� ������ ���������� ����� � ������\" - ������� �����. \"� �� ��� ��� ����� ���. � �� �������� ����\" - �������� ���. ��������, ��� � 2003 ���� � ��������� � �����, ����� ��������, ��������� ����, ������� ������� �������. � ����� ��������� ���������� ���� ������� � ��� 2006 ����. ���� ��������� � ����� ����������� ����� ������� ���. ����� ����������, ��� ����� ��������� �� ��������� 3,4 ��������� ������ � ��� (�� ���� ����� 10000 ������ � ����). ����� ��������� ���������� � ���, ��� ������ ������� ��������� ����������� �� ��������� ����� � ������� 29 ��������� ������.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (156,456,'��������� ����� ������� ������ ���� �� ��������',2,'��������� ����� �������� ������� �� ����� ����� 3-������ ����� ������ ����� �����. ��� �������� AP, ������� ��������������� �������� �������� ��������������� ��� �������� � ���. �� ������, ����������� �� ��������, ����� ���� ���� ��� �������� ���� ����������� ��� ����, ����� ��������� ����������� ������.','��������� ����� �������� ������� �� ����� ����� 3-������ ����� ������ ����� �����. ��� �������� AP, ������� ��������������� �������� �������� ��������������� ��� �������� � ���. �� ������, ����������� �� ��������, ����� ���� ���� ��� �������� ����������� ���������� ����� ��� ����, ����� ��������� ����������� ��� ��������� ����������� ������. ��� �������� ���������, ��� ��������� ��������� ����� �� �������� ���������, ������� ��������� �������� ����� ���������. ��������, ��� ��� ��� ��������� ������� �����. � ��� ���� ������ ���� ����, ����� ������� �������� ���� ����, � ���� �������� ����� ������ � ������. ����� ������� ��������, ��� �������� �� ����� ���������� �� ������ � �������, ���� ������ �������� ������� ����� �����, ������ �� ���� ��������� ��������� � ���, ��� ����� ��������� �������� �� ������� � ������ \"Wanted\", ������� ������� � ��������� ���������� �������� ����� �����������.',24,1174588083,1174588083);
INSERT INTO `news_news` VALUES (157,457,'����������� �������� ������ ����� 140 ����',2,'���� ����� ������� ��������� ������� II �������������� ������� ������ ���� � ��������� ������ - ����� 140 ���������. ��� ��� ���� ���������� ������������� � 1999 ���� �� ���������������-���������� ������� � �������� ������ ��������. ����� ������������ ���� ���� �������� �� ����� � ���������� �������.','����������� �������� �� ���� ����� ������� ��������� ������� II �������������� ������� ������ ���� � ��������� ������ - ����� 140 ���������. ��� ��� ���� ���������� ������������� � 1999 ���� �� ���������������-���������� ������� � �������� ������ ��������. ����� ������������ ���� ���� �������� �� ����� ������������ � ������� (������������� ����� ���������� �������), �������� \"���������\". �� ������� 2007 ���� ����� � ��������� �������� ��������� � ���������������� ��������������� �������������� �����. ��������� ����� �� ��������� ����� �� ��������, �� �������������� ����������� �������� �� ���. ���������� �� ����� ������������ ���������� ���������� ���� ������. ������������� ����������� �������, ��� ������� ���������� ������ ����� ������� ���������� \"�������������������� � ����������\" ���������.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (158,458,'����� \"�����������\" ����� �������������',2,'���������� ����� \"�����������\", � ������� � ���������� ��������� �� ������� ����� ��� �������, ����� ������������� � ���������� ������. \"����� ����� �������������, �� ������ � ������ ����� �������� ����� ����, ��� ������� �������������\", - �������� � �������� \"��������������\".','���������� ����� \"�����������\", � ������� � ���������� ��������� �� ������� ����� ��� �������, ����� ������������� � ���������� ������, �������� \"���������\" �� ������� �� ������������� ��� \"������������ �������� �������� \"��������������\". \"����� ����� �������������, �� ������ � ������ ����� �������� ����� ����, ��� ������� ������������� � ����� �������, � ����� ��������� ��� ���������\", - �������� � ��������. ������, �� ������ ������������, ����� ����� ��������� �����, � ��� ����������� ������� ������������ ������. ��������� ������, ��� ��������������, ��������� ��� ��� ���. �� ������ ������ ����� �������� ��������� 107 �������, ���������� ��� ����� �������� ����, ��� 93 ������� ���� �������. �������� ������������ �� ����� �� �������� ����������� ���� ������ ���� ����� ������, ������� ��������������� � ����� ��-�� ��������� ����� �������� ������ �����. �� ������ �������������, ��� ����� ��������� ��-�� ���������� ������ ������. ��������������� ����� ������ \"������������� �������\". ����� \"�����������\" ���� ������� � ������������ � ������� 2002 ����, �� ��������� �������� - 3 �������� ���� ���� � ���, �������� \"���������\".',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (159,459,'����� ������ �������� ���������������� ��������� ������� ������',2,'������� ������ �� ������ ������ ������� ������������, ��������������� ���������� �� ����� ���������� ���������� ����������� ��������� ������� ������. � ������������ � ������������ ��������, ��������� �� �������� � �������� ��������� ��� ������������ � ������� �������� ������. ������ ������ ������ ����� �������.','������� ������ �� ������ ������ �������� ������������, ��������������� ���������� �� ����� ���������� ���������� ����������� ��������� ������� ������, �������� ��� �������. ����� ����� ������ \"��������� ����������� �������������� ������������ ������� �� ����� ���������� �� ��������� ��������� ��\" � ����� \"�������������� ��������� ����, ��� � ������ ������ ������ ��������, ���������� �������� ����������������� � ����������� ����������\", �������� ��������� \"�������\". � ������������ � ����������, ���� ������������ ������ ����������� ����������� �������� �����������, �� � ������� ���� ������ ��������� ����� ������ ����� - ���� ����� �����������, ���� ������. ������� � ���������� ��������� ������� ����� ����������� ������� ������������ ������� ��������� ������� ��� ��������� ������ ���������. ����� ���������� ����� ������������ ������, ����� ����� �� 12 ��������� ������� ������ ����� ��������� �� ���������, ���� ��� ����� ������ �����������, �� ���� ���������������� ������������ � ��� \"����� �������\". ����������� ���������������� ��������� ���������� ������� � ��������� ������ ����������� ������������� ������������ ���������, � ��������� ������������, �������� ���������� �������, � ��� �����������, ����������� �������� ������ �������� ����� ���������. ����� �� ��������� ������� ������ ������������� ��������� ��� ������������ � ������� �������� ������. ��������, ������������, �� �������� �������� ����� ����������� �� ������������� ����������, ��� ����������� ������� ������� �� � ������������� ����� ����������� � ������ 2007 ����. ��� ������� ������������ �� ������ ��������, ������� ���������� � ���������� ��������� ������ �������� �� ������.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (160,460,'����� \"����������� �����\" � ���� ����������� ���� ������� ���� �������',2,'������������ �������� ��� ����� ������� ������ ������������ ���� ����������� ����������, ����� \"����������� �����\" ������� ��������� �� 27 �����, ����� ���� ��� ����������, ���������� � ��������������, ����� � ���� ���� �������, ��� �� \"������, ��� ����\". ����� ������ ��������� ���������, ������ ��� �� ���� �� �������������.','������������ �������� ��� ����� ������� ������ ������������ ���� ����������� ����������, ����� \"����������� �����\" ������� ��������� �� 27 �����, ����� ���� ��� ����������, ���������� � ��������������, ����� � ���� ���� �������, ��� �� \"������, ��� ����\". ��� �������� ProUA, �������� ������ ��� \"���������\" � ����� �� ������� ������� ���� ���. ����� ������ ������ ����� �������� ����������� ��������������� � ����� ���� ��������� � ���� ��������� ���������. \"��� �� ������ ���� ���������\", - ������ � ����� ��������. ��� ���� �� ����� ������������ � ����� ������� �� ����� ���, � ����� ����� ������� �� ����� �����, ������������ � ���� ����. � ����� �� ����������� ��������� ����� ����� ��������� ���������. ���������� ����������������� ��� \"������\" ��������� �������������� ������������������� �������� ������� ����������� ���������� ��������� � ��������� \"���������\" 20 ������. � ���������� ������� ���� ��� ������������� ���������� ����, � ����� ������������� ��������� ���� ����� � ���� �������� �������������� �� ������� ���������, ������� ��� �������� � ������ ���������� ��� ��� � 2005 ����. �������� �������� �������������� ���������� \"����������� �����\" - ������������������� �����������, ��������� �� ���������� �������������� ���������� � ���������� �������������� ��� �������� ������� ����� �������������, ������������� � �������� ������� ������ � �������. ��������� �����, ��� �������� ��� ����� �� ��������� ������������ �������� ����� ������� �������� � 2006 ����.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (161,461,'���������� Procter & Gamble �� �������� ������������',2,'��������� ��������� ���� ����� ��� � ��� �����������, ��� ��������� ���������� ������������� �������� � ������ �������, ��������� ��������������� � ������� ����� �� �����, �������� Procter & Gamble, �� ����� �������� ��������� � ������ ������. �������� ������� �� ��������� � ���������, ��������� 12 ���, ��������.','��������� ��������� ���� ����� ��� � ��� �����������, ��� ��������� ���������� ������������� �������� � ������ �������, ��������� ��������������� � ������� ����� �� �����, �������� Procter & Gamble, �� ����� �������� ��������� � ������ ������, ����� ���������� The Times. ������� ������ �������������� ��������� � ����� Procter & Gamble � �������������� �������� ������ ������ ������ ����� ���������� ���. �������� ����������� �� ���� ��������� ������ ���������� �� ������������� � P&G �������� Amway Corporation. � 1994 ���� ��� �������������� ��������������, � ������� ������������, ��� ����� ������� P&G ������� �� ������������� �����������. ��� ����������, ��� ��������� ������ ��������� Procter & Gamble 20 ��������� �������� � ���� ���������� ����������� ������. ����� ���, ��� ����� The Times ����� � �������������� �������� Procter & Gamble � ������ ������ ��������� ��� ������, � 1981 ����. ������� ��� ����� �������� ������ ������� ��������, ������� ����������� ����� ����������� ���������� � �������� �������� � ����������� �������� ������ ������. � ���� ������� ������� ��� ����� �� ������������ ��������: \"� ������� �� ���� ������� ��������: �������, ������ � ������; ��� ������ � ��� ����, � �� ������ ����� �� ���������� �����. ������� ��������� � ������ �� ����: � ��� �������� ������� �������\" (���������� �����. ����������. 12 �����). ����� ����, ������������, ��� ���� �������� ������� � �������, � ��������� ����� ������, ��� �� ��� ���������� ����� ����� 666. P&G ����� �������� ���������, ��������, ��� ���������� ����� ������������� ����� ������ ������������ ������. ��� �� ����� ������� �������. ������ ����� ��������� ����� ����� � ���, ��� ��������� P&G , �������� 1 ����� 1994 ���� � ����� ������� ���� �������, ����� ������� ������, ��� ������������ ����� ������� �������� ���� �� ��������� ������ ������ � ���� ����������, ��� ������ ����� ������� ��� �� �������. ����������� P&G ����� �� ��������� � ����������� �������������, ��� ����� �� � ����� ������� �� �������� � ������ ��������� �� �������. � �����, ��� �������� � ��������, ������� ��������� ������� ����� ����������� �� ���� �������������� P&G ���������, �� ������������ ������� P&G ��� ��������� ������ ������� �����.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (162,462,'��������������� ��� �� ������������ ������ ����������� � �����������',2,'��������������� ��� �������� ������������ ������, ���������� �������������� ����, �� ������� ���������� ������� ��� ��������� �� ����������, ����������� ��. ����������� ����� ���� �������� ���������. ���� ��������������� � ����� � ������� ������������ ������ �������, ������������� � ����.','��������������� ��� �������� ������������ ������, ���������� �������������� ����, �� ������� ���������� ������� ��� ��������� �� ����������, ����������� ��. �� ��������� ��� �������, ����������� ����� ���� �������� ���������. � �� �� �����, �� ����, ��� ����� \"� �����������\" �� ������������ ������� �� ��������� �� ���������� ��������, �� ������������� ��������� ������������ �������. ���� ��������������� � ����� � ������� ������������ ������ �������, ������������� � ����, ������� � 2005 ���� ��������� �� ���������� �����������. ����������� ������������ �������� �� 17 ��������, � ��� ����� �� ������ ������ � ����������� �����. � ������ 2005 ���� ������������� ����������, ��� ����������� ������������ �������� �� ������������� ������ \"� ����������� ��\", ��������� �������� ������������ ������� � ���������� ���������� ������������ �����������. ������������ ������ ���� �������� � �����������. ���������� ���������� ������� � ��������� ���, ������� �������� �� ������, � ����� � � ���������������.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (163,463,'Gears of War �������� �� ������� �����������',2,'New Line Cinema ��������� ����� �� �������� ������, ����������� �� Gears of War, ������ ��� ��������� Xbox 360. ����� ���� ������������ � ������ � ����� �������, ���������� ����� �����������, �� ������� Sera. ����������� ����� ������ ������ �����, ����� ���������� ��� �������� \"������ ���������� ����\" � \"����������\".','�������� New Line Cinema ��������� ����� �� �������� ������, ����������� �� ���� Gears of War, ������ ��� ��������� Xbox 360, �������� Reuters. ����������� ����� ������ ������ ����� (Stuart Beattie), ����� ���������� ��� �������� \"������ ���������� ����\" � \"����������\" (Collateral). ��������� ������, ��� ��� ���������� ������� ������� � �������� ���������� Gears of War ��� ��� � ��� ������, ����� �� ����� �� ������� Xbox 360. \"������������� New Line Cinema ����� ���� �������� ��� ��������� ����� ������ Xbox Live. \"�� ����������� �������� �������� � ������ �� ����, � ������� ������ �������?\" - ������� ��\" - ��������� �����. Gears of War - ��������������� ���������� �����, ��������� ��������� Epic Games. ��� ������ �������� ������ ������, ������� ������ � ����� ������� (Locust Horde), ���������� ����� �����������, �� ������� Sera. ����� ����� ���� ����������� ���������� ������ ��� ������ ���������� ���� �������� � ������������ �������������� �������� \"�����\" (Aliens). ���� ��������� � ��������� � ������ 2006 ����. �� ��������� � ������� ������ ����� ���� ������� ����� ���� ��������� ����� ����.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (164,464,'�������� ����� ������� ������ ��� ���������� ��������� ��������',2,'������� ���������, 50-������� ����������� ��������� �������� AarhusKarlshamn, ������������ ������������ �����, ������� � ����� ����� �������� ������ ����������. ��� ����� �������� � ���� ����������� �������� �����. ������ ���� ��������� �� ����� ������� � ��������� CD � DVD-������. ���������� ���������� � 3,5 ����� ������.','������� ���������, 50-������� ����������� ��������� �������� AarhusKarlshamn, ������������ ������������ �����, ������� � ����� ����� �������� ������ ����������. ��� ����� �������� � ���� ����������� �������� �����, �������� The Times. ������� �� ���������� �� ����� ������ �������� ��������� �� ���������� �����, �� ���, �� ������� ���� ����������. ���������� �������� �������� ���������� 848 ����� ������ �� ����� �������, ���������� ������ � ����������, � ����� �� CD/DVD-����� ��� ����� ���������. ������ �������� ������� �������� � 30 ������, ����������� � ������ � 1996 �� 2004 ��� � ���������� � 3,5 ����� ������. ���� ����������� ��������� �������� �� 200 ����� ������������ ����� �� ��������� � ����� ������ �������� ������� �����.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (165,465,'BP ��������� � ���������� �� ������������ ���',2,'����������� �������� �������� BP ��� ���� ������ ������������ ��������� � ����������� ������ �� ��� � ������, ��� � 2005 ���� ��������� �����. �� ������� ���� ���� ���-�������� ������������ ������� ������, ����������������� � ��������� �� ������, ��������� � ������� �������� �� ������������� ���������� ������ � ���.','����������� �������� �������� BP ��� ���� ������ ������������ ��������� � ����������� ������ �� ��� � ������, ��� � 2005 ���� ��������� �����. �� ���� ��������� � ������� �������� �� ������������� ���������� ������ � ��� (Chemical Safety Board). ��� ������� �� 335-����������� ���������, �� ������� ���� ���� ���-�������� ������������ ������� ������, ����������������� � ��������� �� ������. ��� ���� \"������� � ���������� �������������� ������� ����������� ����������� �� ����� ������� ������ � BP, �������� �� ��������� �������� � ������� ������������ ������\". �������� �������� ������� ��� \"�������� ����� �����������\", �������������� � �������. ����� ���, ���������� ���� �������� �������� �� �����. ����� �� ��������������������� ������ � ������ ��������� � ����� 2005 ����. � ���������� ������ ������� 15 �������, ��� ��������� ����� �������� �������. ����� ���� ����� ��������� �� � ����������� ������ � 1990 ����. �� �������� ��� ������� ��������� ����� � ������� 21 �������� ��������. ��� ���������� ���������, ������ ��������� ��-�� ������������� ������������. �������� �� ������������� ���������� ������ ��� �������� ����������� ����������� ����������. ����-�������� ����������� ������������� � ����������. ����� �������� ����������� ����������� ����������� ������ � ������������ �������.',26,1174588083,1174588083);
INSERT INTO `news_news` VALUES (166,466,'����� ����� ������������� ��� ������ ��� �����������',2,'������������ ����� ������������ �� ����������� ����� ������������� ��������� ����������� ���������� ��� ������������ � ��������������. ������������ ��������� ����� ���������� � ������� 120 ���� ����� ������ �����������. ���� �� ����������� �� ����� ���������� �������, ���������� �������� �������� �����.','������������ ����� ������������ �� ����������� ����� ������������� ��������� ����������� ���������� ��� ������������ � ��������������. ��� �������� AP, �������� ������ ������, ������������ ��������� ����� ���������� � ������� 120 ���� ����� ������ ������ �� ��������� �����������. ���� �� ������������ ����������� �� ����� ���������� �������, ��������� �������� �������� �����. �������� ���� �������, �������� ����������, ��� ������������� ���� ��������� ����������, �������� ��� ���� �������� ����� ����������� ��������������� ����. \"���� �� ������������� ��������� ���������� � ���������� ����������, �� ������������� ��� ������������������ �������\", - ���������������� ����� ����������� ����� ������������ �������� ������ ������ ���� (Patrick Leahy). ������������ ������� ������������ ������ ��� ������ ������������ � ������ �������������� ���������. ��������, ��� ������������ ������������ ������������� ������������� ���������� ������ ����������� ����������, ������� ��������� � ����� 2006 ����. ������������ ��������, ��� ��� �������� ���� ����������� ������������.',24,1174588083,1174588083);
INSERT INTO `news_news` VALUES (167,467,'��������� ������������ ������� �� ����� ������� ������� ���������',2,'��������� ������������ ������� �������� ������� ������ ���������� � ���� ������� � ������ ����������� ������� ��������. \"� ����� ��, ����� ���� �������� ������� ��������, �� ����� ��������� ����\", - ������ ��������� � �����. ��������, ��� � ������� � ����������� ���� ������� ����������� �� ����� ���� � �� ����� ������� ���������.','��������� ������������ ������� �������� ������� ������ ���������� � ���� ������� � ������ ����������� ������� ��������. �� ���� ��, ��� �������� ����-���� �������, �������� � ����� ����� �������������� ������ �������� ��������� ������. �� ������ ���������� ����������, �������� \"���������� ��������� � ����� ���������� ������ � ������������ ������������ ����������\". \"��������, � ��������� ����������, � ��� �����, �������������, ��� ��� � ������� �������� ��-�������, - ������� ����� �����������. - ������� � ����� ��, ����� ���� �������� ������� ��������, �� ����� ��������� ����\". ��� ���� ��������� ������� ������������� ������������ �� ������ ��������� ����� �������, �� � �������� ������������ ����, ���������� ������������ ��������. �������, ��� �� ������� ��������� ������ � ��������� ����������� ���� ������� ����������� �� ����� ���� � �� ����� ������� ���������.',22,1174588083,1174588083);
INSERT INTO `news_news` VALUES (168,468,'�� ����������� �������� ��������� ������������ ����������� ������',2,'� ����-����, ������� ��������� ���������� ����������� � ����������� �������, ���������� ������ ��������, ����� ������� ������������ ����������� ������ ������. ����� ����� ���������� �� ���� ������� � ���� ��������� ������������ 8 �����. �� ������ ���� �� ������ � �����, ����� ������� ��������� ����� ��������� � ����.','� ������� ��������� ���������� ����������� � ����������� ������� ����-���� ���������� ������ ��������, ����� ������� ������������ ����������� ������ ������. ������� �������� � ��� �������� ���� ���������� ����������� ������ ����������, ������� ������ ���������� ����, �������� AFP. ���������, ���������� ���������, ���������, ��� �������, �������� �� ����� � �������� ��� ����, ������ ����������� ������� 8 �����. ����� ������������ ������ ����� � ������ ��������, ����� ��������� ����� ����� ��������� ������. ������ ��� ��� �� ������� ����� ��������� �����; � � ��� ������ ����������� ������ ������������ ����� �� ����� � �� ������. ����������� ����� ������ ����� � ����-���� ��������, ����� ������ �������� ������ ������� ������� ������ �������. � ��������� ����� ����� �� ����������, � ������� ��������� �������� ���������� ��� ������������. ������� ������������ ��������� �� ����� ���� ��������� (John Chrysostom - ���������� ������������ ����� ���� ������ IV-V ����� ������ ���������. - ����. Lenta.ru) ������ ������������ � �������� ��������� \"�����\", ����������������� � ���, ��� \"������� ���������� ���� �����\". ���������� � ����������� ������� ������ ���������� �� ����� ��������������� ������, ������������� �� ���-��������� ���� � 2004 ����.',18,1174588083,1174588083);

#
# Table structure for table news_newsfolder
#

CREATE TABLE `news_newsfolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_newsfolder
#

INSERT INTO `news_newsfolder` VALUES (2,6,'root','�������',1,'root');
INSERT INTO `news_newsfolder` VALUES (18,295,'main','�������',17,'root/main');
INSERT INTO `news_newsfolder` VALUES (19,296,'comments','�����������',18,'root/comments');
INSERT INTO `news_newsfolder` VALUES (20,297,'story','������',19,'root/story');
INSERT INTO `news_newsfolder` VALUES (21,298,'russia','� ������',20,'root/russia');
INSERT INTO `news_newsfolder` VALUES (22,299,'xussr','�.����',21,'root/xussr');
INSERT INTO `news_newsfolder` VALUES (23,300,'world','� ����',22,'root/world');
INSERT INTO `news_newsfolder` VALUES (24,301,'america','�������',23,'root/america');
INSERT INTO `news_newsfolder` VALUES (25,302,'economy','���������',24,'root/economy');
INSERT INTO `news_newsfolder` VALUES (26,303,'business','������',25,'root/business');
INSERT INTO `news_newsfolder` VALUES (27,304,'finance','�������',26,'root/finance');
INSERT INTO `news_newsfolder` VALUES (28,305,'realty','������������',27,'root/realty');
INSERT INTO `news_newsfolder` VALUES (29,306,'politic','��������',28,'root/politic');
INSERT INTO `news_newsfolder` VALUES (30,307,'internet','��������',29,'root/internet');
INSERT INTO `news_newsfolder` VALUES (31,308,'tehnology','����������',30,'root/tehnology');

#
# Table structure for table news_newsfolder_tree
#

CREATE TABLE `news_newsfolder_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`),
  KEY `level` (`level`,`lkey`),
  KEY `rkey` (`rkey`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_newsfolder_tree
#

INSERT INTO `news_newsfolder_tree` VALUES (1,1,30,1);
INSERT INTO `news_newsfolder_tree` VALUES (17,2,3,2);
INSERT INTO `news_newsfolder_tree` VALUES (18,4,5,2);
INSERT INTO `news_newsfolder_tree` VALUES (19,6,7,2);
INSERT INTO `news_newsfolder_tree` VALUES (20,8,9,2);
INSERT INTO `news_newsfolder_tree` VALUES (21,10,11,2);
INSERT INTO `news_newsfolder_tree` VALUES (22,12,13,2);
INSERT INTO `news_newsfolder_tree` VALUES (23,14,15,2);
INSERT INTO `news_newsfolder_tree` VALUES (24,16,17,2);
INSERT INTO `news_newsfolder_tree` VALUES (25,18,19,2);
INSERT INTO `news_newsfolder_tree` VALUES (26,20,21,2);
INSERT INTO `news_newsfolder_tree` VALUES (27,22,23,2);
INSERT INTO `news_newsfolder_tree` VALUES (28,24,25,2);
INSERT INTO `news_newsfolder_tree` VALUES (29,26,27,2);
INSERT INTO `news_newsfolder_tree` VALUES (30,28,29,2);

#
# Table structure for table page_page
#

CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `folder_id` int(11) unsigned default NULL,
  `compiled` int(11) default NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=cp1251;

#
# Dumping data for table page_page
#

INSERT INTO `page_page` VALUES (1,9,'main','������ ��������','��� <b>������</b>, ������� <strike>��������</strike><br />\n{load module=\"voting\" section=\"voting\" action=\"viewActual\" name=\"simple\"}\n',1,1);
INSERT INTO `page_page` VALUES (2,10,'404','404 Not Found','������������� �������� �� �������!',1,NULL);
INSERT INTO `page_page` VALUES (3,11,'test','test','test',1,NULL);
INSERT INTO `page_page` VALUES (4,57,'403','������ ��������','������ ��������',1,NULL);
INSERT INTO `page_page` VALUES (5,164,'pagename','123','234',2,NULL);
INSERT INTO `page_page` VALUES (6,165,'asd','qwe','asd',2,NULL);
INSERT INTO `page_page` VALUES (7,166,'12345','1','qwe',2,NULL);
INSERT INTO `page_page` VALUES (8,167,'1236','2','asd',2,NULL);
INSERT INTO `page_page` VALUES (9,168,'1237','3','qwe',2,NULL);
INSERT INTO `page_page` VALUES (10,169,'1234','ffffff','f',2,NULL);
INSERT INTO `page_page` VALUES (11,170,'ss','���','sdaf',2,NULL);

#
# Table structure for table page_pagefolder
#

CREATE TABLE `page_pagefolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table page_pagefolder
#

INSERT INTO `page_pagefolder` VALUES (1,161,'root','/',1,'root');
INSERT INTO `page_pagefolder` VALUES (2,163,'foo','foo',2,'root/foo');
INSERT INTO `page_pagefolder` VALUES (3,234,'zz','zz',3,'root/foo/zz');

#
# Table structure for table page_pagefolder_tree
#

CREATE TABLE `page_pagefolder_tree` (
  `id` int(10) NOT NULL auto_increment,
  `lkey` int(10) NOT NULL default '0',
  `rkey` int(10) NOT NULL default '0',
  `level` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `left_key` (`lkey`,`rkey`,`level`),
  KEY `level` (`level`,`lkey`),
  KEY `rkey` (`rkey`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table page_pagefolder_tree
#

INSERT INTO `page_pagefolder_tree` VALUES (1,1,6,1);
INSERT INTO `page_pagefolder_tree` VALUES (2,2,5,2);
INSERT INTO `page_pagefolder_tree` VALUES (3,3,4,3);

#
# Table structure for table sys_access
#

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
) ENGINE=MyISAM AUTO_INCREMENT=4999 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_access
#

INSERT INTO `sys_access` VALUES (428,3,5,19,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (429,3,5,19,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (436,4,2,6,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (437,5,2,6,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (438,6,2,6,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (439,7,2,6,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (440,8,2,6,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (441,9,2,6,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (442,10,3,12,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (462,5,6,9,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (463,4,6,9,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (467,3,6,9,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (468,5,6,9,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (469,4,6,9,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (470,1,6,9,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (471,2,6,9,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (472,9,6,9,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (480,3,6,10,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (481,5,6,10,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (482,4,6,10,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (483,1,6,10,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (484,2,6,10,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (485,9,6,10,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (486,3,6,10,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (487,5,6,10,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (488,4,6,10,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (489,1,6,10,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (490,2,6,10,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (491,9,6,10,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (499,3,6,11,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (500,5,6,11,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (501,4,6,11,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (502,1,6,11,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (503,2,6,11,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (504,9,6,11,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (505,3,6,11,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (506,5,6,11,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (507,4,6,11,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (508,1,6,11,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (509,2,6,11,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (510,9,6,11,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (533,10,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (534,11,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (535,5,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (536,1,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (537,12,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (538,2,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (539,9,3,55,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (540,10,3,55,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (541,11,3,55,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (542,5,3,55,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (543,1,3,55,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (544,12,3,55,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (545,2,3,55,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (546,9,3,55,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (548,14,4,56,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (549,15,4,56,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (550,16,4,56,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (551,17,4,56,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (552,13,4,56,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (553,9,4,56,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (555,14,4,15,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (556,15,4,15,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (557,16,4,15,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (558,17,4,15,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (559,13,4,15,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (560,9,4,15,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (562,14,4,14,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (563,15,4,14,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (564,16,4,14,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (565,17,4,14,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (566,13,4,14,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (567,9,4,14,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (569,3,6,57,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (570,5,6,57,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (571,4,6,57,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (572,1,6,57,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (573,2,6,57,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (574,9,6,57,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (590,1,1,60,1,NULL,0,1);
INSERT INTO `sys_access` VALUES (591,1,1,60,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (592,2,1,60,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (593,2,1,60,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (594,3,1,60,1,NULL,0,1);
INSERT INTO `sys_access` VALUES (595,3,1,60,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (596,9,1,60,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (597,9,1,60,1,NULL,0,1);
INSERT INTO `sys_access` VALUES (598,9,1,60,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (599,4,2,61,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (600,4,2,61,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (601,4,2,61,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (602,5,2,61,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (603,5,2,61,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (604,5,2,61,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (605,6,2,61,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (606,6,2,61,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (607,6,2,61,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (608,7,2,61,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (609,7,2,61,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (610,7,2,61,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (611,8,2,61,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (612,8,2,61,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (613,8,2,61,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (614,9,2,61,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (615,9,2,61,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (616,9,2,61,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (629,9,7,62,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (630,18,7,62,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (637,3,6,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (638,5,6,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (639,4,6,0,0,NULL,0,1);
INSERT INTO `sys_access` VALUES (640,1,6,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (641,2,6,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (642,9,6,0,0,NULL,0,1);
INSERT INTO `sys_access` VALUES (646,3,5,65,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (647,9,5,65,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (684,3,5,65,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (685,9,5,65,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (686,3,5,65,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (687,9,5,65,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (697,10,3,12,2,NULL,0,1);
INSERT INTO `sys_access` VALUES (698,11,3,12,2,NULL,0,1);
INSERT INTO `sys_access` VALUES (699,5,3,12,2,NULL,0,1);
INSERT INTO `sys_access` VALUES (700,1,3,12,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (701,12,3,12,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (702,2,3,12,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (703,9,3,12,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (729,9,7,71,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (730,18,7,71,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (732,5,11,76,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (733,9,11,76,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (776,5,11,93,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (777,5,11,93,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (778,9,11,93,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (779,9,11,93,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (781,1,10,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (782,2,10,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (783,9,10,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (784,18,7,95,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (788,5,11,96,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (789,5,11,96,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (790,19,11,96,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (791,9,11,96,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (792,9,11,96,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (801,1,10,99,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (802,2,10,99,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (803,9,10,99,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (804,1,10,100,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (805,2,10,100,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (806,9,10,100,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (807,1,10,101,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (808,2,10,101,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (809,9,10,101,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (810,5,11,102,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (811,5,11,102,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (812,19,11,102,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (813,9,11,102,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (814,9,11,102,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (880,5,11,0,0,NULL,0,0);
INSERT INTO `sys_access` VALUES (881,19,11,0,0,NULL,0,0);
INSERT INTO `sys_access` VALUES (882,9,11,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (883,5,11,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (884,19,11,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (885,9,11,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (886,5,11,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (887,19,11,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (888,9,11,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (889,5,11,103,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (890,19,11,103,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (891,9,11,103,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (895,5,11,103,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (896,19,11,103,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (897,9,11,103,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (898,5,11,98,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (899,19,11,98,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (900,9,11,98,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (901,5,11,98,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (902,19,11,98,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (903,9,11,98,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (904,5,11,98,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (905,19,11,98,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (906,9,11,98,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (919,1,10,107,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (920,2,10,107,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (921,9,10,107,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (922,1,10,108,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (923,2,10,108,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (924,9,10,108,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (950,5,11,103,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (951,19,11,103,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (952,9,11,103,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (958,9,7,95,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (961,5,11,124,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (964,19,11,124,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (967,9,11,124,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (968,5,11,124,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (969,19,11,124,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (970,9,11,124,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (971,5,11,124,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (972,19,11,124,NULL,2,0,1);
INSERT INTO `sys_access` VALUES (973,9,11,124,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (974,5,11,127,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (975,5,11,127,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (976,5,11,127,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (977,19,11,127,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (978,19,11,127,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (979,19,11,127,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (980,9,11,127,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (981,9,11,127,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (982,9,11,127,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (983,10,3,12,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (984,11,3,12,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (985,5,3,12,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (986,1,3,12,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (987,12,3,12,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (988,2,3,12,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (989,9,3,12,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (990,10,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (991,11,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (992,5,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (993,1,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (994,12,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (995,2,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (996,9,3,13,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1033,5,11,134,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1034,5,11,134,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1035,5,11,134,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1036,19,11,134,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1037,19,11,134,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1038,19,11,134,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1039,9,11,134,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1040,9,11,134,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1041,9,11,134,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1042,1,10,135,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1043,2,10,135,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1044,9,10,135,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1080,5,11,145,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1081,5,11,145,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1082,5,11,145,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1083,19,11,145,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1084,19,11,145,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1085,19,11,145,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1086,9,11,145,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1087,9,11,145,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1088,9,11,145,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1107,10,3,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1108,11,3,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1109,5,3,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1110,1,3,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1111,12,3,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1112,2,3,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1113,9,3,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1121,10,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1122,11,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1123,5,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1124,1,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1125,12,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1126,2,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1127,9,3,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1128,10,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1129,11,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1130,5,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1131,1,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1132,12,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1133,2,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1134,9,3,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1142,9,7,72,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1143,18,7,72,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1144,20,7,72,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1145,9,7,64,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1146,18,7,64,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1147,20,7,64,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1148,9,7,94,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1149,18,7,94,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1150,20,7,94,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1223,4,2,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1224,5,2,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1225,6,2,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1226,7,2,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1227,8,2,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1228,9,2,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1342,4,13,161,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1343,5,13,161,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1344,6,13,161,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1345,7,13,161,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1346,9,13,161,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1347,4,13,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1348,5,13,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1349,6,13,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1350,7,13,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1351,9,13,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1352,4,13,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1353,5,13,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1354,6,13,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1355,7,13,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1356,9,13,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1357,9,13,163,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1358,9,13,163,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1359,7,13,163,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1360,7,13,163,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1361,6,13,163,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1362,6,13,163,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1363,4,13,163,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1364,4,13,163,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1365,5,13,163,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1366,5,13,163,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1367,3,6,164,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1368,9,6,164,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1369,4,6,164,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1370,1,6,164,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1371,2,6,164,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1372,3,6,165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1373,9,6,165,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1374,4,6,165,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1375,1,6,165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1376,2,6,165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1377,3,6,166,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1378,9,6,166,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1379,4,6,166,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1380,1,6,166,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1381,2,6,166,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1382,3,6,167,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1383,9,6,167,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1384,4,6,167,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1385,1,6,167,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1386,2,6,167,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1387,3,6,168,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1388,9,6,168,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1389,4,6,168,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1390,1,6,168,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1391,2,6,168,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1392,3,6,169,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1393,9,6,169,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1394,4,6,169,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1395,1,6,169,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1396,2,6,169,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1397,3,6,170,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1398,9,6,170,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1399,4,6,170,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (1400,1,6,170,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1401,2,6,170,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1402,5,11,171,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1403,5,11,171,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1404,5,11,171,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1405,19,11,171,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1406,19,11,171,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1407,19,11,171,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1408,9,11,171,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1409,9,11,171,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1410,9,11,171,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1411,5,11,172,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1412,5,11,172,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1413,5,11,172,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1414,19,11,172,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1415,19,11,172,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1416,19,11,172,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1417,9,11,172,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1418,9,11,172,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1419,9,11,172,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1420,5,11,173,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1421,5,11,173,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1422,5,11,173,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1423,19,11,173,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1424,19,11,173,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1425,19,11,173,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1426,9,11,173,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1427,9,11,173,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1428,9,11,173,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1429,5,11,174,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1430,5,11,174,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1431,5,11,174,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1432,19,11,174,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1433,19,11,174,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1434,19,11,174,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1435,9,11,174,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1436,9,11,174,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1437,9,11,174,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1438,5,11,175,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1439,5,11,175,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1440,5,11,175,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1441,19,11,175,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1442,19,11,175,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1443,19,11,175,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1444,9,11,175,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1445,9,11,175,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1446,9,11,175,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1447,3,9,69,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1448,20,9,69,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1449,21,9,69,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1450,9,9,69,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1451,19,11,177,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1452,5,11,177,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1453,9,11,177,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1454,9,11,177,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1455,19,11,177,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1456,5,11,177,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1457,9,11,177,1,NULL,1,0);
INSERT INTO `sys_access` VALUES (1458,19,11,177,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1459,5,11,177,1,NULL,0,0);
INSERT INTO `sys_access` VALUES (1582,4,2,6,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1583,5,2,6,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1584,6,2,6,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1585,7,2,6,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1586,30,2,6,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1587,8,2,6,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1588,9,2,6,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1589,4,13,234,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1590,5,13,234,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1591,6,13,234,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1592,7,13,234,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1593,9,13,234,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1594,4,13,234,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1595,5,13,234,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1596,6,13,234,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1597,7,13,234,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1598,9,13,234,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (1929,3,1,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1930,1,1,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1931,29,1,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1932,2,1,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1933,9,1,0,0,NULL,0,0);
INSERT INTO `sys_access` VALUES (1951,4,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1952,5,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1953,6,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1954,7,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1955,30,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1956,8,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1957,9,2,0,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1965,4,2,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1966,5,2,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1967,6,2,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1968,7,2,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1969,30,2,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1970,8,2,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1971,9,2,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1972,4,2,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1973,5,2,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1974,6,2,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1975,7,2,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1976,30,2,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1977,8,2,0,0,NULL,1,0);
INSERT INTO `sys_access` VALUES (1978,9,2,0,0,NULL,0,0);
INSERT INTO `sys_access` VALUES (1979,3,1,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1980,1,1,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1981,29,1,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1982,2,1,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1983,9,1,0,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1984,9,2,295,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1985,8,2,295,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1986,7,2,295,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1987,6,2,295,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1988,5,2,295,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (1989,4,2,295,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (1990,9,2,295,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1991,8,2,295,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1992,30,2,295,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1993,7,2,295,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1994,6,2,295,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (1995,5,2,295,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1996,4,2,295,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (1997,9,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1998,8,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (1999,30,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2000,7,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2001,6,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2002,5,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2003,4,2,295,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2004,8,2,295,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2005,30,2,295,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2006,7,2,295,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2007,6,2,295,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2008,5,2,295,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2009,4,2,295,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2010,9,2,295,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2011,9,2,296,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2012,8,2,296,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2013,7,2,296,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2014,6,2,296,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2015,5,2,296,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2016,4,2,296,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2017,9,2,296,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2018,8,2,296,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2019,30,2,296,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2020,7,2,296,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2021,6,2,296,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2022,5,2,296,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2023,4,2,296,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2024,9,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2025,8,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2026,30,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2027,7,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2028,6,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2029,5,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2030,4,2,296,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2031,8,2,296,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2032,30,2,296,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2033,7,2,296,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2034,6,2,296,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2035,5,2,296,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2036,4,2,296,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2037,9,2,296,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2038,9,2,297,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2039,8,2,297,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2040,7,2,297,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2041,6,2,297,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2042,5,2,297,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2043,4,2,297,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2044,9,2,297,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2045,8,2,297,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2046,30,2,297,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2047,7,2,297,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2048,6,2,297,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2049,5,2,297,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2050,4,2,297,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2051,9,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2052,8,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2053,30,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2054,7,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2055,6,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2056,5,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2057,4,2,297,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2058,8,2,297,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2059,30,2,297,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2060,7,2,297,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2061,6,2,297,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2062,5,2,297,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2063,4,2,297,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2064,9,2,297,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2065,9,2,298,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2066,8,2,298,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2067,7,2,298,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2068,6,2,298,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2069,5,2,298,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2070,4,2,298,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2071,9,2,298,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2072,8,2,298,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2073,30,2,298,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2074,7,2,298,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2075,6,2,298,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2076,5,2,298,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2077,4,2,298,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2078,9,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2079,8,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2080,30,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2081,7,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2082,6,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2083,5,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2084,4,2,298,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2085,8,2,298,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2086,30,2,298,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2087,7,2,298,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2088,6,2,298,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2089,5,2,298,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2090,4,2,298,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2091,9,2,298,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2092,9,2,299,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2093,8,2,299,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2094,7,2,299,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2095,6,2,299,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2096,5,2,299,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2097,4,2,299,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2098,9,2,299,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2099,8,2,299,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2100,30,2,299,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2101,7,2,299,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2102,6,2,299,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2103,5,2,299,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2104,4,2,299,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2105,9,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2106,8,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2107,30,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2108,7,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2109,6,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2110,5,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2111,4,2,299,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2112,8,2,299,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2113,30,2,299,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2114,7,2,299,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2115,6,2,299,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2116,5,2,299,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2117,4,2,299,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2118,9,2,299,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2119,9,2,300,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2120,8,2,300,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2121,7,2,300,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2122,6,2,300,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2123,5,2,300,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2124,4,2,300,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2125,9,2,300,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2126,8,2,300,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2127,30,2,300,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2128,7,2,300,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2129,6,2,300,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2130,5,2,300,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2131,4,2,300,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2132,9,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2133,8,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2134,30,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2135,7,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2136,6,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2137,5,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2138,4,2,300,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2139,8,2,300,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2140,30,2,300,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2141,7,2,300,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2142,6,2,300,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2143,5,2,300,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2144,4,2,300,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2145,9,2,300,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2146,9,2,301,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2147,8,2,301,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2148,7,2,301,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2149,6,2,301,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2150,5,2,301,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2151,4,2,301,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2152,9,2,301,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2153,8,2,301,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2154,30,2,301,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2155,7,2,301,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2156,6,2,301,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2157,5,2,301,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2158,4,2,301,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2159,9,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2160,8,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2161,30,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2162,7,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2163,6,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2164,5,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2165,4,2,301,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2166,8,2,301,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2167,30,2,301,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2168,7,2,301,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2169,6,2,301,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2170,5,2,301,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2171,4,2,301,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2172,9,2,301,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2173,9,2,302,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2174,8,2,302,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2175,7,2,302,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2176,6,2,302,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2177,5,2,302,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2178,4,2,302,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2179,9,2,302,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2180,8,2,302,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2181,30,2,302,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2182,7,2,302,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2183,6,2,302,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2184,5,2,302,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2185,4,2,302,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2186,9,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2187,8,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2188,30,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2189,7,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2190,6,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2191,5,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2192,4,2,302,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2193,8,2,302,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2194,30,2,302,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2195,7,2,302,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2196,6,2,302,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2197,5,2,302,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2198,4,2,302,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2199,9,2,302,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2200,9,2,303,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2201,8,2,303,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2202,7,2,303,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2203,6,2,303,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2204,5,2,303,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2205,4,2,303,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2206,9,2,303,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2207,8,2,303,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2208,30,2,303,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2209,7,2,303,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2210,6,2,303,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2211,5,2,303,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2212,4,2,303,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2213,9,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2214,8,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2215,30,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2216,7,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2217,6,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2218,5,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2219,4,2,303,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2220,8,2,303,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2221,30,2,303,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2222,7,2,303,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2223,6,2,303,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2224,5,2,303,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2225,4,2,303,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2226,9,2,303,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2227,9,2,304,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2228,8,2,304,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2229,7,2,304,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2230,6,2,304,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2231,5,2,304,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2232,4,2,304,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2233,9,2,304,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2234,8,2,304,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2235,30,2,304,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2236,7,2,304,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2237,6,2,304,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2238,5,2,304,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2239,4,2,304,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2240,9,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2241,8,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2242,30,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2243,7,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2244,6,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2245,5,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2246,4,2,304,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2247,8,2,304,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2248,30,2,304,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2249,7,2,304,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2250,6,2,304,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2251,5,2,304,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2252,4,2,304,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2253,9,2,304,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2254,9,2,305,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2255,8,2,305,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2256,7,2,305,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2257,6,2,305,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2258,5,2,305,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2259,4,2,305,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2260,9,2,305,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2261,8,2,305,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2262,30,2,305,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2263,7,2,305,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2264,6,2,305,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2265,5,2,305,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2266,4,2,305,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2267,9,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2268,8,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2269,30,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2270,7,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2271,6,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2272,5,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2273,4,2,305,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2274,8,2,305,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2275,30,2,305,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2276,7,2,305,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2277,6,2,305,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2278,5,2,305,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2279,4,2,305,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2280,9,2,305,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2281,9,2,306,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2282,8,2,306,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2283,7,2,306,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2284,6,2,306,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2285,5,2,306,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2286,4,2,306,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2287,9,2,306,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2288,8,2,306,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2289,30,2,306,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2290,7,2,306,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2291,6,2,306,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2292,5,2,306,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2293,4,2,306,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2294,9,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2295,8,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2296,30,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2297,7,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2298,6,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2299,5,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2300,4,2,306,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2301,8,2,306,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2302,30,2,306,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2303,7,2,306,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2304,6,2,306,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2305,5,2,306,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2306,4,2,306,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2307,9,2,306,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2308,9,2,307,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2309,8,2,307,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2310,7,2,307,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2311,6,2,307,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2312,5,2,307,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2313,4,2,307,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2314,9,2,307,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2315,8,2,307,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2316,30,2,307,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2317,7,2,307,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2318,6,2,307,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2319,5,2,307,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2320,4,2,307,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2321,9,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2322,8,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2323,30,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2324,7,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2325,6,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2326,5,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2327,4,2,307,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2328,8,2,307,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2329,30,2,307,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2330,7,2,307,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2331,6,2,307,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2332,5,2,307,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2333,4,2,307,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2334,9,2,307,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2335,9,2,308,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2336,8,2,308,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2337,7,2,308,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2338,6,2,308,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2339,5,2,308,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2340,4,2,308,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2341,9,2,308,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2342,8,2,308,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2343,30,2,308,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2344,7,2,308,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2345,6,2,308,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (2346,5,2,308,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2347,4,2,308,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2348,9,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2349,8,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2350,30,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2351,7,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2352,6,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2353,5,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2354,4,2,308,NULL,3,1,0);
INSERT INTO `sys_access` VALUES (2355,8,2,308,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2356,30,2,308,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2357,7,2,308,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2358,6,2,308,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2359,5,2,308,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2360,4,2,308,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2361,9,2,308,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2362,29,1,309,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2363,1,1,309,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2364,3,1,309,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2365,9,1,309,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2366,2,1,309,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2367,9,1,309,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2368,2,1,309,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2369,29,1,309,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2370,1,1,309,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2371,3,1,309,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2372,2,1,309,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2373,29,1,309,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2374,1,1,309,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2375,9,1,309,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2376,3,1,309,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2377,29,1,310,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2378,1,1,310,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2379,3,1,310,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2380,9,1,310,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2381,2,1,310,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2382,9,1,310,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2383,2,1,310,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2384,29,1,310,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2385,1,1,310,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2386,3,1,310,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2387,2,1,310,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2388,29,1,310,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2389,1,1,310,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2390,9,1,310,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2391,3,1,310,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2392,29,1,311,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2393,1,1,311,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2394,3,1,311,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2395,9,1,311,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2396,2,1,311,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2397,9,1,311,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2398,2,1,311,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2399,29,1,311,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2400,1,1,311,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2401,3,1,311,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2402,2,1,311,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2403,29,1,311,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2404,1,1,311,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2405,9,1,311,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2406,3,1,311,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2407,29,1,312,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2408,1,1,312,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2409,3,1,312,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2410,9,1,312,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2411,2,1,312,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2412,9,1,312,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2413,2,1,312,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2414,29,1,312,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2415,1,1,312,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2416,3,1,312,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2417,2,1,312,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2418,29,1,312,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2419,1,1,312,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2420,9,1,312,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2421,3,1,312,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2422,29,1,313,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2423,1,1,313,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2424,3,1,313,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2425,9,1,313,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2426,2,1,313,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2427,9,1,313,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2428,2,1,313,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2429,29,1,313,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2430,1,1,313,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2431,3,1,313,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2432,2,1,313,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2433,29,1,313,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2434,1,1,313,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2435,9,1,313,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2436,3,1,313,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2437,29,1,314,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2438,1,1,314,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2439,3,1,314,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2440,9,1,314,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2441,2,1,314,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2442,9,1,314,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2443,2,1,314,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2444,29,1,314,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2445,1,1,314,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2446,3,1,314,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2447,2,1,314,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2448,29,1,314,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2449,1,1,314,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2450,9,1,314,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2451,3,1,314,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2452,29,1,315,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2453,1,1,315,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2454,3,1,315,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2455,9,1,315,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2456,2,1,315,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2457,9,1,315,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2458,2,1,315,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2459,29,1,315,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2460,1,1,315,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2461,3,1,315,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2462,2,1,315,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2463,29,1,315,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2464,1,1,315,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2465,9,1,315,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2466,3,1,315,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2467,29,1,316,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2468,1,1,316,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2469,3,1,316,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2470,9,1,316,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2471,2,1,316,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2472,9,1,316,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2473,2,1,316,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2474,29,1,316,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2475,1,1,316,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2476,3,1,316,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2477,2,1,316,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2478,29,1,316,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2479,1,1,316,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2480,9,1,316,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2481,3,1,316,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2482,29,1,317,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2483,1,1,317,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2484,3,1,317,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2485,9,1,317,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2486,2,1,317,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2487,9,1,317,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2488,2,1,317,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2489,29,1,317,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2490,1,1,317,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2491,3,1,317,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2492,2,1,317,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2493,29,1,317,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2494,1,1,317,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2495,9,1,317,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2496,3,1,317,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2497,29,1,318,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2498,1,1,318,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2499,3,1,318,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2500,9,1,318,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2501,2,1,318,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2502,9,1,318,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2503,2,1,318,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2504,29,1,318,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2505,1,1,318,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2506,3,1,318,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2507,2,1,318,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2508,29,1,318,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2509,1,1,318,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2510,9,1,318,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2511,3,1,318,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2512,29,1,319,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2513,1,1,319,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2514,3,1,319,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2515,9,1,319,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2516,2,1,319,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2517,9,1,319,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2518,2,1,319,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2519,29,1,319,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2520,1,1,319,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2521,3,1,319,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2522,2,1,319,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2523,29,1,319,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2524,1,1,319,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2525,9,1,319,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2526,3,1,319,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2527,29,1,320,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2528,1,1,320,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2529,3,1,320,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2530,9,1,320,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2531,2,1,320,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2532,9,1,320,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2533,2,1,320,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2534,29,1,320,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2535,1,1,320,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2536,3,1,320,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2537,2,1,320,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2538,29,1,320,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2539,1,1,320,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2540,9,1,320,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2541,3,1,320,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2542,29,1,321,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2543,1,1,321,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2544,3,1,321,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2545,9,1,321,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2546,2,1,321,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2547,9,1,321,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2548,2,1,321,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2549,29,1,321,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2550,1,1,321,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2551,3,1,321,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2552,2,1,321,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2553,29,1,321,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2554,1,1,321,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2555,9,1,321,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2556,3,1,321,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2557,29,1,322,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2558,1,1,322,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2559,3,1,322,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2560,9,1,322,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2561,2,1,322,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2562,9,1,322,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2563,2,1,322,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2564,29,1,322,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2565,1,1,322,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2566,3,1,322,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2567,2,1,322,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2568,29,1,322,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2569,1,1,322,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2570,9,1,322,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2571,3,1,322,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2572,29,1,323,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2573,1,1,323,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2574,3,1,323,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2575,9,1,323,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2576,2,1,323,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2577,9,1,323,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2578,2,1,323,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2579,29,1,323,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2580,1,1,323,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2581,3,1,323,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2582,2,1,323,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2583,29,1,323,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2584,1,1,323,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2585,9,1,323,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2586,3,1,323,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2587,29,1,324,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2588,1,1,324,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2589,3,1,324,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2590,9,1,324,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2591,2,1,324,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2592,9,1,324,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2593,2,1,324,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2594,29,1,324,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2595,1,1,324,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2596,3,1,324,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2597,2,1,324,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2598,29,1,324,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2599,1,1,324,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2600,9,1,324,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2601,3,1,324,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2602,29,1,325,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2603,1,1,325,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2604,3,1,325,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2605,9,1,325,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2606,2,1,325,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2607,9,1,325,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2608,2,1,325,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2609,29,1,325,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2610,1,1,325,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2611,3,1,325,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2612,2,1,325,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2613,29,1,325,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2614,1,1,325,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2615,9,1,325,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2616,3,1,325,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2617,29,1,326,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2618,1,1,326,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2619,3,1,326,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2620,9,1,326,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2621,2,1,326,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2622,9,1,326,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2623,2,1,326,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2624,29,1,326,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2625,1,1,326,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2626,3,1,326,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2627,2,1,326,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2628,29,1,326,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2629,1,1,326,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2630,9,1,326,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2631,3,1,326,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2632,29,1,327,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2633,1,1,327,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2634,3,1,327,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2635,9,1,327,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2636,2,1,327,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2637,9,1,327,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2638,2,1,327,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2639,29,1,327,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2640,1,1,327,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2641,3,1,327,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2642,2,1,327,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2643,29,1,327,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2644,1,1,327,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2645,9,1,327,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2646,3,1,327,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2647,29,1,328,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2648,1,1,328,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2649,3,1,328,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2650,9,1,328,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2651,2,1,328,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2652,9,1,328,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2653,2,1,328,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2654,29,1,328,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2655,1,1,328,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2656,3,1,328,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2657,2,1,328,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2658,29,1,328,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2659,1,1,328,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2660,9,1,328,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2661,3,1,328,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2662,29,1,329,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2663,1,1,329,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2664,3,1,329,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2665,9,1,329,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2666,2,1,329,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2667,9,1,329,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2668,2,1,329,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2669,29,1,329,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2670,1,1,329,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2671,3,1,329,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2672,2,1,329,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2673,29,1,329,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2674,1,1,329,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2675,9,1,329,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2676,3,1,329,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2677,29,1,330,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2678,1,1,330,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2679,3,1,330,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2680,9,1,330,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2681,2,1,330,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2682,9,1,330,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2683,2,1,330,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2684,29,1,330,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2685,1,1,330,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2686,3,1,330,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2687,2,1,330,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2688,29,1,330,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2689,1,1,330,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2690,9,1,330,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2691,3,1,330,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2692,29,1,331,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2693,1,1,331,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2694,3,1,331,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2695,9,1,331,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2696,2,1,331,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2697,9,1,331,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2698,2,1,331,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2699,29,1,331,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2700,1,1,331,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2701,3,1,331,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2702,2,1,331,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2703,29,1,331,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2704,1,1,331,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2705,9,1,331,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2706,3,1,331,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2707,29,1,332,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2708,1,1,332,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2709,3,1,332,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2710,9,1,332,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2711,2,1,332,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2712,9,1,332,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2713,2,1,332,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2714,29,1,332,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2715,1,1,332,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2716,3,1,332,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2717,2,1,332,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2718,29,1,332,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2719,1,1,332,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2720,9,1,332,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2721,3,1,332,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2722,29,1,333,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2723,1,1,333,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2724,3,1,333,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2725,9,1,333,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2726,2,1,333,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2727,9,1,333,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2728,2,1,333,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2729,29,1,333,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2730,1,1,333,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2731,3,1,333,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2732,2,1,333,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2733,29,1,333,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2734,1,1,333,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2735,9,1,333,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2736,3,1,333,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2737,29,1,334,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2738,1,1,334,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2739,3,1,334,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2740,9,1,334,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2741,2,1,334,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2742,9,1,334,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2743,2,1,334,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2744,29,1,334,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2745,1,1,334,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2746,3,1,334,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2747,2,1,334,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2748,29,1,334,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2749,1,1,334,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2750,9,1,334,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2751,3,1,334,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2752,29,1,335,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2753,1,1,335,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2754,3,1,335,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2755,9,1,335,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2756,2,1,335,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2757,9,1,335,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2758,2,1,335,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2759,29,1,335,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2760,1,1,335,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2761,3,1,335,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2762,2,1,335,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2763,29,1,335,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2764,1,1,335,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2765,9,1,335,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2766,3,1,335,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2767,29,1,336,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2768,1,1,336,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2769,3,1,336,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2770,9,1,336,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2771,2,1,336,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2772,9,1,336,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2773,2,1,336,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2774,29,1,336,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2775,1,1,336,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2776,3,1,336,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2777,2,1,336,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2778,29,1,336,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2779,1,1,336,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2780,9,1,336,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2781,3,1,336,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2782,29,1,337,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2783,1,1,337,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2784,3,1,337,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2785,9,1,337,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2786,2,1,337,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2787,9,1,337,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2788,2,1,337,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2789,29,1,337,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2790,1,1,337,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2791,3,1,337,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2792,2,1,337,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2793,29,1,337,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2794,1,1,337,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2795,9,1,337,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2796,3,1,337,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2797,29,1,338,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2798,1,1,338,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2799,3,1,338,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2800,9,1,338,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2801,2,1,338,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2802,9,1,338,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2803,2,1,338,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2804,29,1,338,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2805,1,1,338,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2806,3,1,338,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2807,2,1,338,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2808,29,1,338,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2809,1,1,338,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2810,9,1,338,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2811,3,1,338,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2812,29,1,339,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2813,1,1,339,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2814,3,1,339,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2815,9,1,339,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2816,2,1,339,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2817,9,1,339,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2818,2,1,339,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2819,29,1,339,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2820,1,1,339,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2821,3,1,339,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2822,2,1,339,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2823,29,1,339,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2824,1,1,339,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2825,9,1,339,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2826,3,1,339,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2827,29,1,340,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2828,1,1,340,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2829,3,1,340,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2830,9,1,340,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2831,2,1,340,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2832,9,1,340,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2833,2,1,340,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2834,29,1,340,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2835,1,1,340,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2836,3,1,340,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2837,2,1,340,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2838,29,1,340,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2839,1,1,340,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2840,9,1,340,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2841,3,1,340,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2842,29,1,341,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2843,1,1,341,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2844,3,1,341,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2845,9,1,341,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2846,2,1,341,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2847,9,1,341,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2848,2,1,341,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2849,29,1,341,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2850,1,1,341,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2851,3,1,341,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2852,2,1,341,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2853,29,1,341,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2854,1,1,341,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2855,9,1,341,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2856,3,1,341,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2857,29,1,342,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2858,1,1,342,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2859,3,1,342,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2860,9,1,342,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2861,2,1,342,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2862,9,1,342,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2863,2,1,342,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2864,29,1,342,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2865,1,1,342,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2866,3,1,342,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2867,2,1,342,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2868,29,1,342,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2869,1,1,342,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2870,9,1,342,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2871,3,1,342,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2872,29,1,343,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2873,1,1,343,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2874,3,1,343,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2875,9,1,343,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2876,2,1,343,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2877,9,1,343,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2878,2,1,343,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2879,29,1,343,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2880,1,1,343,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2881,3,1,343,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2882,2,1,343,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2883,29,1,343,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2884,1,1,343,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2885,9,1,343,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2886,3,1,343,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2902,29,1,345,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2903,1,1,345,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2904,3,1,345,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2905,9,1,345,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2906,2,1,345,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2907,9,1,345,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2908,2,1,345,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2909,29,1,345,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2910,1,1,345,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2911,3,1,345,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2912,2,1,345,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2913,29,1,345,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2914,1,1,345,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2915,9,1,345,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2916,3,1,345,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2917,29,1,346,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2918,1,1,346,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2919,3,1,346,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2920,9,1,346,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2921,2,1,346,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2922,9,1,346,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2923,2,1,346,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2924,29,1,346,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2925,1,1,346,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2926,3,1,346,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2927,2,1,346,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2928,29,1,346,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2929,1,1,346,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2930,9,1,346,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2931,3,1,346,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2932,29,1,347,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2933,1,1,347,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2934,3,1,347,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2935,9,1,347,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2936,2,1,347,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2937,9,1,347,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2938,2,1,347,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2939,29,1,347,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2940,1,1,347,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2941,3,1,347,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2942,2,1,347,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2943,29,1,347,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2944,1,1,347,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2945,9,1,347,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2946,3,1,347,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2947,29,1,348,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2948,1,1,348,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2949,3,1,348,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2950,9,1,348,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2951,2,1,348,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2952,9,1,348,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2953,2,1,348,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2954,29,1,348,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2955,1,1,348,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2956,3,1,348,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2957,2,1,348,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2958,29,1,348,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2959,1,1,348,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2960,9,1,348,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2961,3,1,348,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2962,29,1,349,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2963,1,1,349,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2964,3,1,349,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2965,9,1,349,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2966,2,1,349,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2967,9,1,349,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2968,2,1,349,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2969,29,1,349,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2970,1,1,349,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2971,3,1,349,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2972,2,1,349,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2973,29,1,349,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2974,1,1,349,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2975,9,1,349,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2976,3,1,349,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2977,29,1,350,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2978,1,1,350,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2979,3,1,350,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2980,9,1,350,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2981,2,1,350,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2982,9,1,350,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2983,2,1,350,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2984,29,1,350,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2985,1,1,350,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2986,3,1,350,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2987,2,1,350,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2988,29,1,350,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2989,1,1,350,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2990,9,1,350,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (2991,3,1,350,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (2992,29,1,351,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2993,1,1,351,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2994,3,1,351,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (2995,9,1,351,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2996,2,1,351,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (2997,9,1,351,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2998,2,1,351,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (2999,29,1,351,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3000,1,1,351,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3001,3,1,351,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3002,2,1,351,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3003,29,1,351,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3004,1,1,351,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3005,9,1,351,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3006,3,1,351,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3007,29,1,352,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3008,1,1,352,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3009,3,1,352,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3010,9,1,352,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3011,2,1,352,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3012,9,1,352,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3013,2,1,352,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3014,29,1,352,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3015,1,1,352,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3016,3,1,352,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3017,2,1,352,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3018,29,1,352,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3019,1,1,352,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3020,9,1,352,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3021,3,1,352,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3022,29,1,353,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3023,1,1,353,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3024,3,1,353,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3025,9,1,353,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3026,2,1,353,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3027,9,1,353,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3028,2,1,353,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3029,29,1,353,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3030,1,1,353,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3031,3,1,353,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3032,2,1,353,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3033,29,1,353,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3034,1,1,353,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3035,9,1,353,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3036,3,1,353,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3037,29,1,354,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3038,1,1,354,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3039,3,1,354,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3040,9,1,354,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3041,2,1,354,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3042,9,1,354,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3043,2,1,354,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3044,29,1,354,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3045,1,1,354,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3046,3,1,354,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3047,2,1,354,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3048,29,1,354,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3049,1,1,354,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3050,9,1,354,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3051,3,1,354,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3052,29,1,355,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3053,1,1,355,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3054,3,1,355,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3055,9,1,355,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3056,2,1,355,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3057,9,1,355,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3058,2,1,355,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3059,29,1,355,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3060,1,1,355,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3061,3,1,355,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3062,2,1,355,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3063,29,1,355,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3064,1,1,355,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3065,9,1,355,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3066,3,1,355,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3067,29,1,356,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3068,1,1,356,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3069,3,1,356,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3070,9,1,356,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3071,2,1,356,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3072,9,1,356,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3073,2,1,356,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3074,29,1,356,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3075,1,1,356,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3076,3,1,356,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3077,2,1,356,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3078,29,1,356,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3079,1,1,356,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3080,9,1,356,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3081,3,1,356,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3082,29,1,357,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3083,1,1,357,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3084,3,1,357,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3085,9,1,357,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3086,2,1,357,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3087,9,1,357,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3088,2,1,357,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3089,29,1,357,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3090,1,1,357,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3091,3,1,357,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3092,2,1,357,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3093,29,1,357,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3094,1,1,357,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3095,9,1,357,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3096,3,1,357,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3097,29,1,358,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3098,1,1,358,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3099,3,1,358,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3100,9,1,358,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3101,2,1,358,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3102,9,1,358,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3103,2,1,358,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3104,29,1,358,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3105,1,1,358,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3106,3,1,358,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3107,2,1,358,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3108,29,1,358,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3109,1,1,358,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3110,9,1,358,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3111,3,1,358,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3112,29,1,359,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3113,1,1,359,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3114,3,1,359,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3115,9,1,359,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3116,2,1,359,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3117,9,1,359,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3118,2,1,359,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3119,29,1,359,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3120,1,1,359,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3121,3,1,359,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3122,2,1,359,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3123,29,1,359,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3124,1,1,359,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3125,9,1,359,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3126,3,1,359,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3127,29,1,360,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3128,1,1,360,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3129,3,1,360,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3130,9,1,360,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3131,2,1,360,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3132,9,1,360,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3133,2,1,360,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3134,29,1,360,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3135,1,1,360,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3136,3,1,360,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3137,2,1,360,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3138,29,1,360,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3139,1,1,360,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3140,9,1,360,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3141,3,1,360,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3142,29,1,361,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3143,1,1,361,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3144,3,1,361,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3145,9,1,361,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3146,2,1,361,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3147,9,1,361,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3148,2,1,361,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3149,29,1,361,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3150,1,1,361,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3151,3,1,361,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3152,2,1,361,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3153,29,1,361,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3154,1,1,361,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3155,9,1,361,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3156,3,1,361,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3157,29,1,362,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3158,1,1,362,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3159,3,1,362,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3160,9,1,362,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3161,2,1,362,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3162,9,1,362,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3163,2,1,362,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3164,29,1,362,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3165,1,1,362,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3166,3,1,362,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3167,2,1,362,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3168,29,1,362,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3169,1,1,362,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3170,9,1,362,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3171,3,1,362,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3172,29,1,363,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3173,1,1,363,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3174,3,1,363,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3175,9,1,363,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3176,2,1,363,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3177,9,1,363,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3178,2,1,363,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3179,29,1,363,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3180,1,1,363,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3181,3,1,363,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3182,2,1,363,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3183,29,1,363,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3184,1,1,363,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3185,9,1,363,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3186,3,1,363,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3187,29,1,364,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3188,1,1,364,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3189,3,1,364,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3190,9,1,364,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3191,2,1,364,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3192,9,1,364,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3193,2,1,364,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3194,29,1,364,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3195,1,1,364,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3196,3,1,364,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3197,2,1,364,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3198,29,1,364,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3199,1,1,364,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3200,9,1,364,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3201,3,1,364,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3202,29,1,365,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3203,1,1,365,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3204,3,1,365,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3205,9,1,365,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3206,2,1,365,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3207,9,1,365,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3208,2,1,365,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3209,29,1,365,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3210,1,1,365,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3211,3,1,365,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3212,2,1,365,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3213,29,1,365,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3214,1,1,365,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3215,9,1,365,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3216,3,1,365,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3217,29,1,366,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3218,1,1,366,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3219,3,1,366,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3220,9,1,366,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3221,2,1,366,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3222,9,1,366,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3223,2,1,366,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3224,29,1,366,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3225,1,1,366,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3226,3,1,366,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3227,2,1,366,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3228,29,1,366,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3229,1,1,366,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3230,9,1,366,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3231,3,1,366,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3232,29,1,367,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3233,1,1,367,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3234,3,1,367,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3235,9,1,367,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3236,2,1,367,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3237,9,1,367,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3238,2,1,367,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3239,29,1,367,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3240,1,1,367,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3241,3,1,367,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3242,2,1,367,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3243,29,1,367,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3244,1,1,367,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3245,9,1,367,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3246,3,1,367,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3247,29,1,368,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3248,1,1,368,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3249,3,1,368,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3250,9,1,368,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3251,2,1,368,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3252,9,1,368,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3253,2,1,368,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3254,29,1,368,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3255,1,1,368,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3256,3,1,368,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3257,2,1,368,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3258,29,1,368,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3259,1,1,368,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3260,9,1,368,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3261,3,1,368,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3262,29,1,369,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3263,1,1,369,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3264,3,1,369,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3265,9,1,369,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3266,2,1,369,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3267,9,1,369,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3268,2,1,369,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3269,29,1,369,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3270,1,1,369,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3271,3,1,369,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3272,2,1,369,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3273,29,1,369,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3274,1,1,369,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3275,9,1,369,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3276,3,1,369,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3277,29,1,370,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3278,1,1,370,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3279,3,1,370,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3280,9,1,370,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3281,2,1,370,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3282,9,1,370,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3283,2,1,370,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3284,29,1,370,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3285,1,1,370,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3286,3,1,370,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3287,2,1,370,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3288,29,1,370,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3289,1,1,370,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3290,9,1,370,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3291,3,1,370,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3292,29,1,371,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3293,1,1,371,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3294,3,1,371,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3295,9,1,371,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3296,2,1,371,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3297,9,1,371,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3298,2,1,371,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3299,29,1,371,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3300,1,1,371,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3301,3,1,371,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3302,2,1,371,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3303,29,1,371,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3304,1,1,371,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3305,9,1,371,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3306,3,1,371,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3307,29,1,372,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3308,1,1,372,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3309,3,1,372,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3310,9,1,372,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3311,2,1,372,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3312,9,1,372,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3313,2,1,372,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3314,29,1,372,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3315,1,1,372,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3316,3,1,372,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3317,2,1,372,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3318,29,1,372,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3319,1,1,372,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3320,9,1,372,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3321,3,1,372,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3322,29,1,373,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3323,1,1,373,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3324,3,1,373,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3325,9,1,373,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3326,2,1,373,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3327,9,1,373,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3328,2,1,373,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3329,29,1,373,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3330,1,1,373,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3331,3,1,373,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3332,2,1,373,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3333,29,1,373,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3334,1,1,373,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3335,9,1,373,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3336,3,1,373,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3337,29,1,374,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3338,1,1,374,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3339,3,1,374,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3340,9,1,374,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3341,2,1,374,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3342,9,1,374,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3343,2,1,374,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3344,29,1,374,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3345,1,1,374,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3346,3,1,374,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3347,2,1,374,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3348,29,1,374,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3349,1,1,374,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3350,9,1,374,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3351,3,1,374,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3352,29,1,375,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3353,1,1,375,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3354,3,1,375,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3355,9,1,375,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3356,2,1,375,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3357,9,1,375,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3358,2,1,375,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3359,29,1,375,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3360,1,1,375,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3361,3,1,375,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3362,2,1,375,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3363,29,1,375,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3364,1,1,375,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3365,9,1,375,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3366,3,1,375,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3367,29,1,376,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3368,1,1,376,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3369,3,1,376,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3370,9,1,376,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3371,2,1,376,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3372,9,1,376,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3373,2,1,376,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3374,29,1,376,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3375,1,1,376,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3376,3,1,376,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3377,2,1,376,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3378,29,1,376,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3379,1,1,376,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3380,9,1,376,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3381,3,1,376,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3382,29,1,377,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3383,1,1,377,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3384,3,1,377,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3385,9,1,377,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3386,2,1,377,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3387,9,1,377,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3388,2,1,377,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3389,29,1,377,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3390,1,1,377,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3391,3,1,377,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3392,2,1,377,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3393,29,1,377,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3394,1,1,377,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3395,9,1,377,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3396,3,1,377,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3397,29,1,378,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3398,1,1,378,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3399,3,1,378,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3400,9,1,378,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3401,2,1,378,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3407,2,1,378,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3408,29,1,378,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3409,1,1,378,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3410,9,1,378,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3411,3,1,378,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3412,29,1,379,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3413,1,1,379,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3414,3,1,379,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3415,9,1,379,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3416,2,1,379,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3417,9,1,379,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3418,2,1,379,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3419,29,1,379,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3420,1,1,379,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3421,3,1,379,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3422,2,1,379,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3423,29,1,379,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3424,1,1,379,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3425,9,1,379,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3426,3,1,379,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3427,29,1,380,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3428,1,1,380,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3429,3,1,380,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3430,9,1,380,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3431,2,1,380,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3432,9,1,380,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3433,2,1,380,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3434,29,1,380,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3435,1,1,380,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3436,3,1,380,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3437,2,1,380,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3438,29,1,380,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3439,1,1,380,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3440,9,1,380,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3441,3,1,380,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3442,29,1,381,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3443,1,1,381,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3444,3,1,381,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3445,9,1,381,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3446,2,1,381,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3447,9,1,381,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3448,2,1,381,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3449,29,1,381,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3450,1,1,381,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3451,3,1,381,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3452,2,1,381,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3453,29,1,381,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3454,1,1,381,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3455,9,1,381,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3456,3,1,381,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3457,29,1,382,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3458,1,1,382,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3459,3,1,382,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3460,9,1,382,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3461,2,1,382,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3462,9,1,382,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3463,2,1,382,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3464,29,1,382,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3465,1,1,382,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3466,3,1,382,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3467,2,1,382,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3468,29,1,382,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3469,1,1,382,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3470,9,1,382,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3471,3,1,382,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3472,29,1,383,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3473,1,1,383,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3474,3,1,383,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3475,9,1,383,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3476,2,1,383,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3477,9,1,383,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3478,2,1,383,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3479,29,1,383,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3480,1,1,383,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3481,3,1,383,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3482,2,1,383,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3483,29,1,383,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3484,1,1,383,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3485,9,1,383,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3486,3,1,383,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3487,29,1,384,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3488,1,1,384,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3489,3,1,384,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3490,9,1,384,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3491,2,1,384,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3492,9,1,384,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3493,2,1,384,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3494,29,1,384,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3495,1,1,384,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3496,3,1,384,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3497,2,1,384,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3498,29,1,384,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3499,1,1,384,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3500,9,1,384,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3501,3,1,384,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3502,29,1,385,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3503,1,1,385,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3504,3,1,385,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3505,9,1,385,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3506,2,1,385,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3507,9,1,385,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3508,2,1,385,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3509,29,1,385,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3510,1,1,385,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3511,3,1,385,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3512,2,1,385,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3513,29,1,385,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3514,1,1,385,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3515,9,1,385,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3516,3,1,385,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3517,29,1,386,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3518,1,1,386,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3519,3,1,386,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3520,9,1,386,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3521,2,1,386,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3522,9,1,386,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3523,2,1,386,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3524,29,1,386,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3525,1,1,386,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3526,3,1,386,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3527,2,1,386,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3528,29,1,386,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3529,1,1,386,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3530,9,1,386,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3531,3,1,386,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3532,29,1,387,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3533,1,1,387,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3534,3,1,387,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3535,9,1,387,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3536,2,1,387,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3537,9,1,387,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3538,2,1,387,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3539,29,1,387,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3540,1,1,387,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3541,3,1,387,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3542,2,1,387,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3543,29,1,387,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3544,1,1,387,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3545,9,1,387,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3546,3,1,387,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3547,29,1,388,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3548,1,1,388,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3549,3,1,388,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3550,9,1,388,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3551,2,1,388,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3552,9,1,388,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3553,2,1,388,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3554,29,1,388,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3555,1,1,388,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3556,3,1,388,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3557,2,1,388,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3558,29,1,388,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3559,1,1,388,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3560,9,1,388,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3561,3,1,388,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3562,29,1,389,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3563,1,1,389,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3564,3,1,389,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3565,9,1,389,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3566,2,1,389,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3567,9,1,389,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3568,2,1,389,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3569,29,1,389,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3570,1,1,389,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3571,3,1,389,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3572,2,1,389,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3573,29,1,389,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3574,1,1,389,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3575,9,1,389,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3576,3,1,389,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3577,29,1,390,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3578,1,1,390,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3579,3,1,390,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3580,9,1,390,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3581,2,1,390,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3582,9,1,390,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3583,2,1,390,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3584,29,1,390,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3585,1,1,390,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3586,3,1,390,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3587,2,1,390,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3588,29,1,390,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3589,1,1,390,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3590,9,1,390,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3591,3,1,390,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3592,29,1,391,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3593,1,1,391,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3594,3,1,391,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3595,9,1,391,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3596,2,1,391,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3597,9,1,391,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3598,2,1,391,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3599,29,1,391,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3600,1,1,391,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3601,3,1,391,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3602,2,1,391,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3603,29,1,391,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3604,1,1,391,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3605,9,1,391,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3606,3,1,391,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3607,29,1,392,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3608,1,1,392,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3609,3,1,392,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3610,9,1,392,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3611,2,1,392,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3612,9,1,392,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3613,2,1,392,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3614,29,1,392,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3615,1,1,392,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3616,3,1,392,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3617,2,1,392,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3618,29,1,392,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3619,1,1,392,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3620,9,1,392,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3621,3,1,392,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3622,29,1,393,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3623,1,1,393,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3624,3,1,393,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3625,9,1,393,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3626,2,1,393,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3627,9,1,393,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3628,2,1,393,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3629,29,1,393,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3630,1,1,393,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3631,3,1,393,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3632,2,1,393,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3633,29,1,393,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3634,1,1,393,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3635,9,1,393,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3636,3,1,393,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3637,29,1,394,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3638,1,1,394,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3639,3,1,394,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3640,9,1,394,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3641,2,1,394,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3642,9,1,394,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3643,2,1,394,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3644,29,1,394,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3645,1,1,394,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3646,3,1,394,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3647,2,1,394,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3648,29,1,394,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3649,1,1,394,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3650,9,1,394,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3651,3,1,394,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3652,29,1,395,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3653,1,1,395,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3654,3,1,395,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3655,9,1,395,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3656,2,1,395,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3657,9,1,395,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3658,2,1,395,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3659,29,1,395,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3660,1,1,395,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3661,3,1,395,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3662,2,1,395,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3663,29,1,395,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3664,1,1,395,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3665,9,1,395,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3666,3,1,395,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3667,29,1,396,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3668,1,1,396,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3669,3,1,396,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3670,9,1,396,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3671,2,1,396,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3672,9,1,396,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3673,2,1,396,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3674,29,1,396,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3675,1,1,396,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3676,3,1,396,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3677,2,1,396,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3678,29,1,396,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3679,1,1,396,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3680,9,1,396,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3681,3,1,396,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3682,29,1,397,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3683,1,1,397,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3684,3,1,397,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3685,9,1,397,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3686,2,1,397,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3687,9,1,397,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3688,2,1,397,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3689,29,1,397,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3690,1,1,397,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3691,3,1,397,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3692,2,1,397,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3693,29,1,397,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3694,1,1,397,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3695,9,1,397,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3696,3,1,397,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3697,29,1,398,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3698,1,1,398,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3699,3,1,398,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3700,9,1,398,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3701,2,1,398,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3702,9,1,398,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3703,2,1,398,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3704,29,1,398,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3705,1,1,398,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3706,3,1,398,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3707,2,1,398,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3708,29,1,398,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3709,1,1,398,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3710,9,1,398,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3711,3,1,398,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3712,29,1,399,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3713,1,1,399,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3714,3,1,399,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3715,9,1,399,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3716,2,1,399,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3717,9,1,399,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3718,2,1,399,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3719,29,1,399,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3720,1,1,399,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3721,3,1,399,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3722,2,1,399,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3723,29,1,399,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3724,1,1,399,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3725,9,1,399,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3726,3,1,399,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3727,29,1,400,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3728,1,1,400,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3729,3,1,400,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3730,9,1,400,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3731,2,1,400,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3732,9,1,400,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3733,2,1,400,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3734,29,1,400,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3735,1,1,400,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3736,3,1,400,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3737,2,1,400,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3738,29,1,400,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3739,1,1,400,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3740,9,1,400,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3741,3,1,400,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3742,29,1,401,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3743,1,1,401,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3744,3,1,401,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3745,9,1,401,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3746,2,1,401,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3747,9,1,401,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3748,2,1,401,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3749,29,1,401,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3750,1,1,401,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3751,3,1,401,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3752,2,1,401,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3753,29,1,401,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3754,1,1,401,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3755,9,1,401,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3756,3,1,401,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3757,29,1,402,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3758,1,1,402,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3759,3,1,402,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3760,9,1,402,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3761,2,1,402,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3762,9,1,402,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3763,2,1,402,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3764,29,1,402,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3765,1,1,402,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3766,3,1,402,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3767,2,1,402,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3768,29,1,402,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3769,1,1,402,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3770,9,1,402,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3771,3,1,402,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3772,29,1,403,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3773,1,1,403,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3774,3,1,403,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3775,9,1,403,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3776,2,1,403,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3777,9,1,403,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3778,2,1,403,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3779,29,1,403,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3780,1,1,403,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3781,3,1,403,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3782,2,1,403,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3783,29,1,403,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3784,1,1,403,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3785,9,1,403,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3786,3,1,403,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3787,29,1,404,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3788,1,1,404,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3789,3,1,404,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3790,9,1,404,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3791,2,1,404,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3792,9,1,404,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3793,2,1,404,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3794,29,1,404,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3795,1,1,404,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3796,3,1,404,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3797,2,1,404,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3798,29,1,404,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3799,1,1,404,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3800,9,1,404,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3801,3,1,404,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3802,29,1,405,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3803,1,1,405,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3804,3,1,405,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3805,9,1,405,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3806,2,1,405,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3807,9,1,405,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3808,2,1,405,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3809,29,1,405,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3810,1,1,405,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3811,3,1,405,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3812,2,1,405,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3813,29,1,405,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3814,1,1,405,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3815,9,1,405,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3816,3,1,405,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3817,29,1,406,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3818,1,1,406,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3819,3,1,406,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3820,9,1,406,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3821,2,1,406,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3822,9,1,406,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3823,2,1,406,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3824,29,1,406,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3825,1,1,406,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3826,3,1,406,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3827,2,1,406,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3828,29,1,406,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3829,1,1,406,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3830,9,1,406,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3831,3,1,406,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3832,29,1,407,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3833,1,1,407,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3834,3,1,407,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3835,9,1,407,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3836,2,1,407,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3837,9,1,407,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3838,2,1,407,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3839,29,1,407,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3840,1,1,407,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3841,3,1,407,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3842,2,1,407,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3843,29,1,407,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3844,1,1,407,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3845,9,1,407,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3846,3,1,407,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3847,29,1,408,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3848,1,1,408,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3849,3,1,408,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3850,9,1,408,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3851,2,1,408,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3852,9,1,408,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3853,2,1,408,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3854,29,1,408,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3855,1,1,408,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3856,3,1,408,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3857,2,1,408,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3858,29,1,408,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3859,1,1,408,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3860,9,1,408,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3861,3,1,408,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3862,29,1,409,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3863,1,1,409,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3864,3,1,409,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3865,9,1,409,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3866,2,1,409,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3867,9,1,409,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3868,2,1,409,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3869,29,1,409,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3870,1,1,409,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3871,3,1,409,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3872,2,1,409,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3873,29,1,409,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3874,1,1,409,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3875,9,1,409,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3876,3,1,409,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3877,29,1,410,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3878,1,1,410,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3879,3,1,410,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3880,9,1,410,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3881,2,1,410,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3882,9,1,410,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3883,2,1,410,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3884,29,1,410,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3885,1,1,410,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3886,3,1,410,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3887,2,1,410,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3888,29,1,410,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3889,1,1,410,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3890,9,1,410,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3891,3,1,410,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3892,29,1,411,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3893,1,1,411,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3894,3,1,411,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3895,9,1,411,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3896,2,1,411,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3897,9,1,411,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3898,2,1,411,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3899,29,1,411,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3900,1,1,411,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3901,3,1,411,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3902,2,1,411,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3903,29,1,411,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3904,1,1,411,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3905,9,1,411,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3906,3,1,411,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3907,29,1,412,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3908,1,1,412,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3909,3,1,412,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3910,9,1,412,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3911,2,1,412,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3912,9,1,412,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3913,2,1,412,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3914,29,1,412,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3915,1,1,412,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3916,3,1,412,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3917,2,1,412,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3918,29,1,412,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3919,1,1,412,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3920,9,1,412,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3921,3,1,412,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3922,29,1,413,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3923,1,1,413,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3924,3,1,413,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3925,9,1,413,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3926,2,1,413,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3927,9,1,413,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3928,2,1,413,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3929,29,1,413,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3930,1,1,413,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3931,3,1,413,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3932,2,1,413,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3933,29,1,413,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3934,1,1,413,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3935,9,1,413,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3936,3,1,413,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3937,29,1,414,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3938,1,1,414,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3939,3,1,414,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3940,9,1,414,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3941,2,1,414,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3942,9,1,414,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3943,2,1,414,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3944,29,1,414,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3945,1,1,414,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3946,3,1,414,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3947,2,1,414,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3948,29,1,414,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3949,1,1,414,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3950,9,1,414,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3951,3,1,414,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3952,29,1,415,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3953,1,1,415,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3954,3,1,415,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3955,9,1,415,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3956,2,1,415,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3957,9,1,415,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3958,2,1,415,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3959,29,1,415,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3960,1,1,415,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3961,3,1,415,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3962,2,1,415,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3963,29,1,415,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3964,1,1,415,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3965,9,1,415,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3966,3,1,415,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3967,29,1,416,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3968,1,1,416,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3969,3,1,416,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3970,9,1,416,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3971,2,1,416,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3972,9,1,416,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3973,2,1,416,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3974,29,1,416,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3975,1,1,416,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3976,3,1,416,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3977,2,1,416,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3978,29,1,416,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3979,1,1,416,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3980,9,1,416,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3981,3,1,416,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3982,29,1,417,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3983,1,1,417,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3984,3,1,417,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (3985,9,1,417,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3986,2,1,417,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3987,9,1,417,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3988,2,1,417,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3989,29,1,417,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3990,1,1,417,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3991,3,1,417,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (3992,2,1,417,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3993,29,1,417,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3994,1,1,417,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3995,9,1,417,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (3996,3,1,417,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (3997,29,1,418,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3998,1,1,418,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (3999,3,1,418,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4000,9,1,418,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4001,2,1,418,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4002,9,1,418,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4003,2,1,418,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4004,29,1,418,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4005,1,1,418,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4006,3,1,418,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4007,2,1,418,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4008,29,1,418,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4009,1,1,418,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4010,9,1,418,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4011,3,1,418,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4012,29,1,419,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4013,1,1,419,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4014,3,1,419,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4015,9,1,419,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4016,2,1,419,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4017,9,1,419,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4018,2,1,419,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4019,29,1,419,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4020,1,1,419,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4021,3,1,419,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4022,2,1,419,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4023,29,1,419,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4024,1,1,419,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4025,9,1,419,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4026,3,1,419,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4027,29,1,420,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4028,1,1,420,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4029,3,1,420,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4030,9,1,420,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4031,2,1,420,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4032,9,1,420,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4033,2,1,420,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4034,29,1,420,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4035,1,1,420,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4036,3,1,420,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4037,2,1,420,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4038,29,1,420,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4039,1,1,420,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4040,9,1,420,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4041,3,1,420,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4042,29,1,421,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4043,1,1,421,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4044,3,1,421,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4045,9,1,421,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4046,2,1,421,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4047,9,1,421,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4048,2,1,421,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4049,29,1,421,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4050,1,1,421,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4051,3,1,421,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4052,2,1,421,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4053,29,1,421,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4054,1,1,421,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4055,9,1,421,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4056,3,1,421,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4057,29,1,422,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4058,1,1,422,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4059,3,1,422,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4060,9,1,422,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4061,2,1,422,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4062,9,1,422,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4063,2,1,422,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4064,29,1,422,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4065,1,1,422,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4066,3,1,422,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4067,2,1,422,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4068,29,1,422,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4069,1,1,422,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4070,9,1,422,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4071,3,1,422,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4072,29,1,423,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4073,1,1,423,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4074,3,1,423,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4075,9,1,423,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4076,2,1,423,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4077,9,1,423,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4078,2,1,423,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4079,29,1,423,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4080,1,1,423,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4081,3,1,423,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4082,2,1,423,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4083,29,1,423,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4084,1,1,423,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4085,9,1,423,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4086,3,1,423,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4087,29,1,424,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4088,1,1,424,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4089,3,1,424,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4090,9,1,424,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4091,2,1,424,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4092,9,1,424,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4093,2,1,424,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4094,29,1,424,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4095,1,1,424,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4096,3,1,424,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4097,2,1,424,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4098,29,1,424,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4099,1,1,424,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4100,9,1,424,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4101,3,1,424,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4102,29,1,425,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4103,1,1,425,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4104,3,1,425,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4105,9,1,425,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4106,2,1,425,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4107,9,1,425,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4108,2,1,425,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4109,29,1,425,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4110,1,1,425,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4111,3,1,425,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4112,2,1,425,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4113,29,1,425,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4114,1,1,425,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4115,9,1,425,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4116,3,1,425,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4117,29,1,426,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4118,1,1,426,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4119,3,1,426,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4120,9,1,426,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4121,2,1,426,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4122,9,1,426,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4123,2,1,426,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4124,29,1,426,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4125,1,1,426,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4126,3,1,426,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4127,2,1,426,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4128,29,1,426,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4129,1,1,426,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4130,9,1,426,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4131,3,1,426,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4132,29,1,427,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4133,1,1,427,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4134,3,1,427,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4135,9,1,427,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4136,2,1,427,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4137,9,1,427,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4138,2,1,427,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4139,29,1,427,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4140,1,1,427,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4141,3,1,427,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4142,2,1,427,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4143,29,1,427,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4144,1,1,427,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4145,9,1,427,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4146,3,1,427,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4147,29,1,428,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4148,1,1,428,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4149,3,1,428,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4150,9,1,428,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4151,2,1,428,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4152,9,1,428,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4153,2,1,428,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4154,29,1,428,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4155,1,1,428,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4156,3,1,428,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4157,2,1,428,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4158,29,1,428,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4159,1,1,428,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4160,9,1,428,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4161,3,1,428,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4162,29,1,429,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4163,1,1,429,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4164,3,1,429,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4165,9,1,429,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4166,2,1,429,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4167,9,1,429,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4168,2,1,429,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4169,29,1,429,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4170,1,1,429,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4171,3,1,429,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4172,2,1,429,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4173,29,1,429,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4174,1,1,429,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4175,9,1,429,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4176,3,1,429,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4177,29,1,430,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4178,1,1,430,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4179,3,1,430,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4180,9,1,430,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4181,2,1,430,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4182,9,1,430,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4183,2,1,430,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4184,29,1,430,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4185,1,1,430,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4186,3,1,430,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4187,2,1,430,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4188,29,1,430,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4189,1,1,430,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4190,9,1,430,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4191,3,1,430,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4192,29,1,431,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4193,1,1,431,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4194,3,1,431,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4195,9,1,431,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4196,2,1,431,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4197,9,1,431,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4198,2,1,431,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4199,29,1,431,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4200,1,1,431,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4201,3,1,431,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4202,2,1,431,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4203,29,1,431,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4204,1,1,431,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4205,9,1,431,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4206,3,1,431,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4207,29,1,432,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4208,1,1,432,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4209,3,1,432,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4210,9,1,432,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4211,2,1,432,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4212,9,1,432,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4213,2,1,432,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4214,29,1,432,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4215,1,1,432,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4216,3,1,432,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4217,2,1,432,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4218,29,1,432,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4219,1,1,432,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4220,9,1,432,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4221,3,1,432,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4222,29,1,433,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4223,1,1,433,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4224,3,1,433,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4225,9,1,433,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4226,2,1,433,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4227,9,1,433,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4228,2,1,433,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4229,29,1,433,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4230,1,1,433,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4231,3,1,433,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4232,2,1,433,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4233,29,1,433,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4234,1,1,433,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4235,9,1,433,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4236,3,1,433,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4237,29,1,434,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4238,1,1,434,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4239,3,1,434,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4240,9,1,434,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4241,2,1,434,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4242,9,1,434,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4243,2,1,434,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4244,29,1,434,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4245,1,1,434,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4246,3,1,434,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4247,2,1,434,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4248,29,1,434,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4249,1,1,434,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4250,9,1,434,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4251,3,1,434,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4252,29,1,435,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4253,1,1,435,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4254,3,1,435,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4255,9,1,435,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4256,2,1,435,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4257,9,1,435,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4258,2,1,435,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4259,29,1,435,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4260,1,1,435,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4261,3,1,435,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4262,2,1,435,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4263,29,1,435,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4264,1,1,435,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4265,9,1,435,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4266,3,1,435,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4267,29,1,436,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4268,1,1,436,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4269,3,1,436,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4270,9,1,436,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4271,2,1,436,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4272,9,1,436,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4273,2,1,436,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4274,29,1,436,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4275,1,1,436,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4276,3,1,436,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4277,2,1,436,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4278,29,1,436,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4279,1,1,436,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4280,9,1,436,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4281,3,1,436,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4282,29,1,437,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4283,1,1,437,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4284,3,1,437,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4285,9,1,437,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4286,2,1,437,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4287,9,1,437,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4288,2,1,437,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4289,29,1,437,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4290,1,1,437,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4291,3,1,437,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4292,2,1,437,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4293,29,1,437,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4294,1,1,437,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4295,9,1,437,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4296,3,1,437,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4297,29,1,438,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4298,1,1,438,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4299,3,1,438,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4300,9,1,438,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4301,2,1,438,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4302,9,1,438,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4303,2,1,438,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4304,29,1,438,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4305,1,1,438,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4306,3,1,438,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4307,2,1,438,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4308,29,1,438,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4309,1,1,438,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4310,9,1,438,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4311,3,1,438,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4312,29,1,439,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4313,1,1,439,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4314,3,1,439,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4315,9,1,439,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4316,2,1,439,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4317,9,1,439,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4318,2,1,439,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4319,29,1,439,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4320,1,1,439,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4321,3,1,439,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4322,2,1,439,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4323,29,1,439,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4324,1,1,439,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4325,9,1,439,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4326,3,1,439,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4327,29,1,440,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4328,1,1,440,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4329,3,1,440,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4330,9,1,440,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4331,2,1,440,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4332,9,1,440,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4333,2,1,440,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4334,29,1,440,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4335,1,1,440,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4336,3,1,440,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4337,2,1,440,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4338,29,1,440,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4339,1,1,440,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4340,9,1,440,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4341,3,1,440,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4342,29,1,441,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4343,1,1,441,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4344,3,1,441,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4345,9,1,441,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4346,2,1,441,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4347,9,1,441,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4348,2,1,441,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4349,29,1,441,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4350,1,1,441,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4351,3,1,441,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4352,2,1,441,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4353,29,1,441,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4354,1,1,441,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4355,9,1,441,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4356,3,1,441,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4357,29,1,442,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4358,1,1,442,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4359,3,1,442,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4360,9,1,442,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4361,2,1,442,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4362,9,1,442,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4363,2,1,442,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4364,29,1,442,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4365,1,1,442,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4366,3,1,442,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4367,2,1,442,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4368,29,1,442,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4369,1,1,442,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4370,9,1,442,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4371,3,1,442,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4372,29,1,443,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4373,1,1,443,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4374,3,1,443,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4375,9,1,443,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4376,2,1,443,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4377,9,1,443,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4378,2,1,443,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4379,29,1,443,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4380,1,1,443,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4381,3,1,443,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4382,2,1,443,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4383,29,1,443,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4384,1,1,443,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4385,9,1,443,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4386,3,1,443,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4387,29,1,444,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4388,1,1,444,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4389,3,1,444,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4390,9,1,444,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4391,2,1,444,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4392,9,1,444,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4393,2,1,444,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4394,29,1,444,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4395,1,1,444,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4396,3,1,444,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4397,2,1,444,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4398,29,1,444,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4399,1,1,444,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4400,9,1,444,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4401,3,1,444,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4402,29,1,445,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4403,1,1,445,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4404,3,1,445,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4405,9,1,445,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4406,2,1,445,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4407,9,1,445,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4408,2,1,445,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4409,29,1,445,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4410,1,1,445,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4411,3,1,445,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4412,2,1,445,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4413,29,1,445,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4414,1,1,445,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4415,9,1,445,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4416,3,1,445,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4417,29,1,446,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4418,1,1,446,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4419,3,1,446,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4420,9,1,446,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4421,2,1,446,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4422,9,1,446,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4423,2,1,446,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4424,29,1,446,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4425,1,1,446,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4426,3,1,446,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4427,2,1,446,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4428,29,1,446,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4429,1,1,446,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4430,9,1,446,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4431,3,1,446,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4432,29,1,447,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4433,1,1,447,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4434,3,1,447,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4435,9,1,447,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4436,2,1,447,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4437,9,1,447,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4438,2,1,447,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4439,29,1,447,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4440,1,1,447,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4441,3,1,447,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4442,2,1,447,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4443,29,1,447,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4444,1,1,447,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4445,9,1,447,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4446,3,1,447,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4447,29,1,448,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4448,1,1,448,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4449,3,1,448,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4450,9,1,448,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4451,2,1,448,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4452,9,1,448,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4453,2,1,448,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4454,29,1,448,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4455,1,1,448,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4456,3,1,448,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4457,2,1,448,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4458,29,1,448,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4459,1,1,448,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4460,9,1,448,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4461,3,1,448,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4462,29,1,449,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4463,1,1,449,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4464,3,1,449,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4465,9,1,449,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4466,2,1,449,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4467,9,1,449,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4468,2,1,449,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4469,29,1,449,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4470,1,1,449,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4471,3,1,449,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4472,2,1,449,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4473,29,1,449,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4474,1,1,449,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4475,9,1,449,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4476,3,1,449,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4477,29,1,450,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4478,1,1,450,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4479,3,1,450,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4480,9,1,450,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4481,2,1,450,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4482,9,1,450,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4483,2,1,450,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4484,29,1,450,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4485,1,1,450,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4486,3,1,450,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4487,2,1,450,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4488,29,1,450,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4489,1,1,450,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4490,9,1,450,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4491,3,1,450,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4492,29,1,451,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4493,1,1,451,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4494,3,1,451,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4495,9,1,451,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4496,2,1,451,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4497,9,1,451,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4498,2,1,451,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4499,29,1,451,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4500,1,1,451,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4501,3,1,451,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4502,2,1,451,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4503,29,1,451,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4504,1,1,451,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4505,9,1,451,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4506,3,1,451,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4507,29,1,452,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4508,1,1,452,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4509,3,1,452,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4510,9,1,452,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4511,2,1,452,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4512,9,1,452,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4513,2,1,452,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4514,29,1,452,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4515,1,1,452,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4516,3,1,452,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4517,2,1,452,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4518,29,1,452,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4519,1,1,452,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4520,9,1,452,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4521,3,1,452,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4522,29,1,453,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4523,1,1,453,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4524,3,1,453,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4525,9,1,453,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4526,2,1,453,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4527,9,1,453,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4528,2,1,453,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4529,29,1,453,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4530,1,1,453,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4531,3,1,453,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4532,2,1,453,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4533,29,1,453,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4534,1,1,453,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4535,9,1,453,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4536,3,1,453,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4537,29,1,454,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4538,1,1,454,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4539,3,1,454,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4540,9,1,454,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4541,2,1,454,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4542,9,1,454,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4543,2,1,454,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4544,29,1,454,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4545,1,1,454,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4546,3,1,454,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4547,2,1,454,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4548,29,1,454,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4549,1,1,454,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4550,9,1,454,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4551,3,1,454,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4552,29,1,455,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4553,1,1,455,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4554,3,1,455,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4555,9,1,455,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4556,2,1,455,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4557,9,1,455,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4558,2,1,455,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4559,29,1,455,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4560,1,1,455,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4561,3,1,455,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4562,2,1,455,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4563,29,1,455,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4564,1,1,455,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4565,9,1,455,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4566,3,1,455,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4567,29,1,456,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4568,1,1,456,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4569,3,1,456,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4570,9,1,456,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4571,2,1,456,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4572,9,1,456,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4573,2,1,456,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4574,29,1,456,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4575,1,1,456,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4576,3,1,456,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4577,2,1,456,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4578,29,1,456,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4579,1,1,456,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4580,9,1,456,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4581,3,1,456,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4582,29,1,457,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4583,1,1,457,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4584,3,1,457,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4585,9,1,457,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4586,2,1,457,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4587,9,1,457,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4588,2,1,457,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4589,29,1,457,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4590,1,1,457,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4591,3,1,457,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4592,2,1,457,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4593,29,1,457,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4594,1,1,457,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4595,9,1,457,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4596,3,1,457,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4597,29,1,458,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4598,1,1,458,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4599,3,1,458,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4600,9,1,458,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4601,2,1,458,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4602,9,1,458,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4603,2,1,458,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4604,29,1,458,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4605,1,1,458,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4606,3,1,458,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4607,2,1,458,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4608,29,1,458,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4609,1,1,458,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4610,9,1,458,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4611,3,1,458,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4612,29,1,459,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4613,1,1,459,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4614,3,1,459,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4615,9,1,459,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4616,2,1,459,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4617,9,1,459,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4618,2,1,459,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4619,29,1,459,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4620,1,1,459,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4621,3,1,459,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4622,2,1,459,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4623,29,1,459,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4624,1,1,459,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4625,9,1,459,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4626,3,1,459,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4627,29,1,460,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4628,1,1,460,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4629,3,1,460,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4630,9,1,460,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4631,2,1,460,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4632,9,1,460,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4633,2,1,460,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4634,29,1,460,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4635,1,1,460,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4636,3,1,460,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4637,2,1,460,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4638,29,1,460,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4639,1,1,460,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4640,9,1,460,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4641,3,1,460,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4642,29,1,461,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4643,1,1,461,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4644,3,1,461,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4645,9,1,461,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4646,2,1,461,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4647,9,1,461,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4648,2,1,461,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4649,29,1,461,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4650,1,1,461,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4651,3,1,461,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4652,2,1,461,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4653,29,1,461,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4654,1,1,461,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4655,9,1,461,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4656,3,1,461,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4657,29,1,462,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4658,1,1,462,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4659,3,1,462,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4660,9,1,462,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4661,2,1,462,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4662,9,1,462,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4663,2,1,462,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4664,29,1,462,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4665,1,1,462,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4666,3,1,462,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4667,2,1,462,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4668,29,1,462,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4669,1,1,462,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4670,9,1,462,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4671,3,1,462,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4672,29,1,463,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4673,1,1,463,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4674,3,1,463,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4675,9,1,463,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4676,2,1,463,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4677,9,1,463,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4678,2,1,463,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4679,29,1,463,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4680,1,1,463,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4681,3,1,463,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4682,2,1,463,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4683,29,1,463,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4684,1,1,463,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4685,9,1,463,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4686,3,1,463,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4687,29,1,464,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4688,1,1,464,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4689,3,1,464,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4690,9,1,464,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4691,2,1,464,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4692,9,1,464,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4693,2,1,464,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4694,29,1,464,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4695,1,1,464,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4696,3,1,464,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4697,2,1,464,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4698,29,1,464,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4699,1,1,464,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4700,9,1,464,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4701,3,1,464,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4702,29,1,465,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4703,1,1,465,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4704,3,1,465,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4705,9,1,465,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4706,2,1,465,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4707,9,1,465,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4708,2,1,465,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4709,29,1,465,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4710,1,1,465,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4711,3,1,465,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4712,2,1,465,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4713,29,1,465,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4714,1,1,465,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4715,9,1,465,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4716,3,1,465,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4717,29,1,466,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4718,1,1,466,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4719,3,1,466,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4720,9,1,466,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4721,2,1,466,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4722,9,1,466,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4723,2,1,466,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4724,29,1,466,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4725,1,1,466,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4726,3,1,466,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4727,2,1,466,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4728,29,1,466,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4729,1,1,466,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4730,9,1,466,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4731,3,1,466,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4732,29,1,467,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4733,1,1,467,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4734,3,1,467,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4735,9,1,467,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4736,2,1,467,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4737,9,1,467,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4738,2,1,467,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4739,29,1,467,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4740,1,1,467,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4741,3,1,467,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4742,2,1,467,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4743,29,1,467,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4744,1,1,467,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4745,9,1,467,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4746,3,1,467,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4747,29,1,468,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4748,1,1,468,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4749,3,1,468,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4750,9,1,468,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4751,2,1,468,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4752,9,1,468,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4753,2,1,468,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4754,29,1,468,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4755,1,1,468,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4756,3,1,468,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4757,2,1,468,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4758,29,1,468,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4759,1,1,468,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4760,9,1,468,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4761,3,1,468,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4762,19,11,469,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4763,5,11,469,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4764,9,11,469,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4765,9,11,469,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4766,19,11,469,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4767,5,11,469,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4768,9,11,469,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4769,19,11,469,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4770,5,11,469,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4771,4,2,6,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4772,5,2,6,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4773,6,2,6,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4774,7,2,6,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4775,30,2,6,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4776,8,2,6,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4777,9,2,6,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4778,19,11,470,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4779,5,11,470,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4780,9,11,470,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4781,9,11,470,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4782,19,11,470,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4783,5,11,470,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4784,9,11,470,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4785,19,11,470,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4786,5,11,470,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4787,19,11,471,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4788,5,11,471,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4789,9,11,471,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4790,9,11,471,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4791,19,11,471,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4792,5,11,471,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4793,9,11,471,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4794,19,11,471,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4795,5,11,471,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4796,9,3,472,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4797,2,3,472,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4798,12,3,472,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4799,1,3,472,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4800,5,3,472,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4801,11,3,472,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4802,10,3,472,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4803,9,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4804,2,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4805,12,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4806,1,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4807,5,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4808,11,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4809,10,3,472,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4810,10,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4811,11,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4812,5,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4813,1,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4814,12,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4815,2,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4816,9,3,472,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4817,3,1,378,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4818,1,1,378,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4819,29,1,378,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4820,2,1,378,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4821,9,1,378,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4822,3,1,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4823,1,1,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4824,29,1,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4825,2,1,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4826,9,1,0,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4827,19,11,477,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4828,5,11,477,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4829,9,11,477,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4830,9,11,477,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4831,19,11,477,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4832,5,11,477,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4833,9,11,477,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4834,19,11,477,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4835,5,11,477,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4853,3,6,9,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4854,1,6,9,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (4855,2,6,9,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (4856,29,6,9,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4857,9,6,9,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (4858,9,7,233,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (4859,20,7,233,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (4860,18,7,233,NULL,1,0,1);
INSERT INTO `sys_access` VALUES (4861,19,11,504,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4862,5,11,504,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4863,9,11,504,NULL,1,0,0);
INSERT INTO `sys_access` VALUES (4864,9,11,504,NULL,2,0,0);
INSERT INTO `sys_access` VALUES (4865,19,11,504,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4866,5,11,504,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4867,9,11,504,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4868,19,11,504,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4869,5,11,504,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4870,9,11,535,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4871,19,11,535,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4872,5,11,535,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4873,9,11,570,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4874,19,11,570,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4875,5,11,570,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4879,9,11,591,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4880,19,11,591,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4881,5,11,591,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4882,9,11,596,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4883,19,11,596,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4884,5,11,596,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4885,9,11,607,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4886,19,11,607,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4887,5,11,607,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4888,9,11,614,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4889,19,11,614,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4890,5,11,614,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4891,9,11,631,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4892,19,11,631,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4893,5,11,631,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4894,9,11,668,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4895,19,11,668,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4896,5,11,668,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4897,9,11,669,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4898,19,11,669,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4899,5,11,669,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4900,3,22,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4901,9,11,783,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4902,19,11,783,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4903,5,11,783,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4904,9,11,836,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4905,19,11,836,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4906,5,11,836,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4907,80,39,879,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4911,81,34,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4912,19,34,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4913,66,34,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4914,5,32,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4915,82,32,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4916,80,39,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4917,80,39,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4918,5,32,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4920,81,34,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4921,66,34,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4922,86,35,0,NULL,1,1,0);
INSERT INTO `sys_access` VALUES (4923,86,35,0,NULL,2,1,0);
INSERT INTO `sys_access` VALUES (4924,1,35,983,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4925,1,35,984,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4926,1,35,985,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4927,1,35,986,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4928,1,35,987,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4933,81,34,988,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4934,19,34,988,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4935,66,34,988,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4936,87,34,988,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4937,1,35,989,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4938,81,34,992,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4939,19,34,992,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4940,66,34,992,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4941,87,34,992,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4942,1,35,993,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4943,81,34,996,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4944,19,34,996,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4945,66,34,996,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4946,87,34,996,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4947,1,35,997,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4948,1,35,1002,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4949,1,35,1003,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4950,1,35,1007,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4951,1,35,1008,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4952,1,35,1009,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4953,1,35,1010,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4954,1,35,1011,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4955,1,35,1012,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4956,1,35,1013,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4957,1,35,1014,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4958,1,35,1015,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4959,1,35,1016,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4960,1,35,1020,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4961,81,34,1024,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4962,19,34,1024,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4963,66,34,1024,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4964,87,34,1024,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4965,1,35,1026,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4966,81,34,1031,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4967,19,34,1031,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4968,66,34,1031,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4969,87,34,1031,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4970,1,35,1032,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4971,1,35,1037,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4972,1,35,1041,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4973,1,35,1045,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4974,1,35,1049,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4975,1,35,1053,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4976,1,35,1057,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4977,1,35,1061,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4978,1,35,1065,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4979,1,35,1069,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4980,1,35,1073,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4981,1,35,1077,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4982,1,35,1081,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4983,1,35,1085,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4984,1,35,1089,3,NULL,1,0);
INSERT INTO `sys_access` VALUES (4985,9,11,1160,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4986,19,11,1160,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4987,5,11,1160,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4988,2,1,1165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4989,29,1,1165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4990,1,1,1165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4991,9,1,1165,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4992,3,1,1165,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4993,9,11,1167,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4994,19,11,1167,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4995,5,11,1167,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4996,9,11,1171,2,NULL,1,0);
INSERT INTO `sys_access` VALUES (4997,19,11,1171,2,NULL,0,0);
INSERT INTO `sys_access` VALUES (4998,5,11,1171,2,NULL,0,0);

#
# Table structure for table sys_access_registry
#

CREATE TABLE `sys_access_registry` (
  `obj_id` int(11) unsigned default NULL,
  `class_section_id` int(11) unsigned default NULL,
  KEY `obj_id` (`obj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_access_registry
#

INSERT INTO `sys_access_registry` VALUES (6,2);
INSERT INTO `sys_access_registry` VALUES (46,1);
INSERT INTO `sys_access_registry` VALUES (298,2);
INSERT INTO `sys_access_registry` VALUES (318,1);
INSERT INTO `sys_access_registry` VALUES (295,2);
INSERT INTO `sys_access_registry` VALUES (12,3);
INSERT INTO `sys_access_registry` VALUES (13,3);
INSERT INTO `sys_access_registry` VALUES (14,4);
INSERT INTO `sys_access_registry` VALUES (15,4);
INSERT INTO `sys_access_registry` VALUES (9,6);
INSERT INTO `sys_access_registry` VALUES (10,6);
INSERT INTO `sys_access_registry` VALUES (11,6);
INSERT INTO `sys_access_registry` VALUES (55,3);
INSERT INTO `sys_access_registry` VALUES (56,4);
INSERT INTO `sys_access_registry` VALUES (57,6);
INSERT INTO `sys_access_registry` VALUES (60,1);
INSERT INTO `sys_access_registry` VALUES (61,2);
INSERT INTO `sys_access_registry` VALUES (62,7);
INSERT INTO `sys_access_registry` VALUES (63,7);
INSERT INTO `sys_access_registry` VALUES (64,7);
INSERT INTO `sys_access_registry` VALUES (65,5);
INSERT INTO `sys_access_registry` VALUES (190,7);
INSERT INTO `sys_access_registry` VALUES (69,7);
INSERT INTO `sys_access_registry` VALUES (70,7);
INSERT INTO `sys_access_registry` VALUES (71,7);
INSERT INTO `sys_access_registry` VALUES (72,7);
INSERT INTO `sys_access_registry` VALUES (73,7);
INSERT INTO `sys_access_registry` VALUES (287,7);
INSERT INTO `sys_access_registry` VALUES (75,7);
INSERT INTO `sys_access_registry` VALUES (297,2);
INSERT INTO `sys_access_registry` VALUES (189,12);
INSERT INTO `sys_access_registry` VALUES (95,7);
INSERT INTO `sys_access_registry` VALUES (134,11);
INSERT INTO `sys_access_registry` VALUES (191,7);
INSERT INTO `sys_access_registry` VALUES (135,10);
INSERT INTO `sys_access_registry` VALUES (99,10);
INSERT INTO `sys_access_registry` VALUES (100,10);
INSERT INTO `sys_access_registry` VALUES (101,10);
INSERT INTO `sys_access_registry` VALUES (192,7);
INSERT INTO `sys_access_registry` VALUES (193,7);
INSERT INTO `sys_access_registry` VALUES (94,7);
INSERT INTO `sys_access_registry` VALUES (195,15);
INSERT INTO `sys_access_registry` VALUES (194,7);
INSERT INTO `sys_access_registry` VALUES (145,11);
INSERT INTO `sys_access_registry` VALUES (107,10);
INSERT INTO `sys_access_registry` VALUES (108,10);
INSERT INTO `sys_access_registry` VALUES (121,12);
INSERT INTO `sys_access_registry` VALUES (123,7);
INSERT INTO `sys_access_registry` VALUES (126,12);
INSERT INTO `sys_access_registry` VALUES (122,7);
INSERT INTO `sys_access_registry` VALUES (296,2);
INSERT INTO `sys_access_registry` VALUES (299,2);
INSERT INTO `sys_access_registry` VALUES (148,12);
INSERT INTO `sys_access_registry` VALUES (149,12);
INSERT INTO `sys_access_registry` VALUES (150,12);
INSERT INTO `sys_access_registry` VALUES (151,12);
INSERT INTO `sys_access_registry` VALUES (155,12);
INSERT INTO `sys_access_registry` VALUES (177,11);
INSERT INTO `sys_access_registry` VALUES (157,12);
INSERT INTO `sys_access_registry` VALUES (310,1);
INSERT INTO `sys_access_registry` VALUES (317,1);
INSERT INTO `sys_access_registry` VALUES (161,13);
INSERT INTO `sys_access_registry` VALUES (162,7);
INSERT INTO `sys_access_registry` VALUES (163,13);
INSERT INTO `sys_access_registry` VALUES (164,6);
INSERT INTO `sys_access_registry` VALUES (165,6);
INSERT INTO `sys_access_registry` VALUES (166,6);
INSERT INTO `sys_access_registry` VALUES (167,6);
INSERT INTO `sys_access_registry` VALUES (168,6);
INSERT INTO `sys_access_registry` VALUES (169,6);
INSERT INTO `sys_access_registry` VALUES (170,6);
INSERT INTO `sys_access_registry` VALUES (171,11);
INSERT INTO `sys_access_registry` VALUES (172,11);
INSERT INTO `sys_access_registry` VALUES (173,11);
INSERT INTO `sys_access_registry` VALUES (174,11);
INSERT INTO `sys_access_registry` VALUES (175,11);
INSERT INTO `sys_access_registry` VALUES (176,12);
INSERT INTO `sys_access_registry` VALUES (198,7);
INSERT INTO `sys_access_registry` VALUES (201,14);
INSERT INTO `sys_access_registry` VALUES (202,14);
INSERT INTO `sys_access_registry` VALUES (533,15);
INSERT INTO `sys_access_registry` VALUES (300,2);
INSERT INTO `sys_access_registry` VALUES (301,2);
INSERT INTO `sys_access_registry` VALUES (306,2);
INSERT INTO `sys_access_registry` VALUES (305,2);
INSERT INTO `sys_access_registry` VALUES (304,2);
INSERT INTO `sys_access_registry` VALUES (303,2);
INSERT INTO `sys_access_registry` VALUES (302,2);
INSERT INTO `sys_access_registry` VALUES (224,12);
INSERT INTO `sys_access_registry` VALUES (225,4);
INSERT INTO `sys_access_registry` VALUES (226,8);
INSERT INTO `sys_access_registry` VALUES (473,8);
INSERT INTO `sys_access_registry` VALUES (233,7);
INSERT INTO `sys_access_registry` VALUES (234,13);
INSERT INTO `sys_access_registry` VALUES (309,1);
INSERT INTO `sys_access_registry` VALUES (490,16);
INSERT INTO `sys_access_registry` VALUES (240,7);
INSERT INTO `sys_access_registry` VALUES (476,12);
INSERT INTO `sys_access_registry` VALUES (486,17);
INSERT INTO `sys_access_registry` VALUES (253,12);
INSERT INTO `sys_access_registry` VALUES (259,12);
INSERT INTO `sys_access_registry` VALUES (260,12);
INSERT INTO `sys_access_registry` VALUES (261,7);
INSERT INTO `sys_access_registry` VALUES (262,12);
INSERT INTO `sys_access_registry` VALUES (286,12);
INSERT INTO `sys_access_registry` VALUES (264,7);
INSERT INTO `sys_access_registry` VALUES (265,7);
INSERT INTO `sys_access_registry` VALUES (266,7);
INSERT INTO `sys_access_registry` VALUES (316,1);
INSERT INTO `sys_access_registry` VALUES (314,1);
INSERT INTO `sys_access_registry` VALUES (307,2);
INSERT INTO `sys_access_registry` VALUES (308,2);
INSERT INTO `sys_access_registry` VALUES (313,1);
INSERT INTO `sys_access_registry` VALUES (312,1);
INSERT INTO `sys_access_registry` VALUES (311,1);
INSERT INTO `sys_access_registry` VALUES (315,1);
INSERT INTO `sys_access_registry` VALUES (288,7);
INSERT INTO `sys_access_registry` VALUES (477,11);
INSERT INTO `sys_access_registry` VALUES (290,7);
INSERT INTO `sys_access_registry` VALUES (319,1);
INSERT INTO `sys_access_registry` VALUES (320,1);
INSERT INTO `sys_access_registry` VALUES (321,1);
INSERT INTO `sys_access_registry` VALUES (322,1);
INSERT INTO `sys_access_registry` VALUES (323,1);
INSERT INTO `sys_access_registry` VALUES (324,1);
INSERT INTO `sys_access_registry` VALUES (325,1);
INSERT INTO `sys_access_registry` VALUES (326,1);
INSERT INTO `sys_access_registry` VALUES (327,1);
INSERT INTO `sys_access_registry` VALUES (328,1);
INSERT INTO `sys_access_registry` VALUES (329,1);
INSERT INTO `sys_access_registry` VALUES (330,1);
INSERT INTO `sys_access_registry` VALUES (331,1);
INSERT INTO `sys_access_registry` VALUES (332,1);
INSERT INTO `sys_access_registry` VALUES (333,1);
INSERT INTO `sys_access_registry` VALUES (334,1);
INSERT INTO `sys_access_registry` VALUES (335,1);
INSERT INTO `sys_access_registry` VALUES (336,1);
INSERT INTO `sys_access_registry` VALUES (337,1);
INSERT INTO `sys_access_registry` VALUES (338,1);
INSERT INTO `sys_access_registry` VALUES (339,1);
INSERT INTO `sys_access_registry` VALUES (340,1);
INSERT INTO `sys_access_registry` VALUES (341,1);
INSERT INTO `sys_access_registry` VALUES (342,1);
INSERT INTO `sys_access_registry` VALUES (343,1);
INSERT INTO `sys_access_registry` VALUES (345,1);
INSERT INTO `sys_access_registry` VALUES (346,1);
INSERT INTO `sys_access_registry` VALUES (347,1);
INSERT INTO `sys_access_registry` VALUES (348,1);
INSERT INTO `sys_access_registry` VALUES (349,1);
INSERT INTO `sys_access_registry` VALUES (350,1);
INSERT INTO `sys_access_registry` VALUES (351,1);
INSERT INTO `sys_access_registry` VALUES (352,1);
INSERT INTO `sys_access_registry` VALUES (353,1);
INSERT INTO `sys_access_registry` VALUES (354,1);
INSERT INTO `sys_access_registry` VALUES (355,1);
INSERT INTO `sys_access_registry` VALUES (356,1);
INSERT INTO `sys_access_registry` VALUES (357,1);
INSERT INTO `sys_access_registry` VALUES (358,1);
INSERT INTO `sys_access_registry` VALUES (359,1);
INSERT INTO `sys_access_registry` VALUES (360,1);
INSERT INTO `sys_access_registry` VALUES (361,1);
INSERT INTO `sys_access_registry` VALUES (362,1);
INSERT INTO `sys_access_registry` VALUES (363,1);
INSERT INTO `sys_access_registry` VALUES (364,1);
INSERT INTO `sys_access_registry` VALUES (365,1);
INSERT INTO `sys_access_registry` VALUES (366,1);
INSERT INTO `sys_access_registry` VALUES (367,1);
INSERT INTO `sys_access_registry` VALUES (368,1);
INSERT INTO `sys_access_registry` VALUES (369,1);
INSERT INTO `sys_access_registry` VALUES (370,1);
INSERT INTO `sys_access_registry` VALUES (371,1);
INSERT INTO `sys_access_registry` VALUES (372,1);
INSERT INTO `sys_access_registry` VALUES (373,1);
INSERT INTO `sys_access_registry` VALUES (374,1);
INSERT INTO `sys_access_registry` VALUES (375,1);
INSERT INTO `sys_access_registry` VALUES (376,1);
INSERT INTO `sys_access_registry` VALUES (377,1);
INSERT INTO `sys_access_registry` VALUES (378,1);
INSERT INTO `sys_access_registry` VALUES (379,1);
INSERT INTO `sys_access_registry` VALUES (380,1);
INSERT INTO `sys_access_registry` VALUES (381,1);
INSERT INTO `sys_access_registry` VALUES (382,1);
INSERT INTO `sys_access_registry` VALUES (383,1);
INSERT INTO `sys_access_registry` VALUES (384,1);
INSERT INTO `sys_access_registry` VALUES (385,1);
INSERT INTO `sys_access_registry` VALUES (386,1);
INSERT INTO `sys_access_registry` VALUES (387,1);
INSERT INTO `sys_access_registry` VALUES (388,1);
INSERT INTO `sys_access_registry` VALUES (389,1);
INSERT INTO `sys_access_registry` VALUES (390,1);
INSERT INTO `sys_access_registry` VALUES (391,1);
INSERT INTO `sys_access_registry` VALUES (392,1);
INSERT INTO `sys_access_registry` VALUES (393,1);
INSERT INTO `sys_access_registry` VALUES (394,1);
INSERT INTO `sys_access_registry` VALUES (395,1);
INSERT INTO `sys_access_registry` VALUES (396,1);
INSERT INTO `sys_access_registry` VALUES (397,1);
INSERT INTO `sys_access_registry` VALUES (398,1);
INSERT INTO `sys_access_registry` VALUES (399,1);
INSERT INTO `sys_access_registry` VALUES (400,1);
INSERT INTO `sys_access_registry` VALUES (401,1);
INSERT INTO `sys_access_registry` VALUES (402,1);
INSERT INTO `sys_access_registry` VALUES (403,1);
INSERT INTO `sys_access_registry` VALUES (404,1);
INSERT INTO `sys_access_registry` VALUES (405,1);
INSERT INTO `sys_access_registry` VALUES (406,1);
INSERT INTO `sys_access_registry` VALUES (407,1);
INSERT INTO `sys_access_registry` VALUES (408,1);
INSERT INTO `sys_access_registry` VALUES (409,1);
INSERT INTO `sys_access_registry` VALUES (410,1);
INSERT INTO `sys_access_registry` VALUES (411,1);
INSERT INTO `sys_access_registry` VALUES (412,1);
INSERT INTO `sys_access_registry` VALUES (413,1);
INSERT INTO `sys_access_registry` VALUES (414,1);
INSERT INTO `sys_access_registry` VALUES (415,1);
INSERT INTO `sys_access_registry` VALUES (416,1);
INSERT INTO `sys_access_registry` VALUES (417,1);
INSERT INTO `sys_access_registry` VALUES (418,1);
INSERT INTO `sys_access_registry` VALUES (419,1);
INSERT INTO `sys_access_registry` VALUES (420,1);
INSERT INTO `sys_access_registry` VALUES (421,1);
INSERT INTO `sys_access_registry` VALUES (422,1);
INSERT INTO `sys_access_registry` VALUES (423,1);
INSERT INTO `sys_access_registry` VALUES (424,1);
INSERT INTO `sys_access_registry` VALUES (425,1);
INSERT INTO `sys_access_registry` VALUES (426,1);
INSERT INTO `sys_access_registry` VALUES (427,1);
INSERT INTO `sys_access_registry` VALUES (428,1);
INSERT INTO `sys_access_registry` VALUES (429,1);
INSERT INTO `sys_access_registry` VALUES (430,1);
INSERT INTO `sys_access_registry` VALUES (431,1);
INSERT INTO `sys_access_registry` VALUES (432,1);
INSERT INTO `sys_access_registry` VALUES (433,1);
INSERT INTO `sys_access_registry` VALUES (434,1);
INSERT INTO `sys_access_registry` VALUES (435,1);
INSERT INTO `sys_access_registry` VALUES (436,1);
INSERT INTO `sys_access_registry` VALUES (437,1);
INSERT INTO `sys_access_registry` VALUES (438,1);
INSERT INTO `sys_access_registry` VALUES (439,1);
INSERT INTO `sys_access_registry` VALUES (440,1);
INSERT INTO `sys_access_registry` VALUES (441,1);
INSERT INTO `sys_access_registry` VALUES (442,1);
INSERT INTO `sys_access_registry` VALUES (443,1);
INSERT INTO `sys_access_registry` VALUES (444,1);
INSERT INTO `sys_access_registry` VALUES (445,1);
INSERT INTO `sys_access_registry` VALUES (446,1);
INSERT INTO `sys_access_registry` VALUES (447,1);
INSERT INTO `sys_access_registry` VALUES (448,1);
INSERT INTO `sys_access_registry` VALUES (449,1);
INSERT INTO `sys_access_registry` VALUES (450,1);
INSERT INTO `sys_access_registry` VALUES (451,1);
INSERT INTO `sys_access_registry` VALUES (452,1);
INSERT INTO `sys_access_registry` VALUES (453,1);
INSERT INTO `sys_access_registry` VALUES (454,1);
INSERT INTO `sys_access_registry` VALUES (455,1);
INSERT INTO `sys_access_registry` VALUES (456,1);
INSERT INTO `sys_access_registry` VALUES (457,1);
INSERT INTO `sys_access_registry` VALUES (458,1);
INSERT INTO `sys_access_registry` VALUES (459,1);
INSERT INTO `sys_access_registry` VALUES (460,1);
INSERT INTO `sys_access_registry` VALUES (461,1);
INSERT INTO `sys_access_registry` VALUES (462,1);
INSERT INTO `sys_access_registry` VALUES (463,1);
INSERT INTO `sys_access_registry` VALUES (464,1);
INSERT INTO `sys_access_registry` VALUES (465,1);
INSERT INTO `sys_access_registry` VALUES (466,1);
INSERT INTO `sys_access_registry` VALUES (467,1);
INSERT INTO `sys_access_registry` VALUES (468,1);
INSERT INTO `sys_access_registry` VALUES (469,11);
INSERT INTO `sys_access_registry` VALUES (470,11);
INSERT INTO `sys_access_registry` VALUES (471,11);
INSERT INTO `sys_access_registry` VALUES (472,3);
INSERT INTO `sys_access_registry` VALUES (487,17);
INSERT INTO `sys_access_registry` VALUES (481,17);
INSERT INTO `sys_access_registry` VALUES (488,17);
INSERT INTO `sys_access_registry` VALUES (489,16);
INSERT INTO `sys_access_registry` VALUES (501,16);
INSERT INTO `sys_access_registry` VALUES (494,12);
INSERT INTO `sys_access_registry` VALUES (498,12);
INSERT INTO `sys_access_registry` VALUES (497,7);
INSERT INTO `sys_access_registry` VALUES (502,16);
INSERT INTO `sys_access_registry` VALUES (503,16);
INSERT INTO `sys_access_registry` VALUES (504,11);
INSERT INTO `sys_access_registry` VALUES (507,12);
INSERT INTO `sys_access_registry` VALUES (529,12);
INSERT INTO `sys_access_registry` VALUES (524,12);
INSERT INTO `sys_access_registry` VALUES (530,7);
INSERT INTO `sys_access_registry` VALUES (531,7);
INSERT INTO `sys_access_registry` VALUES (532,7);
INSERT INTO `sys_access_registry` VALUES (535,11);
INSERT INTO `sys_access_registry` VALUES (536,19);
INSERT INTO `sys_access_registry` VALUES (537,18);
INSERT INTO `sys_access_registry` VALUES (538,12);
INSERT INTO `sys_access_registry` VALUES (540,20);
INSERT INTO `sys_access_registry` VALUES (541,12);
INSERT INTO `sys_access_registry` VALUES (545,20);
INSERT INTO `sys_access_registry` VALUES (548,20);
INSERT INTO `sys_access_registry` VALUES (551,20);
INSERT INTO `sys_access_registry` VALUES (554,20);
INSERT INTO `sys_access_registry` VALUES (563,16);
INSERT INTO `sys_access_registry` VALUES (562,16);
INSERT INTO `sys_access_registry` VALUES (564,16);
INSERT INTO `sys_access_registry` VALUES (565,16);
INSERT INTO `sys_access_registry` VALUES (566,16);
INSERT INTO `sys_access_registry` VALUES (567,12);
INSERT INTO `sys_access_registry` VALUES (607,11);
INSERT INTO `sys_access_registry` VALUES (570,11);
INSERT INTO `sys_access_registry` VALUES (591,11);
INSERT INTO `sys_access_registry` VALUES (837,31);
INSERT INTO `sys_access_registry` VALUES (596,11);
INSERT INTO `sys_access_registry` VALUES (611,14);
INSERT INTO `sys_access_registry` VALUES (612,20);
INSERT INTO `sys_access_registry` VALUES (614,11);
INSERT INTO `sys_access_registry` VALUES (615,12);
INSERT INTO `sys_access_registry` VALUES (616,14);
INSERT INTO `sys_access_registry` VALUES (619,12);
INSERT INTO `sys_access_registry` VALUES (1097,15);
INSERT INTO `sys_access_registry` VALUES (842,25);
INSERT INTO `sys_access_registry` VALUES (631,11);
INSERT INTO `sys_access_registry` VALUES (632,7);
INSERT INTO `sys_access_registry` VALUES (633,7);
INSERT INTO `sys_access_registry` VALUES (634,12);
INSERT INTO `sys_access_registry` VALUES (635,7);
INSERT INTO `sys_access_registry` VALUES (660,22);
INSERT INTO `sys_access_registry` VALUES (637,21);
INSERT INTO `sys_access_registry` VALUES (663,21);
INSERT INTO `sys_access_registry` VALUES (639,21);
INSERT INTO `sys_access_registry` VALUES (643,7);
INSERT INTO `sys_access_registry` VALUES (641,21);
INSERT INTO `sys_access_registry` VALUES (642,7);
INSERT INTO `sys_access_registry` VALUES (644,7);
INSERT INTO `sys_access_registry` VALUES (645,23);
INSERT INTO `sys_access_registry` VALUES (664,21);
INSERT INTO `sys_access_registry` VALUES (654,12);
INSERT INTO `sys_access_registry` VALUES (661,21);
INSERT INTO `sys_access_registry` VALUES (662,21);
INSERT INTO `sys_access_registry` VALUES (665,21);
INSERT INTO `sys_access_registry` VALUES (666,21);
INSERT INTO `sys_access_registry` VALUES (668,11);
INSERT INTO `sys_access_registry` VALUES (669,11);
INSERT INTO `sys_access_registry` VALUES (672,21);
INSERT INTO `sys_access_registry` VALUES (679,7);
INSERT INTO `sys_access_registry` VALUES (689,24);
INSERT INTO `sys_access_registry` VALUES (681,24);
INSERT INTO `sys_access_registry` VALUES (683,24);
INSERT INTO `sys_access_registry` VALUES (684,24);
INSERT INTO `sys_access_registry` VALUES (717,24);
INSERT INTO `sys_access_registry` VALUES (692,24);
INSERT INTO `sys_access_registry` VALUES (693,24);
INSERT INTO `sys_access_registry` VALUES (703,24);
INSERT INTO `sys_access_registry` VALUES (707,24);
INSERT INTO `sys_access_registry` VALUES (715,24);
INSERT INTO `sys_access_registry` VALUES (718,24);
INSERT INTO `sys_access_registry` VALUES (759,12);
INSERT INTO `sys_access_registry` VALUES (770,12);
INSERT INTO `sys_access_registry` VALUES (775,16);
INSERT INTO `sys_access_registry` VALUES (836,11);
INSERT INTO `sys_access_registry` VALUES (783,11);
INSERT INTO `sys_access_registry` VALUES (841,26);
INSERT INTO `sys_access_registry` VALUES (241,17);
INSERT INTO `sys_access_registry` VALUES (792,7);
INSERT INTO `sys_access_registry` VALUES (793,7);
INSERT INTO `sys_access_registry` VALUES (794,7);
INSERT INTO `sys_access_registry` VALUES (795,7);
INSERT INTO `sys_access_registry` VALUES (796,25);
INSERT INTO `sys_access_registry` VALUES (807,7);
INSERT INTO `sys_access_registry` VALUES (799,26);
INSERT INTO `sys_access_registry` VALUES (801,28);
INSERT INTO `sys_access_registry` VALUES (802,28);
INSERT INTO `sys_access_registry` VALUES (803,28);
INSERT INTO `sys_access_registry` VALUES (804,28);
INSERT INTO `sys_access_registry` VALUES (805,28);
INSERT INTO `sys_access_registry` VALUES (808,7);
INSERT INTO `sys_access_registry` VALUES (809,30);
INSERT INTO `sys_access_registry` VALUES (810,30);
INSERT INTO `sys_access_registry` VALUES (811,30);
INSERT INTO `sys_access_registry` VALUES (812,29);
INSERT INTO `sys_access_registry` VALUES (815,21);
INSERT INTO `sys_access_registry` VALUES (832,27);
INSERT INTO `sys_access_registry` VALUES (823,26);
INSERT INTO `sys_access_registry` VALUES (854,26);
INSERT INTO `sys_access_registry` VALUES (843,25);
INSERT INTO `sys_access_registry` VALUES (845,25);
INSERT INTO `sys_access_registry` VALUES (844,26);
INSERT INTO `sys_access_registry` VALUES (855,21);
INSERT INTO `sys_access_registry` VALUES (853,24);
INSERT INTO `sys_access_registry` VALUES (862,16);
INSERT INTO `sys_access_registry` VALUES (863,7);
INSERT INTO `sys_access_registry` VALUES (864,7);
INSERT INTO `sys_access_registry` VALUES (865,7);
INSERT INTO `sys_access_registry` VALUES (866,7);
INSERT INTO `sys_access_registry` VALUES (868,7);
INSERT INTO `sys_access_registry` VALUES (869,7);
INSERT INTO `sys_access_registry` VALUES (870,37);
INSERT INTO `sys_access_registry` VALUES (872,36);
INSERT INTO `sys_access_registry` VALUES (874,38);
INSERT INTO `sys_access_registry` VALUES (878,36);
INSERT INTO `sys_access_registry` VALUES (879,39);
INSERT INTO `sys_access_registry` VALUES (880,33);
INSERT INTO `sys_access_registry` VALUES (881,32);
INSERT INTO `sys_access_registry` VALUES (882,7);
INSERT INTO `sys_access_registry` VALUES (883,7);
INSERT INTO `sys_access_registry` VALUES (884,7);
INSERT INTO `sys_access_registry` VALUES (885,34);
INSERT INTO `sys_access_registry` VALUES (886,35);
INSERT INTO `sys_access_registry` VALUES (887,35);
INSERT INTO `sys_access_registry` VALUES (888,21);
INSERT INTO `sys_access_registry` VALUES (889,34);
INSERT INTO `sys_access_registry` VALUES (892,34);
INSERT INTO `sys_access_registry` VALUES (895,34);
INSERT INTO `sys_access_registry` VALUES (896,35);
INSERT INTO `sys_access_registry` VALUES (899,34);
INSERT INTO `sys_access_registry` VALUES (900,35);
INSERT INTO `sys_access_registry` VALUES (903,34);
INSERT INTO `sys_access_registry` VALUES (904,35);
INSERT INTO `sys_access_registry` VALUES (907,34);
INSERT INTO `sys_access_registry` VALUES (908,35);
INSERT INTO `sys_access_registry` VALUES (911,35);
INSERT INTO `sys_access_registry` VALUES (912,35);
INSERT INTO `sys_access_registry` VALUES (913,35);
INSERT INTO `sys_access_registry` VALUES (914,35);
INSERT INTO `sys_access_registry` VALUES (915,35);
INSERT INTO `sys_access_registry` VALUES (916,35);
INSERT INTO `sys_access_registry` VALUES (918,35);
INSERT INTO `sys_access_registry` VALUES (919,35);
INSERT INTO `sys_access_registry` VALUES (920,35);
INSERT INTO `sys_access_registry` VALUES (921,35);
INSERT INTO `sys_access_registry` VALUES (923,34);
INSERT INTO `sys_access_registry` VALUES (924,35);
INSERT INTO `sys_access_registry` VALUES (927,34);
INSERT INTO `sys_access_registry` VALUES (928,35);
INSERT INTO `sys_access_registry` VALUES (931,35);
INSERT INTO `sys_access_registry` VALUES (932,35);
INSERT INTO `sys_access_registry` VALUES (933,35);
INSERT INTO `sys_access_registry` VALUES (934,35);
INSERT INTO `sys_access_registry` VALUES (935,33);
INSERT INTO `sys_access_registry` VALUES (936,32);
INSERT INTO `sys_access_registry` VALUES (937,32);
INSERT INTO `sys_access_registry` VALUES (938,34);
INSERT INTO `sys_access_registry` VALUES (939,35);
INSERT INTO `sys_access_registry` VALUES (942,34);
INSERT INTO `sys_access_registry` VALUES (943,35);
INSERT INTO `sys_access_registry` VALUES (946,35);
INSERT INTO `sys_access_registry` VALUES (947,34);
INSERT INTO `sys_access_registry` VALUES (950,34);
INSERT INTO `sys_access_registry` VALUES (951,35);
INSERT INTO `sys_access_registry` VALUES (954,34);
INSERT INTO `sys_access_registry` VALUES (956,35);
INSERT INTO `sys_access_registry` VALUES (960,34);
INSERT INTO `sys_access_registry` VALUES (962,35);
INSERT INTO `sys_access_registry` VALUES (965,34);
INSERT INTO `sys_access_registry` VALUES (966,35);
INSERT INTO `sys_access_registry` VALUES (969,35);
INSERT INTO `sys_access_registry` VALUES (970,35);
INSERT INTO `sys_access_registry` VALUES (971,35);
INSERT INTO `sys_access_registry` VALUES (972,35);
INSERT INTO `sys_access_registry` VALUES (973,34);
INSERT INTO `sys_access_registry` VALUES (974,35);
INSERT INTO `sys_access_registry` VALUES (977,34);
INSERT INTO `sys_access_registry` VALUES (978,35);
INSERT INTO `sys_access_registry` VALUES (981,35);
INSERT INTO `sys_access_registry` VALUES (982,7);
INSERT INTO `sys_access_registry` VALUES (983,35);
INSERT INTO `sys_access_registry` VALUES (984,35);
INSERT INTO `sys_access_registry` VALUES (985,35);
INSERT INTO `sys_access_registry` VALUES (986,35);
INSERT INTO `sys_access_registry` VALUES (987,35);
INSERT INTO `sys_access_registry` VALUES (988,34);
INSERT INTO `sys_access_registry` VALUES (989,35);
INSERT INTO `sys_access_registry` VALUES (992,34);
INSERT INTO `sys_access_registry` VALUES (993,35);
INSERT INTO `sys_access_registry` VALUES (996,34);
INSERT INTO `sys_access_registry` VALUES (997,35);
INSERT INTO `sys_access_registry` VALUES (1002,35);
INSERT INTO `sys_access_registry` VALUES (1003,35);
INSERT INTO `sys_access_registry` VALUES (1007,35);
INSERT INTO `sys_access_registry` VALUES (1008,35);
INSERT INTO `sys_access_registry` VALUES (1009,35);
INSERT INTO `sys_access_registry` VALUES (1010,35);
INSERT INTO `sys_access_registry` VALUES (1011,35);
INSERT INTO `sys_access_registry` VALUES (1012,35);
INSERT INTO `sys_access_registry` VALUES (1013,35);
INSERT INTO `sys_access_registry` VALUES (1014,35);
INSERT INTO `sys_access_registry` VALUES (1015,35);
INSERT INTO `sys_access_registry` VALUES (1016,35);
INSERT INTO `sys_access_registry` VALUES (1020,35);
INSERT INTO `sys_access_registry` VALUES (1024,34);
INSERT INTO `sys_access_registry` VALUES (1026,35);
INSERT INTO `sys_access_registry` VALUES (1031,34);
INSERT INTO `sys_access_registry` VALUES (1032,35);
INSERT INTO `sys_access_registry` VALUES (1037,35);
INSERT INTO `sys_access_registry` VALUES (1041,35);
INSERT INTO `sys_access_registry` VALUES (1045,35);
INSERT INTO `sys_access_registry` VALUES (1049,35);
INSERT INTO `sys_access_registry` VALUES (1053,35);
INSERT INTO `sys_access_registry` VALUES (1057,35);
INSERT INTO `sys_access_registry` VALUES (1061,35);
INSERT INTO `sys_access_registry` VALUES (1065,35);
INSERT INTO `sys_access_registry` VALUES (1069,35);
INSERT INTO `sys_access_registry` VALUES (1073,35);
INSERT INTO `sys_access_registry` VALUES (1077,35);
INSERT INTO `sys_access_registry` VALUES (1081,35);
INSERT INTO `sys_access_registry` VALUES (1085,35);
INSERT INTO `sys_access_registry` VALUES (1089,35);
INSERT INTO `sys_access_registry` VALUES (1093,15);
INSERT INTO `sys_access_registry` VALUES (1094,15);
INSERT INTO `sys_access_registry` VALUES (1099,14);
INSERT INTO `sys_access_registry` VALUES (1100,35);
INSERT INTO `sys_access_registry` VALUES (1104,35);
INSERT INTO `sys_access_registry` VALUES (1116,34);
INSERT INTO `sys_access_registry` VALUES (1117,35);
INSERT INTO `sys_access_registry` VALUES (1126,35);
INSERT INTO `sys_access_registry` VALUES (1130,35);
INSERT INTO `sys_access_registry` VALUES (1134,35);
INSERT INTO `sys_access_registry` VALUES (1140,14);
INSERT INTO `sys_access_registry` VALUES (1141,14);
INSERT INTO `sys_access_registry` VALUES (1142,14);
INSERT INTO `sys_access_registry` VALUES (1143,14);
INSERT INTO `sys_access_registry` VALUES (1144,14);
INSERT INTO `sys_access_registry` VALUES (1145,14);
INSERT INTO `sys_access_registry` VALUES (1146,14);
INSERT INTO `sys_access_registry` VALUES (1147,14);
INSERT INTO `sys_access_registry` VALUES (1149,35);
INSERT INTO `sys_access_registry` VALUES (1153,35);
INSERT INTO `sys_access_registry` VALUES (1155,35);
INSERT INTO `sys_access_registry` VALUES (1159,35);
INSERT INTO `sys_access_registry` VALUES (1160,11);
INSERT INTO `sys_access_registry` VALUES (1161,40);
INSERT INTO `sys_access_registry` VALUES (1162,41);
INSERT INTO `sys_access_registry` VALUES (1165,1);
INSERT INTO `sys_access_registry` VALUES (1166,40);
INSERT INTO `sys_access_registry` VALUES (1167,11);
INSERT INTO `sys_access_registry` VALUES (1168,42);
INSERT INTO `sys_access_registry` VALUES (1169,40);
INSERT INTO `sys_access_registry` VALUES (1170,40);
INSERT INTO `sys_access_registry` VALUES (1171,11);
INSERT INTO `sys_access_registry` VALUES (1172,41);
INSERT INTO `sys_access_registry` VALUES (1173,42);

#
# Table structure for table sys_actions
#

CREATE TABLE `sys_actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_actions
#

INSERT INTO `sys_actions` VALUES (1,'edit');
INSERT INTO `sys_actions` VALUES (2,'delete');
INSERT INTO `sys_actions` VALUES (3,'view');
INSERT INTO `sys_actions` VALUES (4,'create');
INSERT INTO `sys_actions` VALUES (5,'list');
INSERT INTO `sys_actions` VALUES (6,'createFolder');
INSERT INTO `sys_actions` VALUES (7,'editFolder');
INSERT INTO `sys_actions` VALUES (8,'deleteFolder');
INSERT INTO `sys_actions` VALUES (9,'editACL');
INSERT INTO `sys_actions` VALUES (10,'login');
INSERT INTO `sys_actions` VALUES (11,'exit');
INSERT INTO `sys_actions` VALUES (12,'memberOf');
INSERT INTO `sys_actions` VALUES (13,'groupDelete');
INSERT INTO `sys_actions` VALUES (14,'groupsList');
INSERT INTO `sys_actions` VALUES (15,'groupEdit');
INSERT INTO `sys_actions` VALUES (16,'membersList');
INSERT INTO `sys_actions` VALUES (17,'addToGroup');
INSERT INTO `sys_actions` VALUES (18,'editDefault');
INSERT INTO `sys_actions` VALUES (19,'post');
INSERT INTO `sys_actions` VALUES (20,'admin');
INSERT INTO `sys_actions` VALUES (21,'devToolbar');
INSERT INTO `sys_actions` VALUES (27,'upload');
INSERT INTO `sys_actions` VALUES (28,'get');
INSERT INTO `sys_actions` VALUES (29,'move');
INSERT INTO `sys_actions` VALUES (30,'moveFolder');
INSERT INTO `sys_actions` VALUES (51,'groupCreate');
INSERT INTO `sys_actions` VALUES (52,'viewGallery');
INSERT INTO `sys_actions` VALUES (53,'createAlbum');
INSERT INTO `sys_actions` VALUES (54,'editAlbum');
INSERT INTO `sys_actions` VALUES (55,'viewAlbum');
INSERT INTO `sys_actions` VALUES (56,'uploadPhoto');
INSERT INTO `sys_actions` VALUES (57,'viewThumbnail');
INSERT INTO `sys_actions` VALUES (59,'viewPhoto');
INSERT INTO `sys_actions` VALUES (60,'editPhoto');
INSERT INTO `sys_actions` VALUES (61,'save');
INSERT INTO `sys_actions` VALUES (62,'deletemenu');
INSERT INTO `sys_actions` VALUES (63,'addmenu');
INSERT INTO `sys_actions` VALUES (64,'editmenu');
INSERT INTO `sys_actions` VALUES (65,'additem');
INSERT INTO `sys_actions` VALUES (66,'last');
INSERT INTO `sys_actions` VALUES (67,'moveUp');
INSERT INTO `sys_actions` VALUES (68,'moveDown');
INSERT INTO `sys_actions` VALUES (69,'register');
INSERT INTO `sys_actions` VALUES (70,'results');
INSERT INTO `sys_actions` VALUES (71,'send');
INSERT INTO `sys_actions` VALUES (72,'addcategory');
INSERT INTO `sys_actions` VALUES (73,'deletecategory');
INSERT INTO `sys_actions` VALUES (74,'editcategory');
INSERT INTO `sys_actions` VALUES (75,'viewActual');
INSERT INTO `sys_actions` VALUES (76,'deleteAlbum');
INSERT INTO `sys_actions` VALUES (77,'deletecat');
INSERT INTO `sys_actions` VALUES (78,'createcat');
INSERT INTO `sys_actions` VALUES (79,'editcat');
INSERT INTO `sys_actions` VALUES (80,'forum');
INSERT INTO `sys_actions` VALUES (81,'thread');
INSERT INTO `sys_actions` VALUES (82,'newThread');
INSERT INTO `sys_actions` VALUES (83,'createCategory');
INSERT INTO `sys_actions` VALUES (84,'createForum');
INSERT INTO `sys_actions` VALUES (85,'editForum');
INSERT INTO `sys_actions` VALUES (86,'goto');
INSERT INTO `sys_actions` VALUES (87,'editThread');
INSERT INTO `sys_actions` VALUES (88,'moveThread');
INSERT INTO `sys_actions` VALUES (89,'up');
INSERT INTO `sys_actions` VALUES (90,'down');
INSERT INTO `sys_actions` VALUES (91,'createRoot');
INSERT INTO `sys_actions` VALUES (92,'browse');
INSERT INTO `sys_actions` VALUES (93,'new');
INSERT INTO `sys_actions` VALUES (94,'editTags');
INSERT INTO `sys_actions` VALUES (95,'tagsCloud');
INSERT INTO `sys_actions` VALUES (96,'itemsTagsCloud');
INSERT INTO `sys_actions` VALUES (97,'searchByTag');

#
# Table structure for table sys_cfg
#

CREATE TABLE `sys_cfg` (
  `id` int(11) NOT NULL auto_increment,
  `section` int(11) NOT NULL default '0',
  `module` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `section_module` (`section`,`module`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_cfg
#

INSERT INTO `sys_cfg` VALUES (1,0,0);
INSERT INTO `sys_cfg` VALUES (2,0,1);
INSERT INTO `sys_cfg` VALUES (3,0,2);
INSERT INTO `sys_cfg` VALUES (7,0,9);
INSERT INTO `sys_cfg` VALUES (9,0,10);
INSERT INTO `sys_cfg` VALUES (15,10,10);
INSERT INTO `sys_cfg` VALUES (16,0,8);
INSERT INTO `sys_cfg` VALUES (17,1,1);
INSERT INTO `sys_cfg` VALUES (18,9,9);
INSERT INTO `sys_cfg` VALUES (19,0,5);
INSERT INTO `sys_cfg` VALUES (20,0,6);
INSERT INTO `sys_cfg` VALUES (21,0,11);
INSERT INTO `sys_cfg` VALUES (22,0,12);
INSERT INTO `sys_cfg` VALUES (23,0,17);

#
# Table structure for table sys_cfg_titles
#

CREATE TABLE `sys_cfg_titles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_cfg_titles
#

INSERT INTO `sys_cfg_titles` VALUES (1,'��������� �� ��������');
INSERT INTO `sys_cfg_titles` VALUES (2,'������� ��������');
INSERT INTO `sys_cfg_titles` VALUES (3,'�����������');
INSERT INTO `sys_cfg_titles` VALUES (4,'������ ����������� ���������');
INSERT INTO `sys_cfg_titles` VALUES (5,'����� ������������ ������');
INSERT INTO `sys_cfg_titles` VALUES (6,'������ ������������ ������');
INSERT INTO `sys_cfg_titles` VALUES (7,'������ �������������');
INSERT INTO `sys_cfg_titles` VALUES (8,'���������� ��������� ����������');

#
# Table structure for table sys_cfg_values
#

CREATE TABLE `sys_cfg_values` (
  `id` int(11) NOT NULL auto_increment,
  `cfg_id` int(11) NOT NULL default '0',
  `name` int(11) NOT NULL default '0',
  `title` int(11) default NULL,
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cfg_id_name` (`cfg_id`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_cfg_values
#

INSERT INTO `sys_cfg_values` VALUES (1,1,3,3,'true');
INSERT INTO `sys_cfg_values` VALUES (2,2,1,1,'10');
INSERT INTO `sys_cfg_values` VALUES (3,3,1,1,'20');
INSERT INTO `sys_cfg_values` VALUES (14,6,1,1,'20');
INSERT INTO `sys_cfg_values` VALUES (21,7,2,2,'../tmp');
INSERT INTO `sys_cfg_values` VALUES (23,9,1,1,'60');
INSERT INTO `sys_cfg_values` VALUES (28,4,1,1,'10');
INSERT INTO `sys_cfg_values` VALUES (29,10,1,1,'10');
INSERT INTO `sys_cfg_values` VALUES (30,8,2,2,'../files');
INSERT INTO `sys_cfg_values` VALUES (31,11,1,1,'60');
INSERT INTO `sys_cfg_values` VALUES (34,7,1,1,'10');
INSERT INTO `sys_cfg_values` VALUES (40,15,1,1,'60');
INSERT INTO `sys_cfg_values` VALUES (41,17,1,1,'10');
INSERT INTO `sys_cfg_values` VALUES (44,21,4,6,'80');
INSERT INTO `sys_cfg_values` VALUES (45,21,5,5,'60');
INSERT INTO `sys_cfg_values` VALUES (46,21,6,7,'fileManager');
INSERT INTO `sys_cfg_values` VALUES (47,21,7,8,'5');
INSERT INTO `sys_cfg_values` VALUES (48,18,1,1,'10');
INSERT INTO `sys_cfg_values` VALUES (49,18,2,2,'../files');

#
# Table structure for table sys_cfg_vars
#

CREATE TABLE `sys_cfg_vars` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_cfg_vars
#

INSERT INTO `sys_cfg_vars` VALUES (1,'items_per_page');
INSERT INTO `sys_cfg_vars` VALUES (2,'upload_path');
INSERT INTO `sys_cfg_vars` VALUES (3,'cache');
INSERT INTO `sys_cfg_vars` VALUES (4,'thmb_width');
INSERT INTO `sys_cfg_vars` VALUES (5,'thmb_height');
INSERT INTO `sys_cfg_vars` VALUES (6,'filemanager_section');
INSERT INTO `sys_cfg_vars` VALUES (7,'last_photo_number');

#
# Table structure for table sys_classes
#

CREATE TABLE `sys_classes` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `module_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_classes
#

INSERT INTO `sys_classes` VALUES (1,'news',1);
INSERT INTO `sys_classes` VALUES (2,'newsFolder',1);
INSERT INTO `sys_classes` VALUES (3,'user',2);
INSERT INTO `sys_classes` VALUES (4,'group',2);
INSERT INTO `sys_classes` VALUES (6,'page',4);
INSERT INTO `sys_classes` VALUES (7,'access',5);
INSERT INTO `sys_classes` VALUES (8,'userGroup',2);
INSERT INTO `sys_classes` VALUES (9,'admin',6);
INSERT INTO `sys_classes` VALUES (10,'comments',8);
INSERT INTO `sys_classes` VALUES (11,'commentsFolder',8);
INSERT INTO `sys_classes` VALUES (12,'userAuth',2);
INSERT INTO `sys_classes` VALUES (13,'pageFolder',4);
INSERT INTO `sys_classes` VALUES (17,'file',9);
INSERT INTO `sys_classes` VALUES (18,'folder',9);
INSERT INTO `sys_classes` VALUES (19,'catalogue',10);
INSERT INTO `sys_classes` VALUES (20,'catalogueFolder',10);
INSERT INTO `sys_classes` VALUES (21,'gallery',11);
INSERT INTO `sys_classes` VALUES (22,'album',11);
INSERT INTO `sys_classes` VALUES (23,'photo',11);
INSERT INTO `sys_classes` VALUES (24,'menuItem',12);
INSERT INTO `sys_classes` VALUES (25,'menu',12);
INSERT INTO `sys_classes` VALUES (26,'menuFolder',12);
INSERT INTO `sys_classes` VALUES (27,'userOnline',2);
INSERT INTO `sys_classes` VALUES (28,'question',13);
INSERT INTO `sys_classes` VALUES (29,'answer',13);
INSERT INTO `sys_classes` VALUES (30,'voteFolder',13);
INSERT INTO `sys_classes` VALUES (32,'message',14);
INSERT INTO `sys_classes` VALUES (33,'messageCategory',14);
INSERT INTO `sys_classes` VALUES (34,'voteCategory',13);
INSERT INTO `sys_classes` VALUES (35,'forum',15);
INSERT INTO `sys_classes` VALUES (36,'category',15);
INSERT INTO `sys_classes` VALUES (37,'thread',15);
INSERT INTO `sys_classes` VALUES (38,'post',15);
INSERT INTO `sys_classes` VALUES (39,'faq',16);
INSERT INTO `sys_classes` VALUES (41,'faqCategory',16);
INSERT INTO `sys_classes` VALUES (42,'faqFolder',16);
INSERT INTO `sys_classes` VALUES (43,'categoryFolder',15);
INSERT INTO `sys_classes` VALUES (44,'tags',17);
INSERT INTO `sys_classes` VALUES (45,'tagsItem',17);
INSERT INTO `sys_classes` VALUES (46,'tagsItemRel',17);

#
# Table structure for table sys_classes_actions
#

CREATE TABLE `sys_classes_actions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `class_id` int(11) unsigned default NULL,
  `action_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `class_id` (`class_id`,`action_id`)
) ENGINE=MyISAM AUTO_INCREMENT=254 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_classes_actions
#

INSERT INTO `sys_classes_actions` VALUES (1,1,1);
INSERT INTO `sys_classes_actions` VALUES (2,1,2);
INSERT INTO `sys_classes_actions` VALUES (3,1,3);
INSERT INTO `sys_classes_actions` VALUES (4,1,9);
INSERT INTO `sys_classes_actions` VALUES (5,2,4);
INSERT INTO `sys_classes_actions` VALUES (6,2,5);
INSERT INTO `sys_classes_actions` VALUES (7,2,6);
INSERT INTO `sys_classes_actions` VALUES (8,2,7);
INSERT INTO `sys_classes_actions` VALUES (9,2,8);
INSERT INTO `sys_classes_actions` VALUES (10,2,9);
INSERT INTO `sys_classes_actions` VALUES (11,3,10);
INSERT INTO `sys_classes_actions` VALUES (12,3,11);
INSERT INTO `sys_classes_actions` VALUES (13,3,5);
INSERT INTO `sys_classes_actions` VALUES (14,3,1);
INSERT INTO `sys_classes_actions` VALUES (15,3,12);
INSERT INTO `sys_classes_actions` VALUES (16,3,2);
INSERT INTO `sys_classes_actions` VALUES (17,4,13);
INSERT INTO `sys_classes_actions` VALUES (18,4,14);
INSERT INTO `sys_classes_actions` VALUES (19,4,15);
INSERT INTO `sys_classes_actions` VALUES (20,4,16);
INSERT INTO `sys_classes_actions` VALUES (21,4,17);
INSERT INTO `sys_classes_actions` VALUES (22,3,9);
INSERT INTO `sys_classes_actions` VALUES (23,4,9);
INSERT INTO `sys_classes_actions` VALUES (24,6,3);
INSERT INTO `sys_classes_actions` VALUES (25,6,9);
INSERT INTO `sys_classes_actions` VALUES (28,6,1);
INSERT INTO `sys_classes_actions` VALUES (29,6,2);
INSERT INTO `sys_classes_actions` VALUES (31,7,18);
INSERT INTO `sys_classes_actions` VALUES (32,7,9);
INSERT INTO `sys_classes_actions` VALUES (34,9,3);
INSERT INTO `sys_classes_actions` VALUES (35,9,9);
INSERT INTO `sys_classes_actions` VALUES (36,10,1);
INSERT INTO `sys_classes_actions` VALUES (37,10,2);
INSERT INTO `sys_classes_actions` VALUES (38,10,9);
INSERT INTO `sys_classes_actions` VALUES (39,11,5);
INSERT INTO `sys_classes_actions` VALUES (40,11,19);
INSERT INTO `sys_classes_actions` VALUES (41,11,9);
INSERT INTO `sys_classes_actions` VALUES (42,9,20);
INSERT INTO `sys_classes_actions` VALUES (46,13,9);
INSERT INTO `sys_classes_actions` VALUES (47,13,7);
INSERT INTO `sys_classes_actions` VALUES (48,13,6);
INSERT INTO `sys_classes_actions` VALUES (49,13,4);
INSERT INTO `sys_classes_actions` VALUES (50,13,5);
INSERT INTO `sys_classes_actions` VALUES (51,9,21);
INSERT INTO `sys_classes_actions` VALUES (62,18,27);
INSERT INTO `sys_classes_actions` VALUES (63,17,1);
INSERT INTO `sys_classes_actions` VALUES (64,17,28);
INSERT INTO `sys_classes_actions` VALUES (65,17,2);
INSERT INTO `sys_classes_actions` VALUES (66,17,9);
INSERT INTO `sys_classes_actions` VALUES (67,18,9);
INSERT INTO `sys_classes_actions` VALUES (68,17,18);
INSERT INTO `sys_classes_actions` VALUES (69,18,18);
INSERT INTO `sys_classes_actions` VALUES (70,1,29);
INSERT INTO `sys_classes_actions` VALUES (71,17,29);
INSERT INTO `sys_classes_actions` VALUES (72,18,6);
INSERT INTO `sys_classes_actions` VALUES (73,18,8);
INSERT INTO `sys_classes_actions` VALUES (74,18,7);
INSERT INTO `sys_classes_actions` VALUES (76,2,30);
INSERT INTO `sys_classes_actions` VALUES (77,18,30);
INSERT INTO `sys_classes_actions` VALUES (91,13,8);
INSERT INTO `sys_classes_actions` VALUES (92,13,30);
INSERT INTO `sys_classes_actions` VALUES (95,19,2);
INSERT INTO `sys_classes_actions` VALUES (99,20,5);
INSERT INTO `sys_classes_actions` VALUES (100,20,4);
INSERT INTO `sys_classes_actions` VALUES (102,20,6);
INSERT INTO `sys_classes_actions` VALUES (103,20,7);
INSERT INTO `sys_classes_actions` VALUES (104,20,30);
INSERT INTO `sys_classes_actions` VALUES (105,20,8);
INSERT INTO `sys_classes_actions` VALUES (107,19,29);
INSERT INTO `sys_classes_actions` VALUES (108,19,1);
INSERT INTO `sys_classes_actions` VALUES (109,17,20);
INSERT INTO `sys_classes_actions` VALUES (110,18,20);
INSERT INTO `sys_classes_actions` VALUES (111,19,9);
INSERT INTO `sys_classes_actions` VALUES (114,7,20);
INSERT INTO `sys_classes_actions` VALUES (115,20,9);
INSERT INTO `sys_classes_actions` VALUES (116,6,29);
INSERT INTO `sys_classes_actions` VALUES (121,19,20);
INSERT INTO `sys_classes_actions` VALUES (126,3,4);
INSERT INTO `sys_classes_actions` VALUES (127,4,51);
INSERT INTO `sys_classes_actions` VALUES (129,19,3);
INSERT INTO `sys_classes_actions` VALUES (130,21,9);
INSERT INTO `sys_classes_actions` VALUES (131,22,9);
INSERT INTO `sys_classes_actions` VALUES (132,23,9);
INSERT INTO `sys_classes_actions` VALUES (133,21,52);
INSERT INTO `sys_classes_actions` VALUES (134,21,53);
INSERT INTO `sys_classes_actions` VALUES (135,22,54);
INSERT INTO `sys_classes_actions` VALUES (136,22,55);
INSERT INTO `sys_classes_actions` VALUES (137,22,56);
INSERT INTO `sys_classes_actions` VALUES (138,23,57);
INSERT INTO `sys_classes_actions` VALUES (139,23,2);
INSERT INTO `sys_classes_actions` VALUES (141,23,3);
INSERT INTO `sys_classes_actions` VALUES (143,23,59);
INSERT INTO `sys_classes_actions` VALUES (144,23,60);
INSERT INTO `sys_classes_actions` VALUES (145,24,9);
INSERT INTO `sys_classes_actions` VALUES (146,25,9);
INSERT INTO `sys_classes_actions` VALUES (147,25,3);
INSERT INTO `sys_classes_actions` VALUES (151,24,1);
INSERT INTO `sys_classes_actions` VALUES (152,24,4);
INSERT INTO `sys_classes_actions` VALUES (155,25,62);
INSERT INTO `sys_classes_actions` VALUES (156,24,2);
INSERT INTO `sys_classes_actions` VALUES (157,26,9);
INSERT INTO `sys_classes_actions` VALUES (158,26,20);
INSERT INTO `sys_classes_actions` VALUES (160,26,63);
INSERT INTO `sys_classes_actions` VALUES (161,25,64);
INSERT INTO `sys_classes_actions` VALUES (167,3,69);
INSERT INTO `sys_classes_actions` VALUES (168,21,20);
INSERT INTO `sys_classes_actions` VALUES (169,28,9);
INSERT INTO `sys_classes_actions` VALUES (170,29,9);
INSERT INTO `sys_classes_actions` VALUES (171,30,9);
INSERT INTO `sys_classes_actions` VALUES (172,31,9);
INSERT INTO `sys_classes_actions` VALUES (174,28,3);
INSERT INTO `sys_classes_actions` VALUES (176,28,70);
INSERT INTO `sys_classes_actions` VALUES (177,28,1);
INSERT INTO `sys_classes_actions` VALUES (178,28,19);
INSERT INTO `sys_classes_actions` VALUES (179,32,9);
INSERT INTO `sys_classes_actions` VALUES (180,33,9);
INSERT INTO `sys_classes_actions` VALUES (181,33,5);
INSERT INTO `sys_classes_actions` VALUES (182,32,3);
INSERT INTO `sys_classes_actions` VALUES (185,33,71);
INSERT INTO `sys_classes_actions` VALUES (186,32,2);
INSERT INTO `sys_classes_actions` VALUES (187,30,20);
INSERT INTO `sys_classes_actions` VALUES (189,28,2);
INSERT INTO `sys_classes_actions` VALUES (190,34,9);
INSERT INTO `sys_classes_actions` VALUES (192,34,4);
INSERT INTO `sys_classes_actions` VALUES (194,30,72);
INSERT INTO `sys_classes_actions` VALUES (195,34,73);
INSERT INTO `sys_classes_actions` VALUES (196,34,74);
INSERT INTO `sys_classes_actions` VALUES (197,34,75);
INSERT INTO `sys_classes_actions` VALUES (198,22,76);
INSERT INTO `sys_classes_actions` VALUES (199,24,29);
INSERT INTO `sys_classes_actions` VALUES (200,35,9);
INSERT INTO `sys_classes_actions` VALUES (201,36,9);
INSERT INTO `sys_classes_actions` VALUES (202,37,9);
INSERT INTO `sys_classes_actions` VALUES (203,38,9);
INSERT INTO `sys_classes_actions` VALUES (205,39,9);
INSERT INTO `sys_classes_actions` VALUES (206,40,9);
INSERT INTO `sys_classes_actions` VALUES (207,41,9);
INSERT INTO `sys_classes_actions` VALUES (208,42,9);
INSERT INTO `sys_classes_actions` VALUES (209,41,5);
INSERT INTO `sys_classes_actions` VALUES (210,41,4);
INSERT INTO `sys_classes_actions` VALUES (211,39,1);
INSERT INTO `sys_classes_actions` VALUES (212,39,2);
INSERT INTO `sys_classes_actions` VALUES (214,41,77);
INSERT INTO `sys_classes_actions` VALUES (215,42,20);
INSERT INTO `sys_classes_actions` VALUES (216,42,78);
INSERT INTO `sys_classes_actions` VALUES (217,41,79);
INSERT INTO `sys_classes_actions` VALUES (218,43,9);
INSERT INTO `sys_classes_actions` VALUES (219,43,80);
INSERT INTO `sys_classes_actions` VALUES (221,37,81);
INSERT INTO `sys_classes_actions` VALUES (222,35,5);
INSERT INTO `sys_classes_actions` VALUES (223,35,82);
INSERT INTO `sys_classes_actions` VALUES (224,37,19);
INSERT INTO `sys_classes_actions` VALUES (225,38,1);
INSERT INTO `sys_classes_actions` VALUES (226,43,83);
INSERT INTO `sys_classes_actions` VALUES (227,35,20);
INSERT INTO `sys_classes_actions` VALUES (229,36,74);
INSERT INTO `sys_classes_actions` VALUES (230,36,84);
INSERT INTO `sys_classes_actions` VALUES (231,35,85);
INSERT INTO `sys_classes_actions` VALUES (232,37,66);
INSERT INTO `sys_classes_actions` VALUES (233,38,86);
INSERT INTO `sys_classes_actions` VALUES (234,37,87);
INSERT INTO `sys_classes_actions` VALUES (235,37,88);
INSERT INTO `sys_classes_actions` VALUES (239,25,91);
INSERT INTO `sys_classes_actions` VALUES (240,18,5);
INSERT INTO `sys_classes_actions` VALUES (241,18,92);
INSERT INTO `sys_classes_actions` VALUES (242,44,9);
INSERT INTO `sys_classes_actions` VALUES (243,45,9);
INSERT INTO `sys_classes_actions` VALUES (244,46,9);
INSERT INTO `sys_classes_actions` VALUES (249,45,96);
INSERT INTO `sys_classes_actions` VALUES (250,45,95);
INSERT INTO `sys_classes_actions` VALUES (251,45,94);
INSERT INTO `sys_classes_actions` VALUES (252,45,5);
INSERT INTO `sys_classes_actions` VALUES (253,1,97);

#
# Table structure for table sys_classes_sections
#

CREATE TABLE `sys_classes_sections` (
  `id` int(11) NOT NULL auto_increment,
  `class_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_section` (`section_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_classes_sections
#

INSERT INTO `sys_classes_sections` VALUES (1,1,1);
INSERT INTO `sys_classes_sections` VALUES (2,2,1);
INSERT INTO `sys_classes_sections` VALUES (3,3,2);
INSERT INTO `sys_classes_sections` VALUES (4,4,2);
INSERT INTO `sys_classes_sections` VALUES (6,6,4);
INSERT INTO `sys_classes_sections` VALUES (7,7,6);
INSERT INTO `sys_classes_sections` VALUES (8,8,2);
INSERT INTO `sys_classes_sections` VALUES (9,9,7);
INSERT INTO `sys_classes_sections` VALUES (10,10,8);
INSERT INTO `sys_classes_sections` VALUES (11,11,8);
INSERT INTO `sys_classes_sections` VALUES (12,12,2);
INSERT INTO `sys_classes_sections` VALUES (13,13,4);
INSERT INTO `sys_classes_sections` VALUES (14,17,9);
INSERT INTO `sys_classes_sections` VALUES (15,18,9);
INSERT INTO `sys_classes_sections` VALUES (16,19,10);
INSERT INTO `sys_classes_sections` VALUES (17,20,10);
INSERT INTO `sys_classes_sections` VALUES (18,22,11);
INSERT INTO `sys_classes_sections` VALUES (19,21,11);
INSERT INTO `sys_classes_sections` VALUES (20,23,11);
INSERT INTO `sys_classes_sections` VALUES (21,24,12);
INSERT INTO `sys_classes_sections` VALUES (22,25,12);
INSERT INTO `sys_classes_sections` VALUES (23,26,12);
INSERT INTO `sys_classes_sections` VALUES (24,27,2);
INSERT INTO `sys_classes_sections` VALUES (25,28,13);
INSERT INTO `sys_classes_sections` VALUES (26,29,13);
INSERT INTO `sys_classes_sections` VALUES (27,30,13);
INSERT INTO `sys_classes_sections` VALUES (28,31,13);
INSERT INTO `sys_classes_sections` VALUES (29,32,14);
INSERT INTO `sys_classes_sections` VALUES (30,33,14);
INSERT INTO `sys_classes_sections` VALUES (31,34,13);
INSERT INTO `sys_classes_sections` VALUES (32,35,15);
INSERT INTO `sys_classes_sections` VALUES (33,36,15);
INSERT INTO `sys_classes_sections` VALUES (34,37,15);
INSERT INTO `sys_classes_sections` VALUES (35,38,15);
INSERT INTO `sys_classes_sections` VALUES (36,39,16);
INSERT INTO `sys_classes_sections` VALUES (37,41,16);
INSERT INTO `sys_classes_sections` VALUES (38,42,16);
INSERT INTO `sys_classes_sections` VALUES (39,43,15);
INSERT INTO `sys_classes_sections` VALUES (40,45,17);
INSERT INTO `sys_classes_sections` VALUES (41,44,17);
INSERT INTO `sys_classes_sections` VALUES (42,46,17);

#
# Table structure for table sys_modules
#

CREATE TABLE `sys_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `main_class` int(11) unsigned default NULL,
  `title` char(255) default NULL,
  `icon` char(255) default NULL,
  `order` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_modules
#

INSERT INTO `sys_modules` VALUES (1,'news',1,'�������','news.gif',10);
INSERT INTO `sys_modules` VALUES (2,'user',3,'������������','users.gif',90);
INSERT INTO `sys_modules` VALUES (4,'page',6,'��������','pages.gif',20);
INSERT INTO `sys_modules` VALUES (5,'access',7,'����� �������','access.gif',10);
INSERT INTO `sys_modules` VALUES (6,'admin',9,'�����������������','admin.gif',20);
INSERT INTO `sys_modules` VALUES (8,'comments',10,'�����������','comments.gif',40);
INSERT INTO `sys_modules` VALUES (9,'fileManager',17,'�������� ������','fm.gif',50);
INSERT INTO `sys_modules` VALUES (10,'catalogue',19,'�������','catalogue.gif',30);
INSERT INTO `sys_modules` VALUES (11,'gallery',21,'�������','gallery.gif',80);
INSERT INTO `sys_modules` VALUES (12,'menu',26,'����','pages.gif',90);
INSERT INTO `sys_modules` VALUES (13,'voting',30,'�����������','voting.gif',0);
INSERT INTO `sys_modules` VALUES (14,'message',32,'��������� �������������','page.gif',0);
INSERT INTO `sys_modules` VALUES (15,'forum',35,'�����','',0);
INSERT INTO `sys_modules` VALUES (16,'faq',42,'FAQ','',0);
INSERT INTO `sys_modules` VALUES (17,'tags',45,'','',0);

#
# Table structure for table sys_obj_id
#

CREATE TABLE `sys_obj_id` (
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1174 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_obj_id
#

INSERT INTO `sys_obj_id` VALUES (15);
INSERT INTO `sys_obj_id` VALUES (16);
INSERT INTO `sys_obj_id` VALUES (17);
INSERT INTO `sys_obj_id` VALUES (18);
INSERT INTO `sys_obj_id` VALUES (19);
INSERT INTO `sys_obj_id` VALUES (20);
INSERT INTO `sys_obj_id` VALUES (21);
INSERT INTO `sys_obj_id` VALUES (22);
INSERT INTO `sys_obj_id` VALUES (23);
INSERT INTO `sys_obj_id` VALUES (24);
INSERT INTO `sys_obj_id` VALUES (25);
INSERT INTO `sys_obj_id` VALUES (26);
INSERT INTO `sys_obj_id` VALUES (27);
INSERT INTO `sys_obj_id` VALUES (28);
INSERT INTO `sys_obj_id` VALUES (29);
INSERT INTO `sys_obj_id` VALUES (30);
INSERT INTO `sys_obj_id` VALUES (31);
INSERT INTO `sys_obj_id` VALUES (32);
INSERT INTO `sys_obj_id` VALUES (33);
INSERT INTO `sys_obj_id` VALUES (34);
INSERT INTO `sys_obj_id` VALUES (35);
INSERT INTO `sys_obj_id` VALUES (36);
INSERT INTO `sys_obj_id` VALUES (37);
INSERT INTO `sys_obj_id` VALUES (38);
INSERT INTO `sys_obj_id` VALUES (39);
INSERT INTO `sys_obj_id` VALUES (40);
INSERT INTO `sys_obj_id` VALUES (41);
INSERT INTO `sys_obj_id` VALUES (42);
INSERT INTO `sys_obj_id` VALUES (43);
INSERT INTO `sys_obj_id` VALUES (44);
INSERT INTO `sys_obj_id` VALUES (45);
INSERT INTO `sys_obj_id` VALUES (46);
INSERT INTO `sys_obj_id` VALUES (47);
INSERT INTO `sys_obj_id` VALUES (48);
INSERT INTO `sys_obj_id` VALUES (49);
INSERT INTO `sys_obj_id` VALUES (50);
INSERT INTO `sys_obj_id` VALUES (51);
INSERT INTO `sys_obj_id` VALUES (52);
INSERT INTO `sys_obj_id` VALUES (53);
INSERT INTO `sys_obj_id` VALUES (54);
INSERT INTO `sys_obj_id` VALUES (55);
INSERT INTO `sys_obj_id` VALUES (56);
INSERT INTO `sys_obj_id` VALUES (57);
INSERT INTO `sys_obj_id` VALUES (58);
INSERT INTO `sys_obj_id` VALUES (59);
INSERT INTO `sys_obj_id` VALUES (60);
INSERT INTO `sys_obj_id` VALUES (61);
INSERT INTO `sys_obj_id` VALUES (62);
INSERT INTO `sys_obj_id` VALUES (63);
INSERT INTO `sys_obj_id` VALUES (64);
INSERT INTO `sys_obj_id` VALUES (65);
INSERT INTO `sys_obj_id` VALUES (66);
INSERT INTO `sys_obj_id` VALUES (67);
INSERT INTO `sys_obj_id` VALUES (68);
INSERT INTO `sys_obj_id` VALUES (69);
INSERT INTO `sys_obj_id` VALUES (70);
INSERT INTO `sys_obj_id` VALUES (71);
INSERT INTO `sys_obj_id` VALUES (72);
INSERT INTO `sys_obj_id` VALUES (73);
INSERT INTO `sys_obj_id` VALUES (74);
INSERT INTO `sys_obj_id` VALUES (75);
INSERT INTO `sys_obj_id` VALUES (76);
INSERT INTO `sys_obj_id` VALUES (77);
INSERT INTO `sys_obj_id` VALUES (78);
INSERT INTO `sys_obj_id` VALUES (79);
INSERT INTO `sys_obj_id` VALUES (80);
INSERT INTO `sys_obj_id` VALUES (81);
INSERT INTO `sys_obj_id` VALUES (82);
INSERT INTO `sys_obj_id` VALUES (83);
INSERT INTO `sys_obj_id` VALUES (84);
INSERT INTO `sys_obj_id` VALUES (85);
INSERT INTO `sys_obj_id` VALUES (86);
INSERT INTO `sys_obj_id` VALUES (87);
INSERT INTO `sys_obj_id` VALUES (88);
INSERT INTO `sys_obj_id` VALUES (89);
INSERT INTO `sys_obj_id` VALUES (90);
INSERT INTO `sys_obj_id` VALUES (91);
INSERT INTO `sys_obj_id` VALUES (92);
INSERT INTO `sys_obj_id` VALUES (93);
INSERT INTO `sys_obj_id` VALUES (94);
INSERT INTO `sys_obj_id` VALUES (95);
INSERT INTO `sys_obj_id` VALUES (96);
INSERT INTO `sys_obj_id` VALUES (97);
INSERT INTO `sys_obj_id` VALUES (98);
INSERT INTO `sys_obj_id` VALUES (99);
INSERT INTO `sys_obj_id` VALUES (100);
INSERT INTO `sys_obj_id` VALUES (101);
INSERT INTO `sys_obj_id` VALUES (102);
INSERT INTO `sys_obj_id` VALUES (103);
INSERT INTO `sys_obj_id` VALUES (104);
INSERT INTO `sys_obj_id` VALUES (105);
INSERT INTO `sys_obj_id` VALUES (106);
INSERT INTO `sys_obj_id` VALUES (107);
INSERT INTO `sys_obj_id` VALUES (108);
INSERT INTO `sys_obj_id` VALUES (109);
INSERT INTO `sys_obj_id` VALUES (110);
INSERT INTO `sys_obj_id` VALUES (111);
INSERT INTO `sys_obj_id` VALUES (112);
INSERT INTO `sys_obj_id` VALUES (113);
INSERT INTO `sys_obj_id` VALUES (114);
INSERT INTO `sys_obj_id` VALUES (115);
INSERT INTO `sys_obj_id` VALUES (116);
INSERT INTO `sys_obj_id` VALUES (117);
INSERT INTO `sys_obj_id` VALUES (118);
INSERT INTO `sys_obj_id` VALUES (119);
INSERT INTO `sys_obj_id` VALUES (120);
INSERT INTO `sys_obj_id` VALUES (121);
INSERT INTO `sys_obj_id` VALUES (122);
INSERT INTO `sys_obj_id` VALUES (123);
INSERT INTO `sys_obj_id` VALUES (124);
INSERT INTO `sys_obj_id` VALUES (125);
INSERT INTO `sys_obj_id` VALUES (126);
INSERT INTO `sys_obj_id` VALUES (127);
INSERT INTO `sys_obj_id` VALUES (128);
INSERT INTO `sys_obj_id` VALUES (129);
INSERT INTO `sys_obj_id` VALUES (130);
INSERT INTO `sys_obj_id` VALUES (131);
INSERT INTO `sys_obj_id` VALUES (132);
INSERT INTO `sys_obj_id` VALUES (133);
INSERT INTO `sys_obj_id` VALUES (134);
INSERT INTO `sys_obj_id` VALUES (135);
INSERT INTO `sys_obj_id` VALUES (136);
INSERT INTO `sys_obj_id` VALUES (137);
INSERT INTO `sys_obj_id` VALUES (138);
INSERT INTO `sys_obj_id` VALUES (139);
INSERT INTO `sys_obj_id` VALUES (140);
INSERT INTO `sys_obj_id` VALUES (141);
INSERT INTO `sys_obj_id` VALUES (142);
INSERT INTO `sys_obj_id` VALUES (143);
INSERT INTO `sys_obj_id` VALUES (144);
INSERT INTO `sys_obj_id` VALUES (145);
INSERT INTO `sys_obj_id` VALUES (146);
INSERT INTO `sys_obj_id` VALUES (147);
INSERT INTO `sys_obj_id` VALUES (148);
INSERT INTO `sys_obj_id` VALUES (149);
INSERT INTO `sys_obj_id` VALUES (150);
INSERT INTO `sys_obj_id` VALUES (151);
INSERT INTO `sys_obj_id` VALUES (152);
INSERT INTO `sys_obj_id` VALUES (153);
INSERT INTO `sys_obj_id` VALUES (154);
INSERT INTO `sys_obj_id` VALUES (155);
INSERT INTO `sys_obj_id` VALUES (156);
INSERT INTO `sys_obj_id` VALUES (157);
INSERT INTO `sys_obj_id` VALUES (158);
INSERT INTO `sys_obj_id` VALUES (159);
INSERT INTO `sys_obj_id` VALUES (160);
INSERT INTO `sys_obj_id` VALUES (161);
INSERT INTO `sys_obj_id` VALUES (162);
INSERT INTO `sys_obj_id` VALUES (163);
INSERT INTO `sys_obj_id` VALUES (164);
INSERT INTO `sys_obj_id` VALUES (165);
INSERT INTO `sys_obj_id` VALUES (166);
INSERT INTO `sys_obj_id` VALUES (167);
INSERT INTO `sys_obj_id` VALUES (168);
INSERT INTO `sys_obj_id` VALUES (169);
INSERT INTO `sys_obj_id` VALUES (170);
INSERT INTO `sys_obj_id` VALUES (171);
INSERT INTO `sys_obj_id` VALUES (172);
INSERT INTO `sys_obj_id` VALUES (173);
INSERT INTO `sys_obj_id` VALUES (174);
INSERT INTO `sys_obj_id` VALUES (175);
INSERT INTO `sys_obj_id` VALUES (176);
INSERT INTO `sys_obj_id` VALUES (177);
INSERT INTO `sys_obj_id` VALUES (178);
INSERT INTO `sys_obj_id` VALUES (179);
INSERT INTO `sys_obj_id` VALUES (180);
INSERT INTO `sys_obj_id` VALUES (181);
INSERT INTO `sys_obj_id` VALUES (182);
INSERT INTO `sys_obj_id` VALUES (183);
INSERT INTO `sys_obj_id` VALUES (184);
INSERT INTO `sys_obj_id` VALUES (185);
INSERT INTO `sys_obj_id` VALUES (186);
INSERT INTO `sys_obj_id` VALUES (187);
INSERT INTO `sys_obj_id` VALUES (188);
INSERT INTO `sys_obj_id` VALUES (189);
INSERT INTO `sys_obj_id` VALUES (190);
INSERT INTO `sys_obj_id` VALUES (191);
INSERT INTO `sys_obj_id` VALUES (192);
INSERT INTO `sys_obj_id` VALUES (193);
INSERT INTO `sys_obj_id` VALUES (194);
INSERT INTO `sys_obj_id` VALUES (195);
INSERT INTO `sys_obj_id` VALUES (196);
INSERT INTO `sys_obj_id` VALUES (197);
INSERT INTO `sys_obj_id` VALUES (198);
INSERT INTO `sys_obj_id` VALUES (199);
INSERT INTO `sys_obj_id` VALUES (200);
INSERT INTO `sys_obj_id` VALUES (201);
INSERT INTO `sys_obj_id` VALUES (202);
INSERT INTO `sys_obj_id` VALUES (203);
INSERT INTO `sys_obj_id` VALUES (204);
INSERT INTO `sys_obj_id` VALUES (205);
INSERT INTO `sys_obj_id` VALUES (206);
INSERT INTO `sys_obj_id` VALUES (207);
INSERT INTO `sys_obj_id` VALUES (208);
INSERT INTO `sys_obj_id` VALUES (209);
INSERT INTO `sys_obj_id` VALUES (210);
INSERT INTO `sys_obj_id` VALUES (211);
INSERT INTO `sys_obj_id` VALUES (212);
INSERT INTO `sys_obj_id` VALUES (213);
INSERT INTO `sys_obj_id` VALUES (214);
INSERT INTO `sys_obj_id` VALUES (215);
INSERT INTO `sys_obj_id` VALUES (216);
INSERT INTO `sys_obj_id` VALUES (217);
INSERT INTO `sys_obj_id` VALUES (218);
INSERT INTO `sys_obj_id` VALUES (219);
INSERT INTO `sys_obj_id` VALUES (220);
INSERT INTO `sys_obj_id` VALUES (221);
INSERT INTO `sys_obj_id` VALUES (222);
INSERT INTO `sys_obj_id` VALUES (223);
INSERT INTO `sys_obj_id` VALUES (224);
INSERT INTO `sys_obj_id` VALUES (225);
INSERT INTO `sys_obj_id` VALUES (226);
INSERT INTO `sys_obj_id` VALUES (227);
INSERT INTO `sys_obj_id` VALUES (228);
INSERT INTO `sys_obj_id` VALUES (229);
INSERT INTO `sys_obj_id` VALUES (230);
INSERT INTO `sys_obj_id` VALUES (231);
INSERT INTO `sys_obj_id` VALUES (232);
INSERT INTO `sys_obj_id` VALUES (233);
INSERT INTO `sys_obj_id` VALUES (234);
INSERT INTO `sys_obj_id` VALUES (235);
INSERT INTO `sys_obj_id` VALUES (236);
INSERT INTO `sys_obj_id` VALUES (237);
INSERT INTO `sys_obj_id` VALUES (238);
INSERT INTO `sys_obj_id` VALUES (239);
INSERT INTO `sys_obj_id` VALUES (240);
INSERT INTO `sys_obj_id` VALUES (241);
INSERT INTO `sys_obj_id` VALUES (242);
INSERT INTO `sys_obj_id` VALUES (243);
INSERT INTO `sys_obj_id` VALUES (244);
INSERT INTO `sys_obj_id` VALUES (245);
INSERT INTO `sys_obj_id` VALUES (246);
INSERT INTO `sys_obj_id` VALUES (247);
INSERT INTO `sys_obj_id` VALUES (248);
INSERT INTO `sys_obj_id` VALUES (249);
INSERT INTO `sys_obj_id` VALUES (250);
INSERT INTO `sys_obj_id` VALUES (251);
INSERT INTO `sys_obj_id` VALUES (252);
INSERT INTO `sys_obj_id` VALUES (253);
INSERT INTO `sys_obj_id` VALUES (254);
INSERT INTO `sys_obj_id` VALUES (255);
INSERT INTO `sys_obj_id` VALUES (256);
INSERT INTO `sys_obj_id` VALUES (257);
INSERT INTO `sys_obj_id` VALUES (258);
INSERT INTO `sys_obj_id` VALUES (259);
INSERT INTO `sys_obj_id` VALUES (260);
INSERT INTO `sys_obj_id` VALUES (261);
INSERT INTO `sys_obj_id` VALUES (262);
INSERT INTO `sys_obj_id` VALUES (263);
INSERT INTO `sys_obj_id` VALUES (264);
INSERT INTO `sys_obj_id` VALUES (265);
INSERT INTO `sys_obj_id` VALUES (266);
INSERT INTO `sys_obj_id` VALUES (267);
INSERT INTO `sys_obj_id` VALUES (268);
INSERT INTO `sys_obj_id` VALUES (269);
INSERT INTO `sys_obj_id` VALUES (270);
INSERT INTO `sys_obj_id` VALUES (271);
INSERT INTO `sys_obj_id` VALUES (272);
INSERT INTO `sys_obj_id` VALUES (273);
INSERT INTO `sys_obj_id` VALUES (274);
INSERT INTO `sys_obj_id` VALUES (275);
INSERT INTO `sys_obj_id` VALUES (276);
INSERT INTO `sys_obj_id` VALUES (277);
INSERT INTO `sys_obj_id` VALUES (278);
INSERT INTO `sys_obj_id` VALUES (279);
INSERT INTO `sys_obj_id` VALUES (280);
INSERT INTO `sys_obj_id` VALUES (281);
INSERT INTO `sys_obj_id` VALUES (282);
INSERT INTO `sys_obj_id` VALUES (283);
INSERT INTO `sys_obj_id` VALUES (284);
INSERT INTO `sys_obj_id` VALUES (285);
INSERT INTO `sys_obj_id` VALUES (286);
INSERT INTO `sys_obj_id` VALUES (287);
INSERT INTO `sys_obj_id` VALUES (288);
INSERT INTO `sys_obj_id` VALUES (289);
INSERT INTO `sys_obj_id` VALUES (290);
INSERT INTO `sys_obj_id` VALUES (291);
INSERT INTO `sys_obj_id` VALUES (292);
INSERT INTO `sys_obj_id` VALUES (293);
INSERT INTO `sys_obj_id` VALUES (294);
INSERT INTO `sys_obj_id` VALUES (295);
INSERT INTO `sys_obj_id` VALUES (296);
INSERT INTO `sys_obj_id` VALUES (297);
INSERT INTO `sys_obj_id` VALUES (298);
INSERT INTO `sys_obj_id` VALUES (299);
INSERT INTO `sys_obj_id` VALUES (300);
INSERT INTO `sys_obj_id` VALUES (301);
INSERT INTO `sys_obj_id` VALUES (302);
INSERT INTO `sys_obj_id` VALUES (303);
INSERT INTO `sys_obj_id` VALUES (304);
INSERT INTO `sys_obj_id` VALUES (305);
INSERT INTO `sys_obj_id` VALUES (306);
INSERT INTO `sys_obj_id` VALUES (307);
INSERT INTO `sys_obj_id` VALUES (308);
INSERT INTO `sys_obj_id` VALUES (309);
INSERT INTO `sys_obj_id` VALUES (310);
INSERT INTO `sys_obj_id` VALUES (311);
INSERT INTO `sys_obj_id` VALUES (312);
INSERT INTO `sys_obj_id` VALUES (313);
INSERT INTO `sys_obj_id` VALUES (314);
INSERT INTO `sys_obj_id` VALUES (315);
INSERT INTO `sys_obj_id` VALUES (316);
INSERT INTO `sys_obj_id` VALUES (317);
INSERT INTO `sys_obj_id` VALUES (318);
INSERT INTO `sys_obj_id` VALUES (319);
INSERT INTO `sys_obj_id` VALUES (320);
INSERT INTO `sys_obj_id` VALUES (321);
INSERT INTO `sys_obj_id` VALUES (322);
INSERT INTO `sys_obj_id` VALUES (323);
INSERT INTO `sys_obj_id` VALUES (324);
INSERT INTO `sys_obj_id` VALUES (325);
INSERT INTO `sys_obj_id` VALUES (326);
INSERT INTO `sys_obj_id` VALUES (327);
INSERT INTO `sys_obj_id` VALUES (328);
INSERT INTO `sys_obj_id` VALUES (329);
INSERT INTO `sys_obj_id` VALUES (330);
INSERT INTO `sys_obj_id` VALUES (331);
INSERT INTO `sys_obj_id` VALUES (332);
INSERT INTO `sys_obj_id` VALUES (333);
INSERT INTO `sys_obj_id` VALUES (334);
INSERT INTO `sys_obj_id` VALUES (335);
INSERT INTO `sys_obj_id` VALUES (336);
INSERT INTO `sys_obj_id` VALUES (337);
INSERT INTO `sys_obj_id` VALUES (338);
INSERT INTO `sys_obj_id` VALUES (339);
INSERT INTO `sys_obj_id` VALUES (340);
INSERT INTO `sys_obj_id` VALUES (341);
INSERT INTO `sys_obj_id` VALUES (342);
INSERT INTO `sys_obj_id` VALUES (343);
INSERT INTO `sys_obj_id` VALUES (344);
INSERT INTO `sys_obj_id` VALUES (345);
INSERT INTO `sys_obj_id` VALUES (346);
INSERT INTO `sys_obj_id` VALUES (347);
INSERT INTO `sys_obj_id` VALUES (348);
INSERT INTO `sys_obj_id` VALUES (349);
INSERT INTO `sys_obj_id` VALUES (350);
INSERT INTO `sys_obj_id` VALUES (351);
INSERT INTO `sys_obj_id` VALUES (352);
INSERT INTO `sys_obj_id` VALUES (353);
INSERT INTO `sys_obj_id` VALUES (354);
INSERT INTO `sys_obj_id` VALUES (355);
INSERT INTO `sys_obj_id` VALUES (356);
INSERT INTO `sys_obj_id` VALUES (357);
INSERT INTO `sys_obj_id` VALUES (358);
INSERT INTO `sys_obj_id` VALUES (359);
INSERT INTO `sys_obj_id` VALUES (360);
INSERT INTO `sys_obj_id` VALUES (361);
INSERT INTO `sys_obj_id` VALUES (362);
INSERT INTO `sys_obj_id` VALUES (363);
INSERT INTO `sys_obj_id` VALUES (364);
INSERT INTO `sys_obj_id` VALUES (365);
INSERT INTO `sys_obj_id` VALUES (366);
INSERT INTO `sys_obj_id` VALUES (367);
INSERT INTO `sys_obj_id` VALUES (368);
INSERT INTO `sys_obj_id` VALUES (369);
INSERT INTO `sys_obj_id` VALUES (370);
INSERT INTO `sys_obj_id` VALUES (371);
INSERT INTO `sys_obj_id` VALUES (372);
INSERT INTO `sys_obj_id` VALUES (373);
INSERT INTO `sys_obj_id` VALUES (374);
INSERT INTO `sys_obj_id` VALUES (375);
INSERT INTO `sys_obj_id` VALUES (376);
INSERT INTO `sys_obj_id` VALUES (377);
INSERT INTO `sys_obj_id` VALUES (378);
INSERT INTO `sys_obj_id` VALUES (379);
INSERT INTO `sys_obj_id` VALUES (380);
INSERT INTO `sys_obj_id` VALUES (381);
INSERT INTO `sys_obj_id` VALUES (382);
INSERT INTO `sys_obj_id` VALUES (383);
INSERT INTO `sys_obj_id` VALUES (384);
INSERT INTO `sys_obj_id` VALUES (385);
INSERT INTO `sys_obj_id` VALUES (386);
INSERT INTO `sys_obj_id` VALUES (387);
INSERT INTO `sys_obj_id` VALUES (388);
INSERT INTO `sys_obj_id` VALUES (389);
INSERT INTO `sys_obj_id` VALUES (390);
INSERT INTO `sys_obj_id` VALUES (391);
INSERT INTO `sys_obj_id` VALUES (392);
INSERT INTO `sys_obj_id` VALUES (393);
INSERT INTO `sys_obj_id` VALUES (394);
INSERT INTO `sys_obj_id` VALUES (395);
INSERT INTO `sys_obj_id` VALUES (396);
INSERT INTO `sys_obj_id` VALUES (397);
INSERT INTO `sys_obj_id` VALUES (398);
INSERT INTO `sys_obj_id` VALUES (399);
INSERT INTO `sys_obj_id` VALUES (400);
INSERT INTO `sys_obj_id` VALUES (401);
INSERT INTO `sys_obj_id` VALUES (402);
INSERT INTO `sys_obj_id` VALUES (403);
INSERT INTO `sys_obj_id` VALUES (404);
INSERT INTO `sys_obj_id` VALUES (405);
INSERT INTO `sys_obj_id` VALUES (406);
INSERT INTO `sys_obj_id` VALUES (407);
INSERT INTO `sys_obj_id` VALUES (408);
INSERT INTO `sys_obj_id` VALUES (409);
INSERT INTO `sys_obj_id` VALUES (410);
INSERT INTO `sys_obj_id` VALUES (411);
INSERT INTO `sys_obj_id` VALUES (412);
INSERT INTO `sys_obj_id` VALUES (413);
INSERT INTO `sys_obj_id` VALUES (414);
INSERT INTO `sys_obj_id` VALUES (415);
INSERT INTO `sys_obj_id` VALUES (416);
INSERT INTO `sys_obj_id` VALUES (417);
INSERT INTO `sys_obj_id` VALUES (418);
INSERT INTO `sys_obj_id` VALUES (419);
INSERT INTO `sys_obj_id` VALUES (420);
INSERT INTO `sys_obj_id` VALUES (421);
INSERT INTO `sys_obj_id` VALUES (422);
INSERT INTO `sys_obj_id` VALUES (423);
INSERT INTO `sys_obj_id` VALUES (424);
INSERT INTO `sys_obj_id` VALUES (425);
INSERT INTO `sys_obj_id` VALUES (426);
INSERT INTO `sys_obj_id` VALUES (427);
INSERT INTO `sys_obj_id` VALUES (428);
INSERT INTO `sys_obj_id` VALUES (429);
INSERT INTO `sys_obj_id` VALUES (430);
INSERT INTO `sys_obj_id` VALUES (431);
INSERT INTO `sys_obj_id` VALUES (432);
INSERT INTO `sys_obj_id` VALUES (433);
INSERT INTO `sys_obj_id` VALUES (434);
INSERT INTO `sys_obj_id` VALUES (435);
INSERT INTO `sys_obj_id` VALUES (436);
INSERT INTO `sys_obj_id` VALUES (437);
INSERT INTO `sys_obj_id` VALUES (438);
INSERT INTO `sys_obj_id` VALUES (439);
INSERT INTO `sys_obj_id` VALUES (440);
INSERT INTO `sys_obj_id` VALUES (441);
INSERT INTO `sys_obj_id` VALUES (442);
INSERT INTO `sys_obj_id` VALUES (443);
INSERT INTO `sys_obj_id` VALUES (444);
INSERT INTO `sys_obj_id` VALUES (445);
INSERT INTO `sys_obj_id` VALUES (446);
INSERT INTO `sys_obj_id` VALUES (447);
INSERT INTO `sys_obj_id` VALUES (448);
INSERT INTO `sys_obj_id` VALUES (449);
INSERT INTO `sys_obj_id` VALUES (450);
INSERT INTO `sys_obj_id` VALUES (451);
INSERT INTO `sys_obj_id` VALUES (452);
INSERT INTO `sys_obj_id` VALUES (453);
INSERT INTO `sys_obj_id` VALUES (454);
INSERT INTO `sys_obj_id` VALUES (455);
INSERT INTO `sys_obj_id` VALUES (456);
INSERT INTO `sys_obj_id` VALUES (457);
INSERT INTO `sys_obj_id` VALUES (458);
INSERT INTO `sys_obj_id` VALUES (459);
INSERT INTO `sys_obj_id` VALUES (460);
INSERT INTO `sys_obj_id` VALUES (461);
INSERT INTO `sys_obj_id` VALUES (462);
INSERT INTO `sys_obj_id` VALUES (463);
INSERT INTO `sys_obj_id` VALUES (464);
INSERT INTO `sys_obj_id` VALUES (465);
INSERT INTO `sys_obj_id` VALUES (466);
INSERT INTO `sys_obj_id` VALUES (467);
INSERT INTO `sys_obj_id` VALUES (468);
INSERT INTO `sys_obj_id` VALUES (469);
INSERT INTO `sys_obj_id` VALUES (470);
INSERT INTO `sys_obj_id` VALUES (471);
INSERT INTO `sys_obj_id` VALUES (472);
INSERT INTO `sys_obj_id` VALUES (473);
INSERT INTO `sys_obj_id` VALUES (474);
INSERT INTO `sys_obj_id` VALUES (475);
INSERT INTO `sys_obj_id` VALUES (476);
INSERT INTO `sys_obj_id` VALUES (477);
INSERT INTO `sys_obj_id` VALUES (478);
INSERT INTO `sys_obj_id` VALUES (479);
INSERT INTO `sys_obj_id` VALUES (480);
INSERT INTO `sys_obj_id` VALUES (481);
INSERT INTO `sys_obj_id` VALUES (482);
INSERT INTO `sys_obj_id` VALUES (483);
INSERT INTO `sys_obj_id` VALUES (484);
INSERT INTO `sys_obj_id` VALUES (485);
INSERT INTO `sys_obj_id` VALUES (486);
INSERT INTO `sys_obj_id` VALUES (487);
INSERT INTO `sys_obj_id` VALUES (488);
INSERT INTO `sys_obj_id` VALUES (489);
INSERT INTO `sys_obj_id` VALUES (490);
INSERT INTO `sys_obj_id` VALUES (491);
INSERT INTO `sys_obj_id` VALUES (492);
INSERT INTO `sys_obj_id` VALUES (493);
INSERT INTO `sys_obj_id` VALUES (494);
INSERT INTO `sys_obj_id` VALUES (495);
INSERT INTO `sys_obj_id` VALUES (496);
INSERT INTO `sys_obj_id` VALUES (497);
INSERT INTO `sys_obj_id` VALUES (498);
INSERT INTO `sys_obj_id` VALUES (499);
INSERT INTO `sys_obj_id` VALUES (500);
INSERT INTO `sys_obj_id` VALUES (501);
INSERT INTO `sys_obj_id` VALUES (502);
INSERT INTO `sys_obj_id` VALUES (503);
INSERT INTO `sys_obj_id` VALUES (504);
INSERT INTO `sys_obj_id` VALUES (505);
INSERT INTO `sys_obj_id` VALUES (506);
INSERT INTO `sys_obj_id` VALUES (507);
INSERT INTO `sys_obj_id` VALUES (508);
INSERT INTO `sys_obj_id` VALUES (509);
INSERT INTO `sys_obj_id` VALUES (510);
INSERT INTO `sys_obj_id` VALUES (511);
INSERT INTO `sys_obj_id` VALUES (512);
INSERT INTO `sys_obj_id` VALUES (513);
INSERT INTO `sys_obj_id` VALUES (514);
INSERT INTO `sys_obj_id` VALUES (515);
INSERT INTO `sys_obj_id` VALUES (516);
INSERT INTO `sys_obj_id` VALUES (517);
INSERT INTO `sys_obj_id` VALUES (518);
INSERT INTO `sys_obj_id` VALUES (519);
INSERT INTO `sys_obj_id` VALUES (520);
INSERT INTO `sys_obj_id` VALUES (521);
INSERT INTO `sys_obj_id` VALUES (522);
INSERT INTO `sys_obj_id` VALUES (523);
INSERT INTO `sys_obj_id` VALUES (524);
INSERT INTO `sys_obj_id` VALUES (525);
INSERT INTO `sys_obj_id` VALUES (526);
INSERT INTO `sys_obj_id` VALUES (527);
INSERT INTO `sys_obj_id` VALUES (528);
INSERT INTO `sys_obj_id` VALUES (529);
INSERT INTO `sys_obj_id` VALUES (530);
INSERT INTO `sys_obj_id` VALUES (531);
INSERT INTO `sys_obj_id` VALUES (532);
INSERT INTO `sys_obj_id` VALUES (533);
INSERT INTO `sys_obj_id` VALUES (534);
INSERT INTO `sys_obj_id` VALUES (535);
INSERT INTO `sys_obj_id` VALUES (536);
INSERT INTO `sys_obj_id` VALUES (537);
INSERT INTO `sys_obj_id` VALUES (538);
INSERT INTO `sys_obj_id` VALUES (539);
INSERT INTO `sys_obj_id` VALUES (540);
INSERT INTO `sys_obj_id` VALUES (541);
INSERT INTO `sys_obj_id` VALUES (542);
INSERT INTO `sys_obj_id` VALUES (543);
INSERT INTO `sys_obj_id` VALUES (544);
INSERT INTO `sys_obj_id` VALUES (545);
INSERT INTO `sys_obj_id` VALUES (546);
INSERT INTO `sys_obj_id` VALUES (547);
INSERT INTO `sys_obj_id` VALUES (548);
INSERT INTO `sys_obj_id` VALUES (549);
INSERT INTO `sys_obj_id` VALUES (550);
INSERT INTO `sys_obj_id` VALUES (551);
INSERT INTO `sys_obj_id` VALUES (552);
INSERT INTO `sys_obj_id` VALUES (553);
INSERT INTO `sys_obj_id` VALUES (554);
INSERT INTO `sys_obj_id` VALUES (555);
INSERT INTO `sys_obj_id` VALUES (556);
INSERT INTO `sys_obj_id` VALUES (557);
INSERT INTO `sys_obj_id` VALUES (558);
INSERT INTO `sys_obj_id` VALUES (559);
INSERT INTO `sys_obj_id` VALUES (560);
INSERT INTO `sys_obj_id` VALUES (561);
INSERT INTO `sys_obj_id` VALUES (562);
INSERT INTO `sys_obj_id` VALUES (563);
INSERT INTO `sys_obj_id` VALUES (564);
INSERT INTO `sys_obj_id` VALUES (565);
INSERT INTO `sys_obj_id` VALUES (566);
INSERT INTO `sys_obj_id` VALUES (567);
INSERT INTO `sys_obj_id` VALUES (568);
INSERT INTO `sys_obj_id` VALUES (569);
INSERT INTO `sys_obj_id` VALUES (570);
INSERT INTO `sys_obj_id` VALUES (571);
INSERT INTO `sys_obj_id` VALUES (572);
INSERT INTO `sys_obj_id` VALUES (573);
INSERT INTO `sys_obj_id` VALUES (574);
INSERT INTO `sys_obj_id` VALUES (575);
INSERT INTO `sys_obj_id` VALUES (576);
INSERT INTO `sys_obj_id` VALUES (577);
INSERT INTO `sys_obj_id` VALUES (578);
INSERT INTO `sys_obj_id` VALUES (579);
INSERT INTO `sys_obj_id` VALUES (580);
INSERT INTO `sys_obj_id` VALUES (581);
INSERT INTO `sys_obj_id` VALUES (582);
INSERT INTO `sys_obj_id` VALUES (583);
INSERT INTO `sys_obj_id` VALUES (584);
INSERT INTO `sys_obj_id` VALUES (585);
INSERT INTO `sys_obj_id` VALUES (586);
INSERT INTO `sys_obj_id` VALUES (587);
INSERT INTO `sys_obj_id` VALUES (588);
INSERT INTO `sys_obj_id` VALUES (589);
INSERT INTO `sys_obj_id` VALUES (590);
INSERT INTO `sys_obj_id` VALUES (591);
INSERT INTO `sys_obj_id` VALUES (592);
INSERT INTO `sys_obj_id` VALUES (593);
INSERT INTO `sys_obj_id` VALUES (594);
INSERT INTO `sys_obj_id` VALUES (595);
INSERT INTO `sys_obj_id` VALUES (596);
INSERT INTO `sys_obj_id` VALUES (597);
INSERT INTO `sys_obj_id` VALUES (598);
INSERT INTO `sys_obj_id` VALUES (599);
INSERT INTO `sys_obj_id` VALUES (600);
INSERT INTO `sys_obj_id` VALUES (601);
INSERT INTO `sys_obj_id` VALUES (602);
INSERT INTO `sys_obj_id` VALUES (603);
INSERT INTO `sys_obj_id` VALUES (604);
INSERT INTO `sys_obj_id` VALUES (605);
INSERT INTO `sys_obj_id` VALUES (606);
INSERT INTO `sys_obj_id` VALUES (607);
INSERT INTO `sys_obj_id` VALUES (608);
INSERT INTO `sys_obj_id` VALUES (609);
INSERT INTO `sys_obj_id` VALUES (610);
INSERT INTO `sys_obj_id` VALUES (611);
INSERT INTO `sys_obj_id` VALUES (612);
INSERT INTO `sys_obj_id` VALUES (613);
INSERT INTO `sys_obj_id` VALUES (614);
INSERT INTO `sys_obj_id` VALUES (615);
INSERT INTO `sys_obj_id` VALUES (616);
INSERT INTO `sys_obj_id` VALUES (617);
INSERT INTO `sys_obj_id` VALUES (618);
INSERT INTO `sys_obj_id` VALUES (619);
INSERT INTO `sys_obj_id` VALUES (620);
INSERT INTO `sys_obj_id` VALUES (621);
INSERT INTO `sys_obj_id` VALUES (622);
INSERT INTO `sys_obj_id` VALUES (623);
INSERT INTO `sys_obj_id` VALUES (624);
INSERT INTO `sys_obj_id` VALUES (625);
INSERT INTO `sys_obj_id` VALUES (626);
INSERT INTO `sys_obj_id` VALUES (627);
INSERT INTO `sys_obj_id` VALUES (628);
INSERT INTO `sys_obj_id` VALUES (629);
INSERT INTO `sys_obj_id` VALUES (630);
INSERT INTO `sys_obj_id` VALUES (631);
INSERT INTO `sys_obj_id` VALUES (632);
INSERT INTO `sys_obj_id` VALUES (633);
INSERT INTO `sys_obj_id` VALUES (634);
INSERT INTO `sys_obj_id` VALUES (635);
INSERT INTO `sys_obj_id` VALUES (636);
INSERT INTO `sys_obj_id` VALUES (637);
INSERT INTO `sys_obj_id` VALUES (638);
INSERT INTO `sys_obj_id` VALUES (639);
INSERT INTO `sys_obj_id` VALUES (640);
INSERT INTO `sys_obj_id` VALUES (641);
INSERT INTO `sys_obj_id` VALUES (642);
INSERT INTO `sys_obj_id` VALUES (643);
INSERT INTO `sys_obj_id` VALUES (644);
INSERT INTO `sys_obj_id` VALUES (645);
INSERT INTO `sys_obj_id` VALUES (646);
INSERT INTO `sys_obj_id` VALUES (647);
INSERT INTO `sys_obj_id` VALUES (648);
INSERT INTO `sys_obj_id` VALUES (649);
INSERT INTO `sys_obj_id` VALUES (650);
INSERT INTO `sys_obj_id` VALUES (651);
INSERT INTO `sys_obj_id` VALUES (652);
INSERT INTO `sys_obj_id` VALUES (653);
INSERT INTO `sys_obj_id` VALUES (654);
INSERT INTO `sys_obj_id` VALUES (655);
INSERT INTO `sys_obj_id` VALUES (656);
INSERT INTO `sys_obj_id` VALUES (657);
INSERT INTO `sys_obj_id` VALUES (658);
INSERT INTO `sys_obj_id` VALUES (659);
INSERT INTO `sys_obj_id` VALUES (660);
INSERT INTO `sys_obj_id` VALUES (661);
INSERT INTO `sys_obj_id` VALUES (662);
INSERT INTO `sys_obj_id` VALUES (663);
INSERT INTO `sys_obj_id` VALUES (664);
INSERT INTO `sys_obj_id` VALUES (665);
INSERT INTO `sys_obj_id` VALUES (666);
INSERT INTO `sys_obj_id` VALUES (667);
INSERT INTO `sys_obj_id` VALUES (668);
INSERT INTO `sys_obj_id` VALUES (669);
INSERT INTO `sys_obj_id` VALUES (670);
INSERT INTO `sys_obj_id` VALUES (671);
INSERT INTO `sys_obj_id` VALUES (672);
INSERT INTO `sys_obj_id` VALUES (673);
INSERT INTO `sys_obj_id` VALUES (674);
INSERT INTO `sys_obj_id` VALUES (675);
INSERT INTO `sys_obj_id` VALUES (676);
INSERT INTO `sys_obj_id` VALUES (677);
INSERT INTO `sys_obj_id` VALUES (678);
INSERT INTO `sys_obj_id` VALUES (679);
INSERT INTO `sys_obj_id` VALUES (680);
INSERT INTO `sys_obj_id` VALUES (681);
INSERT INTO `sys_obj_id` VALUES (682);
INSERT INTO `sys_obj_id` VALUES (683);
INSERT INTO `sys_obj_id` VALUES (684);
INSERT INTO `sys_obj_id` VALUES (685);
INSERT INTO `sys_obj_id` VALUES (686);
INSERT INTO `sys_obj_id` VALUES (687);
INSERT INTO `sys_obj_id` VALUES (688);
INSERT INTO `sys_obj_id` VALUES (689);
INSERT INTO `sys_obj_id` VALUES (690);
INSERT INTO `sys_obj_id` VALUES (691);
INSERT INTO `sys_obj_id` VALUES (692);
INSERT INTO `sys_obj_id` VALUES (693);
INSERT INTO `sys_obj_id` VALUES (694);
INSERT INTO `sys_obj_id` VALUES (695);
INSERT INTO `sys_obj_id` VALUES (696);
INSERT INTO `sys_obj_id` VALUES (697);
INSERT INTO `sys_obj_id` VALUES (698);
INSERT INTO `sys_obj_id` VALUES (699);
INSERT INTO `sys_obj_id` VALUES (700);
INSERT INTO `sys_obj_id` VALUES (701);
INSERT INTO `sys_obj_id` VALUES (702);
INSERT INTO `sys_obj_id` VALUES (703);
INSERT INTO `sys_obj_id` VALUES (704);
INSERT INTO `sys_obj_id` VALUES (705);
INSERT INTO `sys_obj_id` VALUES (706);
INSERT INTO `sys_obj_id` VALUES (707);
INSERT INTO `sys_obj_id` VALUES (708);
INSERT INTO `sys_obj_id` VALUES (709);
INSERT INTO `sys_obj_id` VALUES (710);
INSERT INTO `sys_obj_id` VALUES (711);
INSERT INTO `sys_obj_id` VALUES (712);
INSERT INTO `sys_obj_id` VALUES (713);
INSERT INTO `sys_obj_id` VALUES (714);
INSERT INTO `sys_obj_id` VALUES (715);
INSERT INTO `sys_obj_id` VALUES (716);
INSERT INTO `sys_obj_id` VALUES (717);
INSERT INTO `sys_obj_id` VALUES (718);
INSERT INTO `sys_obj_id` VALUES (719);
INSERT INTO `sys_obj_id` VALUES (720);
INSERT INTO `sys_obj_id` VALUES (721);
INSERT INTO `sys_obj_id` VALUES (722);
INSERT INTO `sys_obj_id` VALUES (723);
INSERT INTO `sys_obj_id` VALUES (724);
INSERT INTO `sys_obj_id` VALUES (725);
INSERT INTO `sys_obj_id` VALUES (726);
INSERT INTO `sys_obj_id` VALUES (727);
INSERT INTO `sys_obj_id` VALUES (728);
INSERT INTO `sys_obj_id` VALUES (729);
INSERT INTO `sys_obj_id` VALUES (730);
INSERT INTO `sys_obj_id` VALUES (731);
INSERT INTO `sys_obj_id` VALUES (732);
INSERT INTO `sys_obj_id` VALUES (733);
INSERT INTO `sys_obj_id` VALUES (734);
INSERT INTO `sys_obj_id` VALUES (735);
INSERT INTO `sys_obj_id` VALUES (736);
INSERT INTO `sys_obj_id` VALUES (737);
INSERT INTO `sys_obj_id` VALUES (738);
INSERT INTO `sys_obj_id` VALUES (739);
INSERT INTO `sys_obj_id` VALUES (740);
INSERT INTO `sys_obj_id` VALUES (741);
INSERT INTO `sys_obj_id` VALUES (742);
INSERT INTO `sys_obj_id` VALUES (743);
INSERT INTO `sys_obj_id` VALUES (744);
INSERT INTO `sys_obj_id` VALUES (745);
INSERT INTO `sys_obj_id` VALUES (746);
INSERT INTO `sys_obj_id` VALUES (747);
INSERT INTO `sys_obj_id` VALUES (748);
INSERT INTO `sys_obj_id` VALUES (749);
INSERT INTO `sys_obj_id` VALUES (750);
INSERT INTO `sys_obj_id` VALUES (751);
INSERT INTO `sys_obj_id` VALUES (752);
INSERT INTO `sys_obj_id` VALUES (753);
INSERT INTO `sys_obj_id` VALUES (754);
INSERT INTO `sys_obj_id` VALUES (755);
INSERT INTO `sys_obj_id` VALUES (756);
INSERT INTO `sys_obj_id` VALUES (757);
INSERT INTO `sys_obj_id` VALUES (758);
INSERT INTO `sys_obj_id` VALUES (759);
INSERT INTO `sys_obj_id` VALUES (760);
INSERT INTO `sys_obj_id` VALUES (761);
INSERT INTO `sys_obj_id` VALUES (762);
INSERT INTO `sys_obj_id` VALUES (763);
INSERT INTO `sys_obj_id` VALUES (764);
INSERT INTO `sys_obj_id` VALUES (765);
INSERT INTO `sys_obj_id` VALUES (766);
INSERT INTO `sys_obj_id` VALUES (767);
INSERT INTO `sys_obj_id` VALUES (768);
INSERT INTO `sys_obj_id` VALUES (769);
INSERT INTO `sys_obj_id` VALUES (770);
INSERT INTO `sys_obj_id` VALUES (771);
INSERT INTO `sys_obj_id` VALUES (772);
INSERT INTO `sys_obj_id` VALUES (773);
INSERT INTO `sys_obj_id` VALUES (774);
INSERT INTO `sys_obj_id` VALUES (775);
INSERT INTO `sys_obj_id` VALUES (776);
INSERT INTO `sys_obj_id` VALUES (777);
INSERT INTO `sys_obj_id` VALUES (778);
INSERT INTO `sys_obj_id` VALUES (779);
INSERT INTO `sys_obj_id` VALUES (780);
INSERT INTO `sys_obj_id` VALUES (781);
INSERT INTO `sys_obj_id` VALUES (782);
INSERT INTO `sys_obj_id` VALUES (783);
INSERT INTO `sys_obj_id` VALUES (784);
INSERT INTO `sys_obj_id` VALUES (785);
INSERT INTO `sys_obj_id` VALUES (786);
INSERT INTO `sys_obj_id` VALUES (787);
INSERT INTO `sys_obj_id` VALUES (788);
INSERT INTO `sys_obj_id` VALUES (789);
INSERT INTO `sys_obj_id` VALUES (790);
INSERT INTO `sys_obj_id` VALUES (791);
INSERT INTO `sys_obj_id` VALUES (792);
INSERT INTO `sys_obj_id` VALUES (793);
INSERT INTO `sys_obj_id` VALUES (794);
INSERT INTO `sys_obj_id` VALUES (795);
INSERT INTO `sys_obj_id` VALUES (796);
INSERT INTO `sys_obj_id` VALUES (797);
INSERT INTO `sys_obj_id` VALUES (798);
INSERT INTO `sys_obj_id` VALUES (799);
INSERT INTO `sys_obj_id` VALUES (800);
INSERT INTO `sys_obj_id` VALUES (801);
INSERT INTO `sys_obj_id` VALUES (802);
INSERT INTO `sys_obj_id` VALUES (803);
INSERT INTO `sys_obj_id` VALUES (804);
INSERT INTO `sys_obj_id` VALUES (805);
INSERT INTO `sys_obj_id` VALUES (806);
INSERT INTO `sys_obj_id` VALUES (807);
INSERT INTO `sys_obj_id` VALUES (808);
INSERT INTO `sys_obj_id` VALUES (809);
INSERT INTO `sys_obj_id` VALUES (810);
INSERT INTO `sys_obj_id` VALUES (811);
INSERT INTO `sys_obj_id` VALUES (812);
INSERT INTO `sys_obj_id` VALUES (813);
INSERT INTO `sys_obj_id` VALUES (814);
INSERT INTO `sys_obj_id` VALUES (815);
INSERT INTO `sys_obj_id` VALUES (816);
INSERT INTO `sys_obj_id` VALUES (817);
INSERT INTO `sys_obj_id` VALUES (818);
INSERT INTO `sys_obj_id` VALUES (819);
INSERT INTO `sys_obj_id` VALUES (820);
INSERT INTO `sys_obj_id` VALUES (821);
INSERT INTO `sys_obj_id` VALUES (822);
INSERT INTO `sys_obj_id` VALUES (823);
INSERT INTO `sys_obj_id` VALUES (824);
INSERT INTO `sys_obj_id` VALUES (825);
INSERT INTO `sys_obj_id` VALUES (826);
INSERT INTO `sys_obj_id` VALUES (827);
INSERT INTO `sys_obj_id` VALUES (828);
INSERT INTO `sys_obj_id` VALUES (829);
INSERT INTO `sys_obj_id` VALUES (830);
INSERT INTO `sys_obj_id` VALUES (831);
INSERT INTO `sys_obj_id` VALUES (832);
INSERT INTO `sys_obj_id` VALUES (833);
INSERT INTO `sys_obj_id` VALUES (834);
INSERT INTO `sys_obj_id` VALUES (835);
INSERT INTO `sys_obj_id` VALUES (836);
INSERT INTO `sys_obj_id` VALUES (837);
INSERT INTO `sys_obj_id` VALUES (838);
INSERT INTO `sys_obj_id` VALUES (839);
INSERT INTO `sys_obj_id` VALUES (840);
INSERT INTO `sys_obj_id` VALUES (841);
INSERT INTO `sys_obj_id` VALUES (842);
INSERT INTO `sys_obj_id` VALUES (843);
INSERT INTO `sys_obj_id` VALUES (844);
INSERT INTO `sys_obj_id` VALUES (845);
INSERT INTO `sys_obj_id` VALUES (846);
INSERT INTO `sys_obj_id` VALUES (847);
INSERT INTO `sys_obj_id` VALUES (848);
INSERT INTO `sys_obj_id` VALUES (849);
INSERT INTO `sys_obj_id` VALUES (850);
INSERT INTO `sys_obj_id` VALUES (851);
INSERT INTO `sys_obj_id` VALUES (852);
INSERT INTO `sys_obj_id` VALUES (853);
INSERT INTO `sys_obj_id` VALUES (854);
INSERT INTO `sys_obj_id` VALUES (855);
INSERT INTO `sys_obj_id` VALUES (856);
INSERT INTO `sys_obj_id` VALUES (857);
INSERT INTO `sys_obj_id` VALUES (858);
INSERT INTO `sys_obj_id` VALUES (859);
INSERT INTO `sys_obj_id` VALUES (860);
INSERT INTO `sys_obj_id` VALUES (861);
INSERT INTO `sys_obj_id` VALUES (862);
INSERT INTO `sys_obj_id` VALUES (863);
INSERT INTO `sys_obj_id` VALUES (864);
INSERT INTO `sys_obj_id` VALUES (865);
INSERT INTO `sys_obj_id` VALUES (866);
INSERT INTO `sys_obj_id` VALUES (867);
INSERT INTO `sys_obj_id` VALUES (868);
INSERT INTO `sys_obj_id` VALUES (869);
INSERT INTO `sys_obj_id` VALUES (870);
INSERT INTO `sys_obj_id` VALUES (871);
INSERT INTO `sys_obj_id` VALUES (872);
INSERT INTO `sys_obj_id` VALUES (873);
INSERT INTO `sys_obj_id` VALUES (874);
INSERT INTO `sys_obj_id` VALUES (875);
INSERT INTO `sys_obj_id` VALUES (876);
INSERT INTO `sys_obj_id` VALUES (877);
INSERT INTO `sys_obj_id` VALUES (878);
INSERT INTO `sys_obj_id` VALUES (879);
INSERT INTO `sys_obj_id` VALUES (880);
INSERT INTO `sys_obj_id` VALUES (881);
INSERT INTO `sys_obj_id` VALUES (882);
INSERT INTO `sys_obj_id` VALUES (883);
INSERT INTO `sys_obj_id` VALUES (884);
INSERT INTO `sys_obj_id` VALUES (885);
INSERT INTO `sys_obj_id` VALUES (886);
INSERT INTO `sys_obj_id` VALUES (887);
INSERT INTO `sys_obj_id` VALUES (888);
INSERT INTO `sys_obj_id` VALUES (889);
INSERT INTO `sys_obj_id` VALUES (890);
INSERT INTO `sys_obj_id` VALUES (891);
INSERT INTO `sys_obj_id` VALUES (892);
INSERT INTO `sys_obj_id` VALUES (893);
INSERT INTO `sys_obj_id` VALUES (894);
INSERT INTO `sys_obj_id` VALUES (895);
INSERT INTO `sys_obj_id` VALUES (896);
INSERT INTO `sys_obj_id` VALUES (897);
INSERT INTO `sys_obj_id` VALUES (898);
INSERT INTO `sys_obj_id` VALUES (899);
INSERT INTO `sys_obj_id` VALUES (900);
INSERT INTO `sys_obj_id` VALUES (901);
INSERT INTO `sys_obj_id` VALUES (902);
INSERT INTO `sys_obj_id` VALUES (903);
INSERT INTO `sys_obj_id` VALUES (904);
INSERT INTO `sys_obj_id` VALUES (905);
INSERT INTO `sys_obj_id` VALUES (906);
INSERT INTO `sys_obj_id` VALUES (907);
INSERT INTO `sys_obj_id` VALUES (908);
INSERT INTO `sys_obj_id` VALUES (909);
INSERT INTO `sys_obj_id` VALUES (910);
INSERT INTO `sys_obj_id` VALUES (911);
INSERT INTO `sys_obj_id` VALUES (912);
INSERT INTO `sys_obj_id` VALUES (913);
INSERT INTO `sys_obj_id` VALUES (914);
INSERT INTO `sys_obj_id` VALUES (915);
INSERT INTO `sys_obj_id` VALUES (916);
INSERT INTO `sys_obj_id` VALUES (917);
INSERT INTO `sys_obj_id` VALUES (918);
INSERT INTO `sys_obj_id` VALUES (919);
INSERT INTO `sys_obj_id` VALUES (920);
INSERT INTO `sys_obj_id` VALUES (921);
INSERT INTO `sys_obj_id` VALUES (922);
INSERT INTO `sys_obj_id` VALUES (923);
INSERT INTO `sys_obj_id` VALUES (924);
INSERT INTO `sys_obj_id` VALUES (925);
INSERT INTO `sys_obj_id` VALUES (926);
INSERT INTO `sys_obj_id` VALUES (927);
INSERT INTO `sys_obj_id` VALUES (928);
INSERT INTO `sys_obj_id` VALUES (929);
INSERT INTO `sys_obj_id` VALUES (930);
INSERT INTO `sys_obj_id` VALUES (931);
INSERT INTO `sys_obj_id` VALUES (932);
INSERT INTO `sys_obj_id` VALUES (933);
INSERT INTO `sys_obj_id` VALUES (934);
INSERT INTO `sys_obj_id` VALUES (935);
INSERT INTO `sys_obj_id` VALUES (936);
INSERT INTO `sys_obj_id` VALUES (937);
INSERT INTO `sys_obj_id` VALUES (938);
INSERT INTO `sys_obj_id` VALUES (939);
INSERT INTO `sys_obj_id` VALUES (940);
INSERT INTO `sys_obj_id` VALUES (941);
INSERT INTO `sys_obj_id` VALUES (942);
INSERT INTO `sys_obj_id` VALUES (943);
INSERT INTO `sys_obj_id` VALUES (944);
INSERT INTO `sys_obj_id` VALUES (945);
INSERT INTO `sys_obj_id` VALUES (946);
INSERT INTO `sys_obj_id` VALUES (947);
INSERT INTO `sys_obj_id` VALUES (948);
INSERT INTO `sys_obj_id` VALUES (949);
INSERT INTO `sys_obj_id` VALUES (950);
INSERT INTO `sys_obj_id` VALUES (951);
INSERT INTO `sys_obj_id` VALUES (952);
INSERT INTO `sys_obj_id` VALUES (953);
INSERT INTO `sys_obj_id` VALUES (954);
INSERT INTO `sys_obj_id` VALUES (955);
INSERT INTO `sys_obj_id` VALUES (956);
INSERT INTO `sys_obj_id` VALUES (957);
INSERT INTO `sys_obj_id` VALUES (958);
INSERT INTO `sys_obj_id` VALUES (959);
INSERT INTO `sys_obj_id` VALUES (960);
INSERT INTO `sys_obj_id` VALUES (961);
INSERT INTO `sys_obj_id` VALUES (962);
INSERT INTO `sys_obj_id` VALUES (963);
INSERT INTO `sys_obj_id` VALUES (964);
INSERT INTO `sys_obj_id` VALUES (965);
INSERT INTO `sys_obj_id` VALUES (966);
INSERT INTO `sys_obj_id` VALUES (967);
INSERT INTO `sys_obj_id` VALUES (968);
INSERT INTO `sys_obj_id` VALUES (969);
INSERT INTO `sys_obj_id` VALUES (970);
INSERT INTO `sys_obj_id` VALUES (971);
INSERT INTO `sys_obj_id` VALUES (972);
INSERT INTO `sys_obj_id` VALUES (973);
INSERT INTO `sys_obj_id` VALUES (974);
INSERT INTO `sys_obj_id` VALUES (975);
INSERT INTO `sys_obj_id` VALUES (976);
INSERT INTO `sys_obj_id` VALUES (977);
INSERT INTO `sys_obj_id` VALUES (978);
INSERT INTO `sys_obj_id` VALUES (979);
INSERT INTO `sys_obj_id` VALUES (980);
INSERT INTO `sys_obj_id` VALUES (981);
INSERT INTO `sys_obj_id` VALUES (982);
INSERT INTO `sys_obj_id` VALUES (983);
INSERT INTO `sys_obj_id` VALUES (984);
INSERT INTO `sys_obj_id` VALUES (985);
INSERT INTO `sys_obj_id` VALUES (986);
INSERT INTO `sys_obj_id` VALUES (987);
INSERT INTO `sys_obj_id` VALUES (988);
INSERT INTO `sys_obj_id` VALUES (989);
INSERT INTO `sys_obj_id` VALUES (990);
INSERT INTO `sys_obj_id` VALUES (991);
INSERT INTO `sys_obj_id` VALUES (992);
INSERT INTO `sys_obj_id` VALUES (993);
INSERT INTO `sys_obj_id` VALUES (994);
INSERT INTO `sys_obj_id` VALUES (995);
INSERT INTO `sys_obj_id` VALUES (996);
INSERT INTO `sys_obj_id` VALUES (997);
INSERT INTO `sys_obj_id` VALUES (998);
INSERT INTO `sys_obj_id` VALUES (999);
INSERT INTO `sys_obj_id` VALUES (1000);
INSERT INTO `sys_obj_id` VALUES (1001);
INSERT INTO `sys_obj_id` VALUES (1002);
INSERT INTO `sys_obj_id` VALUES (1003);
INSERT INTO `sys_obj_id` VALUES (1004);
INSERT INTO `sys_obj_id` VALUES (1005);
INSERT INTO `sys_obj_id` VALUES (1006);
INSERT INTO `sys_obj_id` VALUES (1007);
INSERT INTO `sys_obj_id` VALUES (1008);
INSERT INTO `sys_obj_id` VALUES (1009);
INSERT INTO `sys_obj_id` VALUES (1010);
INSERT INTO `sys_obj_id` VALUES (1011);
INSERT INTO `sys_obj_id` VALUES (1012);
INSERT INTO `sys_obj_id` VALUES (1013);
INSERT INTO `sys_obj_id` VALUES (1014);
INSERT INTO `sys_obj_id` VALUES (1015);
INSERT INTO `sys_obj_id` VALUES (1016);
INSERT INTO `sys_obj_id` VALUES (1017);
INSERT INTO `sys_obj_id` VALUES (1018);
INSERT INTO `sys_obj_id` VALUES (1019);
INSERT INTO `sys_obj_id` VALUES (1020);
INSERT INTO `sys_obj_id` VALUES (1021);
INSERT INTO `sys_obj_id` VALUES (1022);
INSERT INTO `sys_obj_id` VALUES (1023);
INSERT INTO `sys_obj_id` VALUES (1024);
INSERT INTO `sys_obj_id` VALUES (1025);
INSERT INTO `sys_obj_id` VALUES (1026);
INSERT INTO `sys_obj_id` VALUES (1027);
INSERT INTO `sys_obj_id` VALUES (1028);
INSERT INTO `sys_obj_id` VALUES (1029);
INSERT INTO `sys_obj_id` VALUES (1030);
INSERT INTO `sys_obj_id` VALUES (1031);
INSERT INTO `sys_obj_id` VALUES (1032);
INSERT INTO `sys_obj_id` VALUES (1033);
INSERT INTO `sys_obj_id` VALUES (1034);
INSERT INTO `sys_obj_id` VALUES (1035);
INSERT INTO `sys_obj_id` VALUES (1036);
INSERT INTO `sys_obj_id` VALUES (1037);
INSERT INTO `sys_obj_id` VALUES (1038);
INSERT INTO `sys_obj_id` VALUES (1039);
INSERT INTO `sys_obj_id` VALUES (1040);
INSERT INTO `sys_obj_id` VALUES (1041);
INSERT INTO `sys_obj_id` VALUES (1042);
INSERT INTO `sys_obj_id` VALUES (1043);
INSERT INTO `sys_obj_id` VALUES (1044);
INSERT INTO `sys_obj_id` VALUES (1045);
INSERT INTO `sys_obj_id` VALUES (1046);
INSERT INTO `sys_obj_id` VALUES (1047);
INSERT INTO `sys_obj_id` VALUES (1048);
INSERT INTO `sys_obj_id` VALUES (1049);
INSERT INTO `sys_obj_id` VALUES (1050);
INSERT INTO `sys_obj_id` VALUES (1051);
INSERT INTO `sys_obj_id` VALUES (1052);
INSERT INTO `sys_obj_id` VALUES (1053);
INSERT INTO `sys_obj_id` VALUES (1054);
INSERT INTO `sys_obj_id` VALUES (1055);
INSERT INTO `sys_obj_id` VALUES (1056);
INSERT INTO `sys_obj_id` VALUES (1057);
INSERT INTO `sys_obj_id` VALUES (1058);
INSERT INTO `sys_obj_id` VALUES (1059);
INSERT INTO `sys_obj_id` VALUES (1060);
INSERT INTO `sys_obj_id` VALUES (1061);
INSERT INTO `sys_obj_id` VALUES (1062);
INSERT INTO `sys_obj_id` VALUES (1063);
INSERT INTO `sys_obj_id` VALUES (1064);
INSERT INTO `sys_obj_id` VALUES (1065);
INSERT INTO `sys_obj_id` VALUES (1066);
INSERT INTO `sys_obj_id` VALUES (1067);
INSERT INTO `sys_obj_id` VALUES (1068);
INSERT INTO `sys_obj_id` VALUES (1069);
INSERT INTO `sys_obj_id` VALUES (1070);
INSERT INTO `sys_obj_id` VALUES (1071);
INSERT INTO `sys_obj_id` VALUES (1072);
INSERT INTO `sys_obj_id` VALUES (1073);
INSERT INTO `sys_obj_id` VALUES (1074);
INSERT INTO `sys_obj_id` VALUES (1075);
INSERT INTO `sys_obj_id` VALUES (1076);
INSERT INTO `sys_obj_id` VALUES (1077);
INSERT INTO `sys_obj_id` VALUES (1078);
INSERT INTO `sys_obj_id` VALUES (1079);
INSERT INTO `sys_obj_id` VALUES (1080);
INSERT INTO `sys_obj_id` VALUES (1081);
INSERT INTO `sys_obj_id` VALUES (1082);
INSERT INTO `sys_obj_id` VALUES (1083);
INSERT INTO `sys_obj_id` VALUES (1084);
INSERT INTO `sys_obj_id` VALUES (1085);
INSERT INTO `sys_obj_id` VALUES (1086);
INSERT INTO `sys_obj_id` VALUES (1087);
INSERT INTO `sys_obj_id` VALUES (1088);
INSERT INTO `sys_obj_id` VALUES (1089);
INSERT INTO `sys_obj_id` VALUES (1090);
INSERT INTO `sys_obj_id` VALUES (1091);
INSERT INTO `sys_obj_id` VALUES (1092);
INSERT INTO `sys_obj_id` VALUES (1093);
INSERT INTO `sys_obj_id` VALUES (1094);
INSERT INTO `sys_obj_id` VALUES (1095);
INSERT INTO `sys_obj_id` VALUES (1096);
INSERT INTO `sys_obj_id` VALUES (1097);
INSERT INTO `sys_obj_id` VALUES (1098);
INSERT INTO `sys_obj_id` VALUES (1099);
INSERT INTO `sys_obj_id` VALUES (1100);
INSERT INTO `sys_obj_id` VALUES (1101);
INSERT INTO `sys_obj_id` VALUES (1102);
INSERT INTO `sys_obj_id` VALUES (1103);
INSERT INTO `sys_obj_id` VALUES (1104);
INSERT INTO `sys_obj_id` VALUES (1105);
INSERT INTO `sys_obj_id` VALUES (1106);
INSERT INTO `sys_obj_id` VALUES (1107);
INSERT INTO `sys_obj_id` VALUES (1108);
INSERT INTO `sys_obj_id` VALUES (1109);
INSERT INTO `sys_obj_id` VALUES (1110);
INSERT INTO `sys_obj_id` VALUES (1111);
INSERT INTO `sys_obj_id` VALUES (1112);
INSERT INTO `sys_obj_id` VALUES (1113);
INSERT INTO `sys_obj_id` VALUES (1114);
INSERT INTO `sys_obj_id` VALUES (1115);
INSERT INTO `sys_obj_id` VALUES (1116);
INSERT INTO `sys_obj_id` VALUES (1117);
INSERT INTO `sys_obj_id` VALUES (1118);
INSERT INTO `sys_obj_id` VALUES (1119);
INSERT INTO `sys_obj_id` VALUES (1120);
INSERT INTO `sys_obj_id` VALUES (1121);
INSERT INTO `sys_obj_id` VALUES (1122);
INSERT INTO `sys_obj_id` VALUES (1123);
INSERT INTO `sys_obj_id` VALUES (1124);
INSERT INTO `sys_obj_id` VALUES (1125);
INSERT INTO `sys_obj_id` VALUES (1126);
INSERT INTO `sys_obj_id` VALUES (1127);
INSERT INTO `sys_obj_id` VALUES (1128);
INSERT INTO `sys_obj_id` VALUES (1129);
INSERT INTO `sys_obj_id` VALUES (1130);
INSERT INTO `sys_obj_id` VALUES (1131);
INSERT INTO `sys_obj_id` VALUES (1132);
INSERT INTO `sys_obj_id` VALUES (1133);
INSERT INTO `sys_obj_id` VALUES (1134);
INSERT INTO `sys_obj_id` VALUES (1135);
INSERT INTO `sys_obj_id` VALUES (1136);
INSERT INTO `sys_obj_id` VALUES (1137);
INSERT INTO `sys_obj_id` VALUES (1138);
INSERT INTO `sys_obj_id` VALUES (1139);
INSERT INTO `sys_obj_id` VALUES (1140);
INSERT INTO `sys_obj_id` VALUES (1141);
INSERT INTO `sys_obj_id` VALUES (1142);
INSERT INTO `sys_obj_id` VALUES (1143);
INSERT INTO `sys_obj_id` VALUES (1144);
INSERT INTO `sys_obj_id` VALUES (1145);
INSERT INTO `sys_obj_id` VALUES (1146);
INSERT INTO `sys_obj_id` VALUES (1147);
INSERT INTO `sys_obj_id` VALUES (1148);
INSERT INTO `sys_obj_id` VALUES (1149);
INSERT INTO `sys_obj_id` VALUES (1150);
INSERT INTO `sys_obj_id` VALUES (1151);
INSERT INTO `sys_obj_id` VALUES (1152);
INSERT INTO `sys_obj_id` VALUES (1153);
INSERT INTO `sys_obj_id` VALUES (1154);
INSERT INTO `sys_obj_id` VALUES (1155);
INSERT INTO `sys_obj_id` VALUES (1156);
INSERT INTO `sys_obj_id` VALUES (1157);
INSERT INTO `sys_obj_id` VALUES (1158);
INSERT INTO `sys_obj_id` VALUES (1159);
INSERT INTO `sys_obj_id` VALUES (1160);
INSERT INTO `sys_obj_id` VALUES (1161);
INSERT INTO `sys_obj_id` VALUES (1162);
INSERT INTO `sys_obj_id` VALUES (1163);
INSERT INTO `sys_obj_id` VALUES (1164);
INSERT INTO `sys_obj_id` VALUES (1165);
INSERT INTO `sys_obj_id` VALUES (1166);
INSERT INTO `sys_obj_id` VALUES (1167);
INSERT INTO `sys_obj_id` VALUES (1168);
INSERT INTO `sys_obj_id` VALUES (1169);
INSERT INTO `sys_obj_id` VALUES (1170);
INSERT INTO `sys_obj_id` VALUES (1171);
INSERT INTO `sys_obj_id` VALUES (1172);
INSERT INTO `sys_obj_id` VALUES (1173);

#
# Table structure for table sys_obj_id_named
#

CREATE TABLE `sys_obj_id_named` (
  `obj_id` int(11) unsigned default NULL,
  `name` char(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_obj_id_named
#

INSERT INTO `sys_obj_id_named` VALUES (55,'user_userFolder');
INSERT INTO `sys_obj_id_named` VALUES (56,'user_groupFolder');
INSERT INTO `sys_obj_id_named` VALUES (58,'access_groupFolder');
INSERT INTO `sys_obj_id_named` VALUES (71,'access_user_group');
INSERT INTO `sys_obj_id_named` VALUES (60,'news_news');
INSERT INTO `sys_obj_id_named` VALUES (61,'news_newsFolder');
INSERT INTO `sys_obj_id_named` VALUES (62,'access_news_newsFolder');
INSERT INTO `sys_obj_id_named` VALUES (63,'access_news_news');
INSERT INTO `sys_obj_id_named` VALUES (64,'access_page_page');
INSERT INTO `sys_obj_id_named` VALUES (65,'timer_timer');
INSERT INTO `sys_obj_id_named` VALUES (69,'access_admin_admin');
INSERT INTO `sys_obj_id_named` VALUES (72,'access_user_user');
INSERT INTO `sys_obj_id_named` VALUES (73,'access_sys_access');
INSERT INTO `sys_obj_id_named` VALUES (287,'access_timer_timer');
INSERT INTO `sys_obj_id_named` VALUES (75,'access_user_userGroup');
INSERT INTO `sys_obj_id_named` VALUES (95,'access_comments_commentsFolder');
INSERT INTO `sys_obj_id_named` VALUES (94,'access_comments_comments');
INSERT INTO `sys_obj_id_named` VALUES (122,'access_user_userAuth');
INSERT INTO `sys_obj_id_named` VALUES (123,'access_comments_Array');
INSERT INTO `sys_obj_id_named` VALUES (158,'access_foo_foo');
INSERT INTO `sys_obj_id_named` VALUES (162,'access_page_pageFolder');
INSERT INTO `sys_obj_id_named` VALUES (193,'access_fileManager_file');
INSERT INTO `sys_obj_id_named` VALUES (194,'access_fileManager_folder');
INSERT INTO `sys_obj_id_named` VALUES (198,'access_fileManager_fileManager');
INSERT INTO `sys_obj_id_named` VALUES (233,'access_catalogue_catalogue');
INSERT INTO `sys_obj_id_named` VALUES (264,'access_news_catalogue');
INSERT INTO `sys_obj_id_named` VALUES (265,'access_page_news');
INSERT INTO `sys_obj_id_named` VALUES (266,'access_fileManager_page');
INSERT INTO `sys_obj_id_named` VALUES (497,'access_catalogue_catalogueFolder');
INSERT INTO `sys_obj_id_named` VALUES (532,'access_gallery_gallery');
INSERT INTO `sys_obj_id_named` VALUES (635,'access_menu_menu');
INSERT INTO `sys_obj_id_named` VALUES (642,'access_menu_menuItem');
INSERT INTO `sys_obj_id_named` VALUES (644,'access_menu_menuFolder');
INSERT INTO `sys_obj_id_named` VALUES (645,'menu_menuFolder');
INSERT INTO `sys_obj_id_named` VALUES (794,'access_voting_question');
INSERT INTO `sys_obj_id_named` VALUES (795,'access_voting_voteFolder');
INSERT INTO `sys_obj_id_named` VALUES (808,'access_message_message');
INSERT INTO `sys_obj_id_named` VALUES (832,'voting_voteFolder');
INSERT INTO `sys_obj_id_named` VALUES (855,'menu_menuItem');
INSERT INTO `sys_obj_id_named` VALUES (862,'catalogue_catalogue');
INSERT INTO `sys_obj_id_named` VALUES (866,'access_forum_forum');
INSERT INTO `sys_obj_id_named` VALUES (868,'access_faq_faq');
INSERT INTO `sys_obj_id_named` VALUES (869,'access_faq_faqFolder');
INSERT INTO `sys_obj_id_named` VALUES (874,'faq_faqFolder');
INSERT INTO `sys_obj_id_named` VALUES (879,'forum_forumCategoryFolder');
INSERT INTO `sys_obj_id_named` VALUES (882,'access_forum_category');
INSERT INTO `sys_obj_id_named` VALUES (883,'access_forum_post');
INSERT INTO `sys_obj_id_named` VALUES (884,'access_forum_categoryFolder');
INSERT INTO `sys_obj_id_named` VALUES (982,'access_forum_thread');
INSERT INTO `sys_obj_id_named` VALUES (1165,'news_searchByTag');
INSERT INTO `sys_obj_id_named` VALUES (1169,'news_tagsCloud');

#
# Table structure for table sys_sections
#

CREATE TABLE `sys_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `order` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=cp1251;

#
# Dumping data for table sys_sections
#

INSERT INTO `sys_sections` VALUES (1,'news','�������',50);
INSERT INTO `sys_sections` VALUES (2,'user','������������',80);
INSERT INTO `sys_sections` VALUES (4,'page','��������',60);
INSERT INTO `sys_sections` VALUES (6,'sys','���������',0);
INSERT INTO `sys_sections` VALUES (7,'admin','�����������������',10);
INSERT INTO `sys_sections` VALUES (8,'comments','�����������',30);
INSERT INTO `sys_sections` VALUES (9,'fileManager','�������� ������',40);
INSERT INTO `sys_sections` VALUES (10,'catalogue','�������',20);
INSERT INTO `sys_sections` VALUES (11,'gallery','�������',80);
INSERT INTO `sys_sections` VALUES (12,'menu','����',50);
INSERT INTO `sys_sections` VALUES (13,'voting','�����������',0);
INSERT INTO `sys_sections` VALUES (14,'message','��������� �������������',0);
INSERT INTO `sys_sections` VALUES (15,'forum','�����',0);
INSERT INTO `sys_sections` VALUES (16,'faq','',0);
INSERT INTO `sys_sections` VALUES (17,'tags',NULL,NULL);

#
# Table structure for table tags_item_rel
#

CREATE TABLE `tags_item_rel` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag_id` int(10) unsigned default NULL,
  `item_id` int(10) unsigned default NULL,
  `obj_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table tags_item_rel
#

INSERT INTO `tags_item_rel` VALUES (1,1,11,1164);
INSERT INTO `tags_item_rel` VALUES (2,1,12,1168);
INSERT INTO `tags_item_rel` VALUES (3,2,13,1173);

#
# Table structure for table tags_tags
#

CREATE TABLE `tags_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(255) default NULL,
  `obj_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

#
# Dumping data for table tags_tags
#

INSERT INTO `tags_tags` VALUES (1,'�����',1162);
INSERT INTO `tags_tags` VALUES (2,'Google',1172);

#
# Table structure for table tags_tagsitem
#

CREATE TABLE `tags_tagsitem` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `item_obj_id` int(10) unsigned default NULL,
  `obj_id` int(10) unsigned default NULL,
  `owner` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;

#
# Dumping data for table tags_tagsitem
#

INSERT INTO `tags_tagsitem` VALUES (11,331,1161,NULL);
INSERT INTO `tags_tagsitem` VALUES (12,459,1166,NULL);
INSERT INTO `tags_tagsitem` VALUES (13,445,1170,NULL);

#
# Table structure for table user_group
#

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  `is_default` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_group
#

INSERT INTO `user_group` VALUES (1,14,'unauth',NULL);
INSERT INTO `user_group` VALUES (2,15,'auth',1);
INSERT INTO `user_group` VALUES (3,225,'root',0);

#
# Table structure for table user_user
#

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `created` int(11) default NULL,
  `confirmed` varchar(32) default NULL,
  `last_login` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_user
#

INSERT INTO `user_user` VALUES (1,12,'guest','',NULL,NULL,1193225333);
INSERT INTO `user_user` VALUES (2,13,'admin','098f6bcd4621d373cade4e832627b4f6',NULL,NULL,1190001074);
INSERT INTO `user_user` VALUES (3,472,'pedro','098f6bcd4621d373cade4e832627b4f6',1188187851,NULL,1190001055);

#
# Table structure for table user_userauth
#

CREATE TABLE `user_userauth` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned default NULL,
  `ip` char(15) default NULL,
  `hash` char(32) default NULL,
  `obj_id` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_userauth
#

INSERT INTO `user_userauth` VALUES (71,2,'127.0.0.1','0c0b80d11079f5a7a0b2381ff05abc10',NULL,1187831447);
INSERT INTO `user_userauth` VALUES (72,2,'127.0.0.1','4f9252b570591bcf33d0bc3224b12de8',NULL,1187925555);
INSERT INTO `user_userauth` VALUES (81,2,'127.0.0.1','be504534880ccf8dd7c6e1e620c90479',NULL,1188427749);
INSERT INTO `user_userauth` VALUES (82,3,'127.0.0.1','b11d08d01d8d43d4a13af69894287094',NULL,1188430535);
INSERT INTO `user_userauth` VALUES (84,2,'127.0.0.1','0c7731ab2cbc019466ed8b4962bc20f4',NULL,1189865442);
INSERT INTO `user_userauth` VALUES (85,2,'127.0.0.1','923419062bc5d8b61cd739a18a0bcc7b',NULL,1189980243);
INSERT INTO `user_userauth` VALUES (87,3,'127.0.0.1','27795bb192fb7db9b9d1956a5ab64695',NULL,1190000095);
INSERT INTO `user_userauth` VALUES (88,2,'127.0.0.1','2cb55a1503611b24dd8bd14c0dfddd28',NULL,1193226125);

#
# Table structure for table user_usergroup_rel
#

CREATE TABLE `user_usergroup_rel` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_usergroup_rel
#

INSERT INTO `user_usergroup_rel` VALUES (1,1,1,50);
INSERT INTO `user_usergroup_rel` VALUES (23,2,2,47);
INSERT INTO `user_usergroup_rel` VALUES (24,3,2,226);
INSERT INTO `user_usergroup_rel` VALUES (30,2,3,473);

#
# Table structure for table user_useronline
#

CREATE TABLE `user_useronline` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `session` char(32) default NULL,
  `last_activity` int(11) default NULL,
  `url` char(255) default NULL,
  `ip` char(15) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`,`session`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_useronline
#

INSERT INTO `user_useronline` VALUES (173,2,'rdtol7gs9mgoe84buebhjt0vn6',1193226411,'http://mzz/news/america/list','127.0.0.1');
INSERT INTO `user_useronline` VALUES (187,1,'piprf96utfql1nhja73kifiim4',1193225706,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (188,1,'u71g0di5asj7v7upggektk22q3',1193225775,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (189,1,'u1ebmln0qhv9q4bps610p2qgg2',1193225777,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (190,1,'38sfbpdq1tfnefdi7id0pdp242',1193225778,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (191,1,'foab2oavp9kkmsqfkuetiautc7',1193225825,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (192,1,'t9rml24pecrvhr8ioc12fbeh76',1193225938,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (193,1,'1ql55haeqg34r8ovb296il9j72',1193225985,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (194,1,'7oudbnompo68nqg4aab0t9q3b5',1193226011,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (195,1,'vrhh3l5u7cvb4ud48m61kilci1',1193226088,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (197,2,'ehnivcpgb60s4phms4obr20mi0',1193226376,'http://mzz/news','127.0.0.1');
INSERT INTO `user_useronline` VALUES (198,1,'6u8jc0al3729pbrofu15pinn82',1193226318,'http://mzz/favicon.ico','127.0.0.1');
INSERT INTO `user_useronline` VALUES (199,1,'4nrvo1fftoslvhn5gi5b681lo2',1193226348,'http://mzz/favicon.ico','127.0.0.1');

#
# Table structure for table voting_answer
#

CREATE TABLE `voting_answer` (
  `id` int(11) NOT NULL auto_increment,
  `title` char(255) NOT NULL default '',
  `type` smallint(6) default '0',
  `question_id` int(11) NOT NULL default '0',
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251;

#
# Dumping data for table voting_answer
#

INSERT INTO `voting_answer` VALUES (2,'��',0,1,799);
INSERT INTO `voting_answer` VALUES (5,'���',0,1,823);
INSERT INTO `voting_answer` VALUES (10,'���� �������',2,1,854);

#
# Table structure for table voting_question
#

CREATE TABLE `voting_question` (
  `id` int(11) NOT NULL auto_increment,
  `question` char(255) NOT NULL default '',
  `category_id` int(11) default '0',
  `created` int(11) default NULL,
  `expired` int(11) default NULL,
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table voting_question
#

INSERT INTO `voting_question` VALUES (1,'�� ������ � �������� ��������?',1,1186015080,1186188060,796);

#
# Table structure for table voting_vote
#

CREATE TABLE `voting_vote` (
  `id` int(11) NOT NULL auto_increment,
  `answer_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `question_id` int(11) NOT NULL default '0',
  `text` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `question` (`question_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table voting_vote
#


#
# Table structure for table voting_votecategory
#

CREATE TABLE `voting_votecategory` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `obj_id` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Dumping data for table voting_votecategory
#

INSERT INTO `voting_votecategory` VALUES (1,'simple','�������',837);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
