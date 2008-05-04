SET NAMES `utf8`;

CREATE TABLE `ratings_ratings` (
  `id` int(11) NOT NULL auto_increment,
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `ratings_ratingsFolder` (
  `id` int(11) NOT NULL auto_increment,
  `obj_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `ratesum` int(11) default '0',
  `ratecount` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1288, 7);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1289, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1290, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1291, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1292, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1293, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1294, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1295, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1296, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1297, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1298, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1299, 52);
INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1300, 52);
COMMIT;

# Synchronize for "sys_classes" Type: Source to target

INSERT INTO `sys_classes` (`id`, `name`, `module_id`) 
VALUES (53, 'ratingsFolder', 21);
INSERT INTO `sys_classes` (`id`, `name`, `module_id`) 
VALUES (54, 'ratings', 21);
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (284, 53, 9);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (285, 54, 9);
INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (286, 53, 3);
COMMIT;

# Synchronize for "sys_classes_sections" Type: Source to target

INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) 
VALUES (52, 53, 19);
INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) 
VALUES (53, 54, 19);
COMMIT;

# Synchronize for "sys_modules" Type: Source to target

INSERT INTO `sys_modules` (`id`, `name`, `main_class`, `title`, `icon`, `order`) 
VALUES (21, 'ratings', 53, '?aeoeiae', '', 0);
COMMIT;

# Synchronize for "sys_obj_id" Type: Source to target

INSERT INTO `sys_obj_id` (`id`) 
VALUES (1288);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1289);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1290);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1291);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1292);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1293);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1294);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1295);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1296);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1297);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1298);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1299);
INSERT INTO `sys_obj_id` (`id`) 
VALUES (1300);
COMMIT;

# Synchronize for "sys_obj_id_named" Type: Source to target

INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) 
VALUES (1288, 'access_ratings_ratingsFolder');
COMMIT;

# Synchronize for "sys_sections" Type: Source to target

INSERT INTO `sys_sections` (`id`, `name`, `title`, `order`) 
VALUES (19, 'ratings', '', 0);
COMMIT;