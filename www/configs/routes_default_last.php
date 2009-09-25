<?php

$router->addRoute('withAnyParam', new requestRoute(':module/:name/:action', array('name' => 'root', 'action' => 'view'), array('name' => '.+?')));
$router->addRoute('default2', new requestRoute(':module/:action'));
$router->addRoute('adminDefault', new requestRoute('admin', array('module' => 'admin', 'action' => 'admin')));

?>