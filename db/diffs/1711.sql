CREATE TABLE `fileManager_storage` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(255) default NULL,
  `path` char(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `fileManager_file` ADD COLUMN `server_id` INTEGER(11) DEFAULT NULL;


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

# Synchronize for "user_user" Type: Source to target

UPDATE `user_user` 
SET `obj_id`=12, `login`='guest', `password`='', `created`=NULL, `confirmed`=NULL, `last_login`=1199847239 
WHERE `id`=1 AND `obj_id`=12 AND `login`='guest' AND `password`='' AND IsNull(`created`) AND IsNull(`confirmed`) AND `last_login`=1198040969;
UPDATE `user_user` 
SET `obj_id`=13, `login`='admin', `password`='098f6bcd4621d373cade4e832627b4f6', `created`=NULL, `confirmed`=NULL, `last_login`=1199847233 
WHERE `id`=2 AND `obj_id`=13 AND `login`='admin' AND `password`='098f6bcd4621d373cade4e832627b4f6' AND IsNull(`created`) AND IsNull(`confirmed`) AND `last_login`=1199595961;
UPDATE `user_user` 
SET `obj_id`=472, `login`='pedro', `password`='098f6bcd4621d373cade4e832627b4f6', `created`=1188187851, `confirmed`=NULL, `last_login`=1199847249 
WHERE `id`=3 AND `obj_id`=472 AND `login`='pedro' AND `password`='098f6bcd4621d373cade4e832627b4f6' AND `created`=1188187851 AND IsNull(`confirmed`) AND `last_login`=1199842206;
COMMIT;