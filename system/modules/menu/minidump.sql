# SQL Manager 2007 for MySQL 4.3.4.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mzz


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES cp1251 */;

SET FOREIGN_KEY_CHECKS=0;

USE `mzz`;

SET sql_mode = '';

#
# Structure for the `menu_menu` table : 
#

DROP TABLE IF EXISTS `menu_menu`;

CREATE TABLE `menu_menu` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `obj_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=8 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menu` table  (LIMIT 0,500)
#

INSERT INTO `menu_menu` (`id`, `name`, `title`, `obj_id`) VALUES 
  (6,'hmenu','Верхнее меню',1185);
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
  `title` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `order` INTEGER(10) UNSIGNED DEFAULT '0',
  `args` TEXT COLLATE utf8_general_ci NOT NULL,
  `obj_id` INTEGER(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=28 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `menu_menuItem` table  (LIMIT 0,500)
#

INSERT INTO `menu_menuItem` (`id`, `parent_id`, `type_id`, `menu_id`, `title`, `order`, `args`, `obj_id`) VALUES 
  (9,0,1,6,'Новости',1,'a:1:{s:3:\"url\";s:5:\"/test\";}',1186),
  (10,0,1,6,'Каталог',3,'a:1:{s:3:\"url\";s:5:\"/test\";}',1187),
  (11,0,1,6,'Галерея',2,'a:1:{s:3:\"url\";s:5:\"/test\";}',1188),
  (12,0,1,6,'FAQ',5,'a:1:{s:3:\"url\";s:5:\"/test\";}',1189),
  (13,0,1,6,'Форум',4,'a:1:{s:3:\"url\";s:5:\"/test\";}',1190),
  (14,0,1,6,'ПУ',7,'a:1:{s:3:\"url\";s:5:\"/test\";}',1191),
  (24,0,1,6,'О нас',6,'a:1:{s:3:\"url\";s:5:\"/test\";}',1301),
  (26,0,2,6,'Адвансд',8,'a:4:{s:5:\"route\";s:8:\"default2\";s:7:\"section\";s:4:\"news\";s:6:\"action\";s:4:\"list\";s:6:\"regexp\";s:14:\"!news/list!siU\";}',1304);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;