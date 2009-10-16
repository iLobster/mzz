<?php
//folder actions config

return array(
    'upload' => array(
        'controller' => 'upload',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page/add',
        'title' => 'Загрузить файл',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath',
    ),
    'createFolder' => array(
        'controller' => 'saveFolder',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/folder/add',
        'title' => 'Создать каталог',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath',
    ),
    'editFolder' => array(
        'controller' => 'saveFolder',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/folder/edit',
        'title' => 'Редактировать каталог',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath',
    ),
    'moveFolder' => array(
        'controller' => 'moveFolder',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/folder/move',
        'title' => 'Переместить каталог',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath',
    ),
    'deleteFolder' => array(
        'controller' => 'deleteFolder',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/folder/del',
        'title' => 'Удалить каталог',
        'confirm' => 'Вы хотите удалить этот каталог?',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath',
    ),
    'list' => array(
        'controller' => 'list',
        'title' => 'list',
        'main' => 'active.blank.tpl',
    ),
);
?>