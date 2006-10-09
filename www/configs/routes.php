<?php


$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list')));
$router->addRoute('newsCategory', new requestRoute('news/:name/:action', array('section' => 'news', 'action' => 'list')));
$router->addRoute('pageNamed', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view')));
$router->addRoute('pageActions', new requestRoute('page/:action', array('section' => 'page', 'action' => 'list'), array('action' => '(?:list|create|delete)')));
$router->addRoute('withId', new requestRoute(':section/:id/:action', array('action' => 'view'), array('id' => '\d+')));
$router->addRoute('newsActions', new requestRoute('news/:action', array('section' => 'news', 'action' => 'list'), array('action' => '(?:list|createItem|delete|createFolder)')));


?>
