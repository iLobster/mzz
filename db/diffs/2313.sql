ALTER TABLE `fileManager_file` DROP COLUMN `server_id`;
ALTER TABLE `fileManager_file` ADD COLUMN `storage_id` INTEGER(11) DEFAULT NULL;

# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1276, 48);
COMMIT;

# Synchronize for "sys_cfg_values" Type: Source to target

DELETE FROM `sys_cfg_values` WHERE `id`=21 AND `cfg_id`=7 AND `name`=2 AND `title`=2 AND `type_id`=1 AND `value`='../tmp';
DELETE FROM `sys_cfg_values` WHERE `id`=30 AND `cfg_id`=8 AND `name`=2 AND `title`=2 AND `type_id`=1 AND `value`='../files';
DELETE FROM `sys_cfg_values` WHERE `id`=49 AND `cfg_id`=18 AND `name`=2 AND `title`=2 AND `type_id`=1 AND `value`='../files';
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

# Synchronize for "fileManager_file" Type: Source to target

UPDATE `fileManager_file` 
SET `realname`='161577520fa51c296ac29682a28ab915', `name`='1.jpg', `ext`='jpg', `size`=41037, `modified`=1200893586, `downloads`=29, `right_header`=1, `about`='По фамилии Fernandes', `folder_id`=5, `obj_id`=611 
WHERE `id`=1 AND `realname`='161577520fa51c296ac29682a28ab915' AND `name`='1.jpg' AND `ext`='jpg' AND `size`=41037 AND `modified`=1189865423 AND `downloads`=28 AND `right_header`=1 AND `about`='По фамилии Fernandes' AND `folder_id`=5 AND `obj_id`=611;
COMMIT;

# Synchronize for "fileManager_storage" Type: Source to target

INSERT INTO `fileManager_storage` (`id`, `name`, `path`) 
VALUES (1, 'local', '../files/');
COMMIT;