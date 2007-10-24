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

INSERT INTO `catalogue_catalogue` VALUES (6,8,'Delphi: программирование на языке высокого уровня',2,1175235587,489,12);
INSERT INTO `catalogue_catalogue` VALUES (7,8,'Учебник английского языка для технических университетов и вузов',2,1175237052,490,12);
INSERT INTO `catalogue_catalogue` VALUES (8,7,'Nokia 6300',2,1175871646,501,5);
INSERT INTO `catalogue_catalogue` VALUES (9,7,'Nokia E65',2,1175871677,502,5);
INSERT INTO `catalogue_catalogue` VALUES (10,7,'Motorola KRZR K1',2,1175871755,503,5);
INSERT INTO `catalogue_catalogue` VALUES (11,8,'Линия грёз',2,1179562302,562,11);
INSERT INTO `catalogue_catalogue` VALUES (12,9,'Стаканчик-непроливайка, 2 шт',2,1179565776,563,1);
INSERT INTO `catalogue_catalogue` VALUES (13,9,'Набор штампиков \"Пираты Карибского моря\"',2,1179565863,564,1);
INSERT INTO `catalogue_catalogue` VALUES (14,8,'PHP5 для профессионалов',2,1179566368,565,1);
INSERT INTO `catalogue_catalogue` VALUES (15,9,'Бархатная раскраска \"Котята\"',2,1179566669,566,1);
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

