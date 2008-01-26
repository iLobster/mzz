
SET NAMES `utf8`;

# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1285, 40);
COMMIT;

# Synchronize for "sys_classes" Type: Source to target

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) 
VALUES (52, 'groupFolder', 2);
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

DELETE FROM `sys_classes_actions` WHERE `id`=18;
DELETE FROM `sys_classes_actions` WHERE `id`=276;
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (277, 52, 9);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (279, 52, 51);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (280, 52, 14);
COMMIT;

# Synchronize for "sys_classes_sections" Type: Source to target

INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) 
VALUES (51, 52, 2);
COMMIT;

# Synchronize for "sys_obj_id" Type: Source to target

INSERT INTO `sys_obj_id` (`id`) 
VALUES (1285);
COMMIT;

# Synchronize for "tags_tagsItem" Type: Source to target

INSERT INTO `tags_tagsItem` (`id`, `item_obj_id`, `obj_id`, `owner`) 
VALUES (16, 463, 1285, NULL);
COMMIT;

# Synchronize for "user_user" Type: Source to target

UPDATE `user_user` 
SET `obj_id`=12, `login`='guest', `password`='', `created`=NULL, `confirmed`=NULL, `last_login`=1201330723 
WHERE `id`=1;
COMMIT;