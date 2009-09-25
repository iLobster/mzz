<?php

$router->addRoute('admin', new requestRoute('admin/:module_name/:params/:action_name', array('module' => 'admin', 'action' => 'admin', 'params' => ''), array('params' => '.*?')));
/*
//$router->addRoute('adminTranslate', new requestRoute('admin/:module_name/:language/translate', array('section' => 'admin', 'action' => 'translate')));
$router->addRoute('adminCfgEdit', new requestRoute('admin/:id/:name/:action', array('section' => 'admin', 'action' => 'editCfg'), array('id' => '\d+')));
$router->addRoute('adminAction', new requestRoute('admin/:id/:action_name/:action', array('section' => 'admin'), array('id' => '\d+', 'action' => '(?:editAction|deleteAction)')));
*/

$router->addRoute('adminSimpleActions', new requestRoute('admin/:action', array('module' => 'admin')));
$router->addRoute('adminModule', new requestRoute('admin/:name/:action', array('module' => 'admin'), array('action' => '(?:addClass|editModule|deleteModule)')));
$router->addRoute('adminModuleEntity', new requestRoute('admin/:module_name/:class_name/:action', array('module' => 'admin')));

$router->addRoute('accessEditRoles', new requestRoute('access/:module_name/:action', array('module' => 'access', 'action' => 'list'), array('action' => '(?:list|add)')));
$router->addRoute('accessEditModuleRoles', new requestRoute('access/:module_name/:group_id/:action', array('module' => 'access'), array('action' => '(?:edit|delete)')));
?>