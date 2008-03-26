SET NAMES `utf8`;

ALTER TABLE `catalogue_catalogue_data` DROP INDEX `id`;
ALTER TABLE `menu_menuItem_data` DROP INDEX `id`;
ALTER TABLE `catalogue_catalogue_data` MODIFY COLUMN `id` INTEGER(11) NOT NULL DEFAULT '0';
ALTER TABLE `catalogue_catalogue_data` MODIFY COLUMN `property_type` INTEGER(11) UNSIGNED NOT NULL;
ALTER TABLE `menu_menuItem_data` MODIFY COLUMN `id` INTEGER(11) NOT NULL DEFAULT '0';
ALTER TABLE `menu_menuItem_data` MODIFY COLUMN `property_type` INTEGER(11) UNSIGNED NOT NULL;
ALTER TABLE `catalogue_catalogue_data` ADD PRIMARY KEY (`id`, `property_type`);
ALTER TABLE `menu_menuItem_data` ADD PRIMARY KEY (`id`, `property_type`);

CREATE TABLE `sys_lang_lang` (
  `id` int(11) unsigned NOT NULL,
  `lang_id` int(11) unsigned NOT NULL,
  `name` char(32) default NULL,
  PRIMARY KEY  (`id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `sys_lang_lang` (`id`, `lang_id`, `name`) 
VALUES (1, 1, 'русский');
INSERT INTO `sys_lang_lang` (`id`, `lang_id`, `name`) 
VALUES (1, 2, 'russian');
INSERT INTO `sys_lang_lang` (`id`, `lang_id`, `name`) 
VALUES (2, 1, 'английский');
INSERT INTO `sys_lang_lang` (`id`, `lang_id`, `name`) 
VALUES (2, 2, 'english');
COMMIT;