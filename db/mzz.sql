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

SET sql_mode = '';

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
  PRIMARY KEY (`id`),
  KEY `folder_id` (`folder_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `comments_comments` table  (LIMIT 0,500)
#

INSERT INTO `comments_comments` (`id`, `obj_id`, `text`, `user_id`, `created`, `folder_id`) VALUES 
  (1,NULL,'test',1,1248950392,1);
COMMIT;

#
# Structure for the `comments_commentsFolder` table : 
#

DROP TABLE IF EXISTS `comments_commentsFolder`;

CREATE TABLE `comments_commentsFolder` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `module` CHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` CHAR(50) COLLATE utf8_general_ci DEFAULT NULL,
  `by_field` CHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `comments_count` INTEGER(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_id_2` (`parent_id`, `type`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `comments_commentsFolder` table  (LIMIT 0,500)
#

INSERT INTO `comments_commentsFolder` (`id`, `parent_id`, `module`, `type`, `by_field`, `comments_count`) VALUES 
  (1,9,'page','page','obj_id',1),
  (2,1,'page','page','id',0);
COMMIT;

#
# Structure for the `comments_comments_tree` table : 
#

DROP TABLE IF EXISTS `comments_comments_tree`;

CREATE TABLE `comments_comments_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `parent_id` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) DEFAULT NULL,
  `path` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`),
  KEY `foreign_key` (`foreign_key`),
  KEY `parent_id` (`parent_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `comments_comments_tree` table  (LIMIT 0,500)
#

INSERT INTO `comments_comments_tree` (`id`, `foreign_key`, `parent_id`, `level`, `path`) VALUES 
  (1,1,0,1,'1/');
COMMIT;

#
# Structure for the `fileManager_file` table : 
#

DROP TABLE IF EXISTS `fileManager_file`;

CREATE TABLE `fileManager_file` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `realname` VARCHAR(255) COLLATE utf8_general_ci DEFAULT 'èìÿ â ôñ â êàòàëîãå íà ñåðâåðå',
  `name` VARCHAR(255) COLLATE utf8_general_ci DEFAULT 'èìÿ ñ êîòîðûì ôàéë áóäåò îòäàâàòüñÿ êëèåíòó',
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
  (1,'4e3086e5c8df049bc271e42eead64437.jpg','june-09-the-perfect-wave-calendar-1280x1024.jpg','jpg',711416,NULL,1,0,0,'',1,NULL,1),
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
  `type_id` INTEGER(10) UNSIGNED NOT NULL DEFAULT '1',
  `menu_id` INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
  `order` INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
  `args` TEXT COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=4 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menuItem` table  (LIMIT 0,500)
#

INSERT INTO `menu_menuItem` (`id`, `type_id`, `menu_id`, `order`, `args`) VALUES 
  (1,2,6,1,'a:5:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:6:\"module\";s:4:\"news\";s:6:\"action\";s:0:\"\";s:12:\"activeRoutes\";a:2:{i:0;a:2:{s:5:\"route\";s:10:\"newsFolder\";s:6:\"params\";a:2:{s:4:\"name\";s:1:\"*\";s:6:\"action\";s:4:\"list\";}}i:1;a:2:{s:5:\"route\";s:6:\"withId\";s:6:\"params\";a:3:{s:6:\"module\";s:0:\"\";s:2:\"id\";s:1:\"*\";s:6:\"action\";s:4:\"view\";}}}}'),
  (2,2,6,2,'a:5:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:6:\"module\";s:4:\"page\";s:6:\"action\";s:0:\"\";s:12:\"activeRoutes\";a:3:{i:0;a:2:{s:5:\"route\";s:11:\"pageActions\";s:6:\"params\";a:2:{s:4:\"name\";s:4:\"main\";s:6:\"action\";s:4:\"view\";}}i:1;a:2:{s:5:\"route\";s:11:\"pageDefault\";s:6:\"params\";a:0:{}}i:2;a:2:{s:5:\"route\";s:7:\"default\";s:6:\"params\";a:0:{}}}}'),
  (3,2,6,3,'a:5:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:6:\"module\";s:5:\"admin\";s:6:\"action\";s:5:\"admin\";s:12:\"activeRoutes\";a:0:{}}');
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
  (1,1,'Íîâîñòè'),
  (1,2,'News'),
  (2,1,'Î íàñ'),
  (2,2,'About us'),
  (3,1,'ÏÓ'),
  (3,2,'AP'),
  (9,1,'Íîâîñòè'),
  (9,2,'News'),
  (10,1,'Êàòàëîã'),
  (10,2,'Catalogue'),
  (11,1,'Ãàëåðåÿ'),
  (11,2,'Gallery'),
  (12,1,'FAQ'),
  (12,2,'FAQ'),
  (13,1,'Ôîðóì'),
  (13,2,'Forum'),
  (14,1,'ÏÓ'),
  (14,2,'AP'),
  (24,1,'Î íàñ'),
  (24,2,'About us');
COMMIT;

#
# Structure for the `menu_menuItem_tree` table : 
#

DROP TABLE IF EXISTS `menu_menuItem_tree`;

CREATE TABLE `menu_menuItem_tree` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `foreign_key` INTEGER(11) DEFAULT NULL,
  `parent_id` INTEGER(11) DEFAULT NULL,
  `level` INTEGER(11) DEFAULT NULL,
  `path` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY (`id`),
  KEY `foreign_key` (`foreign_key`),
  KEY `parent_id` (`parent_id`)
)ENGINE=MyISAM
AUTO_INCREMENT=4 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menuItem_tree` table  (LIMIT 0,500)
#

INSERT INTO `menu_menuItem_tree` (`id`, `foreign_key`, `parent_id`, `level`, `path`) VALUES 
  (1,1,0,1,'1/'),
  (2,2,0,1,'2/'),
  (3,3,0,1,'3/');
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
  (2,1,'Íîâîñòè'),
  (2,2,'News'),
  (18,1,'Ãëàâíîå'),
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
  (169,1,'Ðîññèÿíå íàçâàëè ñâîè ëþáèìûå áðåíäû','Ïåðâûå òðè ìåñòà ðåéòèíãà ëþáèìûõ áðåíäîâ ðîññèÿí çàíÿëè Samsung, Sony è Nokia. Íà ÷åòâåðòîì ìåñòå Panasonic, à íà ïÿòîì - Toyota. Òàêèå ðåçóëüòàòû äàëî èññëåäîâàíèå êîìïàíèè Online Market Intelligence. Â äâàäöàòêó ëþáèìûõ ðîññèÿíàìè áðåíäîâ âîøëè Nissan, Reebok è Honda, íå ïîïàâøèå â ïðîøëîãîäíèé ðåéòèíã.','Ïåðâûå òðè ìåñòà ðåéòèíãà ëþáèìûõ áðåíäîâ ðîññèÿí çàíÿëè Samsung, Sony è Nokia. Òàêèå ðåçóëüòàòû äàëî èññëåäîâàíèå, ïðîâåäåííîå êîìïàíèåé Online Market Intelligence.\n\nÒàêèì îáðàçîì, â òðîéêå ëèäåðîâ îêàçàëèñü òå æå áðåíäû, ÷òî è â 2008 ãîäó, íî Samsung ïîäíÿëñÿ íà ïåðâîå ìåñòî ñî âòîðîãî, à Sony ïîòåðÿëà îäíó ñòðî÷êó. Íà ÷åòâåðòîì ìåñòå Panasonic, à íà ïÿòîì - Toyota. Â ïðîøëîì ãîäó ïÿòîå ìåñòî çàíèìàë Adidas, îïóñòèâøèéñÿ íà øåñòóþ ñòðî÷êó.\n\nÑèëüíåå âñåãî óïàëè â ðåéòèíãå áðåíäû BMW (îïóñòèëñÿ ñ ñåäüìîãî ìåñòà íà äåâÿòíàäöàòîå) è Mercedes (ñ âîñüìîãî íà âîñåìíàäöàòîå). Ìåæäó òåì, â äâàäöàòêó ëþáèìûõ áðåíäîâ ïîïàëè Nissan, Reebok è Honda, íå âîøåäøèå â ðåéòèíã 2008 ãîäà.\n\nÏîëíîñòüþ ñïèñîê ëþáèìûõ áðåíäîâ âûãëÿäèò ñëåäóþùèì îáðàçîì:\n\n   1. Samsung\n   2. Sony\n   3. Nokia\n   4. Panasonic\n   5. Toyota\n   6. Adidas\n   7. Canon\n   8. Bosch\n   9. Asus\n  10. Philips\n  11. HP\n  12. Sony Ericsson\n  13. Nike\n  14. LG\n  15. Nissan\n  16. Coca-Cola\n  17. Reebok\n  18. Mercedes\n  19. BMW\n  20. Honda \n\nÂ îñíîâó ðåéòèíãà ëåãëà äîëÿ óïîìÿíóâøèõ êàæäûé áðåíä îò îáùåãî ÷èñëà ðåñïîíäåíòîâ, íàçâàâøèõ õîòÿ áû îäèí áðåíä. Ñîîáùàåòñÿ òàêæå, ÷òî ïîëíûé ìàòåðèàë î ðåçóëüòàòàõ èññëåäîâàíèÿ ñ êîììåíòàðèÿìè ýêñïåðòîâ áóäåò îïóáëèêîâàí â åæåíåäåëüíèêå \"Êîìïàíèÿ\". ');
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
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=5 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `page_pageFolder` table  (LIMIT 0,500)
#

INSERT INTO `page_pageFolder` (`id`, `obj_id`, `name`, `title`) VALUES 
  (2,161,'root','/');
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
  (1,1,'Äîáðî ïîæàëîâàòü!','<p>Â íîâîé âåðñèè íàøåãî ôðåéìâîðêà ìû ïðîäåëàëè îãðîìíóþ ðàáîòó, ñäåëàâ ôðåéìâîðê åù¸ ñòàáèëüíåå è ãèá÷å.<br /> <br /> Èç èçìåíåíèé îñîáî õîòåëîñü áû âûäåëèòü íîâûé ORM, áîëåå áûñòðûé è ãèáêèé áëàãîäàðÿ ïëàãèíàì. Âìåñòî ñòàðîãî ACL, mzz îáçàâ¸ëñÿ òåïåðü äâóìÿ ïîëèòèêàìè îáðàáîòêè ïðàâ ïîëüçîâàòåëåé: acl_simple (óïðîùåííûé) è acl_ext (ðàñøèðåííûé). Óïðîù¸ííûé îïåðèðóåò êëàññàìè îáúåêòîâ, ðàñøèðåííûé - òàê æå êàê è ðàíüøå, êîíêðåòíûìè îáúåêòàìè. Â áîëüøèíñòâå ñëó÷àåâ äîñòàòî÷íî ôóíêöèé ïðîñòîãî ACL, ÷òî ïîçâîëÿåò èçáåæàòü ëèøíèõ çàïðîñîâ ê ÁÄ è ñäåëàòü ïðèëîæåíèå åùå áûñòðåå, à óïðàâëåíèå ïðàâàìè äîñòóïà - åù¸ ïðîùå. Â êà÷åñòâå javascript-ôðåéìâîðêà òåïåðü èñïîëüçóåòñÿ jQuery (â ðåæèìå ñîâìåñòèìîñòè).<br /> <br /> Â ýòîò ðåëèç áûëè âêëþ÷åíû ïåðåïèñàííûå ñ ó÷åòîì íîâîââåäåíèé ñàìûå íåîáõîäèìûå èç ïðåäûäóùèõ ìîäóëåé: íîâîñòè, ñòðàíèöû, ôàéëîâûé ìåíåäæåð, êîììåíòàðèè, ìåíþ, captcha. Â ñëåäóþùèõ âåðñèÿõ, ïàðàëëåëüíî ñ ðàçâèòèåì ñàìîãî ôðåéìâîðêà, áóäåò äîáàâëåí åù¸ ðÿä ìîäóëåé.<br /> <br /> Áîëåå ïîäðîáíóþ èíôîðìàöèþ î âíóòðåííåì óñòðîéñòâå ôðåéìâîðêà ìîæíî íàéòè â äîêóìåíòàöèè. Ïî âñåì âîïðîñàì, êàñàþùèìñÿ ðàçðàáîòêè ñ èñïîëüçîâàíèåì mzz, âû ìîæåòå îáðàùàòüñÿ â íàø <a href=\"http://mzz.ru/forum\">ôîðóì</a>, ëèáî <a style=\"color: #006620; background-color: #fff9ab;\" title=\"Linkification: irc://mzz@irc.rusnet.ru\">irc://mzz@irc.rusnet.ru</a>.<br /> <br /> Äëÿ àâòîðèçàöèè â äåìî-ïðèëîæåíèè èñïîëüçóéòå ñëåäóþùèå äàííûå:<br /> Ëîãèí: admin<br /> Ïàðîëü: test</p>','',''),
  (1,2,'About us','<strong>mzz</strong> - is a php5 framework for web-applications.',NULL,NULL),
  (2,1,'404 Not Found','Çàïðàøèâàåìàÿ ñòðàíèöà íå íàéäåíà!',NULL,NULL),
  (2,2,'404 Not Found','Page doesn''t exist',NULL,NULL),
  (4,1,'Äîñòóï çàïðåù¸í','Äîñòóï çàïðåù¸í',NULL,NULL),
  (4,2,'Access not allowed.','Access not allowed. Try to login or register.',NULL,NULL);
COMMIT;

#
# Structure for the `sys_config` table : 
#

DROP TABLE IF EXISTS `sys_config`;

CREATE TABLE `sys_config` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `module_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type_id` INTEGER(11) NOT NULL,
  `value` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `args` TEXT COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_name` (`module_name`),
  KEY `name` (`name`)
)ENGINE=MyISAM
AUTO_INCREMENT=5 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `sys_config` table  (LIMIT 0,500)
#

INSERT INTO `sys_config` (`id`, `module_name`, `name`, `title`, `type_id`, `value`, `args`) VALUES 
  (3,'news','items_per_page','Êîëè÷åñòâî ýëåìåíòîâ íà ñòðàíèöó',1,'20',''),
  (4,'fileManager','public_path','Ïóòü äî ïàáëèê ïàïêè',2,'','');
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
  (1,'ru','ðó'),
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
  (1,1,'ðóññêèé'),
  (1,2,'russian'),
  (2,1,'àíãëèéñêèé'),
  (2,2,'english');
COMMIT;

#
# Structure for the `sys_obj_id` table : 
#

DROP TABLE IF EXISTS `sys_obj_id`;

CREATE TABLE `sys_obj_id` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1462 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

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
  (1460),
  (1461);
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
# Structure for the `user_roles` table : 
#

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `group_id` INTEGER(11) NOT NULL,
  `module` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `role` VARCHAR(32) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_module_role` (`group_id`, `module`, `role`)
)ENGINE=MyISAM
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Structure for the `user_user` table : 
#

