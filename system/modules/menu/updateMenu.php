<?php
error_reporting(E_ALL);

require_once './configs/config.php';
require_once systemConfig::$pathToSystem . '/index.php';

$db = new PDO(systemConfig::$db['default']['dsn'], systemConfig::$db['default']['user'], systemConfig::$db['default']['password']);
$db->query('SET NAMES ' .  systemConfig::$db['default']['charset']);

$properties = array(
1 => 'url',
2 => 'url',
3 => 'section',
4 => 'action'
);
$items = $db->query('SELECT `mi`.`id`, `mi`.`title`, `char`, `property_type`, `property_id` FROM `menu_menuItem` `mi` LEFT JOIN `menu_menuItem_data` `md` ON `md`.`id` = `mi`.`id` INNER JOIN `menu_menuItem_types_props` `mtp` ON `mtp`.`id` = `md`.`property_type`');
if (!$items) {
    exit('Меню уже обновлено видимо.');
}
$params = array();
while ($row = $items->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($params[$row['id']])) {
        $params[$row['id']] = array(
        'name' => $row['title'],
        'regex' => '',
        'route' => 'default2'
        );
    }
    $params[$row['id']][$properties[$row['property_id']]] = $row['char'];
}
foreach ($params as $param) {
    echo '<strong>' . $param['name'] . "</strong> params will be updated: <br /> old &nbsp;<span style=\"color: green;\"> [";
    if (array_key_exists('action', $param)) {
        echo "section = '" . $param['section'] . "', action = '" . $param['action'] . "', url = '" . $param['url'];
    } else {
        echo "url = '" . $param['url'];
    }
    echo "']</span> <br /> new";

    if (array_key_exists('action', $param) && empty($param['action'])) {
        $param['action'] = substr_count($param['url'], '/') > 1 ? substr($param['url'], strrpos($param['url'], '/') + 1) : 'list';
    }

    echo " [url = '" . $param['url'] . "']</span><hr />";
}

echo "<strong>There are your sql queries:</strong><br><textarea rows=15 cols=120>";
echo <<<SQL
DROP TABLE `menu_menuItem_data`;
DROP TABLE `menu_menuItem_properties`;
DROP TABLE `menu_menuItem_properties_types`;
DROP TABLE `menu_menuItem_types`;
DROP TABLE `menu_menuItem_types_props`;

ALTER TABLE `menu_menuItem` ADD `args` TEXT NOT NULL AFTER `order`;

SQL;

foreach ($params as $id => $param) {
    $args = array('url' => $param['url']);
    echo "UPDATE `mzz`.`menu_menuItem` SET `type_id` = 1, `args` = " . $db->quote(serialize($args)) . " WHERE `menu_menuItem`.`id` = " . $id . ";\r\n";
}

echo "\r\n</textarea>";
?>