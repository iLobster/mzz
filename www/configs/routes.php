<?php

$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list', 'name' => 'root')));
$router->addRoute('newsFolder', new requestRoute('news/:name/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('name' => '.+?', 'action' => '(?:list|createItem|createFolder|editFolder|deleteFolder)')));
$router->addRoute('pageNamed', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view')));
$router->addRoute('pageActions', new requestRoute('page/:action', array('section' => 'page', 'action' => 'list'), array('action' => '(?:list|create|delete)')));
$router->addRoute('withId', new requestRoute(':section/:id/:action', array('action' => 'view'), array('id' => '\d+')));
$router->addRoute('newsActions', new requestRoute('news/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('action' => '(?:list|createItem|delete|createFolder)')));
$router->addRoute('userActions', new requestRoute('user/:action', array('section' => 'user'), array('action' => '(?:exit|list|create|groupsList|groupCreate)')));
//$router->addRoute('aclActions', new requestRoute('acl/:action', array('section' => 'acl')));

?>