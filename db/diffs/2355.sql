SET NAMES `utf8`;

# Synchronize for "sys_actions" Type: Source to target

UPDATE `sys_actions` 
SET `name`='addCategory' 
WHERE `id`=72;
UPDATE `sys_actions` 
SET `name`='deleteCategory' 
WHERE `id`=73;
COMMIT;