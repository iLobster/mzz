<?php

$db = new PDO('mysql:host=localhost;port=3306;dbname=knpz', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->query("SET NAMES 'cp1251'");

$module_name = 'questionnaire';

$qry = 'SELECT * FROM `sys_modules` WHERE `name` = ' . $db->quote($module_name);
$stmt = $db->query($qry);
$module = $stmt->fetch();

$qry = 'SELECT * FROM `sys_classes` WHERE `module_id` = ' . $module['id'];
$stmt = $db->query($qry);

$classes = $stmt->fetchAll();

$qry = 'SELECT `a`.`name`, `c`.`name` AS `class_name` FROM `sys_classes` `c` INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `c`.`id` INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id` WHERE `c`.`module_id` = ' . $module['id'];
$stmt = $db->query($qry);

$actions = array();

while ($row = $stmt->fetch()) {
    $actions[$row['class_name']][] = $row['name'];
}

echo 'INSERT INTO `sys_modules` (`name`, `title`, `icon`, `order`) VALUES (' . $db->quote($module['name']) . ', ' . $db->quote($module['title']) . ', ' . $db->quote($module['icon']) . ', ' . $db->quote($module['order']) . ');<br />';
echo 'SET @MODULE_ID = LAST_INSERT_ID();<br />';

foreach ($classes as $class) {
    echo 'INSERT INTO `sys_classes` (`name`, `module_id`) VALUES (' . $db->quote($class['name']) . ', @MODULE_ID);<br />';
    echo 'SET @LAST_CLASS_ID = (SELECT `id` FROM `sys_classes` WHERE `name` = ' . $db->quote($class['name']) . ');<br />';
    foreach ($actions[$class['name']] as $action) {
        echo 'INSERT IGNORE INTO `sys_actions` (`name`) VALUES (' . $db->quote($action) . ');<br />';
        echo 'SET @LAST_ACTION_ID = (SELECT `id` FROM `sys_actions` WHERE `name` = ' . $db->quote($action) . ');<br />';
        echo 'INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES (@LAST_CLASS_ID, @LAST_ACTION_ID);<br />';
    }
}

?>