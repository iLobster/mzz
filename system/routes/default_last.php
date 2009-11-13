<?php

$router->addRoute('withAnyParam', new requestRoute(':module/:name/:action', array('name' => 'root', 'action' => 'view'), array('name' => '.+?')));
$router->addRoute('default2', new requestRoute(':module/:action'));
$router->addRoute('adminDefault', new requestRoute('admin', array('module' => 'admin', 'action' => 'admin')));

$router->addRoute('admin', new requestRoute('admin/:module_name/:params/:action_name', array('module' => 'admin', 'action' => 'admin', 'params' => ''), array('params' => '.*?')));

$router->addRoute('adminSimpleActions', new requestRoute('admin/:action', array('module' => 'admin')));
$router->addRoute('adminModule', new requestRoute('admin/:name/:action', array('module' => 'admin'), array('action' => '(?:addClass|editModule|deleteModule)')));
$router->addRoute('adminModuleEntity', new requestRoute('admin/:module_name/:class_name/:action', array('module' => 'admin'), array('action' => '(?:listActions|map|editClass|deleteClass|addAction|editAction|deleteAction)')));

$router->addRoute('accessEditRoles', new requestRoute('access/:module_name/:action', array('module' => 'access', 'action' => 'list'), array('action' => '(?:list|add)')));
$router->addRoute('accessEditModuleRoles', new requestRoute('access/:module_name/:group_id/:action', array('module' => 'access'), array('action' => '(?:edit|delete)')));

?>