SET NAMES `utf8`;

ALTER TABLE `fileManager_file` ADD COLUMN `direct_link` INTEGER(11) DEFAULT '0';
ALTER TABLE `fileManager_storage` ADD COLUMN `web_path` CHAR(255) COLLATE utf8_general_ci DEFAULT NULL;
