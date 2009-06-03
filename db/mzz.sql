# SQL Manager 2007 for MySQL 4.4.0.5
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mzz


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `mzz`;

CREATE DATABASE `mzz`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `mzz`;

#
# Structure for the `comments_comments` table : 
#

DROP TABLE IF EXISTS `comments_comments`;

CREATE TABLE `comments_comments` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `text` TEXT COLLATE utf8_general_ci,
  `user_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `created` INTEGER(11) UNSIGNED DEFAULT NULL,
  `folder_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `comments_commentsFolder` table : 
#

DROP TABLE IF EXISTS `comments_commentsFolder`;

CREATE TABLE `comments_commentsFolder` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `parent_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `module` CHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` CHAR(50) COLLATE utf8_general_ci DEFAULT NULL,
  `by_field` CHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_id_2` (`parent_id`, `type`),
  KEY `parent_id` (`parent_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=4 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `comments_commentsFolder` table  (LIMIT 0,500)
#

INSERT INTO `comments_commentsFolder` (`id`, `obj_id`, `parent_id`, `module`, `type`, `by_field`) VALUES 
  (2,1458,1457,'news','news','obj_id'),
  (3,1459,9,'page','page','obj_id');
COMMIT;

#
# Structure for the `comments_comments_tree` table : 
#

DROP TABLE IF EXISTS `comments_comments_tree`;

CREATE TABLE `comments_comments_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` TEXT COLLATE utf8_general_ci,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) UNSIGNED DEFAULT NULL,
  `spath` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=15 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `fileManager_file` table : 
#

DROP TABLE IF EXISTS `fileManager_file`;

CREATE TABLE `fileManager_file` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `realname` VARCHAR(255) COLLATE utf8_general_ci DEFAULT 'имя в фс в каталоге на сервере',
  `name` VARCHAR(255) COLLATE utf8_general_ci DEFAULT 'имя с которым файл будет отдаваться клиенту',
  `ext` VARCHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `size` INTEGER(11) DEFAULT NULL,
  `modified` INTEGER(11) DEFAULT NULL,
  `downloads` INTEGER(11) DEFAULT '0',
  `right_header` TINYINT(4) DEFAULT NULL,
  `direct_link` INTEGER(11) DEFAULT '0',
  `about` TEXT COLLATE utf8_general_ci,
  `folder_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `storage_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `realname` (`realname`),
  KEY `folder_id` (`folder_id`, `name`, `ext`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_file` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_file` (`id`, `realname`, `name`, `ext`, `size`, `modified`, `downloads`, `right_header`, `direct_link`, `about`, `folder_id`, `obj_id`, `storage_id`) VALUES 
  (1,'4e3086e5c8df049bc271e42eead64437.jpg','june-09-the-perfect-wave-calendar-1280x1024.jpg','jpg',711416,NULL,NULL,0,0,'',1,NULL,1),
  (2,'56cf8ac2db85fec5c194c4c4cfef3d92.jpg','june-09-light-bokeh_of_the_abstract-calendar-1280x1024.jpg','jpg',580032,NULL,NULL,0,0,'',1,NULL,1);
COMMIT;

#
# Structure for the `fileManager_folder` table : 
#

DROP TABLE IF EXISTS `fileManager_folder`;

CREATE TABLE `fileManager_folder` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `filesize` INTEGER(11) UNSIGNED DEFAULT NULL,
  `exts` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `storage_id` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_folder` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_folder` (`id`, `name`, `title`, `filesize`, `exts`, `storage_id`) VALUES 
  (1,'root','root',NULL,NULL,1),
  (2,'test','test',0,'',1);
COMMIT;

#
# Structure for the `fileManager_folder_tree` table : 
#

DROP TABLE IF EXISTS `fileManager_folder_tree`;

CREATE TABLE `fileManager_folder_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` TEXT COLLATE utf8_general_ci,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) UNSIGNED DEFAULT NULL,
  `spath` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_folder_tree` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_folder_tree` (`id`, `path`, `foreign_key`, `level`, `spath`) VALUES 
  (1,'root/',1,1,'1/'),
  (2,'root/test/',2,2,'1/2/');
