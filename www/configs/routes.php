<?php

$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list')));
$router->addRoute('withName', new requestRoute(':section/:name/:action', array('action' => 'view')));
$router->addRoute('withId', new requestRoute(':section/:id/:action', array('action' => 'view'), array('id' => '\d+')));
$router->addRoute('pageName', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view')));
$router->addRoute('withoutParams', new requestRoute(':section/:action', array('action' => 'list')));

?>
