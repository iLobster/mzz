SET NAMES `utf8`;

# Synchronize for "fileManager_file" Type: Source to target

UPDATE `fileManager_file` 
SET `realname`='161577520fa51c296ac29682a28ab915', `name`='1.jpg', `ext`='jpg', `size`=41037, `modified`=1201062605, `downloads`=46, `right_header`=1, `about`='По фамилии Fernandes', `folder_id`=5, `obj_id`=611, `storage_id`=1 
WHERE `id`=1;
DELETE FROM `fileManager_file` WHERE `id`=26;
COMMIT;

# Synchronize for "fileManager_folder" Type: Source to target

DELETE FROM `fileManager_folder` WHERE `id`=7;
COMMIT;

# Synchronize for "fileManager_folder_tree" Type: Source to target

UPDATE `fileManager_folder_tree` 
SET `lkey`=1, `rkey`=6, `level`=1 
WHERE `id`=1;
DELETE FROM `fileManager_folder_tree` WHERE `id`=7;
UPDATE `fileManager_folder_tree` 
SET `lkey`=4, `rkey`=5, `level`=2 
WHERE `id`=8;
COMMIT;

# Synchronize for "sys_access_registry" Type: Source to target

DELETE FROM `sys_access_registry` WHERE `obj_id`=1093;
DELETE FROM `sys_access_registry` WHERE `obj_id`=1283;
COMMIT;