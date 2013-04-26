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

USE `mzz`;

SET sql_mode = '';

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
  `downloads` INTEGER(11) DEFAULT NULL,
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
AUTO_INCREMENT=27 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_file` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_file` (`id`, `realname`, `name`, `ext`, `size`, `modified`, `downloads`, `right_header`, `direct_link`, `about`, `folder_id`, `obj_id`, `storage_id`) VALUES 
  (1,'161577520fa51c296ac29682a28ab915','1.jpg','jpg',41037,1201062605,46,1,0,'По фамилии Fernandes',3,611,1),
  (15,'a0494eeadea195b23bc2947780346d47','2.jpg','jpg',28565,1193874091,NULL,1,0,'',3,1195,1),
  (16,'10fb1fa8b1d8cc73842511e6d77fb441','3.jpg','jpg',36957,1200917090,4,1,0,'',3,1199,1),
  (17,'f7566302d872ec98768bfa775b5c7dce','4.jpg','jpg',32557,1200916924,4,1,0,'',3,1203,1),
  (18,'eca188a35070342d2daa3d11b904d32f','5.jpg','jpg',31552,1197726704,7,1,0,'',3,1207,1),
  (23,'fc6bfaf392fd56f0c1353a304ee609f0','6.jpg','jpg',33454,1193874183,NULL,1,0,'',3,1215,1),
  (24,'c77d18916bbfc6c1b7e25fd66d1055ae','7.jpg','jpg',28233,1193988674,2,1,0,'',3,1219,1),
  (25,'b09b5fb89d1399ba4f66c1f5b5940981.jpg','avatar_1.jpg','jpg',4545,1225006148,11,1,1,'test',1,1275,2),
  (26,'0c0ab86dcc8875d1bd12f57b4f93c198.png','user.png','png',333,NULL,NULL,0,0,'',1,1434,1);
COMMIT;

#
# Structure for the `fileManager_folder` table : 
#

DROP TABLE IF EXISTS `fileManager_folder`;

CREATE TABLE `fileManager_folder` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `title` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent` INTEGER(11) UNSIGNED DEFAULT NULL,
  `path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `obj_id` INTEGER(11) UNSIGNED DEFAULT NULL,
  `filesize` INTEGER(11) UNSIGNED DEFAULT NULL,
  `exts` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL,
  `storage_id` INTEGER(11) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=4 ROW_FORMAT=FIXED CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_folder` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_folder` (`id`, `name`, `title`, `parent`, `path`, `obj_id`, `filesize`, `exts`, `storage_id`) VALUES 
  (1,'root','root',NULL,NULL,1431,0,NULL,1),
  (3,'test','test2',NULL,NULL,1433,0,'',1);
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
AUTO_INCREMENT=4 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

#
# Data for the `fileManager_folder_tree` table  (LIMIT 0,500)
#

INSERT INTO `fileManager_folder_tree` (`id`, `path`, `foreign_key`, `level`, `spath`) VALUES 
  (1,'root/',1,1,'1/'),
  (3,'root/test/',3,2,'1/3/');
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
  (1,'local','../files/','/'),
  (2,'avatars','files/avatars/','/files/avatars/');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;