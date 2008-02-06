SET NAMES `utf8`;

# Synchronize for "catalogue_catalogue_data" Type: Source to target

UPDATE `catalogue_catalogue_data` 
SET `text`=NULL, `char`=NULL, `int`=1, `float`=NULL 
WHERE `id`=17 AND `property_type`=55;
UPDATE `catalogue_catalogue_data` 
SET `text`='N;', `char`=NULL, `int`=NULL, `float`=NULL 
WHERE `id`=17 AND `property_type`=56;
INSERT INTO `catalogue_catalogue_data` (`id`, `property_type`, `text`, `char`, `int`, `float`) 
VALUES (17, 59, 'a:3:{i:0;s:1:\"0\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', NULL, NULL, NULL);
COMMIT;

# Synchronize for "catalogue_catalogue_properties" Type: Source to target

INSERT INTO `catalogue_catalogue_properties` (`id`, `name`, `title`, `type_id`, `args`) 
VALUES (33, 'complect', 'Комплектация', 9, 'a:4:{i:0;s:16:\"Упаковка\";i:1;s:23:\"Шнур питания\";i:2;s:14:\"Розетка\";i:3;s:22:\"Плоскогубцы\";}');
COMMIT;

# Synchronize for "catalogue_catalogue_properties_types" Type: Source to target

INSERT INTO `catalogue_catalogue_properties_types` (`id`, `name`, `title`) 
VALUES (9, 'multiselect', 'Мультиселект');
COMMIT;

# Synchronize for "catalogue_catalogue_types_props" Type: Source to target

UPDATE `catalogue_catalogue_types_props` 
SET `type_id`=11, `property_id`=31, `sort`=0, `isFull`=1, `isShort`=1 
WHERE `id`=55;
UPDATE `catalogue_catalogue_types_props` 
SET `type_id`=11, `property_id`=32, `sort`=0, `isFull`=1, `isShort`=1 
WHERE `id`=56;
INSERT INTO `catalogue_catalogue_types_props` (`id`, `type_id`, `property_id`, `sort`, `isFull`, `isShort`) 
VALUES (59, 11, 33, 0, 1, 1);
COMMIT;

# Synchronize for "user_user" Type: Source to target

UPDATE `user_user` 
SET `obj_id`=13, `login`='admin', `password`='098f6bcd4621d373cade4e832627b4f6', `created`=NULL, `confirmed`=NULL, `last_login`=1201754581 
WHERE `id`=2;
COMMIT;