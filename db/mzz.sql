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
# Structure for the `catalogue_catalogue` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogue`;

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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogue` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogue` (`id`, `type_id`, `name`, `editor`, `created`, `obj_id`, `folder_id`) VALUES 
  (2,2,'Комп',10,777,238,1),
  (3,1,'Запор',2,1173870334,272,1);

COMMIT;

#
# Structure for the `catalogue_catalogueFolder` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogueFolder`;

CREATE TABLE `catalogue_catalogueFolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) NOT NULL default '0',
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogueFolder` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogueFolder` (`id`, `obj_id`, `name`, `title`, `parent`, `path`) VALUES 
  (1,241,'root','Основной',1,'root'),
  (2,249,'test','Тестовый',2,'root/test');

COMMIT;

#
# Structure for the `catalogue_catalogueFolder_tree` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogueFolder_tree`;

CREATE TABLE `catalogue_catalogueFolder_tree` (
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
# Data for the `catalogue_catalogueFolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogueFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,4,1),
  (2,2,3,2);

COMMIT;

#
# Structure for the `catalogue_catalogue_data` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogue_data`;

CREATE TABLE `catalogue_catalogue_data` (
  `id` int(11) NOT NULL default '0',
  `property_type` int(11) unsigned default NULL,
  `text` text,
  `char` varchar(255) default NULL,
  `int` int(11) default NULL,
  `date` datetime default NULL,
  `float` float(9,3) default NULL,
  UNIQUE KEY `id` (`id`,`property_type`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogue_data` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogue_data` (`id`, `property_type`, `text`, `char`, `int`, `date`, `float`) VALUES 
  (2,4,NULL,'LG FLATRON L1717S 17''',NULL,NULL,NULL),
  (2,5,NULL,'ATI Radeon x1600Pro',NULL,NULL,NULL),
  (2,6,NULL,'Seagate 5400 80gb',NULL,NULL,NULL),
  (2,18,NULL,'Pentium4 - 2400 MHz',NULL,NULL,NULL),
  (3,17,NULL,'0%',NULL,NULL,NULL),
  (3,12,NULL,NULL,1985,NULL,NULL),
  (3,3,NULL,'Запорожец',NULL,NULL,NULL);

COMMIT;

#
# Structure for the `catalogue_catalogue_properties` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogue_properties`;

CREATE TABLE `catalogue_catalogue_properties` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `type_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogue_properties` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogue_properties` (`id`, `name`, `title`, `type_id`) VALUES 
  (1,'comfort','Комфортабельность',1),
  (2,'year','Год выпуска',3),
  (3,'marka','Марка',1),
  (4,'monitor','Монитор',1),
  (5,'videocard','Видеокарта',1),
  (6,'harddrive','Жесткий диск',1),
  (7,'processor','Процессор',1),
  (9,'test','test',2);

COMMIT;

#
# Structure for the `catalogue_catalogue_properties_types` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogue_properties_types`;

CREATE TABLE `catalogue_catalogue_properties_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogue_properties_types` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogue_properties_types` (`id`, `name`, `title`) VALUES 
  (1,'char','Строка'),
  (2,'float','Число с плавающей точкой'),
  (3,'int','Целое'),
  (4,'text','Текст');

COMMIT;

#
# Structure for the `catalogue_catalogue_types` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogue_types`;

CREATE TABLE `catalogue_catalogue_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogue_types` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogue_types` (`id`, `name`, `title`) VALUES 
  (1,'autos','Автомобили'),
  (2,'computers','Компьютеры'),
  (6,'test','Тестовая');

COMMIT;

#
# Structure for the `catalogue_catalogue_types_props` table : 
#

DROP TABLE IF EXISTS `catalogue_catalogue_types_props`;

CREATE TABLE `catalogue_catalogue_types_props` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `property_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_id` (`type_id`,`property_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `catalogue_catalogue_types_props` table  (LIMIT 0,500)
#

INSERT INTO `catalogue_catalogue_types_props` (`id`, `type_id`, `property_id`) VALUES 
  (17,1,1),
  (18,2,7),
  (3,1,3),
  (4,2,4),
  (5,2,5),
  (6,2,6),
  (12,1,2),
  (23,6,9);

COMMIT;

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
# Data for the `comments_comments` table  (LIMIT 0,500)
#

INSERT INTO `comments_comments` (`id`, `obj_id`, `text`, `author`, `time`, `folder_id`) VALUES 
  (34,185,'sdf',2,1170662062,28),
  (25,135,'asdfsdfg',2,1164000450,14),
  (37,188,'jhgkhjk',2,1170662102,28),
  (33,184,'asd',2,1170662056,28),
  (38,214,'яяяяяяййййм',2,1170820956,29),
  (39,215,'фваааааааа',2,1170821437,29),
  (40,216,'ыва',2,1170821447,29),
  (41,217,'цйук',2,1170821449,29),
  (42,218,'рпо',2,1170821452,29);

COMMIT;

#
# Structure for the `comments_commentsFolder` table : 
#

DROP TABLE IF EXISTS `comments_commentsFolder`;

CREATE TABLE `comments_commentsFolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `parent_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `comments_commentsFolder` table  (LIMIT 0,500)
#

INSERT INTO `comments_commentsFolder` (`id`, `obj_id`, `parent_id`) VALUES 
  (14,134,9),
  (16,145,10),
  (18,171,164),
  (19,172,165),
  (20,173,166),
  (21,174,170),
  (22,175,11),
  (23,177,6),
  (28,183,182),
  (29,213,212);

COMMIT;

#
# Structure for the `fileManager_file` table : 
#

DROP TABLE IF EXISTS `fileManager_file`;

CREATE TABLE `fileManager_file` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `realname` char(255) default 'имя в фс в каталоге на сервере',
  `name` char(255) default 'имя с которым файл будет отдаваться клиенту',
  `ext` char(20) default NULL,
  `size` int(11) default NULL,
  `downloads` int(11) default NULL,
  `folder_id` int(11) unsigned default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `realname` (`realname`),
  KEY `folder_id` (`folder_id`,`name`,`ext`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `fileManager_file` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_file` (`id`, `realname`, `name`, `ext`, `size`, `downloads`, `folder_id`, `obj_id`) VALUES 
  (1,'foobar.txt','q','txt',10,1,1,196),
  (2,'06558db05a7d5148084025676972cbb2','','rec',9,NULL,NULL,201),
  (3,'9f4b4024092fcebfc434401210f71f7d','','rec',9,NULL,NULL,202),
  (4,'05a131b70aef0e2b9f3e344d6163d311','qwe.rec','rec',9,NULL,1,203),
  (5,'5b78dc5c1c2ad6511e3e324845c2eb3c','2rec','',9,NULL,1,204),
  (6,'13810e7f5782973b2dc72030c1c392f0','сы','',18,NULL,1,205),
  (7,'86a4a3164ed3f07762b204d7ccbbea0e','!А вам слабо!Excel!AutoCAD-MustDie','xls',745984,2,1,206),
  (8,'3ff2104331237dafe9d7941a1286136f','mysql','',39,1,1,207),
  (9,'395ce8a398746491a5e73c2f0ab786ba','сверхурочка','',38,1,1,208),
  (10,'02c870089fc7f94ba1286e8faef13316','web.txt','txt',28,3,1,209),
  (11,'59833d36a918ad9fdd5f860d8a9b350f','!А вам слабо!Excel!AutoCAD-MustDie','xls',745984,NULL,1,210),
  (12,'72bbe08ad2ff3bf5ac950061a8a71ccd','!А вам слабо!Excel!AutoCAD-MustDie.xls','xls',745984,1,1,211),
  (13,'ddaa316ac5ba16b0a2e39a3f9c19d330','2rec','',9,NULL,2,219),
  (14,'715dc8aa6d7e16526ae15a80386c4552','2rec.bmp','bmp',9,3,2,220),
  (15,'4f0d05060fc2119d464b15a2ec93337f','apache_1.3.37.tar.gz','gz',2665370,1,4,236);

COMMIT;

#
# Structure for the `fileManager_folder` table : 
#

DROP TABLE IF EXISTS `fileManager_folder`;

CREATE TABLE `fileManager_folder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `parent` int(11) unsigned default NULL,
  `path` char(255) default NULL,
  `obj_id` int(11) unsigned default NULL,
  `filesize` int(11) unsigned default NULL,
  `exts` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `fileManager_folder` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_folder` (`id`, `name`, `title`, `parent`, `path`, `obj_id`, `filesize`, `exts`) VALUES 
  (1,'root','/',1,'root',195,NULL,NULL),
  (2,'child','child_node',2,'root/child',197,1,'bmp'),
  (3,'q','q',3,'root/child/q',221,0,''),
  (4,'z','z',4,'root/child/z',222,0,'');

COMMIT;

#
# Structure for the `fileManager_folder_tree` table : 
#

DROP TABLE IF EXISTS `fileManager_folder_tree`;

CREATE TABLE `fileManager_folder_tree` (
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
# Data for the `fileManager_folder_tree` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_folder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,8,1),
  (2,2,7,2),
  (3,3,4,3),
  (4,5,6,3);

COMMIT;

#
# Structure for the `news_news` table : 
#

DROP TABLE IF EXISTS `news_news`;

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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_news` table  (LIMIT 0,500)
#

INSERT INTO `news_news` (`id`, `obj_id`, `title`, `editor`, `annotation`, `text`, `folder_id`, `created`, `updated`) VALUES 
  (7,182,'1',2,NULL,'3',2,1170662044,1172037447),
  (8,212,'ывф',2,'Аннотация','Содержание',2,1170820429,1173934400);

COMMIT;

#
# Structure for the `news_newsFolder` table : 
#

DROP TABLE IF EXISTS `news_newsFolder`;

CREATE TABLE `news_newsFolder` (
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
# Data for the `news_newsFolder` table  (LIMIT 0,500)
#

INSERT INTO `news_newsFolder` (`id`, `obj_id`, `name`, `title`, `parent`, `path`) VALUES 
  (2,6,'root','/',1,'root'),
  (3,49,'zzz','подкаталог',2,'root/zzz'),
  (5,159,'one_more','zzz',4,'root/one_more'),
  (6,160,'two','qqq',5,'root/zzz/two'),
  (7,235,'asd','asd',6,'root/one_more/asd');

COMMIT;

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
  KEY `left_key` (`lkey`,`rkey`,`level`),
  KEY `level` (`level`,`lkey`),
  KEY `rkey` (`rkey`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `news_newsFolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `news_newsFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,10,1),
  (2,2,5,2),
  (4,6,9,2),
  (5,3,4,3),
  (6,7,8,3);

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
  `folder_id` int(11) unsigned default NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `page_page` table  (LIMIT 0,500)
#

INSERT INTO `page_page` (`id`, `obj_id`, `name`, `title`, `content`, `folder_id`) VALUES 
  (1,9,'main','Первая страница','Это <b>первая</b>, главная <strike>страница</strike>\n',1),
  (2,10,'404','404 Not Found','Запрашиваемая страница не найдена!',1),
  (3,11,'test','test','test',1),
  (4,57,'403','Доступ запрещён','Доступ запрещён',1),
  (5,164,'pagename','123','234',2),
  (6,165,'asd','qwe','asd',2),
  (7,166,'12345','1','qwe',2),
  (8,167,'1236','2','asd',2),
  (9,168,'1237','3','qwe',2),
  (10,169,'1234','ffffff','f',2),
  (11,170,'ss','ква','sdaf',2);

COMMIT;

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
# Data for the `page_pageFolder` table  (LIMIT 0,500)
#

INSERT INTO `page_pageFolder` (`id`, `obj_id`, `name`, `title`, `parent`, `path`) VALUES 
  (1,161,'root','/',1,'root'),
  (2,163,'foo','foo',2,'root/foo'),
  (3,234,'zz','zz',3,'root/foo/zz');

COMMIT;

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
# Data for the `page_pageFolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `page_pageFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES 
  (1,1,6,1),
  (2,2,5,2),
  (3,3,4,3);

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
  `allow` tinyint(1) unsigned default '0',
  `deny` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `class_action_id` (`class_section_id`,`obj_id`,`uid`,`gid`),
  KEY `obj_id_gid` (`obj_id`,`gid`),
  KEY `obj_id_uid` (`obj_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_access` table  (LIMIT 0,500)
#

INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `obj_id`, `uid`, `gid`, `allow`, `deny`) VALUES 
  (1202,9,1,0,1,NULL,0,0),
  (1201,20,1,0,1,NULL,0,0),
  (1113,9,3,0,NULL,1,0,0),
  (859,9,1,0,0,NULL,1,0),
  (858,2,1,0,0,NULL,1,0),
  (665,9,2,49,2,NULL,1,0),
  (671,9,2,49,NULL,2,1,0),
  (670,8,2,49,NULL,2,1,0),
  (669,7,2,49,NULL,2,1,0),
  (1112,2,3,0,NULL,1,0,0),
  (1111,12,3,0,NULL,1,0,0),
  (394,9,2,0,0,NULL,1,0),
  (391,6,2,0,0,NULL,1,0),
  (390,5,2,0,0,NULL,1,0),
  (441,9,2,6,2,NULL,1,0),
  (1528,1,10,188,2,NULL,1,0),
  (1498,1,1,182,2,NULL,1,0),
  (857,1,1,0,0,NULL,1,0),
  (389,4,2,0,0,NULL,1,0),
  (440,8,2,6,2,NULL,1,0),
  (439,7,2,6,2,NULL,1,0),
  (438,6,2,6,2,NULL,1,0),
  (437,5,2,6,2,NULL,1,0),
  (436,4,2,6,2,NULL,1,0),
  (664,8,2,49,2,NULL,1,0),
  (663,7,2,49,2,NULL,1,0),
  (1504,3,1,182,1,NULL,1,0),
  (1503,1,1,182,1,NULL,0,0),
  (1502,2,1,182,1,NULL,0,0),
  (1501,20,1,182,1,NULL,0,0),
  (1500,9,1,182,1,NULL,0,0),
  (668,6,2,49,NULL,2,1,0),
  (667,5,2,49,NULL,2,1,0),
  (666,4,2,49,NULL,2,1,0),
  (662,6,2,49,2,NULL,1,0),
  (661,5,2,49,2,NULL,1,0),
  (660,4,2,49,2,NULL,1,0),
  (393,8,2,0,0,NULL,1,0),
  (392,7,2,0,0,NULL,1,0),
  (1200,2,1,0,1,NULL,0,0),
  (1199,1,1,0,1,NULL,0,0),
  (1110,1,3,0,NULL,1,0,0),
  (1109,5,3,0,NULL,1,1,0),
  (1108,11,3,0,NULL,1,1,0),
  (1107,10,3,0,NULL,1,1,0),
  (856,3,1,0,0,NULL,1,0),
  (1497,2,1,182,2,NULL,1,0),
  (1228,9,2,0,NULL,1,0,0),
  (1227,8,2,0,NULL,1,0,0),
  (1226,7,2,0,NULL,1,0,0),
  (1225,6,2,0,NULL,1,0,0),
  (1224,5,2,0,NULL,1,1,0),
  (1223,4,2,0,NULL,1,0,0),
  (355,4,2,0,NULL,2,1,0),
  (356,5,2,0,NULL,2,1,0),
  (357,6,2,0,NULL,2,1,0),
  (358,7,2,0,NULL,2,0,1),
  (359,8,2,0,NULL,2,0,1),
  (360,9,2,0,NULL,2,0,1),
  (1134,9,3,0,NULL,2,1,0),
  (1133,2,3,0,NULL,2,1,0),
  (1132,12,3,0,NULL,2,1,0),
  (1131,1,3,0,NULL,2,1,0),
  (1130,5,3,0,NULL,2,1,0),
  (1129,11,3,0,NULL,2,1,0),
  (1128,10,3,0,NULL,2,1,0),
  (428,3,5,19,NULL,1,1,0),
  (429,3,5,19,NULL,2,1,0),
  (442,10,3,12,NULL,1,1,0),
  (996,9,3,13,NULL,2,1,0),
  (466,9,6,9,NULL,1,0,1),
  (465,2,6,9,NULL,1,0,1),
  (464,1,6,9,NULL,1,0,1),
  (463,4,6,9,NULL,1,0,1),
  (462,5,6,9,NULL,1,1,0),
  (468,5,6,9,NULL,2,0,1),
  (467,3,6,9,NULL,2,1,0),
  (461,3,6,9,NULL,1,1,0),
  (469,4,6,9,NULL,2,0,1),
  (470,1,6,9,NULL,2,1,0),
  (471,2,6,9,NULL,2,0,1),
  (472,9,6,9,NULL,2,1,0),
  (486,3,6,10,NULL,2,1,0),
  (485,9,6,10,NULL,1,0,1),
  (484,2,6,10,NULL,1,0,1),
  (483,1,6,10,NULL,1,0,1),
  (482,4,6,10,NULL,1,0,1),
  (481,5,6,10,NULL,1,1,0),
  (480,3,6,10,NULL,1,1,0),
  (487,5,6,10,NULL,2,1,0),
  (488,4,6,10,NULL,2,1,0),
  (489,1,6,10,NULL,2,1,0),
  (490,2,6,10,NULL,2,0,1),
  (491,9,6,10,NULL,2,1,0),
  (504,9,6,11,NULL,2,1,0),
  (503,2,6,11,NULL,2,1,0),
  (502,1,6,11,NULL,2,1,0),
  (501,4,6,11,NULL,2,1,0),
  (500,5,6,11,NULL,2,1,0),
  (499,3,6,11,NULL,2,1,0),
  (505,3,6,11,NULL,1,1,0),
  (506,5,6,11,NULL,1,1,0),
  (507,4,6,11,NULL,1,0,1),
  (508,1,6,11,NULL,1,0,1),
  (509,2,6,11,NULL,1,0,1),
  (510,9,6,11,NULL,1,0,1),
  (546,9,3,55,NULL,1,0,1),
  (539,9,3,55,NULL,2,1,0),
  (545,2,3,55,NULL,1,0,1),
  (538,2,3,55,NULL,2,1,0),
  (544,12,3,55,NULL,1,0,1),
  (537,12,3,55,NULL,2,1,0),
  (543,1,3,55,NULL,1,0,1),
  (536,1,3,55,NULL,2,1,0),
  (542,5,3,55,NULL,1,1,0),
  (535,5,3,55,NULL,2,1,0),
  (541,11,3,55,NULL,1,1,0),
  (534,11,3,55,NULL,2,1,0),
  (540,10,3,55,NULL,1,1,0),
  (533,10,3,55,NULL,2,1,0),
  (995,2,3,13,NULL,2,1,0),
  (994,12,3,13,NULL,2,1,0),
  (993,1,3,13,NULL,2,1,0),
  (992,5,3,13,NULL,2,1,0),
  (991,11,3,13,NULL,2,1,0),
  (990,10,3,13,NULL,2,1,0),
  (548,14,4,56,NULL,2,1,0),
  (549,15,4,56,NULL,2,1,0),
  (550,16,4,56,NULL,2,1,0),
  (551,17,4,56,NULL,2,1,0),
  (552,13,4,56,NULL,2,1,0),
  (553,9,4,56,NULL,2,1,0),
  (555,14,4,15,NULL,2,1,0),
  (556,15,4,15,NULL,2,1,0),
  (557,16,4,15,NULL,2,1,0),
  (558,17,4,15,NULL,2,1,0),
  (559,13,4,15,NULL,2,1,0),
  (560,9,4,15,NULL,2,1,0),
  (562,14,4,14,NULL,2,1,0),
  (563,15,4,14,NULL,2,1,0),
  (564,16,4,14,NULL,2,1,0),
  (565,17,4,14,NULL,2,1,0),
  (566,13,4,14,NULL,2,1,0),
  (567,9,4,14,NULL,2,1,0),
  (569,3,6,57,NULL,2,1,0),
  (570,5,6,57,NULL,2,1,0),
  (571,4,6,57,NULL,2,1,0),
  (572,1,6,57,NULL,2,1,0),
  (573,2,6,57,NULL,2,1,0),
  (574,9,6,57,NULL,2,1,0),
  (590,1,1,60,1,NULL,0,1),
  (591,1,1,60,2,NULL,1,0),
  (592,2,1,60,2,NULL,1,0),
  (593,2,1,60,1,NULL,1,0),
  (594,3,1,60,1,NULL,0,1),
  (595,3,1,60,2,NULL,1,0),
  (596,9,1,60,2,NULL,1,0),
  (597,9,1,60,1,NULL,0,1),
  (598,9,1,60,NULL,2,1,0),
  (599,4,2,61,NULL,1,0,1),
  (600,4,2,61,NULL,2,1,0),
  (601,4,2,61,2,NULL,1,0),
  (602,5,2,61,NULL,1,1,0),
  (603,5,2,61,NULL,2,1,0),
  (604,5,2,61,2,NULL,1,0),
  (605,6,2,61,NULL,1,0,1),
  (606,6,2,61,NULL,2,1,0),
  (607,6,2,61,2,NULL,1,0),
  (608,7,2,61,NULL,1,0,1),
  (609,7,2,61,NULL,2,0,1),
  (610,7,2,61,2,NULL,1,0),
  (611,8,2,61,NULL,1,0,1),
  (612,8,2,61,NULL,2,0,1),
  (613,8,2,61,2,NULL,1,0),
  (614,9,2,61,NULL,1,0,1),
  (615,9,2,61,NULL,2,0,1),
  (616,9,2,61,2,NULL,1,0),
  (630,18,7,62,NULL,2,1,0),
  (1240,9,2,0,2,NULL,1,0),
  (1239,8,2,0,2,NULL,1,0),
  (1238,7,2,0,2,NULL,1,0),
  (1237,6,2,0,2,NULL,1,0),
  (1236,5,2,0,2,NULL,1,0),
  (1235,4,2,0,2,NULL,1,0),
  (629,9,7,62,NULL,2,1,0),
  (1140,18,7,63,NULL,2,1,0),
  (1139,9,7,63,NULL,2,1,0),
  (1146,18,7,64,NULL,2,1,0),
  (1145,9,7,64,NULL,2,1,0),
  (637,3,6,0,0,NULL,1,0),
  (638,5,6,0,0,NULL,1,0),
  (639,4,6,0,0,NULL,0,1),
  (640,1,6,0,0,NULL,1,0),
  (641,2,6,0,0,NULL,1,0),
  (642,9,6,0,0,NULL,0,1),
  (687,9,5,65,NULL,2,1,0),
  (686,3,5,65,NULL,2,1,0),
  (646,3,5,65,NULL,1,1,0),
  (647,9,5,65,NULL,1,0,1),
  (1527,2,10,188,2,NULL,1,0),
  (1519,1,10,185,2,NULL,1,0),
  (1518,2,10,185,2,NULL,1,0),
  (684,3,5,65,2,NULL,1,0),
  (685,9,5,65,2,NULL,1,0),
  (989,9,3,12,NULL,2,1,0),
  (697,10,3,12,2,NULL,0,1),
  (698,11,3,12,2,NULL,0,1),
  (699,5,3,12,2,NULL,0,1),
  (700,1,3,12,2,NULL,1,0),
  (701,12,3,12,2,NULL,1,0),
  (702,2,3,12,2,NULL,1,0),
  (703,9,3,12,2,NULL,1,0),
  (988,2,3,12,NULL,2,1,0),
  (987,12,3,12,NULL,2,0,0),
  (986,1,3,12,NULL,2,0,0),
  (985,5,3,12,NULL,2,0,0),
  (984,11,3,12,NULL,2,0,0),
  (983,10,3,12,NULL,2,0,0),
  (1449,21,9,69,NULL,2,1,0),
  (1448,20,9,69,NULL,2,1,0),
  (1143,18,7,72,NULL,2,1,0),
  (1142,9,7,72,NULL,2,1,0),
  (729,9,7,71,NULL,2,1,0),
  (730,18,7,71,NULL,2,1,0),
  (732,5,11,76,2,NULL,1,0),
  (733,9,11,76,2,NULL,1,0),
  (776,5,11,93,NULL,1,1,0),
  (777,5,11,93,NULL,2,1,0),
  (884,19,11,0,NULL,1,0,0),
  (883,5,11,0,NULL,1,1,0),
  (888,9,11,0,NULL,2,0,0),
  (887,19,11,0,NULL,2,1,0),
  (778,9,11,93,NULL,1,0,1),
  (784,18,7,95,2,NULL,1,0),
  (779,9,11,93,NULL,2,1,0),
  (1149,18,7,94,2,NULL,1,0),
  (886,5,11,0,NULL,2,1,0),
  (788,5,11,96,NULL,1,1,0),
  (783,9,10,0,0,NULL,1,0),
  (782,2,10,0,0,NULL,1,0),
  (789,5,11,96,NULL,2,1,0),
  (790,19,11,96,NULL,2,1,0),
  (791,9,11,96,NULL,1,0,1),
  (792,9,11,96,NULL,2,1,0),
  (781,1,10,0,0,NULL,1,0),
  (902,19,11,98,NULL,1,0,0),
  (906,9,11,98,NULL,2,0,0),
  (905,19,11,98,NULL,2,1,0),
  (901,5,11,98,NULL,1,1,0),
  (904,5,11,98,NULL,2,1,0),
  (801,1,10,99,2,NULL,1,0),
  (804,1,10,100,2,NULL,1,0),
  (803,9,10,99,2,NULL,1,0),
  (802,2,10,99,2,NULL,1,0),
  (805,2,10,100,2,NULL,1,0),
  (806,9,10,100,2,NULL,1,0),
  (807,1,10,101,2,NULL,1,0),
  (808,2,10,101,2,NULL,1,0),
  (809,9,10,101,2,NULL,1,0),
  (810,5,11,102,NULL,1,1,0),
  (811,5,11,102,NULL,2,1,0),
  (812,19,11,102,NULL,2,1,0),
  (813,9,11,102,NULL,1,0,1),
  (814,9,11,102,NULL,2,1,0),
  (890,19,11,103,NULL,1,0,0),
  (897,9,11,103,NULL,2,0,0),
  (896,19,11,103,NULL,2,1,0),
  (889,5,11,103,NULL,1,1,0),
  (895,5,11,103,NULL,2,1,0),
  (885,9,11,0,NULL,1,0,0),
  (882,9,11,0,0,NULL,1,0),
  (881,19,11,0,0,NULL,0,0),
  (880,5,11,0,0,NULL,0,0),
  (891,9,11,103,NULL,1,0,0),
  (952,9,11,103,2,NULL,1,0),
  (951,19,11,103,2,NULL,0,0),
  (950,5,11,103,2,NULL,0,0),
  (898,5,11,98,2,NULL,0,0),
  (899,19,11,98,2,NULL,0,0),
  (900,9,11,98,2,NULL,1,0),
  (903,9,11,98,NULL,1,0,0),
  (919,1,10,107,2,NULL,1,0),
  (920,2,10,107,2,NULL,1,0),
  (921,9,10,107,2,NULL,1,0),
  (922,1,10,108,2,NULL,1,0),
  (923,2,10,108,2,NULL,1,0),
  (924,9,10,108,2,NULL,1,0),
  (1148,9,7,94,2,NULL,1,0),
  (958,9,7,95,2,NULL,1,0),
  (970,9,11,124,NULL,1,0,0),
  (973,9,11,124,NULL,2,0,0),
  (961,5,11,124,1,NULL,0,0),
  (969,19,11,124,NULL,1,0,1),
  (972,19,11,124,NULL,2,0,1),
  (964,19,11,124,1,NULL,0,0),
  (968,5,11,124,NULL,1,1,0),
  (971,5,11,124,NULL,2,1,0),
  (967,9,11,124,2,NULL,1,0),
  (974,5,11,127,NULL,1,1,0),
  (975,5,11,127,NULL,2,1,0),
  (976,5,11,127,2,NULL,0,0),
  (977,19,11,127,NULL,1,0,0),
  (978,19,11,127,NULL,2,1,0),
  (979,19,11,127,2,NULL,0,0),
  (980,9,11,127,NULL,1,0,0),
  (981,9,11,127,NULL,2,0,0),
  (982,9,11,127,2,NULL,1,0),
  (1526,9,10,188,2,NULL,1,0),
  (1033,5,11,134,NULL,1,1,0),
  (1034,5,11,134,NULL,2,1,0),
  (1035,5,11,134,1,NULL,0,0),
  (1036,19,11,134,NULL,1,0,0),
  (1037,19,11,134,NULL,2,1,0),
  (1038,19,11,134,1,NULL,0,0),
  (1039,9,11,134,NULL,1,0,0),
  (1040,9,11,134,NULL,2,0,0),
  (1041,9,11,134,1,NULL,1,0),
  (1042,1,10,135,2,NULL,1,0),
  (1043,2,10,135,2,NULL,1,0),
  (1044,9,10,135,2,NULL,1,0),
  (1080,5,11,145,NULL,1,1,0),
  (1081,5,11,145,NULL,2,1,0),
  (1082,5,11,145,1,NULL,0,0),
  (1083,19,11,145,NULL,1,0,0),
  (1084,19,11,145,NULL,2,1,0),
  (1085,19,11,145,1,NULL,0,0),
  (1086,9,11,145,NULL,1,0,0),
  (1087,9,11,145,NULL,2,0,0),
  (1088,9,11,145,1,NULL,1,0),
  (1510,5,11,183,NULL,2,1,0),
  (1507,9,11,183,NULL,1,0,0),
  (1513,5,11,183,2,NULL,0,0),
  (1509,19,11,183,NULL,2,1,0),
  (1506,5,11,183,NULL,1,1,0),
  (1512,19,11,183,2,NULL,0,0),
  (1508,9,11,183,NULL,2,0,0),
  (1505,19,11,183,NULL,1,0,0),
  (1511,9,11,183,2,NULL,1,0),
  (1516,1,10,184,2,NULL,1,0),
  (1515,2,10,184,2,NULL,1,0),
  (1514,9,10,184,2,NULL,1,0),
  (1121,10,3,0,0,NULL,1,0),
  (1122,11,3,0,0,NULL,1,0),
  (1123,5,3,0,0,NULL,1,0),
  (1124,1,3,0,0,NULL,1,0),
  (1125,12,3,0,0,NULL,1,0),
  (1126,2,3,0,0,NULL,1,0),
  (1127,9,3,0,0,NULL,1,0),
  (1447,3,9,69,NULL,2,1,0),
  (1141,20,7,63,NULL,2,1,0),
  (1144,20,7,72,NULL,2,1,0),
  (1147,20,7,64,NULL,2,1,0),
  (1150,20,7,94,2,NULL,1,0),
  (1499,3,1,182,2,NULL,1,0),
  (1517,9,10,185,2,NULL,1,0),
  (1496,9,1,182,2,NULL,1,0),
  (1198,3,1,0,1,NULL,1,0),
  (1309,8,2,159,NULL,1,0,0),
  (1303,6,2,159,2,NULL,1,0),
  (1321,5,2,160,NULL,1,1,0),
  (1320,4,2,160,2,NULL,1,0),
  (1308,7,2,159,2,NULL,1,0),
  (1302,6,2,159,NULL,2,1,0),
  (1319,4,2,160,2,NULL,1,0),
  (1318,4,2,160,NULL,2,1,0),
  (1307,7,2,159,2,NULL,1,0),
  (1301,6,2,159,NULL,1,0,0),
  (1317,4,2,160,NULL,1,0,0),
  (1316,9,2,159,2,NULL,1,0),
  (1306,7,2,159,NULL,2,0,0),
  (1300,5,2,159,2,NULL,1,0),
  (1315,9,2,159,2,NULL,1,0),
  (1314,9,2,159,NULL,2,0,0),
  (1305,7,2,159,NULL,1,0,0),
  (1299,5,2,159,2,NULL,1,0),
  (1313,9,2,159,NULL,1,0,0),
  (1312,8,2,159,2,NULL,1,0),
  (1304,6,2,159,2,NULL,1,0),
  (1298,5,2,159,NULL,2,1,0),
  (1311,8,2,159,2,NULL,1,0),
  (1310,8,2,159,NULL,2,0,0),
  (1454,9,11,177,NULL,2,0,0),
  (1297,5,2,159,NULL,1,1,0),
  (1453,9,11,177,NULL,1,0,0),
  (1296,4,2,159,2,NULL,1,0),
  (1452,5,11,177,NULL,1,1,0),
  (1295,4,2,159,2,NULL,1,0),
  (1451,19,11,177,NULL,1,0,0),
  (1294,4,2,159,NULL,2,1,0),
  (1293,4,2,159,NULL,1,0,0),
  (1325,6,2,160,NULL,1,0,0),
  (1330,7,2,160,NULL,2,0,0),
  (1324,5,2,160,2,NULL,1,0),
  (1329,7,2,160,NULL,1,0,0),
  (1323,5,2,160,2,NULL,1,0),
  (1328,6,2,160,2,NULL,1,0),
  (1322,5,2,160,NULL,2,1,0),
  (1327,6,2,160,2,NULL,1,0),
  (1326,6,2,160,NULL,2,1,0),
  (1331,7,2,160,2,NULL,1,0),
  (1332,7,2,160,2,NULL,1,0),
  (1333,8,2,160,NULL,1,0,0),
  (1334,8,2,160,NULL,2,0,0),
  (1335,8,2,160,2,NULL,1,0),
  (1336,8,2,160,2,NULL,1,0),
  (1337,9,2,160,NULL,1,0,0),
  (1338,9,2,160,NULL,2,0,0),
  (1339,9,2,160,2,NULL,1,0),
  (1340,9,2,160,2,NULL,1,0),
  (1342,4,13,161,NULL,2,1,0),
  (1343,5,13,161,NULL,2,1,0),
  (1344,6,13,161,NULL,2,1,0),
  (1345,7,13,161,NULL,2,1,0),
  (1346,9,13,161,NULL,2,1,0),
  (1347,4,13,0,0,NULL,1,0),
  (1348,5,13,0,0,NULL,1,0),
  (1349,6,13,0,0,NULL,1,0),
  (1350,7,13,0,0,NULL,1,0),
  (1351,9,13,0,0,NULL,1,0),
  (1352,4,13,0,NULL,2,1,0),
  (1353,5,13,0,NULL,2,1,0),
  (1354,6,13,0,NULL,2,1,0),
  (1355,7,13,0,NULL,2,1,0),
  (1356,9,13,0,NULL,2,1,0),
  (1357,9,13,163,NULL,2,1,0),
  (1358,9,13,163,2,NULL,1,0),
  (1359,7,13,163,NULL,2,1,0),
  (1360,7,13,163,2,NULL,1,0),
  (1361,6,13,163,NULL,2,1,0),
  (1362,6,13,163,2,NULL,1,0),
  (1363,4,13,163,NULL,2,1,0),
  (1364,4,13,163,2,NULL,1,0),
  (1365,5,13,163,NULL,2,1,0),
  (1366,5,13,163,2,NULL,1,0),
  (1367,3,6,164,2,NULL,1,0),
  (1368,9,6,164,2,NULL,0,0),
  (1369,4,6,164,2,NULL,0,0),
  (1370,1,6,164,2,NULL,1,0),
  (1371,2,6,164,2,NULL,1,0),
  (1372,3,6,165,2,NULL,1,0),
  (1373,9,6,165,2,NULL,0,0),
  (1374,4,6,165,2,NULL,0,0),
  (1375,1,6,165,2,NULL,1,0),
  (1376,2,6,165,2,NULL,1,0),
  (1377,3,6,166,2,NULL,1,0),
  (1378,9,6,166,2,NULL,0,0),
  (1379,4,6,166,2,NULL,0,0),
  (1380,1,6,166,2,NULL,1,0),
  (1381,2,6,166,2,NULL,1,0),
  (1382,3,6,167,2,NULL,1,0),
  (1383,9,6,167,2,NULL,0,0),
  (1384,4,6,167,2,NULL,0,0),
  (1385,1,6,167,2,NULL,1,0),
  (1386,2,6,167,2,NULL,1,0),
  (1387,3,6,168,2,NULL,1,0),
  (1388,9,6,168,2,NULL,0,0),
  (1389,4,6,168,2,NULL,0,0),
  (1390,1,6,168,2,NULL,1,0),
  (1391,2,6,168,2,NULL,1,0),
  (1392,3,6,169,2,NULL,1,0),
  (1393,9,6,169,2,NULL,0,0),
  (1394,4,6,169,2,NULL,0,0),
  (1395,1,6,169,2,NULL,1,0),
  (1396,2,6,169,2,NULL,1,0),
  (1397,3,6,170,2,NULL,1,0),
  (1398,9,6,170,2,NULL,0,0),
  (1399,4,6,170,2,NULL,0,0),
  (1400,1,6,170,2,NULL,1,0),
  (1401,2,6,170,2,NULL,1,0),
  (1402,5,11,171,NULL,1,1,0),
  (1403,5,11,171,NULL,2,1,0),
  (1404,5,11,171,1,NULL,0,0),
  (1405,19,11,171,NULL,1,0,0),
  (1406,19,11,171,NULL,2,1,0),
  (1407,19,11,171,1,NULL,0,0),
  (1408,9,11,171,NULL,1,0,0),
  (1409,9,11,171,NULL,2,0,0),
  (1410,9,11,171,1,NULL,1,0),
  (1411,5,11,172,NULL,1,1,0),
  (1412,5,11,172,NULL,2,1,0),
  (1413,5,11,172,1,NULL,0,0),
  (1414,19,11,172,NULL,1,0,0),
  (1415,19,11,172,NULL,2,1,0),
  (1416,19,11,172,1,NULL,0,0),
  (1417,9,11,172,NULL,1,0,0),
  (1418,9,11,172,NULL,2,0,0),
  (1419,9,11,172,1,NULL,1,0),
  (1420,5,11,173,NULL,1,1,0),
  (1421,5,11,173,NULL,2,1,0),
  (1422,5,11,173,1,NULL,0,0),
  (1423,19,11,173,NULL,1,0,0),
  (1424,19,11,173,NULL,2,1,0),
  (1425,19,11,173,1,NULL,0,0),
  (1426,9,11,173,NULL,1,0,0),
  (1427,9,11,173,NULL,2,0,0),
  (1428,9,11,173,1,NULL,1,0),
  (1429,5,11,174,NULL,1,1,0),
  (1430,5,11,174,NULL,2,1,0),
  (1431,5,11,174,1,NULL,0,0),
  (1432,19,11,174,NULL,1,0,0);

COMMIT;

#
# Data for the `sys_access` table  (LIMIT 500,500)
#

INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `obj_id`, `uid`, `gid`, `allow`, `deny`) VALUES 
  (1433,19,11,174,NULL,2,1,0),
  (1434,19,11,174,1,NULL,0,0),
  (1435,9,11,174,NULL,1,0,0),
  (1436,9,11,174,NULL,2,0,0),
  (1437,9,11,174,1,NULL,1,0),
  (1438,5,11,175,NULL,1,1,0),
  (1439,5,11,175,NULL,2,1,0),
  (1440,5,11,175,1,NULL,0,0),
  (1441,19,11,175,NULL,1,0,0),
  (1442,19,11,175,NULL,2,1,0),
  (1443,19,11,175,1,NULL,0,0),
  (1444,9,11,175,NULL,1,0,0),
  (1445,9,11,175,NULL,2,0,0),
  (1446,9,11,175,1,NULL,1,0),
  (1450,9,9,69,NULL,2,1,0),
  (1455,19,11,177,NULL,2,1,0),
  (1456,5,11,177,NULL,2,1,0),
  (1457,9,11,177,1,NULL,1,0),
  (1458,19,11,177,1,NULL,0,0),
  (1459,5,11,177,1,NULL,0,0),
  (1529,9,1,212,2,NULL,1,0),
  (1530,2,1,212,2,NULL,1,0),
  (1531,1,1,212,2,NULL,1,0),
  (1532,3,1,212,2,NULL,1,0),
  (1533,9,1,212,1,NULL,0,0),
  (1534,2,1,212,1,NULL,0,0),
  (1535,1,1,212,1,NULL,0,0),
  (1536,3,1,212,1,NULL,1,0),
  (1537,19,11,213,NULL,1,0,0),
  (1538,5,11,213,NULL,1,1,0),
  (1539,9,11,213,NULL,1,0,0),
  (1540,9,11,213,NULL,2,0,0),
  (1541,19,11,213,NULL,2,1,0),
  (1542,5,11,213,NULL,2,1,0),
  (1543,9,11,213,2,NULL,1,0),
  (1544,19,11,213,2,NULL,0,0),
  (1545,5,11,213,2,NULL,0,0),
  (1546,9,10,214,2,NULL,1,0),
  (1547,2,10,214,2,NULL,1,0),
  (1548,1,10,214,2,NULL,1,0),
  (1549,9,10,215,2,NULL,1,0),
  (1550,2,10,215,2,NULL,1,0),
  (1551,1,10,215,2,NULL,1,0),
  (1552,9,10,216,2,NULL,1,0),
  (1553,2,10,216,2,NULL,1,0),
  (1554,1,10,216,2,NULL,1,0),
  (1555,9,10,217,2,NULL,1,0),
  (1556,2,10,217,2,NULL,1,0),
  (1557,1,10,217,2,NULL,1,0),
  (1558,9,10,218,2,NULL,1,0),
  (1559,2,10,218,2,NULL,1,0),
  (1560,1,10,218,2,NULL,1,0),
  (1582,4,2,6,NULL,2,0,0),
  (1583,5,2,6,NULL,2,1,0),
  (1584,6,2,6,NULL,2,0,0),
  (1585,7,2,6,NULL,2,0,0),
  (1586,30,2,6,NULL,2,0,0),
  (1587,8,2,6,NULL,2,0,0),
  (1588,9,2,6,NULL,2,0,0),
  (1589,4,13,234,NULL,2,1,0),
  (1590,5,13,234,NULL,2,1,0),
  (1591,6,13,234,NULL,2,1,0),
  (1592,7,13,234,NULL,2,1,0),
  (1593,9,13,234,NULL,2,1,0),
  (1594,4,13,234,2,NULL,1,0),
  (1595,5,13,234,2,NULL,1,0),
  (1596,6,13,234,2,NULL,1,0),
  (1597,7,13,234,2,NULL,1,0),
  (1598,9,13,234,2,NULL,1,0),
  (1599,9,2,235,NULL,1,0,0),
  (1600,8,2,235,NULL,1,0,0),
  (1601,7,2,235,NULL,1,0,0),
  (1602,6,2,235,NULL,1,0,0),
  (1603,5,2,235,NULL,1,1,0),
  (1604,4,2,235,NULL,1,0,0),
  (1605,4,2,235,NULL,2,1,0),
  (1606,5,2,235,NULL,2,1,0),
  (1607,6,2,235,NULL,2,1,0),
  (1608,7,2,235,NULL,2,0,0),
  (1609,8,2,235,NULL,2,0,0),
  (1610,9,2,235,NULL,2,0,0),
  (1611,9,2,235,2,NULL,1,0),
  (1612,6,2,235,2,NULL,1,0),
  (1613,5,2,235,2,NULL,1,0),
  (1614,4,2,235,2,NULL,1,0),
  (1615,8,2,235,2,NULL,1,0),
  (1616,7,2,235,2,NULL,1,0),
  (1617,9,2,235,2,NULL,1,0),
  (1618,8,2,235,2,NULL,1,0),
  (1619,7,2,235,2,NULL,1,0),
  (1620,6,2,235,2,NULL,1,0),
  (1621,5,2,235,2,NULL,1,0),
  (1622,4,2,235,2,NULL,1,0);

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
  (185,10),
  (49,2),
  (182,1),
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
  (190,7),
  (69,9),
  (70,7),
  (71,7),
  (72,7),
  (73,7),
  (74,7),
  (75,7),
  (188,10),
  (189,12),
  (95,7),
  (134,11),
  (191,7),
  (135,10),
  (99,10),
  (100,10),
  (101,10),
  (192,7),
  (193,7),
  (94,7),
  (195,15),
  (194,7),
  (145,11),
  (107,10),
  (108,10),
  (121,12),
  (123,7),
  (196,14),
  (126,12),
  (122,7),
  (183,11),
  (184,10),
  (148,12),
  (149,12),
  (150,12),
  (151,12),
  (155,12),
  (177,11),
  (157,12),
  (159,2),
  (160,2),
  (161,13),
  (162,7),
  (163,13),
  (164,6),
  (165,6),
  (166,6),
  (167,6),
  (168,6),
  (169,6),
  (170,6),
  (171,11),
  (172,11),
  (173,11),
  (174,11),
  (175,11),
  (176,12),
  (197,15),
  (198,7),
  (201,14),
  (202,14),
  (203,14),
  (204,14),
  (205,14),
  (206,14),
  (207,14),
  (208,14),
  (209,14),
  (210,14),
  (211,14),
  (212,1),
  (213,11),
  (214,10),
  (215,10),
  (216,10),
  (217,10),
  (218,10),
  (219,14),
  (220,14),
  (221,15),
  (222,15),
  (224,12),
  (225,4),
  (226,8),
  (232,8),
  (233,7),
  (234,13),
  (235,2),
  (236,14),
  (238,16),
  (240,7),
  (249,17),
  (272,16),
  (253,12),
  (259,12),
  (260,12),
  (261,7),
  (262,12),
  (263,12),
  (264,7),
  (265,7),
  (266,7);

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
  (19,'post'),
  (20,'admin'),
  (21,'devToolbar'),
  (22,'acti'),
  (23,'q'),
  (24,'qq'),
  (25,'aaa'),
  (26,'qqq'),
  (27,'upload'),
  (28,'get'),
  (29,'move'),
  (30,'moveFolder'),
  (31,'mainClass'),
  (32,'test'),
  (33,'addType'),
  (34,'deleteType'),
  (35,'editType'),
  (36,'addProperty'),
  (37,'editProperty'),
  (38,'deleteProperty'),
  (39,'editObject'),
  (40,'addObject'),
  (41,'add'),
  (42,'testee'),
  (43,'creatrFolder');

COMMIT;

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
# Data for the `sys_cfg` table  (LIMIT 0,500)
#

INSERT INTO `sys_cfg` (`id`, `section`, `module`) VALUES 
  (2,0,1),
  (3,0,2),
  (1,0,0),
  (7,0,9),
  (9,0,10),
  (15,10,10),
  (16,0,8),
  (17,1,1),
  (18,9,9);

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
  (2,2,'items_per_page','10'),
  (3,3,'items_per_page','20'),
  (28,4,'items_per_page','10'),
  (13,5,'',''),
  (14,6,'items_per_page','20'),
  (21,7,'upload_path','../tmp'),
  (30,8,'upload_path','../files'),
  (23,9,'items_per_page','60'),
  (29,10,'items_per_page','10'),
  (31,11,'items_per_page','60'),
  (32,15,'items_per_page','60'),
  (33,17,'items_per_page','1'),
  (34,7,'items_per_page','10'),
  (35,18,'items_per_page','1'),
  (36,18,'upload_path','../tmp');

COMMIT;

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
  (11,'commentsFolder',8),
  (12,'userAuth',2),
  (13,'pageFolder',4),
  (17,'file',9),
  (18,'folder',9),
  (19,'catalogue',10),
  (20,'catalogueFolder',10);

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
  UNIQUE KEY `class_id` (`class_id`,`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

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
  (46,13,9),
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
  (41,11,9),
  (42,9,20),
  (62,18,27),
  (110,18,20),
  (47,13,7),
  (48,13,6),
  (49,13,4),
  (50,13,5),
  (51,9,21),
  (63,17,1),
  (64,17,28),
  (65,17,2),
  (66,17,9),
  (67,18,9),
  (68,17,18),
  (69,18,18),
  (70,1,29),
  (71,17,29),
  (72,18,6),
  (73,18,8),
  (74,18,7),
  (77,18,30),
  (76,2,30),
  (104,20,30),
  (98,19,20),
  (84,19,33),
  (85,19,34),
  (86,19,35),
  (87,19,36),
  (88,19,37),
  (89,19,38),
  (108,19,1),
  (91,13,8),
  (92,13,30),
  (95,19,2),
  (99,20,5),
  (100,20,4),
  (102,20,6),
  (103,20,7),
  (105,20,8),
  (107,19,29),
  (109,17,20);

COMMIT;

#
# Structure for the `sys_classes_sections` table : 
#

DROP TABLE IF EXISTS `sys_classes_sections`;

CREATE TABLE `sys_classes_sections` (
  `id` int(11) NOT NULL auto_increment,
  `class_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_section` (`section_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

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
  (11,11,8),
  (12,12,2),
  (13,13,4),
  (14,17,9),
  (15,18,9),
  (16,19,10),
  (17,20,10);

COMMIT;

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `main_class` int(11) unsigned default NULL,
  `title` char(255) default NULL,
  `icon` char(255) default NULL,
  `order` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_modules` table  (LIMIT 0,500)
#

INSERT INTO `sys_modules` (`id`, `name`, `main_class`, `title`, `icon`, `order`) VALUES 
  (1,'news',1,'Новости','news.gif',60),
  (2,'user',3,'Пользователи','users.gif',90),
  (3,'timer',5,'Таймер','timer.gif',80),
  (4,'page',6,'Страницы','pages.gif',70),
  (5,'access',7,'Права доступа','access.gif',10),
  (6,'admin',9,'Администрирование','admin.gif',20),
  (8,'comments',10,'Комментарии','comments.gif',40),
  (9,'fileManager',17,'Менеджер файлов','fm.gif',50),
  (10,'catalogue',19,'Каталог','catalogue.gif',30);

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
  (76),
  (77),
  (78),
  (79),
  (80),
  (81),
  (82),
  (83),
  (84),
  (85),
  (86),
  (87),
  (88),
  (89),
  (90),
  (91),
  (92),
  (93),
  (94),
  (95),
  (96),
  (97),
  (98),
  (99),
  (100),
  (101),
  (102),
  (103),
  (104),
  (105),
  (106),
  (107),
  (108),
  (109),
  (110),
  (111),
  (112),
  (113),
  (114),
  (115),
  (116),
  (117),
  (118),
  (119),
  (120),
  (121),
  (122),
  (123),
  (124),
  (125),
  (126),
  (127),
  (128),
  (129),
  (130),
  (131),
  (132),
  (133),
  (134),
  (135),
  (136),
  (137),
  (138),
  (139),
  (140),
  (141),
  (142),
  (143),
  (144),
  (145),
  (146),
  (147),
  (148),
  (149),
  (150),
  (151),
  (152),
  (153),
  (154),
  (155),
  (156),
  (157),
  (158),
  (159),
  (160),
  (161),
  (162),
  (163),
  (164),
  (165),
  (166),
  (167),
  (168),
  (169),
  (170),
  (171),
  (172),
  (173),
  (174),
  (175),
  (176),
  (177),
  (178),
  (179),
  (180),
  (181),
  (182),
  (183),
  (184),
  (185),
  (186),
  (187),
  (188),
  (189),
  (190),
  (191),
  (192),
  (193),
  (194),
  (195),
  (196),
  (197),
  (198),
  (199),
  (200),
  (201),
  (202),
  (203),
  (204),
  (205),
  (206),
  (207),
  (208),
  (209),
  (210),
  (211),
  (212),
  (213),
  (214),
  (215),
  (216),
  (217),
  (218),
  (219),
  (220),
  (221),
  (222),
  (223),
  (224),
  (225),
  (226),
  (227),
  (228),
  (229),
  (230),
  (231),
  (232),
  (233),
  (234),
  (235),
  (236),
  (237),
  (238),
  (239),
  (240),
  (241),
  (242),
  (243),
  (244),
  (245),
  (246),
  (247),
  (248),
  (249),
  (250),
  (251),
  (252),
  (253),
  (254),
  (255),
  (256),
  (257),
  (258),
  (259),
  (260),
  (261),
  (262),
  (263),
  (264),
  (265),
  (266),
  (267),
  (268),
  (269),
  (270),
  (271),
  (272),
  (273);

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
  (75,'access_user_userGroup'),
  (95,'access_comments_commentsFolder'),
  (94,'access_comments_comments'),
  (122,'access_user_userAuth'),
  (123,'access_comments_Array'),
  (158,'access_foo_foo'),
  (162,'access_page_pageFolder'),
  (190,'access__q'),
  (191,'access__file'),
  (192,'access__folder'),
  (193,'access_fileManager_file'),
  (194,'access_fileManager_folder'),
  (198,'access_fileManager_fileManager'),
  (233,'access_catalogue_catalogue'),
  (240,'access__catalogue'),
  (261,'access__'),
  (264,'access_news_catalogue'),
  (265,'access_page_news'),
  (266,'access_fileManager_page');

COMMIT;

#
# Structure for the `sys_sections` table : 
#

DROP TABLE IF EXISTS `sys_sections`;

CREATE TABLE `sys_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `order` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_sections` (`id`, `name`, `title`, `order`) VALUES 
  (7,'admin','Администрирование',10),
  (10,'catalogue','Каталог',20),
  (8,'comments','Комментарии',30),
  (9,'fileManager','Менеджер файлов',40),
  (1,'news','Новости',50),
  (4,'page','Страницы',60),
  (6,'sys','Системное',0),
  (3,'timer','Таймер',70),
  (2,'user','Пользователи',80);

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
  (2,15,'auth'),
  (3,225,'root');

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
# Structure for the `user_userAuth` table : 
#

DROP TABLE IF EXISTS `user_userAuth`;

CREATE TABLE `user_userAuth` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned default NULL,
  `ip` char(15) default NULL,
  `hash` char(32) default NULL,
  `obj_id` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_userAuth` table  (LIMIT 0,500)
#

INSERT INTO `user_userAuth` (`id`, `user_id`, `ip`, `hash`, `obj_id`, `time`) VALUES 
  (12,2,'127.0.0.10','40f005459cebb89062ce9c68d8a1a6e4',121,1163984139),
  (14,2,'127.0.0.10','dfbd10d2c43c598707181edac1dcb03f',126,1163992875),
  (15,2,'127.0.0.10','2fa75156d5b5c303756c73aff49271cd',148,1164262245),
  (16,2,'127.0.0.10','cf86fbaa31ae0541760c738157ddad41',149,1164762973),
  (17,2,'127.0.0.10','231926d71b42299ad056586146d9fdc8',150,1165213689),
  (18,2,'127.0.0.1','23f7962e0e872c530f4e8af736633a87',151,1165448691),
  (19,2,'127.0.0.1','87797ac73e4f640b4afc275d741d1204',155,1166160735),
  (21,2,'127.0.0.1','d7077cea0a904e17ac64769455aca1c1',157,1167013306),
  (22,2,'127.0.0.1','6cf0e978f23e2cb178b7aed1112095f9',176,1170655390),
  (23,2,'127.0.0.1','7f0e40b578c76a1809043d0cb4b1b58d',189,1170713610),
  (25,2,'127.0.0.1','35309ce4e0316685d1be41d25afde9d7',224,1172709883),
  (26,2,'127.0.0.1','e43de89500fe5c144b5a4687c80cefa9',253,1173239786),
  (27,2,'127.0.0.1','ccc906aca21b95a2e8825f6533632de5',259,1173277691),
  (28,2,'127.0.0.1','ab6db17706e797855c40ba766f8ee3fc',260,1173523868),
  (29,2,'127.0.0.1','64e5e933282a5f410d87265186533fe4',262,1173738059),
  (30,2,'127.0.0.1','a82f02233d00f3ac1f998934774e5331',263,1173762922);

COMMIT;

#
# Structure for the `user_userGroup_rel` table : 
#

DROP TABLE IF EXISTS `user_userGroup_rel`;

CREATE TABLE `user_userGroup_rel` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `user_userGroup_rel` table  (LIMIT 0,500)
#

INSERT INTO `user_userGroup_rel` (`id`, `group_id`, `user_id`, `obj_id`) VALUES 
  (1,1,1,50),
  (23,2,2,47),
  (24,3,2,226),
  (29,2,3,232);

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;