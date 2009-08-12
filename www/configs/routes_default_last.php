<?php

$router->addRoute('withAnyParam', new requestRoute(':section/:name/:action', array('name' => 'root', 'action' => 'view'), array('name' => '.+?')));
$router->addRoute('default2', new requestRoute(':section/:action'));
$router->addRoute('adminDefault', new requestRoute('admin', array('section' => 'admin', 'action' => 'admin')));

?>