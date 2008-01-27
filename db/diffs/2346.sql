SET NAMES `utf8`;

# Synchronize for "forum_profile" Type: Source to target

UPDATE `forum_profile` 
SET `messages`=2, `signature`='Я педро!', `avatar_id`=0 
WHERE `user_id`=3;
COMMIT;

# Synchronize for "forum_thread" Type: Source to target

UPDATE `forum_thread` 
SET `title`='Я педро!', `posts_count`=1, `post_date`=1199840852, `author`=3, `forum_id`=4, `obj_id`=1268, `last_post`=94, `closed`=NULL, `sticky`=0, `stickyfirst`=0, `first_post`=92, `view_count`=3 
WHERE `id`=26;
COMMIT;

# Synchronize for "sys_access" Type: Source to target

INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `obj_id`, `uid`, `gid`, `allow`, `deny`) 
VALUES (5014, 98, 47, 0, NULL, 1, 1, 0);
INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `obj_id`, `uid`, `gid`, `allow`, `deny`) 
VALUES (5015, 98, 47, 0, NULL, 2, 1, 0);
COMMIT;

# Synchronize for "sys_access_registry" Type: Source to target

INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) 
VALUES (1286, 7);
COMMIT;

# Synchronize for "sys_actions" Type: Source to target

INSERT INTO `sys_actions` (`id`, `name`) 
VALUES (100, 'editProfile');
COMMIT;

# Synchronize for "sys_classes_actions" Type: Source to target

INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) 
VALUES (281, 48, 100);
COMMIT;

# Synchronize for "sys_obj_id" Type: Source to target

INSERT INTO `sys_obj_id` (`id`) 
VALUES (1286);
COMMIT;

# Synchronize for "sys_obj_id_named" Type: Source to target

INSERT INTO `sys_obj_id_named` (`obj_id`, `name`) 
VALUES (1286, 'access_forum_profile');
COMMIT;

# Synchronize for "user_user" Type: Source to target

UPDATE `user_user` 
SET `obj_id`=12, `login`='guest', `password`='', `created`=NULL, `confirmed`=NULL, `last_login`=1201330990 
WHERE `id`=1;
UPDATE `user_user` 
SET `obj_id`=13, `login`='admin', `password`='098f6bcd4621d373cade4e832627b4f6', `created`=NULL, `confirmed`=NULL, `last_login`=1201331781 
WHERE `id`=2;
COMMIT;