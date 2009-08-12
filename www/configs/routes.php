<?php
//$router->enableDebug();
require_once 'routes_default_last.php';

$router->addRoute('captcha', new requestRoute('captcha', array('section' => 'captcha', 'action' => 'view')));

$router->addRoute('fmFolder', new requestRoute('fileManager/:name/:action', array('section' => 'fileManager', 'name' => 'root', 'action' => 'get'), array('name' => '.+?', 'action' => '(?:list|upload|edit|delete|get|editFolder|createFolder|deleteFolder|move|moveFolder)')));
$router->addRoute('fmFolderRoot', new requestRoute('fileManager/:action', array('section' => 'fileManager', 'name' => 'root', 'action' => 'list'), array('name' => '.+?', 'action' => '(?:list|upload)')));

$router->addRoute('newsFolder', new requestRoute('news/:name/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('name' => '.*?', 'action' => '(?:list|create|createFolder|editFolder|deleteFolder|moveFolder)')));

require_once 'routes_default_middle.php';

$router->addRoute('menuMoveAction', new requestRoute('menu/:id/:target/move', array('section' => 'menu', 'action' => 'move'), array('id' => '\d+', 'target' => '(?:up|down|\d+)')));

require_once 'routes_default_first.php';

$router->addRoute('pageDefault', new requestRoute('page', array('section' => 'page', 'action' => 'view', 'name' => 'main')));
$router->addRoute('pageActions', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view'), array('name' => '.+?', 'action' => '(?:view|edit|list|create|delete|createFolder|editFolder|moveFolder|deleteFolder|move)')));

$router->addRoute('default', new requestRoute('', array('section' => 'page', 'action' => 'view', 'name' => 'main')));

?>