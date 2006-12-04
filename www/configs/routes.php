<?php

$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list', 'name' => 'root')));
$router->addRoute('default2', new requestRoute(':section/:action'));

$router->addRoute('cfgEdit', new requestRoute('config/:section_name/:module_name/:action', array('section' => 'config'), array('action' => 'editCfg')));

$router->addRoute('newsFolder', new requestRoute('news/:name/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('name' => '.+?', 'action' => '(?:list|createItem|createFolder|editFolder|deleteFolder)')));
$router->addRoute('pageNamed', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view')));
$router->addRoute('pageActions', new requestRoute('page/:action', array('section' => 'page', 'action' => 'list'), array('action' => '(?:list|create|delete)')));
$router->addRoute('pageDefault', new requestRoute('page', array('section' => 'page', 'action' => 'view', 'name' => 'main')));

$router->addRoute('newsActions', new requestRoute('news/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('action' => '(?:list|createItem|delete|createFolder)')));
$router->addRoute('userActions', new requestRoute('user/:action', array('section' => 'user'), array('action' => '(?:exit|list|login|create|groupsList|groupCreate)')));

$router->addRoute('aclActions', new requestRoute('access/:id/:user_id/:action', array('section' => 'access'), array('id' => '\d+', 'user_id' => '\d+', 'action' => '(?:editUser|editGroup|deleteGroup|deleteUser)')));

$router->addRoute('aclDefaults', new requestRoute('access/:section_name/:class_name/:action', array('section' => 'access'), array('action' => 'editDefault')));
$router->addRoute('aclDefaultsEdit', new requestRoute('access/:section_name/:class_name/:id/:action', array('section' => 'access'), array('action' => '(?:editGroupDefault|deleteGroupDefault|editUserDefault|deleteUserDefault)', 'id' => '\d+')));
$router->addRoute('aclDefaultsAdd', new requestRoute('access/:section_name/:class_name/:action', array('section' => 'access'), array('action' => '(?:addGroupDefault|addUserDefault|editOwner)')));

$router->addRoute('aclDefaultAction', new requestRoute('access/:id', array('section' => 'access', 'action' => 'edit'), array('id' => '\d+')));

$router->addRoute('admin', new requestRoute('admin/:section_name/:module_name/:action', array('section' => 'admin'), array('action' => '(?:admin)')));

$router->addRoute('withId', new requestRoute(':section/:id/:action', array('action' => 'view'), array('id' => '\d+')));

?>