COMMIT;

#
# Structure for the `fileManager_storage` table : 
#

DROP TABLE IF EXISTS `fileManager_storage`;

CREATE TABLE `fileManager_storage` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `web_path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_storage` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_storage` (`id`, `name`, `path`, `web_path`) VALUES 
  (1,'local','../files/','/');
COMMIT;

#
# Structure for the `menu_menu` table : 
#

DROP TABLE IF EXISTS `menu_menu`;

CREATE TABLE `menu_menu` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `obj_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=8 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menu` table  (LIMIT 0,500)
#

INSERT INTO `menu_menu` (`id`, `name`, `obj_id`) VALUES 
  (6,'hmenu',1185);
COMMIT;

#
# Structure for the `menu_menuItem` table : 
#

DROP TABLE IF EXISTS `menu_menuItem`;

CREATE TABLE `menu_menuItem` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `parent_id` INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
  `type_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  `menu_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  `order` INTEGER(10) UNSIGNED DEFAULT '0',
  `args` TEXT COLLATE utf8_general_ci NOT NULL,
  `obj_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=28 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menuItem` table  (LIMIT 0,500)
#

INSERT INTO `menu_menuItem` (`id`, `parent_id`, `type_id`, `menu_id`, `order`, `args`, `obj_id`) VALUES 
  (9,0,2,6,1,'a:4:{s:5:\"route\";s:8:\"default2\";s:7:\"section\";s:4:\"news\";s:6:\"action\";s:0:\"\";s:12:\"activeRoutes\";a:2:{i:0;a:2:{s:5:\"route\";s:10:\"newsFolder\";s:6:\"params\";a:2:{s:4:\"name\";s:1:\"*\";s:6:\"action\";s:4:\"list\";}}i:1;a:2:{s:5:\"route\";s:6:\"withId\";s:6:\"params\";a:3:{s:7:\"section\";s:4:\"news\";s:2:\"id\";s:1:\"*\";s:6:\"action\";s:4:\"view\";}}}}',1186),
  (14,0,2,6,3,'a:4:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:7:\"section\";s:5:\"admin\";s:6:\"action\";s:5:\"admin\";}',1191),
  (24,0,1,6,2,'a:1:{s:3:\"url\";s:4:\"page\";}',1301);
COMMIT;

#
# Structure for the `menu_menuItem_lang` table : 
#

DROP TABLE IF EXISTS `menu_menuItem_lang`;

CREATE TABLE `menu_menuItem_lang` (
  `id` INTEGER(11) NOT NULL DEFAULT '0',
  `lang_id` INTEGER(11) NOT NULL DEFAULT '0',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menuItem_lang` table  (LIMIT 0,500)
#

INSERT INTO `menu_menuItem_lang` (`id`, `lang_id`, `title`) VALUES 
  (9,1,'Новости'),
  (9,2,'News'),
  (10,1,'Каталог'),
  (10,2,'Catalogue'),
  (11,1,'Галерея'),
  (11,2,'Gallery'),
  (12,1,'FAQ'),
  (12,2,'FAQ'),
  (13,1,'Форум'),
  (13,2,'Forum'),
  (14,1,'ПУ'),
  (14,2,'AP'),
  (24,1,'О нас'),
  (24,2,'About us');
COMMIT;

#
# Structure for the `news_news` table : 
#

DROP TABLE IF EXISTS `news_news`;

