<?php

// тут проверяем работоспособность новостей

$_GET['path'] = '/news/';

require_once './config.php';
require_once SYSTEM . 'index.php';

// как будто загрузчик модулей (код которого будет в активном шаблоне типа {mod->run ... }

$module = 'news'; // эти данные загрузчик получает из шаблона из {mod->run ... }
$action = 'list';

fileResolver::includer($module, $module . '.factory');
$factory = new newsFactory($action);
$controller = $factory->getController();
$view = $controller->getView();
$result = $view->toString();
echo $result;

?>