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
  (24,133,'q',2,1163995837,13),
  (25,135,'asdfsdfg',2,1164000450,14),
  (29,141,'�',2,1164004456,15),
  (30,142,'',2,1164004458,15),
  (31,143,'aqwe���qfgggg',2,1164004460,15),
  (32,147,'aaaaaaaa',2,1164157623,17);

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
  (12,131,66),
  (13,132,48),
  (15,137,136),
  (16,145,10),
  (17,146,50);

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
  (2,48,'sadf',2,'asdqw3423aaaa',2,1161647727,1166393498),
  (3,50,'qweqwer',2,'dsff',3,1161647948,1161647948),
  (4,66,'qweqwe1',2,'234',2,1162960578,1168314664),
  (5,136,'ggggggggg',2,'vvvvvvvv���',2,1164001191,1168314656),
  (6,153,'123',2,'qwe',2,1166054735,1168307933);

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
  (3,49,'zzz','����������',2,'root/zzz'),
  (5,159,'one_more','zzz',4,'root/zzz/one_more'),
  (6,160,'two','qqq',5,'root/zzz/two');

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
  (1,1,8,1),
  (2,2,7,2),
  (4,3,4,3),
  (5,5,6,3);

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
  (1,9,'main','������ ��������a','��� ������, ������� ��������',1),
  (2,10,'404','404 Not Found','������������� �������� �� �������!',1),
  (3,11,'test','test','test',1),
  (4,57,'403','������ ��������','������ ��������',1);

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
  (2,163,'foo','foo',2,'root/foo');

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
  (1,1,4,1),
  (2,2,3,2);

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
  (937,9,1,66,NULL,1,0,0),
  (669,7,2,49,NULL,2,1,0),
  (1112,2,3,0,NULL,1,0,0),
  (1111,12,3,0,NULL,1,0,0),
  (394,9,2,0,0,NULL,1,0),
  (391,6,2,0,0,NULL,1,0),
  (390,5,2,0,0,NULL,1,0),
  (441,9,2,6,2,NULL,1,0),
  (1210,9,1,48,2,NULL,1,0),
  (847,9,1,48,NULL,2,1,0),
  (1222,9,1,48,NULL,1,0,0),
  (1209,2,1,48,2,NULL,1,1),
  (857,1,1,0,0,NULL,1,0),
  (389,4,2,0,0,NULL,1,0),
  (440,8,2,6,2,NULL,1,0),
  (439,7,2,6,2,NULL,1,0),
  (438,6,2,6,2,NULL,1,0),
  (437,5,2,6,2,NULL,1,0),
  (436,4,2,6,2,NULL,1,0),
  (1208,1,1,48,2,NULL,1,0),
  (664,8,2,49,2,NULL,1,0),
  (663,7,2,49,2,NULL,1,0),
  (219,1,1,50,2,NULL,1,0),
  (220,2,1,50,2,NULL,1,0),
  (221,3,1,50,NULL,1,1,0),
  (222,3,1,50,NULL,2,1,0),
  (223,9,1,50,2,NULL,1,0),
  (724,9,1,66,2,NULL,1,0),
  (936,2,1,66,NULL,1,0,0),
  (668,6,2,49,NULL,2,1,0),
  (667,5,2,49,NULL,2,1,0),
  (666,4,2,49,NULL,2,1,0),
  (723,2,1,66,2,NULL,1,0),
  (935,1,1,66,NULL,1,0,0),
  (722,1,1,66,2,NULL,1,0),
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
  (1207,3,1,48,2,NULL,1,0),
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
  (846,2,1,48,NULL,2,1,0),
  (845,1,1,48,NULL,2,1,0),
  (844,3,1,48,NULL,2,1,0),
  (721,3,1,66,2,NULL,1,0),
  (934,3,1,66,NULL,1,1,0),
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
  (1138,9,9,69,NULL,2,1,0),
  (1137,20,9,69,NULL,2,1,0),
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
  (1032,9,11,131,2,NULL,1,0),
  (1007,5,11,131,NULL,2,1,0),
  (789,5,11,96,NULL,2,1,0),
  (790,19,11,96,NULL,2,1,0),
  (791,9,11,96,NULL,1,0,1),
  (792,9,11,96,NULL,2,1,0),
  (1006,5,11,131,NULL,1,1,0),
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
  (1031,19,11,131,2,NULL,0,0),
  (1010,19,11,131,NULL,2,1,0),
  (1009,19,11,131,NULL,1,0,0),
  (1030,5,11,131,2,NULL,0,0),
  (1013,9,11,131,NULL,2,0,0),
  (1012,9,11,131,NULL,1,0,0),
  (1017,5,11,132,1,NULL,0,0),
  (1016,5,11,132,NULL,2,1,0),
  (1015,5,11,132,NULL,1,1,0),
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
  (1020,19,11,132,1,NULL,0,0),
  (1019,19,11,132,NULL,2,1,0),
  (1018,19,11,132,NULL,1,0,0),
  (1023,9,11,132,1,NULL,1,0),
  (1022,9,11,132,NULL,2,0,0),
  (1021,9,11,132,NULL,1,0,0),
  (1024,1,10,133,2,NULL,1,0),
  (1025,2,10,133,2,NULL,1,0),
  (1026,9,10,133,2,NULL,1,0),
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
  (1206,9,1,136,2,NULL,1,0),
  (1046,1,1,136,1,NULL,0,0),
  (1205,2,1,136,2,NULL,1,0),
  (1048,2,1,136,1,NULL,0,0),
  (1204,1,1,136,2,NULL,1,0),
  (1050,3,1,136,1,NULL,1,0),
  (1203,3,1,136,2,NULL,1,0),
  (1052,9,1,136,1,NULL,0,0),
  (1053,5,11,137,NULL,1,1,0),
  (1054,5,11,137,NULL,2,1,0),
  (1106,9,11,137,2,NULL,1,0),
  (1056,19,11,137,NULL,1,0,0),
  (1057,19,11,137,NULL,2,1,0),
  (1105,19,11,137,2,NULL,0,0),
  (1059,9,11,137,NULL,1,0,0),
  (1060,9,11,137,NULL,2,0,0),
  (1104,5,11,137,2,NULL,0,0),
  (1073,9,10,141,2,NULL,1,0),
  (1072,2,10,141,2,NULL,1,0),
  (1071,1,10,141,2,NULL,1,0),
  (1076,9,10,142,2,NULL,1,0),
  (1075,2,10,142,2,NULL,1,0),
  (1074,1,10,142,2,NULL,1,0),
  (1077,1,10,143,2,NULL,1,0),
  (1078,2,10,143,2,NULL,1,0),
  (1079,9,10,143,2,NULL,1,0),
  (1080,5,11,145,NULL,1,1,0),
  (1081,5,11,145,NULL,2,1,0),
  (1082,5,11,145,1,NULL,0,0),
  (1083,19,11,145,NULL,1,0,0),
  (1084,19,11,145,NULL,2,1,0),
  (1085,19,11,145,1,NULL,0,0),
  (1086,9,11,145,NULL,1,0,0),
  (1087,9,11,145,NULL,2,0,0),
  (1088,9,11,145,1,NULL,1,0),
  (1089,5,11,146,NULL,1,1,0),
  (1090,5,11,146,NULL,2,1,0),
  (1091,5,11,146,2,NULL,0,0),
  (1092,19,11,146,NULL,1,0,0),
  (1093,19,11,146,NULL,2,1,0),
  (1094,19,11,146,2,NULL,0,0),
  (1095,9,11,146,NULL,1,0,0),
  (1096,9,11,146,NULL,2,0,0),
  (1097,9,11,146,2,NULL,1,0),
  (1098,1,10,147,2,NULL,1,0),
  (1099,2,10,147,2,NULL,1,0),
  (1100,9,10,147,2,NULL,1,0),
  (1121,10,3,0,0,NULL,1,0),
  (1122,11,3,0,0,NULL,1,0),
  (1123,5,3,0,0,NULL,1,0),
  (1124,1,3,0,0,NULL,1,0),
  (1125,12,3,0,0,NULL,1,0),
  (1126,2,3,0,0,NULL,1,0),
  (1127,9,3,0,0,NULL,1,0),
  (1136,3,9,69,NULL,2,1,0),
  (1141,20,7,63,NULL,2,1,0),
  (1144,20,7,72,NULL,2,1,0),
  (1147,20,7,64,NULL,2,1,0),
  (1150,20,7,94,2,NULL,1,0),
  (1221,2,1,48,NULL,1,0,0),
  (1220,1,1,48,NULL,1,0,0),
  (1219,3,1,48,NULL,1,1,0),
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
  (1265,1,1,153,2,NULL,1,0),
  (1297,5,2,159,NULL,1,1,0),
  (1267,2,1,153,2,NULL,1,0),
  (1296,4,2,159,2,NULL,1,0),
  (1269,3,1,153,2,NULL,1,0),
  (1295,4,2,159,2,NULL,1,0),
  (1271,9,1,153,2,NULL,1,0),
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
  (1366,5,13,163,2,NULL,1,0);

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
  (48,1),
  (49,2),
  (50,1),
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
  (66,1),
  (69,9),
  (70,7),
  (71,7),
  (72,7),
  (73,7),
  (74,7),
  (75,7),
  (132,11),
  (133,10),
  (95,7),
  (134,11),
  (131,11),
  (135,10),
  (99,10),
  (100,10),
  (101,10),
  (136,1),
  (137,11),
  (94,7),
  (142,10),
  (143,10),
  (145,11),
  (107,10),
  (108,10),
  (121,12),
  (123,7),
  (141,10),
  (126,12),
  (122,7),
  (146,11),
  (147,10),
  (148,12),
  (149,12),
  (150,12),
  (151,12),
  (155,12),
  (153,1),
  (157,12),
  (159,2),
  (160,2),
  (161,13),
  (162,7),
  (163,13);

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
  (20,'admin');

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
  (4,1,1),
  (5,7,6),
  (6,2,2),
  (1,0,0);

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
  (16,4,'items_per_page','50'),
  (13,5,'',''),
  (14,6,'items_per_page','20');

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
  (13,'pageFolder',4);

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
  KEY `class_id` (`class_id`)
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
  (45,1,20),
  (44,7,20),
  (47,13,7),
  (48,13,6),
  (49,13,4),
  (50,13,5);

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
  KEY `module_section` (`section_id`,`class_id`),
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
  (13,13,4);

COMMIT;

#
# Structure for the `sys_modules` table : 
#

DROP TABLE IF EXISTS `sys_modules`;

CREATE TABLE `sys_modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_modules` table  (LIMIT 0,500)
#

INSERT INTO `sys_modules` (`id`, `name`) VALUES 
  (1,'news'),
  (2,'user'),
  (3,'timer'),
  (4,'page'),
  (5,'access'),
  (6,'admin'),
  (8,'comments');

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
  (163);

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
  (162,'access_page_pageFolder');

COMMIT;

#
# Structure for the `sys_sections` table : 
#

DROP TABLE IF EXISTS `sys_sections`;

CREATE TABLE `sys_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Data for the `sys_sections` table  (LIMIT 0,500)
#

INSERT INTO `sys_sections` (`id`, `name`) VALUES 
  (7,'admin'),
  (8,'comments'),
  (1,'news'),
  (4,'page'),
  (6,'sys'),
  (3,'timer'),
  (2,'user');

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
  (21,2,'127.0.0.1','d7077cea0a904e17ac64769455aca1c1',157,1167013306);

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
  (23,2,2,47);

COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;