SET NAMES `utf8`;

CREATE TABLE `sys_skins` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(32) default NULL,
  `title` char(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
ALTER TABLE `user_user` ADD COLUMN `skin` INTEGER(11) UNSIGNED DEFAULT '1';

# Synchronize for "sys_skins" Type: Source to target

INSERT INTO `sys_skins` (`id`, `name`, `title`) 
VALUES (1, 'default', 'default');
INSERT INTO `sys_skins` (`id`, `name`, `title`) 
VALUES (2, 'light', 'light');
COMMIT;