INSERT INTO `catalogue_catalogue_data` VALUES (6,27,'Книга посвящена новейшей версии Delphi  7 Studio. Здесь изложены как приёмы программирования в среде Delphi, её главные составные части - галереи компонентов, хранилища объектов, вспомогательный инструментарий, так и сам язык программирования Delphi',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (6,24,NULL,'В.В. Фаронов',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (6,25,NULL,NULL,640,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (6,26,NULL,'Издетельский дом \"Питер\"',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,24,NULL,'И.В. Орловская, Л.С. Самсонова, А.И. Скубриева',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,25,NULL,NULL,448,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,26,NULL,'Издательство МГТУ им. Н.Э. Баумана',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (7,27,'Учебник состоит из 12 уроков-тем, объединенных единой тематикой и содержащих: основной текст, назначением которого является обучение чтению технической литературы по специальностям машинно- и приборостроительных вузов; дополнительные текста и диалоги для общественной лексики, развития навыков профессионального обучения по изучаемой тематике; письменные и устные грамматические и лексические упражнения коммуникативной направленности.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (8,28,NULL,'GSM 900/1800/1900',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (8,29,NULL,'91 г.',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (8,30,NULL,'106.4 x 43.6 x 11.7',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (9,28,NULL,'GSM 850/900/1800/1900',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (9,29,NULL,'115 г.',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (9,30,NULL,'105 x 49 x 15.5',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (10,28,NULL,'GSM 850/900/1800/1900',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (10,29,NULL,'',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (10,30,NULL,'103 x 42 x 16',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,24,NULL,'С. Лукьяненко',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,25,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,26,NULL,'',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (11,27,'От создателя первого российского блок-бастера \"Ночной дозор\"! Отчаянный наемный телохранитель Кей Альтос беспощаден к себе и к миру, в котором вынужден жить. Его родина уничтожена, его домом стал Космос, его работой сделалась смерть.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (12,49,NULL,NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (12,50,NULL,NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (12,51,'Эти стаканчики-непроливайки - настоящая находка для родителей и очень удобная вещь для детей! Теперь ребенок может не бояться пролить воду с краской из стакана на любимую мамину скатерть и можно полностью отдаться творческому процессу.',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (13,49,NULL,NULL,2,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (13,50,NULL,NULL,1178543636,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (13,51,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,24,NULL,'Эд Леки-Томпсон, Хьяо Айде-Гудман, Алек Коув, Стивен Д. Новицки',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,25,NULL,NULL,604,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,26,NULL,'\"Диалектика\"',NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (14,27,'В данном практическом руководстве продемонстрирована вся мощь и гибкость языка PHP и даны полезные советы программистам. В этой книге показано, как построить масштабируемую и высокопроизводительную инфраструктуру на языке PHP5...',NULL,NULL,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (15,49,NULL,NULL,0,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (15,50,NULL,NULL,1181014750,NULL);
INSERT INTO `catalogue_catalogue_data` VALUES (15,51,'Бархатная раскраска выгодно отличается от обычных раскрасок. Ее бархатная поверхность вокруг раскрашиваемых участков рисунка, помогает ребенку аккуратно и красиво раскрасить, а блестящие гелевые краски, создают неповторимый мерцающий эффект. Рисунок раскрашенный своими руками, станет уникальным украшением для детской комнаты.',NULL,NULL,NULL);
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

INSERT INTO `catalogue_catalogue_properties` VALUES (10,'author','Автор',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (11,'pagescount','Количество страниц',3,NULL);
INSERT INTO `catalogue_catalogue_properties` VALUES (12,'izdat','Издатель',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (13,'annotation','Аннотация',4,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (14,'standart','Стандарт',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (15,'weight','Вес',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (16,'size','Размеры',1,'');
INSERT INTO `catalogue_catalogue_properties` VALUES (24,'madein','Страна изготовитель',5,'a:3:{i:0;s:0:\"\";i:1;s:5:\"Китай\";i:2;s:6:\"Россия\";}');
INSERT INTO `catalogue_catalogue_properties` VALUES (25,'storedata','Дата поступления на склад',6,'%H:%M:%S %d/%B/%Y');
INSERT INTO `catalogue_catalogue_properties` VALUES (26,'about','Описание',4,NULL);
INSERT INTO `catalogue_catalogue_properties` VALUES (31,'test1','Динамический селект',7,'a:7:{s:7:\"section\";s:4:\"user\";s:6:\"module\";s:4:\"user\";s:2:\"do\";s:4:\"user\";s:12:\"searchMethod\";s:9:\"searchAll\";s:13:\"extractMethod\";s:8:\"getLogin\";s:4:\"args\";N;s:8:\"optional\";b:1;}');
INSERT INTO `catalogue_catalogue_properties` VALUES (32,'img','Изображение',8,'a:2:{s:7:\"section\";s:11:\"fileManager\";s:8:\"folderId\";i:1;}');

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

INSERT INTO `catalogue_catalogue_properties_types` VALUES (1,'char','строка');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (2,'float','число с плавающей точкой');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (3,'int','целое число');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (4,'text','текст');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (5,'select','обычный список');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (6,'datetime','дата и время');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (7,'dynamicselect','динамический список');
INSERT INTO `catalogue_catalogue_properties_types` VALUES (8,'img','изображение');

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

INSERT INTO `catalogue_catalogue_types` VALUES (7,'mobile','Мобильный телефон');
INSERT INTO `catalogue_catalogue_types` VALUES (8,'books','Книги');
INSERT INTO `catalogue_catalogue_types` VALUES (9,'childrens','Детский мир');
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

INSERT INTO `catalogue_cataloguefolder` VALUES (1,241,'root','Основной',0,1,'root');
INSERT INTO `catalogue_cataloguefolder` VALUES (5,481,'mobile','Телефоны',7,5,'root/mobile');
INSERT INTO `catalogue_cataloguefolder` VALUES (10,486,'books','Книги',0,10,'root/books');
INSERT INTO `catalogue_cataloguefolder` VALUES (11,487,'fantazy','Фантастика',0,11,'root/books/fantazy');
INSERT INTO `catalogue_cataloguefolder` VALUES (12,488,'tech','Техническая литература',11,12,'root/books/tech');

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

INSERT INTO `faq_faq` VALUES (1,'Надо ли мне верить в розового жирафика, чтобы пользоваться mzz?','Желательно, но вовсе необязательно',1,872);
INSERT INTO `faq_faq` VALUES (2,'Вопрос','ответ',1,878);

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

INSERT INTO `faq_faqcategory` VALUES (1,'demo','Демо',870);

#
# Table structure for table filemanager_file
#

CREATE TABLE `filemanager_file` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `realname` varchar(255) default 'имя в фс в каталоге на сервере',
  `name` varchar(255) default 'имя с которым файл будет отдаваться клиенту',
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

INSERT INTO `filemanager_file` VALUES (1,'161577520fa51c296ac29682a28ab915','1.jpg','jpg',41037,1189865423,28,1,'По фамилии Fernandes',5,611);
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
INSERT INTO `filemanager_folder` VALUES (5,'gallery','Галерея',5,'root/gallery',533,0,'jpg');
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
INSERT INTO `forum_category` VALUES (2,'новая категория2',100,935);

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

INSERT INTO `forum_forum` VALUES (1,'Новый форум',1,100,881,2,7,59,'Описание');
INSERT INTO `forum_forum` VALUES (2,'lol2? :)',1,10,936,9,50,83,NULL);
INSERT INTO `forum_forum` VALUES (3,'ещё один тупой форум',2,0,937,1,1,58,NULL);

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

INSERT INTO `forum_post` VALUES (1,'Пост 1',2,10,NULL,1,886);
INSERT INTO `forum_post` VALUES (2,'Пост 2',2,231654,NULL,1,887);
INSERT INTO `forum_post` VALUES (3,'adfwqer',2,1187931976,NULL,4,896);
INSERT INTO `forum_post` VALUES (4,'sd',2,1187932074,NULL,5,900);
INSERT INTO `forum_post` VALUES (5,'tyr',2,1187932122,NULL,6,904);
INSERT INTO `forum_post` VALUES (6,'типа пост ;)',2,1187932173,NULL,7,908);
INSERT INTO `forum_post` VALUES (7,'хехе',2,1188183439,NULL,7,911);
INSERT INTO `forum_post` VALUES (8,'фывафыва',2,1188183538,NULL,7,912);
INSERT INTO `forum_post` VALUES (9,'апорапоапо',2,1188183541,NULL,7,913);
INSERT INTO `forum_post` VALUES (10,'аправрва',2,1188183547,NULL,7,914);
INSERT INTO `forum_post` VALUES (11,'апоровыапывпывп',2,1188183565,1188184207,7,915);
INSERT INTO `forum_post` VALUES (12,'апороsdfgfsdgф11123',2,1188184047,1188184202,7,916);
INSERT INTO `forum_post` VALUES (13,'fhdfh',2,1188184816,NULL,1,918);
INSERT INTO `forum_post` VALUES (14,'гы, сына, лол',2,1188184821,1188184843,1,919);
INSERT INTO `forum_post` VALUES (15,'ывапывп',2,1188185186,NULL,1,920);
INSERT INTO `forum_post` VALUES (16,'апоапоапо',2,1188185191,NULL,1,921);
INSERT INTO `forum_post` VALUES (17,'р',2,1188185213,NULL,8,924);
INSERT INTO `forum_post` VALUES (18,'ббб',2,1188185309,NULL,9,928);
INSERT INTO `forum_post` VALUES (19,'олрплпрл',2,1188185316,NULL,9,931);
INSERT INTO `forum_post` VALUES (20,'апопаоапо',2,1188185344,NULL,8,932);
INSERT INTO `forum_post` VALUES (21,'выапывапывп',2,1188185811,NULL,1,933);
INSERT INTO `forum_post` VALUES (22,'выапывапывп',2,1188185812,NULL,1,934);
INSERT INTO `forum_post` VALUES (23,'тупой пост в тупом треде',2,1188188069,NULL,10,939);
INSERT INTO `forum_post` VALUES (24,'wqerqwr',2,1188258626,1188273213,11,943);
INSERT INTO `forum_post` VALUES (25,'wqer',2,1188258638,NULL,11,946);
INSERT INTO `forum_post` VALUES (26,'et',2,1188258769,NULL,13,951);
INSERT INTO `forum_post` VALUES (27,'rqwerqwer',2,1188258878,NULL,14,956);
INSERT INTO `forum_post` VALUES (28,'афигеть',2,1188259934,NULL,15,962);
INSERT INTO `forum_post` VALUES (29,'ввыапыва',2,1188260003,NULL,16,966);
INSERT INTO `forum_post` VALUES (30,'аврукенк',2,1188260016,NULL,11,969);
INSERT INTO `forum_post` VALUES (31,'пррррррррррррр',2,1188260032,1188270981,11,970);
INSERT INTO `forum_post` VALUES (32,'пппппппппппп213',2,1188260041,1188271043,11,971);
INSERT INTO `forum_post` VALUES (33,'fuck2',2,1188260115,1188269047,11,972);
INSERT INTO `forum_post` VALUES (34,'фывфыв',2,1188261500,NULL,17,974);
INSERT INTO `forum_post` VALUES (35,'ывфафыва',2,1188261508,NULL,18,978);
INSERT INTO `forum_post` VALUES (36,'sadfasdfasd',2,1188263244,NULL,11,981);
INSERT INTO `forum_post` VALUES (37,'sadfwe',2,1188267686,NULL,1,983);
INSERT INTO `forum_post` VALUES (38,'wrtwert',2,1188267690,NULL,1,984);
INSERT INTO `forum_post` VALUES (39,'asd',2,1188267692,1188267896,1,985);
INSERT INTO `forum_post` VALUES (40,'dsgertwet111111111111111',3,1188267913,1188267942,15,986);
INSERT INTO `forum_post` VALUES (41,'342341sgrt',3,1188267928,1188267938,15,987);
INSERT INTO `forum_post` VALUES (42,'фывафывф',2,1188271348,NULL,19,989);
INSERT INTO `forum_post` VALUES (43,'фывафывф',2,1188271367,NULL,20,993);
INSERT INTO `forum_post` VALUES (44,'pots11dsfgsdg',2,1188271395,1188272058,21,997);
INSERT INTO `forum_post` VALUES (45,'ewqrqwrqwr',2,1188271613,NULL,21,1002);
INSERT INTO `forum_post` VALUES (46,'подрочил, спасибо',3,1188272475,NULL,11,1003);
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
INSERT INTO `forum_post` VALUES (74,'jhgjhg добавлено sadf добавлено dsfgdsg добавлено dh',2,1189549156,1189549990,18,1100);
INSERT INTO `forum_post` VALUES (75,'asd\r\nдобавлено\r\nwerwqer\r\n\r\nдобавлено\r\n\r\ndsfgdsg\r\n\r\nдобавлено\r\n\r\nsgfsdgsdgsdfgdsfgdsfgdsfg',2,1189550150,1189550150,18,1104);
INSERT INTO `forum_post` VALUES (76,'eqrqewr',2,1189555660,NULL,24,1117);
INSERT INTO `forum_post` VALUES (77,'werwq',3,1189555862,NULL,18,1126);
INSERT INTO `forum_post` VALUES (78,'sdfgsdfg11',2,1189558203,1189569116,18,1130);
INSERT INTO `forum_post` VALUES (79,'sadfsdf\r\n\r\nдобавлено\r\n\r\nq',2,1189569139,1189569139,18,1134);
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

INSERT INTO `forum_thread` VALUES (1,'новый тред',7,15,2,1,885,39,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (4,'sadfsadf',1,1187931976,2,1,895,11,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (5,'q',1,1187932074,2,1,899,11,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (6,'fdhd',0,1187932122,2,1,903,11,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (7,'стас кобан',0,1187932173,2,1,907,12,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (8,'уцкецуе',1,1188185213,2,1,923,20,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (9,'ааа',1,1188185309,2,1,927,19,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (10,'тред в тупом форуме',0,1188188069,2,3,938,23,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (11,'asf2',16,1188258626,2,2,942,55,0,24,2);
INSERT INTO `forum_thread` VALUES (13,'ewrt',0,1188258769,2,2,950,26,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (14,'qwerqwe',0,1188258878,2,2,954,27,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (15,'хыхы',2,1188259934,2,1,960,41,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (16,'ывп',0,1188260003,2,2,965,29,NULL,NULL,NULL);
INSERT INTO `forum_thread` VALUES (17,'ещё тема',1,1188261500,2,2,973,82,NULL,NULL,1);
INSERT INTO `forum_thread` VALUES (18,'и ещё тема',22,1188261508,2,2,977,80,NULL,76,1006);
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

INSERT INTO `menu_menu` VALUES (5,'demo','Демо-меню',660);

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

INSERT INTO `menu_menuitem` VALUES (1,0,2,5,'Новости',1,661);
INSERT INTO `menu_menuitem` VALUES (2,0,2,5,'Страницы',2,662);
INSERT INTO `menu_menuitem` VALUES (3,0,2,5,'Каталог',3,663);
INSERT INTO `menu_menuitem` VALUES (4,0,2,5,'Галерея',4,664);
INSERT INTO `menu_menuitem` VALUES (5,0,2,5,'Пользователи',5,665);
INSERT INTO `menu_menuitem` VALUES (6,0,2,5,'Панель управления',7,666);
INSERT INTO `menu_menuitem` VALUES (7,0,2,5,'Сообщения',8,815);
INSERT INTO `menu_menuitem` VALUES (8,0,2,5,'Форум',9,888);

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

INSERT INTO `menu_menuitem_properties` VALUES (1,'url','Ссылка',1,NULL);
INSERT INTO `menu_menuitem_properties` VALUES (2,'url','Ссылка',1,NULL);
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

INSERT INTO `menu_menuitem_properties_types` VALUES (1,'char','Строка');

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

INSERT INTO `menu_menuitem_types` VALUES (1,'simple','Простой');
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

INSERT INTO `message_message` VALUES (1,'Превед','Превед медвед',1,2,1184625784,1,1,812);

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

INSERT INTO `message_messagecategory` VALUES (1,'Входящие','incoming',809);
INSERT INTO `message_messagecategory` VALUES (2,'Исходящие','sent',810);
INSERT INTO `message_messagecategory` VALUES (3,'Корзина','recycle',811);

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

INSERT INTO `news_news` VALUES (9,309,'Приостановлена деятельность НБП',2,'Прокуратура Москвы приостановила деятельность НБП вплоть до решения суда, который должен вынести окончательное решение по этому вопросу и признать или не признать НБП экстремистской организацией. НБП запрещается организовывать и проводить собрания, митинги, демонстрации и иные массовые акции или публичные мероприятия.','Прокуратура Москвы в четверг, 22 марта, приостановила деятельность НБП вплоть до решения суда, который должен вынести окончательное решение по этому вопросу и признать или не признать НБП экстремистской организацией, сообщается на сайте Генпрокуратуры. Как отмечается в постановлении прокуратуры, в соответствии с требованиями ч. 3 ст. 10 Федерального закона \"О противодействии экстремистской деятельности\" приостанавливаются все права НБП, а также региональных и других структурных подразделений этой организации. НБП, в частности, запрещается организовывать и проводить собрания, митинги, демонстрации, шествия, пикетирование и иные массовые акции или публичные мероприятия, а также использовать банковские вклады, за исключением проведения расчетов, связанных с их хозяйственной деятельностью. Несмотря на то, что НБП 29 июня 2005 года была ликвидирована и исключена из Единого государственного реестра юридических лиц, организация продолжила свою деятельность. В марте 2007 года прокуратуры Санкт-Петербурга, Челябинской области и Одинцовского района Московской области вынесли НБП предупреждения о недопустимости экстремистских действий. Неоднократные предупреждения, как отмечается в постановлении прокуратуры, являются достаточным основанием для признания НБП экстремистской организацией и запрета её деятельности. Лидер нацболов Эдуард Лимонов сообщил корреспонденту \"Ленты.ру\", что представление прокуратуры о запрете НБП будет рассмотрено в Мосгорсуде 29 марта 2007 года. Самому Лимонову представителем прокуратуры была вручена повестка в суд. Он оказался единственным фигурантом этого дела, так как прокуратура заявляет, что \"личности других лидеров установить не удалось\". Лидер НБП отметил, что действия прокуратуры являются первой попыткой применить новый закон об экстремизме, что, по его мнению, является сигналом о скором начале \"массовых репрессий в отношении оппозиции\".',29,1174588081,1174588081);
INSERT INTO `news_news` VALUES (10,310,'Задержаны трое подозреваемых в причастности к терактам в лондонском метро',2,'В ходе полицейской спецоперации 22 марта в Великобритании арестованы три человека, подозреваемых в причастности к планированию и осуществлению терактов в лондонском метро. Двое были схвачены перед посадкой в направляющийся в Пакистан самолет, за третьим полицейские пришли в его дом в городе Лидс.','В ходе полицейской спецоперации 22 марта в Великобритании арестованы три человека, подозреваемых в причастности к планированию и осуществлению терактов в лондонском метро 7 июля 2005 года, сообщает Sky News. Двое (23 и 30 лет) были схвачены перед посадкой в направляющийся в Пакистан самолет, за третьим (26 лет) полицейские пришли в его дом в городе Лидс. В рамках этой же операции были проведены обыски в пяти домах в Лидсе. Все подозреваемые доставлены в центральное полицейское управление Лондона, их уже допрашивают следователи. По словам стражей порядка, целью их работы является выявление лиц, не только причастных к совершению этих терактов, но и тех людей, кто знал об их подготовке, сочувствовал исполнителям и призывал террористов к совершению преступлений. Расследование, отмечают в полиции, отнюдь не закончилось и будет продолжаться и далее. Напомним, что 7 июля 2005 года террористы-смертники пытались привести в действие спрятанные в рюкзаках бомбы, однако из-за недостатков конструкции взрывные устройства не сработали, что сохранило жизни многим людям.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (11,311,'Иран отрабатывает блокаду Персидского залива',2,'Военно-морские силы Ирана проводят маневры в Персидском заливе. В маневрах, начавшихся 21 марта, участвуют корветы, ракетные катера и подводные лодки. Целью учений является отработка действий по блокированию Ормузского пролива - \"торговых ворот\" ближневосточного региона.','Военно-морские силы Ирана проводят крупномасштабные учения в Персидском заливе, сообщает MIGnews. В маневрах принимают участие ракетные корветы, катера и подводные лодки. По сообщениям СМИ, иранский флот отрабатывает на учениях блокаду Ормузского пролива - \"торговых ворот\" ближневосточного региона. Ормузский пролив соединяет Персидский залив с Индийским океаном. Через него обеспечивается до 25 процентов мировых поставок нефти. Учения, начавшиеся в среду, 21 марта, продлятся до 30 марта 2007 года. По мнению экспертов, цель учений - демонстрация силы в условиях предполагаемой военной операции США. Следует отметить, что США официально опровергают все сообщения о подготовке военной операции против Ирана. Военно-морские силы Ирана насчитывают пять патрульных корветов водоизмещением менее 1500 тонн и 23 ракетных катера. Наиболее боеспособной частью ВМС являются подводные силы, располагающие тремя подлодками проекта 877ЭКМ российской постройки, по своим ТТХ сравнимыми с израильскими подводными лодками типа Dolphin.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (12,312,'Половина авиации РВСН не летает',2,'Значительная часть авиатехники и все аэродромы ракетных войск стратегического назначения нуждаются в капитальном ремонте. Из-за недостаточного финансирования РВСН могут поддерживать в исправности только 51 процент самолетов и вертолетов. Средний годовой налет на экипаж составляет 40-55 часов.','Значительная часть авиатехники и все аэропорты ракетных войск стратегического назначения нуждаются в капитальном ремонте, сообщает РИА Новости. \"Из-за недостаточного выделения ассигнований и отсутствия финансирования по другим статьям сметы Министерства обороны, материально-техническое обеспечение авиации РВСН позволяет поддерживать в частях постоянной готовности в исправном состоянии не более 51 процента авиационной техники\", - сообщил журналистам представитель Службы информации и общественных связей Ракетных войск. Для обеспечения повседневной деятельности и охраны ракетных баз РВСН располагают группировкой транспортных самолетов Ан-12, Ан-24, Ан-26, Ан-72 и многоцелевых вертолетов Ми-8. Средний налет по итогам 2006 года составил 55 часов на самолетах и 40 часов на вертолетах.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (13,313,'\"Бората\" и \"Симпсонов\" разместят в Сети для бесплатного просмотра',2,'Компании News Corp. и NBC Universal объявили о планах по созданию собственного онлайн-видеосервиса. По мнению создателей пока не названного сервиса, их детище сможет составить серьезную конкуренцию видеоресурсам Google и принадлежащего последней YouTube. По имеющимся данным, доступ к размещенному на новом сайте контенту будет бесплатным.','Компании News Corp. и NBC Universal объявили о планах по созданию собственного онлайн-видеосервиса. По мнению создателей пока не названного сервиса, их детище сможет составить серьезную конкуренцию видеоресурсам Google и принадлежащего последней YouTube, сообщает Reuters. На страницах разрабатываемого сервиса будут размещаться не короткие ролики (длиной до 10 минут), как на YouTube, а целые телевизионные шоу и даже кинофильмы большой продолжительности. Так, разработчики пообещали выложить в Сети серии \"Симпсонов\", а также блокбастеры \"Дьявол носит Prada\" и \"Борат\". По имеющимся данным, доступ к размещенному на новом сайте контенту будет бесплатным. Прибыль NBC и News Corp. будут получать за счет размещения рекламы. Причем ролики будут размещены не только на страницах сервиса, но и на сайтах Yahoo! и MySpace. Запуск потенциального конкурента YouTube намечен на лето 2007 года.',30,1174588081,1174588081);
INSERT INTO `news_news` VALUES (14,314,'Суд запретил обсуждать реабилитацию Бритни Спирс',2,'По просьбе юристов Бритни Спирс Верховный суд Лондона выпустил постановление, запрещающее дальнейшее распространение информации, касающейся пребывания певицы в реабилитационной клинике Promises. Представитель Спирс сообщил, что она планирует опротестовать ранее опубликованную информацию.','По просьбе юристов Бритни Спирс Верховный суд Лондона выпустил постановление, запрещающее дальнейшее распространение информации, касающейся пребывания певицы в реабилитационной клинике Promises, сообщает Sky News. \"Мисс Спирс планирует опротестовать ложные заявления, которые уже попали в печать\" - заявил представитель исполнительницы. Также юристы обратились к суду с просьбой потребовать от некоторых британских средств массовой информации раскрытия их источников, \"чтобы идентифицировать Джона Доу\". Джоном Доу (John Doe) в юридической практике называют человека, чья личность не установлена. Поскольку точной информации об источниках сведений о Спирс нет, распространять дальнейшие слухи запретили именно Джону Доу. Напомним, что 25-летняя певица выписалась из реабилитационного центра Promises в Калифорнии 21 марта 2007 года. В клинику Спирс поступила 22 февраля, после серии странных поступков: например, она побрилась наголо и сделала новую татуировку в виде губ на запястье. Также в прессе появлялась информация о том, что Спирс, находясь в клинике, пыталась покончить жизнь самоубийством, а также составила список лиц, которым она желает смерти. Этот перечень включал и имя ее бывшего мужа, рэппера Кевина Федерлайна, после развода с которым в ноябре 2006 года в поведении Спирс и начали наблюдаться странности.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (15,315,'Арестован проректор Санкт-Петербургского университета',2,'В Санкт-Петербурге арестован проректор по развитию материально-технической базы местного госуниверситета Лев Огнев. Замена меры пресечения с подписки о невыезде на арест была произведена накануне, но стало известно об этом только в 22 марта. Сейчас проректор находится в следственном изоляторе \"Кресты\".','В Санкт-Петербурге арестован проректор по развитию материально-технической базы местного госуниверситета Лев Огнев, который ранее находился под подпиской о невыезде, сообщает \"Росбалт\" со ссылкой на источник в правоохранительных органах. Замена меры пресечения с подписки о невыезде на содержание под стражей была произведена накануне, но стало известно об этом только 22 марта. Сейчас проректор находится в следственном изоляторе \"Кресты\". О сроках окончания следствия по его делу ничего не известно. Правоохранительные органы 5 октября 2006 года возбудили уголовное дело в отношении ряда сотрудников СПбГУ по части 4 ст. 160 УК РФ (присвоение или растрата, совершенное группой лиц). Дело было возбуждено по итогам проверки, проведенной специалистами Росфиннадзора. В ее ходе было выявлено неправомерное расходование денежных средств на сумму около 210,5 миллиона рублей.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (16,316,'Пропавший вертолет ищут спасатели на снегоходах',2,'Поиски вертолета Ми-8 компании \"Газпромавиа\", который пропал в среду, 21 марта, в Республике Коми, продолжаются. Операцию ведут спасатели на снегоходах, она не будет приостановлена даже с наступлением темноты. Утром 23 марта к поиску присоединятся вертолеты, которые доставят спасателей в труднодоступные районы.','Поиски принадлежащего компании \"Газпромавиа\" вертолета Ми-8, который пропал в среду, 21 марта, в Республике Коми, продолжаются. Операцию ведут спасатели на снегоходах, она не будет приостановлена даже с наступлением темноты, передает РИА Новости. Ранее сообщалось, что поиски пропавшего вертолета и находившихся на его борту пяти членов экипажа и одного пассажира временно приостановлены в связи с ухудшением метеоусловий. Как стало известно со слов представителя оперативного штаба регионального управления МЧС поисковые вертолеты смогут подняться в воздух теперь уже только утром 23 марта, в том случае, если позволит погода. Их вылет запланирован на 5 часов утра. Вертолеты должны будут высадить поисковые группы на вершины сопок, чтобы спасатели смогли обследовать труднодоступные районы. Напомним, что связь с Ми-8 была потеряна 21 марта в 15:00 по московскому времени. Вертолет возвращался в Ухту, после того как доставил группу рабочих на пункт экологического контроля в Вуктыльском районе. На поиски был отправлен вертолет со спасателями, который пролетел по маршруту пропавшего Ми-8, но ничего не обнаружил. С наступлением темноты поиски были прекращены. Рано утром в четверг, 22 марта, поисково-спасательная операция возобновилась. В ней были задействованы три вертолета и группы спасателей на снегоходах. Район поисков был расширен.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (17,317,'Питерские таможенники предотвратили незаконный вывоз запчастей для Су-27',2,'Сотрудники отдела по борьбе с особо опасными видами контрабанды Северо-западной оперативной таможни изъяли готовящиеся к отправке за границу детали для истребителей Су-27. Контейнеры с контрабандой были обнаружены в Морском порту Санкт-Петербурга. Злоумышленники собирались отправить их в одну из стран Азии.','Сотрудники отдела по борьбе с особо опасными видами контрабанды Северо-западной оперативной таможни изъяли готовящиеся к отправке за границу детали для истребителей Су-27, сообщает \"Интерфакс\". Контейнеры с контрабандой были обнаружены в Морском порту Санкт-Петербурга. \"По товарно-сопроводительным документам перевозились шины для гражданской авиационной техники. Hа самом же деле в контейнерах были обнаружены почти 900 колес для боевых истребителей Су-27. При осуществлении следственных мероприятий в складском помещении было обнаружено еще 600 штук шин, готовящихся к отправке за границу. Ориентировочная стоимость задержанного составляет не менее 5,5 миллионов рублей\", - рассказали в пресс-службе Северо-западной оперативной таможни. Этот инцидент стал уже вторым в этом роде с начала 2007 года. В феврале на российско-латвийской границе был задержан автобус с запасными частями к истребителям Су-27 и вертолетам Ка-27. В ходе обысков у задержанных тогда были изъяты и секретные карты Минобороны России. По мнению сотрудников Северо-западной оперативной таможни, \"нынешнее задержание является звеном все той же одной цепи и одних и тех же действующих лиц\".',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (18,318,'Пол Маккартни променял EMI на Starbucks',2,'Пол Маккартни стал первым музыкантом, заключившим договор со звукозаписывающим лейблом Hear Music, владельцем которого является сеть кофеен Starbucks. Музыкант сообщил, что его новый альбом может появиться в продаже уже в начале июня 2007 года, и охарактеризовал пластинку как \"очень личную\".','Пол Маккартни стал первым музыкантом, заключившим договор со звукозаписывающим лейблом Hear Music, владельцем которого является сеть кофеен Starbucks, сообщает BBC News. Лейбл был создан 12 марта 2007 года совместно со звукозаписывающей компанией Concord Music Group. Ранее сеть Starbucks уже работала как распространитель музыкальной продукции. Например, посетители кофеен могли приобрести сборник дуэтов Рэя Чарльза Genius Loves Company и акустическую версию альбома Jagged Little Pill певицы Аланис Мориссетт. Маккартни сообщил, что его новый альбом может появиться в продаже уже в начале июня 2007 года. Музыкант описал пластинку как \"очень личную\" и добавил, что песни будут затрагивать прошлое и настоящее. Напомним, что около недели назад Маккартни прервал отношения с лейблом Capitol/EMI, с которым сотрудничал с выхода первого альбома The Beatles в 1963 году.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (19,319,'Полузащитник сборной России рассказал о конфликте Титова и Хиддинка',2,'Главный тренер сборной России Гуус Хиддинк назвал капитана национальной команды Егора Титова главным виновником поражения в товарищеском матче с командой Нидерландов (1:4). Эта игра состоялась 7 февраля, но о конфликте капитана и тренера стало известно лишь 22 марта, после интервью одного из футболистов сборной.','Главный тренер сборной России Гуус Хиддинк назвал капитана национальной команды Егора Титова главным виновником поражения в товарищеском матче с командой Нидерландов (1:4). Эта игра состоялась 7 февраля, но о конфликте капитана и тренера стало известно лишь 22 марта, после интервью одного из футболистов сборной. \"Насколько я знаю, после проигрыша голландцам обычно спокойный Хиддинк был в бешенстве, - рассказал полузащитник московского \"Динамо\" и сборной России Игорь Семшов в интервью изданию \"Труд\". - В раздевалке досталось всем без исключения футболистам. Егору, как капитану сборной, больше всех. Вот что сказал Хиддинк: \"Так, как играл Титов, на поле действовать нельзя, Егор подвел команду\". Но после этого я не слышал нелицеприятных отзывов Титова о Хиддинке. Хотя, обида на тренера у него наверняка осталась. Но в той ситуации голландец был прав. Поражение со счетом 1:4 выведет из себя любого\". Напомним, что матч с Нидерландами стал пока последним для Егора Титова в составе сборной России. Перед матчем отборочного турнира Евро-2008 с командой Эстонии, который состоится 24 марта в 21:30, Титов отказался от вызова в команду. Он позвонил помощнику главного тренера сборной России Александру Бородюку и сообщил, что в данный момент ему важнее быть рядом с беременной женой. Гуус Хиддинк на пресс-конференции перед матчем с Эстонией заявил, что он понимает и принимает решение игрока. Титов провел в составе сборной России 41 матч и забил 7 голов.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (20,320,'Участникам драки в Кондопоге грозит до пяти лет строгого режима',2,'Государственный обвинитель потребовал приговорить участников драки в кондопожском ресторане \"Чайка\" Сергея Мозгалева и Юрия Плиева к 5-ти и 2,5 годам лишения свободы в колонии строгого режима. Адвокаты заявили об отсутствии хулиганского мотива в действиях подсудимых.','Государственный обвинитель потребовал приговорить участников драки в кондопожском ресторане \"Чайка\" Сергея Мозгалева и Юрия Плиева к 5-ти и 2,5 годам лишения свободы в колонии строгого режима, сообщает \"Росбалт\". Стороной обвинения действия Мозгалева квалифицированы по части 2-й статьи 213-й и части 2-й статьи 116-й УК РФ (хулиганство и побои), действия Плиева - по части 2-й статьи 213-й УК РФ. Адвокаты заявили об отсутствии хулиганского мотива в действиях подсудимых. Председательствующий объявил перерыв в процессе перед выступлением обвиняемых с последним словом. Напомним, что после упомянутой драки, в ходе которых были убиты двое русских, местные жители начали громить дома и имущество выходцев с Кавказа, которых обвинили в совершении этих убийств. По подозрению в причастности к погромам и поджогам зданий в Кондопоге были задержаны 109 человек, 25 участников массовых беспорядков были арестованы.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (21,321,'Росприроднадзор выступил за отзыв одной из лицензий у \"АЛРОСА\"',2,'Роспророднадзор будет ходатайствовать об отзыве лицензии на кимберлитовую трубку \"Дальняя\" у самой большой алмазодобывающей компании России \"АЛРОСА\". Ведомство проводило проверку лицензионного соглашения в марте 2007 года. По данных инспекторов, \"АЛРОСА\" не начала работы в установленный срок.','Росприроднадзор будет ходатайствовать об отзыве лицензии на кимберлитовую трубку \"Дальняя\" у самой большой алмазодобывающей компании России \"АЛРОСА\". Об этом сообщает РИА Новости со ссылкой на пресс-службу Министерства природных ресурсов. Росприроднадзор проводил проверку лицензионного соглашения в марте 2007 года. По данных инспекторов, \"АЛРОСА\" не начала работы в установленный срок. Кроме того, компания не представила заключения геологической и экологической экспертиз на проведение разведочных работ. Лицензионное соглашение предполагало, что разведка кимберлитовой трубки \"Дальняя\" будет закончена к 31 октября 2004 года. \"АЛРОСА\" добывает 25 процентов алмазов в мире. В 2005 году компании реализовала своей продукции на 2,86 миллиарда долларов. Основными акционерами \"АЛРОСА\" являются Росимущество и министерство по управлению госимуществом Якутии. Трубка \"Дальняя\" открыта в 1955 году. Она находится в Далдыно-Алакитском района на северо-западе Якутии.',26,1174588081,1174588081);
INSERT INTO `news_news` VALUES (22,322,'Лотерейный билет на 2 миллиона фунтов попал в пепельницу',2,'Четверо британских дорожных рабочих из графства Норфолк, выигравших в лотерею 2,1 миллионов фунтов стерлингов, хранили лотерейный билет в пепельнице своего автомобиля. Билет был помещен туда для сохранности. По словам самих победителей, больше месяца назад их предупредили о скором увольнении.','Четверо британских дорожных рабочих из графства Норфолк, выигравших в лотерею 2,1 миллионов фунтов стерлингов, хранили лотерейный билет в пепельнице своего автомобиля, пишет газета Daily Express. По словам мужчин, больше месяца назад их предупредили о скором увольнении. И в один из своих рейсов британцы решили купить билет Национальной лотереи Великобритании. Не придумав ничего лучше, для сохранности они решили спрятать его в пепельнице, поскольку курил только один из них, а пепел обычно стряхивал в открытое окно. О своем выигрыше мужчины узнали на следующий день. Билет - один из двух с общим призовым фондом в 4,2 миллионов фунтов - по счастью, был на прежнем месте. Дорожные рабочие, зарабатывавшие до этого по триста фунтов в неделю, признались, что потратят деньги на покупку новых домов, автомобилей, отдых и лечение.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (23,323,'Пророссийские организации в Крыму закроют через суд',2,'Служба безопасности Украины закроет все пророссийские радикальные организации в Крыму через суд. Об этом заявил в четверг исполняющий обязанности главы СБУ Валентин Наливайченко. Он также сообщил, что мэр Москвы Юрий Лужков согласился ответить на вопросы спецслужб относительно февральского выступления в Севастополе.','Служба безопасности Украины (СБУ) закроет все пророссийские радикальные организации в Крыму через суд. Об этом, как пишет в четверг \"Газета по-киевски\", заявил исполняющий обязанности главы СБУ Валентин Наливайченко. Он напомнил инцидент, когда Севастопольский суд с подачи СБУ принудительно прекратил деятельность организации \"Прорыв\". \"Перечень мероприятий реагирования на антиукраинскую деятельность не будет ограничиваться профилактическими беседами или закрытым въездом\", - пояснил Наливайченко. По его словам, в ближайшее время в суд поступит дело о \"Евроазийском союзе молодежи\", а также сообщил, что СБУ следит за деятельностью организации \"Крым-Севастополь-Россия\". Наливайченко также сообщил, что мэр Москвы Юрий Лужков согласился ответить на вопросы украинских спецслужб относительно своего февральского выступления в Севастополе. \"Господин Лужков согласился ответить на наш запрос. Согласно законодательству Украины, мы обязаны и опросим его в ближайшее время\", - отметил Наливайченко. Как сообщалось ранее, в Севастополе Лужков, в частности, заявил, что этот город, как и весь Крым в целом, в силу исторических процессов был \"оторван от России\" и это оставило \"глубокую рану, не заживающую в сердцах русских людей до сих пор\". В МИД Украины сочли, что мэр поставил под сомнение статус Крыма как части территории Украины. Что же касается закрытия в Крыму пророссийских организаций, то, как заявил в ответ на высказывания Наливайченко лидер \"Прорыва\" Алексей Добычин, Служба безопасности Украины должна в первую очередь в судебном порядке прекратить деятельность незарегистрированного крымско-татарского меджлиса. \"Прежде всего, пан Наливайченко, закройте незаконную, антиконституционную, экстремистскую организацию \"Меджлис\". Вот тогда все граждане Украины и Крыма убедятся в вашей непредвзятости и стремлении обеспечить государственную безопасность Украины. Это – ваш экзамен, и как вы его сдадите, мы все скоро увидим\", - сказал Добычин в интервью ИА \"Новый регион\".',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (24,324,'Мартина Навратилова устроила \"Большой шлем\" в живописи',2,'50-летняя американская теннисистка Мартина Навратилова, обладательница 354 спортивных титулов, открыла в Париже выставку своих картин. Все они написаны в одной технике: на холстах изображены фрагменты теннисных кортов и раскрашенные масляными красками отпечатки мячей, оставшихся от ударов Навратиловой.','50-летняя американская теннисистка Мартина Навратилова открыла в Париже на стадионе \"Ролан Гаррос\" выставку своих картин под названием \"Art Grand Slam\" (\"Большой шлем искусств\"). Экспозиция готовилась в тайне около шести лет: знаменитая спортсменка и словацкий художник Юрай Кралик (Juraj Kralik) опасались, что их живописное ноу-хау украдут, отмечает агентство France Presse. На выставке представлено более шестидесяти картин. Все они написаны в одной технике: на холстах изображены фрагменты теннисных кортов и раскрашенные масляными красками отпечатки мячей, оставшихся от ударов Навратиловой. \"Мне нравится, что не нужно было заботиться о том, куда летит мяч. В спорте такое немыслимо\", - заметила теннисистка, обладательница 354 титулов, завоеванных за 31 год. Юрай Кралик рассказал, что с детства любил смотреть, как мячи оставляют следы на грунтовых кортах, и в 1999 году впервые попробовал запечатлеть это на бумаге. Навратилова надеется, что после закрытия выставки, намеченного на 20 августа 2007 года, экспозиция отправится в США.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (25,325,'Спецслужбы Украины узнали о готовящемся покушении на Тимошенко',2,'В Службу безопасности Украины поступила информация об угрозе жизни лидера БЮТ Юлии Тимошенко. С таким заявлением в четверг выступил исполняющий обязанности главы СБУ Валентин Наливайченко. \"Эта информация тщательным образом проверяется\", - пояснил он. Наливайченко также пообещал в ближайшее время рассказать правду об отравлении Виктора Ющенко.','В Службу безопасности Украины (СБУ) поступила информация об угрозе жизни лидера БЮТ Юлии Тимошенко. С таким заявлением в четверг, как передает ProUA, выступил исполняющий обязанности главы СБУ Валентин Наливайченко. \"Эта информация тщательным образом проверяется\", - подчеркнул Наливайченко. При этом он напомнил, что СБУ обеспечивает безопасность первых лиц государства – в частности президента, премьера, спикера Верховной Рады и других лиц, определенных законом. Относится ли к таким лицам Тимошенко, руководитель СБУ не уточнил. По словам Наливайченко, СБУ имеет опыт работы относительно предотвращения преступлений против известных политиков. В частности, по его словам, в феврале служба получила информацию о привлечении криминалитета и поступлении угроз в адрес одного из руководителей облгосадминистраций. \"Мы закрыли это преступление, и задержали человека, и изъяли взрывчатку\", - сообщил Наливайченко, отказавшись при этом назвать имя чиновника, которому угрожали преступники. Исполняющий обязанности главы СБУ также пообещал, что совместно с Генпрокуратурой страны в ближайшее время они проинформируют общество о ходе расследования дела об отравлении президента Виктора Ющенко. \"Дайте нам возможность на будущей неделе объективно вас проинформировать вместе с Генеральной прокуратурой\", - обратился Наливайченко к прессе. Как известно, Ющенко был отравлен диоксином осенью 2004 года, когда был кандидатом в президенты Украины.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (26,326,'Французский издатель карикатур на пророка Мухаммеда оправдан',2,'Парижский суд снял все обвинения с главного редактора журнала Charlie Hebdo Филиппа Валя, который опубликовал на страницах своего издания карикатуры на пророка Мухаммеда. Таким образом были отклонены жалобы ряда исламских организаций, обвинивших Валя в \"преднамеренном нападении\" на мусульманские ценности.','Парижский суд снял все обвинения с главного редактора журнала \"Шарли Эбдо\" (Charlie Hebdo) Филиппа Валя (Philippe Val), который опубликовал в феврале прошлого года на страницах своего издания карикатуры на пророка Мухаммеда, сообщает Reuters. Таким образом были отклонены жалобы Союза исламских организаций Франции и Большой парижской мечети, обвинивших журналиста в \"преднамеренном нападении\" на мусульманские ценности и \"оскорблении группы лиц по религиозному признаку\". В том случае, если бы Валя признали виновным, ему грозило заключение на срок до шести месяцев и штраф в 22 тысячи евро. Charlie Hebdo опубликовал три карикатуры на пророка Мухаммеда, в том числе одну из датской газеты Jyllands-Posten. Напомним, что вышедшие на страницах датского издания картинки вызвали ярость со стороны многих мусульман по всему миру. В поддержку Charlie Hebdo выступил министр внутренних дел Франции и кандидат в президенты Николя Саркози, отправивший в адрес журналистов письмо одобрения.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (27,327,'Папа Римский стал обладателем чемпионского пояса по боксу',2,'Самый знаменитый боксерский промоутер Дон Кинг побывал на общей аудиенции, которую 21 марта на площади Святого Петра в Ватикане дал Папа Римский Бенедикт XVI. Во время аудиенции Кинг вручил понтифику чемпионские пояса по самым престижным версиям – WBC, IBF и WBA, а также пояса от французской и итальянской федераций.','Самый знаменитый боксерский промоутер Дон Кинг побывал на общей аудиенции, которую 21 марта на площади Святого Петра в Ватикане дал Папа Римский Бенедикт XVI. Во время аудиенции Кинг вручил понтифику чемпионские пояса по самым престижным версиям – WBC (Всемирный боксерский совет), IBF (Международная боксерская федерация) и WBA (Всемирная боксерская ассоциация), а также пояса от французской и итальянской федераций профессионального бокса, сообщает сайт Seconds Out. Кинг признался, что получил приглашение на аудиенцию с помощью одного из своих боксеров, чемпиона в среднем весе итальянца Луки Месси, родной брат которого является священником и служит в Ватикане. Месси присутствовал на аудиенции вместе с Кингом. \"Я подарил ему эти пояса, потому что Папа постоянно борется за Христа, мир и любовь во всем мире, - рассказал затем Кинг. – Я попросил его помолиться за моих боксеров, за мою жену, за президента США и его супругу, за наши войска и всех солдат, которые сражаются за мир\". Стоит отметить, что Дон Кинг является баптистом, а не католиком, но перед аудиенцией он заявил, что не делает особого различия между религиями. Основная цель визита Кинга в Италию – организация боксерских поединков.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (28,328,'Киргизия запретила узбекам бесплатно пасти скот на своей территории',2,'Правительство Киргизии удовлетворило ходатайство омбудсмена Турсунбая Бакир уулу и отменило распоряжение о беспошлинном ввозе скота из Узбекистана для выпаса на киргизской территории. Правозащитник обратился к властям, после многочисленных обращений в его адрес от местных скотоводов, которые требовали защитить их интересы.','Правительство Киргизии удовлетворило ходатайство омбудсмена Турсунбая Бакир уулу и отменило распоряжение о беспошлинном ввозе скота из Узбекистана для выпаса на арендованных пастбищах Узгенского района Ошской области республики. Об этом ИА \"24.kg\" сообщили в пресс-службе правозащитника. Там подчеркнули, что уполномоченный по правам человека направил свое ходатайство в связи с поступившей к нему просьбой скотоводов района. По их мнению, беспошлинный и фактически бесконтрольный выпас скота из соседнего государства приводит к вспышкам инфекционных заболеваний среди домашних животных и является одним из факторов уничтожения многолетних трав и редких растений в Ошской области. Помимо этого, заметили в пресс-службе омбудсмена, правительство Киргизии считает считает введение пошлин за для скотоводов соседнего государства эффективным средством пополнения районного бюджета.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (29,329,'Португальцы опередили Кука на 250 лет',2,'Австралийский журналист Питер Трикетт утверждает, что еще до еще за 250 лет до Джеймса Кука Австралию открыл малоизвестный португальский мореплаватель Кристовао Мендонка. В доказательство Трикетт приводит португальские карты начала XVI века, которые содержат подробное изображение восточного побережья Австралии.','Австралийский журналист Питер Трикетт (Peter Trickett) утверждает, что еще до еще за 250 лет до Джеймса Кука Австралию открыл малоизвестный португальский мореплаватель Кристовао Мендонка (Cristovao Mendonca), пишет британская The Guardian. В доказательство своих слов Трикетт приводит карты начала XVI века, которые ему случайно удалось купить у букиниста в Канберре. Карты, полагает Трикетт, содержат точное и подробное изображение восточного побережья Австралии, с обозначениями на португальском языке. Карты настолько точны, что по ним без труда можно определить точное местоположение. На них легко узнаются окрестности и линия побережья в районе залива Ботани (Botany Bay) в Тасмановом море, заявляет Трикетт. Журналист считает, что карты были составлены французским картографами по оригинальным картам Кристовао Мендонка, привезенным из путешествия, которое он осуществил в 1520 году. Трикетт опубликовал находку в своей книге Beyond Capricorn. Cчитается, что Австралию первым открыл Джеймс Кук, который обследовал ее восточное побережье в 1770 году и объявил новую землю собственностью английской короны.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (30,330,'Погорельцам из латвийского пансионата снова пришлось спасаться от пожара',2,'В ночь на 22 марта в латвийском доме престарелых \"Айзвики\" произошел пожар. У утру возгорание было ликвидировано. Никто из постояльцев не пострадал, все 87 человек, находившихся в здании, были эвакуированы. Ранее в центр \"Айзвики\" были помещены восемь пациентов пансионата \"Реги\", который сгорел в конце февраля.','В ночь на 22 марта в латвийском доме престарелых \"Айзвики\" произошел пожар, сообщает NovoNews. Никто из постояльцев не пострадал, все 87 человек, находившихся в здании, были эвакуированы. Как отмечает сайт liepajniekiem.lv, ранее в центр \"Айзвики\" были помещены восемь пациентов пансионата \"Реги\", который сгорел в конце февраля. Причиной пожара, произошедшего 22 марта, представители Государственной пожарно-спасательной службы Латвии считают неосторожное курение. Рассматривается также версия поджога. К утру возгорание было ликвидировано. О повреждениях, которые получило здание, не сообщается, однако сайт liepajniekiem.lv отмечает, что эвакуированные пациенты уже вернулись в пансионат.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (31,331,'Путин подписал указ о создании \"Объединенной судостроительной корпорации\"',2,'Президент России Владимир Путин в четверг 22 марта подписал указ \"Об открытом акционерном обществе \"Объединенная судостроительная корпорация\". ОСК объединит государственные финансовые активы в судостроении - как 100-процентные во ФГУПах, так и небольшие активы в частных компаниях.','Президент России Владимир Путин в четверг 22 марта подписал указ \"Об открытом акционерном обществе \"Объединенная судостроительная корпорация\" (ОСК), сообщает РИА Новости со ссылкой на пресс-службу Кремля. ОСК объединит государственные финансовые активы в судостроении - как 100-процентные во ФГУПах, так и небольшие активы в частных компаниях, отмечает ИТАР-ТАСС. Ожидается, что судостроительную корпорацию возглавит советник президента по военно-промышленной политике Александр Бурутин. Вице-премьер Сергей Иванов ранее заявлял, что в создаваемую компанию будут влиты все существующие проектно-конструкторские активы. В рамках ОСК будут созданы 3 региональные субхолдинга: Северный - на базе Северодвинских предприятий, Западный - на базе Санкт-Петербурга и Калининграда, а также Дальневосточный. Пресс-служба Кремля также сообщила, что президент подписал указ \"Об открытом акционерном обществе Центр технологии судостроения и судоремонта\", 100% акций которого будет принадлежать государству.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (32,332,'Новозеландская оперная дива выиграла иск о нижнем белье',2,'Суд Сиднея признал законность отказа новозеландской оперной певицы леди Кири Те Канава от выступления вместе с австралийским рокером Джоном Фарнхэмом. В 2005 году леди Кири не согласилась участвовать в концерте \"Два великих голоса\", опасаясь поклонниц Фарнхэма, швыряющих свое нижнее белье на сцену.','Суд Сиднея признал законность отказа новозеландской оперной певицы леди Кири Те Канава (Dame Kiri Te Kanawa) от выступления вместе с австралийским рокером Джоном Фарнхэмом (John Farnham). В 2005 году леди Кири не согласилась участвовать в концерте \"Два великих голоса\", опасаясь возбужденных поклонниц Фарнхэма, швыряющих свое нижнее белье на сцену. \"Разве я, классическая исполнительница, могу позволить такое отношение? Это неуважение ко мне\", - цитирует газета The Times заявление певицы. Иск почти на два миллиона американских долларов против леди Кири подала компания-промоутер Leading Edge Productions, посчитавшая, что певица нарушила контракт с Фарнхэмом. Однако суд признал правоту леди Кири: певица не подписывала ни одного договора с организаторами шоу. Примечательно, что Фарнхэм не отказался от проекта \"Два великих голоса\": на место леди Кири он пригласил Тома Джонса (Tom Jones), человека, в которого поклонницы бросаются трусами уже почти сорок лет, отмечает корреспондент The Times.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (33,333,'Таллин обнародовал отчет об оружии на пароме \"Эстония\"',2,'Правительство Эстонии обнародовало отчет спецкомиссии по расследованию перевозки оружия на затонувшем пароме \"Эстония\". Документ на эстонском языке выложен на сайте правительства. Спецкомиссия продолжит свою работу и подготовит новый отчет к октябрю этого года. Паром \"Эстония\" затонул в ночь на 28 сентября 1994. При этом погибли 852 человека.','Правительство Эстонии обнародовало отчет специальной комиссии по расследованию перевозки оружия на затонувшем пароме \"Эстония\". Как пишет Postimees, решение опубликовать секретные данные было принято в четверг, после того как кабинет министров ознакомился с отчетом. Документ на эстонском языке выложен на сайте правительства. Кабинет министров решил также продлить полномочия спецкомиссии, которая будет работать над новым отчетом по той же теме. Ожидается, что новый документ будет представлен правительству не позднее 15 октября 2007 года. Паром \"Эстония\", следовавший Таллина в Стокгольм, затонул в ночь на 28 сентября 1994 года во время сильного шторма. В результате кораблекрушения погибли 852 пассажира и члена экипажа, 137 человек были спасены. Официальными причинами катастрофы были названы дефекты конструкции и \"трагическое стечение обстоятельств\" - считается, что у парома на полном ходу открылись створки грузовой палубы. Существуют и другие версии причин гибели судна. В частности, есть предположение, что паром перевозил российское секретное оружие, которое и стало причиной кораблекрушения. До сих пор озвучиваются предложения поднять остатки парома, чтобы окончательно установить причину его гибели, однако эти инициативы не находят поддержки у властей Эстонии и Швеции.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (34,334,'Ожидающих PS3 австралийцев развлечет Джеймс Бонд',2,'Австралийские геймеры станут первыми, кто получит приставку PS3 за пределами Северной Америки и Японии. Реализация первой партии консолей начнется 23 марта 2007 в полночь в Сиднее. Чтобы собравшиеся у магазина геймеры не скучали, им покажут \"Казино Рояль\", последний на сегодняшний день фильм об агенте Джеймсе Бонде.','Австралийские геймеры станут первыми, кто официально получит приставку PlayStation 3 за пределами Северной Америки и Японии. Реализация первой партии консолей начнется 23 марта 2007 в полночь в Сиднее, сообщает AFP. Назначенное время соответствует четырем часам дня 22 марта по Москве. Представитель Sony заявил, что компания получила предварительные заказы на PS3 от десяти тысяч потенциальных покупателей. Собравшихся у магазина геймеров будут развлекать специально приглашенные для этого диджеи; кроме того, чтобы игроки не скучали, им покажут \"Казино Рояль\", последний на сегодняшний день фильм об агенте Джеймсе Бонде. В Европе официальные продажи консолей начнутся завтра, 23 марта 2007 года, в девять часов утра по Гринвичу (в полдень по Москве). Сообщается, что первый человек, пожелавший купить приставку, появился у магазина Virgin Megastore (где произойдет официальный запуск PS3) в пять утра 21 марта. Консоль еще вчера можно было купить в Италии, где некоторые местные ритейлеры начали продажи в обход договора с Sony. Напомним, что компания Sony планировала начать реализацию своей новейшей консоли в ноябре 2006 года одновременно во всех регионах. Но создатели приставок столкнулись с техническими трудностями, и в прошлом году PlayStation 3 добралась только до Японии и Северной Америки.',31,1174588081,1174588081);
INSERT INTO `news_news` VALUES (35,335,'\"Наши\" решили отправить Путину 100 тысяч SMS',2,'25 марта в Москве пройдет массовая акция движения \"Наши\" под названием \"Связной президента\", в рамках которой все желающие смогут отправить SMS-сообщение Владимиру Путину. Организаторы намерены вовлечь в этот процесс не менее 100 тысяч молодых людей. Акция посвящена 7-й годовщине президентства Путина.','25 марта в Москве пройдет массовая акция молодежного движения \"Наши\" под названием \"Связной президента\", в рамках которой все желающие смогут отправить SMS-сообщение Владимиру Путину. Организаторы намерены вовлечь в этот процесс не менее ста тысяч молодых людей, сообщает РИА \"Новости\". Акция будет посвящена седьмой годовщине президентства Путина, который был избран на этот пост 26 марта 2000 года. Как заявил в четверг на пресс-конференции лидер \"Наших\" Василий Якеменко, проводить акцию будут 15 тысяч активистов движения из разных регионов страны - так называемые \"связные президента\". Акция начнется митингом на проспекте Сахарова, который уже санкционирован московскими властями. Затем активисты \"Наших\" рассредоточатся по городу и будут предлагать молодым прохожим \"дать оценку политическому курсу страны\", отправив Путину SMS-сообщение на специальный телефонный номер. \"Связные президента\" будут находиться приблизительно в 800 точках по всей Москве. Тексты присланных сообщений будут транслироваться на несколько установленных в городе больших экранов. В дальнейшем из этих SMS будет составлена брошюра, один экземпляр которой организаторы намерены передать Путину. Кроме того, в рамках акции представители \"Наших\" планируют раздать десять тысяч SIM-карт с нулевым балансом, на которые их обладателям будут рассылаться сообщения о проводимых образовательных проектах, семинарах и лекциях, организуемых при содействии \"Наших\" в институте \"Высшая школа управления\". Напомним, что в выходные первой половины апреля в Москве планируется проведение нескольких массовых акций. Так, 8 апреля \"Международное Евразийское движение\" собирается провести \"Имперский марш\" в знак протеста против \"Марша несогласных\". А 14 апреля пройдут сразу две акции - \"Марш несогласных\", организованный политическим совещанием оппозиционного форума \"Другая Россия\", и акция \"Молодой гвардии Единой России\", в которой, по предварительным данным, примут участие 15 тысяч человек.',29,1174588081,1174588081);
INSERT INTO `news_news` VALUES (36,336,'Евросоюз открыл небо для американских авиакомпаний',2,'Министры транспорта Евросоюза единогласно поддержали соглашение \"открытых небес\", дающее возможность американским авиаперевозчикам бесплатно летать в любой город ЕС, а европейским - в любой город США. Сторонники соглашения утверждают, что оно стимулирует конкуренцию между авиакомпаниями и приведет к удешевлению рейсов.','Министры транспорта Евросоюза единогласно поддержали соглашение \"открытых небес\", дающее возможность американским авиаперевозчикам бесплатно летать в любой город ЕС, а европейским - в любой город США, сообщает BBC News. По оценке представителей Еврокомиссии, экономическая выгода от заключения соглашения составит до 12 миллиардов евро, сообщает AFP. Кроме того, благодаря документу в ближайшие пять лет через Атлантику будет перевезено дополнительно 26 миллионов пассажиров, и будут созданы 80 тысяч рабочих мест как в ЕС, так и в США. В то же время, отмечает BBC News, согласно документу, европейские компании не получат равных прав с американскими на внутренних маршрутах США. Первоначально договор должен был вступить в силу в октябре 2007 года, но с подписанием сроки сдвинулись на март 2008 года. Вашингтон должен будет подписать его 30 апреля. Сторонники соглашения утверждают, что оно стимулирует конкуренцию между авиакомпаниями и в конце концов приведет к удешевлению рейсов. Против документа, направленного на упрощение механизма трансатлантических перелетов, высказывались британские перевозчики. В настоящее время трансатлантические перевозки из крупнейшего авиаузла Великобритании, аэропорта Хитроу, контролируют лишь четыре компании: BA, Virgin, American Airlines и United Airlines. Соглашение позволит осуществлять такие рейсы и другим авиакомпаниям. При этом общее число рейсов не изменится.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (37,337,'Российские десантники получили БТР нового поколения',2,'В России завершены испытания бронетранспортера БТР-МД и бронированной медицинской машины БММ-Д для воздушно-десантных войск. Бронемашины нового поколения, построенные на шасси БМД-3, оснащены гидропневматической подвеской и могут десантироваться с помощью грузовых парашютных систем.','В России завершены испытания многоцелевого бронетранспортера и бронированной медицинской машины для ВДВ, сообщает РОСПРОМ. Многоцелевой бронетранспортер БТР-МД и медицинская машина БММ-Д построены на шасси серийной боевой машины десанта БМД-3. От прежней машины новый БТР отличается, в частности, усиленной броневой защитой и большими размерами. Бронетранспортер предназначен для перевозки грузов и личного состава при ведении боевых действий, а также для монтажа различных систем вооружения - противотанковых ракет, малокалиберных пушек, средств наблюдения и целеуказания. Бронированная медицинская машина предназначена для поиска, сбора и вывоза раненых с поля боя с оказанием им первой помощи. Она оснащена погрузочно-разгрузочными устройствами для размещения раненых на носилках, лебедкой и краном для извлечения раненых из труднодоступных мест (овраги, провалы, подбитая техника). Обе бронированные машины способны десантироваться с помощью грузовых парашютных систем. Для перевозки БТР-МД и БММ-Д по воздуху могут использоваться самолеты Ан-12, Ил-76 и грузовые вертолеты Ми-26. Как и БМД-3, эти машины оснащены гидропневматической подвеской, позволяющей изменять дорожный просвет.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (38,338,'Сторонники Ющенко призывают отобрать у России два радара',2,'Украина в самое ближайшее время должна разорвать договор об аренде Россией двух РЛС, расположенных в Мукачево и Севастополе. С таким заявлением выступил депутат парламентской фракции пропрезидентского блока \"Наша Украина\" Руслан Князевич. По его словам, российские РЛС угрожают безопасности Украины, поскольку РФ воюет с мусульманским государством.','Украина в самое ближайшее время должна разорвать договор об аренде Россией станций радиолокационного наблюдения (РЛС), расположенных в Мукачево и Севастополе. С таким заявлением, как пишет ИА \"Новый регион\", выступил депутат парламентской фракции пропрезидентского блока \"Наша Украина\" Руслан Князевич. \"Мы считаем необходимым, чтобы Верховная Рада дала поручение правительству про неотложное приостановление договора с Российской Федерацией и его разрыв, относительно размещения РЛС на нашей территории\", – заявил депутат, по мнению которого, арендуемые Россией объекты являются источником потенциальной террористической угрозы для Украины. \"Сегодня угроза для Украины не от размещения (систем ПРО - примечание Lenta.Ru) в Чехии и Польше, а от двух РЛС, которые отданы Российской Федерации. РФ находится в состоянии внутренней войны с мусульманским государством, и именно это может быть террористической угрозой для Украины\", – считает Князевич. РЛС в Севастополе (Крым) и Мукачево (Закарпатье) являются собственностью Украины. В соответствии с российско-украинским соглашением, информация с этих станций, ведущих наблюдение за космическим пространством над Центральной и Южной Европой, а также Средиземноморьем, поступает на центральный командный пункт Космических войск РФ. Ранее Украина уже требовала от России увеличить плату за аренду РЛС. В четверг также стало известно, что Верховная Рада Украины планирует выразить обеспокоенность планами США разместить на территориях соседних с Украиной государств элементы противоракетной обороны. В проекте постановления, которое было принято депутатами за основу, отмечается, что реализация планов США по поводу размещения элементов ПРО угрожает национальной безопасности Украины и миллионам ее граждан.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (39,339,'Француз Бриан Жубер стал чемпионом мира по фигурному катанию',2,'В Японии, где проходит чемпионат мира по фигурному катанию, определись призеры в соревнованиях мужчин. Новым чемпионом мира стал француз Бриан Жубер, который сумел опередить японца Дайсуке Такахаси и двукратного чемпиона мира, швейцарца Стефана Ламбьеля. Российские фигуристы в десятку лучших не попали.','В Японии, где проходит чемпионат мира по фигурному катанию, определись призеры в соревнованиях мужчин. Новым чемпионом мира стал француз Бриан Жубер, который сумел опередить японца Дайсуке Такахаси и двукратного чемпиона мира, швейцарца Стефана Ламбьеля. Российские фигуристы в десятку лучших не попали. Ключевым фактором в победе Жубера стало удачное выступление в короткой программе, во время которой он не допустил ни единой ошибки. В произвольной программе француз выступал после Ламбьеля, и мог сам решать, включать в свое выступление три прыжка в четыре оборота, или оставить два. Жубер решил ограничиться двумя четверными прыжками, причем во время выступления не допустил ни одной ошибки. Швейцарский фигурист откатал свою программу с двумя небольшими помарками, что не позволило ему занять даже второе место. Он в итоге проиграл всего один балл Такахаси, которому судьи поставили самые высокие оценки за произвольную программу. Россияне Сергей Воронов и Андрей Лутай в итоге заняли 19-е и 20-е места. Это означает, что на следующем чемпионате мира Россию в мужском одиночном катании будет представлять только один спортсмен.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (40,340,'Южная Корея поможет КНДР цементом и одеялами',2,'Руководство Южной Кореи обещает до конца марта возобновить гуманитарную помощь КНДР, прерванную в связи с ядерными испытаниями, которые Пхеньян провел в октябре 2006 года. Это решение последовало за согласием Северной Кореи свернуть свою ядерную программу в обмен на отмену экономических санкций.','Руководство Южной Кореи обещает до конца марта возобновить гуманитарную помощь КНДР, прерванную в связи с ядерными испытаниями, которые Пхеньян провел в октябре 2006 года, сообщает AFP. Это решение последовало за согласием Северной Кореи свернуть свою ядерную программу в обмен на отмену экономических санкций. Как заявил замминистра по делам национального объединения Южной Кореи Шин Он-Сан (Shin Eon-Sang), 28 марта начнутся поставки одеял для жертв наводнений, произошедших в Северной Корее летом 2006 года. В апреле-мае, по его словам, в КНДР будут отправлены также грузовики, цемент и арматура. Кроме того будут возобновлены ежегодные поставки риса и удобрений в северную республику. Между тем 22 марта шестисторонние переговоры по ядерной программе в очередной раз были сорваны. Причиной стала задержка в процессе разблокирования северокорейских счетов в банке Макао, которые ранее были заморожены по требованию США. КНДР отказалась продолжать переговоры, пока не получит доступа к этим средствам.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (41,341,'Папу объявили единственной преградой между православными и католиками',2,'Архиепископ Венский кардинал Кристоф Шенборн в интервью газете \"Труд\" заявил, что католическая и православная церкви пришли к согласию почти по всем спорным вопросам и единственное, что на данный момент их разделяет, - это вопрос о роли наместника престола святого Петра - Папы Римского.','Архиепископ Венский кардинал Кристоф Шенборн в интервью газете \"Труд\" заявил, что католическая и православная церкви пришли к согласию почти по всем спорным вопросам и единственное, что на данный момент их разделяет, - это вопрос о роли наместника престола святого Петра - Папы Римского. Вместе с тем, кардинал выразил надежду, что со временем православные и католики смогут выработать некий общий подход в осмыслении места Папы Римского в христианском мире. В этой связи он обратил внимание на энциклику \"Ut unum sint\" Иоанна Павла II, который пригласил всех христиан \"к совместному размышлению над формой осуществления службы Петра\", отметив, что это приглашение действует и сегодня. В целом Кристоф Шенборн выразил убеждение, что предполагаемая борьба религий - это \"идеологическая фантазия\". По его мнению, в современном мире есть достаточное количество вопросов, по которым христиане не только могут, но и должны говорить одним голосом. Прежде всего, речь в данном случае идет о распространении универсальных христианских принципов и отстаивании справедливости и мира. Со своей стороны, представитель православной церкви, глава секретариата Отдела внешних церковных связей по межхристианским отношениям священник Игорь Выжанов, в интервью агентству \"Интерфакс\" назвал точку зрения Кристофа Шенборна \"триумфалистcкой\". Он отметил, что среди католических иерархов традиционно широко распространено представление, что между католиками и православными нет различий, кроме как по вопросу о роли Папы. Между тем, по словам Выжанова, \"почти все православные богословы, причем не только в России, но и в Греции и других странах, сходятся во мнении, что различия есть\".',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (42,342,'Сейм Латвии отказался заботиться о культуре нацменьшинств',2,'Латвийский сейм отклонил законопроект, вменяющий в обязанность самоуправлений республики заботу, в том числе и финансовую, о сохранении культуры нацменьшинств, если к ним принадлежат не менее одной четверти жителей конкретного самоуправления. Авторы закона пытались доказать, что представители нацменьшинств такие же налогоплательщиками как и латыши, но безуспешно.','Латвийский сейм в четверг отклонил законопроект, вменяющий в обязанность самоуправлений республики заботу, в том числе и финансовую о сохранении культуры национальных меньшинств с правом формирования комиссий по делам нацменьшинств, если к ним принадлежат не менее одной четверти жителей конкретного самоуправления. Как пишет интернет-газета NovoNews, поправки к закону о самоуправлениях подготовили депутаты парламентской фракции \"За права человека в единой Латвии\" (ЗаПЧЕЛ). Авторы документа пытались доказать, в частности, что представители национальных меньшинств являются такими же налогоплательщиками, как и другие жители страны и у них должно быть право на финансирование культурных программ, реализуемых на русском языке. Однако за передачу законопроекта на рассмотрение парламентских комиссий проголосовали только 22 депутата, 23 были против и 37 воздержались. Между тем, как утверждают в ЗаПЧЕЛ, в настоящее время в большинстве городов и районов Латвии культурные мероприятия национальных меньшинств финансируются в недостаточном объеме, редко устраиваются Новогодние ёлки на понятном всем нацменьшинствам республики русском языке, ещё реже финансируются театральные представления и концерты.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (43,343,'В Нижнем Новгороде избили малазийского студента',2,'В Нижнем Новгороде подростки избили гражданина Малайзии. Как передает Интерфакс со ссылкой на ГУВД нижегородской области, нападение было совершено из хулиганских побуждений. Пострадавший не нуждался в госпитализации. Возбуждено уголовное дело по факту нанесения побоев.','В Нижнем Новгороде подростки избили гражданина Малайзии. Как передает \"Интерфакс\" со ссылкой на ГУВД нижегородской области, нападение было совершено из хулиганских побуждений. Вечером в среду группа подростков, предположительно в количестве 10 человек, напала на 18-летнего студента Нижегородской государственной архитектурно-строительной академии. Иностранцу брызнули в лицо из газового баллончика, затем нанесли телесные повреждения. Пострадавший не нуждался в госпитализации. Возбуждено уголовное дело по факту нанесения побоев.',21,1174588081,1174588081);
INSERT INTO `news_news` VALUES (45,345,'В Белоруссию занесло гарь из Чернобыля',2,'В зоне отчуждения около Чернобыльской АЭС сгорели несколько гектаров травы, при этом дым и остатки горения ветром отнесло в сторону Белоруссии. В МЧС Украины сообщили, что пожар уже локализован, идут замеры радиации, результаты которых станут известны уже вечером в четверг или в пятницу. Причиной пожара стало, по всей видимости, неосторожное обращение с огнем.','В зоне отчуждения около Чернобыльской АЭС, приблизительно в 8-10 километрах от самой станции, сгорели несколько гектаров травы, при этом дым и остатки горения ветром отнесло в сторону Белоруссии. Об этом пишет в четверг интернет-издание Telegraf.by. В МЧС Украины сообщили, что пожар на площади около 60 гектаров уже локализован, идут замеры радиации. \"Горела трава – подстилка, вокруг – болота, водоемы, и угрозы дальнейшего распространения нет\", - пояснил заместитель главы МЧС Владимир Холоша. По его словам, на украинской территории \"пока ничего чрезвычайного нет, потому что ветер, по моим данным, идет в сторону Беларуси\". Холоша пояснил также, что причиной пожара, который возник в районе железной дороги, по которой из города Славутич возят на станцию работников ЧАЭС, стало, по всей видимости, неосторожное обращение с огнем. Теперь все участники ликвидации возгорания пройдут специальное обследование. Результаты замеров радиации станут известны уже вечером в четверг или в пятницу. В настоящее время на месте пожара работают 60 сотрудников и 10 единиц техники МЧС Украины.',22,1174588081,1174588081);
INSERT INTO `news_news` VALUES (46,346,'Рокфеллер намерен поставить мировой рекорд на арт-рынке',2,'Дэвид Рокфеллер, миллиардер и филантроп, выставит на майские торги дома Sotheby\'s в Нью-Йорке картину абстрактного экспрессиониста Марка Ротко \"Белый центр\". Стоимость полотна оценена в 40 миллионов долларов: это самая высокая цена за произведение послевоенного искусства.','Дэвид Рокфеллер, миллиардер и филантроп, выставит на майские торги дома Sotheby\'s в Нью-Йорке картину абстрактного экспрессиониста Марка Ротко \"Белый центр\". Стоимость полотна оценена в 40 миллионов долларов: это самая высокая цена за произведение послевоенного искусства, отмечает агентство Bloomberg. Независимо от исхода аукциона 15 мая 2007 года 91-летний Рокфеллер получит гарантированную домом Sotheby\'s сумму, но ее величина не разглашается. \"Белый центр\", написанное в 1950 году большое полотно (свыше двух метров в высоту), считается ключевой работой позднего Ротко: в ней он выработал ту манеру, которая сделала его знаменитым. Рокфеллер приобрел полотно в 1960 году, еще при жизни Ротко, \"нехотя и с трепетом\" - по рекомендации Дороти Миллер, куратора нью-йоркского Музея современного искусства (MoMA). Спустя 47 лет картины Ротко ценятся на арт-рынке чрезвычайно высоко: в 2005 году его \"Посвящение Матиссу\" ушло с молотка за 22,4 миллиона долларов, а в ходе частных сделок стоимость его работ достигает 30 миллионов. Ротко входит в тройку самых дорогих послевоенных живописцев наравне с Виллемом де Кунингом и Энди Уорхолом.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (47,347,'ООН признала торговлю детьми \"суровой реальностью\" Украины',2,'ООН выражает обеспокоенность развитием детской проституции на Украине. Специальный докладчик организации по вопросу о торговле детьми, детской проституции и детской порнографии Хуан Мигель Петит в своем докладе, подготовленным после посещения Украины в октябре прошлого года, заявил, что торговля детьми является суровой реальностью этой страны.','Организация Объединенных Наций выражает обеспокоенность развитием детской проституции на Украине. Как пишет в четверг ProUA, об этом говорится в докладе, который представил специальный докладчик ООН по вопросу о торговле детьми, детской проституции и детской порнографии Хуан Мигель Петит по итогам посещения Украины в конце октября 2006 года. В докладе отмечается, в частности, что на Украине процветает детская проституция, а торговля детьми является \"огромной проблемой и суровой реальностью\". Петит утверждает, что 10 процентов жертв торговли людьми составляют дети в возрасте от 13 до 18 лет, половина детей посылается в соседние страны, в основном в Россию. \"Дети эксплуатируются в уличной торговле в качестве домашней прислуги, в сельском хозяйстве, в качестве танцовщиц, официантов и официанток или в целях оказания сексуальных услуг\", - говорится в докладе. Торговцы детьми заманивают своих жертв в долговую кабалу, они заставляют их отработать расходы, связанные с поездкой и такими услугами, как питание и жилье, при этом возможности вырваться из кабалы появляются крайне редко. В свою очередь, согласно данным обследования, проведенного Украинским институтом социальных исследований среди женщин, занимающихся оказанием сексуальных услуг в коммерческих целях, 11 процентов составляли дети в возрасте от 12 до 15 лет и 20 процентов - в возрасте от 16 до 17 лет. Хуан Мигель Петит подчеркивает в своем докладе, что с отменой виз для туристов из большинства западных стран Украина становится одним из основных направлений для секс-туризма, в котором используются и дети. По мнению, представителя ООН, Украине необходимо будет сформировать новую модель защиты прав детей, иначе она столкнется с последствиями, которые будут серьезно сказываться на будущих поколениях.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (48,348,'Минздрав предлагает сажать на 15 суток за отказ сдать анализ на наркотики',2,'Минздрав разработал поправки в КоАП, которые вводят наказание в виде штрафа или ареста за отказ лечиться от наркомании, а также проходить обследование на предмет употребления наркотиков. Нарушителей предлагается штрафовать на сумму от 10 до 20 минимальных МРОТ или отправлять под арест на срок до 15 суток.','Минздравсоцразвития разработало поправки в Административный кодекс РФ, которые вводят наказание в виде штрафа или ареста за отказ лечиться от наркомании, а также проходить обследование на предмет употребления наркотиков, пишет \"Коммерсант\". И та, и другая процедуры в настоящее время носят добровольный характер, однако тех, кто от них отказывается, авторы поправок предлагают штрафовать на сумму от 10 до 20 минимальных размеров оплаты труда (размер МРОТ, по которому считаются штрафы, составляет 100 рублей) или отправлять под арест на срок до 15 суток. Посредством подобных мер чиновники, как выразился замглавы Минздрава Владимир Стародубов, рассчитывают \"улучшить выявляемость наркозависимых\". В то же время, как пишет \"Коммерсант\", законопроект может стать очередным шагом к принудительному лечению наркоманов.',21,1174588081,1174588081);
INSERT INTO `news_news` VALUES (49,349,'Египет намерен запретить полеты Ил-86 уже с 1 мая',2,'Власти Египта планируют запретить полеты на свою территорию российский самолетов Ил-86. Запрет может быть введен с 1 мая или 1 июня 2007 года. Эти самолеты активно используются для чартерных перевозок туристов, и запрет на их использование может иметь заметные последствия для туристического рынка.','Власти Египта планируют запретить полеты на свою территорию российских самолетов Ил-86. По информации газеты \"Коммерсант\", запрет может быть введен с 1 мая или 1 июня 2007 года. Эти самолеты активно используются для чартерных перевозок туристов, и запрет на их использование может иметь заметные последствия для туристического рынка. В частности, увеличится стоимость путевок в эту африканскую страну. О готовящемся запрете изданию стало известно из письма директора департамента госполитики в области гражданской авиации Минтранса России к председателю египетского управления гражданской авиации Самиру Абдель Мабуду Абдель Азизу от 7 марта. В тексте содержится просьба \"оказать содействие в продлении периода операций до окончания летнего сезона 2007 года\". Запрет может быть введен на основании приложения \"Защита окружающей среды\" к Конвенции по пребыванию судов международной гражданской авиации в воздушном пространстве Египта. Местные власти начали выражать недовольство несоответствием двигателей Ил-86 международным нормам по шумам еще в 2003 году. Наибольшие парки Ил-86 принадлежат российским авиакомпаниям \"Сибирь\", \"Атлант-союз\" и \"Красноярские авиалинии\". По мнению участников рынка, если запрет будет введен, это приведет к уменьшению количества российских туристов в Египте, подорожанию путевок и перераспределению пассажирского потока в пользу компаний, предпочитающих использовать иностранные самолеты, например, \"Трансаэро\". Похожая ситуация уже складывалась, когда полеты Ил-86 на своей территории запретили Кипр и Болгария. Количество туристов, отправляющихся на Кипр, уменьшилось на 25 процентов, а стоимость перевозок в Болгарию увеличилась на 15 процентов.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (50,350,'Сборная Хиддинка потеряла еще одного полузащитника',2,'Полузащитник московского \"Динамо\" Игорь Семшов не сможет принять участие в матче отборочного турнира Евро-2008 Эстония - Россия. В среду 21 марта у футболиста поднялась температура, и врачи национальной команды приняли решение отпустить его со сборов, чтобы избежать переноса инфекции на других игроков.','Полузащитник московского \"Динамо\" Игорь Семшов не сможет принять участие в матче отборочного турнира Евро-2008 Эстония - Россия. В среду 21 марта у футболиста поднялась температура, и врачи национальной команды приняли решение отпустить его со сборов, чтобы избежать переноса инфекции на других игроков, сообщает официальный сайт Российского футбольного союза (РФС). Потеря Семшова еще больше усугубляет кадровый дефицит центральных полузащитников. Во вторник расположение команды Гууса Хиддинка по семейным обстоятельствам покинул Егор Титов, и Семшов считался главным кандидатом на замену капитана московского \"Спартака\". Кроме того, по словам врача сборной Андрея Гришина, по прежнему под вопросом находится участие в игре с эстонцами центрального защитника Дениса Колодина. Шансы динамовца, получившего травму ноги, выйти на поле оцениваются как 50 на 50. Сборная России вылетит в Таллин в четверг в 17:00 после того, как проведет последнюю тренировку на стадионе \"Динамо\". Матч с эстонцами состоится 24 марта (начало в 21:30 по московскому времени) и будет показан Первым каналом в прямом эфире. Окончательный состав сборной России на матч с Эстонией Вратари: Игорь Акинфеев (ЦСКА), Вячеслав Малафеев (\"Зенит\"), Дмитрий Бородин (\"Торпедо\"). Защитники: Александр Анюков (\"Зенит\"), Сергей Игнашевич (ЦСКА), Сергей Ефимов (\"Локомотив\"), Денис Колодин (Динамо\"), Роман Шишкин (\"Спартак\" М). Полузащитники: Евгений Алдонин, Юрий Жирков (оба - ЦСКА), Владимир Быстров, Дмитрий Торбинский (оба - \"Спартак\" М), Динияр Билялетдинов (\"Локомотив\"), Константин Зырянов, Игорь Денисов (оба - \"Зенит\"). Нападающие: Иван Саенко (\"Нюрнберг\", Германия), Дмитрий Сычев (\"Локомотив\"), Андрей Аршавин (\"Зенит\"), Александр Кержаков (\"Севилья\", Испания), Евгений Савин (\"Амкар\").',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (51,351,'Правительство России одобрило основные параметры трехлетнего бюджета',2,'Правительство России приняло за основу основные параметры федерального бюджета на 2008-2010 годы. Премьер-министр Михаил Фрадков призвал правительство в течение ближайшего месяца доработать бюджет, чтобы до 30 апреля внести его в Госдуму. В 2007 году главный бюджет страны будет впервые приниматься сразу на три года.','Правительство России приняло за основу основные параметры федерального бюджета на 2008-2010 годы. Премьер-министр Михаил Фрадков призвал правительство в течение ближайшего месяца доработать бюджет, чтобы до 30 апреля внести его в Госдуму. Об этом сообщает РИА Новости. В 2007 году главный бюджет страны будет впервые приниматься не на один год, а сразу на три. Согласно проекту трехлетнего бюджета, в 2008 году доходы запланированы на уровне 6,67 триллиона рублей (19,1 процента ВВП), расходы - 6,5 триллиона рублей (18,6 процента ВВП). Таким образом, профицит в 2008 году может составить 173,2 миллиарда рублей или 0,5 процента ВВП. В 2006 году профицит составил 7,5 процента ВВП. В 2009 году доходы запланированы в сумме 7,4 триллиона рублей (18,8 процента ВВП), расходы 7,4 триллиона рублей (18,6 процента ВВП). Профицит в 2009 году прогнозируется на уровне 0,2 процента, а в 2010 году - 0,1 процента ВВП. При этом доходы в 2010 году составят восемь триллионов рублей (18,1 процента ВВП), а расходы - 7,9 триллиона рублей (18 процентов ВВП). При этом премьер напомнил, что сейчас идет формирование так называемого \"ненефтегазового\" бюджета. По мнению Фрадкова, правительство должно \"поставить себя в такую модель\", в которой оно вынуждено будет заниматься диверсификацией экономики. \"Если мы этого не сделаем, то мы сами себе на ногу просто наступим и никуда не денемся. А нам нужно наступить себе на ногу и при этом идти вперед\", - выразил свое видение ситуации премьер. Стоит напомнить, что работа над трехлетним бюджетом в правительстве сопровождается внесением изменений в Бюджетный кодекс, разделив Стабфонд на резервный фонд и фонд будущих поколений и дополнив кодекс статьями о нефтегазовом трансферте в экономику так, чтобы бюджет на 2008-2010 годы оказался \"ненефтегазовым\". Кроме того, правительство приняло за основу основные направления долговой политики на 2008-2010 годы. Ранее Минфин заявлял, что в 2009 году чистое привлечение средств составит 396,3 миллиарда рублей. В 2010 году - 524,8 миллиарда рублей.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (52,352,'Накануне распродажи \"ЮКОСа\" \"Роснефть\" покинул первый вице-президент',2,'\"Роснефть\" покинул первый вице-президент компании Николай Борисенко, который, в частности, отвечал за стратегию компании в сфере слияний и поглощений. Борисенко покидает компанию накануне аукционов по продаже активов \"ЮКОСа\", на первый из которых будут выставлены 9,44 процента акций самой \"Роснефти\".','\"Роснефть\" покинул первый вице-президент компании Николай Борисенко, который отвечал за стратегию компании в сфере слияний и поглощений. Об этом сообщила пресс-служба компании. Газета \"Ведомости\" пишет, что отставка Борисенко ослабит \"Роснефть\" и ее руководителя Сергея Богданчикова. Неясно почему Борисенко покидает компанию накануне аукционов по продаже активов \"ЮКОСа\". На первый аукцион выставлены 9,44 процента акций самой \"Роснефти\" и векселя \"Юганскнефтегаза\". Ранее \"Роснефть\" объявляла о планах участвовать в торгах и уже заняла 22 миллиарда долларов. Борисенко был единственным зампредом правления компании и, по сути, осуществлял оперативное руководство \"Роснефтью\". В сентябре 2005 года Борисенко был награжден орденом \"За заслуги перед Отечеством 2 степени\" за вклад в развитие нефтегазовой промышленности. Борисенко работает с Богданчиковым с 1994 года. \"Ведомости\" отмечают, что отставка стала неожиданностью для коллег Борисенко: президент \"Роснефти\" не собирал менеджеров компании и ничего им на эту тему не объявлял. Сферы деятельности Борисенко поделят между другими менеджерами компании. Выручка \"Роснефти\" за девять месяцев 2006 года - 25,5 миллиарда, чистая прибыль - 2,9 миллиарда долларов. Государственному \"Роснефтегазу\" принадлежит более 75 процентов компании, \"ЮКОСу\" - 9,44 процента. Капитализация в РТС - 88,3 миллиарда долларов.',26,1174588081,1174588081);
INSERT INTO `news_news` VALUES (53,353,'Владельцы гравюры Эдварда Мунка выкупили ее у грабителей',2,'В Швеции неизвестный вернул владельцам похищенную в 2006 году гравюру Эдварда Мунка под названием \"К лесу\" стоимостью более полумиллиона долларов. За работу норвежского классика, выкраденную из частного дома, был заплачен выкуп. Поисками гравюры, выполненной в 1897 году, занимались ее хозяева.','В Швеции неизвестный вернул владельцам похищенную в 2006 году гравюру Эдварда Мунка стоимостью более полумиллиона долларов. По сведениям шведской газеты Kvaellsposten, на которую ссылается агентство France Presse, за работу норвежского классика был заплачен выкуп, но ни сумма его, ни другие обстоятельства сделки не сообщаются. Гравюра 1897 года под названием \"К лесу\" была украдена из частного дома на юге Швеции в мае 2006 года. Владелец работы вскоре умер, и ее розыском занимались сыновья покойного. В сентябре 2006 года в Осло при невыясненных обстоятельствах нашлись две большие работы Мунка - \"Крик\" и \"Мадонна\", похищенные в 2004 году из музея художника. Норвежская полиция отрицала, что картины были возвращены за выкуп, а в прессе появились сообщения, что полотна появились благодаря сотрудничеству со следствием шведского преступника Давида Тоски.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (54,354,'Российским военным придется дольше ждать звездочек',2,'Увеличены сроки, в течение которых должны будут служить российские военные, чтобы получить следующее звание. Соответствующие изменения внесены в Положение о порядке прохождения военной службы Указом президента РФ Владимира Путина. Коснутся они как младших командиров, так и офицеров.','Увеличены сроки, в течение которых должны будут служить офицеры российской армии, чтобы получить следующее звание. Как пишет \"Российская газета\", соответствующие изменения внесены в Положение о порядке прохождения военной службы Указом президента РФ Владимира Путина. Изменения коснутся и младших командиров, и офицеров. Например, старшим сержантом можно будет стать, только отслужив три года, столько же понадобится лейтенанту чтобы стать старшим лейтенантом, а подполковнику, чтобы превратиться в полковника, понадобится пять лет. Прежней останется скорость служебного роста только у прапорщиков и мичманов. Также не изменился срок присвоения первичного командирского звания. Чтобы стать младшим сержантом или старшиной второй статьи, нужно прослужить пять месяцев. Внесенные изменения связаны с увеличением количества контрактников, а также сокращением военной службы по призыву до одного года - соответствующий указ был подписан ранее. То есть солдаты-срочники не успеют дослужиться до звания сержанта, и все командирские должности займут те, кто служит по контракту, то есть профессионалы. Кроме того, слишком быстрый служебный рост приводит к тому, что человек занимает вышестоящую должность, не успев дорасти до нее и не обладая необходимыми навыками. Указ вступит в силу 1 января 2008 года.',21,1174588081,1174588081);
INSERT INTO `news_news` VALUES (55,355,'Резервному фонду Кудрина не хватит российской нефти и газа',2,'Министр финансов Алексей Кудрин заявил, что в 2009 году Резервному фонду, который будет создан в 2008 году, будет не хватать доходов от экспорта нефти и газа для поддержания своего объема на плановом уровне в десять процентов ВВП. В 2008 году его величина составит почти 3,5 триллиона рублей.','Министр финансов Алексей Кудрин заявил, что в 2009 году Резервному фонду, который будет создан в 2008 году, будет не хватать доходов от экспорта нефти и газа для поддержания своего объема на плановом уровне в десять процентов ВВП, сообщает РИА Новости. Второе чтение законопроекта Минфина о Резервном фонде запланировано в Госдуме на конец марта. В документе предлагается расширить нефтяные доходы доходами от газа. Резервный фонд, согласно законопроекту Минфина, будет сформирован из Стабфонда 1 февраля 2008 года в размере 10 процентов от ВВП. Остальная часть Стабфонда пойдет по предложению Владимира Путина на формирование фонда будущих поколений. В 2008 году величина фонда составит почти 3,5 триллиона рублей. Ожидается, что средства Резервного фонда будут вкладываться в надежные ценные бумаги, а фонда будущих поколений - в более широкий диапазон финансовых инструментов, включающий в себя бумаги корпораций, сообщает ПРАЙМ-ТАСС. В Минфине также рассматривают возможность инвестирования средств фонда будущих поколений в недвижимость.',25,1174588081,1174588081);
INSERT INTO `news_news` VALUES (56,356,'Представитель КНДР не дождался денег и покинул переговоры',2,'Замглавы МИДа Северной Кореи, который представляет страну на шестисторонних переговорах по ядерной программе КНДР, покинул встречу в Пекине и вылетел в Пхеньян. Причиной, по которой переговоры в очередной раз были прерваны, стала задержка в процессе разблокирования счетов КНДР, ранее замороженных по требованию США.','Замглавы МИДа Северной Кореи Ким Ке Гван, который представляет страну на шестисторонних переговорах по ядерной программе КНДР, покинул встречу в Пекине и вылетел в Пхеньян, сообщает AFP. Причиной, по которой переговоры в очередной раз были прерваны, стала задержка в процессе разблокирования счетов КНДР, ранее замороженных по требованию США. 25 миллионов долларов, о которых идет речь, были заблокированы в банке китайского Макао в 2005 году в связи с обвинениями в фальшивомонетчестве и отмывании денег, с которыми в адрес Северной Кореи выступили Соединенные Штаты. Впоследствии обвинения не подтвердились, и США дали согласие на освобождение счетов. Однако КНДР так и не смогла получить доступ к этим средствам: в частности, возникли сложности при сборе заявлений северокорейских вкладчиков, необходимых для того, чтобы их средства перевели из Макао. Кроме того многие банки не желают принимать эти деньги, опасаясь финансовых санкций со стороны США. Глава российской делегации на шестисторонних переговорах Александр Лосюков, со своей стороны, не рекомендовал российским банкам принимать участие в этих операциях. Напомним, что в середине февраля 2007 года КНДР согласилась свернуть разработки в ядерной сфере в обмен на экономическую помощь, отмену санкций в отношении республики и, в частности, размораживание счетов в Макао. 20 марта Пхеньян заявил, что отказывается от участия в шестисторонних переговорах до тех пор, пока не получит доступ к средствам в китайском банке.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (57,357,'Оператор \"Острова\" посмертно получил профессиональную премию',2,'Премию в области киноизобразительного искусства \"Белый квадрат\" посмертно получил оператор Андрей Жегалов, чьей последней работой был фильм \"Остров\" Павла Лунгина. За эту картину его уже отметили \"Золотым Орлом\" и номинацией на \"Нику\". Почетную премию за вклад в кино получил Вадим Юсов, соавтор Андрея Тарковского.','Премию в области киноизобразительного искусства \"Белый квадрат\" посмертно получил оператор Андрей Жегалов, чьей последней работой был фильм \"Остров\" Павла Лунгина. Церемония награждения состоялась в Москве 21 марта 2007 года, сообщает \"Коммерсант\". Андрей Жегалов, скончавшийся в январе 2007 года в возрасте 42 лет, был одним из самых известных операторов отечественного кино: он снял такие картины, как \"Замок\" Алексея Балабанова, \"Особенности национальной охоты\", \"Блокпост\", \"Перегон\" и \"Кукушку\" Александра Рогожкина (последняя принесла ему Государственную премию), \"Турецкий гамбит\" Джаника Файзиева. Работа над \"Островом\" отмечена \"Золотым орлом\" и номинацией на \"Нику\". Кроме Жегалова на \"Белый квадрат\" были номинированы Сергей Мачильский (\"Связь\"), Максим Осадчий (\"Вдох-выдох\"), Сергей Астахов (\"Мне не больно\") и Владислав Гурчин (\"Гадкие лебеди\"). Почетную премию за вклад в искусство кино получил Вадим Юсов, снимавший с Андреем Тарковским \"Иваново детство\", \"Андрея Рублева\" и \"Солярис\", с Сергеем Бондарчуком \"Они сражались за Родину\" и другие известные картины.',18,1174588081,1174588081);
INSERT INTO `news_news` VALUES (58,358,'Совбез отказался продлить срок ультиматума Ирану',2,'Постоянные члены Совбеза ООН, приступившие к рассмотрению новой резолюции по ядерной программе Ирана, отклонили одну из поправок в документ, предусматривающую увеличение срока ультиматума о приостановке обогащения урана с 60 до 90 дней. Эту поправку предложил непостоянный член совета Южная Африка.','Постоянные члены Совбеза ООН, приступившие к рассмотрению новой резолюции по ядерной программе Ирана, отклонили одну из поправок в документ, предусматривающую увеличение срока ультиматума о приостановке обогащения урана с 60 до 90 дней, сообщает агентство AFP. Эту поправку предложил непостоянный член совета Южная Африка. В пятницу, 23 марта, Совбез рассмотрит еще ряд поправок в окончательный текст резолюции, предложенных не только южноафриканскими дипломатами, но и представителями Катара и Индонезии. ЮАР, в частности, предлагает ввести одновременный мораторий на санкции после приостановки Тегераном обогащения урана и отказаться от эмбарго на экспорт иранского оружия. Поправки других непостоянных членов Совбеза ООН носят в основном декларативный характер и призваны смягчить язык документа и подчеркнуть значение переговорных усилий \"шестерки\" с Ираном. Постоянный представитель РФ при ООН Виталий Чуркин заявил РИА Новости о том, что некоторые из предложенных непостоянными членами поправок в резолюцию по Ирану скорее всего будут приняты. Вместе с тем, он подчеркнул, что \"пятерка\" постоянных членов в разной степени готова к компромиссу, поэтому часть предложений будет отклонена. \"Есть возможность по некоторым вопросам пойти навстречу непостоянным членам СБ ООН, чтобы добиться единства при голосовании. Речь, безусловно, не идет об ужесточении текста\", - пояснил Чуркин. Он также заявил, что Россия в свою очередь рассчитывает получить от постоянных членов Совбеза закрепленные гарантии того, что новые санкции в отношении Ирана не затронут существующие контракты и не нанесут ущерба интересам России. Дипломат отметил, что новая резолюция может быть согласована к концу текущей недели. Представитель Катара в ООН Нассир Абдулазиз аль-Нассер (Nassir Abdulaziz al-Nasser) также заявил AFP, что на этой неделе документ в окончательном варианте вряд ли будет поставлен на голосование, поскольку для утверждения его текста необходимо больше времени. Напомним, в середине марта Совбез ООН согласовал текст резолюции, который ужесточает экономические санкции против Тегерана. В частности, запрещаются поставки вооружений из страны, а также замораживаются счета ряда иранских чиновников и предприятий. В течение 60 дней иранцы должны прекратить обогащение урана. В предыдущей резолюции срок ультиматума был таким же, однако Тегеран его проигнорировал. Ранее Виталий Чуркин заявил, что ограничения не коснутся ранее заключенных контрактов, в том числе связанных со строительством Россией АЭС в Бушере. На заседании Совбеза в Нью-Йорке, на котором будет приниматься резолюция, намерен присутствовать президент Ирана Махмуд Ахмадинеджад. США готовы предоставить ему визу.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (59,359,'Из сельского клуба украли портрет Путина',2,'В Пензенской области из сельского клуба украден портрет Владимира Путина. Украденная фотография висела в самом просторном зале клуба, где обычно проходят дискотеки и концерты. Как уточняет российская пресса, без снимка президента работа клуба фактически парализована.','В Пензенской области из сельского клуба украден портрет Владимира Путина, сообщает \"Комсомольская правда в Пензе\". Вместе с фотографией главы государства из клуба в селе Нарышкино Бековского района злоумышленники унесли еще три диска и микрофон, но оставили музыкальный центр, предварительно вытащив из него предохранитель. Украденный портрет висел в самом просторном зале клуба, где обычно проходят дискотеки и концерты. Как уточняют \"Новые Известия\", без президента работа клуба фактически парализована. \"Придут люди на концерт, увидят, что Путин пропал со стены и решат, что отношение к президенту у нас изменилось. А тут еще все разговоры о выборах 2008 года\", – объяснили изданию в сельской администрации. А в клубе пообещали приобрести новую картину в самое ближайшее время. Действия преступников подпадают под вторую часть статьи 158 УК РФ и могут быть квалифицированы как \"кража с незаконным проникновением в помещение\". Эта статья предусматривает наказание в виде лишения свободы до пяти лет и штраф в размере 200 тысяч рублей.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (60,360,'Из затопленной шахты \"Ульяновская\" откачивают воду',2,'На затопленном участке шахты \"Ульяновская\", в которой 19 марта произошел взрыв метана, начали откачивать воду. Кроме того продолжаются работы по расчистке выработок, восстановлению энергоснабжения и вентиляции. Из тех, кто находился в шахте в момент взрыва, двое по-прежнему считаются пропавшими без вести.','Утром 22 марта на затопленном участке шахты \"Ульяновская\", в которой 19 марта произошел взрыв метана, начались работы по откачке воды, сообщает \"Интерфакс\". Как пояснил начальник пресс-службы кемеровского областного управления МЧС Валерий Корчагин, водолазам, искавшим двух горняков, которые считаются пропавшими без вести, пришлось работать в очень сложных условиях: видимость в разрушенной шахте была минимальной, а страховочный трос позволял удаляться всего на 50 метров. В связи с этим, по словам Корчагина, и было принято решение откачать воду. Кроме того, как сообщил представитель МЧС, на \"Ульяновской\" продолжаются работы по расчистке выработок, восстановлению энергоснабжения и вентиляции. Как сообщалось ранее, в момент взрыва в шахте находились 203 человека: 93 из них были спасены, поиски еще двоих продолжаются. 108 горняков погибли, их тела уже подняты на поверхность, 86 из них опознаны. Похороны 60 погибших состоялись 22 марта. По версии Ростехнадзора, причиной взрыва в шахте могло стать проседание земной породы или же \"человеческий фактор\". Ранее представители ведомства предположили, что авария могла произойти из-за \"возможной ошибки в проектировании\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (61,361,'Джет Ли станет главным злодеем \"Мумии 3\"',2,'Кинокомпания Universal Pictures подтвердила, что Джет Ли сыграет роль главного злодея в третьей серии \"Мумии\", которую снимет режиссер Роб Коэн. Действие картины будет происходить после Второй мировой войны в Китае. Не обойдется и без знаменитых терракотовых воинов.','Кинокомпания Universal Pictures подтвердила, что Джет Ли сыграет роль главного злодея в третьей серии \"Мумии\", которую снимет режиссер Роб Коэн. Сюжет картины держится в секрете, однако, как сообщает The Hollywood Reporter, стало известно, что действие ее будет происходить после Второй мировой войны в Китае. Не обойдется и без знаменитых терракотовых воинов, охраняющих могилу императора. Напомним, что ранее сообщалось, что в проект вернутся исполнители главных ролей Брэндан Фрейзер и Рэйчел Уaйз. Но сюжет будет строиться вокруг приключений их подросшего сына. Бюджет картины составляет примерно 100 миллионов долларов.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (62,362,'Обзор рынков: ФРС США не изменила ставку рефинансирования',2,'Американские рынки 21 марта значительно укрепились. Dow Jones вырос сразу на 1,3 процента до 12447,52 пункта, Nasdaq - на 1,98 процента до 2455,92 пункта, а S&P 500 - на 1,71 процента до 1435,04 пункта. На торги повлияло решение ФРС США оставить ставку рефинансирования без изменений.','Американские рынки 21 марта значительно укрепились. Dow Jones вырос сразу на 1,3 процента до 12447,52 пункта, Nasdaq - на 1,98 процента до 2455,92 пункта, а S&P 500 - на 1,71 процента до 1435,04 пункта. При этом на Нью-Йоркской фондовой бирже NYSE подорожали 79 процентов акций. Федеральная резервная система США приняла решение в ближайшее время не менять ставку рефинансирования, что подтолкнуло инвесторов к покупке ценных бумаг американских компаний. Европейские индексы 21 марта закрылись разнонаправленно. Британский FTSE 100 поднялся на 0,58 процента до 6256,8 пункта, немецкий DAX увеличился на 0,18 процента до 6712,06 пункта, а французский CAC-40, наоборот, снизился на 0,02 процента до 5502,18 пункта. Французский индекс выглядел хуже других из-за того, что ряд топ-менежеров нефтяной компании Total 21 марта был допрошен финансовой полицией по подозрению в коррупции. Это вызвало понижение котировок Total. Российские биржи закончили торги 21 марта в плюсе. Индекс РТС поднялся на 0,88 процента до 1847,26 пункта, полностью отыграв падение, показанное днем ранее. Объем торгов был средним - на классическом рынке трейдеры заключили сделок на 43,9 миллиона долларов. Больше других на индекс оказали влияние акции РАО \"ЕЭС России\", подорожавшие на 3,07 процента, и ценные бумаги \"Сургутнефтегаза\", выросшие в цене на 4,91 процента. Из отраслевых индексов лучше всех оказалась \"Нефть и газ\". Этот показатель поднялся на 1,434 процента. Индекс ММВБ увеличился на 1,02 процента до 1646,07 пункта. Центральный банк РФ установил с 22 марта официальный курс доллара в размере 26,0335 рубля за один доллар, по сравнению с предыдущим показателем он понизился на 0,79 копейки. Доллар падает уже седьмую сессию подряд. Курс евро составил 34,6558 рубля, что на 1,29 копейки больше, чем днем ранее. На международном рынке курс евро повысился за день до 1,3386 доллара, британский фунт достиг отметки в 1,9680 доллара, а японская иена - 117,47 иены за доллар, отмечают эксперты NorthFinance По итогам торгов на NYMEX 21 марта баррель нефти WTI с поставкой в мае подорожал на 36 центов до 59,61 доллара. На Лондонской межконтинентальной бирже ICE апрельский контракт на нефть марки Brent, вырос в цене на 57 центов до 60,77 доллара за баррель. На торги оказал влияние отчет министерства энергетики США о сокращении в стране запасов автомобильного бензина. Природный газ с поставкой в апреле подорожал на 3,6 процента до 7,16 доллара за миллион британских термических единиц, сообщают эксперты K2kapital. Из новостей среды следует отметить уход со своего поста главы Росфинмониторинга Виктора Зубкова, а также принятие Госдумой закона об указании цен на товары и услуги только в рублях.',27,1174588082,1174588082);
INSERT INTO `news_news` VALUES (63,363,'Московское \"Динамо\" пробилось в четвертьфинал баскетбольной Евролиги',2,'Столичное \"Динамо\" в решающем матче турнира Топ-16 баскетбольной Евролиги обыграло итальянский \"Бенеттон\" со счетом 68:65 и пробилось в четвертьфинал турнира. На этой стадии турнира команда Душана Ивковича сыграет с греческим \"Панатинаикосом\". Ранее досрочно обеспечил себе выход в 1/4 финала московский ЦСКА.','Столичное \"Динамо\" в решающем матче турнира Топ-16 баскетбольной Евролиги обыграло итальянский \"Бенеттон\" со счетом 68:65 и пробилось в четвертьфинал турнира. Судьба матча решилась в овертайме, который бело-голубые провели чуть-сильнее. Стоит отметить, что \"Бенеттон\" тренирует наставник сборной России Дэвид Блатт. Ключевую роль в победе динамовцев сыграло выступление двух игроков, принесших большую часть очков и собравших большую часть подборов. Греческий легионер \"Динамо\" Антонис Фоцис набрал 22 очка и сделал 24 подбора. Греческий центровой бело-голубых Лазарос Попадопулос набрал 24 очка и сделал 11 подборов. Как сообщает официальный сайт Евролиги, Фоцис стал рекордсменом турнира по подборам в одном матче. Ранее рекорд принадлежал бывшему баскетболисту ЦСКА Мирсаду Туркану – 23 подбора. Кроме того, Фоцис стал всего лишь третьим игроком в истории Евролиги, которому в одном матче удалось набрать более 20 очков и сделать более 20 подборов. В своей группе \"Динамо\" набрало одинаковое количество очков с испанской \"Уникахой\", но уступило лидерство по дополнительным показателям. В четвертьфинале команда Душана Ивковича сыграет с одним из главным фаворитов турнира, греческим \"Панатинаикосом\". Напомним, что ранее в восьмерку сильнейших досрочно пробился действующий чемпион Евролиги, московский ЦСКА.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (64,364,'Организатора взрыва в суде обвинили в умышленном уничтожении имущества',2,'Организатору взрыва в здании Октябрьского районного суда Новосибирска в сентябре 2006 года предъявлено обвинение в умышленном уничтожении имущества. В прокуратуре считают, что Константин Шихавцов пытался уничтожить заведенное на него уголовное дело о совершении разбойного нападения.','Организатору взрыва в здании Октябрьского районного суда Новосибирска в сентябре 2006 года предъявлено обвинение по статье 167 части 2 УК РФ (умышленное уничтожение или повреждение имущества, совершенное путем поджога, взрыва или иным общеопасным способом), передает в четверг РИА Новости. Ранее судимый житель Новосибирска Константин Шихавцов был арестован решением суда. По версии следствия, Шихавцов и двое его объявленных в розыск сообщников ночью 3 сентября 2006 года залили через отверстия в окнах здания бензин и закачали через трубки бытовой газ, затем вставили фитили и подожгли их. Когда произошел взрыв, двухэтажное здание суда частично обрушилось и выгорело внутри, однако внутри никого не было, поэтому пострадавших не оказалось. В прокуратуре считают, что таким образом 35-летний Шихавцов пытался уничтожить заведенное на него уголовное дело о совершении разбойного нападения, рассмотрение которого должно было начаться в районном суде. Ущерб, нанесенный зданию, оценивается в 40 миллионов рублей, около 40 уголовных дел были частично испорчены огнем, а одно сгорело полностью. Причастность к взрыву обвиняемый отрицает.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (65,365,'Девять пограничников задержаны в связи с самоубийством матроса',2,'В Приморье взяты под стражу девять членов экипажа морской бригады пограничных кораблей, в отношении них возбуждено уголовное дело по статье 335 УК РФ (нарушение уставных правил), предусматривающей лишение свободы на срок от трех до десяти лет. Дедовщина на корабле обнаружилась после самоубийства 19-летнего матроса.','В Приморье взяты под стражу девять членов экипажа морской бригады пограничных кораблей, в отношении них возбуждено уголовное дело по статье 335 УК РФ (нарушение уставных правил), предусматривающей лишение свободы на срок от трех до десяти лет. Как сообщает в четверг РИА Новости со ссылкой на Тихоокеанскую пограничную военную прокуратуру, дедовщина на корабле обнаружилась после самоубийства 19-летнего матроса первого года службы. Следствие располагает данными об избиении старослужащими двенадцати молодых матросов, а общее количество инцидентов достигает 30. Пресс-служба Пограничного управления ФСБ России по Приморскому краю пока не комментирует следственные мероприятия в отношении морских пограничников.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (66,366,'Израиль утвердил название прошлогодней войны с Ливаном',2,'В среду члены израильской министерской комиссии под руководством министра без портфеля Яакова Эдери присвоили официальное название прошлогоднему конфликту Израиля с Ливаном. Он будет называться \"Второй Ливанской войной\", решение было принято под давлением родителей погибших израильских солдат.','В среду члены израильской министерской комиссии под руководством министра без портфеля Яакова Эдери (Yaacov Ederi) присвоили официальное название прошлогоднему конфликту Израиля с Ливаном. Как пишет Ha\'aretz, он будет называться \"Второй Ливанской войной\". Это наименование комиссия предпочла другим вариантам, среди которых упоминались \"Война на Севере\" и \"Северный Щит\". Процесс присвоения названия конфликту затянулся: власти предпочитали считать его \"операцией\", \"кампанией\" или \"военными действиями\". Лишь под давлением родителей израильских солдат, погибших в результате этих военных действий, в понедельник было принято решение о придании конфликту статуса войны. Первый конфликт с Ливаном до сих пор имеет статус \"операции\", что в конечном итоге не помешало израильским министрам назвать второе столкновение с этим государством \"второй войной\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (67,367,'Третий американский солдат сел в тюрьму за изнасилование иракской девочки',2,'В среду военный трибунал США приговорил 20-летнего рядового Брайана Говарда к пяти годам тюремного заключения за участие в изнасиловании и убийстве 14-летней иракской девушки из города Махмудия, а также расстреле членов ее семьи. Если он выполнит все условия соглашения со следователями, то проведет в тюрьме 27 месяцев.','В среду военный трибунал США приговорил 20-летнего рядового Брайана Говарда (Bryan Howard) к пяти годам тюремного заключения за участие в изнасиловании и убийстве 14-летней иракской девушки из города Махмудия, а также расстреле троих членов ее семьи, сообщает Associated Press. Говард признал свою вину и пообещал следствию дать показания против других участников преступления, избежав таким образом 15-летнего срока. Если он выполнит все условия соглашения, заключенного со следователями, то проведет в тюрьме лишь 27 месяцев. Ранее младший сержант Джеймс Баркер (James P. Barker) и сержант Пол Кортес (Paul E. Cortez) заявили под присягой, что 12 марта 2006 года они несколько раз по очереди изнасиловали Абир Касим Хамзе аль-Джахаби. В это время рядовой Стивен Грин (Steven Green) застрелил членов ее семьи, а затем и ее саму. Говард и рядовой Джесси Шпильман (Jesse V. Spielman) не принимали непосредственного участия в преступлении, но знали о нем и находились рядом. Баркер был приговорен к 90 годам тюремного заключения, а Кортес - к 100 годам, однако оба смогут добиваться условного освобождения после того, как отсидят первые десять лет. Заседание военного трибунала, на котором будет вынесен приговор Шпильману, намечено на 2 апреля.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (68,368,'В центре Москвы пять человек сгорели в автомобиле',2,'В результате дорожно-транспортного происшествия на Садовом кольце в Москве в ночь на четверг погибли пять человек. В 2:15 на Садово-Спасской улице произошло лобовое столкновения автомобиля \"Жигули\" и иномарки. После столкновения один из автомобилей загорелся, а его водитель и четыре пассажира сгорели внутри.','В результате дорожно-транспортного происшествия на Садовом кольце в Москве в ночь на четверг погибли пять человек, передает агентство \"Интерфакс\". По данным правоохранительных органов столицы, в 2:15 возле дома 19 по Садово-Спасской улице на внешней стороне кольца произошло лобовое столкновения автомобиля \"Жигули\" и иномарки. После столкновения один из автомобилей загорелся (по другим данным, загорелись оба). Водитель одной из машин и четыре его пассажира не успели выбраться из поврежденного автомобиля и сгорели в нем. Представитель столичной ГИБДД рассказал РИА Новости, что одна из машин выехала на полосу встречного движения и, по предварительной версии, причиной ДТП стало значительное превышение скорости водителем иномарки. На месте происшествия работают сотрудники прокуратуры и автоинспекции, которые пытаются выяснить обстоятельства случившегося.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (69,369,'Лидера басков оправдали сразу после ареста',2,'В среду испанская полиция арестовала Арнальдо Отеги, лидера политического крыла сепаратистской баскской организации ETA, после чего суд снял с него обвинения в пропаганде и оправдании терроризма и закрыл дело. Глава партии «Батасуна» был привлечен к ответственности за то, что назвал членов ETA настоящими патриотами.','В среду испанская полиция арестовала Арнальдо Отеги (Arnaldo Otegi), лидера политического крыла сепаратистской баскской организации ETA, после чего суд снял с него обвинения в пропаганде и оправдании терроризма и закрыл дело. Отеги вновь получил свободу, сообщает France Presse. Глава партии \"Батасуна\" был привлечен к ответственности за то, что на похоронах 22-летней террористки ETA Олайи Кастресаны (Olaya Castresana), погибшей от неосторожного обращения со взрывчаткой, он назвал членов ETA настоящими патриотами. По словам прокурора, подсудимый выразил \"свои убеждения излишне самоуверенно, однако это лишь мнение, которое может быть спорным, но не является криминальным\". Арест Арнальдо Отеги был вызван его отказом явиться в Мадрид на процесс, суд требовал для него 15-месячного тюремного заключения. Впрочем, за решетку лидер \"Батасуны\" все равно бы не попал - все приговоры на срок менее двух лет в Испании заменяются условным наказанием. В ноябре 2005 года Отеги уже был приговорен к году \"тюрьмы\" за то, что назвал короля Хуана Карлоса \"главным мучителем\" басков. Отеги также подал апелляцию на другой обвинительный приговор, вынесенный ему в прошлом году за симпатию еще к одному члену ETA, Хосе Мигелю Беналарану (Jose Miguel Benalaran). Верховный суд Испании рассмотрит апелляцию после муниципальных выборов 27 мая, в которых надеется принять участие \"Батасуна\". Правительство намерено допустить участие политического крыла ETA в выборах лишь после того, как его представители официально осудят насильственные методы ведения борьбы. В четверг исполняется год перемирию, объявленному ETA и нарушенному за это время один раз - от взрыва бомбы в аэропорту Мадрида 30 декабря 2006 года погибли два человека.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (70,370,'Таможенники напомнили о запрете на пересылку паспортов за границу',2,'Федеральная таможенная служба России разъяснила в среду, что высылать из РФ почтой паспорта, свидетельства о рождении, военные билеты и другие документы, удостоверяющие личность, а также трудовые книжки не разрешается. Соответствующие положения закреплены в федеральном законе \"О почтовой связи\" и Таможенном кодексе.','Федеральная таможенная служба (ФТС) России напомнила в среду, что высылать из РФ почтой удостоверения личности не разрешается, передает агентство \"Интерфакс\". Как говорится в разъяснении ФТС, пересылка в международном почтовом отправлении не допускается. Также запрещен вывоз указанных документов за пределы РФ в несопровождаемом и пересылаемом багаже, в том числе экспресс-перевозчиками. В разъяснении ФТС ссылается на нормы федерального закона \"О почтовой связи\", Таможенного кодекса, а также закона от 1991 года \"О порядке вывоза, пересылки и истребования личных документов советских и иностранных граждан и лиц без гражданства из СССР за границу\", уточняет агентство.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (71,371,'Португальские ротвейлеры загрызли эмигрантку из Украины',2,'В среду в окрестностях Лиссабона четыре ротвейлера загрызли пожилую эмигрантку из Украины, когда та шла на работу. Полицейским пришлось несколько раз выстрелить в воздух, чтобы отогнать собак от женщины. От полученных травм она скончалась по пути в больницу.','В среду в португальском городе Синтра (Sintra) в окрестностях Лиссабона четыре ротвейлера загрызли пожилую эмигрантку из Украины, когда та шла на работу, передает агентство France Presse. Полицейским пришлось несколько раз выстрелить в воздух, чтобы отогнать собак от 60-летней женщины. От полученных травм она скончалась по пути в больницу. Как выяснилось, животные, проживавшие в одном из окрестных домов, сумели выбраться из-за ограды на улицу. Их отвезли в собачий приют, где вскоре усыпят. Ротвейлеры относятся к группе из семи опасных пород собак, содержание которых, в соответствии с законами Португалии, регламентируется местными властями. Полиции предстоит проверить, имел ли право владелец держать агрессивных животных дома.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (72,372,'При пожаре в московском кафе погиб человек',2,'В результате пожара в кафе на юго-востоке Москвы погиб человек. Возгорание в одноэтажном кафе, расположенном на улице Хлобыстова недалеко от станции метро \"Выхино\", произошло около 24.00. В здании обрушилась крыша, площадь пожара превышала 300 квадратных метров. В ликвидации возгорания участвовали 10 пожарных расчетов.','В результате пожара в кафе на юго-востоке Москвы погиб человек, передает в четверг РИА Новости. Возгорание в трехэтажном кафе, расположенном на улице Хлобыстова недалеко от станции метро \"Выхино\", произошло около полуночи. По словам представителя МЧС, в здании обрушилась крыша, площадь пожара превышала 300 квадратных метров. В ликвидации возгорания участвовали 10 пожарных расчетов. При тушении они обнаружили тело погибшего.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (73,373,'Поиски пропавшего в Коми Ми-8 возобновятся утром',2,'Принадлежавший \"Газпромавиа\" вертолет Ми-8, пропавший в среду днем в республике Коми, попал в аварию или произвел аварийную посадку. По словам представителя \"Газпрома\", полет совершался по заказу \"Севергазпрома\", но пассажир не являлся сотрудником этой организации. На борту вертолета находились шесть человек.','Принадлежавший \"Газпромавиа\" вертолет Ми-8, пропавший в среду днем в республике Коми, попал в аварию или произвел аварийную посадку. Об этом сообщили РИА Новости в компании \"Газпром\". Напомним, на борту вертолета находились пять членов экипажа и один пассажир. По словам представителя компании, полет совершался по заказу \"Севергазпрома\", но пассажир не являлся сотрудником этой организации. Связь с Ми-8 была потеряна в 15:00 по московскому времени, вертолет возвращался в Ухту после отправки группы рабочих на пункт экологического контроля. С наступлением темного времени суток попытки отыскать Ми-8 были прекращены, их возобновление запланировано на утро четверга.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (74,374,'Элтон Джон отпразднует день рождения в интернете',2,'Элтон Джон отпразднует день рождения, выложив в сеть около четырехсот песен с тридцати альбомов. 25 марта 2007 года музыканту исполнится 60 лет. Все треки будут доступны пользователям службы iTunes с 26 марта по 30 апреля 2007 года. Также 25 марта в продажу поступит коллекция хитов Rocket Man : The Definitive Hits.','Элтон Джон отпразднует очередной день рождения, выложив в сеть более тридцати своих альбомов, сообщает International Herald Tribune. 25 марта 2007 года музыканту исполнится 60 лет. В общей сложности будут доступны более четырехсот песен, записанных за почти сорок лет. Напомним, что первая пластинка Элтона Джона под названием Open Sky появилась в 1969 году. Все треки будут доступны пользователям службы iTunes с 26 марта по 30 апреля 2007 года. Также музыкант планирует распространять через сетевые сервисы свои самые популярные видеоклипы, а некоторые из синглов превратить в мелодии для мобильных телефонов. Кроме того, в день рождения исполнителя в продажу поступит коллекция его песен, занимавших первые места в чартах, дополненная концертными записями и видеоклипами. Сборник получил название Rocket Man: The Definitive Hits.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (75,375,'Болезнь жены не помешает Эдвардсу бороться за президентское кресло',2,'Кандидат в президенты США Джон Эдвардс заявил, что продолжит кампанию, несмотря на плохое состояние здоровья его жены. Супруга Эдвардса, Элизабет, рассказала, что у нее обнаружен рецидив рака груди, излеченного в 2004 году, однако она полностью поддерживает решение мужа продолжать борьбу за главный пост страны.','Сенатор-демократ Джон Эдвардс, вступивший в предвыборную гонку за пост президента США, заявил в эфире CNN, что продолжит кампанию, несмотря на плохое состояние здоровья его жены. Супруга Эдвардса, Элизабет, рассказала, что у нее обнаружен рецидив рака груди, излеченного в 2004 году, однако она полностью поддерживает решение мужа продолжать борьбу за главный пост страны.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (76,376,'Главный тренер \"Ливерпуля\" отказался возглавить \"Реал\"',2,'Наставник английского \"Ливерпуля\" Рафаэль Бенитес опроверг слухи о своем переходе по окончании нынешнего сезона в мадридский \"Реал\". На официальном сайте мерсисайдского клуба он подтвердил, что продолжит свою работу в \"Ливерпуле\", хотя признал, что тренировать \"Реал\" – большая честь для любого тренера.','Наставник английского \"Ливерпуля\" Рафаэль Бенитес опроверг слухи о своем переходе по окончании нынешнего сезона в мадридский \"Реал\". На официальном сайте мерсисайдского клуба он подтвердил, что продолжит свою работу в \"Ливерпуле\", хотя признал, что тренировать \"Реал\" – большая честь для любого тренера. \"Хочу успокоить болельщиков – я полностью посвящаю себя работе в \"Ливерпуле\" и не собираюсь никуда уходить. Конечно, работать в \"Реале\" – большая честь, тем более что Мадрид – мой родной город, но я счастлив в Англии и надеюсь, что мой нынешний клуб ждет отличное будущее\". Новый владелец \"Ливерпуля\" Том Хикс вместе со своим компаньоном Джорджем Джиллеттом намерен обсудить с Бенитесом вопрос о продлении контракта 31 марта, когда мерсисайдцы сыграют с \"Арсеналом\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (77,377,'Приостановлено движение по Серпуховско-Тимирязевской ветке московского метро',2,'Движение на Серпуховско-Тимирязевской линии московского метрополитена временно приостановлено из-за падения человека на рельсы. Поезда не идут в направлении центра от станции \"Савеловская\", где и произошел инцидент.','Движение на серой ветке московского метрополитена временно приостановлено из-за падения человека на рельсы, сообщает корреспондент Lenta.Ru. Поезда не идут в направлении центра от станции \"Савеловская\", где и произошел инцидент. Известно, что пострадавший - мужчина. О его состоянии пока ничего не сообщается. Наш корреспондент сообщает, что на станции скопилось большое количество людей. С пяти до восьми часов вечера в московском метро - традиционный час-пик.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (78,378,'Правительство нашло еще трех претендентов на средства Инвестфонда',2,'Правительственная комиссия по инвестиционным проектам одобрила еще три проекта, которые будут построены с помощью средств Инвестфонда. Государство поможет в возведении перегрузочного комплекса в балтийском порту Усть-Луга, реконструкции объектов водоснабжения в Ростовской области и строительству железной дороги в Туве.','Правительственная комиссия одобрила еще три проекта, которые будут построены с помощью средств Инвестфонда. Чиновники сочли соответствующими всем необходимым условиям заявки на возведение многопрофильного перегрузочного комплекса \"Юг-2\" в балтийском порту Усть-Луга, реконструкцию и строительство объектов водоснабжения в Ростовской области, а также железной дороги в Туве. Об этом сообщил глава правительственной комиссии и министр экономического развития Герман Греф. Его слова передает РИА Новости. Общая стоимость трех проектов составляет 162 миллиарда рублей. 56 миллиардов рублей будет выделено из Инвестфонда. Общая же стоимость всех 12 проектов, которые финансируются с помощью госфонда, превысила триллион рублей. Из них государство вложит 286 миллиардов рублей. По мнению Грефа, самым важным из одобренных проектов является железнодорожная линия Кызыл-Курагино. Она позволит соединить столицу Тувы Кызыл с всей железнодорожной сетью России. Предполагается, что после реализации проекта ВВП Тувы удвоится, а налоговая база увеличится в 4 раза. Проект в Усть-Луге предполагает создание 700 новых рабочих мест, а прямые поступления в федеральных бюджет составят 8 миллиардов рублей, отметил Греф. Терминал на Балтике позволит принимать суда с легковыми автомобилями на борту, что сделает их доставку в Москву значительно дешевле. Проект в Ростовской области создаст условия для строительства 12 тысяч квадратных метров недвижимости, что позволит обеспечить жильем около 400 тысяч человек. Инвестфонд был образован в ноябре 2005 года. Он состоит из средств, полученных бюджетом от высоких цен на нефть на мировых рынках. За три года планируется потратить 377 миллиардов рублей Инвестфонда.',25,1174588082,1174588082);
INSERT INTO `news_news` VALUES (79,379,'Самолеты А350 на пять процентов будут российскими',2,'Европейский концерн EADS и ОАО \"Объединенная авиастроительная корпорация\" подписали соглашение, согласно которому Россия будет выполнять пять процентов работ по производству и проектированию самолетов А350. В настоящее время стороны ведут переговоры о том, какие именно компоненты А350 будут производиться в России.','Европейский концерн EADS и ОАО \"Объединенная авиастроительная корпорация\" подписали соглашение, согласно которому Россия будет выполнять пять процентов работ по производству и проектированию самолетов А350. Об этом сообщает \"Интерфакс\". В настоящее время стороны ведут переговоры о том, какие именно компоненты А350 будут производиться в России. Также было подписано соглашение о создании в Дрездене совместного предприятия для организации в подмосковном городе Луховицы и в Дрездене центров, в которых будут переделывать пассажирские самолеты A320 в грузовые. Кооперация с Airbus стала возможной после того, как Россия вошла в состав акционеров EADS – единственного акционера компании. В сентябре было объявлено, что государственный банк ВТБ скупил 5 процентов акций европейского концерна.',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (80,380,'Епископальная церковь США отказалась подчиниться Англиканской',2,'Американская Епископальная церковь отвергла предложение Сообщества англиканских церквей об учреждении международного надзорного органа, который бы контролировал деятельность церквей на территории США. Такое решение было принято на конференции лидеров Епископальной церкви, прошедшей в Хьюстоне.','Американская Епископальная церковь отвергла предложение Сообщества англиканских церквей об учреждении международного надзорного органа, который бы контролировал деятельность церквей на территории США. Как сообщает LA Times, такое решение было принято на конференции лидеров Епископальной церкви, прошедшей в Хьюстоне. Ее участники не прокомментировали требование Англиканской церкви прекратить практику возведения в сан лиц нетрадиционной сексуальной ориентации и благословения однополых гражданских союзов. В то же время, в резолюции, принятой по итогам конференции, говорится: \"Мы провозглашаем, что все дети Божие, в том числе геи и лесбиянки, являются полноправными участниками жизни церкви Христовой\". Архиепископ Кентерберийский Роуэн Уильямс, являющийся духовным лидером Англиканской церкви, выразил свое разочарование решением коллег из США. \"Нам еще предстоит обсудить эти важные вопросы. Никто толком не представляет, с какими вызовами нам придется столкнуться в будущем\", - сказал он. Напомним, что на прошедшем в конце февраля в Танзании конгрессе лидеров 38 англиканских церквей было принято постановление, в котором в ультимативной форме было рекомендовано Епископальной церкви США отказаться от практики рукоположения гомосексуалистов. Американская церковь должна дать ответ до 30 сентября 2007 года.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (81,381,'США направили к берегам Кореи новейший авианосец',2,'Военно-морские силы США направили к берегам Южной Кореи новейший атомный авианосец \"Рональд Рейган\" в сопровождении ракетного крейсера и двух эсминцев. Авианосная ударная группа примет участие в совместных учениях вооруженных сил США и Южной Кореи, которые начнутся 25 марта 2007 года.','ВМС США направили к берегам Южной Кореи новейший атомный авианосец, сообщает Defencetalk. Авианосец \"Рональд Рейган\" в сопровождении ракетного крейсера и двух эсминцев примет участие в крупнейших военных учениях на территории Южной Кореи. В учениях будут задействованы также американские войска, размещенные на полуострове. Учения, которые должны стартовать 25 марта, вызвали острую реакцию Северной Кореи. Пхеньян обвинил США и Южную Корею в нагнетании напряженности в регионе и стремлении сорвать процесс шестисторонних переговоров по корейской ядерной проблеме. CVN-76 Ronald Reagan вошел в строй в 2003 году и стал девятым авианосцем типа \"Честер Нимитц\". Водоизмещение корабля превышает 100 тысяч тонн, скорость полного хода составляет 32 узла. На авианосце базируются истребители F/A-18 Hornet и Super Hornet, самолеты радиоэлектронной борьбы EA-6B, \"летающие радары\" E-2C, противолодочные самолеты Viking и вертолеты. Численность авиакрыла превышает 70 машин.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (82,382,'Прокуратура обжаловала перевод Ходорковского и Лебедева в Москву',2,'Генпрокуратура РФ 22 марта обжаловала решение Басманного суда, который 20 марта признал незаконным проведение предварительного следствия по новому уголовному делу против Михаила Ходорковского и Платона Лебедева в Чите и принял решение провести следственные действия в Москве, по месту инкриминируемых деяний.','Генеральная прокуратура России 22 марта обжаловала решение Басманного суда, который 20 марта признал незаконным проведение предварительного следствия по новому уголовному делу против Михаила Ходорковского и Платона Лебедева в Чите, передает РИА Новости. Басманный суд постановил, что следственные мероприятия по делу бывшего главы \"ЮКОСа\" Ходорковского и бывшего председателя совета директоров группы \"МЕНАТЕП\" Лебедева должны проводиться в Москве, по месту инкриминируемых им деяний. Однако до рассмотрения поданного Генпрокуратурой представления на решение Басманного суда вердикт не сможет вступить в силу. Со своей стороны, адвокат Ходорковского Юрий Шмидт ранее заявлял, что считает маловероятным возможность обжалования судебного решения. \"Это решение блестяще мотивировано. Я просто не представляю к чему здесь можно зацепиться, чтобы его обжаловать\", - добавил он. Напомним, что в рамках нового уголовного дела экс-глава \"ЮКОСа\" и руководитель МФО \"МЕНАТЕП\" обвиняются в том, что в период c 1998 по 2004 год похитили нефти на астрономическую сумму - 850 миллиардов рублей. Защита Ходорковского и Лебедева расценила выдвинутые обвинения не только как абсурдные, но и как безумные. Юрий Шмидт заявил, что приводимые прокуратурой цифры - больше выручки компании и отметил, что \"украсть такую сумму невозможно никому, нигде и никогда\".',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (83,383,'Египетские чиновники успокоили россиян',2,'Председатель Государственной организации туризма Египта Ахмед Эль-Хадем сообщил на пресс-конференции в Москве, что вопрос о полетах российских самолетов Ил-86 на территории этой страны решается. Чиновник выразил уверенность, разрешение на полеты самолетов этого типа будет продлено. \"З','Председатель Государственной организации туризма Египта Ахмед Эль-Хадем заявил на пресс-конференции в Москве, что вопрос о полетах Ил-86 на территории этой страны будет решен в пользу России. Как передает РИА Новости, чиновник выразил уверенность, что разрешение на полеты самолетов этого типа будет продлено. \"Запрета вводиться не будет\", - сказал он. \"Я два дня назад разговаривал с представителями соответствующих структур Египта и просил, чтобы их ответ на запрос российской стороны был положительным. Надеюсь, что он будет положительным\", - пояснил Эль-Хадем. Использование Ил-86 запрещено в ряде стран из-за несоответствия современным стандартам по экологическим параметрам. Египетские власти также неоднократно выражали недовольство полетами этих самолетов на своей территории. Однако, по словам Эль-Хадема, египтяне готовы пойти на встречу российским авиакомпаниям, поскольку большинство туристов из России прибывают чартерными рейсами с использованием Ил-86. Ранее российская сторона просила продлить полеты до конца февраля 2007 года, и эта просьба была удовлетворена. \"Сейчас мы даем разрешение на каждый отдельный рейс на самолетах Ил-86 в Египет\", - сообщил египетский чиновник. Он также рассказал, что организаторы чартерных рейсов попросили продлить использование самолетов еще на год, чтобы успеть сменить их на более современные. По этому вопросу сейчас ведутся переговоры. В то же время корреспондент РИА Новости сообщает из Каира, ссылаясь на анонимный источник в министерстве гражданской авиации Египта, что решение по Ил-86 будет принято до конца месяца, поскольку действующее разрешение заканчивается 31 марта 2007 года. Источник также полагает, что \"беспокоится не стоит\". Ранее сообщалось, что египетские власти намерены запретить полеты Ил-86 на своей территории уже с 1 мая 2007 года.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (84,384,'Генсек ООН пережил обстрел в прямом эфире',2,'Во время пресс-конференции в Багдаде с участием генсека ООН Пан Ги Муна и премьер-министра Ирака Нури аль-Малики недалеко от здания, где проходила встреча, взорвалась мина. Глава ООН вздрогнул и пригнулся. Минометная мина взорвалась в 50 метрах от помещения, где проходила встреча с журналистами.','Во время пресс-конференции в Багдаде с участием генсека ООН Пан Ги Муна и премьер-министра Ирака Нури аль-Малики недалеко от здания, где проходила встреча, взорвалась мина. Глава ООН, как сообщает агентство AFP, вздрогнул и пригнулся. По сведениям Sky News, обстрел велся из миномета. По словам очевидцев, мина взорвалась в 50 метрах от помещения, где проходила конференция генсека ООН, рядом с офисом Нури аль-Малики. О пострадавших ничего не сообщается. Как отмечает телеканал, сверху на Пан Ги Муна посыпались мелкие крошки штукатурки. Один из сотрудников службы безопасности попытался увести Нури аль-Малики, однако он отказался уходить, сказав, что не стоит этого делать. Взрыв на короткое время прервал пресс-конференцию, однако вскоре она была продолжена. Генсек ООН прибыл в Багдад неожиданно, поскольку ранее из соображений безопасности этот визит не объявлялся. Ирак стал первой страной в десятидневной ближневосточной поездке Пан Ги Муна. Он также намерен посетить Израиль, Палестину, Иорданию, Ливан и Саудовскую Аравию. Последний раз в ноябре 2005 года в Ирак приезжал прежний генсек Кофи Аннан.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (85,385,'Бертон получит награду Венецианского фестиваля',2,'Известный режиссер Тим Бертон получит награду за вклад в развитие киноиндустрии на следующем Венецианском кинофестивале, который начнется 29 августа 2007 года. Организаторы фестиваля провозгласили 5 сентября днем Бертона и пообещали представить некий сюрприз. Возможно речь идет о картине \"Суини Тодд\".','Известный режиссер Тим Бертон получит награду за вклад в развитие киноиндустрии на следующем Венецианском кинофестивале, который начнется 29 августа 2007 года, сообщает Reuters. Организаторы фестиваля провозгласили 5 сентября днем Бертона и пообещали представить некий сюрприз. Вполне возможно, что речь идет о премьере фильма \"Суини Тодд\", который режиссер снимает на момент написания статьи. Главную роль в картине играет Джонни Депп. Ранее во время Венецианских фестивалей проводились международные премьеры таких фильмов Бертона, как \"Кошмар перед Рождеством\" и \"Труп невесты\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (86,386,'Поиски пропавшего Ми-8 временно прекращены',2,'Поиски вертолета Ми-8, пропавшего в среду в республике Коми, временно прекращены. Это связано с ухудшением погоды в Вуктыльском районе, где велись поисковые работы. Связь с вертолетом была потеряна в 15 часов по московскому времени. На борту находилось пять членов экипажа и один пассажир.','Поиски вертолета Ми-8, пропавшего в среду в республике Коми, временно прекращены. Как передает \"Интерфакс\" со ссылкой на представителя оперативного штаба, это связано с ухудшением погоды в Вуктыльском районе, где велись поисковые работы. Связь с вертолетом, принадлежащим \"Газпромавиа\", была потеряна 21 марта в 15 часов по московскому времени. На борту находилось пять членов экипажа и один пассажир.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (87,387,'Евросоюз обвинил Вашингтон в незаконной поддержке Boeing',2,'Евросоюз на слушаниях в рамках Всемирной торговой организации обвинил власти США в том, что они выдали авиакомпании Boeing субсидий на 23,7 миллиардов долларов с 1990 года. Стоит отметить, что Евросоюз подал в ВТО жалобу в ответ на действия Вашингтона, который обвинили Брюссель в господдержке Airbus.','Представители Евросоюза на слушаниях в рамках Всемирной торговой организации обвинили власти США в том, что они выдали авиакомпании Boeing субсидий на 23,7 миллиарда долларов с 1990 года. Об этом сообщает AFP. Стоит отметить, что Евросоюз подал в ВТО жалобу в ответ на действия Вашингтона, который обвинил Брюссель в незаконной поддержке авиакомпании Airbus. Американцы 21 марта заявили, что Airbus получил от стран Евросоюза 15 миллиардов долларов субсидий. При этом, по данным властей США, общая сумма субсидий за последние 30 лет превышает 100 миллиардов. В Вашингтоне утверждают, что страны Евросоюза предоставляли Airbus долгосрочные кредиты по заниженным ставкам. Ожидается, что ВТО вынесет свое решение по претензиям США к Airbus в конце 2007 года, однако, по мнению специалистов, слушания могут затянуться. Решение ВТО по Boeing ожидается не ранее весны 2008 года. Стоит отметить, что в 2006 году Boeing впервые за шесть лет обошел Airbus по количеству заказов новых самолетов. Руководство европейского концерна, чтобы снизить издержки, придумало план Power8, согласно которому с заводов Airbus будет уволено 10 тысяч человек.',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (88,388,'Партия регионов получила доказательства допросов Тимошенко в США',2,'Партия регионов Украины получила документы, которые подтверждают, что во время недавнего визита в США лидер БЮТ Юлия Тимошенко была допрошена в связи с делом бывшего премьер-министра Украины Павла Лазаренко. Об этом заявил депутат Верховной Рады из фракции \"регионалов\" Василия Киселев. При этом он выразил недоумение тем, что Тимошенко выпустили из США.','Партия регионов Украины получила документы, которые подтверждают, что во время недавнего визита в США лидер БЮТ Юлия Тимошенко была допрошена в связи с делом бывшего премьер-министра Украины Павла Лазаренко. Об этом заявил депутат Верховной Рады, первый заместитель главы фракции \"регионалов\" Василия Киселев. Как ранее сообщалось, Тимошенко посетила Соединенные Штаты в начале марта этого года. По словам Киселева, утверждения посла США на Украине Уильяма Тейлора о том, что никакой связи между Тимошенко и Лазаренко не установлено, далеки от истины. \"Когда мы получили документы, которые подтверждают, что посол США, к сожалению, сказал не всю правду или его ввели в заблуждение, потому что у нас в руках документы, которые подтверждают, что госпожа Тимошенко вызывалась на допросы американским прокурором Мартой Берш, эти документы имеются\", - пояснил депутат. Он выразил недоумение тем, что, несмотря на интерес к персоне Тимошенко со стороны американского правосудия, лидер БЮТ все же была выпущена из США. Киселев также спрогнозировал, что теперь Тимошенко приложит все усилия, чтобы не дать работать Верховной Раде, \"потому что она боится ответственности\". \"Она боится, что если мы сегодня раскрутим до конца то, что в свое время по политическому решению было прекращено, то ей придется сидеть рядом с теми, кто сегодня уже сидит\", - заявил \"регионал\", добавив, что \"отвечает за свои слова\". В ближайшее время специальная комиссия Верховной рады Украины, которая расследует деятельность Юлии Тимошенко в период ее руководства \"Едиными энергосистемами Украины\" (ЕЭСУ), планирует обнародовать данные Министерства юстиции США о причастности Юлии Тимошенко к хищениям государственных средств совместно с Павлом Лазаренко. Напомним, в сентябре прошлого года американский суд приговорил Лазаренко к девяти годам лишения свободы и штрафу в 10 миллионов долларов за вымогательство и отмывание денег. Экс-премьер, возглавлявший украинское правительство в середине 90-х годов, попросил политического убежища в США в 1999 году, однако вместо предоставления убежища американские власти выдали ордер на его арест. Юлия Тимошенко руководила компанией ЕЭСУ во время премьерства Лазаренко в 90-х годах. Ранее представители Партии регионов неоднократно пытались установить связь между деятельностью Лазаренко и лидером БЮТ, однако эти обвинения были отвергнуты не только Тимошенко, но и находящимся в заключении экс-премьером.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (89,389,'Писатели вступились за лондонский книжный магазин для геев',2,'Британские и американские писатели включились в кампанию по защите последнего в Лондоне и единственного в Великобритании книжного магазина, ориентированного на сексуальные меньшинства. Владельцы расположенного в Блумсбери магазина \"Gay\'s The Word\" не могут оплатить аренду: ставки растут, а продажи падают.','Британские и американские писатели включились в кампанию по защите последнего в Лондоне и единственного в Великобритании книжного магазина, ориентированного на сексуальные меньшинства. Как сообщила газета The Guardian, владельцы расположенного в районе Блумсбери магазина \"Gay\'s The Word\" не могут оплатить аренду: им нужно за два месяца собрать 20 тысяч фунтов стерлингов (чуть меньше 40 тысяч долларов), а продажи книг резко упали. Писательница Али Смит (Ali Smith), лауреатка Уитбредовской премии, автор романа \"Отель - мир\", заявила, что закрытие \"Gay\'s The Word\" означает \"политическую, культурную, общественную и человеческую потери\". Дважды номинировавшаяся на Букеровскую премию Сара Уотерс (Sarah Waters), автор \"Тонкой работы\", присоединилась к Смит, отметив, что магазин в Блумсбери - одна из самых \"человечных\" достопримечательностей Лондона. Эдмунд Уайт (Edmund White), написавший \"Историю одного мальчика\", назвал \"Gay\'s The Word\" уникальным магазином с выдающимся персоналом. Постоянными посетителями магазина являются известные художники Гилберт и Джорж, актер и писатель Саймон Кэллоу и многие другие. \"Gay\'s The Word\" открылся в 1979 году. В 1984-ом его пытались закрыть за импорт \"литературы непристойного содержания\", но дело развалилось: суд не признал преступлением ввоз книг Алена Гинзберга, Гора Видала и Теннеси Уильямса. Магазин славен не только исключительно богатым ассортиментом книг и периодики, но и регулярными встречами с писателями.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (90,390,'Джон Маккейн возглавит борьбу с социализмом',2,'Кандидат в президенты США от Республиканской партии Джон Маккейн пообещал в случае его избрания обратить пристальное внимание на страны Латинской Америки, чтобы не допустить распространение социализма в регионе. По его мнению, США должны активнее экспортировать ценности капитализма и демократии.','Кандидат в президенты США от Республиканской партии Джон Маккейн пообещал в случае его избрания обратить пристальное внимание на страны Латинской Америки, чтобы не допустить распространение социализма в регионе, сообщает AP. Выступая перед ветеранами организованной ЦРУ в 1961 году операции в Заливе Свиней, целью которой являлось свержение режима Фиделя Кастро, Маккейн пообещал, что первыми его внешнеполитическими действиями в качестве президента станут визиты в Мексику и другие страны региона. По нению сенатора, \"война в Ираке отвлекла внимание США от их собственного полушария, и теперь они вынуждены расплачиваться за это\". \"Мы все должны понимать, что между Чавесом, Моралесом и Кастро существует тесная связь. Они вдохновляют друг друга, они помогают друг другу. Это нас очень беспокоит\", - посетовал Маккейн. По его мнению, США должны активнее экспортировать в Латинскую Америку ценности капитализма и демократии, чтобы выиграть \"эту войну идей\".',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (91,391,'Акционеры японской Nikko вновь отказались продать ее Citigroup',2,'Harris Associates LP, крупнейший акционер брокера Nikko Cordial, третьего по величине в Японии, вновь отказался продать компанию американской банковской группе Citigroup. В Harris, которая владеет 7,5 процентами акций Nikko, заявили, что не намерены принимать предложение Citigroup в 13,4 миллиарда долларов.','Harris Associates LP, крупнейший акционер брокера Nikko Cordial, третьего по величине в Японии, вновь отказался продать компанию американской банковской группе Citigroup. Об этом сообщает Bloomberg. В Harris, которая владеет 7,5 процентами акций Nikko, заявили, что не намерены принимать предложение Citigroup в 13,4 миллиарда долларов. По мнению японской стороны, компания стоит дороже. Стоит отметить, что компания Mizuho Financial Group, которая владеет 4,8 процентами ценных бумаг Nikko, приняла новое предложение Citigroup. Ранее Citigroup предлагала за японского брокера 10,8 миллиарда долларов. Повышение цены произошло после того, как Токийская фондовая биржа решила не снимать акции компании с торгов из-за скандала вокруг финансовой отчетности Nikko, разразившегося в Японии в 2006 году. В настоящее время Citigroup уже принадлежит 4,9 процента акций Nikko. Если компания выкупит контрольный пакет в японской компании, то ей достанется более ста отделений брокера в Японии.',27,1174588082,1174588082);
INSERT INTO `news_news` VALUES (92,392,'В Турции пропали еще несколько иранских офицеров',2,'Генерал Али Реза Асгари стал не единственным высокопоставленным иранским военным, оказавшимся на Западе за последнее время. Как сообщает MEMRI со ссылкой на турецкую газету Yeni Safak, \"похищены\" еще два офицера армии Исламской республики - полковник Амир Мухаммад Ширази и генерал Мухаммад Султани.','Генерал Али Реза Асгари стал не единственным высокопоставленным иранским военным, оказавшимся на Западе за последнее время. Как сообщает MEMRI со ссылкой на турецкую газету Yeni Safak, \"похищены\" еще два офицера - полковник Амир Мухаммад Ширази (Amir Muhammad Shirazi) и генерал Мухаммад Султани (Muhammad Sultani). По данным издания, это произошло в результате совместной операции израильских и американских спецслужб на территории Турции. \"Известно, что пять военных выехали из Ирана в пятницу 16 марта и прибыли в Турцию на следующий день. 18 марта они были переданы в руки ЦРУ и \"Моссада\". Были ли среди них Ширази и Султани, пока неизвестно\", - пишет газета. Кроме того, издание пояснило, что если американцы и израильтяне действительно систематически похищают иранских военных, то ситуация может перерасти в серьезное столкновение, \"так как иранцы обладают человеческими и техническими ресурсами для нанесения удара по любым американским и израильским целям или ответных похищений в любой точке мира\". Генерал Али Реза Асгари пропал 7 февраля по пути из стамбульского аэропорта в гостиницу. По некоторым данным, сейчас он находится в одной из западных стран, где активно сотрудничает с местными спецслужбами. Супруга генерала не сомневается в том, что ее муж был похищен и винит Турцию в причастности к этому делу.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (93,393,'\"Химкам\" запретили принимать ЦСКА, \"Спартак\" и \"Зенит\" на своем поле',2,'Исполком Российского футбольного союза (РФС) принял решение запретить подмосковному клубу \"Химки\" принимать на своем поле три команды чемпионата страны - ЦСКА, московский \"Спартак\" и \"Зенит\". Для проведения этих встреч химчанам придется искать другой стадион, имеющий сертификат соответствия РФС.','Исполком Российского футбольного союза (РФС) принял решение запретить подмосковному клубу \"Химки\" принимать на своем поле три команды чемпионата страны - ЦСКА, московский \"Спартак\" и \"Зенит\". Для проведения этих встреч химчанам придется искать другой стадион, имеющий сертификат соответствия РФС, сообщает официальный сайт российской футбольной премьер-лиги. 17 марта \"Химки\" провели первый домашний матч чемпионата России 2006 года, обыграв на стадионе \"Родина\" краснодарскую \"Кубань\" (1:0). Поле с самого начала игры находилось в крайне плохом состоянии, однако ситуация усугубилась, когда во втором тайме в Химках пошел дождь. Неудовлетворительное состояние газона было отмечено всеми российскими спортивным СМИ. Помимо сложностей с покрытием поля, стадион \"Родина\" не может принять большое количество зрителей: по данным, опубликованным на официальном сайте клуба, вместимость арены составляет 10054 человека. Матч \"Химки\" - ЦСКА должен состояться уже 8 апреля. Домашняя игра со \"Спартаком\" запланирована на 25 мая, а с \"Зенитом\" - на 16 июня. В первых двух турах чемпионата России \"Химки\" набрали три очка и занимают десятое место в турнирной таблице.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (94,394,'\"Войны гильдий\" продолжатся несколько веков спустя',2,'Компания ArenaNet анонсировала Guild Wars 2, продолжение своей многопользовательской ролевой игры, выпущенной в 2005 году. События второй части будут развиваться в мире оригинальной игры под названием Тирия, но несколькими веками позже. Тестирование Guild Wars 2 начнется в 2008 году.','Компания ArenaNet анонсировала Guild Wars 2, продолжение своей многопользовательской ролевой игры, выпущенной в 2005 году, сообщается на сайте Eurogamer. События второй части будут развиваться в мире оригинальной игры под названием Тирия (Tyria), но несколькими веками позже. Добавятся четыре новых расы. Максимально достижимый уровень персонажей возрастет до 100 (возможно, даже больше); в оригинальной Guild Wars герои могли развиваться только до двадцатого уровня. Тестирование Guild Wars 2 начнется в 2008 году. Параллельно идет работа над Eye of the North, дополнением к первой части игры. Сообщается, что сюжет дополнения должен стать связующими звеном между обеими играми. По обыкновению, появятся новые доспехи, навыки и персонажи. Известно, что перенести героев из первой части игры во вторую не получится. Eye of the North появится ближе к новому году.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (95,395,'Рассел Кроу снимет фильм о серферах',2,'Рассел Кроу станет режиссером картины \"Bra Boys\", посвященную серферскому сообществу его родной Австралии. В основе картины будет документальный фильм, рассказывающий о трех братьях, организовавшие новое социальное движение, которое вскоре завоевало множество сторонников.','Рассел Кроу станет режиссером картины \"Bra Boys\", посвященную серферскому сообществу его родной Австралии, сообщает Variety. В основе картины будет документальный фильм, рассказывающий о трех братьях, организовавшие новое социальное движение, которое вскоре завоевало множество сторонников. Рассел Кроу принимал участие в озвучивании этого фильма. Продюсерами проекта станут Брайан Грейзер и Стюарт Битти, также принимающие участие в написании одноименной книги. А следующим фильмом с участием Кроу, который выйдет на экраны, станет драма \"Американский гангстер\", где его партнером по съемочной площадке является Дензел Вашингтон.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (96,396,'В Афинах подожжен офис футбольного клуба',2,'В Афинах неизвестные подожгли офис местного футбольного клуба \"Панатинаикос\" бутылками с зажигательной смесью. Возникший на первом этаже здания пожар перекинулся на припаркованные поблизости машины, в результате чего пострадало пять автомобилей. Никого из работников клуба в это время в офисе не было.','В Афинах неизвестные подожгли офис местного футбольного клуба \"Панатинаикос\" бутылками с зажигательной смесью. Возникший на первом этаже здания пожар перекинулся на припаркованные поблизости машины, в результате чего пострадало пять автомобилей. Никого из работников клуба в это время в офисе не было. Как сообщает сайт канала \"РТР-Спорт\", пожарным удалось потушить возгорания. По информации местной полиции, офис подожгли около десятка неизвестных, подъехавших к зданию клуба на мотоциклах. После поджога злоумышленники скрылись с места преступления, и задержать их не удалось. Полицейские подозревают, что преступники являются фанатами, болеющими за другой футбольный клуб. Самым принципиальным соперником \"Панатинаикоса\" в чемпионате Греции считается \"Олимпиакос\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (97,397,'Российская синхронистка выиграла серебро чемпионата мира',2,'Наталья Ищенко принесла очередную медаль сборной России на проходящем в Мельбурне чемпионате мира по водным видам спорта. Она стала второй в соревнованиях синхронисток-одиночниц в произвольной программе. Ищенко ровно один балл уступила главной фаворитке турнира, француженке Виржинии Дидье.','Наталья Ищенко принесла очередную медаль сборной России на проходящем в Мельбурне чемпионате мира по водным видам спорта. Она стала второй в соревнованиях синхронисток-одиночниц в произвольной программе. Ищенко ровно один балл уступила главной фаворитке турнира, француженке Виржинии Дидье. Отметим, что россиянка в Мельбурне уже стала чемпионкой мира, но в технической программе, от участия в которой Дидье отказалась. Таким образом расклад сил на австралийском первенстве в точности повторил ситуацию, которая была два года назад в Монреале, когда Дидье также стала первой, а Ищенко – второй. Примечательно, что соревнования одиночниц в произвольной программе стали первыми на турнире по синхронному плаванию, в которых победу одержала не представительница сборной России. До этого в четырех видах программы победили россиянки. Окончательные итоги в произвольной программе одиночниц таковы: Дидье – 99,500 балла; Ищенко – 98,500 балла; Джемма Сивилл Менгуаль – 98,000 баллов. На счету сборной России теперь 11 медалей - 7 золотых, 3 серебряных и 1 бронзовая.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (98,398,'Чиновники завернули новый устав РАН',2,'Руководство Минобрнауки направило в Российскую академию наук отрицательный отзыв на проект устава, разработанный академиками. Необходимость в принятии нового устава РАН возникла после внесения поправок в закону \"О науке\", согласно которым президент академии теперь должен будет утверждаться главой государства.','Руководство Минобрнауки направило в Российскую академию наук (РАН) отрицательный отзыв на проект устава, разработанный академиками, пишет \"Коммерсант\". Необходимость в принятии нового устава РАН возникла после внесения поправок в закону \"О науке\", согласно которым президент академии, ранее избиравшийся общим собранием, теперь должен будет утверждаться главой государства, а сама РАН переименовывается в ГАН (Государственную академию наук). Позднее Министерство образования и науки разработало свой проект устава, меняющий систему управления и финансовых полномочий в академии. Министерский документ не понравился академикам, которые обвинили чиновников в попытке \"нахрапом навязать дилетантские представления, ведущие к развалу российской науки\" (цитируется по журналу \"Власть\") и подготовили свой проект устава. Концепция академического варианта устава практически не отличается от действующей. Согласно документу, основными органами управления РАН остаются общее собрание и президиум РАН, за которым планируется сохранить все административные и финансовые полномочия. Единственными нововведениями оказались положения о назначении президента РАН (теперь его будет утверждать глава государства) и уставе (утверждать будет правительство). В начале следующей недели академический вариант устава будет рассмотрен на общем собрании РАН. Как сообщает \"Коммерсант\", накануне заседания в РАН пришли отзывы от четырех отраслевых ведомств - Минкульта, Минрегионразвития, Минздравсоцразвития и Минобрнауки. По данным издания, в двух первых ведомствах потребовали лишь мелких доработок проекта, и лишь в Минздравсоцразвития и Минобрнауки согласовывать академический проект устава наотрез отказались. В отзыве Минобрнауки перечислены положения министерского проекта устава, проигнорированные РАН. В документе в частности сказано, что \"научную экспертизу и оперативное управление\" следует разделить, полномочия президиума должны свестись к научной экспертизе, а основные административно-финансовые функции нужно передать наблюдательному совету, состоящему из представителей органов власти, и правлению, фактически назначаемому руководством страны. Минобрнауки также отмечает, что в уставе не упомянуты правила проектного финансирования академии и не обозначены принципы кадровой политики. \"Готовьтесь к новому раунду переговоров по уставу\", – предупреждает академиков статс-секретарь Минобрнауки Дмитрий Ливанов.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (99,399,'NASA закроет свою фабрику идей',2,'Институт передовых концепций NASA (NIAC), ведущий исследовательскую деятельность уже почти 20 лет, будет закрыт из-за нехватки денег. Ежегодно из 16 миллиардов долларов бюджета NASA четыре миллиона выделялось институту. NASA собирается направить средства в проект по доставке человека на Луну.','Институт передовых концепций NASA (Nasa\'s Institute for Advanced Concepts (NIAC)), ведущий исследовательскую деятельность уже почти 20 лет, будет закрыт из-за нехватки денег, пишет  The Guardian. NIAC был основан в 1988 году как проект по разработке идей новых или проработке не до конца понятных ученым технологий, таких как лифт в космос. Ежегодно из 16 миллиардов долларов бюджета NASA четыре миллиона выделялось институту для финансирования более десятка долгосрочных исследовательских проектов, на осуществление которых ушло бы от 10 до 40 лет. Ученых просили не ограничиваться рамками возможного на сегодняшний день. Среди проектов института есть такие как космический зонд для фотографирования планет вне пределов солнечной системы, двухкилометровый космический экран для защиты Земли от солнечных лучей и противостояния глобальному потеплению, а также генетически модифицированные растения, которые смогут расти в марсианских условиях. С 2004 года NASA пытается реорганизовать свои активы так, чтобы направить средства в проект по доставке человека на Луну, а затем и на Марс. Однако бывший ученый NASA Кейт Коуинг (Keith Cowing) считает, что идея закрытия института не принесет ничего хорошего, так как без его прогрессивных разработок исследователи не смогут успешно выполнять космические миссии.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (100,400,'Шохин занялся перестановками в РСПП',2,'Глава РСПП Александр Шохин начал кадровые перестановки. Новым заместителем Шохина станет замминистра образования и науки Андрей Свинаренко. В свою очередь, пост главы налогового комитета РСПП перейдет от вице-президента \"Русского алюминия\" Александра Лившица к главе НЛМК Владимиру Лисину.','Глава Российского союза промышленников и предпринимателей (РСПП) Александр Шохин начал кадровые перестановки, пишет газета \"Коммерсант\". Новым заместителем Шохина станет замминистра образования и науки Андрей Свинаренко. Приказ о его отставке с нынешнего поста будет подписан Михаилом Фрадковым со дня на день. В свою очередь, пост главы налогового комитета РСПП перейдет от вице-президента \"Русского алюминия\" Александра Лившица к главе НЛМК Владимиру Лисину. Смену главы комитета Шохин объяснил занятостью Лившица. Кроме того, Виктор Вексельберг, который одновременно возглавляет комитет по МСФО и комитет по международному сотрудничеству, отдаст руководство последним Александру Абрамову из \"Евразхолдинга\". Как пишет издание, РСПП планирует продолжить диалог в властью по вопросам налогообложения, что, по словам Шохина может привести к превращению страны в особую экономическую зону. Этим, в частности займется Владимир Лисин.',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (101,401,'Задержаны шестеро подозреваемых во взрыве в питерском \"Макдоналдсе\"',2,'В Санкт-Петербурге задержаны шестеро подозреваемых в совершении взрыва в \"Макдональдсе\". Подозреваемые, среди которых есть и несовершеннолетние, относят себя к экстремистски настроенной группе \"Движение имени павшего героя Дмитрия Боровикова\". При взрыве в \"Макдональдс\" 18 февраля пострадали шесть человек.','В Санкт-Петербурге задержаны шестеро подозреваемых в совершении взрыва в \"Макдоналдсе\", сообщает интернет-сайт \"Фонтанка.ру\". Задержания проведены с 15 по 20 марта, однако известно о них стало только сейчас. Подозреваемые, среди которых есть и несовершеннолетние, относят себя к экстремистски настроенной группе \"Движение имени павшего героя Дмитрия Боровикова\" (бывший лидер группировки Mad Сrowd). При обыске на квартирах задержанных, большинство которых проживают в Приморском районе города, обнаружено как минимум одно самодельное взрывное устройство, атрибутика и литература экстремистского толка. Несмотря на то, что в организации взрыва сознался только один участник группы - ее лидер, все задержанные, по предварительным данным, арестованы. Им инкриминируются преступления, подпадающие под статью 205 УК РФ (терроризм). По информации интернет-сайта, выйти на задержанных помогли кадры камеры видеонаблюдения, установленной в \"Макдоналдсе\". На записи видно, как шестеро задержанных заходят в ресторан за полчаса до взрыва и закладывают взрывное устройство. При взрыве в ресторане сети \"Макдоналдс\" на пересечении улицы Рубинштейна и Невского проспекта 18 февраля пострадали шесть человек. Комментируя инцидент, наблюдатели указывали на то, что он может быть использован как повод для усиления борьбы с экстремизмом в городе. В правоохранительных органах считают, что задержанные могут быть также причастны и к другим преступлениям, в том числе к взрыву на станции метро \"Владимирская\" за две недели до инцидента в Макдоналдсе. Тогда пострадала одна женщина.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (102,402,'Президента Союза биатлонистов России обвинили в угрозах спортсменам',2,'Главный тренер мужской сборной России по биатлону Владимир Аликин обвинил президента Союза биатлонистов России Александра Тихонова в том, что он угрожает лидерам, пытаясь заставить их выступить на чемпионате страны. Первенство России стартует в четверг 22 марта в Новосибирске, хотя официальный сезон уже закончен.','Главный тренер мужской сборной России по биатлону Владимир Аликин обвинил президента Союза биатлонистов России (СБР) Александра Тихонова в том, что он угрожает лидерам, пытаясь заставить их выступить на чемпионате страны. Первенство России стартует в четверг 22 марта в Новосибирске, хотя официальный сезон уже закончен. \"Чемпионат России - главное национальное соревнование, в котором должны участвовать все сильнейшие спортсмены страны, - заявил Владимир Аликин в интервью агентству спортивной информации \"Весь Спорт\". - Но, во-первых, чемпионат России должен проходить в нормальные сроки, а не в конце сезона, когда лидеры физически и психологически измотаны после тяжелейшего сезона\". \"Наших ребят погнали в Новосибирск под угрозой исключения из национальной сборной, - добавил главный тренер мужской сборной. - На финале Кубка мира в Ханты-Мансийске Тихонов прямо заявил: кто не выступит на чемпионате России, не будет включен в команду на следующий сезон. Не помогли никакие аргументы\". \"Я спросил: Александр Иваныч, а если не приедет вся команда? Он ответил: наберу молодежь, сам буду тренировать, готовить к сезону. Я уточнил: а ты не боишься, что общественное мнение отреагирует на исключение Ярошенко, Чудова, Круглова, Черезова, Рожкова жестко и категорично - и ты уже точно не усидишь на троне? Он ответил: не боюсь никого и ничего, всех уволю!\". Напомним, что в конце января 2007 года Александр Тихонов был переизбран на пост президента СБР, но отчетно-выборная конференция сопровождалась скандалами. Что касается спортивных результатов мужской сборной России, то по итогам сезона-2006/07 она впервые с 1996 года выиграла Кубок наций.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (103,403,'На месте Басманного рынка появится библиотечный центр',2,'К 2010 году на месте обрушившегося в 2006-м Басманного рынка появится новое здание, в котором разместится часть фондов Центральной городской библиотеки имени Некрасова, кинозал, книжный магазин и издательские офисы. Библиотека будет ориентирована на студентов, преподавателей и инвалидов.','К 2010 году на месте обрушившегося в 2006-м Басманного рынка появится новое здание, в котором разместится часть фондов Центральной городской библиотеки имени Некрасова, кинозал, книжный магазин и издательские офисы. Об этом сообщает \"Российская газета\". Библиотеку предполагается сделать ультрасовременной и ориентированной на студентов, преподавателей и инвалидов. Финансирование нового книгохранилища пойдет через бюджет Москвы. Разработка проекта центра уже началась. Крыша здания Басманного рынка, построенного в 1977 году, рухнула 23 февраля 2006 года. Под завалами погибли 66 человек, еще 33 получили ранения. Остатки здания были разобраны.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (104,404,'Фрадков отдаст \"Транснефти\" транспортировку бензина',2,'Премьер Михаил Фрадков направил в администрацию президента документы, описывающие схему поглощения \"Транснефтью\" компании \"Транснефтепродукт\". Сначала \"Транснефтепродукт\" указом президента исключат из списка стратегических предприятий, затем акции компании будут оценены и переданы в уставный капитал \"Транснефти\".','Премьер Михаил Фрадков направил в администрацию президента документы, описывающие схему поглощения \"Транснефтью\" компании \"Транснефтепродукт\", сообщает газета \"Ведомости\". В бумагах направленных в администрацию президента описана следующая схема: сначала \"Транснефтепродукт\" указом президента исключат из списка стратегических предприятий. Затем акции \"Транснефтепродукта\" будут оценены и переданы в уставный капитал \"Транснефти\", при этом монополии надо будет провести дополнительную эмиссию акций. Объединенную компанию, скорее всего, возглавит президент \"Транснефти\" Семен Вайншток. Газета, со ссылкой на свои источникипишет, что \"Транснефтепродукт\" стоит около 35-37 миллиардов рублей. Летом 2006 года глава Минпромэнерго Виктор Христенко опроверг слухи о возможном объединении двух госкомпаний. Тогда министр заявил, что у каждой из компаний есть свои крупные проекты, которые нельзя подвергать рискам. \"Транснефть\" объединяет все магистральные нефтепроводы России, \"Транснефтепродукт\" специализируется на транспортировке нефтепродуктов (бензина, керосина и дизельного топлива) по системе нефтепродуктопроводов. Государству принадлежит 100 процентов акций \"Транснефтепродукта\" и 75 процентов акций \"Транснефти\".',26,1174588082,1174588082);
INSERT INTO `news_news` VALUES (105,405,'Российский лыжник выиграл спринт на этапе Кубка мира',2,'21-летний российский лыжник Михаил Девятьяров-младший одержал победу на этапе Кубка мира в Стокгольме. Россиянин выиграл спринтерскую гонку (один километр), опередив на финише двух представителей Швеции - Эмиля Йенссона и Матса Ларссона. Аналогичную дистанцию у женщин выиграла Петра Майдич (Словения).','21-летний российский лыжник Михаил Девятьяров-младший одержал победу на этапе Кубка мира в Стокгольме. Россиянин выиграл спринтерскую гонку (один километр), опередив на финише двух представителей Швеции - Эмиля Йенссона и Матса Ларссона. Аналогичную дистанцию у женщин выиграла Петра Майдич (Словения). Как сообщает интернет-издание fasterskier.com, победа в Стокгольме стала для Девятьярова-младшего первой на этапах Кубка мира. Его отец Михаил Девятьяров-старший в составе сборной СССР побеждал на Олимпийских играх 1988 года в Калгари. \"Не могу поверить, что я выиграл гонку, это просто потрясающе, - поделился своими эмоциями Девятьяров-младший, - Борьба была трудной, но я был сконцентрирован и шел вперед от одного заезда к другому\". Отметим, что судьбу серебряной и бронзовой медалей определил фотофиниш, отдавший серебро Эмилю Йенссону. Что касается женского спринта, то вслед за Майдич финишную черту пересекли Вирпи Кюйтунен (Финляндия) и Анна Дальберг (Швеция).',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (106,406,'Пропавший в Коми Ми-8 прошел техническую проверку перед вылетом',2,'Старший помощник прокурора республики Коми Юрий Князев сообщил, что пропавший в среду Ми-8 прошел технический осмотр перед вылетом. Спасательный вертолет, пролетевший накануне по маршруту пропавшей машины, ничего не обнаружил. В четверг поиски Ми-8 продолжились.','Пропавший в среду в республике Коми вертолет Ми-8 прошел технический осмотр перед вылетом, сообщил РИА Новости старший помощник прокурора республики Юрий Князев. Вертолет компании \"Газпромавиа\" пропал накануне днем. Доставив из Коми в пункт экологического контроля в Буктыльском районе группу рабочих, в 14:40 по московскому времени Ми-8 вылетел обратно. На его борту находилось пять членов экипажа и один пассажир. В 15 часов Ми-8 должен был выйти на связь, однако этого не произошло. Спасательный вертолет, пролетевший накануне по маршруту пропавшей машины, ничего не обнаружил. В четверг поиски Ми-8 продолжились - в спасательной операции участвуют четыре вертолета.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (107,407,'Объявлена дата юбилейной церемонии \"Оскар\"',2,'Американская Киноакадемия объявила ключевые даты, относящиеся к юбилейной 80-й церемонии вручения премии \"Оскар\". Как сообщается в официальном пресс-релизе, сама церемония состоится 24 февраля и пройдет вновь в кинокомплексе Kodak в Голливуде. Трансляцию будет осуществлять компания ABC.','Американская Киноакадемия объявила ключевые даты, относящиеся к юбилейной 80-й церемонии вручения премии \"Оскар\". Как сообщается в официальном пресс-релизе, сама церемония состоится 24 февраля и пройдет вновь в кинокомплексе Kodak в Голливуде. Трансляцию будет осуществлять компания ABC. 26 декабря 2007 года членам академии будут разосланы бюллетени для голосования, 22 января 2008 года состоится представление номинантов на \"Оскар\", 30 января академикам будет предложено выбрать победителей из списка номинантов. Напомним, что телетрансляцию 79-й церемонии вручения премий \"Оскар\" смотрели в США 38,9 миллионов зрителей. Как утверждает Entertainment Television, шоу, хозяйкой которого была телеведущая Эллен ди Дженерес, не удалось привлечь больше зрителей, чем в прошлом году, а тенденция к снижению популярности церемонии сохранилась.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (108,408,'Причиной столкновения двух МиГ-29 назвали ошибку пилотирования',2,'Причиной столкновения в воздухе двух самолетов МиГ-29, произошедшего 21 марта в Ростовской области, могла стать ошибка пилотов. Один из летчиков не пострадал, другой получил незначительные повреждения лица. Бортовые самописцы, основные узлы и агрегаты самолетов доставлены в Миллерово для проведения экспертизы.','Причиной столкновения в воздухе двух самолетов МиГ-29, произошедшего 21 марта в Ростовской области, может являться ошибка пилотов, сообщает в четверг РИА Новости со ссылкой на помощника главкома ВВС РФ Александра Дробышевского. Столкновение случилось в 16:02 по московскому времени в 40 километрах от авиагарнизона Миллерово в ходе проведения плановых полетов. Пилоты катапультировались, один из них не пострадал, другой получил незначительные повреждения лица. Поскольку авария произошла над полем в безлюдной местности, жертв и разрушений не было. На месте крушения работает комиссия Службы безопасности полетов Минобороны РФ и ВВС, которую возглавляет Сергей Якименко. Бортовые самописцы, находящиеся в удовлетворительном состоянии, а также основные узлы и агрегаты самолетов доставлены в Миллерово для проведения экспертизы. Туда же в четверг в 9.30 вылетает с подмосковного аэродрома Чкаловский главнокомандующий Военно-воздушными силами РФ Владимир Михайлов. По факту столкновения самолетов военная прокуратура Северо-Кавказского военного округа возбудила уголовное дело по статье 351 УК РФ (\"нарушение правил полетов или подготовки к ним\"). МиГ-29 является легким фронтовым истребителем, он создан РСК \"МиГ\" в начале 80-х годов и находится на вооружении в 27 странах.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (109,409,'Спичрайтер Иванова подал рапорт на увольнение',2,'Начальник Главного управления международного военного сотрудничества Минобороны РФ генерал-полковник Анатолий Мазуркевич подал рапорт на увольнение. ГУМВС в дипломатических кругах получил название \"второго МИДа\", а его руководитель был одним из наиболее приближенных к бывшему министру обороны Сергею Иванову людей.','Начальник Главного управления международного военного сотрудничества (ГУМВС) Минобороны РФ генерал-полковник Анатолий Мазуркевич подал рапорт об отставке, пишет 22 марта \"Независимая газета\". ГУМВС в дипломатических кругах получил название \"второго МИДа\", а его руководитель был одним из наиболее приближенных к бывшему министру обороны Сергею Иванову людей. В частности, сотрудники Мазуркевича готовили для Иванова международные речи. По одной из версий, начальник ГУМВС увольняется по болезни. Другую гипотезу высказал предшественник Мазуркевича на этом посту, генерал-полковник Леонид Ивашов. По его словам, отставка может быть связана с возможным расформированием управления. В начале 2000 года бывший начальник Генштаба Анатолий Квашнин уже хотел расформировать ГУМВС, пытаясь усилить роль своего ведомства в силовых структурах страны, однако в 2001 году министром обороны стал Иванов, который отверг эту идею и отправил Квашнина в отставку. По мнению источников издания, подобная перестановка может быть удобна и нынешнему начальнику Генерального штаба ВС РФ Юрию Балуевскому. Как напоминает газета, начальнику ГУМВС подчиняются Управление Министерства обороны РФ по контролю за выполнением договоров, известное как Национальный центр по уменьшению ядерной опасности, и Военно-техническое издательство на иностранных языках.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (110,410,'США запустили баллистическую ракету для проверки системы ПРО',2,'США запустили межконтинентальную баллистическую ракету для проверки эффективности плавучего радара системы ПРО в Тихом океане. Ракета Minuteman 2 стартовала в среду утром по московскому времени, ее траекторию отслеживали сенсоры 85-метрового радара, предназначенные для определения истинных и ложных боеголовок.','Американские военные запустили межконтинентальную баллистическую ракету без боеголовки для проверки эффективности радара морского базирования системы ПРО в Тихом океане, сообщает Associated Press. Ракета Minuteman 2 стартовала в 21.27 вторника по местному времени (в среду утром по московскому), ее траекторию отслеживали сенсоры 85-метрового радара, предназначенные для определения истинных и ложных боеголовок. В ходе последнего запуска старт ракеты-перехватчика не производился. Он запланирован в рамках следующих испытаний - весной и осенью этого года. Радар морского базирования SBX был построен компанией Raytheon для Boeing (основного подрядчика минобороны США) и обошелся в 815 миллионов долларов. Он размещен на самоходной полупогружной платформе CS-50 (Moss Sirius), построенной в Выборге, которая может перемещаться в любую точку по необходимости. Радар изначально разместили на базе ВМФ США на Гавайях, однако в конце 2006 года его установили ближе к российским границам. Согласно заявлениям США, это было сделано для тестирования и слежения за возможными пусками ракет в КНДР.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (111,411,'Председатель совета Центросоюза подозревается в крупном мошенничестве',2,'Прокуратура Москвы возбудила уголовное дело в отношении председателя совета Центрального союза потребительских обществ РФ Валентина Ермакова. Он подозревается в мошенничестве в особо крупном размере. По данным следствия, в 2005 году Ермаков пытался перевести акции КБ Eurobank стоимостью 17 миллионов евро в собственность учрежденной им фирмы.','Прокуратура Москвы возбудила уголовное дело в отношении председателя совета Центрального союза потребительских обществ РФ (Центросоюз) Валентина Ермакова, пишет в четверг газета \"Газета\". Ермаков подозревается в покушении на мошенничество в особо крупном размере. По данным следствия, не являясь владельцем акций КБ Eurobank, 30 сентября 2005 года он направил туда распоряжение о переводе этих активов стоимостью 17 миллионов евро в собственность учрежденной им зарубежной фирмы Centrecoop Ltd. Между тем, напоминает издание, возбуждение дела против Ермакова является очередным этапом тяжбы между Банком России и Центросоюзом за акции Eurobank. СССР приобрел их еще в 1925 году и оформил ценные бумаги на Госбанк и ряд внешнеторговых организаций, в том числе небольшую долю получила потребительская кооперация. После распада СССР в 1992 году по решению Верховного Совета РСФСР акции советского потребсоюза были переданы в собственность Центросоюзу как естественному правопреемнику. Так Центросоюз стал акционером Eurobank с пакетом чуть более 9 процентов акций. Однако ЦБ считает себя 100-процентным владельцем российских зарубежных банков, а остальных акционеров называет номинальными. По мнению Банка России, нынешние миноритарии не имеют права на акции, так как никаких средств в капиталы загранбанков не вносили. \"Газета\" добавляет, что в феврале 2007 года в прессу попало письмо первого заместителя председателя Центробанка Алексея Улюкаева, адресованное генпрокурору РФ Юрию Чайке. Улюкаев потребовал привлечь руководителя Центросоюза к уголовной ответственности за попытку продать акции Eurobank \"третьим лицам\". Как сообщалось ранее, право Центросоюза на акции Eurobank было подтверждено в 1995 году Торговым судом Парижа. Спорный пакет акций оценивается в 40-50 миллионов евро.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (112,412,'На британской атомной подлодке взорвалась установка для очистки воздуха',2,'Причиной гибели двух моряков ВМС Великобритании на подводной лодке HMS Tireless стал взрыв установки для очистки воздуха в носовой части судна. Как уточнили в британском Министерстве обороны, инцидент произошел около 4:30 по гринвичскому времени, когда лодка участвовала в учениях в Северном Ледовитом океане.','Причиной гибели двух моряков ВМС Великобритании на подводной лодке HMS Tireless стал взрыв установки для очистки воздуха в носовой части судна, передает в четверг агентство France Presse. Как уточнили в британском Министерстве обороны, инцидент произошел в среду около 4:30 по гринвичскому времени, когда подлодка участвовала в учениях в Северном Ледовитом океане. \"Субмарина не подвергалась опасности, ее атомный реактор не пострадал, она быстро всплыла целой и невредимой\", - подчеркивается в пресс-релизе министерства. \"Команда судна приняла быстрые и профессиональные меры в сложившейся ситуации, в результате чего пострадала лишь внешняя отделка носового отсека\", - указывается в заявлении военных. В Минобороны напомнили, что ранее неполадки подобного оборудования для очистки воздуха не фиксировались, однако до завершения расследования его использование на всех подлодках ВМС Великобритании ограничено. HMS Tireless была спущена на воду в 1984 году, однако установка для очистки воздуха появилась на субмарине в 2001 году после ремонта. Как напоминает AFP, в мае 2000 года подлодка встала на ремонт в Гибралтаре после того, как в системе охлаждения атомного реактора обнаружилась течь. Однако британские военные заверили, что тот случай не имеет никакого отношения к последнему происшествию.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (113,413,'Инспекция здравоохранения Эстонии нашла в \"Боржоми\" лишние соли бария',2,'В среду Инспекция здравоохранения Эстгнии сделала предписание изъять из продажи грузинскую минеральную воду \"Боржоми\" в связи с обнаружением в ней повышенного содержания солей бария. Как оказалось, в воде, полученной из источников 38 и 41, предельно допустимая концентрация этого вещества превышена в шесть раз.','В среду Инспекция здравоохранения Эстонии сделала предписание изъять из продажи грузинскую минеральную воду \"Боржоми\" в связи с обнаружением в ней повышенного содержания солей бария, сообщает интернет-издание DELFI. Как оказалось, в воде, полученной из источников 38 и 41, предельно допустимая концентрация солей бария превышена в шесть раз. Разовое употребление такой минеральной воды здоровью не повредит, однако при регулярном потреблении возрастает риск сердечно-сосудистых заболеваний. Информация о несоответствии \"Боржоми\" из источников 38 и 41 санитарным нормам поступила из Латвии, где проводилась соответствующая проверка. Кроме того, эстонские власти обеспокоены, что вода из данных источников не значится в списке натуральных минеральных вод Европейской комиссии, а это является обязательным. Напомним, продажа грузинской минеральной воды на российском рынке была запрещена в мае 2006 года по требованию Роспотребнадзора. Как сообщалось официально, санитарные власти России пошли на этот шаг из-за большого количества контрафактной продукции.',22,1174588082,1174588082);
INSERT INTO `news_news` VALUES (114,414,'Родственники погибших в доме престарелых компенсации не получат',2,'Власти Краснодарского края приняли решение не выплачивать компенсации родственникам погибших в результате пожара в доме престарелых в станице Камышеватская. Они \"бросили своих стариков на попечение государства\", поэтому не вправе расчитывать на выплаты. Исключение сделано лишь для сына погибшей медсестры - он получит 250 тысяч рублей.','Власти Краснодарского края приняли решение не выплачивать компенсации родственникам погибших во вторник в результате пожара в доме престарелых в станице Камышеватская, передает РИА Новости. Как пояснили в пресс-службе администрации региона, люди \"бросили своих стариков на попечение государства\", поэтому не вправе расчитывать на выплаты, несмотря на принятую практику. Исключение сделано лишь для семнадцатилетнего сына погибшей медсестры Лидии Паченцевой - он получит 250 тысяч рублей. Кроме того, юношу переведут с коммерческой на бюджетную форму обучения и \"будут поддерживать в дальнейшем\", пообещали в администрации. Деньги, которые могли бы получить родственники погибших, планируется направить на обеспечение безопасности пожилых людей, инвалидов и детей в интернатах региона. Власти Краснодарского края намерены выделить дополнительное финансирование на обеспечение противопожарной безопасности социальных объектов. Напомним, пожар в доме престарелых в станице Камышеватская начался около часа ночи 20 марта. В результате происшествия погибли 62 человека, еще одна пострадавшая позже скончалась в больнице. Из огня удалось спасти 35 человек, из них 30 были госпитализированы. В краевом МЧС отрабатываются три версии происшествия - неосторожное обращение с огнем, короткое замыкание проводки и поджог. Тем временем губернатор Кубани Александр Ткачев предложил главе Ейского района края Дмитрию Кугинису уйти в отставку, назвав ситуацию с пожаром \"преступной халатностью\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (115,415,'Началась регистрация участников конференции \"Интернет и бизнес\"',2,'Организаторы конференции \"Интернет и бизнес\" объявили о начале регистрации участников мероприятия. Организованная компаниями Афиша, Бегун, Демос, Mail.Ru, Ozon.ru, Rambler, РБК, HeadHunter и Яндекс, пройдет с 18 по 20 апреля 2007 года в подмосковном пансионате \"Бор\".','Организаторы конференции \"Интернет и бизнес\" объявили о начале регистрации участников мероприятия. Всероссийская конференция, посвященная развитию Рунета и организованная компаниями Афиша, Бегун, Демос, Mail.Ru, Ozon.ru, Rambler, РБК, HeadHunter и Яндекс, пройдет с 18 по 20 апреля 2007 года в подмосковном пансионате \"Бор\". Для участия в КиБе-2007 необходимо заполнить анкету, размещенную на сайте конференции. Также на сайте опубликована программа грядущего мероприятия - с ней можно ознакомиться по этому адресу.',30,1174588082,1174588082);
INSERT INTO `news_news` VALUES (116,416,'\"Проф-Медиа\" продаст \"Комсомолку\" в течение месяца',2,'Холдинг \"Проф-Медиа\" в среду объявил, что корпоративные процедуры по оформлению продажи 60 процентов и одной акции ИД \"Комсомольская правда\" группе ЕСН завершены. Как ожидается, сделка, организаций которой занимался холдинг \"Газпром-Медиа\", будет полностью оформлена в течение месяца.','Холдинг \"Проф-Медиа\" в среду объявил, что корпоративные процедуры по оформлению продажи 60 процентов и одной акции ИД \"Комсомольская правда\" Группе компаний ЕСН завершены, передает агентство \"Интерфакс\". Как ожидается, сделка, организаций которой занимался холдинг \"Газпром-Медиа\", будет полностью оформлена в течение месяца. По словам главного редактора \"Комсомольской правды\" Владимира Сунгоркина, в редакции относятся к происходящему \"в целом нормально\" и \"ничего плохого не ждут\". Отвечая на вопрос о кандидатуре главного редактора издания после смены собственника, Сунгоркин заметил, что не находит корректным высказываться на этот счет. В январе 2006 года, напоминает \"Интерфакс\", Группа компаний ЕСН приобрела ИД \"РЖД-Партнер\", который владеет одноименным журналом, интернет-порталом, рекламным агентством \"Рекламотив\" и издает журнал \"Саквояж-СВ\". \"Проф-Медиа\" в сегменте печатных СМИ, помимо \"Комсомольской правды\", владеет ИД \"Афиша\", а в сегменте интернет-активов - компания Rambler Media. Холдинг также управляет несколькими FM-радиостанциями в Москве и Санкт-Петербурге, национальной телесетью \"ТВ-3\" и телеканалом \"2х2\", который выйдет в эфир в апреле 2007 года. Кроме того, \"Проф-Медиа\" принадлежат национальная сеть мультиплексов под маркой \"Синема Парк\" и контрольный пакет акций компании \"Централ Партнершип\".',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (117,417,'На Автозаводской улице в Москве расстреляли мужчину',2,'Вечером в среду напротив дома 13 по Автозаводской улице на юге Москвы был застрелен мужчина. Преступление было совершено возле адвокатской конторы примерно в 21:00. Как рассказали очевидцы, двое неизвестных из пистолетов несколько раз выстрелили в жертву и скрылись.','Вечером в среду напротив дома 13 по Автозаводской улице на юге Москвы был застрелен мужчина, передает РИА Новости. По словам представителя правоохранительных органов столицы, преступление было совершено возле адвокатской конторы примерно в 21:00. Как рассказали очевидцы, двое неизвестных из пистолетов несколько раз выстрелили в жертву и скрылись. Между тем, по данным агентства \"Интерфакс\", мужчина не убит, а тяжело ранен. Это администратор продовольственного магазина, который сделал замечание двум покупателям, из-за чего один из них достал пистолет и выстрелил в работника торговли. Пострадавшему, который находится в крайне тяжелом состоянии, врачи оказывают помощь на месте, указывает \"Интерфакс\". Приметы злоумышленников переданы во все отделения милиции города, на месте происшествия работает следственная группа.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (118,418,'На юго-западе Москвы ВАЗ-2199 на тротуаре сбил коляску с ребенком',2,'Вечером в среду около 20:30 в районе дома 154 по Профсоюзной улице водитель автомобиля ВАЗ-2199 зацепил стоявшую на тротуаре коляску с младенцем и протащил ее несколько кварталов. Нарушитель попытался скрыться с места происшествия, и задержать его удалось лишь в районе улицы Академика Варги. Младенец погиб.','Вечером в среду в результате дорожно-транспортного происшествия в районе метро \"Теплый стан\" на юго-западе Москвы погиб младенец, передает агентство \"Интерфакс\". Как рассказали в ГУВД столицы, ДТП произошло недалеко от дома 154 по Профсоюзной улице. Около 20:30 водитель автомобиля ВАЗ-2199 зацепил стоявшую на тротуаре коляску с младенцем. Автомобилист не остановился и попытался скрыться с места происшествия. Он протащил коляску за автомобилем несколько кварталов и был задержан лишь в районе улицы Академика Варги. О состоянии водителя не сообщается.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (119,419,'На британской атомной подлодке погибли два моряка',2,'В результате происшествия на борту атомной подводной лодки ВМС Великобритании погибли два моряка и еще один пострадал. В Министерстве обороны не сообщили, что привело к гибели военнослужащих. Когда произошел несчастный случай, подлодка с командой в 140 человек участвовала в учениях в Северном Ледовитом океане.','В результате происшествия на борту атомной подводной лодки ВМС Великобритании HMS Tireless погибли два моряка и еще один пострадал, сообщается на сайте BBC News. В Министерстве обороны не сообщили, что именно привело к гибели военнослужащих, однако, по предварительным данным, она \"связана с деталью системы кондиционирования воздуха на носу подлодки\", уточняет агентство France Presse. Когда произошел несчастный случай, подлодка с командой в 140 человек участвовала в учениях в Северном Ледовитом океане. Точное место дислокации судна не раскрывается. Происшествие не было связано ни с атомным реактором подлодки, ни с находившимся на ней оружием, подчеркнули в британском Минобороны. Инцидент произошел на глубине, но не повлиял на способность судна передвигаться. Сейчас оно всплыло на поверхность, отмечает BBC News. Имена погибших моряков не сообщаются, их родственники оповещены о произошедшем. Как напоминает телеканал Sky News, 23-летняя HMS Tireless (\"Неутомимая\") вошла в строй в 2006 году после серьезного ремонта, на который встала в 2000 году. Тогда на трубах охлаждения атомного реактора были замечены трещины. Несколько месяцев подлодка находилась в доке в Гибралтаре, что вызвало серьезное беспокойство испанских властей.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (120,420,'В центре Санкт-Петербурга бурильная установка рухнула на бассейн',2,'В центре Санкт-Петербурга бурильная установка рухнула на двухэтажное здание бассейна. В результате обрушилось от 150 до 250 квадратных метров кровли здания, где в этот момент находились 30 человек. Впрочем, никто из них не пострадал, оказавшись в противоположном от места обрушения конце здания.','В центре Санкт-Петербурга в районе площади Александра Невского бурильная установка рухнула на двухэтажное здание бассейна, сообщает интернет-издание \"Фонтанка.Ру\", ссылаясь на представителей городского управления МЧС России. По их словам, в результате инцидента обрушилось от 150 до 250 квадратных метров кровли здания, где в этот момент находились 30 человек. Впрочем, никто из них не пострадал, благодаря тому, что обрушение произошло в противоположном от них конце здания.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (121,421,'Делом о торговле людьми займется военная прокуратура',2,'Дело о торговавшем людьми международном преступном сообществе, ликвидированном ФСБ, передано в Главную военную прокуратуру. \"Сегодня следователи меня известили, что дело передано в ГВП по подследственности из прокуратуры Юго-Восточного округа Москвы\", - сказал адвокат одного из обвиняемых.','Дело о торговавшем людьми международном преступном сообществе, ликвидированном ФСБ, передано в Главную военную прокуратуру, сообщает РИА Новости со ссылкой на адвоката одного из обвиняемых - Руслана Коблева. \"Сегодня следователи меня известили, что дело передано в Главную военную прокуратуру по подследственности из прокуратуры Юго-Восточного округа Москвы\", - сказал он. По мнению Коблева, скорее всего, удовлетворено его ходатайство о том, что дела в отношении военнослужащих должны рассматриваться военной прокуратурой. \"Видимо, дальше Главная военная прокуратура будет решать - какая именно военная прокуратура будет рассматривать данное дело\", - пояснил адвокат. Напомним, что согласно заявлению Генеральной прокуратуры, \"прокуратура Юго-Восточного административного округа Москвы по данному делу предъявила обвинение 37-летнему подполковнику Дмитрию Стрыканову, 27-летнему Вячеславу Баландину, 33-летнему Игорю Владу, 42-летнему Валерию Белову, 39-летнему Юрию Фролову, 33-летнему Вадиму Стояну и 38-летнему Олегу Чайкину по части 3 статьи 127.1 (торговля людьми) и части 2 статьи 210 (участие в преступном сообществе) УК РФ\". По мнению следствия, указанные лица объединились в преступную группу с целью продажи людей в зарубежные страны для оказания услуг интимного характера.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (122,422,'Бундестагу рассказали об антисанитарии в солдатских казармах',2,'Военнослужащие частей Бундесвера, дислоцированных на западе Германии, проходят службу в антисанитарных условиях. Причиной такой ситуации стало преимущественное финансирование на протяжении последних пятнадцати лет военных объектов Бундесвера на территории бывшей ГДР.','Военнослужащие частей Бундесвера, дислоцированных на западе Германии, проходят службу в антисанитарных условиях, сообщает Deutsche Welle. \"Нашим военнослужащим порой приходиться жить в условиях, которые я вынужден назвать невыносимыми и отчасти скандальными\", - сообщил в своем докладе Бундестагу уполномоченный по делам военнослужащих Райнхольд Роббе (Rheinhold Robbe). Ряд казарм, построенных еще в 30-е годы, находится в аварийном состоянии по причине ветхости зданий и давно не ремонтировавшихся коммуникаций. Причиной подобной ситуации стало преимущественное финансирование в последние 15 лет восточногерманских казарм, считает Роббе. Также в докладе уполномоченного сообщается об антисанитарных условиях размещения немецкого миротворческого контингента в Конго, где оборудование палаточного городка было впервые поручено частной фирме.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (123,423,'Европейским обладателям PS3 порекомендовали пропускать второстепенные видеоролики',2,'Sony запустила специальный сайт, посвященный совместимости европейской версии приставки PlayStation 3 с играми для предыдущих консолей компании. Разработчики уточняют, что речь идет исключительно о консолях, на которых установленная новейшая (1.6 на сегодняшний день) версия системного программного обеспечения.','Sony запустила специальный сайт, посвященный совместимости европейской версии приставки PlayStation 3 с играми для предыдущих консолей компании, PlayStation и PlayStation 2, сообщается на сайте 1up. Разработчики уточняют, что речь идет исключительно о консолях, на которых установленная новейшая (1.6 на сегодняшний день) версия системного программного обеспечения. На сайте приведен обширный список игр, напротив каждой из которой стоит одна из трех пометок: \"проблемы не обнаружены\", \"функционирует в системе PlayStation 3 с незначительными проблемами\" и \"функционирует в системе PlayStation 3 с заметными проблемами\". При этом Sony не уточняет, какие именно проблемы подразумеваются под \"незначительными\" или \"заметными\". Игры, которые вообще не будут функционировать, в списках и вовсе не значатся. Выясняется, что на европейских PS3 не будут запускаться, например, третья серия Silent Hill, Metal Gear Solid 2, Bully и Gran Turismo 4. С трудом работают боевик Devil May Cry 2, Okami и десятая Final Fantasy. Для оптимальной работы игр с предыдущих платформ европейским обладателям PS3 рекомендуют \"не подключать к системе PS3 устройства USB, которые не требуются для игры\", \"избегать использования режима 60Hz и сетевых режимов игры\" и \"пропускать второстепенные видеоролики\". Напомним, что вопрос о совместимости PS3 с играми для предыдущей приставки компании возник после того, как выяснилось, что в европейскую модель не будет встроен так называемый Emotion Engine, графическая микросхема PS2. Все игры будут запускаться исключительно благодаря программной эмуляции. Новая консоль Sony поступит в продажу в Европе 23 марта 2007 года. Цена европейских PS3 будет самой высокой. Стоимость приставки, оснащенной 60-гигабайтным жестким диском, составит 599 евро. Для сравнения, в США PS3 оценена в ту же сумму, но в американских долларах.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (124,424,'В Израиле прекратилась всеобщая забастовка',2,'Руководители израильской ассоциации профсоюзов Гистадрут вечером в среду, 21 марта, объявили об окончании всеобщей забастовки, которая на восемь часов практически парализовала жизнь страны. Профсоюзам удалось прийти к соглашению с правительством по вопросу о погашении многомесячной задолженности по зарплате.','Руководители израильской ассоциации профсоюзов Гистадрут (Histadrut) вечером в среду, 21 марта, объявили об окончании всеобщей забастовки, которая на восемь часов практически парализовала жизнь страны, передает агенство AFP. Сообщается, что профсоюзам удалось прийти к соглашению с правительством по вопросу о погашении многомесячной задолженности по зарплате муниципальным служащим, которая послужила главной причиной объявления забастовки. \"Забастовка окончена, все рабочие могут вернутся к нормальной деятельности\", - заявил глава ассоциации Гистадрут Офер Ейни (Ofer Eini). В забастовке, начавшейся в 9:00 по местному времени, приняли участие почти 400 тысяч рабочих и служащих. Работа международного аэропорта Бен-Гуриона (Ben-Gurion), морских портов, и других предприятий и государственных учреждений по все стране была прервана.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (125,425,'Кубанский губернатор возложил вину за пожар в доме престарелых на районные власти',2,'Губернатор Краснодарского края Александр Ткачев призвал уйти в отставку главу Ейского района, где 20 марта при пожаре в доме престарелых сгорели 62 человека. \"Считаю, что вам необходимо уйти с этого поста. Вы не справились со своими обязанностями\", - сказал губернатор на заседании чрезвычайной комиссии края.','Губернатор Краснодарского края Александр Ткачев призвал уйти в отставку главу Ейского района, где 20 марта при пожаре в доме престарелых сгорели 62 человека, сообщает РИА Новости. \"Считаю, что вам необходимо уйти с этого поста. Вы не справились со своими обязанностями\", - сказал губернатор на заседании чрезвычайной комиссии края. По мнению Ткачева, передает \"Интерфакс\", власти района слишком безответственно относились к предупреждениям пожарных о недостаточном обеспечении пожарной безопасности. \"Мы прекрасно понимаем, что эта ситуация возникла не вчера. Со стороны администрации района - это преступная халатность\", - сказал глава региона. Он также возложил часть вины за произошедшее на руководство соседней со станицей птицефабрики, которое отказало в предоставлении пожарной машины для тушения дома престарелых. Напомним, что при пожаре погибли 62 человека, еще одна женщина позднее скончалась в больнице.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (126,426,'Все погибшие при пожаре в доме престарелых опознаны',2,'Закончено опознание всех погибших в результате пожара в доме престарелых в станице Камышеватской Ейского района Краснодарского края. Всего для процедуры опознания в морг центральной городской больницы Ейска было направлено 62 тела. В среду на Кубани прошли похороны 38 погибших.','Закончено опознание всех погибших в результате пожара в доме престарелых в станице Камышеватской Ейского района Краснодарского края. Об этом, сообщает \"Интерфакс\", заявил в среду вице-губернатор Краснодарского края Мурат Ахеджак. По его словам, в среду на Кубани прошли похороны 38 погибших. Как сообщил представитель центральной городской больницы Ейска, всего для процедуры опознания в морг больницы было направлено 62 тела. В то же время, число погибших в результате пожара в ночь на среду возросло до 63 человек. В Ейской центральной районной больнице скончалась от инфаркта 66-летняя женщина. Пожар в двухэтажном кирпичном здании дома престарелых вспыхнул во вторник, в 01:11 по московскому времени. Из огня удалось спасти 35 человек. Гибель людей при пожаре в доме престарелых в станице Камышеватской стала одной из причин, по которой 21 марта объявлено в России днем траура.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (127,427,'Компания Google опровергла слухи о создании \"Гуглофона\"',2,'Ричард Климбер, управляющий директор азиатского подразделения Google, заявил, что рынок мобильных телефонов не представляет интереса для компании. \"На данный момент нас больше интересует программное обеспечение, нежели мобильные телефоны,\" - сказал Климбер.','Компания Google опровергла слухи о создании собственного мобильного телефона, сообщается на сайте Gizmodo. Ричард Климбер, управляющий директор азиатского подразделения Google, заявил, что рынок мобильных телефонов не представляет интереса для компании. \"На данный момент нас больше интересует программное обеспечение, нежели мобильные телефоны,\" - сказал Климбер. Это подтверждает недавнее заявление Винтона Серфа, вице-президента Google, о том, что \"производство мобильных телефонов не соответствует бизнес-модели компании\". Тем не менее ни Климбер, ни Серф ни словом не обмолвились о том, существует \"Гуглофон\" или нет. Напомним, что слухи о создании телефона от Google появились еще в 2006 году. Слухам поверила компания Nokia, представители которой заявили, что \"Гуглофон\" не будет иметь успеха на рынке и повлечет за собой финансовые потери для компании-производителя.',31,1174588082,1174588082);
INSERT INTO `news_news` VALUES (128,428,'Испанский суд потребовал арестовать лидера партии басков',2,'Государственный суд Испании потребовал от полиции арестовать Арнальдо Отеги, лидера партии \"Батасуна\", политического крыла сепаратистской баскской организации ETA, за отказ явиться на процесс, где он проходит обвиняемым в оправдании терроризма. Сам Отеги заявил, что не может приехать в Мадрид из-за сильного снегопада.','Государственный суд Испании потребовал от полиции немедленно арестовать Арнальдо Отеги (Arnaldo Otegi), лидера партии \"Батасуна\", политического крыла сепаратистской баскской организации ETA, передает агентство Associated Press. Решение суда продиктовано отказом Отеги явится в Мадрид на процесс, где он должен выступить в качестве обвиняемого за пропаганду и оправдание терроризма - деятельность, которая в Испании считается преступной. Сам Отеги заявил, что не может явиться в суд из-за сильного снегопада, который блокировал его машину по дороге из города Elgoibar, где он живет, в Мадрид. Однако судьи сочли, что в данном случае плохие погодные условия не могут считаться оправданием для неявки. Сообщается, что Государственный суд обратился в за необходимыми разъяснениями в дорожную полицию, которая заявила, что снегопад не является серьезным препятствием, для направляющихся в Мадрид на автомобиле. Напомним, что Отеги обвиняется в том, что на похоронах 22-летней террористки ETA Олайи Кастресаны (Olaya Castresana), погибшей от неосторожного обращения со взрывчаткой, он произнес речь, в которой восхвалял членов ETA как настоящих патриотов.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (129,429,'\"Молодогвардейцы\" ответят на \"Марш несогласных\" политической весной',2,'\"Молодая гвардия Единой России\" (МГЕР) планирует 14 апреля, одновременно с \"Маршем несогласных\", вывести на улицы Москвы 15 тысяч человек. Акция будет посвящена \"новой политической весне\". Кроме того, не исключено, что МГЕР может принять участие в \"Имперском марше\", назначенном на 8 апреля.','\"Молодая гвардия Единой России\" (МГЕР) планирует провести 14 апреля в Москве акцию, в которой, по предварительным данным, примут участие 15 тысяч человек. Такое заявление сделал в среду на пресс-конференции член координационного и политического советов МГЕР Андрей Турчак, сообщает корреспондент Ленты.Ру. Отметим, что в этот же день, 14 апреля, в Москве планируется проведение очередного \"Марша несогласных\". Однако, по словам Турчака, акция \"молодогвардейцев\" не связана с акцией оппозиции и не будет противопоставлена ей. \"Эта акция будет посвящена новой политической весне\", - заявил Турчак, отметив, что \"молодогвардейцы\" не собираются готовить никаких провокаций в отношении \"Марша несогласных\". В то же время он не исключил, что \"Молодая гвардия\" может принять участие в \"Имперском марше\", который пройдет в Москве 8 апреля. По словам Турчака, в настоящее время с организаторами этого шествия – \"Международным Евразийским движением\" - ведутся консультации. Напомним, что оргкомитет \"Имперского марша\" собирается провести эту акцию в знак протеста против \"Марша несогласных\".',29,1174588082,1174588082);
INSERT INTO `news_news` VALUES (130,430,'Конгрессмены вызвали Карла Роува на допрос',2,'Субкомитет Палаты представителей Конгресса США по вопросам коммерческого и административного законодательства проголосовал за приглашение для дачи показаний советников президента Буша. Конгрессмены намерены проинтервьюировать Карла Роува и Харриет Майерс по поводу их роли в увольнении восьмерых федеральных прокуроров.','Субкомитет Палаты представителей Конгресса США по вопросам коммерческого и административного законодательства проголосовал за приглашение для дачи показаний советников президента Буша. Как сообщает AP, конгрессмены намерены проинтервьюировать Карла Роува, Харриет Майерс, а также их помощников по поводу их роли в увольнении восьмерых федеральных прокуроров. Кроме сотрудников Белого дома, представление будет направлено бывшему помощнику генерального прокурора Кайлу Сэмпсону. Все они будут отвечать на вопросы комиссии, расследующей обстоятельства, приведшие к отставке, публично и под присягой. Напомним, что днем ранее президент Буш заявил, что позволит своим подчиненным отвечать перед Конгрессом только в том случае, если их показания не будут записываться, и они не будут давать присягу.',24,1174588082,1174588082);
INSERT INTO `news_news` VALUES (131,431,'В самарской катастрофе Ту-134 могут обвинить метеорологов',2,'Причиной катастрофы самолета Ту-134 авиакомпании UTair, которая произошла 17 марта в самарском аэропорту, могла стать неудовлетворительная работа метеослужбы. \"Диспетчерская служба аэропорта работала безукоризненно, но диспетчер не имел достоверной информации от метеослужбы\", - сообщил источник РИА Новости.','Причиной катастрофы самолета Ту-134 авиакомпании UTair, которая произошла 17 марта в самарском аэропорту \"Курумоч\", могла стать неудовлетворительная работа метеослужбы. \"Экипаж не имел правдивой информации о состоянии погоды на момент катастрофы. Диспетчерская служба аэропорта \"Курумоч\" работала безукоризненно, но диспетчер не имел достоверной информации от метеослужбы\", - цитирует РИА Новости слова высокопоставленного источника, знакомого с ходом расследования авиапроисшествия. По его словам, погода в самарском аэропорту в момент захода самолета Ту-134 на посадку изменилась. \"К сожалению, мы вынуждены констатировать, что погода в аэропорту менялась фатально в момент перед приземлением. Записи зафиксировали, что в момент катастрофы погода являлась нелетной для всех видов воздушных судов\", - пояснил чиновник. В результате крушения авиалайнера погибли шесть человек, десятки получили ранения. Большего числа жертв удалось избежать благодаря тому, что пассажирам и экипажу самолета удалось самостоятельно потушить начавшийся пожар. Изначально рассматривались четыре версии авиакатастрофы: ошибка экипажа, неисправное оборудование, плохие погодные условия, ошибка наземных служб. При этом расшифровка \"черных ящиков\" Ту-134 не подтвердила версию о неисправности самолета.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (132,432,'Разбившиеся в Ростовской области МиГи не были вооружены',2,'Оружия на борту разбившихся в Ростовской области истребителей МиГ-29 не было. Об этом сообщил помощник главкома ВВС России полковник Александр Дробышевский. По его словам, \"летчики отрабатывали полет парой, выполняя упражнение на слетанность\". Он отметил, что место падения столкнувшихся самолетов оцеплено, жертв и разрушений на земле нет.','Оружия на борту разбившихся в Ростовской области истребителей МиГ-29 не было. Об этом, как передает агентство \"Интерфакс\", сообщил помощник главкома ВВС России полковник Александр Дробышевский. По его словам, \"летчики отрабатывали полет парой, выполняя упражнение на слетанность\". Он отметил, что самолеты столкнулись на высоте около семи тысяч метров, добавив, что место падения истребителей оцеплено, а жертв и разрушений на земле нет. Летчики при столкновении успели катапультироваться и вскоре их подобрали спасательные вертолеты, доставившие пилотов в медсанчасть, где их состояние оценили как удовлетворительное. Напомним, что по факту столкновения двух военных самолетов, происшедшего 21 марта в 40 километрах от авиагарнизона Миллерово в Ростовской области, военная прокуратура Северо-Кавказского военного округа возбудила уголовное дело по статье 351 УК РФ (\"нарушение правил полетов или подготовки к ним\").',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (133,433,'Индонезийский боксер умер после поражения на ринге',2,'20 марта в больнице Джакарты (Индонезия) скончался местный боксер Анис Дви Мулья. За пять дней до смерти он потерпел поражение от Ирфана Боне, причем бой был остановлен в шестом раунде, когда Мулья перестал сопротивляться в связи с неожиданным упадком сил. После операции он пришел в себя, но вскоре умер.','20 марта в больнице Джакарты (Индонезия) скончался местный боксер Анис Дви Мулья. За пять дней до смерти он потерпел поражение от Ирфана Боне, причем бой был остановлен в шестом раунде, когда Мулья перестал сопротивляться в связи с неожиданным упадком сил. После операции он пришел в себя, но вскоре умер. Как сообщает интернет-издание fightnews.com, врачи обнаружили у Мульи две гематомы мозга и прооперировали спортсмена. После этого боксер пришел в сознание и общался с родными и друзьями. Специалисты считают, что причиной смерти могла стать лихорадка денге. Основанием для этих предположений служит пониженный уровень тромбоцитов в крови Мульи. Сделанные анализы показали, что уровень этих клеток в крови спортсмена резко понизился с 200 тысяч в одном в кубическом миллиметре до 56 тысяч (нормальным показателем является 200-400 тысяч). Именно лихорадка денге могла привести к образованию гематом мозга. Мулья стал уже третьим индонезийским боксером, погибшим непосредственно после боя. В 2005 году после поединка скончался Хендрик Бира, а в 2006 - Фадли Кассим.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (134,434,'Бьорк отправится в концертный тур по США и Европе',2,'Бьорк объявила даты выступлений, которые состоятся в рамках ее концертного тура в поддержку нового альбома Volta. Тур начнется в Рейкьявике 1 апреля 2007 года. Затем певица отправится в США и снова вернется в Европу перед фестивалем Glastonbury. Новая пластинка Бьорк появится в продаже 6 мая 2007 года.','Исландская певица Бьорк объявила даты выступлений, которые состоятся в рамках ее концертного тура, сообщается на сайте Gigwise. Тур начнется в Рейкьявике 1 апреля 2007 года. 27 апреля певица появится на фестивале Coachella, а после даст еще несколько концертов в США. Затем Бьорк планирует несколько выступлений в Европе, первое из которых состоится на фестивале Glastonbury 22 июня 2007 года. Концертный тур Бьорк будет посвящен выходу нового студийного альбома певицы. Пластинка под названием Volta появится в продаже 6 мая 2007 и будет содержать десять треков. В записи диска принимали участие Энтони Хегарти (лидер американской поп-группы Antony and the Johnsons), продюсер Timbaland, ранее сотрудничавший с Мисси Эллиот, Джастином Тимберлейком и Jay-Z, и состоящий из десяти участниц исландский духовой ансамбль.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (135,435,'Канадцы создали мышь для PlayStation 3',2,'Канадская компания SplitFish выпустила FragFX, новую версию своего контроллера EdgeFX для PlayStation 3. Необычная правая часть контроллера представляет собой восьмикнопочную оптическую мышь со стандартными кнопками PlayStation на боковой части. В комплект также входит пластиковый твердый коврик для мыши.','Канадская компания SplitFish выпустила FragFX, новую версию своего контроллера EdgeFX для PlayStation 3, сообщается на сайте Gizmodo. Левая часть FragFX оснащена стандартными органами управления - двумя аналоговыми джойстиками. Необычная правая часть контроллера представляет собой восьмикнопочную оптическую мышь со стандартными кнопками PlayStation на боковой части. В комплект также входит пластиковый твердый коврик для мыши. Контроллер представлен в двух вариантах - USB и Bluetooth. Поддержка беспроводных мышей заявлена в сетевом сервисе Home для PlayStation 3, который появится осенью 2007 года. Sony PlayStation 3 появилась в продаже на территории США в ноябре 2006 года. В Европе консоль официально еще не вышла.',31,1174588082,1174588082);
INSERT INTO `news_news` VALUES (136,436,'Генеральный директор ИА \"Росбалт\" станет сенатором от Псковской области',2,'На пост сенатора от Псковской области выдвинута кандидатура гендиректора ИА \"Росбалт\" Hаталии Черкесовой. Как стало известно из источников в псковском парламенте, кандидатура Черкесовой будет предложена на первой после выборов сессии Псковского областного собрания, которая состоится 23 марта.','Hа пост сенатора от Псковской области выдвинута кандидатура генерального директора ИА \"Росбалт\" Hаталии Черкесовой. Об этом агентству \"Интерфакс\" стало известно из источников в псковском парламенте. Как сообщил источник, кандидатура Черкесовой будет предложена на первой после выборов сессии Псковского областного собрания, которая состоится 23 марта. Эти сведения подтверждает и Псковское агентство информации. Наталия Черкесова родилась 15 февраля 1957 года в Ленинграде. Окончила факультет журналистики Ленинградского государственного университета. Работала корреспондентом газеты \"Смена\", главным редактором газеты \"Ленинские искры\". С 1990 по 2004 год была главным редактором газеты \"Час Пик\" (\"Петербургский Час Пик\"). В настоящее время возглавляет ИА \"Росбалт\" и совет директоров ООО \"Петербургский Час Пик\". Муж Наталии Черкесовой, Виктор Черкесов - директор Федеральной службы РФ по контролю за оборотом наркотиков. Ранее Виктор Черкесов был полномочным представителем президента по Северо-Западному федеральному округу.',29,1174588082,1174588082);
INSERT INTO `news_news` VALUES (137,437,'Столкновением двух МиГов занялась военная прокуратура',2,'По факту столкновения двух военных самолетов МиГ-29, происшедшего 21 марта в ходе плановых полетов в 40 километрах от авиагарнизона Миллерово в Ростовской области, военная прокуратура Северо-Кавказского военного округа возбудила уголовное дело по статье за нарушение правил полетов или подготовки к ним.','По факту столкновения двух военных самолетов МИГ-29, происшедшего 21 марта в ходе плановых полетов в 40 километрах от авиагарнизона Миллерово в Ростовской области, военная прокуратура Северо-Кавказского военного округа возбудила уголовное дело, передает РИА Новости. Представитель военной прокуратуры отметил, что уголовное дело возбуждено по статье 351 УК РФ (\"нарушение правил полетов или подготовки к ним\"). Как стало известно, на месте происшествия уже работает специально созданная следственная группа из представителей военной прокуратуры. Напомним, что, по словам помощника главкома ВВС России полковника Александра Дробышевского, столкновение произошло 21 марта в 16:02 по московскому времени в 40 километрах от авиагарнизона Миллерово в ходе проведения плановых полетов. Сообщается, что при столкновении летчики успели катапультироваться. Пилотов уже подобрали спасательные вертолеты и доставили в медсанчасть. Их состояние расценивается как удовлетворительное. По последним данным, в результате инцидента жертв и разрушений на земле нет.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (138,438,'Басманный суд арестовал имущество главы концерна \"Нефтяной\"',2,'Басманный суд наложил арест на имущество главы концерна \"Нефтяной\" Игоря Линшица, обвиняемого в незаконной банковской деятельности и отмывании денежных средств. Как подчеркнул адвокат Линшица Генрих Падва, арестованные судом акции и дом в Москве \"только приписывается Линщицу\", но не принадлежат ему в действительности.','Басманный суд Москвы наложил арест на имущество главы концерна \"Нефтяной\" Игоря Линшица, обвиняемого в незаконной банковской деятельности и отмывании денежных средств, передает РИА Новости, ссылаясь на адвоката Линшица Генриха Падву. По его словам, арест был наложен на акции и дом в Москве. В то же время адвокат подчеркнул, что \"суд арестовал имущество, которое только приписывается Линшицу\". \"Собственником этого имущества он не является\", - заявил Падва, добавив, что защита Линшица намерена до 23 марта обжаловать это решение как незаконное. Напомним, что обвинения по двум статьям УК были предъявлены Линшицу в середине января 2006 года. По данным следствия, глава концерна \"Нефтяной\" \"в составе организованной группы совершал незаконные банковские операции и получил в результате незаконный доход в размере 57 миллиардов рублей\". Как утверждает обвинение, 610 миллионов рублей Линшиц затем легализовал\". C февраля 2006 года Линшиц находится в федеральном и международном розыске, а 1 марта того же года Басманный суд столицы заочно выдал санкцию на арест банкира.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (139,439,'Создатели Duke Nukem Forever признали свои ошибки',2,'Создатели шутера Duke Nukem Forever признались в том, что наделали ошибок при разработке игры. Заявление соответствующего содержания сделал Скотт Миллер, основатель компании Apogee Software. Миллер также сказал, что разработчики переоценили свои возможности, попытавшись создать \"лучшую в мире игру\".','Создатели шутера Duke Nukem Forever признались в том, что наделали ошибок при разработке игры, сообщается на сайте The Inquirer. Заявление соответствующего содержания сделал Скотт Миллер (Scott Miller), основатель компании Apogee Software. Миллер также сказал, что разработчики переоценили свои возможности, попытавшись создать \"лучшую в мире игру\". Разработка Duke Nukem Forever (\"Дюк Нюкем навсегда\"), сиквела к шутеру от первого лица Duke Nukem 3D, началась в 1997 году. Создатели до сих пор не раскрыли сюжет и список персонажей. Кроме того, \"движок\", на основе которого создается игра, неоднократно менялся. \"Мы признаем, что наделали ошибок, и игра превратилась в повод для насмешек. В последние полтора года мы стали более реалистично смотреть на вещи, и теперь, думаю, движемся в правильном направлении\" - заявил Миллер. Тем не менее, ориентировочная дата появления готовой игры до сих пор не известна.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (140,440,'Частная ракета Falcon долетела до космоса',2,'В США осуществлен испытательный старт частной ракеты Falcon 1, построенной Space Exploration Technologies Corp. 21-метровая Falcon 1 успешно ушла со стартового стола, однако через пять минут связь с ракетой была потеряна. Тем не менее, устройство можно считать покинувшим атмосферу и достигшим космического пространства.','В США осуществлен испытательный старт частной ракеты Falcon 1, построенной Space Exploration Technologies Corp. (SpaceX). Аппарат был запущен со специального пускового комплекса на одном из атоллов в районе Маршалловых островов. Старт прошел со второй попытки. Первоначально подготовительный цикл был автоматически прерван за 90 секунд до запланированного времени запуска из-за программного сбоя. 21-метровая Falcon 1 успешно ушла со стартового стола, однако через пять минут связь с ракетой была потеряна. Предположительно, из-за возникшего вращения второй ступени ее двигатель автоматически выключился, и она, не достигнув нужной высоты, вернулась в плотные слои атмосферы. Тем не менее, устройство можно считать покинувшим атмосферу и достигшим космического пространства. Руководство компании оценивает проведенный запуск как успешный. Год назад аналогичный запуск привел к взрыву ракеты непосредственно после отрыва от земли. В перспективе, компания SpaceX планирует получить от NASA контракт на поставку грузов на МКС, сумма которого составляет 278 миллионов долларов. На следующий старт ракета Falcon, утверждают в компании, выйдет с полезной нагрузкой.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (141,441,'Парламент Белоруссии передумал стерилизовать асоциальных личностей',2,'Депутаты белорусского парламента отказались от идеи законодательно оформить стерилизацию асоциальных личностей. Об этом сообщил председатель комиссии по правам человека нижней палаты парламента республики Юрий Кулаковский. По его словам, депутаты не в праве запрещать заводить потомство людям, вне зависимости от их социального положения.','Депутаты белорусского парламента отказались от идеи законодательно оформить стерилизацию асоциальных личностей. Об этом, как пишет в среду Telegraf.by, сообщил председатель комиссии по правам человека нижней палаты парламента республики Юрий Кулаковский. По его мнению, такое решение не даст требуемых результатов, тем более что депутаты не вправе лишать людей возможности завести детей, вне зависимости от их социального положения. Напротив, считает Кулаковский, для женщины появление детей даже может стать поводом исправить свою жизнь. Еще два года назад депутат Палаты представителей (нижней палаты парламента) Национального собрания Белоруссии Сергей Костян настаивал на необходимости принять в республике закон о насильственной стерилизации асоциальных лиц. Депутат предлагал применять этот закон в единичных случаях, чтобы он послужил строгим предупреждением для тех, кто \"ведет безобразный половой образ жизни\".',22,1174588082,1174588082);
INSERT INTO `news_news` VALUES (142,442,'Губернатор Громов окажет помощь семьям погибших шахтеров',2,'Губернатор Московской области Борис Громов направил в администрацию Кемеровской области 10 миллионов рублей из своего резервного фонда. Как сообщили в пресс-службе главы Подмосковья, деньги предназначены для оказания помощи родственникам горняков, погибших в результате взрыва на шахте \"Ульяновская\".','Губернатор Московской области Борис Громов направил в администрацию Кемеровской области 10 миллионов рублей из своего резервного фонда. Как сообщает РИА Новости со ссылкой на пресс-службу главы Подмосковья, деньги предназначены для оказания помощи родственникам погибших шахтеров. \"Эти деньги направляются в качестве помощи от всех жителей Московской области\", - подчеркнули в пресс-службе. Ранее начальник Управления МЧС РФ Ирина Андрианова заявила, что семьи погибших получат от 1,3 до 2 миллионов рублей. Источник, из которого будут сделаны выплаты, не уточнялся. Также сообщалось, что по соглашению между администрацией Кемеровской области и компанией \"Южкузбассуголь\", которой принадлежит шахта, родственники получат помощь, минимальный размер которой составит миллион рублей. Также компания возьмет на себя оплату обучения детей погибших. Авария на шахте \"Ульяновская\" в Кемеровской области произошла утром 19 марта. Предварительное следствие пришло к выводу, что ее причиной стал взрыв метана. Число погибших, по последним данным, составляет 108 человек. Всего на момент взрыва в шахте находилось 203 горняка.',21,1174588082,1174588082);
INSERT INTO `news_news` VALUES (143,443,'Спасатели подобрали летчиков двух столкнувшихся МиГов',2,'Пилоты двух военных самолетов МиГ-29, столкнувшихся 21 марта в воздухе недалеко от авиагарнизона Миллерово, подобраны спасателями и доставлены на вертолете в медсанчасть. Состояние здоровья летчиков расценивается как удовлетворительное.','Пилоты двух военных самолетов МиГ-29, столкнувшихся 21 марта в воздухе недалеко от авиагарнизона Миллерово, подобраны спасателями и доставлены на вертолете в медсанчасть, передает агентство \"Интерфакс\" со ссылкой на помощника главкома ВВС России полковника Александра Дробышевского. По словам Дробышевского, состояние пилотов расценивается как удовлетворительное. При столкновении оба летчика успели катапультироваться. Александр Дробышевский также уточнил, что столкновение произошло в 16:02 по московскому времени в 40 километрах от авиагарнизона Миллерово в ходе проведения плановых полетов. \"Жертв и разрушений на земле нет\", - заявил помощник главкома.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (144,444,'Присяжные признали вину взорвавших поезд \"Грозный-Москва\"',2,'Коллегия присяжных вынесла обвинительный вердикт подсудимым по делу о подрыве летом 2005 года поезда \"Грозный-Москва\". Большинством голосов Михаил Клевачев и Владимир Власов были признаны виновными по всем статьям, в том числе статье 205 (\"терроризм\") УК РФ.','Коллегия присяжных вынесла обвинительный вердикт Михаилу Клевачеву и Владимиру Власову - подсудимым по делу о подрыве летом 2005 года поезда \"Грозный-Москва\", сообщает РИА Новости. \"Большинством голосов они оба были признаны виновными по всем статьям, в том числе статье 205 (\"терроризм\") УК РФ\", - заявил адвокат одного из обвиняемых Валерий Прилепский. Вместе с тем, коллегия сочла, что фигуранты дела заслуживают снисхождения. На 2 апреля суд назначил заседание, в ходе которого будут обсуждаться последствия вердикта присяжных. Согласно закону, на данной стадии прокурор попросит назначить сроки наказания подсудимым, затем слово будет предоставлено стороне защиты. После выступления сторон суд удалится на вынесение приговора.',18,1174588082,1174588082);
INSERT INTO `news_news` VALUES (145,445,'Google поменяет систему контекстной рекламы',2,'По правилам новой системы Google, рекламодатель платит только в том случае, если после перехода по рекламной ссылке пользователь зарегистрировался в рекламируемом сервисе, заполнил анкету или приобрел продукцию фирмы. Такая система позволит рекламодателям сэкономить на онлайн-рекламе и уменьшить риск фальшивых показов.','Компания Google тестирует новую систему контекстной рекламы. По новым правилам, рекламодатель платит только в том случае, если после перехода по рекламной ссылке пользователь зарегистрировался в рекламируемом сервисе, заполнил анкету или приобрел продукцию фирмы, сообщает The New York Times. Нынешние системы онлайн-рекламы подразумевают оплату каждого показа баннера или перехода по ссылке на сайт рекламодателя, независимо от того, получил ли тот прибыль от такой рекламы. Рекламодатели с энтузиазмом восприняли идею Google. Во-первых, такая система позволит сэкономить на онлайн-рекламе, поскольку компаниям не придется платить за объявления, не дающие финансовой прибыли. А во-вторых, новая система уменьшает риск генерации фальшивых показов рекламы с подставных адресов.',30,1174588083,1174588083);
INSERT INTO `news_news` VALUES (146,446,'В шахте \"Ульяновская\" найден еще один погибший',2,'Тело еще одного погибшего обнаружено в ходе спасательных работ в шахте \"Ульяновская\", где 20 марта произошел взрыв скопившегося метана. Таким образом общее число жертв достигло 108 человек. В шахте продолжаются поиски еще двух горняков, которые пока числятся пропавшими без вести.','Тело еще одного погибшего обнаружено в ходе спасательных работ в шахте \"Ульяновская\", где 20 марта произошел взрыв скопившегося метана. Об этом, как передает ИТАР-ТАСС, сообщили в управлении МЧС по Кемеровской области. Таким образом, общее число жертв достигло 108 человек. В шахте продолжаются поиски еще двух горняков, которые пока числятся пропавшими без вести. Напомним, что спасти после взрыва удалось 93 человека, из находившихся в шахте на момент аварии. Сейчас, по словам специалистов, часть шахты затоплена водой, в ней сохраняется высокая концентрация метана. Предполагается, что поисковые работы продлятся еще три дня. В то же время представители ОАО \"Объединенная угольная компания \"Южкузбассуголь\", которой принадлежит \"Ульяновская\", поспешили заявить, что эта шахта будет восстановлена. Впрочем, оговорившись, что \"детали и нюансы будут известны после того, как пройдет расследование и будет понятно, в каком состоянии она находится\".',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (147,447,'Великобритания запретила неуправляемые кассетные бомбы',2,'Правительство Великобритании запретило использование неуправляемых кассетных боеприпасов в связи с большим числом жертв среди мирного населения. В результате, британские вооруженные силы могут использовать только те кассетные боеприпасы, которые снабжены системой управления и самоликвидации в случае несрабатывания.','Британское правительство запретило использование неуправляемых кассетных боеприпасов, сообщает Defencetalk. Причиной запрета стала неизбирательность действия неуправляемых кассетных боеприпасов, приводящая к большому количеству жертв среди мирного населения как в момент подрыва бомбы, так и впоследствии, от взрыва несработавших боеприпасов. Теперь британские вооруженные силы могут использовать только кассетные бомбы и снаряды, снабженные системой управления и самоликвидации, обеспечивающей уничтожение боеприпасов в случае несрабатывания взрывателя. Инициаторами запрета стали правозащитные организации, в том числе \"Международная амнистия\", представившие данные о большом количестве подрывов мирных жителей на несработавших боеприпасах, иногда через много лет после окончания вооруженного конфликта. Следует отметить, что Великобритания первой из крупных держав запретила использование неуправляемых кассетных боеприпасов.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (148,448,'Уголовное дело против Юрия Луценко приостановлено',2,'Подольский районный суд Киева приостановил расследование уголовного дела против бывшего министра внутренних дел, лидера общественной организации \"Народная самооборона\" Юрия Луценко для определения законности его возбуждения. Об этом сообщил адвокат Луценко Юрий Мартыненко. Луценко подозревается в незаконной выдаче 51 единицы оружия.','Подольский районный суд Киева приостановил расследование уголовного дела против бывшего министра внутренних дел, лидера общественной организации \"Народная самооборона\" Юрия Луценко для определения законности его возбуждения. Об этом, как передает ProUA, сообщил адвокат Луценко Юрий Мартыненко. По его словам, еще во вторник в суд была подана жалоба юристов Луценко на постановление Генпрокуратуры о возбуждении уголовного дела против бывшего шефа МВД. Суд открыл производство по данной жалобе и приостановил следствие Генпрокуратуры. Как сообщалось ранее, 2 марта Генеральная прокуратура возбудила в отношении Луценко уголовное дело по двум статьям Уголовного кодекса, а именно части 3 статьи 364 – злоупотребление властью или служебным положением, совершенные работником правоохранительного органа и повлекшее тяжелые последствия, и части 1 статьи 263 - незаконное обращение с оружием и боеприпасами. Луценко подозревается, в частности, в незаконной выдаче сотрудникам МВД 51 единицы оружия. Утром 20 марта сотрудники прокуратуры в рамках расследования уголовного дела против Луценко провела обыск в его квартире в Печерском районе. После этого бывший министр был вызван на допрос. В среду, 21 марта Луценко снова пошел на допрос в Генпрокуратуру, после чего его адвокаты заявили о приостановке дела.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (149,449,'Читинский облсуд подтвердил незаконность помещения Ходорковского в ШИЗО',2,'Читинский областной суд 21 марта подтвердил, что помещение экс-главы \"ЮКОСа\" Михаила Ходорковского в ШИЗО за неучтенные продукты, которые у него нашли после свидания, было незаконным. Ранее такое же решение было вынесено и городским судом Краснокаменска.','Читинский областной суд 21 марта подтвердил, что помещение экс-главы \"ЮКОСа\" Михаила Ходорковского в ШИЗО за неучтенные продукты, которые у него нашли после свидания, было незаконным, сообщает \"Интерфакс\" со ссылкой на адвоката Ходорковского Наталью Терехову. Поводом для заключения экс-главы \"ЮКОСа\" на 10 суток в ШИЗО 3 июня прошлого года стали два лимона, найденные у него при обыске. Основанием для взыскания стал пункт 15 правил внутреннего распорядка исправительных учреждений, запрещающий заключенным \"продавать, покупать, дарить, принимать в дар, отчуждать иным способом в пользу других осужденных либо присваивать продукты питания, предметы и вещества, находящиеся в личном пользовании\". Краснокаменский городской суд посчитал это наказание неправомерным. Администрация колонии общего режима обжаловала решение суда первой инстанции, однако, областной суд склонился в пользу городского, оставив тем самым решение в силе, сказала адвокат. Напомним, что Ходорковского уже трижды сажали в ШИЗО по обвинению в различных проступках, но Краснокаменский суд все три раза признавал эти взыскания незаконными.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (150,450,'Кубинцы отреставрируют дом Хемингуэя к 2009 году',2,'Реставрация кубинской виллы Эрнста Хемингуэя продлится до 2009 года. В доме \"Финка Вихиа\", расположенном к югу от Гаваны, Хемингуэй жил между 1939 и 1960 годами. Там он написал свою знаменитую повесть \"Старик и море\" и другие произведения. После самоубийства писателя вилла была передана кубинскому правительству.','Реставрация кубинской виллы Эрнста Хемингуэя продлится до 2009 года. Музейные работники назвали причиной задержки строительство гаража для вновь найденного автомобиля, на котором писатель ездил по острову, сообщило агентство Associated Press. Сумма, которая должна быть затрачена на ремонт, не разглашается, но известно, что финансирует проект кубинское правительство. В доме под названием \"Финка Вихиа\" (\"Finca Vigia\"), расположенном к югу от Гаваны, Хемингуэй жил между 1939 и 1960 годами. Там он написал свою знаменитую повесть \"Старик и море\" и другие произведения. После самоубийства писателя в 1961 году его вдова передала виллу Фиделю Кастро, и уже в 1962 году там открылся музей. Однако за домом мало следили все эти годы, и он сильно пострадал. Литературоведов особенно беспокоит состояние архива Хемингуэя, оставшегося в \"Финка Вихиа\": там, среди прочего, находится неопубликованный эпилог к известному роману \"По ком звонит колокол\". В 2007 году музей \"Финка Вихиа\" отмечает 45-летие. Празднования начнутся 1 апреля - в годовщину первого визита Хемингуэя на Кубу (1928 год), а завершатся 21 июля - в день рождения писателя.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (151,451,'Итальянцам PlayStation 3 досталась на двое суток раньше европейской премьеры',2,'Итальянским игрокам удалось стать первыми в Европе, кто смог приобрести PAL-версию новейшей игровой системы от Sony PlayStation 3. Начало продаж консоли за двое суток до официально объявленного срока стало следствием желания местных ритейлеров обогнать друг друга. Sony имеет право подать иски против магазинов.','Итальянским игрокам удалось стать первыми в Европе, кто смог приобрести PAL-версию новейшей игровой системы от Sony PlayStation 3. Начало продаж консоли за двое суток до официально объявленного срока стало следствием желания местных ритейлеров обогнать друг друга, сообщается на сайте The Register. Срыв сроков запуска консоли произошел по вине местной сети магазинов Darty, представители которой разместили в местных СМИ объявление о том, что продажи PS3 в их торговых точках начнутся более чем за сутки до пятницы, 23 марта 2007 года - официальной даты релиза, названной Sony. Конкуренты Darty, сеть Media World, начала продавать PS3 уже сегодня в 9 утра по местному времени. Остальные магазины также решили не отставать от MW и начали торговать PS3 за двое суток до официального релиза. По мнению наблюдателей, чересчур расторопным продавцам могут грозить судебные иски от Sony. Представители последней выразили сожаление по поводу преждевременных продаж PS3 и заявили, что пока что раздумывают, какие действия предпринять против итальянских ритейлеров.',31,1174588083,1174588083);
INSERT INTO `news_news` VALUES (152,452,'Телефонный террорист заминировал АЭС в Швеции',2,'Часть персонала одной из трех шведских АЭС была эвакуирована утром 21 марта в связи с угрозой взрыва. Как сообщили представители правоохранительных органов Швеции, неизвестный позвонил в полицию и пообещал в 13:00 по местному времени взорвать электростанцию, если к полудню оттуда не будут эвакуированы люди.','Часть персонала одной из трех шведских АЭС - \"Форшмарк\" (Forsmark), расположенной близ города Упсала (Uppsala) к северу от Стокгольма, была эвакуирована утром 21 марта в связи с угрозой взрыва. Соответствующее сообщение было опубликовано на сайте шведской газеты Aftonbladet со ссылкой на представителя полицейского управления Упсалы Кристер Нурдстрем (Christer Nordstrom). По его словам, неизвестный позвонил в полицию около девяти часов утра по местному времени и пообещал в 13:00 взорвать электростанцию, если к полудню оттуда не будут эвакуированы люди. В полиции восприняли угрозу всерьез - люди с АЭС были эвакуированы, а прилегающие дороги перекрыты. В то же время Нурдстрем отметил, что АЭС покинули лишь административные сотрудники, в то время как эксплуатационный персонал остался на своих местах, а сама станция продолжала работать в штатном режиме.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (153,453,'Жак Ширак отложил мартовский визит к Путину',2,'Президент Франции Жак Ширак отложил свой визит в Россию, который был запланирован на конец марта. Новые сроки визита в настоящее время согласовываться по дипломатическим каналам. Владимир Путин планировал обсудить с ним \"широкий круг вопросов\", в частности касающихся энергетического сотрудничества.','Президент Франции Жак Ширак отложил свой визит в Россию, который был запланирован на конец марта, сообщает агентство \"Интерфакс\" со ссылкой на дипломатический источник в Москве. По его сведениям, новые сроки визита в настоящее время согласовываются по дипломатическим каналам. Российский президент Владимир Путин в ходе февральской встречи с главами министерства обороны и МИДа Франции заявил, что готов обсудить со своим французским коллегой \"широкий круг вопросов\", в частности касающихся энергетического сотрудничества. О причинах, по которым встречу Путина и Ширака отложили, ничего не сообщается. Вместе с тем, в среду президент Франции заявил, что на предстоящих президентских выборах он окажет поддержку министру внутренних дел Николя Саркози. 26 марта глава французского МВД покинет свой пост, чтобы участвовать в избирательной кампании.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (154,454,'Победители парламентских выборов в Эстонии поделили портфели',2,'Реформистская партия Эстония, выигравшая в начале марта парламентские выборы, получит в новом кабинете министров 7 портфелей. Об этом сообщил премьер-министр республики Андрус Ансип. Правая коалиция в составе партий \"Союз Отечества\" и \"Республика\" получит пять портфелей, социал-демократы - 3 и зеленые - один министерский пост.','Реформистская партия Эстония, выигравшая в начале марта парламентские выборы, получит в новом кабинете министров семь портфелей. Об этом, как пишет в среду Postimees, сообщил премьер-министр республики Андрус Ансип после собрания руководства партии. По его словам, правая коалиция в составе партий \"Союз Отечества\" и \"Республика\" получит пять портфелей, социал-демократы - 3 и зеленые - один министерский пост. При этом места главы МИДа и министра юстиции отойдут в новом правительстве Реформистской партии. Помимо портфелей министров юстиции и иностранных дел, сообщил далее премьер, реформисты должны получить и пост заместителя спикера парламента страны. А правые партии, полагает Ансип, кроме министерских кресел могут рассчитывать на место спикера законодательного собрания республики. Вместе с тем Ансип подчеркнул, что в среду на коалиционных переговорах обсуждаются прежде всего программные позиции. В случае, если текст коалиционного договора будет согласован всеми сторонами, четыре участвующие в переговорах партии перейдут к распределению министерских постов. Ранее сообщалось, что победу на прошедших в начале марта в Эстонии выборах одержала Реформистская партия, возглавляемая Ансипом. Реформисты заручились поддержкой 27,7 процента голосов избирателей. Таким образом, партия получила 31 из 101 мандата в парламенте.',22,1174588083,1174588083);
INSERT INTO `news_news` VALUES (155,455,'Хизер Миллс продолжает дружить с Полом Маккартни',2,'Хизер Миллс заявила, что до сих пор поддерживает дружеские отношениях со своим бывшим мужем Полом Маккартни. \"Мы остаемся друзьями. Это его юристы превращают жизнь в кошмар\" - заявила Миллс. Ранее сообщалось, что Миллс требовала от музыканта 3,4 миллионов фунтов в год (то есть около 10000 фунтов в день).','Хизер Миллс заявила, что до сих пор поддерживает дружеские отношениях со своим бывшим мужем Полом Маккартни, сообщает AFP. \"Мы остаемся друзьями. Это его юристы превращают жизнь в кошмар\" - заявила Миллс. \"Я до сих пор люблю его. И он отличный отец\" - добавила она. Напомним, что в 2003 году у Маккартни и Миллс, тогда супругов, появилась дочь, которую назвали Беатрис. О своем намерении развестись пара заявила в мае 2006 года. Брак Маккартни и Миллс продержался около четырех лет. Ранее сообщалось, что Миллс требовала от музыканта 3,4 миллионов фунтов в год (то есть около 10000 фунтов в день). Потом появилась информация о том, что бывшая супруга Маккартни согласилась на отступную сумму в размере 29 миллионов фунтов.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (156,456,'Анджелина Джоли вывезла нового сына из Вьетнама',2,'Анджелина Джоли покинула Вьетнам со своим новым 3-летним сыном Паксом Тхиен Джоли. Как сообщает AP, актриса воспользовалась услугами частного авиаперевозчика для перелета в США. За неделю, проведенную во Вьетнаме, Джоли лишь пару раз покидала свои апартаменты для того, чтобы заполнить необходимые бумаги.','Анджелина Джоли покинула Вьетнам со своим новым 3-летним сыном Паксом Тхиен Джоли. Как сообщает AP, актриса воспользовалась услугами частного авиаперевозчика для перелета в США. За неделю, проведенную во Вьетнаме, Джоли лишь пару раз покидала апартаменты роскошного отеля для того, чтобы заполнить необходимые для процедуры усыновления бумаги. Как отмечает агентство, она тщательно оберегала Пакса от десятков папарацци, которые постоянно дежурили возле гостиницы. Напомним, что это уже четвертый ребенок Джоли. У нее есть родная дочь Шило, отцом которой является Брэд Питт, и двое приемных детей Мэдокс и Захара. Ранее актриса заявляла, что намерена на время отказаться от съемок в фильмах, дабы больше внимания уделять своим детям, однако на днях появились сообщения о том, что Джоли подписала контракт на участие в фильме \"Wanted\", который снимает в Голливуде российский режиссер Тимур Бекмамбетов.',24,1174588083,1174588083);
INSERT INTO `news_news` VALUES (157,457,'Прокуратура передала церкви более 140 икон',2,'Юрий Чайка передал патриарху Алексию II беспрецедентно большую партию икон и церковной утвари - более 140 предметов. Все они были обнаружены таможенниками в 1999 году на североосетинско-грузинской границе в багажном отсеке автобуса. Часть возвращенных икон была похищена из храма в Московской области.','Генеральный прокурор РФ Юрий Чайка передал патриарху Алексию II беспрецедентно большую партию икон и церковной утвари - более 140 предметов. Все они были обнаружены таможенниками в 1999 году на североосетинско-грузинской границе в багажном отсеке автобуса. Часть возвращенных икон была похищена из храма Преображения в Саввино (Балашихинский район Московской области), сообщает \"Интерфакс\". До февраля 2007 года иконы и остальные предметы хранились в Североосетинском республиканском художественном музее. Поскольку никто не предъявил права на ценности, то Генпрокуратура постановила передать их РПЦ. Похищенное из храма Преображения возвращено настоятелю этой церкви. Представители прокуратуры заявили, что впервые возвращают церкви столь большое количество \"высокохудожественных и раритетных\" предметов.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (158,458,'Шахта \"Ульяновская\" будет восстановлена',2,'Кузбасская шахта \"Ульяновская\", в которой в результате недавнего ЧП погибли свыше ста человек, будет восстановлена и возобновит работу. \"Шахта будет восстановлена, но детали и нюансы будут известны после того, как пройдет расследование\", - пояснили в компании \"Южкузбассуголь\".','Кузбасская шахта \"Ульяновская\", в которой в результате недавнего ЧП погибли свыше ста человек, будет восстановлена и возобновит работу, сообщает \"Интерфакс\" со ссылкой на представителя ОАО \"Объединенная угольная компания \"Южкузбассуголь\". \"Шахта будет восстановлена, но детали и нюансы будут известны после того, как пройдет расследование и будет понятно, в каком состоянии она находится\", - пояснили в компании. Сейчас, по словам специалистов, часть шахты затоплена водой, в ней сохраняется высокая концентрация метана. Поисковые работы, как предполагается, продлятся еще три дня. На данный момент число погибших достигает 107 человек, пропавшими без вести числятся трое, еще 93 шахтера были спасены. Причиной происшествия на одной из наиболее современных шахт России стал взрыв метана, который распространился в забое из-за обрушения пород основной кровли шахты. По мнению Ростехнадзора, это могло произойти из-за проседания земной породы. Рассматривается также версия \"человеческого фактора\". Шахта \"Ульяновская\" была введена в эксплуатацию в октябре 2002 года, ее проектная мощность - 3 миллиона тонн угля в год, отмечает \"Интерфакс\".',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (159,459,'Путин станет гарантом профессионализма аудиторов Счетной палаты',2,'Госдума России во втором чтении приняла законопроект, предоставляющий президенту РФ право предлагать парламенту кандидатуры аудиторов Счетной палаты. В соответствии с действующими законами, аудиторов СП депутаты и сенаторы подбирают без консультаций с другими органами власти. Проект закона внесен самой палатой.','Госдума России во втором чтении одобрила законопроект, предоставляющий президенту РФ право предлагать парламенту кандидатуры аудиторов Счетной палаты, сообщает РИА Новости. Новый закон должен \"исключить возможности нежелательного постороннего влияния на отбор кандидатов на должности аудиторов СП\" и стать \"дополнительной гарантией того, что в состав палаты войдут аудиторы, обладающие высокими профессиональными и личностными качествами\", передает агентство \"Росбалт\". В соответствии с документом, если предложенная главой государства кандидатура аудитора отклоняется, то в течение двух недель президент может внести новую - либо ранее отклоненную, либо другую. Решение о назначении аудиторов Счетной платы принимается простым большинством голосов депутатов Госдумы или сенаторов Совета Федерации. Также отменяется норма действующего закона, когда троих из 12 аудиторов Счетной палаты можно назначить на должность, если они имеют высшее образование, но опыт профессиональной деятельности у них \"иного профиля\". Действующее законодательство позволяет президенту вносить в парламент только кандидатуры руководителей контрольного ведомства, в частности председателя, которого утверждает Госдума, и его заместителя, кандидатуру которого должен одобрить Совет Федерации. Самих же аудиторов Счетной палаты парламентарии подбирают без консультаций с другими органами власти. Напомним, законопроект, по которому аудиторы будут назначаться по представлению президента, был представлен Счетной палатой РФ в администрацию главы государства в январе 2007 года. Как заявлял председатель СП Сергей Степашин, участие президента в назначении аудиторов должно повысить их статус.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (160,460,'Глава \"Российского клуба\" в зале украинского суда объявил себя мессией',2,'Святошинский районный суд Киева перенес начало рассмотрения дела российского бизнесмена, главы \"Российского клуба\" Максима Курочкина на 27 марта, после того как подсудимый, обвиняемый в вымогательстве, прямо в зале суда объявил, что он \"мессия, сын Бога\". Судья сделал Курочкину замечание, однако оно на него не подействовало.','Святошинский районный суд Киева перенес начало рассмотрения дела российского бизнесмена, главы \"Российского клуба\" Максима Курочкина на 27 марта, после того как подсудимый, обвиняемый в вымогательстве, прямо в зале суда объявил, что он \"мессия, сын Бога\". Как передает ProUA, Курочкин сделал это \"признание\" в ответ на просьбу назвать свое имя. После такого ответа судья попросил подсудимого сосредоточиться и вести себя порядочно в зале судебного заседания. \"Это вы ведите себя порядочно\", - заявил в ответ Курочкин. При этом он начал признаваться в любви женщине по имени Юля, а также начал спорить со своим отцом, находившемся в зале суда. В связи со сложившейся ситуацией судья решил перенести заседание. Сотрудники спецподразделения МВД \"Беркут\" задержали разыскиваемого правоохранительными органами Украины российского бизнесмена Курочкина в аэропорту \"Борисполь\" 20 ноября. У украинской милиции есть два постановления Ялтинского суда, а также Голосеевского районного суда Киева о двух эпизодах вымогательства со стороны Курочкина, который был объявлен в розыск украинским МВД еще в 2005 году. Курочкин является исполнительным директором \"Российского клуба\" - неправительственной организации, созданной по инициативе представителей российской и украинской общественности для развития диалога между общественными, политическими и деловыми кругами России и Украины. Считается также, что Курочкин был одним из спонсоров предвыборной кампании Блока Натальи Витренко в 2006 году.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (161,461,'Подгузники Procter & Gamble не признаны сатанинскими',2,'Присяжные окружного суда штата Юта в США постановили, что продукция известного производителя чистящих и моющих средств, туалетных принадлежностей и средств ухода за телом, компании Procter & Gamble, не имеет никакого отношения к культу Сатаны. Судебный процесс по обвинению в сатанизме, длившийся 12 лет, завершен.','Присяжные окружного суда штата Юта в США постановили, что продукция известного производителя чистящих и моющих средств, туалетных принадлежностей и средств ухода за телом, компании Procter & Gamble, не имеет никакого отношения к культу Сатаны, пишет британская The Times. Процесс против клеветнических обвинений в адрес Procter & Gamble о приверженности компании культу Сатаны длился почти двенадцать лет. Главными ответчиками по делу выступали четыре бизнесмена из конкурирующей с P&G компании Amway Corporation. В 1994 году они распространили аудиообращение, в котором утверждалось, что часть прибыли P&G пускает на спонсирование сатаниствов. Суд постановил, что обвинямые должны выплатить Procter & Gamble 20 миллионов долларов в счет возмещения нанесенного ущерба. Между тем, как пишет The Times слухи о приверженности компании Procter & Gamble к культу Сатаны появились еще раньше, в 1981 году. Поводом для этого послужил старый логотип компании, который представлял собой изображение бородатого и рогатого человека с тринадцатью звездами вокруг головы. В этом увидели издевку над одним из христианских символов: \"И явилось на небе великое знамение: женщина, одетая в солнце; под ногами у нее луна, а на голове венец из двенадцати звезд. Женщина беременна и кричит от муки: у нее начались родовые схватки\" (Евангелист Иоанн. Откровение. 12 глава). Более того, утверждалось, что если поднести логотип к зеркалу, в отражении можно видеть, как на нем проступает число зверя 666. P&G тогда отвергла обвинения, объяснив, что тринадцать звезд соответствуют числу первых американских штатов. Тем не менее логотип сменили. Однако потом появились новые слухи о том, что президент P&G , выступая 1 марта 1994 года в эфире телешоу Фила Донахью, якобы открыто заявил, что значительная часть прибыли компании идет на поддержку церкви Сатаны и даже бахвалился, что никого вреда бизнесу это не нанесет. Руководство P&G тогда же выступило с официальным опровержением, что никто ни в каком телешоу не выступал и ничего подобного не говорил. В целом, как надеются в компании, вердикт присяжных положит конец спекуляциям на тему приверженности P&G сатанизму, на опровержение которых P&G уже потратила весьма крупные суммы.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (162,462,'Конституционный суд не удовлетворил жалобу коммунистов о референдуме',2,'Конституционный суд закончил рассмотрение жалобы, касающейся несоответствия норм, по которым отбираются вопросы для вынесения на референдум, Конституции РФ. Действующие нормы были признаны законными. Дело рассматривалось в связи с жалобой инициативной группы граждан, принадлежащих к КПРФ.','Конституционный суд закончил рассмотрение жалобы, касающейся несоответствия норм, по которым отбираются вопросы для вынесения на референдум, Конституции РФ. По сообщению РИА Новости, действующие нормы были признаны законными. В то же время, КС счел, что закон \"О референдуме\" не предполагает запрета на вынесение на референдум вопросов, не затрагивающих изменения действующего бюджета. Дело рассматривалось в связи с жалобой инициативной группы граждан, принадлежащих к КПРФ, которые в 2005 году выступили за проведение референдума. Голосование предлагалось провести по 17 вопросам, в том числе об отмене закона о монетизации льгот. В апреле 2005 года Центризбирком постановил, что большинство предложенных вопросов не соответствуют закону \"О референдуме РФ\", поскольку касаются федерального бюджета и внутренних финансовых обязательств государства. Инициативной группе было отказано в регистрации. Коммунисты обратились сначала в Верховный суд, который отклонил их жалобу, а затем и в Конституционный.',21,1174588083,1174588083);
INSERT INTO `news_news` VALUES (163,463,'Gears of War появится на экранах кинотеатров',2,'New Line Cinema приобрела права на создание фильма, основанного на Gears of War, шутере для приставки Xbox 360. Сюжет игры рассказывает о борьбе с Ордой Саранчи, враждебной расой инопланетян, на планете Sera. Сценаристом ленты станет Стюарт Битти, ранее работавший над фильмами \"Пираты Карибского моря\" и \"Соучастник\".','Компания New Line Cinema приобрела права на создание фильма, основанного на игре Gears of War, шутере для приставки Xbox 360, сообщает Reuters. Сценаристом ленты станет Стюарт Битти (Stuart Beattie), ранее работавший над фильмами \"Пираты Карибского моря\" и \"Соучастник\" (Collateral). Сценарист заявил, что ему предложили принять участие в создании киноверсии Gears of War как раз в тот момент, когда он играл на консоли Xbox 360. \"Представитель New Line Cinema Джефф Катз отправил мне сообщение через службу Xbox Live. \"Ты согласишься написать сценарий к фильму по игре, в которую сейчас играешь?\" - спросил он\" - рассказал Битти. Gears of War - футуристический трехмерный шутер, созданный компанией Epic Games. Его героем является Маркус Феникс, ведущий борьбу с Ордой Саранчи (Locust Horde), враждебной расой инопланетян, на планете Sera. Такой сюжет дает возможность создателям фильма уже сейчас сравнивать свое творение с классическим фантастическим боевиком \"Чужие\" (Aliens). Игра появилась в магазинах в ноябре 2006 года. За прошедшее с момента релиза время было продано более трех миллионов копий игры.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (164,464,'Британец украл миллион фунтов для пополнения коллекции гаджетов',2,'Стивена Незертона, 50-летнего финансового директора компании AarhusKarlshamn, производящей растительное масло, уличили в краже почти миллиона фунтов стерлингов. Это стало известно в ходе аудиторской проверки фирмы. Деньги были потрачены на новые гаджеты и коллекцию CD и DVD-дисков. Растратчик приговорен к 3,5 годам тюрьмы.','Стивена Незертона, 50-летнего финансового директора компании AarhusKarlshamn, производящей растительное масло, уличили в краже почти миллиона фунтов стерлингов. Это стало известно в ходе аудиторской проверки фирмы, сообщает The Times. Полиция не обнаружила во время обыска владений Незертона ни спортивных машин, ни яхт, ни крупных сумм наличности. Финансовый директор потратил украденные 848 тысяч фунтов на новые гаджеты, плазменные экраны и компьютеры, а также на CD/DVD-диски для своей коллекции. Стивен Незертон признан виновным в 30 кражах, совершенных в период с 1996 по 2004 год и приговорен к 3,5 годам тюрьмы. Жена финансового директора осуждена на 200 часов общественных работ по обвинению в одном случае растраты средств фирмы.',18,1174588083,1174588083);
INSERT INTO `news_news` VALUES (165,465,'BP упрекнули в халатности на американском НПЗ',2,'Руководство нефтяной компании BP три года подряд игнорировало сообщения о возможности аварий на НПЗ в Техасе, где в 2005 году произошел взрыв. По меньшей мере один топ-менеджер неоднократно получал отчеты, свидетельствующие о проблемах на заводе, говорится в докладе Комиссии по расследованию химических аварий в США.','Руководство нефтяной компании BP три года подряд игнорировало сообщения о возможности аварий на НПЗ в Техасе, где в 2005 году произошел взрыв. Об этом говорится в докладе Комиссии по расследованию химических аварий в США (Chemical Safety Board). Как следует из 335-страничного документа, по меньшей мере один топ-менеджер неоднократно получал отчеты, свидетельствующие о проблемах на заводе. При этом \"решения о сокращении финансирования бюджета предприятия принималось на самом высоком уровне в BP, несмотря на серьезные проблемы в системе безопасности завода\". Урезание расходов сделало НПЗ \"уязвимым перед катастрофой\", подчеркивается в докладе. Между тем, конкретных имен комиссия называть не стала. Взрыв на нефтеперерабатывающем заводе в Техасе произошел в марте 2005 года. В результате аварии погибли 15 рабочих, еще несколько сотен получили ранения. Взрыв стал самым серьезным ЧП в Соединенных Штатах с 1990 года. На компанию был наложен рекордный штраф в размере 21 миллиона долларов. Как установило следствие, авария произошла из-за неисправности оборудования. Комиссия по расследованию химических аварий США является независимым федеральным ведомством. Штаб-квартира организации располагается в Вашингтоне. Члены комиссии назначаются президентом Соединенных Штатов и утверждаются Сенатом.',26,1174588083,1174588083);
INSERT INTO `news_news` VALUES (166,466,'Сенат лишил администрацию США власти над прокурорами',2,'Американский Сенат проголосовал за ограничение права администрации назначать федеральных прокуроров без согласования с законодателями. Генеральному прокурору будет предписано в течение 120 дней найти замену обвинителям. Если же кандидатуры не будут утверждены Сенатом, прокуроров назначит окружной судья.','Американский Сенат проголосовал за ограничение права администрации назначать федеральных прокуроров без согласования с законодателями. Как сообщает AP, согласно новому закону, генеральному прокурору будет предписано в течение 120 дней найти замену любому из уволенных обвинителей. Если же предложенная кандидатура не будет утверждена Сенатом, прокурора назначит окружной судья. Объясняя свое решение, сенаторы настаивают, что администрация Буша превысила полномочия, которыми она была наделена после утверждения Патриотического акта. \"Если вы политизируете процедуру назначения и увольнения прокуроров, вы политизируете всю правоохранительную систему\", - прокомментировал итоги голосования глава юридического комитета Сената Патрик Лихи (Patrick Leahy). Утвержденный Сенатом законопроект должен еще пройти согласование в Палате представителей Конгресса. Напомним, что законодатели инициировали расследование обстоятельств увольнения восьми федеральных прокуроров, которое произошло в конце 2006 года. Законодатели полагают, что эти отставки были политически мотивированы.',24,1174588083,1174588083);
INSERT INTO `news_news` VALUES (167,467,'Президент Таджикистана отрезал от своей фамилии русское окончание',2,'Президент Таджикистана Эмомали Рахмонов пожелал внести коррективы в свою фамилию и впредь именоваться Эмомали Рахмоном. \"Я хотел бы, чтобы меня называли Эмомали Рахмоном, по имени покойного отца\", - заявил президент в среду. Известно, что в прошлом в Центральной Азии фамилии происходили от имени отца и не имели русских окончаний.','Президент Таджикистана Эмомали Рахмонов пожелал внести коррективы в свою фамилию и впредь именоваться Эмомали Рахмоном. Об этом он, как передает ИТАР-ТАСС объявил, выступая в среду перед интеллигенцией страны накануне праздника Навруз. По словам президента республики, таджикам \"необходимо вернуться к нашим культурным корням и использовать национальную топонимику\". \"Например, в различных документах, в том числе, международных, мои имя и фамилию называют по-разному, - отметил глава государства. - Поэтому я хотел бы, чтобы меня называли Эмомали Рахмоном, по имени покойного отца\". При этом президент призвал интеллигенцию пересмотреть не только окончания своих фамилий, но и названия исторических мест, памятников национальной культуры. Заметим, что до прихода советской власти у мусульман Центральной Азии фамилии происходили от имени отца и не имели русских окончаний.',22,1174588083,1174588083);
INSERT INTO `news_news` VALUES (168,468,'На Андаманских островах появилось кровоточащее изображение Христа',2,'В Порт-Блэр, столицу индийской территории Андаманские и Никобарские острова, съезжаются тысячи верующих, чтобы увидеть кровоточащее изображение Иисуса Христа. Пятна крови проявились на двух образах в доме сельского полицейского 8 марта. Он привез одну из картин в город, чтобы местные христиане могли убедиться в чуде.','В столицу индийской территории Андаманские и Никобарские острова Порт-Блэр съезжаются тысячи верующих, чтобы увидеть кровоточащее изображение Иисуса Христа. Картина помещена в дом епископа Пола Кристофера полицейским Эриком Натаниелем, ставшим первым свидетелем чуда, сообщает AFP. Натаниель, этнический никобарец, рассказал, что картина, стоявшая на столе в гостиной его дома, начала кровоточить вечером 8 марта. Семья полицейского зажгла свечи и начала молиться, через некоторое время кровь перестала капать. Спустя два дня на картине снова появилась кровь; а у еще одного изображения Христа обнаружилась кровь на руках и на сердце. Полицейский отвез первый образ в Порт-Блэр епископу, чтобы другие верующие смогли увидеть картину своими глазами. В настоящее время образ не кровоточит, а епископ Кристофер оказался недоступен для комментариев. Местный англиканский священник по имени Джон Хризостом (John Chrysostom - английская транскрипция имени отца церкви IV-V веков Иоанна Златоуста. - прим. Lenta.ru) назвал происшествие с картиной Натаниеля \"чудом\", свидетельствующим о том, что \"Христос оплакивает наши грехи\". Андманские и Никобарские острова сильно пострадали во время разрушительного цунами, обрушившегося на Юго-Восточную Азию в 2004 году.',18,1174588083,1174588083);

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

INSERT INTO `news_newsfolder` VALUES (2,6,'root','Новости',1,'root');
INSERT INTO `news_newsfolder` VALUES (18,295,'main','Главное',17,'root/main');
INSERT INTO `news_newsfolder` VALUES (19,296,'comments','Комментарии',18,'root/comments');
INSERT INTO `news_newsfolder` VALUES (20,297,'story','Сюжеты',19,'root/story');
INSERT INTO `news_newsfolder` VALUES (21,298,'russia','В России',20,'root/russia');
INSERT INTO `news_newsfolder` VALUES (22,299,'xussr','б.СССР',21,'root/xussr');
INSERT INTO `news_newsfolder` VALUES (23,300,'world','В мире',22,'root/world');
INSERT INTO `news_newsfolder` VALUES (24,301,'america','Америка',23,'root/america');
INSERT INTO `news_newsfolder` VALUES (25,302,'economy','Экономика',24,'root/economy');
INSERT INTO `news_newsfolder` VALUES (26,303,'business','Бизнес',25,'root/business');
INSERT INTO `news_newsfolder` VALUES (27,304,'finance','Финансы',26,'root/finance');
INSERT INTO `news_newsfolder` VALUES (28,305,'realty','Недвижимость',27,'root/realty');
INSERT INTO `news_newsfolder` VALUES (29,306,'politic','Политика',28,'root/politic');
INSERT INTO `news_newsfolder` VALUES (30,307,'internet','Интернет',29,'root/internet');
INSERT INTO `news_newsfolder` VALUES (31,308,'tehnology','Технологии',30,'root/tehnology');

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

INSERT INTO `page_page` VALUES (1,9,'main','Первая страница','Это <b>первая</b>, главная <strike>страница</strike><br />\n{load module=\"voting\" section=\"voting\" action=\"viewActual\" name=\"simple\"}\n',1,1);
INSERT INTO `page_page` VALUES (2,10,'404','404 Not Found','Запрашиваемая страница не найдена!',1,NULL);
INSERT INTO `page_page` VALUES (3,11,'test','test','test',1,NULL);
INSERT INTO `page_page` VALUES (4,57,'403','Доступ запрещён','Доступ запрещён',1,NULL);
INSERT INTO `page_page` VALUES (5,164,'pagename','123','234',2,NULL);
INSERT INTO `page_page` VALUES (6,165,'asd','qwe','asd',2,NULL);
INSERT INTO `page_page` VALUES (7,166,'12345','1','qwe',2,NULL);
INSERT INTO `page_page` VALUES (8,167,'1236','2','asd',2,NULL);
INSERT INTO `page_page` VALUES (9,168,'1237','3','qwe',2,NULL);
INSERT INTO `page_page` VALUES (10,169,'1234','ffffff','f',2,NULL);
INSERT INTO `page_page` VALUES (11,170,'ss','ква','sdaf',2,NULL);

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

INSERT INTO `sys_cfg_titles` VALUES (1,'Элементов на странице');
INSERT INTO `sys_cfg_titles` VALUES (2,'Каталог загрузки');
INSERT INTO `sys_cfg_titles` VALUES (3,'Кэширование');
INSERT INTO `sys_cfg_titles` VALUES (4,'Ширина создаваемой превьюшки');
INSERT INTO `sys_cfg_titles` VALUES (5,'Длина создаваемого превью');
INSERT INTO `sys_cfg_titles` VALUES (6,'Ширина создаваемого превью');
INSERT INTO `sys_cfg_titles` VALUES (7,'Секция файлменеджера');
INSERT INTO `sys_cfg_titles` VALUES (8,'Количество последних фотографий');

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

INSERT INTO `sys_modules` VALUES (1,'news',1,'Новости','news.gif',10);
INSERT INTO `sys_modules` VALUES (2,'user',3,'Пользователи','users.gif',90);
INSERT INTO `sys_modules` VALUES (4,'page',6,'Страницы','pages.gif',20);
INSERT INTO `sys_modules` VALUES (5,'access',7,'Права доступа','access.gif',10);
INSERT INTO `sys_modules` VALUES (6,'admin',9,'Администрирование','admin.gif',20);
INSERT INTO `sys_modules` VALUES (8,'comments',10,'Комментарии','comments.gif',40);
INSERT INTO `sys_modules` VALUES (9,'fileManager',17,'Менеджер файлов','fm.gif',50);
INSERT INTO `sys_modules` VALUES (10,'catalogue',19,'Каталог','catalogue.gif',30);
INSERT INTO `sys_modules` VALUES (11,'gallery',21,'Галерея','gallery.gif',80);
INSERT INTO `sys_modules` VALUES (12,'menu',26,'Меню','pages.gif',90);
INSERT INTO `sys_modules` VALUES (13,'voting',30,'Голосование','voting.gif',0);
INSERT INTO `sys_modules` VALUES (14,'message',32,'Сообщения пользователей','page.gif',0);
INSERT INTO `sys_modules` VALUES (15,'forum',35,'Форум','',0);
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

INSERT INTO `sys_sections` VALUES (1,'news','Новости',50);
INSERT INTO `sys_sections` VALUES (2,'user','Пользователи',80);
INSERT INTO `sys_sections` VALUES (4,'page','Страницы',60);
INSERT INTO `sys_sections` VALUES (6,'sys','Системное',0);
INSERT INTO `sys_sections` VALUES (7,'admin','Администрирование',10);
INSERT INTO `sys_sections` VALUES (8,'comments','Комментарии',30);
INSERT INTO `sys_sections` VALUES (9,'fileManager','Менеджер файлов',40);
INSERT INTO `sys_sections` VALUES (10,'catalogue','Каталог',20);
INSERT INTO `sys_sections` VALUES (11,'gallery','Галерея',80);
INSERT INTO `sys_sections` VALUES (12,'menu','Меню',50);
INSERT INTO `sys_sections` VALUES (13,'voting','Голосование',0);
INSERT INTO `sys_sections` VALUES (14,'message','Сообщения пользователей',0);
INSERT INTO `sys_sections` VALUES (15,'forum','Форум',0);
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

INSERT INTO `tags_tags` VALUES (1,'Путин',1162);
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

INSERT INTO `voting_answer` VALUES (2,'Да',0,1,799);
INSERT INTO `voting_answer` VALUES (5,'Нет',0,1,823);
INSERT INTO `voting_answer` VALUES (10,'Свой вариант',2,1,854);

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

INSERT INTO `voting_question` VALUES (1,'Вы верите в розового жирафика?',1,1186015080,1186188060,796);

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

INSERT INTO `voting_votecategory` VALUES (1,'simple','Простая',837);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
