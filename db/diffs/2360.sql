SET NAMES `utf8`;

# Synchronize for "sys_actions" Type: Source to target

INSERT INTO `sys_actions` (`id`, `name`) 
VALUES (101, 'massAction');
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (282, 20, 101);
COMMIT;