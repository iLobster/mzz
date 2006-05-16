# MySQL-Front 3.2  (Build 12.3)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;

/*!40101 SET NAMES utf8 */;
/*!40103 SET TIME_ZONE='SYSTEM' */;

# Host: localhost    Database: mzz_test
# ------------------------------------------------------
# Server version 5.0.18-nt

/*!40101 SET NAMES cp1251 */;

#
# Table structure for table news_news
#

DROP TABLE IF EXISTS `news_news`;
CREATE TABLE `news_news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `editor` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `folder_id` int(11) default NULL,
  `created` int(11) default NULL,
  `updated` int(11) default NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_news
#


#
# Table structure for table news_news_tree
#

DROP TABLE IF EXISTS `news_news_tree`;
CREATE TABLE `news_news_tree` (
  `id` int(11) NOT NULL auto_increment,
  `name` char(255) default NULL,
  `parent` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table news_news_tree
#


#
# Table structure for table page_page
#

DROP TABLE IF EXISTS `page_page`;
CREATE TABLE `page_page` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table page_page
#


#
# Table structure for table sessions
#

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` int(11) NOT NULL auto_increment,
  `sid` varchar(50) NOT NULL default '',
  `ts` timestamp NOT NULL default '0000-00-00 00:00:00',
  `valid` enum('yes','no') NOT NULL default 'yes',
  `data` blob,
  PRIMARY KEY  (`id`),
  KEY `valid` (`valid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table sessions
#


#
# Table structure for table user_user
#

DROP TABLE IF EXISTS `user_user`;
CREATE TABLE `user_user` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(255) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Dumping data for table user_user
#


/*!40101 SET NAMES utf8 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
