SET NAMES `utf8`;

ALTER TABLE `page_page` DROP INDEX `id`;
ALTER TABLE `sys_access_registry` DROP INDEX `obj_id`;
CREATE TABLE `fileManager_storage` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `fileManager_file` ADD COLUMN `server_id` INTEGER(11) DEFAULT NULL;
ALTER TABLE `news_news` MODIFY COLUMN `id` INTEGER(11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `news_newsFolder_lang` MODIFY COLUMN `id` INTEGER(11) NOT NULL DEFAULT '0' PRIMARY KEY;
ALTER TABLE `news_newsFolder_lang` MODIFY COLUMN `lang_id` INTEGER(11) NOT NULL DEFAULT '0' PRIMARY KEY;
ALTER TABLE `news_news_lang` MODIFY COLUMN `id` INTEGER(11) NOT NULL DEFAULT '0' PRIMARY KEY;
ALTER TABLE `news_news_lang` MODIFY COLUMN `lang_id` INTEGER(11) NOT NULL DEFAULT '0' PRIMARY KEY;
ALTER TABLE `page_page` MODIFY COLUMN `id` INTEGER(11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `sys_access_registry` MODIFY COLUMN `obj_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `sys_obj_id_named` MODIFY COLUMN `obj_id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `news_news` ADD PRIMARY KEY (`id`);
ALTER TABLE `news_news` ADD UNIQUE KEY `id_2` (`id`);
ALTER TABLE `news_newsFolder_lang` ADD PRIMARY KEY (`id`, `lang_id`);
ALTER TABLE `news_news_lang` ADD PRIMARY KEY (`id`, `lang_id`);
ALTER TABLE `page_page` ADD PRIMARY KEY (`id`);
ALTER TABLE `sys_access_registry` ADD PRIMARY KEY (`obj_id`);
ALTER TABLE `sys_obj_id_named` ADD PRIMARY KEY (`obj_id`);
ALTER TABLE `sys_obj_id_named` ADD UNIQUE KEY `name` (`name`);

# Synchronize for "sys_classes" Type: Source to target

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) 
VALUES (49, 'storage', 9);
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (260, 49, 9);
COMMIT;

# Synchronize for "sys_classes_sections" Type: Source to target

INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) 
VALUES (48, 49, 9);
COMMIT;
