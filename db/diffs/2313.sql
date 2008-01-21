SET NAMES `utf8`;

ALTER TABLE `fileManager_file` DROP COLUMN `server_id`;
ALTER TABLE `fileManager_file` ADD COLUMN `storage_id` INTEGER(11) DEFAULT NULL;

# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1276, 48);
COMMIT;

# Synchronize for "sys_cfg_values" Type: Source to target

DELETE FROM `sys_cfg_values` WHERE `id`=21;
DELETE FROM `sys_cfg_values` WHERE `id`=30;
DELETE FROM `sys_cfg_values` WHERE `id`=49;
COMMIT;

# Synchronize for "sys_obj_id" Type: Source to target

INSERT INTO `sys_obj_id` (`id`) 
VALUES (1276);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1277);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1278);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1279);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1280);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1281);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1282);
COMMIT;

# Synchronize for "fileManager_storage" Type: Source to target

INSERT INTO `fileManager_storage` (`id`, `name`, `path`) 
VALUES (1, 'local', '../files/');
COMMIT;