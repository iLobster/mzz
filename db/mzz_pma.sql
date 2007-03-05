-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Мар 05 2007 г., 16:12
-- Версия сервера: 4.1.16
-- Версия PHP: 5.1.6
-- 
-- БД: `mzz`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogue`
-- 

DROP TABLE IF EXISTS `catalogue_catalogue`;
CREATE TABLE `catalogue_catalogue` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `editor` int(11) default NULL,
  `created` int(11) default NULL,
  `obj_id` int(11) default NULL,
  `folder_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `folder_id` (`folder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `catalogue_catalogue`
-- 

INSERT INTO `catalogue_catalogue` VALUES (2, 2, 10, 777, 238, 1);
INSERT INTO `catalogue_catalogue` VALUES (8, 1, 10, 777, 246, 1);
INSERT INTO `catalogue_catalogue` VALUES (11, 1, 10, 777, 250, 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogueFolder`
-- 

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

-- 
-- Дамп данных таблицы `catalogue_catalogueFolder`
-- 

INSERT INTO `catalogue_catalogueFolder` VALUES (1, 241, 'root', '/', 1, 'root');
INSERT INTO `catalogue_catalogueFolder` VALUES (2, 249, 'test', 'test', 2, 'root/test');

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogueFolder_tree`
-- 

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

-- 
-- Дамп данных таблицы `catalogue_catalogueFolder_tree`
-- 

INSERT INTO `catalogue_catalogueFolder_tree` VALUES (1, 1, 4, 1);
INSERT INTO `catalogue_catalogueFolder_tree` VALUES (2, 2, 3, 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogue_data`
-- 

DROP TABLE IF EXISTS `catalogue_catalogue_data`;
CREATE TABLE `catalogue_catalogue_data` (
  `id` int(11) NOT NULL default '0',
  `property_type` int(11) unsigned default NULL,
  `value` text,
  UNIQUE KEY `property_type` (`property_type`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `catalogue_catalogue_data`
-- 

INSERT INTO `catalogue_catalogue_data` VALUES (2, 4, 'LG FLATRON L1717S 17''');
INSERT INTO `catalogue_catalogue_data` VALUES (2, 5, 'ATI Radeon 9600Pro');
INSERT INTO `catalogue_catalogue_data` VALUES (2, 6, 'Seagate 5400 80gb');
INSERT INTO `catalogue_catalogue_data` VALUES (11, 12, '1985');
INSERT INTO `catalogue_catalogue_data` VALUES (8, 3, 'Запорожец');
INSERT INTO `catalogue_catalogue_data` VALUES (2, 18, 'Pentium4 - 2400 MHz');
INSERT INTO `catalogue_catalogue_data` VALUES (8, 17, '0%');
INSERT INTO `catalogue_catalogue_data` VALUES (8, 12, '1983');
INSERT INTO `catalogue_catalogue_data` VALUES (11, 17, '10%');
INSERT INTO `catalogue_catalogue_data` VALUES (11, 3, 'Жигули');

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogue_properties`
-- 

DROP TABLE IF EXISTS `catalogue_catalogue_properties`;
CREATE TABLE `catalogue_catalogue_properties` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `catalogue_catalogue_properties`
-- 

INSERT INTO `catalogue_catalogue_properties` VALUES (1, 'comfort', 'Комфортабельность');
INSERT INTO `catalogue_catalogue_properties` VALUES (2, 'year', 'Год выпуска');
INSERT INTO `catalogue_catalogue_properties` VALUES (3, 'marka', 'Марка');
INSERT INTO `catalogue_catalogue_properties` VALUES (4, 'monitor', 'Монитор');
INSERT INTO `catalogue_catalogue_properties` VALUES (5, 'videocard', 'Видеокарта');
INSERT INTO `catalogue_catalogue_properties` VALUES (6, 'harddrive', 'Жесткий диск');
INSERT INTO `catalogue_catalogue_properties` VALUES (7, 'processor', 'Процессор');

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogue_types`
-- 

DROP TABLE IF EXISTS `catalogue_catalogue_types`;
CREATE TABLE `catalogue_catalogue_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `title` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `catalogue_catalogue_types`
-- 

INSERT INTO `catalogue_catalogue_types` VALUES (1, 'autos', 'Автомобили');
INSERT INTO `catalogue_catalogue_types` VALUES (2, 'computers', 'Компьютеры');
INSERT INTO `catalogue_catalogue_types` VALUES (6, 'test', 'Тестовая');

-- --------------------------------------------------------

-- 
-- Структура таблицы `catalogue_catalogue_types_props`
-- 

DROP TABLE IF EXISTS `catalogue_catalogue_types_props`;
CREATE TABLE `catalogue_catalogue_types_props` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_id` int(11) unsigned default NULL,
  `property_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_id` (`type_id`,`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `catalogue_catalogue_types_props`
-- 

INSERT INTO `catalogue_catalogue_types_props` VALUES (17, 1, 1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (18, 2, 7);
INSERT INTO `catalogue_catalogue_types_props` VALUES (3, 1, 3);
INSERT INTO `catalogue_catalogue_types_props` VALUES (4, 2, 4);
INSERT INTO `catalogue_catalogue_types_props` VALUES (5, 2, 5);
INSERT INTO `catalogue_catalogue_types_props` VALUES (6, 2, 6);
INSERT INTO `catalogue_catalogue_types_props` VALUES (12, 1, 2);
INSERT INTO `catalogue_catalogue_types_props` VALUES (20, 6, 1);
INSERT INTO `catalogue_catalogue_types_props` VALUES (21, 6, 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `comments_comments`
-- 

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

-- 
-- Дамп данных таблицы `comments_comments`
-- 

INSERT INTO `comments_comments` VALUES (34, 185, 'sdf', 2, 1170662062, 28);
INSERT INTO `comments_comments` VALUES (25, 135, 'asdfsdfg', 2, 1164000450, 14);
INSERT INTO `comments_comments` VALUES (37, 188, 'jhgkhjk', 2, 1170662102, 28);
INSERT INTO `comments_comments` VALUES (33, 184, 'asd', 2, 1170662056, 28);
INSERT INTO `comments_comments` VALUES (38, 214, 'яяяяяяййййм', 2, 1170820956, 29);
INSERT INTO `comments_comments` VALUES (39, 215, 'фваааааааа', 2, 1170821437, 29);
INSERT INTO `comments_comments` VALUES (40, 216, 'ыва', 2, 1170821447, 29);
INSERT INTO `comments_comments` VALUES (41, 217, 'цйук', 2, 1170821449, 29);
INSERT INTO `comments_comments` VALUES (42, 218, 'рпо', 2, 1170821452, 29);

-- --------------------------------------------------------

-- 
-- Структура таблицы `comments_commentsFolder`
-- 

DROP TABLE IF EXISTS `comments_commentsFolder`;
CREATE TABLE `comments_commentsFolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `parent_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `comments_commentsFolder`
-- 

INSERT INTO `comments_commentsFolder` VALUES (14, 134, 9);
INSERT INTO `comments_commentsFolder` VALUES (16, 145, 10);
INSERT INTO `comments_commentsFolder` VALUES (18, 171, 164);
INSERT INTO `comments_commentsFolder` VALUES (19, 172, 165);
INSERT INTO `comments_commentsFolder` VALUES (20, 173, 166);
INSERT INTO `comments_commentsFolder` VALUES (21, 174, 170);
INSERT INTO `comments_commentsFolder` VALUES (22, 175, 11);
INSERT INTO `comments_commentsFolder` VALUES (23, 177, 6);
INSERT INTO `comments_commentsFolder` VALUES (28, 183, 182);
INSERT INTO `comments_commentsFolder` VALUES (29, 213, 212);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fileManager_file`
-- 

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

-- 
-- Дамп данных таблицы `fileManager_file`
-- 

INSERT INTO `fileManager_file` VALUES (1, 'foobar.txt', 'q', 'txt', 10, NULL, 1, 196);
INSERT INTO `fileManager_file` VALUES (2, '06558db05a7d5148084025676972cbb2', '', 'rec', 9, NULL, NULL, 201);
INSERT INTO `fileManager_file` VALUES (3, '9f4b4024092fcebfc434401210f71f7d', '', 'rec', 9, NULL, NULL, 202);
INSERT INTO `fileManager_file` VALUES (4, '05a131b70aef0e2b9f3e344d6163d311', 'qwe.rec', 'rec', 9, NULL, 1, 203);
INSERT INTO `fileManager_file` VALUES (5, '5b78dc5c1c2ad6511e3e324845c2eb3c', '2rec', '', 9, NULL, 1, 204);
INSERT INTO `fileManager_file` VALUES (6, '13810e7f5782973b2dc72030c1c392f0', 'сы', '', 18, NULL, 1, 205);
INSERT INTO `fileManager_file` VALUES (7, '86a4a3164ed3f07762b204d7ccbbea0e', '!А вам слабо!Excel!AutoCAD-MustDie', 'xls', 745984, 1, 1, 206);
INSERT INTO `fileManager_file` VALUES (8, '3ff2104331237dafe9d7941a1286136f', 'mysql', '', 39, NULL, 1, 207);
INSERT INTO `fileManager_file` VALUES (9, '395ce8a398746491a5e73c2f0ab786ba', 'сверхурочка', '', 38, 1, 1, 208);
INSERT INTO `fileManager_file` VALUES (10, '02c870089fc7f94ba1286e8faef13316', 'web.txt', 'txt', 28, NULL, 1, 209);
INSERT INTO `fileManager_file` VALUES (11, '59833d36a918ad9fdd5f860d8a9b350f', '!А вам слабо!Excel!AutoCAD-MustDie', 'xls', 745984, NULL, 1, 210);
INSERT INTO `fileManager_file` VALUES (12, '72bbe08ad2ff3bf5ac950061a8a71ccd', '!А вам слабо!Excel!AutoCAD-MustDie.xls', 'xls', 745984, 1, 1, 211);
INSERT INTO `fileManager_file` VALUES (13, 'ddaa316ac5ba16b0a2e39a3f9c19d330', '2rec', '', 9, NULL, 2, 219);
INSERT INTO `fileManager_file` VALUES (14, '715dc8aa6d7e16526ae15a80386c4552', '2rec.bmp', 'bmp', 9, 3, 2, 220);
INSERT INTO `fileManager_file` VALUES (15, '4f0d05060fc2119d464b15a2ec93337f', 'apache_1.3.37.tar.gz', 'gz', 2665370, 1, 4, 236);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fileManager_folder`
-- 

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

-- 
-- Дамп данных таблицы `fileManager_folder`
-- 

INSERT INTO `fileManager_folder` VALUES (1, 'root', '/', 1, 'root', 195, NULL, NULL);
INSERT INTO `fileManager_folder` VALUES (2, 'child', 'child_node', 2, 'root/child', 197, 1, 'bmp');
INSERT INTO `fileManager_folder` VALUES (3, 'q', 'q', 3, 'root/child/q', 221, 0, '');
INSERT INTO `fileManager_folder` VALUES (4, 'z', 'z', 4, 'root/child/q/z', 222, 0, '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fileManager_folder_tree`
-- 

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

-- 
-- Дамп данных таблицы `fileManager_folder_tree`
-- 

INSERT INTO `fileManager_folder_tree` VALUES (1, 1, 8, 1);
INSERT INTO `fileManager_folder_tree` VALUES (2, 2, 7, 2);
INSERT INTO `fileManager_folder_tree` VALUES (3, 3, 6, 3);
INSERT INTO `fileManager_folder_tree` VALUES (4, 4, 5, 4);

-- --------------------------------------------------------

-- 
-- Структура таблицы `news_news`
-- 

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

-- 
-- Дамп данных таблицы `news_news`
-- 

INSERT INTO `news_news` VALUES (7, 182, '1', 2, '3', 2, 1170662044, 1172037447);
INSERT INTO `news_news` VALUES (8, 212, 'ывф', 2, 'йк', 2, 1170820429, 1170820429);

-- --------------------------------------------------------

-- 
-- Структура таблицы `news_newsFolder`
-- 

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

-- 
-- Дамп данных таблицы `news_newsFolder`
-- 

INSERT INTO `news_newsFolder` VALUES (2, 6, 'root', '/', 1, 'root');
INSERT INTO `news_newsFolder` VALUES (3, 49, 'zzz', 'подкаталог', 2, 'root/zzz');
INSERT INTO `news_newsFolder` VALUES (5, 159, 'one_more', 'zzz', 4, 'root/one_more');
INSERT INTO `news_newsFolder` VALUES (6, 160, 'two', 'qqq', 5, 'root/zzz/two');
INSERT INTO `news_newsFolder` VALUES (7, 235, 'asd', 'asd', 6, 'root/one_more/asd');

-- --------------------------------------------------------

-- 
-- Структура таблицы `news_newsFolder_tree`
-- 

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

-- 
-- Дамп данных таблицы `news_newsFolder_tree`
-- 

INSERT INTO `news_newsFolder_tree` VALUES (1, 1, 10, 1);
INSERT INTO `news_newsFolder_tree` VALUES (2, 2, 5, 2);
INSERT INTO `news_newsFolder_tree` VALUES (4, 6, 9, 2);
INSERT INTO `news_newsFolder_tree` VALUES (5, 3, 4, 3);
INSERT INTO `news_newsFolder_tree` VALUES (6, 7, 8, 3);

-- --------------------------------------------------------

-- 
-- Структура таблицы `page_page`
-- 

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

-- 
-- Дамп данных таблицы `page_page`
-- 

INSERT INTO `page_page` VALUES (1, 9, 'main', 'Первая страница', 'Это <b>первая</b>, главная <strike>страница</strike>\n', 1);
INSERT INTO `page_page` VALUES (2, 10, '404', '404 Not Found', 'Запрашиваемая страница не найдена!', 1);
INSERT INTO `page_page` VALUES (3, 11, 'test', 'test', 'test', 1);
INSERT INTO `page_page` VALUES (4, 57, '403', 'Доступ запрещён', 'Доступ запрещён', 1);
INSERT INTO `page_page` VALUES (5, 164, 'pagename', '123', '234', 2);
INSERT INTO `page_page` VALUES (6, 165, 'asd', 'qwe', 'asd', 2);
INSERT INTO `page_page` VALUES (7, 166, '12345', '1', 'qwe', 2);
INSERT INTO `page_page` VALUES (8, 167, '1236', '2', 'asd', 2);
INSERT INTO `page_page` VALUES (9, 168, '1237', '3', 'qwe', 2);
INSERT INTO `page_page` VALUES (10, 169, '1234', 'ffffff', 'f', 2);
INSERT INTO `page_page` VALUES (11, 170, 'ss', 'ква', 'sdaf', 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `page_pageFolder`
-- 

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

-- 
-- Дамп данных таблицы `page_pageFolder`
-- 

INSERT INTO `page_pageFolder` VALUES (1, 161, 'root', '/', 1, 'root');
INSERT INTO `page_pageFolder` VALUES (2, 163, 'foo', 'foo', 2, 'root/foo');
INSERT INTO `page_pageFolder` VALUES (3, 234, 'zz', 'zz', 3, 'root/foo/zz');

-- --------------------------------------------------------

-- 
-- Структура таблицы `page_pageFolder_tree`
-- 

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

-- 
-- Дамп данных таблицы `page_pageFolder_tree`
-- 

INSERT INTO `page_pageFolder_tree` VALUES (1, 1, 6, 1);
INSERT INTO `page_pageFolder_tree` VALUES (2, 2, 5, 2);
INSERT INTO `page_pageFolder_tree` VALUES (3, 3, 4, 3);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_access`
-- 

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

-- 
-- Дамп данных таблицы `sys_access`
-- 

INSERT INTO `sys_access` VALUES (1202, 9, 1, 0, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1201, 20, 1, 0, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1113, 9, 3, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (859, 9, 1, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (858, 2, 1, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (665, 9, 2, 49, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (671, 9, 2, 49, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (670, 8, 2, 49, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (669, 7, 2, 49, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1112, 2, 3, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1111, 12, 3, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (394, 9, 2, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (391, 6, 2, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (390, 5, 2, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (441, 9, 2, 6, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1528, 1, 10, 188, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1498, 1, 1, 182, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (857, 1, 1, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (389, 4, 2, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (440, 8, 2, 6, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (439, 7, 2, 6, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (438, 6, 2, 6, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (437, 5, 2, 6, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (436, 4, 2, 6, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (664, 8, 2, 49, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (663, 7, 2, 49, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1504, 3, 1, 182, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1503, 1, 1, 182, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1502, 2, 1, 182, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1501, 20, 1, 182, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1500, 9, 1, 182, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (668, 6, 2, 49, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (667, 5, 2, 49, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (666, 4, 2, 49, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (662, 6, 2, 49, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (661, 5, 2, 49, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (660, 4, 2, 49, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (393, 8, 2, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (392, 7, 2, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1200, 2, 1, 0, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1199, 1, 1, 0, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1110, 1, 3, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1109, 5, 3, 0, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1108, 11, 3, 0, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1107, 10, 3, 0, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (856, 3, 1, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1497, 2, 1, 182, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1228, 9, 2, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1227, 8, 2, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1226, 7, 2, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1225, 6, 2, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1224, 5, 2, 0, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1223, 4, 2, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (355, 4, 2, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (356, 5, 2, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (357, 6, 2, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (358, 7, 2, 0, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (359, 8, 2, 0, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (360, 9, 2, 0, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (1134, 9, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1133, 2, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1132, 12, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1131, 1, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1130, 5, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1129, 11, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1128, 10, 3, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (428, 3, 5, 19, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (429, 3, 5, 19, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (442, 10, 3, 12, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (996, 9, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (466, 9, 6, 9, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (465, 2, 6, 9, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (464, 1, 6, 9, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (463, 4, 6, 9, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (462, 5, 6, 9, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (468, 5, 6, 9, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (467, 3, 6, 9, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (461, 3, 6, 9, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (469, 4, 6, 9, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (470, 1, 6, 9, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (471, 2, 6, 9, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (472, 9, 6, 9, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (486, 3, 6, 10, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (485, 9, 6, 10, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (484, 2, 6, 10, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (483, 1, 6, 10, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (482, 4, 6, 10, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (481, 5, 6, 10, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (480, 3, 6, 10, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (487, 5, 6, 10, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (488, 4, 6, 10, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (489, 1, 6, 10, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (490, 2, 6, 10, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (491, 9, 6, 10, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (504, 9, 6, 11, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (503, 2, 6, 11, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (502, 1, 6, 11, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (501, 4, 6, 11, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (500, 5, 6, 11, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (499, 3, 6, 11, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (505, 3, 6, 11, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (506, 5, 6, 11, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (507, 4, 6, 11, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (508, 1, 6, 11, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (509, 2, 6, 11, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (510, 9, 6, 11, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (546, 9, 3, 55, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (539, 9, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (545, 2, 3, 55, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (538, 2, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (544, 12, 3, 55, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (537, 12, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (543, 1, 3, 55, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (536, 1, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (542, 5, 3, 55, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (535, 5, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (541, 11, 3, 55, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (534, 11, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (540, 10, 3, 55, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (533, 10, 3, 55, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (995, 2, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (994, 12, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (993, 1, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (992, 5, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (991, 11, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (990, 10, 3, 13, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (548, 14, 4, 56, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (549, 15, 4, 56, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (550, 16, 4, 56, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (551, 17, 4, 56, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (552, 13, 4, 56, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (553, 9, 4, 56, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (555, 14, 4, 15, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (556, 15, 4, 15, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (557, 16, 4, 15, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (558, 17, 4, 15, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (559, 13, 4, 15, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (560, 9, 4, 15, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (562, 14, 4, 14, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (563, 15, 4, 14, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (564, 16, 4, 14, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (565, 17, 4, 14, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (566, 13, 4, 14, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (567, 9, 4, 14, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (569, 3, 6, 57, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (570, 5, 6, 57, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (571, 4, 6, 57, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (572, 1, 6, 57, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (573, 2, 6, 57, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (574, 9, 6, 57, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (590, 1, 1, 60, 1, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (591, 1, 1, 60, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (592, 2, 1, 60, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (593, 2, 1, 60, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (594, 3, 1, 60, 1, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (595, 3, 1, 60, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (596, 9, 1, 60, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (597, 9, 1, 60, 1, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (598, 9, 1, 60, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (599, 4, 2, 61, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (600, 4, 2, 61, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (601, 4, 2, 61, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (602, 5, 2, 61, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (603, 5, 2, 61, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (604, 5, 2, 61, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (605, 6, 2, 61, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (606, 6, 2, 61, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (607, 6, 2, 61, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (608, 7, 2, 61, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (609, 7, 2, 61, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (610, 7, 2, 61, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (611, 8, 2, 61, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (612, 8, 2, 61, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (613, 8, 2, 61, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (614, 9, 2, 61, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (615, 9, 2, 61, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (616, 9, 2, 61, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (630, 18, 7, 62, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1240, 9, 2, 0, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1239, 8, 2, 0, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1238, 7, 2, 0, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1237, 6, 2, 0, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1236, 5, 2, 0, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1235, 4, 2, 0, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (629, 9, 7, 62, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1140, 18, 7, 63, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1139, 9, 7, 63, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1146, 18, 7, 64, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1145, 9, 7, 64, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (637, 3, 6, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (638, 5, 6, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (639, 4, 6, 0, 0, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (640, 1, 6, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (641, 2, 6, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (642, 9, 6, 0, 0, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (687, 9, 5, 65, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (686, 3, 5, 65, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (646, 3, 5, 65, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (647, 9, 5, 65, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (1527, 2, 10, 188, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1519, 1, 10, 185, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1518, 2, 10, 185, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (684, 3, 5, 65, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (685, 9, 5, 65, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (989, 9, 3, 12, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (697, 10, 3, 12, 2, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (698, 11, 3, 12, 2, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (699, 5, 3, 12, 2, NULL, 0, 1);
INSERT INTO `sys_access` VALUES (700, 1, 3, 12, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (701, 12, 3, 12, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (702, 2, 3, 12, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (703, 9, 3, 12, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (988, 2, 3, 12, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (987, 12, 3, 12, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (986, 1, 3, 12, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (985, 5, 3, 12, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (984, 11, 3, 12, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (983, 10, 3, 12, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1449, 21, 9, 69, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1448, 20, 9, 69, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1143, 18, 7, 72, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1142, 9, 7, 72, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (729, 9, 7, 71, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (730, 18, 7, 71, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (732, 5, 11, 76, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (733, 9, 11, 76, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (776, 5, 11, 93, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (777, 5, 11, 93, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (884, 19, 11, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (883, 5, 11, 0, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (888, 9, 11, 0, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (887, 19, 11, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (778, 9, 11, 93, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (784, 18, 7, 95, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (779, 9, 11, 93, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1149, 18, 7, 94, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (886, 5, 11, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (788, 5, 11, 96, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (783, 9, 10, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (782, 2, 10, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (789, 5, 11, 96, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (790, 19, 11, 96, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (791, 9, 11, 96, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (792, 9, 11, 96, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (781, 1, 10, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (902, 19, 11, 98, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (906, 9, 11, 98, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (905, 19, 11, 98, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (901, 5, 11, 98, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (904, 5, 11, 98, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (801, 1, 10, 99, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (804, 1, 10, 100, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (803, 9, 10, 99, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (802, 2, 10, 99, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (805, 2, 10, 100, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (806, 9, 10, 100, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (807, 1, 10, 101, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (808, 2, 10, 101, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (809, 9, 10, 101, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (810, 5, 11, 102, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (811, 5, 11, 102, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (812, 19, 11, 102, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (813, 9, 11, 102, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (814, 9, 11, 102, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (890, 19, 11, 103, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (897, 9, 11, 103, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (896, 19, 11, 103, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (889, 5, 11, 103, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (895, 5, 11, 103, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (885, 9, 11, 0, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (882, 9, 11, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (881, 19, 11, 0, 0, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (880, 5, 11, 0, 0, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (891, 9, 11, 103, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (952, 9, 11, 103, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (951, 19, 11, 103, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (950, 5, 11, 103, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (898, 5, 11, 98, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (899, 19, 11, 98, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (900, 9, 11, 98, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (903, 9, 11, 98, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (919, 1, 10, 107, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (920, 2, 10, 107, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (921, 9, 10, 107, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (922, 1, 10, 108, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (923, 2, 10, 108, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (924, 9, 10, 108, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1148, 9, 7, 94, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (958, 9, 7, 95, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (970, 9, 11, 124, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (973, 9, 11, 124, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (961, 5, 11, 124, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (969, 19, 11, 124, NULL, 1, 0, 1);
INSERT INTO `sys_access` VALUES (972, 19, 11, 124, NULL, 2, 0, 1);
INSERT INTO `sys_access` VALUES (964, 19, 11, 124, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (968, 5, 11, 124, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (971, 5, 11, 124, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (967, 9, 11, 124, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (974, 5, 11, 127, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (975, 5, 11, 127, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (976, 5, 11, 127, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (977, 19, 11, 127, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (978, 19, 11, 127, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (979, 19, 11, 127, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (980, 9, 11, 127, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (981, 9, 11, 127, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (982, 9, 11, 127, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1526, 9, 10, 188, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1033, 5, 11, 134, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1034, 5, 11, 134, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1035, 5, 11, 134, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1036, 19, 11, 134, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1037, 19, 11, 134, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1038, 19, 11, 134, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1039, 9, 11, 134, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1040, 9, 11, 134, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1041, 9, 11, 134, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1042, 1, 10, 135, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1043, 2, 10, 135, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1044, 9, 10, 135, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1080, 5, 11, 145, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1081, 5, 11, 145, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1082, 5, 11, 145, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1083, 19, 11, 145, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1084, 19, 11, 145, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1085, 19, 11, 145, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1086, 9, 11, 145, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1087, 9, 11, 145, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1088, 9, 11, 145, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1510, 5, 11, 183, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1507, 9, 11, 183, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1513, 5, 11, 183, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1509, 19, 11, 183, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1506, 5, 11, 183, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1512, 19, 11, 183, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1508, 9, 11, 183, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1505, 19, 11, 183, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1511, 9, 11, 183, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1516, 1, 10, 184, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1515, 2, 10, 184, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1514, 9, 10, 184, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1121, 10, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1122, 11, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1123, 5, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1124, 1, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1125, 12, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1126, 2, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1127, 9, 3, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1447, 3, 9, 69, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1141, 20, 7, 63, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1144, 20, 7, 72, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1147, 20, 7, 64, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1150, 20, 7, 94, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1499, 3, 1, 182, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1517, 9, 10, 185, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1496, 9, 1, 182, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1198, 3, 1, 0, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1309, 8, 2, 159, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1303, 6, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1321, 5, 2, 160, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1320, 4, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1308, 7, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1302, 6, 2, 159, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1319, 4, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1318, 4, 2, 160, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1307, 7, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1301, 6, 2, 159, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1317, 4, 2, 160, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1316, 9, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1306, 7, 2, 159, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1300, 5, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1315, 9, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1314, 9, 2, 159, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1305, 7, 2, 159, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1299, 5, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1313, 9, 2, 159, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1312, 8, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1304, 6, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1298, 5, 2, 159, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1311, 8, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1310, 8, 2, 159, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1454, 9, 11, 177, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1297, 5, 2, 159, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1453, 9, 11, 177, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1296, 4, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1452, 5, 11, 177, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1295, 4, 2, 159, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1451, 19, 11, 177, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1294, 4, 2, 159, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1293, 4, 2, 159, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1325, 6, 2, 160, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1330, 7, 2, 160, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1324, 5, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1329, 7, 2, 160, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1323, 5, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1328, 6, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1322, 5, 2, 160, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1327, 6, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1326, 6, 2, 160, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1331, 7, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1332, 7, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1333, 8, 2, 160, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1334, 8, 2, 160, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1335, 8, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1336, 8, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1337, 9, 2, 160, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1338, 9, 2, 160, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1339, 9, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1340, 9, 2, 160, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1342, 4, 13, 161, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1343, 5, 13, 161, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1344, 6, 13, 161, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1345, 7, 13, 161, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1346, 9, 13, 161, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1347, 4, 13, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1348, 5, 13, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1349, 6, 13, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1350, 7, 13, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1351, 9, 13, 0, 0, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1352, 4, 13, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1353, 5, 13, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1354, 6, 13, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1355, 7, 13, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1356, 9, 13, 0, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1357, 9, 13, 163, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1358, 9, 13, 163, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1359, 7, 13, 163, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1360, 7, 13, 163, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1361, 6, 13, 163, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1362, 6, 13, 163, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1363, 4, 13, 163, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1364, 4, 13, 163, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1365, 5, 13, 163, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1366, 5, 13, 163, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1367, 3, 6, 164, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1368, 9, 6, 164, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1369, 4, 6, 164, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1370, 1, 6, 164, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1371, 2, 6, 164, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1372, 3, 6, 165, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1373, 9, 6, 165, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1374, 4, 6, 165, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1375, 1, 6, 165, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1376, 2, 6, 165, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1377, 3, 6, 166, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1378, 9, 6, 166, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1379, 4, 6, 166, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1380, 1, 6, 166, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1381, 2, 6, 166, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1382, 3, 6, 167, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1383, 9, 6, 167, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1384, 4, 6, 167, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1385, 1, 6, 167, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1386, 2, 6, 167, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1387, 3, 6, 168, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1388, 9, 6, 168, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1389, 4, 6, 168, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1390, 1, 6, 168, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1391, 2, 6, 168, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1392, 3, 6, 169, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1393, 9, 6, 169, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1394, 4, 6, 169, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1395, 1, 6, 169, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1396, 2, 6, 169, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1397, 3, 6, 170, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1398, 9, 6, 170, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1399, 4, 6, 170, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1400, 1, 6, 170, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1401, 2, 6, 170, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1402, 5, 11, 171, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1403, 5, 11, 171, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1404, 5, 11, 171, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1405, 19, 11, 171, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1406, 19, 11, 171, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1407, 19, 11, 171, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1408, 9, 11, 171, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1409, 9, 11, 171, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1410, 9, 11, 171, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1411, 5, 11, 172, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1412, 5, 11, 172, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1413, 5, 11, 172, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1414, 19, 11, 172, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1415, 19, 11, 172, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1416, 19, 11, 172, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1417, 9, 11, 172, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1418, 9, 11, 172, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1419, 9, 11, 172, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1420, 5, 11, 173, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1421, 5, 11, 173, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1422, 5, 11, 173, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1423, 19, 11, 173, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1424, 19, 11, 173, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1425, 19, 11, 173, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1426, 9, 11, 173, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1427, 9, 11, 173, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1428, 9, 11, 173, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1429, 5, 11, 174, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1430, 5, 11, 174, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1431, 5, 11, 174, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1432, 19, 11, 174, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1433, 19, 11, 174, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1434, 19, 11, 174, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1435, 9, 11, 174, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1436, 9, 11, 174, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1437, 9, 11, 174, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1438, 5, 11, 175, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1439, 5, 11, 175, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1440, 5, 11, 175, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1441, 19, 11, 175, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1442, 19, 11, 175, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1443, 19, 11, 175, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1444, 9, 11, 175, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1445, 9, 11, 175, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1446, 9, 11, 175, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1450, 9, 9, 69, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1455, 19, 11, 177, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1456, 5, 11, 177, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1457, 9, 11, 177, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1458, 19, 11, 177, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1459, 5, 11, 177, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1529, 9, 1, 212, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1530, 2, 1, 212, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1531, 1, 1, 212, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1532, 3, 1, 212, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1533, 9, 1, 212, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1534, 2, 1, 212, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1535, 1, 1, 212, 1, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1536, 3, 1, 212, 1, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1537, 19, 11, 213, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1538, 5, 11, 213, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1539, 9, 11, 213, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1540, 9, 11, 213, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1541, 19, 11, 213, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1542, 5, 11, 213, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1543, 9, 11, 213, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1544, 19, 11, 213, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1545, 5, 11, 213, 2, NULL, 0, 0);
INSERT INTO `sys_access` VALUES (1546, 9, 10, 214, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1547, 2, 10, 214, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1548, 1, 10, 214, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1549, 9, 10, 215, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1550, 2, 10, 215, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1551, 1, 10, 215, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1552, 9, 10, 216, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1553, 2, 10, 216, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1554, 1, 10, 216, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1555, 9, 10, 217, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1556, 2, 10, 217, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1557, 1, 10, 217, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1558, 9, 10, 218, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1559, 2, 10, 218, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1560, 1, 10, 218, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1582, 4, 2, 6, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1583, 5, 2, 6, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1584, 6, 2, 6, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1585, 7, 2, 6, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1586, 30, 2, 6, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1587, 8, 2, 6, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1588, 9, 2, 6, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1589, 4, 13, 234, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1590, 5, 13, 234, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1591, 6, 13, 234, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1592, 7, 13, 234, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1593, 9, 13, 234, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1594, 4, 13, 234, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1595, 5, 13, 234, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1596, 6, 13, 234, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1597, 7, 13, 234, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1598, 9, 13, 234, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1599, 9, 2, 235, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1600, 8, 2, 235, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1601, 7, 2, 235, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1602, 6, 2, 235, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1603, 5, 2, 235, NULL, 1, 1, 0);
INSERT INTO `sys_access` VALUES (1604, 4, 2, 235, NULL, 1, 0, 0);
INSERT INTO `sys_access` VALUES (1605, 4, 2, 235, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1606, 5, 2, 235, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1607, 6, 2, 235, NULL, 2, 1, 0);
INSERT INTO `sys_access` VALUES (1608, 7, 2, 235, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1609, 8, 2, 235, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1610, 9, 2, 235, NULL, 2, 0, 0);
INSERT INTO `sys_access` VALUES (1611, 9, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1612, 6, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1613, 5, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1614, 4, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1615, 8, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1616, 7, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1617, 9, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1618, 8, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1619, 7, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1620, 6, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1621, 5, 2, 235, 2, NULL, 1, 0);
INSERT INTO `sys_access` VALUES (1622, 4, 2, 235, 2, NULL, 1, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_access_registry`
-- 

DROP TABLE IF EXISTS `sys_access_registry`;
CREATE TABLE `sys_access_registry` (
  `obj_id` int(11) unsigned default NULL,
  `class_section_id` int(11) unsigned default NULL,
  KEY `obj_id` (`obj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_access_registry`
-- 

INSERT INTO `sys_access_registry` VALUES (6, 2);
INSERT INTO `sys_access_registry` VALUES (46, 1);
INSERT INTO `sys_access_registry` VALUES (185, 10);
INSERT INTO `sys_access_registry` VALUES (49, 2);
INSERT INTO `sys_access_registry` VALUES (182, 1);
INSERT INTO `sys_access_registry` VALUES (12, 3);
INSERT INTO `sys_access_registry` VALUES (13, 3);
INSERT INTO `sys_access_registry` VALUES (14, 4);
INSERT INTO `sys_access_registry` VALUES (15, 4);
INSERT INTO `sys_access_registry` VALUES (9, 6);
INSERT INTO `sys_access_registry` VALUES (10, 6);
INSERT INTO `sys_access_registry` VALUES (11, 6);
INSERT INTO `sys_access_registry` VALUES (55, 3);
INSERT INTO `sys_access_registry` VALUES (56, 4);
INSERT INTO `sys_access_registry` VALUES (57, 6);
INSERT INTO `sys_access_registry` VALUES (60, 1);
INSERT INTO `sys_access_registry` VALUES (61, 2);
INSERT INTO `sys_access_registry` VALUES (62, 7);
INSERT INTO `sys_access_registry` VALUES (63, 7);
INSERT INTO `sys_access_registry` VALUES (64, 7);
INSERT INTO `sys_access_registry` VALUES (65, 5);
INSERT INTO `sys_access_registry` VALUES (190, 7);
INSERT INTO `sys_access_registry` VALUES (69, 9);
INSERT INTO `sys_access_registry` VALUES (70, 7);
INSERT INTO `sys_access_registry` VALUES (71, 7);
INSERT INTO `sys_access_registry` VALUES (72, 7);
INSERT INTO `sys_access_registry` VALUES (73, 7);
INSERT INTO `sys_access_registry` VALUES (74, 7);
INSERT INTO `sys_access_registry` VALUES (75, 7);
INSERT INTO `sys_access_registry` VALUES (188, 10);
INSERT INTO `sys_access_registry` VALUES (189, 12);
INSERT INTO `sys_access_registry` VALUES (95, 7);
INSERT INTO `sys_access_registry` VALUES (134, 11);
INSERT INTO `sys_access_registry` VALUES (191, 7);
INSERT INTO `sys_access_registry` VALUES (135, 10);
INSERT INTO `sys_access_registry` VALUES (99, 10);
INSERT INTO `sys_access_registry` VALUES (100, 10);
INSERT INTO `sys_access_registry` VALUES (101, 10);
INSERT INTO `sys_access_registry` VALUES (192, 7);
INSERT INTO `sys_access_registry` VALUES (193, 7);
INSERT INTO `sys_access_registry` VALUES (94, 7);
INSERT INTO `sys_access_registry` VALUES (195, 15);
INSERT INTO `sys_access_registry` VALUES (194, 7);
INSERT INTO `sys_access_registry` VALUES (145, 11);
INSERT INTO `sys_access_registry` VALUES (107, 10);
INSERT INTO `sys_access_registry` VALUES (108, 10);
INSERT INTO `sys_access_registry` VALUES (121, 12);
INSERT INTO `sys_access_registry` VALUES (123, 7);
INSERT INTO `sys_access_registry` VALUES (196, 14);
INSERT INTO `sys_access_registry` VALUES (126, 12);
INSERT INTO `sys_access_registry` VALUES (122, 7);
INSERT INTO `sys_access_registry` VALUES (183, 11);
INSERT INTO `sys_access_registry` VALUES (184, 10);
INSERT INTO `sys_access_registry` VALUES (148, 12);
INSERT INTO `sys_access_registry` VALUES (149, 12);
INSERT INTO `sys_access_registry` VALUES (150, 12);
INSERT INTO `sys_access_registry` VALUES (151, 12);
INSERT INTO `sys_access_registry` VALUES (155, 12);
INSERT INTO `sys_access_registry` VALUES (177, 11);
INSERT INTO `sys_access_registry` VALUES (157, 12);
INSERT INTO `sys_access_registry` VALUES (159, 2);
INSERT INTO `sys_access_registry` VALUES (160, 2);
INSERT INTO `sys_access_registry` VALUES (161, 13);
INSERT INTO `sys_access_registry` VALUES (162, 7);
INSERT INTO `sys_access_registry` VALUES (163, 13);
INSERT INTO `sys_access_registry` VALUES (164, 6);
INSERT INTO `sys_access_registry` VALUES (165, 6);
INSERT INTO `sys_access_registry` VALUES (166, 6);
INSERT INTO `sys_access_registry` VALUES (167, 6);
INSERT INTO `sys_access_registry` VALUES (168, 6);
INSERT INTO `sys_access_registry` VALUES (169, 6);
INSERT INTO `sys_access_registry` VALUES (170, 6);
INSERT INTO `sys_access_registry` VALUES (171, 11);
INSERT INTO `sys_access_registry` VALUES (172, 11);
INSERT INTO `sys_access_registry` VALUES (173, 11);
INSERT INTO `sys_access_registry` VALUES (174, 11);
INSERT INTO `sys_access_registry` VALUES (175, 11);
INSERT INTO `sys_access_registry` VALUES (176, 12);
INSERT INTO `sys_access_registry` VALUES (197, 15);
INSERT INTO `sys_access_registry` VALUES (198, 7);
INSERT INTO `sys_access_registry` VALUES (201, 14);
INSERT INTO `sys_access_registry` VALUES (202, 14);
INSERT INTO `sys_access_registry` VALUES (203, 14);
INSERT INTO `sys_access_registry` VALUES (204, 14);
INSERT INTO `sys_access_registry` VALUES (205, 14);
INSERT INTO `sys_access_registry` VALUES (206, 14);
INSERT INTO `sys_access_registry` VALUES (207, 14);
INSERT INTO `sys_access_registry` VALUES (208, 14);
INSERT INTO `sys_access_registry` VALUES (209, 14);
INSERT INTO `sys_access_registry` VALUES (210, 14);
INSERT INTO `sys_access_registry` VALUES (211, 14);
INSERT INTO `sys_access_registry` VALUES (212, 1);
INSERT INTO `sys_access_registry` VALUES (213, 11);
INSERT INTO `sys_access_registry` VALUES (214, 10);
INSERT INTO `sys_access_registry` VALUES (215, 10);
INSERT INTO `sys_access_registry` VALUES (216, 10);
INSERT INTO `sys_access_registry` VALUES (217, 10);
INSERT INTO `sys_access_registry` VALUES (218, 10);
INSERT INTO `sys_access_registry` VALUES (219, 14);
INSERT INTO `sys_access_registry` VALUES (220, 14);
INSERT INTO `sys_access_registry` VALUES (221, 15);
INSERT INTO `sys_access_registry` VALUES (222, 15);
INSERT INTO `sys_access_registry` VALUES (224, 12);
INSERT INTO `sys_access_registry` VALUES (225, 4);
INSERT INTO `sys_access_registry` VALUES (226, 8);
INSERT INTO `sys_access_registry` VALUES (232, 8);
INSERT INTO `sys_access_registry` VALUES (233, 7);
INSERT INTO `sys_access_registry` VALUES (234, 13);
INSERT INTO `sys_access_registry` VALUES (235, 2);
INSERT INTO `sys_access_registry` VALUES (236, 14);
INSERT INTO `sys_access_registry` VALUES (238, 16);
INSERT INTO `sys_access_registry` VALUES (240, 7);
INSERT INTO `sys_access_registry` VALUES (246, 16);
INSERT INTO `sys_access_registry` VALUES (249, 17);
INSERT INTO `sys_access_registry` VALUES (250, 16);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_actions`
-- 

DROP TABLE IF EXISTS `sys_actions`;
CREATE TABLE `sys_actions` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_actions`
-- 

INSERT INTO `sys_actions` VALUES (1, 'edit');
INSERT INTO `sys_actions` VALUES (2, 'delete');
INSERT INTO `sys_actions` VALUES (3, 'view');
INSERT INTO `sys_actions` VALUES (4, 'create');
INSERT INTO `sys_actions` VALUES (5, 'list');
INSERT INTO `sys_actions` VALUES (6, 'createFolder');
INSERT INTO `sys_actions` VALUES (7, 'editFolder');
INSERT INTO `sys_actions` VALUES (8, 'deleteFolder');
INSERT INTO `sys_actions` VALUES (9, 'editACL');
INSERT INTO `sys_actions` VALUES (10, 'login');
INSERT INTO `sys_actions` VALUES (11, 'exit');
INSERT INTO `sys_actions` VALUES (12, 'memberOf');
INSERT INTO `sys_actions` VALUES (13, 'groupDelete');
INSERT INTO `sys_actions` VALUES (14, 'groupsList');
INSERT INTO `sys_actions` VALUES (15, 'groupEdit');
INSERT INTO `sys_actions` VALUES (16, 'membersList');
INSERT INTO `sys_actions` VALUES (17, 'addToGroup');
INSERT INTO `sys_actions` VALUES (18, 'editDefault');
INSERT INTO `sys_actions` VALUES (19, 'post');
INSERT INTO `sys_actions` VALUES (20, 'admin');
INSERT INTO `sys_actions` VALUES (21, 'devToolbar');
INSERT INTO `sys_actions` VALUES (22, 'acti');
INSERT INTO `sys_actions` VALUES (23, 'q');
INSERT INTO `sys_actions` VALUES (24, 'qq');
INSERT INTO `sys_actions` VALUES (25, 'aaa');
INSERT INTO `sys_actions` VALUES (26, 'qqq');
INSERT INTO `sys_actions` VALUES (27, 'upload');
INSERT INTO `sys_actions` VALUES (28, 'get');
INSERT INTO `sys_actions` VALUES (29, 'move');
INSERT INTO `sys_actions` VALUES (30, 'moveFolder');
INSERT INTO `sys_actions` VALUES (31, 'mainClass');
INSERT INTO `sys_actions` VALUES (32, 'test');
INSERT INTO `sys_actions` VALUES (33, 'addType');
INSERT INTO `sys_actions` VALUES (34, 'deleteType');
INSERT INTO `sys_actions` VALUES (35, 'editType');
INSERT INTO `sys_actions` VALUES (36, 'addProperty');
INSERT INTO `sys_actions` VALUES (37, 'editProperty');
INSERT INTO `sys_actions` VALUES (38, 'deleteProperty');
INSERT INTO `sys_actions` VALUES (39, 'editObject');
INSERT INTO `sys_actions` VALUES (40, 'addObject');
INSERT INTO `sys_actions` VALUES (41, 'add');
INSERT INTO `sys_actions` VALUES (42, 'testee');
INSERT INTO `sys_actions` VALUES (43, 'creatrFolder');

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_cfg`
-- 

DROP TABLE IF EXISTS `sys_cfg`;
CREATE TABLE `sys_cfg` (
  `id` int(11) NOT NULL auto_increment,
  `section` int(11) NOT NULL default '0',
  `module` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `section_module` (`section`,`module`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_cfg`
-- 

INSERT INTO `sys_cfg` VALUES (2, 0, 1);
INSERT INTO `sys_cfg` VALUES (3, 0, 2);
INSERT INTO `sys_cfg` VALUES (4, 1, 1);
INSERT INTO `sys_cfg` VALUES (5, 7, 6);
INSERT INTO `sys_cfg` VALUES (6, 2, 2);
INSERT INTO `sys_cfg` VALUES (1, 0, 0);
INSERT INTO `sys_cfg` VALUES (7, 0, 9);
INSERT INTO `sys_cfg` VALUES (8, 9, 9);
INSERT INTO `sys_cfg` VALUES (9, 0, 10);
INSERT INTO `sys_cfg` VALUES (10, 10, 10);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_cfg_values`
-- 

DROP TABLE IF EXISTS `sys_cfg_values`;
CREATE TABLE `sys_cfg_values` (
  `id` int(11) NOT NULL auto_increment,
  `cfg_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cfg_id_name` (`cfg_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_cfg_values`
-- 

INSERT INTO `sys_cfg_values` VALUES (1, 1, 'cache', 'true');
INSERT INTO `sys_cfg_values` VALUES (2, 2, 'items_per_page', '10');
INSERT INTO `sys_cfg_values` VALUES (3, 3, 'items_per_page', '20');
INSERT INTO `sys_cfg_values` VALUES (25, 4, 'items_per_page', '1');
INSERT INTO `sys_cfg_values` VALUES (13, 5, '', '');
INSERT INTO `sys_cfg_values` VALUES (14, 6, 'items_per_page', '20');
INSERT INTO `sys_cfg_values` VALUES (21, 7, 'upload_path', '../tmp');
INSERT INTO `sys_cfg_values` VALUES (22, 8, 'upload_path', '../files');
INSERT INTO `sys_cfg_values` VALUES (23, 9, 'items_per_page', '60');
INSERT INTO `sys_cfg_values` VALUES (27, 10, 'items_per_page', '10');

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_classes`
-- 

DROP TABLE IF EXISTS `sys_classes`;
CREATE TABLE `sys_classes` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `module_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_classes`
-- 

INSERT INTO `sys_classes` VALUES (1, 'news', 1);
INSERT INTO `sys_classes` VALUES (2, 'newsFolder', 1);
INSERT INTO `sys_classes` VALUES (3, 'user', 2);
INSERT INTO `sys_classes` VALUES (4, 'group', 2);
INSERT INTO `sys_classes` VALUES (5, 'timer', 3);
INSERT INTO `sys_classes` VALUES (6, 'page', 4);
INSERT INTO `sys_classes` VALUES (7, 'access', 5);
INSERT INTO `sys_classes` VALUES (8, 'userGroup', 2);
INSERT INTO `sys_classes` VALUES (9, 'admin', 6);
INSERT INTO `sys_classes` VALUES (10, 'comments', 8);
INSERT INTO `sys_classes` VALUES (11, 'commentsFolder', 8);
INSERT INTO `sys_classes` VALUES (12, 'userAuth', 2);
INSERT INTO `sys_classes` VALUES (13, 'pageFolder', 4);
INSERT INTO `sys_classes` VALUES (17, 'file', 9);
INSERT INTO `sys_classes` VALUES (18, 'folder', 9);
INSERT INTO `sys_classes` VALUES (19, 'catalogue', 10);
INSERT INTO `sys_classes` VALUES (20, 'catalogueFolder', 10);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_classes_actions`
-- 

DROP TABLE IF EXISTS `sys_classes_actions`;
CREATE TABLE `sys_classes_actions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `class_id` int(11) unsigned default NULL,
  `action_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `class_id` (`class_id`,`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_classes_actions`
-- 

INSERT INTO `sys_classes_actions` VALUES (1, 1, 1);
INSERT INTO `sys_classes_actions` VALUES (2, 1, 2);
INSERT INTO `sys_classes_actions` VALUES (3, 1, 3);
INSERT INTO `sys_classes_actions` VALUES (4, 1, 9);
INSERT INTO `sys_classes_actions` VALUES (5, 2, 4);
INSERT INTO `sys_classes_actions` VALUES (6, 2, 5);
INSERT INTO `sys_classes_actions` VALUES (7, 2, 6);
INSERT INTO `sys_classes_actions` VALUES (8, 2, 7);
INSERT INTO `sys_classes_actions` VALUES (9, 2, 8);
INSERT INTO `sys_classes_actions` VALUES (10, 2, 9);
INSERT INTO `sys_classes_actions` VALUES (11, 3, 10);
INSERT INTO `sys_classes_actions` VALUES (12, 3, 11);
INSERT INTO `sys_classes_actions` VALUES (13, 3, 5);
INSERT INTO `sys_classes_actions` VALUES (14, 3, 1);
INSERT INTO `sys_classes_actions` VALUES (15, 3, 12);
INSERT INTO `sys_classes_actions` VALUES (16, 3, 2);
INSERT INTO `sys_classes_actions` VALUES (17, 4, 13);
INSERT INTO `sys_classes_actions` VALUES (18, 4, 14);
INSERT INTO `sys_classes_actions` VALUES (19, 4, 15);
INSERT INTO `sys_classes_actions` VALUES (20, 4, 16);
INSERT INTO `sys_classes_actions` VALUES (21, 4, 17);
INSERT INTO `sys_classes_actions` VALUES (22, 3, 9);
INSERT INTO `sys_classes_actions` VALUES (23, 4, 9);
INSERT INTO `sys_classes_actions` VALUES (24, 6, 3);
INSERT INTO `sys_classes_actions` VALUES (25, 6, 9);
INSERT INTO `sys_classes_actions` VALUES (46, 13, 9);
INSERT INTO `sys_classes_actions` VALUES (27, 6, 4);
INSERT INTO `sys_classes_actions` VALUES (28, 6, 1);
INSERT INTO `sys_classes_actions` VALUES (29, 6, 2);
INSERT INTO `sys_classes_actions` VALUES (30, 5, 9);
INSERT INTO `sys_classes_actions` VALUES (31, 7, 18);
INSERT INTO `sys_classes_actions` VALUES (32, 7, 9);
INSERT INTO `sys_classes_actions` VALUES (33, 5, 3);
INSERT INTO `sys_classes_actions` VALUES (34, 9, 3);
INSERT INTO `sys_classes_actions` VALUES (35, 9, 9);
INSERT INTO `sys_classes_actions` VALUES (36, 10, 1);
INSERT INTO `sys_classes_actions` VALUES (37, 10, 2);
INSERT INTO `sys_classes_actions` VALUES (38, 10, 9);
INSERT INTO `sys_classes_actions` VALUES (39, 11, 5);
INSERT INTO `sys_classes_actions` VALUES (40, 11, 19);
INSERT INTO `sys_classes_actions` VALUES (41, 11, 9);
INSERT INTO `sys_classes_actions` VALUES (42, 9, 20);
INSERT INTO `sys_classes_actions` VALUES (62, 18, 27);
INSERT INTO `sys_classes_actions` VALUES (61, 18, 5);
INSERT INTO `sys_classes_actions` VALUES (47, 13, 7);
INSERT INTO `sys_classes_actions` VALUES (48, 13, 6);
INSERT INTO `sys_classes_actions` VALUES (49, 13, 4);
INSERT INTO `sys_classes_actions` VALUES (50, 13, 5);
INSERT INTO `sys_classes_actions` VALUES (51, 9, 21);
INSERT INTO `sys_classes_actions` VALUES (63, 17, 1);
INSERT INTO `sys_classes_actions` VALUES (64, 17, 28);
INSERT INTO `sys_classes_actions` VALUES (65, 17, 2);
INSERT INTO `sys_classes_actions` VALUES (66, 17, 9);
INSERT INTO `sys_classes_actions` VALUES (67, 18, 9);
INSERT INTO `sys_classes_actions` VALUES (68, 17, 18);
INSERT INTO `sys_classes_actions` VALUES (69, 18, 18);
INSERT INTO `sys_classes_actions` VALUES (70, 1, 29);
INSERT INTO `sys_classes_actions` VALUES (71, 17, 29);
INSERT INTO `sys_classes_actions` VALUES (72, 18, 6);
INSERT INTO `sys_classes_actions` VALUES (73, 18, 8);
INSERT INTO `sys_classes_actions` VALUES (74, 18, 7);
INSERT INTO `sys_classes_actions` VALUES (77, 18, 30);
INSERT INTO `sys_classes_actions` VALUES (76, 2, 30);
INSERT INTO `sys_classes_actions` VALUES (81, 19, 3);
INSERT INTO `sys_classes_actions` VALUES (98, 19, 20);
INSERT INTO `sys_classes_actions` VALUES (84, 19, 33);
INSERT INTO `sys_classes_actions` VALUES (85, 19, 34);
INSERT INTO `sys_classes_actions` VALUES (86, 19, 35);
INSERT INTO `sys_classes_actions` VALUES (87, 19, 36);
INSERT INTO `sys_classes_actions` VALUES (88, 19, 37);
INSERT INTO `sys_classes_actions` VALUES (89, 19, 38);
INSERT INTO `sys_classes_actions` VALUES (90, 19, 39);
INSERT INTO `sys_classes_actions` VALUES (91, 13, 8);
INSERT INTO `sys_classes_actions` VALUES (92, 13, 30);
INSERT INTO `sys_classes_actions` VALUES (95, 19, 2);
INSERT INTO `sys_classes_actions` VALUES (99, 20, 5);
INSERT INTO `sys_classes_actions` VALUES (100, 20, 4);
INSERT INTO `sys_classes_actions` VALUES (102, 20, 6);
INSERT INTO `sys_classes_actions` VALUES (103, 20, 7);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_classes_sections`
-- 

DROP TABLE IF EXISTS `sys_classes_sections`;
CREATE TABLE `sys_classes_sections` (
  `id` int(11) NOT NULL auto_increment,
  `class_id` int(11) default NULL,
  `section_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_section` (`section_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_classes_sections`
-- 

INSERT INTO `sys_classes_sections` VALUES (1, 1, 1);
INSERT INTO `sys_classes_sections` VALUES (2, 2, 1);
INSERT INTO `sys_classes_sections` VALUES (3, 3, 2);
INSERT INTO `sys_classes_sections` VALUES (4, 4, 2);
INSERT INTO `sys_classes_sections` VALUES (5, 5, 3);
INSERT INTO `sys_classes_sections` VALUES (6, 6, 4);
INSERT INTO `sys_classes_sections` VALUES (7, 7, 6);
INSERT INTO `sys_classes_sections` VALUES (8, 8, 2);
INSERT INTO `sys_classes_sections` VALUES (9, 9, 7);
INSERT INTO `sys_classes_sections` VALUES (10, 10, 8);
INSERT INTO `sys_classes_sections` VALUES (11, 11, 8);
INSERT INTO `sys_classes_sections` VALUES (12, 12, 2);
INSERT INTO `sys_classes_sections` VALUES (13, 13, 4);
INSERT INTO `sys_classes_sections` VALUES (14, 17, 9);
INSERT INTO `sys_classes_sections` VALUES (15, 18, 9);
INSERT INTO `sys_classes_sections` VALUES (16, 19, 10);
INSERT INTO `sys_classes_sections` VALUES (17, 20, 10);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_modules`
-- 

DROP TABLE IF EXISTS `sys_modules`;
CREATE TABLE `sys_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `main_class` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_modules`
-- 

INSERT INTO `sys_modules` VALUES (1, 'news', NULL);
INSERT INTO `sys_modules` VALUES (2, 'user', NULL);
INSERT INTO `sys_modules` VALUES (3, 'timer', NULL);
INSERT INTO `sys_modules` VALUES (4, 'page', NULL);
INSERT INTO `sys_modules` VALUES (5, 'access', NULL);
INSERT INTO `sys_modules` VALUES (6, 'admin', NULL);
INSERT INTO `sys_modules` VALUES (8, 'comments', NULL);
INSERT INTO `sys_modules` VALUES (9, 'fileManager', 17);
INSERT INTO `sys_modules` VALUES (10, 'catalogue', 19);

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_obj_id`
-- 

DROP TABLE IF EXISTS `sys_obj_id`;
CREATE TABLE `sys_obj_id` (
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_obj_id`
-- 

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

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_obj_id_named`
-- 

DROP TABLE IF EXISTS `sys_obj_id_named`;
CREATE TABLE `sys_obj_id_named` (
  `obj_id` int(11) unsigned default NULL,
  `name` char(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_obj_id_named`
-- 

INSERT INTO `sys_obj_id_named` VALUES (55, 'user_userFolder');
INSERT INTO `sys_obj_id_named` VALUES (56, 'user_groupFolder');
INSERT INTO `sys_obj_id_named` VALUES (58, 'access_groupFolder');
INSERT INTO `sys_obj_id_named` VALUES (71, 'access_user_group');
INSERT INTO `sys_obj_id_named` VALUES (60, 'news_news');
INSERT INTO `sys_obj_id_named` VALUES (61, 'news_newsFolder');
INSERT INTO `sys_obj_id_named` VALUES (62, 'access_news_newsFolder');
INSERT INTO `sys_obj_id_named` VALUES (63, 'access_news_news');
INSERT INTO `sys_obj_id_named` VALUES (64, 'access_page_page');
INSERT INTO `sys_obj_id_named` VALUES (65, 'timer_timer');
INSERT INTO `sys_obj_id_named` VALUES (69, 'access_admin_admin');
INSERT INTO `sys_obj_id_named` VALUES (72, 'access_user_user');
INSERT INTO `sys_obj_id_named` VALUES (73, 'access_sys_access');
INSERT INTO `sys_obj_id_named` VALUES (74, 'access_timer_timer');
INSERT INTO `sys_obj_id_named` VALUES (75, 'access_user_userGroup');
INSERT INTO `sys_obj_id_named` VALUES (95, 'access_comments_commentsFolder');
INSERT INTO `sys_obj_id_named` VALUES (94, 'access_comments_comments');
INSERT INTO `sys_obj_id_named` VALUES (122, 'access_user_userAuth');
INSERT INTO `sys_obj_id_named` VALUES (123, 'access_comments_Array');
INSERT INTO `sys_obj_id_named` VALUES (158, 'access_foo_foo');
INSERT INTO `sys_obj_id_named` VALUES (162, 'access_page_pageFolder');
INSERT INTO `sys_obj_id_named` VALUES (190, 'access__q');
INSERT INTO `sys_obj_id_named` VALUES (191, 'access__file');
INSERT INTO `sys_obj_id_named` VALUES (192, 'access__folder');
INSERT INTO `sys_obj_id_named` VALUES (193, 'access_fileManager_file');
INSERT INTO `sys_obj_id_named` VALUES (194, 'access_fileManager_folder');
INSERT INTO `sys_obj_id_named` VALUES (198, 'access_fileManager_fileManager');
INSERT INTO `sys_obj_id_named` VALUES (233, 'access_catalogue_catalogue');
INSERT INTO `sys_obj_id_named` VALUES (240, 'access__catalogue');

-- --------------------------------------------------------

-- 
-- Структура таблицы `sys_sections`
-- 

DROP TABLE IF EXISTS `sys_sections`;
CREATE TABLE `sys_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `sys_sections`
-- 

INSERT INTO `sys_sections` VALUES (7, 'admin');
INSERT INTO `sys_sections` VALUES (10, 'catalogue');
INSERT INTO `sys_sections` VALUES (8, 'comments');
INSERT INTO `sys_sections` VALUES (9, 'fileManager');
INSERT INTO `sys_sections` VALUES (1, 'news');
INSERT INTO `sys_sections` VALUES (4, 'page');
INSERT INTO `sys_sections` VALUES (6, 'sys');
INSERT INTO `sys_sections` VALUES (3, 'timer');
INSERT INTO `sys_sections` VALUES (2, 'user');

-- --------------------------------------------------------

-- 
-- Структура таблицы `user_group`
-- 

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `user_group`
-- 

INSERT INTO `user_group` VALUES (1, 14, 'unauth');
INSERT INTO `user_group` VALUES (2, 15, 'auth');
INSERT INTO `user_group` VALUES (3, 225, 'root');

-- --------------------------------------------------------

-- 
-- Структура таблицы `user_user`
-- 

DROP TABLE IF EXISTS `user_user`;
CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(10) unsigned NOT NULL default '0',
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `user_user`
-- 

INSERT INTO `user_user` VALUES (1, 12, 'guest', '');
INSERT INTO `user_user` VALUES (2, 13, 'admin', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

-- 
-- Структура таблицы `user_userAuth`
-- 

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

-- 
-- Дамп данных таблицы `user_userAuth`
-- 

INSERT INTO `user_userAuth` VALUES (12, 2, '127.0.0.10', '40f005459cebb89062ce9c68d8a1a6e4', 121, 1163984139);
INSERT INTO `user_userAuth` VALUES (14, 2, '127.0.0.10', 'dfbd10d2c43c598707181edac1dcb03f', 126, 1163992875);
INSERT INTO `user_userAuth` VALUES (15, 2, '127.0.0.10', '2fa75156d5b5c303756c73aff49271cd', 148, 1164262245);
INSERT INTO `user_userAuth` VALUES (16, 2, '127.0.0.10', 'cf86fbaa31ae0541760c738157ddad41', 149, 1164762973);
INSERT INTO `user_userAuth` VALUES (17, 2, '127.0.0.10', '231926d71b42299ad056586146d9fdc8', 150, 1165213689);
INSERT INTO `user_userAuth` VALUES (18, 2, '127.0.0.1', '23f7962e0e872c530f4e8af736633a87', 151, 1165448691);
INSERT INTO `user_userAuth` VALUES (19, 2, '127.0.0.1', '87797ac73e4f640b4afc275d741d1204', 155, 1166160735);
INSERT INTO `user_userAuth` VALUES (21, 2, '127.0.0.1', 'd7077cea0a904e17ac64769455aca1c1', 157, 1167013306);
INSERT INTO `user_userAuth` VALUES (22, 2, '127.0.0.1', '6cf0e978f23e2cb178b7aed1112095f9', 176, 1170655390);
INSERT INTO `user_userAuth` VALUES (23, 2, '127.0.0.1', '7f0e40b578c76a1809043d0cb4b1b58d', 189, 1170713610);
INSERT INTO `user_userAuth` VALUES (25, 2, '127.0.0.1', '35309ce4e0316685d1be41d25afde9d7', 224, 1172709883);

-- --------------------------------------------------------

-- 
-- Структура таблицы `user_userGroup_rel`
-- 

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

-- 
-- Дамп данных таблицы `user_userGroup_rel`
-- 

INSERT INTO `user_userGroup_rel` VALUES (1, 1, 1, 50);
INSERT INTO `user_userGroup_rel` VALUES (23, 2, 2, 47);
INSERT INTO `user_userGroup_rel` VALUES (24, 3, 2, 226);
INSERT INTO `user_userGroup_rel` VALUES (29, 2, 3, 232);
        