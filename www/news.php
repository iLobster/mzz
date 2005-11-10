<?php

// ��� ��������� ����������������� ��������

$_GET['path'] = '/news/';

require_once './config.php';
require_once SYSTEM . 'index.php';

// ��� ����� ��������� ������� (��� �������� ����� � �������� ������� ���� {mod->run ... }

$module = 'news'; // ��� ������ ��������� �������� �� ������� �� {mod->run ... }
$action = 'list';

fileResolver::includer($module, $module . '.factory');
$factory = new newsFactory($action);
$controller = $factory->getController();
$view = $controller->getView();
$result = $view->toString();
echo $result;

?>