DROP TABLE IF EXISTS `user_user`;

CREATE TABLE `user_user` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
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
AUTO_INCREMENT=6 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_user` table  (LIMIT 0,500)
#

INSERT INTO `user_user` (`id`, `login`, `email`, `password`, `created`, `confirmed`, `last_login`, `language_id`, `timezone`, `skin`) VALUES 
  (1,'guest','','',NULL,NULL,1225005849,NULL,3,1),
  (2,'admin','','098f6bcd4621d373cade4e832627b4f6',NULL,NULL,1253665584,1,3,1),
  (3,'moderator','','098f6bcd4621d373cade4e832627b4f6',1188187851,NULL,1203767664,1,3,1),
  (4,'user','','098f6bcd4621d373cade4e832627b4f6',1243925700,NULL,NULL,NULL,3,1),
  (5,'qwe','','202cb962ac59075b964b07152d234b70',1249521132,NULL,NULL,1,3,1);
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
AUTO_INCREMENT=138 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_userAuth` table  (LIMIT 0,500)
#

INSERT INTO `user_userAuth` (`id`, `user_id`, `ip`, `hash`, `obj_id`, `time`) VALUES 
  (120,2,'10.30.35.150','0e92bb89eee69e7b2d0fabf722f6dd6b',NULL,NULL),
  (121,2,'127.0.0.1','e6554e265eb42296f32e6ebb6ae555af',NULL,NULL),
  (122,2,'127.0.0.1','41c1f3d65189710fd9a0326716b7d643',NULL,NULL),
  (123,2,'127.0.0.1','e87b231c137decdd917559c2d8121d4b',NULL,NULL),
  (124,2,'127.0.0.1','508472f0463a79bc906538de5f39dfb6',NULL,NULL),
  (125,2,'127.0.0.1','0e8f35e187247098b098204613bd9b27',NULL,NULL),
  (126,2,'127.0.0.1','956eb3fa26b9b78b82c96d9f098d8a06',NULL,NULL),
  (128,2,'10.30.35.9','639eb7566aaf6b368863cfb4ba8afd1e',NULL,NULL),
  (132,2,'10.30.35.150','c54fbf06a0f11f5a10f4822e493a82bd',NULL,NULL),
  (133,2,'127.0.0.1','021d2bab67d5c4d478dd39d7cfaca0b2',NULL,NULL),
  (134,2,'127.0.0.1','254be4b2e6328875e8dfe2291eead872',NULL,NULL),
  (135,2,'127.0.0.1','f028a4c7dd2cfce774e71b1d86cba0a4',NULL,NULL),
  (136,5,'10.30.35.150','b77e872c8cdbe566085756413d0beef1',NULL,NULL),
  (137,2,'127.0.0.1','ba3c6bca2a06f107dfaeb0d72d3ea278',NULL,1253230671);
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
AUTO_INCREMENT=34 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `user_userGroup_rel` table  (LIMIT 0,500)
#

INSERT INTO `user_userGroup_rel` (`id`, `group_id`, `user_id`) VALUES 
  (1,1,1),
  (23,2,2),
  (24,3,2),
  (30,2,3),
  (31,2,4),
  (32,4,3),
  (33,2,5);
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