CREATE TABLE `news_news` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `editor` INTEGER(11) NOT NULL DEFAULT '0',
  `folder_id` INTEGER(11) DEFAULT NULL,
  `created` INTEGER(11) DEFAULT NULL,
  `updated` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `folder_id` (`folder_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=170 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `news_news` table  (LIMIT 0,500)
#

INSERT INTO `news_news` (`id`, `obj_id`, `editor`, `folder_id`, `created`, `updated`) VALUES 
  (169,1457,2,2,1233907447,1243927140);
COMMIT;

#
# Structure for the `news_newsFolder` table : 
#

DROP TABLE IF EXISTS `news_newsFolder`;

CREATE TABLE `news_newsFolder` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent` INTEGER(11) DEFAULT '0',
  `path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `parent` (`parent`)
)ENGINE=MyISAM
AUTO_INCREMENT=32 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `news_newsFolder` table  (LIMIT 0,500)
#

INSERT INTO `news_newsFolder` (`id`, `name`, `parent`, `path`, `title`) VALUES 
  (2,'root',1,'root','root'),
  (18,'main',17,'root/main','main');
COMMIT;

#
# Structure for the `news_newsFolder_lang` table : 
#

DROP TABLE IF EXISTS `news_newsFolder_lang`;

CREATE TABLE `news_newsFolder_lang` (
  `id` INTEGER(11) NOT NULL DEFAULT '0',
  `lang_id` INTEGER(11) NOT NULL DEFAULT '0',
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `news_newsFolder_lang` table  (LIMIT 0,500)
#

INSERT INTO `news_newsFolder_lang` (`id`, `lang_id`, `title`) VALUES 
  (2,1,'Новости'),
  (2,2,'News'),
  (18,1,'Главное'),
  (18,2,'Main');
COMMIT;

#
# Structure for the `news_newsFolder_tree` table : 
#

DROP TABLE IF EXISTS `news_newsFolder_tree`;

CREATE TABLE `news_newsFolder_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` TEXT COLLATE utf8_general_ci,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) UNSIGNED DEFAULT NULL,
  `spath` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=16 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `news_newsFolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `news_newsFolder_tree` (`id`, `path`, `foreign_key`, `level`, `spath`) VALUES 
  (1,'root/',2,1,'1/'),
  (2,'root/main/',18,2,'1/2/');
COMMIT;

#
# Structure for the `news_news_lang` table : 
#

DROP TABLE IF EXISTS `news_news_lang`;

CREATE TABLE `news_news_lang` (
  `id` INTEGER(11) NOT NULL DEFAULT '0',
  `lang_id` INTEGER(11) NOT NULL DEFAULT '0',
  `title` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `annotation` TEXT COLLATE utf8_general_ci,
  `text` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `news_news_lang` table  (LIMIT 0,500)
#

INSERT INTO `news_news_lang` (`id`, `lang_id`, `title`, `annotation`, `text`) VALUES 
  (169,1,'Россияне назвали свои любимые бренды','Первые три места рейтинга любимых брендов россиян заняли Samsung, Sony и Nokia. На четвертом месте Panasonic, а на пятом - Toyota. Такие результаты дало исследование компании Online Market Intelligence. В двадцатку любимых россиянами брендов вошли Nissan, Reebok и Honda, не попавшие в прошлогодний рейтинг.','Первые три места рейтинга любимых брендов россиян заняли Samsung, Sony и Nokia. Такие результаты дало исследование, проведенное компанией Online Market Intelligence.\n\nТаким образом, в тройке лидеров оказались те же бренды, что и в 2008 году, но Samsung поднялся на первое место со второго, а Sony потеряла одну строчку. На четвертом месте Panasonic, а на пятом - Toyota. В прошлом году пятое место занимал Adidas, опустившийся на шестую строчку.\n\nСильнее всего упали в рейтинге бренды BMW (опустился с седьмого места на девятнадцатое) и Mercedes (с восьмого на восемнадцатое). Между тем, в двадцатку любимых брендов попали Nissan, Reebok и Honda, не вошедшие в рейтинг 2008 года.\n\nПолностью список любимых брендов выглядит следующим образом:\n\n   1. Samsung\n   2. Sony\n   3. Nokia\n   4. Panasonic\n   5. Toyota\n   6. Adidas\n   7. Canon\n   8. Bosch\n   9. Asus\n  10. Philips\n  11. HP\n  12. Sony Ericsson\n  13. Nike\n  14. LG\n  15. Nissan\n  16. Coca-Cola\n  17. Reebok\n  18. Mercedes\n  19. BMW\n  20. Honda \n\nВ основу рейтинга легла доля упомянувших каждый бренд от общего числа респондентов, назвавших хотя бы один бренд. Сообщается также, что полный материал о результатах исследования с комментариями экспертов будет опубликован в еженедельнике \"Компания\". ');
COMMIT;

#
# Structure for the `page_page` table : 
#

DROP TABLE IF EXISTS `page_page`;

CREATE TABLE `page_page` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `folder_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `allow_comment` TINYINT(4) DEFAULT '1',
  `compiled` INTEGER(11) DEFAULT NULL,
  `keywords_reset` TINYINT(1) DEFAULT '0',
  `description_reset` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=12 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `page_page` table  (LIMIT 0,500)
#

INSERT INTO `page_page` (`id`, `obj_id`, `name`, `folder_id`, `allow_comment`, `compiled`, `keywords_reset`, `description_reset`) VALUES 
  (1,9,'main',2,1,0,0,0),
  (2,10,'404',2,1,NULL,0,0),
  (4,57,'403',2,1,NULL,0,0);
COMMIT;

#
# Structure for the `page_pageFolder` table : 
#

DROP TABLE IF EXISTS `page_pageFolder`;

CREATE TABLE `page_pageFolder` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent` INTEGER(11) DEFAULT '0',
  `path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=5 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `page_pageFolder` table  (LIMIT 0,500)
#

INSERT INTO `page_pageFolder` (`id`, `obj_id`, `name`, `title`, `parent`, `path`) VALUES 
  (2,161,'root','/',1,'root');
COMMIT;

#
# Structure for the `page_pageFolder_tree` table : 
#

DROP TABLE IF EXISTS `page_pageFolder_tree`;

CREATE TABLE `page_pageFolder_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` TEXT COLLATE utf8_general_ci,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) UNSIGNED DEFAULT NULL,
  `spath` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `page_pageFolder_tree` table  (LIMIT 0,500)
#

INSERT INTO `page_pageFolder_tree` (`id`, `path`, `foreign_key`, `level`, `spath`) VALUES 
  (1,'root/',2,1,'1/');
COMMIT;

#
# Structure for the `page_page_lang` table : 
#

DROP TABLE IF EXISTS `page_page_lang`;

CREATE TABLE `page_page_lang` (
  `id` INTEGER(11) NOT NULL DEFAULT '0',
  `lang_id` INTEGER(11) NOT NULL DEFAULT '0',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` TEXT COLLATE utf8_general_ci NOT NULL,
  `keywords` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `description` VARCHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `page_page_lang` table  (LIMIT 0,500)
#

INSERT INTO `page_page_lang` (`id`, `lang_id`, `title`, `content`, `keywords`, `description`) VALUES 
  (1,1,'Первая страница','Это <b>первая</b>, главная <strike>страница</strike>\n',NULL,NULL),
  (1,2,'About us','<strong>mzz</strong> - is a php5 framework for web-applications.',NULL,NULL),
  (2,1,'404 Not Found','Запрашиваемая страница не найдена!',NULL,NULL),
  (2,2,'404 Not Found','Page doesn''t exist',NULL,NULL),
  (4,1,'Доступ запрещён','Доступ запрещён',NULL,NULL),
  (4,2,'Access not allowed.','Access not allowed. Try to login or register.',NULL,NULL);
COMMIT;

#
# Structure for the `sys_access` table : 
#

DROP TABLE IF EXISTS `sys_access`;

CREATE TABLE `sys_access` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `action_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `class_id` INTEGER(11) DEFAULT NULL,
  `obj_id` INTEGER(11) DEFAULT NULL,
  `uid` INTEGER(11) DEFAULT NULL,
  `gid` INTEGER(11) DEFAULT NULL,
  `allow` TINYINT(1) UNSIGNED DEFAULT '0',
  `deny` TINYINT(1) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `class_action_id` (`class_id`, `obj_id`, `uid`, `gid`),
  KEY `obj_id_gid` (`obj_id`, `gid`),
  KEY `obj_id_uid` (`obj_id`, `uid`)
)ENGINE=MyISAM
AUTO_INCREMENT=9093 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_access` table  (LIMIT 0,500)
#

INSERT INTO `sys_access` (`id`, `action_id`, `class_id`, `obj_id`, `uid`, `gid`, `allow`, `deny`) VALUES 
  (9079,3,1,0,NULL,1,1,0),
  (9080,3,1,0,NULL,2,1,0),
  (9081,3,1,0,NULL,4,1,0),
  (9082,1,1,0,NULL,4,1,0),
  (9083,29,1,0,NULL,4,1,0),
  (9084,2,1,0,NULL,4,1,0),
  (9085,5,2,0,NULL,1,1,0),
  (9086,5,2,0,NULL,2,1,0),
  (9087,4,2,0,NULL,4,1,0),
  (9088,5,2,0,NULL,4,1,0),
  (9089,6,2,0,NULL,4,1,0),
  (9090,7,2,0,NULL,4,1,0),
  (9091,30,2,0,NULL,4,1,0),
  (9092,8,2,0,NULL,4,1,0);
COMMIT;

#
# Structure for the `sys_access_registry` table : 
#

DROP TABLE IF EXISTS `sys_access_registry`;

CREATE TABLE `sys_access_registry` (
  `obj_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`obj_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1461 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_access_registry` table  (LIMIT 0,500)
#

INSERT INTO `sys_access_registry` (`obj_id`, `class_id`) VALUES 
  (1443,9),
  (1444,7),
  (1445,7),
  (1446,7),
  (1447,7),
  (1448,7),
  (1449,7),
  (1450,7),
  (1451,7),
  (1452,7),
  (1453,7),
  (1454,50),
  (1455,52),
  (1456,3),
  (1457,1),
  (1458,11),
  (1459,11),
  (1460,7);
COMMIT;

#
# Structure for the `sys_actions` table : 
#

DROP TABLE IF EXISTS `sys_actions`;

CREATE TABLE `sys_actions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=109 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

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
  (27,'upload'),
  (28,'get'),
  (29,'move'),
  (30,'moveFolder'),
  (51,'groupCreate'),
  (52,'viewGallery'),
  (53,'createAlbum'),
  (54,'editAlbum'),
  (55,'viewAlbum'),
  (57,'viewThumbnail'),
  (59,'viewPhoto'),
  (60,'editPhoto'),
  (61,'save'),
  (62,'deletemenu'),
  (63,'addmenu'),
  (64,'editmenu'),
  (65,'additem'),
  (66,'last'),
  (67,'moveUp'),
  (68,'moveDown'),
  (69,'register'),
  (70,'results'),
  (71,'send'),
  (72,'addCategory'),
  (73,'deleteCategory'),
  (74,'editCategory'),
  (75,'viewActual'),
  (76,'deleteAlbum'),
  (77,'deletecat'),
  (78,'createcat'),
  (79,'editcat'),
  (80,'forum'),
  (81,'thread'),
  (82,'newThread'),
  (83,'createCategory'),
  (84,'createForum'),
  (85,'editForum'),
  (86,'goto'),
  (87,'editThread'),
  (88,'moveThread'),
  (89,'up'),
  (90,'down'),
  (91,'createRoot'),
  (92,'browse'),
  (93,'new'),
  (94,'editTags'),
  (95,'tagsCloud'),
  (96,'itemsTagsCloud'),
  (97,'searchByTag'),
  (98,'profile'),
  (99,'groupAdmin'),
  (100,'editProfile'),
  (101,'massAction'),
  (102,'translate'),
  (103,'configuration'),
  (104,'adminTypes'),
  (105,'adminProperties'),
  (106,'add'),
  (107,'menu'),
  (108,'configure');
COMMIT;

#
# Structure for the `sys_classes` table : 
#

DROP TABLE IF EXISTS `sys_classes`;

CREATE TABLE `sys_classes` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `module_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=61 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_classes` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) VALUES 
  (1,'news',1),
  (2,'newsFolder',1),
  (3,'user',2),
  (4,'group',2),
  (6,'page',4),
  (7,'access',5),
  (8,'userGroup',2),
  (9,'admin',6),
  (10,'comments',8),
  (11,'commentsFolder',8),
  (12,'userAuth',2),
  (13,'pageFolder',4),
  (24,'menuItem',12),
  (25,'menu',12),
  (26,'menuFolder',12),
  (27,'userOnline',2),
  (32,'message',14),
  (33,'messageCategory',14),
  (47,'captcha',18),
  (48,'profile',15),
  (50,'userFolder',2),
  (52,'groupFolder',2),
  (55,'configOption',22),
  (56,'configFolder',22),
  (58,'file',25),
  (59,'folder',25),
  (60,'storage',25);
COMMIT;

#
# Structure for the `sys_classes_actions` table : 
#

DROP TABLE IF EXISTS `sys_classes_actions`;

CREATE TABLE `sys_classes_actions` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `action_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_id` (`class_id`, `action_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=313 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_classes_actions` table  (LIMIT 0,500)
#

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) VALUES 
  (1,1,1),
  (2,1,2),
  (3,1,3),
  (5,2,4),
  (6,2,5),
  (7,2,6),
  (8,2,7),
  (9,2,8),
  (11,3,10),
  (12,3,11),
  (13,3,5),
  (14,3,1),
  (15,3,12),
  (16,3,2),
  (17,4,13),
  (19,4,15),
  (20,4,16),
  (21,4,17),
  (24,6,3),
  (28,6,1),
  (29,6,2),
  (31,7,18),
  (34,9,3),
  (37,10,2),
  (47,13,7),
  (48,13,6),
  (49,13,4),
  (50,13,5),
  (51,9,21),
  (70,1,29),
  (76,2,30),
  (91,13,8),
  (92,13,30),
  (114,7,20),
  (116,6,29),
  (158,26,20),
  (160,26,63),
  (161,25,64),
  (181,33,5),
  (182,32,3),
  (185,33,71),
  (186,32,2),
  (199,24,29),
  (253,1,97),
  (259,48,98),
  (264,50,20),
  (266,50,69),
  (270,50,4),
  (271,50,51),
  (279,52,51),
  (280,52,14),
  (281,48,100),
  (295,10,1),
  (296,55,2),
  (300,56,108),
  (301,58,20),
  (302,58,2),
  (303,58,1),
  (304,58,28),
  (305,58,29),
  (306,59,92),
  (307,59,6),
  (308,59,8),
  (309,59,7),
  (310,59,5),
  (311,59,30),
  (312,59,27);
COMMIT;

#
# Structure for the `sys_config` table : 
#

DROP TABLE IF EXISTS `sys_config`;

CREATE TABLE `sys_config` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `obj_id` INTEGER(10) UNSIGNED NOT NULL,
  `module_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type_id` INTEGER(11) NOT NULL,
  `value` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `args` TEXT COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=4 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_config` table  (LIMIT 0,500)
#

INSERT INTO `sys_config` (`id`, `obj_id`, `module_name`, `name`, `title`, `type_id`, `value`, `args`) VALUES 
  (3,0,'news','items_per_page','Количество элементов на страницу',1,'20','');
COMMIT;

#
# Structure for the `sys_lang` table : 
#

DROP TABLE IF EXISTS `sys_lang`;

CREATE TABLE `sys_lang` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(20) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_lang` table  (LIMIT 0,500)
#

INSERT INTO `sys_lang` (`id`, `name`, `title`) VALUES 
  (1,'ru','ру'),
  (2,'en','en');
COMMIT;

#
# Structure for the `sys_lang_lang` table : 
#

DROP TABLE IF EXISTS `sys_lang_lang`;

CREATE TABLE `sys_lang_lang` (
  `id` INTEGER(11) UNSIGNED NOT NULL,
  `lang_id` INTEGER(11) UNSIGNED NOT NULL,
  `name` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `lang_id`)
)ENGINE=MyISAM
ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_lang_lang` table  (LIMIT 0,500)
#

INSERT INTO `sys_lang_lang` (`id`, `lang_id`, `name`) VALUES 
  (1,1,'русский'),
  (1,2,'russian'),
  (2,1,'английский'),
  (2,2,'english');
COMMIT;

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `icon` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `order` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=26 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_modules` table  (LIMIT 0,500)
#

INSERT INTO `sys_modules` (`id`, `name`, `title`, `icon`, `order`) VALUES 
  (1,'news','Новости','news.gif',10),
  (2,'user','Пользователи','users.gif',90),
  (4,'page','Страницы','pages.gif',20),
  (5,'access','Права доступа','access.gif',10),
  (6,'admin','Администрирование','admin.gif',120),
  (8,'comments','Комментарии','comments.gif',40),
  (12,'menu','Меню','pages.gif',90),
  (18,'captcha','Captcha','',0),
  (19,'pager','Пейджер',NULL,NULL),
  (20,'simple','simple',NULL,NULL),
  (22,'config','Конфигурация','config.gif',0),
  (25,'fileManager','file manager','',0);
COMMIT;

#
# Structure for the `sys_obj_id` table : 
#

DROP TABLE IF EXISTS `sys_obj_id`;

CREATE TABLE `sys_obj_id` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1461 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_obj_id` table  (LIMIT 0,500)
#

INSERT INTO `sys_obj_id` (`id`) VALUES 
  (1443),
  (1444),
  (1445),
  (1446),
  (1447),
  (1448),
  (1449),
  (1450),
  (1451),
  (1452),
  (1453),
  (1454),
  (1455),
  (1456),
  (1457),
  (1458),
  (1459),
  (1460);
COMMIT;

#
# Structure for the `sys_obj_id_named` table : 
#

DROP TABLE IF EXISTS `sys_obj_id_named`;

CREATE TABLE `sys_obj_id_named` (
  `obj_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`obj_id`),
  UNIQUE KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=1461 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_obj_id_named` table  (LIMIT 0,500)
#

INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) VALUES 
  (1443,'access_admin'),
  (1444,'access_access'),
  (1445,'access_captcha'),
  (1446,'access_comments'),
  (1447,'access_config'),
  (1448,'access_menu'),
  (1449,'access_news'),
  (1450,'access_page'),
  (1451,'access_pager'),
  (1452,'access_simple'),
  (1453,'access_user'),
  (1454,'userFolder'),
  (1455,'groupFolder'),
  (1460,'access_fileManager');
COMMIT;

#
# Structure for the `sys_sessions` table : 
#

DROP TABLE IF EXISTS `sys_sessions`;

CREATE TABLE `sys_sessions` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `ts` INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  `valid` ENUM('yes','no') NOT NULL DEFAULT 'yes',
  `data` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sid` (`sid`),
  KEY `valid` (`valid`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `sys_skins` table : 
#

DROP TABLE IF EXISTS `sys_skins`;

CREATE TABLE `sys_skins` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_skins` table  (LIMIT 0,500)
#

INSERT INTO `sys_skins` (`id`, `name`, `title`) VALUES 
  (1,'default','default'),
  (2,'light','light');
COMMIT;

#
# Structure for the `user_group` table : 
#

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `is_default` TINYINT(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=5 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_group` table  (LIMIT 0,500)
#

INSERT INTO `user_group` (`id`, `name`, `is_default`) VALUES 
  (1,'unauth',NULL),
  (2,'auth',1),
  (3,'root',0),
  (4,'moderators',0);
COMMIT;

#
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `password` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `created` INTEGER(11) DEFAULT NULL,
  `confirmed` VARCHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  `last_login` INTEGER(11) DEFAULT NULL,
  `language_id` INTEGER(11) DEFAULT NULL,
  `timezone` INTEGER(11) DEFAULT '3',
  `skin` INTEGER(11) UNSIGNED DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `login` (`login`)
)ENGINE=MyISAM
AUTO_INCREMENT=5 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_user` table  (LIMIT 0,500)
#

INSERT INTO `user_user` (`id`, `login`, `password`, `created`, `confirmed`, `last_login`, `language_id`, `timezone`, `skin`) VALUES 
  (1,'guest','',NULL,NULL,1225005849,NULL,3,1),
  (2,'admin','098f6bcd4621d373cade4e832627b4f6',NULL,NULL,1237956788,1,3,1),
  (3,'moderator','098f6bcd4621d373cade4e832627b4f6',1188187851,NULL,1203767664,1,3,1),
  (4,'user','098f6bcd4621d373cade4e832627b4f6',1243925700,NULL,NULL,NULL,3,1);
COMMIT;

#
# Structure for the `user_userAuth` table : 
#

DROP TABLE IF EXISTS `user_userAuth`;

CREATE TABLE `user_userAuth` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `ip` CHAR(15) COLLATE utf8_general_ci DEFAULT NULL,
  `hash` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `time` INTEGER(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=124 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_userAuth` table  (LIMIT 0,500)
