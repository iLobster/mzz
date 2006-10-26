<?php

$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list', 'name' => 'root')));
$router->addRoute('newsFolder', new requestRoute('news/:name/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('name' => '.+?', 'action' => '(?:list|createItem|createFolder|editFolder|deleteFolder)')));
$router->addRoute('pageNamed', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view')));
$router->addRoute('pageActions', new requestRoute('page/:action', array('section' => 'page', 'action' => 'list'), array('action' => '(?:list|create|delete)')));
$router->addRoute('withId', new requestRoute(':section/:id/:action', array('action' => 'view'), array('id' => '\d+')));
$router->addRoute('newsActions', new requestRoute('news/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('action' => '(?:list|createItem|delete|createFolder)')));
$router->addRoute('userActions', new requestRoute('user/:action', array('section' => 'user'), array('action' => '(?:exit|list|create|groupsList|groupCreate)')));
$router->addRoute('aclActions', new requestRoute('access/:id/:user_id/:action', array('section' => 'access'), array('id' => '\d+', 'user_id' => '\d+', 'action' => '(?:editUser|editGroup|deleteGroup|deleteUser)')));
$router->addRoute('aclDefaults', new requestRoute('access/:section_name/:class_name/:action', array('section' => 'access'), array('action' => 'editDefault')));
$router->addRoute('aclDefaultsEdit', new requestRoute('access/:section_name/:class_name/:id/:action', array('section' => 'access'), array('action' => '(?:editGroupDefault|editUserDefault)')));
$router->addRoute('aclDefaultAction', new requestRoute('access/:id', array('section' => 'access', 'action' => 'edit'), array('id' => '\d+')));


?>