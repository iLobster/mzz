-- MySQL dump 10.11
--
-- Host: localhost    Database: mzz
-- ------------------------------------------------------
-- Server version	5.0.70-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `mzz`
--

/*!40000 DROP DATABASE IF EXISTS `mzz`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `mzz` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mzz`;

--
-- Table structure for table `comments_comments`
--

DROP TABLE IF EXISTS `comments_comments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `comments_comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `text` text,
  `user_id` int(11) unsigned default NULL,
  `created` int(11) unsigned default NULL,
  `folder_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `comments_comments`
--

/*!40000 ALTER TABLE `comments_comments` DISABLE KEYS */;
INSERT INTO `comments_comments` VALUES (1,NULL,'test',1,1248950392,1);
/*!40000 ALTER TABLE `comments_comments` ENABLE KEYS */;

--
-- Table structure for table `comments_commentsFolder`
--

DROP TABLE IF EXISTS `comments_commentsFolder`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `comments_commentsFolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent_id` int(11) unsigned default NULL,
  `module` char(50) NOT NULL default '',
  `type` char(50) default NULL,
  `by_field` char(50) NOT NULL default '',
  `comments_count` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `parent_id_2` (`parent_id`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `comments_commentsFolder`
--

/*!40000 ALTER TABLE `comments_commentsFolder` DISABLE KEYS */;
INSERT INTO `comments_commentsFolder` VALUES (1,9,'page','page','obj_id',1),(2,1,'page','page','id',0);
/*!40000 ALTER TABLE `comments_commentsFolder` ENABLE KEYS */;

--
-- Table structure for table `comments_comments_tree`
--

DROP TABLE IF EXISTS `comments_comments_tree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `comments_comments_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `foreign_key` int(11) default NULL,
  `parent_id` int(11) default NULL,
  `level` int(11) default NULL,
  `path` text,
  PRIMARY KEY  (`id`),
  KEY `foreign_key` (`foreign_key`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `comments_comments_tree`
--

/*!40000 ALTER TABLE `comments_comments_tree` DISABLE KEYS */;
INSERT INTO `comments_comments_tree` VALUES (1,1,0,1,'1/');
/*!40000 ALTER TABLE `comments_comments_tree` ENABLE KEYS */;

--
-- Table structure for table `fileManager_file`
--

DROP TABLE IF EXISTS `fileManager_file`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fileManager_file` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `realname` varchar(255) default 'имя в фс в каталоге на сервере',
  `name` varchar(255) default 'имя с которым файл будет отдаваться клиенту',
  `ext` varchar(20) default NULL,
  `size` int(11) default NULL,
  `modified` int(11) default NULL,
  `downloads` int(11) default '0',
  `right_header` tinyint(4) default NULL,
  `direct_link` int(11) default '0',
  `about` text,
  `folder_id` int(11) unsigned default NULL,
  `obj_id` int(11) unsigned default NULL,
  `storage_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `realname` (`realname`),
  KEY `folder_id` (`folder_id`,`name`,`ext`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `fileManager_file`
--

/*!40000 ALTER TABLE `fileManager_file` DISABLE KEYS */;
INSERT INTO `fileManager_file` VALUES (1,'4e3086e5c8df049bc271e42eead64437.jpg','june-09-the-perfect-wave-calendar-1280x1024.jpg','jpg',711416,NULL,1,0,0,'',1,NULL,1),(2,'56cf8ac2db85fec5c194c4c4cfef3d92.jpg','june-09-light-bokeh_of_the_abstract-calendar-1280x1024.jpg','jpg',580032,NULL,NULL,0,0,'',1,NULL,1);
/*!40000 ALTER TABLE `fileManager_file` ENABLE KEYS */;

--
-- Table structure for table `fileManager_folder`
--

DROP TABLE IF EXISTS `fileManager_folder`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fileManager_folder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  `filesize` int(11) unsigned default NULL,
  `exts` char(255) default NULL,
  `storage_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `fileManager_folder`
--

/*!40000 ALTER TABLE `fileManager_folder` DISABLE KEYS */;
INSERT INTO `fileManager_folder` VALUES (1,'root','root',NULL,NULL,1),(2,'test','test',0,'',1);
/*!40000 ALTER TABLE `fileManager_folder` ENABLE KEYS */;

--
-- Table structure for table `fileManager_folder_tree`
--

DROP TABLE IF EXISTS `fileManager_folder_tree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fileManager_folder_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `path` text,
  `foreign_key` int(11) default NULL,
  `level` int(11) unsigned default NULL,
  `spath` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `fileManager_folder_tree`
--

/*!40000 ALTER TABLE `fileManager_folder_tree` DISABLE KEYS */;
INSERT INTO `fileManager_folder_tree` VALUES (1,'root/',1,1,'1/'),(2,'root/test/',2,2,'1/2/');
/*!40000 ALTER TABLE `fileManager_folder_tree` ENABLE KEYS */;

--
-- Table structure for table `fileManager_storage`
--

DROP TABLE IF EXISTS `fileManager_storage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fileManager_storage` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `path` char(255) default NULL,
  `web_path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `fileManager_storage`
--

/*!40000 ALTER TABLE `fileManager_storage` DISABLE KEYS */;
INSERT INTO `fileManager_storage` VALUES (1,'local','../files/','/');
/*!40000 ALTER TABLE `fileManager_storage` ENABLE KEYS */;

--
-- Table structure for table `menu_menu`
--

DROP TABLE IF EXISTS `menu_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `menu_menu` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `obj_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `menu_menu`
--

/*!40000 ALTER TABLE `menu_menu` DISABLE KEYS */;
INSERT INTO `menu_menu` VALUES (6,'hmenu',1185);
/*!40000 ALTER TABLE `menu_menu` ENABLE KEYS */;

--
-- Table structure for table `menu_menuItem`
--

DROP TABLE IF EXISTS `menu_menuItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `menu_menuItem` (
  `id` int(11) NOT NULL auto_increment,
  `type_id` int(10) unsigned NOT NULL default '1',
  `menu_id` int(10) unsigned NOT NULL default '0',
  `order` int(10) unsigned NOT NULL default '0',
  `args` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `menu_menuItem`
--

/*!40000 ALTER TABLE `menu_menuItem` DISABLE KEYS */;
INSERT INTO `menu_menuItem` VALUES (1,2,6,1,'a:5:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:6:\"module\";s:4:\"news\";s:6:\"action\";s:0:\"\";s:12:\"activeRoutes\";a:2:{i:0;a:2:{s:5:\"route\";s:10:\"newsFolder\";s:6:\"params\";a:2:{s:4:\"name\";s:1:\"*\";s:6:\"action\";s:4:\"list\";}}i:1;a:2:{s:5:\"route\";s:6:\"withId\";s:6:\"params\";a:3:{s:6:\"module\";s:0:\"\";s:2:\"id\";s:1:\"*\";s:6:\"action\";s:4:\"view\";}}}}'),(2,2,6,2,'a:5:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:6:\"module\";s:4:\"page\";s:6:\"action\";s:0:\"\";s:12:\"activeRoutes\";a:3:{i:0;a:2:{s:5:\"route\";s:11:\"pageActions\";s:6:\"params\";a:2:{s:4:\"name\";s:4:\"main\";s:6:\"action\";s:4:\"view\";}}i:1;a:2:{s:5:\"route\";s:11:\"pageDefault\";s:6:\"params\";a:0:{}}i:2;a:2:{s:5:\"route\";s:7:\"default\";s:6:\"params\";a:0:{}}}}'),(3,2,6,3,'a:5:{s:5:\"route\";s:8:\"default2\";s:6:\"regexp\";s:0:\"\";s:6:\"module\";s:5:\"admin\";s:6:\"action\";s:5:\"admin\";s:12:\"activeRoutes\";a:0:{}}');
/*!40000 ALTER TABLE `menu_menuItem` ENABLE KEYS */;

--
-- Table structure for table `menu_menuItem_lang`
--

DROP TABLE IF EXISTS `menu_menuItem_lang`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `menu_menuItem_lang` (
  `id` int(11) NOT NULL default '0',
  `lang_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `menu_menuItem_lang`
--

/*!40000 ALTER TABLE `menu_menuItem_lang` DISABLE KEYS */;
INSERT INTO `menu_menuItem_lang` VALUES (1,1,'Новости'),(1,2,'News'),(2,1,'О нас'),(2,2,'About us'),(3,1,'ПУ'),(3,2,'AP'),(9,1,'Новости'),(9,2,'News'),(10,1,'Каталог'),(10,2,'Catalogue'),(11,1,'Галерея'),(11,2,'Gallery'),(12,1,'FAQ'),(12,2,'FAQ'),(13,1,'Форум'),(13,2,'Forum'),(14,1,'ПУ'),(14,2,'AP'),(24,1,'О нас'),(24,2,'About us');
/*!40000 ALTER TABLE `menu_menuItem_lang` ENABLE KEYS */;

--
-- Table structure for table `menu_menuItem_tree`
--

DROP TABLE IF EXISTS `menu_menuItem_tree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `menu_menuItem_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `foreign_key` int(11) default NULL,
  `parent_id` int(11) default NULL,
  `level` int(11) default NULL,
  `path` text,
  PRIMARY KEY  (`id`),
  KEY `foreign_key` (`foreign_key`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `menu_menuItem_tree`
--

/*!40000 ALTER TABLE `menu_menuItem_tree` DISABLE KEYS */;
INSERT INTO `menu_menuItem_tree` VALUES (1,1,0,1,'1/'),(2,2,0,1,'2/'),(3,3,0,1,'3/');
/*!40000 ALTER TABLE `menu_menuItem_tree` ENABLE KEYS */;

--
-- Table structure for table `news_news`
--

DROP TABLE IF EXISTS `news_news`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_news` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) default NULL,
  `editor` int(11) NOT NULL default '0',
  `folder_id` int(11) default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=170 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `news_news`
--

/*!40000 ALTER TABLE `news_news` DISABLE KEYS */;
INSERT INTO `news_news` VALUES (169,1457,2,2,1233907447,1243927140);
/*!40000 ALTER TABLE `news_news` ENABLE KEYS */;

--
-- Table structure for table `news_newsFolder`
--

DROP TABLE IF EXISTS `news_newsFolder`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_newsFolder` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  `path` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `news_newsFolder`
--

/*!40000 ALTER TABLE `news_newsFolder` DISABLE KEYS */;
INSERT INTO `news_newsFolder` VALUES (2,'root',1,'root','root'),(18,'main',17,'root/main','main');
/*!40000 ALTER TABLE `news_newsFolder` ENABLE KEYS */;

--
-- Table structure for table `news_newsFolder_lang`
--

DROP TABLE IF EXISTS `news_newsFolder_lang`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_newsFolder_lang` (
  `id` int(11) NOT NULL default '0',
  `lang_id` int(11) NOT NULL default '0',
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `news_newsFolder_lang`
--

/*!40000 ALTER TABLE `news_newsFolder_lang` DISABLE KEYS */;
INSERT INTO `news_newsFolder_lang` VALUES (2,1,'Новости'),(2,2,'News'),(18,1,'Главное'),(18,2,'Main');
/*!40000 ALTER TABLE `news_newsFolder_lang` ENABLE KEYS */;

--
-- Table structure for table `news_newsFolder_tree`
--

DROP TABLE IF EXISTS `news_newsFolder_tree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_newsFolder_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `path` text,
  `foreign_key` int(11) default NULL,
  `level` int(11) unsigned default NULL,
  `spath` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `news_newsFolder_tree`
--

/*!40000 ALTER TABLE `news_newsFolder_tree` DISABLE KEYS */;
INSERT INTO `news_newsFolder_tree` VALUES (1,'root/',2,1,'1/'),(2,'root/main/',18,2,'1/2/');
/*!40000 ALTER TABLE `news_newsFolder_tree` ENABLE KEYS */;

--
-- Table structure for table `news_news_lang`
--

DROP TABLE IF EXISTS `news_news_lang`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news_news_lang` (
  `id` int(11) NOT NULL default '0',
  `lang_id` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `annotation` text,
  `text` text,
  PRIMARY KEY  (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `news_news_lang`
--

/*!40000 ALTER TABLE `news_news_lang` DISABLE KEYS */;
INSERT INTO `news_news_lang` VALUES (169,1,'Россияне назвали свои любимые бренды','Первые три места рейтинга любимых брендов россиян заняли Samsung, Sony и Nokia. На четвертом месте Panasonic, а на пятом - Toyota. Такие результаты дало исследование компании Online Market Intelligence. В двадцатку любимых россиянами брендов вошли Nissan, Reebok и Honda, не попавшие в прошлогодний рейтинг.','Первые три места рейтинга любимых брендов россиян заняли Samsung, Sony и Nokia. Такие результаты дало исследование, проведенное компанией Online Market Intelligence.\n\nТаким образом, в тройке лидеров оказались те же бренды, что и в 2008 году, но Samsung поднялся на первое место со второго, а Sony потеряла одну строчку. На четвертом месте Panasonic, а на пятом - Toyota. В прошлом году пятое место занимал Adidas, опустившийся на шестую строчку.\n\nСильнее всего упали в рейтинге бренды BMW (опустился с седьмого места на девятнадцатое) и Mercedes (с восьмого на восемнадцатое). Между тем, в двадцатку любимых брендов попали Nissan, Reebok и Honda, не вошедшие в рейтинг 2008 года.\n\nПолностью список любимых брендов выглядит следующим образом:\n\n   1. Samsung\n   2. Sony\n   3. Nokia\n   4. Panasonic\n   5. Toyota\n   6. Adidas\n   7. Canon\n   8. Bosch\n   9. Asus\n  10. Philips\n  11. HP\n  12. Sony Ericsson\n  13. Nike\n  14. LG\n  15. Nissan\n  16. Coca-Cola\n  17. Reebok\n  18. Mercedes\n  19. BMW\n  20. Honda \n\nВ основу рейтинга легла доля упомянувших каждый бренд от общего числа респондентов, назвавших хотя бы один бренд. Сообщается также, что полный материал о результатах исследования с комментариями экспертов будет опубликован в еженедельнике \"Компания\". ');
/*!40000 ALTER TABLE `news_news_lang` ENABLE KEYS */;

--
-- Table structure for table `page_page`
--

DROP TABLE IF EXISTS `page_page`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `folder_id` int(11) unsigned default NULL,
  `allow_comment` tinyint(4) default '1',
  `compiled` int(11) default NULL,
  `keywords_reset` tinyint(1) default '0',
  `description_reset` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `page_page`
--

/*!40000 ALTER TABLE `page_page` DISABLE KEYS */;
INSERT INTO `page_page` VALUES (1,9,'main',2,1,0,0,0),(2,10,'404',2,1,NULL,0,0),(4,57,'403',2,1,NULL,0,0);
/*!40000 ALTER TABLE `page_page` ENABLE KEYS */;

--
-- Table structure for table `page_pageFolder`
--

DROP TABLE IF EXISTS `page_pageFolder`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `page_pageFolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `page_pageFolder`
--

/*!40000 ALTER TABLE `page_pageFolder` DISABLE KEYS */;
INSERT INTO `page_pageFolder` VALUES (2,161,'root','/');
/*!40000 ALTER TABLE `page_pageFolder` ENABLE KEYS */;

--
-- Table structure for table `page_pageFolder_tree`
--

DROP TABLE IF EXISTS `page_pageFolder_tree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `page_pageFolder_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `path` text,
  `foreign_key` int(11) default NULL,
  `level` int(11) unsigned default NULL,
  `spath` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `page_pageFolder_tree`
--

/*!40000 ALTER TABLE `page_pageFolder_tree` DISABLE KEYS */;
INSERT INTO `page_pageFolder_tree` VALUES (1,'root/',2,1,'1/');
/*!40000 ALTER TABLE `page_pageFolder_tree` ENABLE KEYS */;

--
-- Table structure for table `page_page_lang`
--

DROP TABLE IF EXISTS `page_page_lang`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `page_page_lang` (
  `id` int(11) NOT NULL default '0',
  `lang_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `page_page_lang`
--

/*!40000 ALTER TABLE `page_page_lang` DISABLE KEYS */;
INSERT INTO `page_page_lang` VALUES (1,1,'Добро пожаловать!','<p>В новой версии нашего фреймворка мы проделали огромную работу, сделав фреймворк ещё стабильнее и гибче.<br /> <br /> Из изменений особо хотелось бы выделить новый ORM, более быстрый и гибкий благодаря плагинам. Вместо старого ACL, mzz обзавёлся теперь двумя политиками обработки прав пользователей: acl_simple (упрощенный) и acl_ext (расширенный). Упрощённый оперирует классами объектов, расширенный - так же как и раньше, конкретными объектами. В большинстве случаев достаточно функций простого ACL, что позволяет избежать лишних запросов к БД и сделать приложение еще быстрее, а управление правами доступа - ещё проще. В качестве javascript-фреймворка теперь используется jQuery (в режиме совместимости).<br /> <br /> В этот релиз были включены переписанные с учетом нововведений самые необходимые из предыдущих модулей: новости, страницы, файловый менеджер, комментарии, меню, captcha. В следующих версиях, параллельно с развитием самого фреймворка, будет добавлен ещё ряд модулей.<br /> <br /> Более подробную информацию о внутреннем устройстве фреймворка можно найти в документации. По всем вопросам, касающимся разработки с использованием mzz, вы можете обращаться в наш <a href=\"http://mzz.ru/forum\">форум</a>, либо <a style=\"color: #006620; background-color: #fff9ab;\" title=\"Linkification: irc://mzz@irc.rusnet.ru\">irc://mzz@irc.rusnet.ru</a>.<br /> <br /> Для авторизации в демо-приложении используйте следующие данные:<br /> Логин: admin<br /> Пароль: test</p>','',''),(1,2,'About us','<strong>mzz</strong> - is a php5 framework for web-applications.',NULL,NULL),(2,1,'404 Not Found','Запрашиваемая страница не найдена!',NULL,NULL),(2,2,'404 Not Found','Page doesn\'t exist',NULL,NULL),(4,1,'Доступ запрещён','Доступ запрещён',NULL,NULL),(4,2,'Access not allowed.','Access not allowed. Try to login or register.',NULL,NULL);
/*!40000 ALTER TABLE `page_page_lang` ENABLE KEYS */;

--
-- Table structure for table `sys_config`
--

DROP TABLE IF EXISTS `sys_config`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_config` (
  `id` int(11) NOT NULL auto_increment,
  `module_name` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `type_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL default '',
  `args` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `module_name` (`module_name`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_config`
--

/*!40000 ALTER TABLE `sys_config` DISABLE KEYS */;
INSERT INTO `sys_config` VALUES (3,'news','items_per_page','Количество элементов на страницу',1,'20',''),(4,'fileManager','public_path','Путь до паблик папки',2,'','');
/*!40000 ALTER TABLE `sys_config` ENABLE KEYS */;

--
-- Table structure for table `sys_lang`
--

DROP TABLE IF EXISTS `sys_lang`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_lang` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(20) default NULL,
  `title` char(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_lang`
--

/*!40000 ALTER TABLE `sys_lang` DISABLE KEYS */;
INSERT INTO `sys_lang` VALUES (1,'ru','ру'),(2,'en','en');
/*!40000 ALTER TABLE `sys_lang` ENABLE KEYS */;

--
-- Table structure for table `sys_lang_lang`
--

DROP TABLE IF EXISTS `sys_lang_lang`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_lang_lang` (
  `id` int(11) unsigned NOT NULL,
  `lang_id` int(11) unsigned NOT NULL,
  `name` char(32) default NULL,
  PRIMARY KEY  (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_lang_lang`
--

/*!40000 ALTER TABLE `sys_lang_lang` DISABLE KEYS */;
INSERT INTO `sys_lang_lang` VALUES (1,1,'русский'),(1,2,'russian'),(2,1,'английский'),(2,2,'english');
/*!40000 ALTER TABLE `sys_lang_lang` ENABLE KEYS */;

--
-- Table structure for table `sys_obj_id`
--

DROP TABLE IF EXISTS `sys_obj_id`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_obj_id` (
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1462 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_obj_id`
--

/*!40000 ALTER TABLE `sys_obj_id` DISABLE KEYS */;
INSERT INTO `sys_obj_id` VALUES (1443),(1444),(1445),(1446),(1447),(1448),(1449),(1450),(1451),(1452),(1453),(1454),(1455),(1456),(1457),(1458),(1459),(1460),(1461);
/*!40000 ALTER TABLE `sys_obj_id` ENABLE KEYS */;

--
-- Table structure for table `sys_obj_id_named`
--

DROP TABLE IF EXISTS `sys_obj_id_named`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_obj_id_named` (
  `obj_id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`obj_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1461 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_obj_id_named`
--

/*!40000 ALTER TABLE `sys_obj_id_named` DISABLE KEYS */;
INSERT INTO `sys_obj_id_named` VALUES (1443,'access_admin'),(1444,'access_access'),(1445,'access_captcha'),(1446,'access_comments'),(1447,'access_config'),(1448,'access_menu'),(1449,'access_news'),(1450,'access_page'),(1451,'access_pager'),(1452,'access_simple'),(1453,'access_user'),(1454,'userFolder'),(1455,'groupFolder'),(1460,'access_fileManager');
/*!40000 ALTER TABLE `sys_obj_id_named` ENABLE KEYS */;

--
-- Table structure for table `sys_sessions`
--

DROP TABLE IF EXISTS `sys_sessions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_sessions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sid` varchar(50) NOT NULL default '',
  `ts` int(11) unsigned NOT NULL default '0',
  `valid` enum('yes','no') NOT NULL default 'yes',
  `data` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sid` (`sid`),
  KEY `valid` (`valid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_sessions`
--

/*!40000 ALTER TABLE `sys_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_sessions` ENABLE KEYS */;

--
-- Table structure for table `sys_skins`
--

DROP TABLE IF EXISTS `sys_skins`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sys_skins` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(32) default NULL,
  `title` char(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sys_skins`
--

/*!40000 ALTER TABLE `sys_skins` DISABLE KEYS */;
INSERT INTO `sys_skins` VALUES (1,'default','default'),(2,'light','light');
/*!40000 ALTER TABLE `sys_skins` ENABLE KEYS */;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `is_default` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_group`
--

/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'unauth',NULL),(2,'auth',1),(3,'root',0),(4,'moderators',0);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `module` varchar(32) NOT NULL default '',
  `role` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_module_role` (`group_id`,`module`,`role`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_roles`
--

/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,4,'page','moderator'),(2,2,'page','user'),(3,1,'page','user'),(4,3,'page','moderator'),(5,3,'page','user'),(6,4,'page','user'),(7,4,'news','moderator'),(8,4,'news','user'),(9,3,'news','moderator'),(10,3,'news','user'),(11,1,'news','user'),(12,2,'news','user');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;

--
-- Table structure for table `user_user`
--

DROP TABLE IF EXISTS `user_user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `created` int(11) default NULL,
  `confirmed` varchar(32) default NULL,
  `last_login` int(11) default NULL,
  `language_id` int(11) default NULL,
  `timezone` int(11) default '3',
  `skin` int(11) unsigned default '1',
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_user`
--

/*!40000 ALTER TABLE `user_user` DISABLE KEYS */;
INSERT INTO `user_user` VALUES (1,'guest','','',NULL,NULL,1225005849,NULL,3,1),(2,'admin','','098f6bcd4621d373cade4e832627b4f6',NULL,NULL,1253665584,1,3,1),(3,'moderator','','098f6bcd4621d373cade4e832627b4f6',1188187851,NULL,1203767664,1,3,1),(4,'user','','098f6bcd4621d373cade4e832627b4f6',1243925700,NULL,NULL,NULL,3,1),(5,'qwe','','202cb962ac59075b964b07152d234b70',1249521132,NULL,NULL,1,3,1);
/*!40000 ALTER TABLE `user_user` ENABLE KEYS */;

--
-- Table structure for table `user_userAuth`
--

DROP TABLE IF EXISTS `user_userAuth`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_userAuth` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned default NULL,
  `ip` char(15) default NULL,
  `hash` char(32) default NULL,
  `obj_id` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_userAuth`
--

/*!40000 ALTER TABLE `user_userAuth` DISABLE KEYS */;
INSERT INTO `user_userAuth` VALUES (120,2,'10.30.35.150','0e92bb89eee69e7b2d0fabf722f6dd6b',NULL,NULL),(121,2,'127.0.0.1','e6554e265eb42296f32e6ebb6ae555af',NULL,NULL),(122,2,'127.0.0.1','41c1f3d65189710fd9a0326716b7d643',NULL,NULL),(123,2,'127.0.0.1','e87b231c137decdd917559c2d8121d4b',NULL,NULL),(124,2,'127.0.0.1','508472f0463a79bc906538de5f39dfb6',NULL,NULL),(125,2,'127.0.0.1','0e8f35e187247098b098204613bd9b27',NULL,NULL),(126,2,'127.0.0.1','956eb3fa26b9b78b82c96d9f098d8a06',NULL,NULL),(128,2,'10.30.35.9','639eb7566aaf6b368863cfb4ba8afd1e',NULL,NULL),(132,2,'10.30.35.150','c54fbf06a0f11f5a10f4822e493a82bd',NULL,NULL),(133,2,'127.0.0.1','021d2bab67d5c4d478dd39d7cfaca0b2',NULL,NULL),(134,2,'127.0.0.1','254be4b2e6328875e8dfe2291eead872',NULL,NULL),(135,2,'127.0.0.1','f028a4c7dd2cfce774e71b1d86cba0a4',NULL,NULL),(136,5,'10.30.35.150','b77e872c8cdbe566085756413d0beef1',NULL,NULL),(137,2,'127.0.0.1','ba3c6bca2a06f107dfaeb0d72d3ea278',NULL,1253230671),(138,2,'10.30.35.150','ddd95c8bd1a5a07451a8fb7d3340e9f1',NULL,1254702538);
/*!40000 ALTER TABLE `user_userAuth` ENABLE KEYS */;

--
-- Table structure for table `user_userGroup_rel`
--

DROP TABLE IF EXISTS `user_userGroup_rel`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_userGroup_rel` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_userGroup_rel`
--

/*!40000 ALTER TABLE `user_userGroup_rel` DISABLE KEYS */;
INSERT INTO `user_userGroup_rel` VALUES (1,1,1),(23,2,2),(24,3,2),(30,2,3),(31,2,4),(32,4,3),(33,2,5);
/*!40000 ALTER TABLE `user_userGroup_rel` ENABLE KEYS */;

--
-- Table structure for table `user_userOnline`
--

DROP TABLE IF EXISTS `user_userOnline`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_userOnline` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `session` char(32) default NULL,
  `last_activity` int(11) default NULL,
  `url` char(255) default NULL,
  `ip` char(15) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`,`session`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM AUTO_INCREMENT=330 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_userOnline`
--

/*!40000 ALTER TABLE `user_userOnline` DISABLE KEYS */;
INSERT INTO `user_userOnline` VALUES (329,2,'e068f18f7ca743008ebe3fea63ced400',1233982270,'http://mzz/ru/admin/devToolbar','127.0.0.1');
/*!40000 ALTER TABLE `user_userOnline` ENABLE KEYS */;

--
-- Dumping routines for database 'mzz'
--
DELIMITER ;;
DELIMITER ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-10-05  1:22:48