#

INSERT INTO `user_userAuth` (`id`, `user_id`, `ip`, `hash`, `obj_id`, `time`) VALUES 
  (120,2,'10.30.35.150','0e92bb89eee69e7b2d0fabf722f6dd6b',NULL,NULL),
  (121,2,'127.0.0.1','e6554e265eb42296f32e6ebb6ae555af',NULL,NULL),
  (122,2,'127.0.0.1','41c1f3d65189710fd9a0326716b7d643',NULL,NULL),
  (123,2,'127.0.0.1','e87b231c137decdd917559c2d8121d4b',NULL,NULL);
COMMIT;

#
# Structure for the `user_userGroup_rel` table : 
#

DROP TABLE IF EXISTS `user_userGroup_rel`;

CREATE TABLE `user_userGroup_rel` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `group_id` INTEGER(11) DEFAULT NULL,
  `user_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`, `user_id`),
  KEY `user_id` (`user_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=33 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_userGroup_rel` table  (LIMIT 0,500)
#

INSERT INTO `user_userGroup_rel` (`id`, `group_id`, `user_id`) VALUES 
  (1,1,1),
  (23,2,2),
  (24,3,2),
  (30,2,3),
  (31,2,4),
  (32,4,3);
COMMIT;

#
# Structure for the `user_userOnline` table : 
#

DROP TABLE IF EXISTS `user_userOnline`;

CREATE TABLE `user_userOnline` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER(11) DEFAULT NULL,
  `session` CHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  `last_activity` INTEGER(11) DEFAULT NULL,
  `url` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `ip` CHAR(15) COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`, `session`),
  KEY `last_activity` (`last_activity`)
)ENGINE=MyISAM
AUTO_INCREMENT=330 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_userOnline` table  (LIMIT 0,500)
#

INSERT INTO `user_userOnline` (`id`, `user_id`, `session`, `last_activity`, `url`, `ip`) VALUES 
  (329,2,'e068f18f7ca743008ebe3fea63ced400',1233982270,'http://mzz/ru/admin/devToolbar','127.0.0.1');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;