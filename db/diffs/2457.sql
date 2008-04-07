SET NAMES `utf8`;


# Synchronize for "sys_actions" Type: Source to target

INSERT INTO `sys_actions` (`id`, `name`) 
VALUES (102, 'translate');
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (283, 9, 102);
COMMIT;


# Synchronize for "sys_modules" Type: Source to target

INSERT INTO `sys_modules` (`name`, `main_class`, `title`, `icon`, `order`) 
VALUES ('pager', NULL, 'Пейджер', NULL, NULL);
INSERT INTO `sys_modules` (`name`, `main_class`, `title`, `icon`, `order`) 
VALUES ('simple', NULL, 'simple', NULL, NULL);
COMMIT;
