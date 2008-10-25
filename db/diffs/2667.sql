SET NAMES `utf8`;

# Synchronize for "sys_actions" Type: Source to target

INSERT INTO `sys_actions` (`id`, `name`) 
VALUES (104, 'adminTypes');
INSERT INTO `sys_actions` (`id`, `name`) 
VALUES (105, 'adminProperties');
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

DELETE FROM `sys_classes_actions` WHERE `id`=109;
DELETE FROM `sys_classes_actions` WHERE `id`=110;
DELETE FROM `sys_classes_actions` WHERE `id`=121;
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (288, 19, 104);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (289, 19, 105);
COMMIT;
