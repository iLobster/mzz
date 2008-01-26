SET NAMES `utf8`;
# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1284, 7);
COMMIT;

# Synchronize for "sys_actions" Type: Source to target

INSERT INTO `sys_actions` (`id`, `name`) 
VALUES (99, 'groupAdmin');
COMMIT;

# Synchronize for "sys_classes" Type: Source to target

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) 
VALUES (50, 'userFolder', 2);
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

DELETE FROM `sys_classes_actions` WHERE `id`=126;
DELETE FROM `sys_classes_actions` WHERE `id`=127;
DELETE FROM `sys_classes_actions` WHERE `id`=167;
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (263, 50, 9);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (264, 50, 20);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (266, 50, 69);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (270, 50, 4);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (271, 50, 51);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (272, 51, 9);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (276, 50, 99);
COMMIT;

# Synchronize for "sys_classes_sections" Type: Source to target

INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) 
VALUES (49, 50, 2);
INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) 
VALUES (50, 51, 2);
COMMIT;

# Synchronize for "sys_modules" Type: Source to target

UPDATE `sys_modules` 
SET `name`='user', `main_class`=50, `title`='Пользователи', `icon`='users.gif', `order`=90 
WHERE `id`=2;
COMMIT;

# Synchronize for "sys_obj_id" Type: Source to target

INSERT INTO `sys_obj_id` (`id`) 
VALUES (1284);
COMMIT;

# Synchronize for "sys_obj_id_named" Type: Source to target

INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) 
VALUES (1284, 'access_user_userFolder');
COMMIT;

# Synchronize for "user_user" Type: Source to target

UPDATE `user_user` 
SET `obj_id`=12, `login`='guest', `password`='', `created`=NULL, `confirmed`=NULL, `last_login`=1201323712 
WHERE `id`=1;
UPDATE `user_user` 
SET `obj_id`=13, `login`='admin', `password`='098f6bcd4621d373cade4e832627b4f6', `created`=NULL, `confirmed`=NULL, `last_login`=1201064402 
WHERE `id`=2;
COMMIT;