<?php
//$router->enableDebug();
$router->addRoute('withAnyParam', new requestRoute(':section/:name/:action', array('name' => 'root', 'action' => 'view'), array('name' => '.+?')));
$router->addRoute('default2', new requestRoute(':section/:action'));
$router->addRoute('adminDefault', new requestRoute('admin', array('section' => 'admin', 'action' => 'admin')));

//$router->addRoute('cfgEdit', new requestRoute('config/:section_name/:module_name/:action', array('section' => 'config'), array('action' => 'editCfg')));

$router->addRoute('captcha', new requestRoute('captcha', array('section' => 'captcha', 'action' => 'view')));

$router->addRoute('fmFolder', new requestRoute('fileManager/:name/:action', array('section' => 'fileManager', 'name' => 'root', 'action' => 'get'), array('name' => '.+?', 'action' => '(?:list|upload|edit|delete|get|editFolder|createFolder|deleteFolder|move|moveFolder)')));
$router->addRoute('fmFolderRoot', new requestRoute('fileManager/:action', array('section' => 'fileManager', 'name' => 'root', 'action' => 'list'), array('name' => '.+?', 'action' => '(?:list|upload)')));

$router->addRoute('pageActions', new requestRoute('page/:name/:action', array('section' => 'page', 'action' => 'view'), array('name' => '.+?', 'action' => '(?:view|edit|list|create|delete|createFolder|editFolder|moveFolder|deleteFolder|move)')));
$router->addRoute('pageDefault', new requestRoute('page', array('section' => 'page', 'action' => 'view', 'name' => 'main')));

$router->addRoute('catalogueFolder', new requestRoute('catalogue/:name/:action', array('section' => 'catalogue', 'name' => 'root', 'action' => 'list'), array('name' => '.+?', 'action' => '(?:list|create|createFolder|editFolder|deleteFolder|moveFolder|massAction)')));
$router->addRoute('catalogueActions', new requestRoute('catalogue/:action', array('section' => 'catalogue'), array('action' => '(?:addType|addProperty|delete|move|adminTypes|adminProperties)')));

$router->addRoute('newsFolder', new requestRoute('news/:name/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('name' => '.*?', 'action' => '(?:list|create|createFolder|editFolder|deleteFolder|moveFolder)')));
//$router->addRoute('newsActions', new requestRoute('news/:action', array('section' => 'news', 'name' => 'root', 'action' => 'list'), array('action' => '(?:list|create|delete|createFolder)')));
//$router->addRoute('userActions', new requestRoute('user/:action', array('section' => 'user'), array('action' => '(?:exit|list|login|create|groupsList|groupCreate)')));

//$router->addRoute('galleryAlbumActions', new requestRoute('gallery/:name/:action', array('section' => 'gallery'), array('action' => '(?:createAlbum)')));
$router->addRoute('galleryAlbum', new requestRoute('gallery/:name/:album/:action', array('section' => 'gallery')));
$router->addRoute('galleryPicAction', new requestRoute('gallery/:name/:album/:id/:action', array('section' => 'gallery')));


$router->addRoute('aclActions', new requestRoute('access/:id/:user_id/:action', array('section' => 'access'), array('id' => '\d+', 'user_id' => '\d+', 'action' => '(?:editUser|editGroup|deleteGroup|deleteUser)')));
$router->addRoute('aclDefaults', new requestRoute('access/:section_name/:class_name/:action', array('section' => 'access'), array('action' => 'editDefault')));
$router->addRoute('aclDefaultsEdit', new requestRoute('access/:section_name/:class_name/:id/:action', array('section' => 'access'), array('action' => '(?:editGroupDefault|deleteGroupDefault|editUserDefault|deleteUserDefault)', 'id' => '\d+')));
$router->addRoute('aclDefaultsAdd', new requestRoute('access/:section_name/:class_name/:action', array('section' => 'access'), array('action' => '(?:addGroupDefault|addUserDefault|editOwner)')));
$router->addRoute('aclDefaultAction', new requestRoute('access/:id', array('section' => 'access', 'action' => 'edit'), array('id' => '\d+')));

$router->addRoute('admin', new requestRoute('admin/:module_name/:params/:action', array('section' => 'admin', 'action' => 'admin', 'params' => 'root'), array('params' => '.*?', 'action' => '(?:admin|editConfig)')));
$router->addRoute('adminTranslate', new requestRoute('admin/:module_name/:language/translate', array('section' => 'admin', 'action' => 'translate')));
$router->addRoute('adminMap', new requestRoute('admin/:class/:field/:action', array('section' => 'admin'), array('action' => '(?:editmap|deletemap)')));
$router->addRoute('adminCfgEdit', new requestRoute('admin/:id/:name/:action', array('section' => 'admin', 'action' => 'editCfg'), array('id' => '\d+')));
$router->addRoute('adminAction', new requestRoute('admin/:id/:action_name/:action', array('section' => 'admin'), array('id' => '\d+', 'action' => '(?:editAction|deleteAction)')));

$router->addRoute('menuMoveAction', new requestRoute('menu/:id/:target/move', array('section' => 'menu', 'action' => 'move'), array('id' => '\d+', 'target' => '(?:up|down|\d+)')));

$router->addRoute('withId', new requestRoute(':section/:id/:action', array('action' => 'view'), array('id' => '\d+')));
$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list', 'name' => 'root')));

$router->addRoute('tags', new requestRoute(':section/tag/:tag', array('action' => 'searchByTag'), array('tag' => '.+?')));

?>