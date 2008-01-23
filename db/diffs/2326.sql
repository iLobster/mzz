SET NAMES `utf8`;

# Synchronize for "fileManager_file" Type: Source to target

INSERT INTO `fileManager_file` (`id`, `realname`, `name`, `ext`, `size`, `modified`, `downloads`, `right_header`, `about`, `folder_id`, `obj_id`, `storage_id`) 
VALUES (26, '21e111e33fcaee9b0371405f94b2e5a6.jpg', 'notfound.jpg', 'jpg', 40260, 1201056438, NULL, 1, '', 7, 1283, 1);
COMMIT;

# Synchronize for "fileManager_folder" Type: Source to target

UPDATE `fileManager_folder` 
SET `name`='system', `title`='Системный каталог', `parent`=7, `path`='root/system', `obj_id`=1093, `filesize`=0, `exts`='' 
WHERE `id`=7;
COMMIT;

# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1283, 14);
COMMIT;

# Synchronize for "sys_actions" Type: Source to target

UPDATE `sys_actions` 
SET `name`='editCategory' 
WHERE `id`=74;
COMMIT;

# Synchronize for "sys_cfg_titles" Type: Source to target

INSERT INTO `sys_cfg_titles` (`id`, `title`) 
VALUES (13, 'Путь до каталога хранения файлов в модуле fileManager');
COMMIT;

# Synchronize for "sys_cfg_values" Type: Source to target

INSERT INTO `sys_cfg_values` (`id`, `cfg_id`, `name`, `title`, `type_id`, `value`) 
VALUES (55, 21, 12, 13, 1, 'root/gallery');
COMMIT;

# Synchronize for "sys_cfg_vars" Type: Source to target

INSERT INTO `sys_cfg_vars` (`id`, `name`) 
VALUES (12, 'fileManager_path');
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (261, 36, 73);
COMMIT;

# Synchronize for "sys_obj_id" Type: Source to target

INSERT INTO `sys_obj_id` (`id`) 
VALUES (1283);
COMMIT;
