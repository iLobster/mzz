<?php

$router->addRoute('aclActions', new requestRoute('access/:id/:user_id/:action', array('section' => 'access'), array('id' => '\d+', 'user_id' => '\d+', 'action' => '(?:editUser|editGroup|deleteGroup|deleteUser)')));
$router->addRoute('aclDefaultsEdit', new requestRoute('access/:class_name/:id/:action', array('section' => 'access'), array('action' => '(?:editGroupDefault|deleteGroupDefault|editUserDefault|deleteUserDefault)', 'id' => '\d+')));
$router->addRoute('aclDefaultsAdd', new requestRoute('access/:class_name/:action', array('section' => 'access'), array('action' => '(?:editDefault|addGroupDefault|addUserDefault|editOwner|admin_access)')));
$router->addRoute('aclAccessDefaults', new requestRoute('access/:module_name/:action', array('section' => 'access'), array('action' => '(?:addAccessGroup|addAccessUser|admin_access)')));
$router->addRoute('aclAccessDefaultsEdit', new requestRoute('access/:module_name/:user_id/:action', array('section' => 'access'), array('action' => '(?:editAccessGroup|editAccessUser|deleteAccessUser|deleteAccessGroup)')));
$router->addRoute('aclDefaultAction', new requestRoute('access/:id', array('section' => 'access', 'action' => 'edit'), array('id' => '\d+')));

$router->addRoute('admin', new requestRoute('admin/:module_name/:params/:action_name', array('section' => 'admin', 'action' => 'admin', 'params' => ''), array('params' => '.*?')));
$router->addRoute('adminTranslate', new requestRoute('admin/:module_name/:language/translate', array('section' => 'admin', 'action' => 'translate')));
$router->addRoute('adminCfgEdit', new requestRoute('admin/:id/:name/:action', array('section' => 'admin', 'action' => 'editCfg'), array('id' => '\d+')));
$router->addRoute('adminAction', new requestRoute('admin/:id/:action_name/:action', array('section' => 'admin'), array('id' => '\d+', 'action' => '(?:editAction|deleteAction)')));
$router->addRoute('adminSimpleActions', new requestRoute('admin/:action', array('section' => 'admin')));

?>