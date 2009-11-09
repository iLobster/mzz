<?php

return array(
    'create' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array(
            'moderator'),
        'title' => 'Добавить страницу',
        'icon' => 'sprite:mzz-icon/page/add',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'createFolder' => array(
        'controller' => 'saveFolder',
        'jip' => '1',
        'role' => array(
            'moderator'),
        'icon' => 'sprite:mzz-icon/folder/add',
        'title' => 'Создать папку',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'editFolder' => array(
        'controller' => 'saveFolder',
        'jip' => '1',
        'role' => array(
            'moderator'),
        'icon' => 'sprite:mzz-icon/folder/edit',
        'title' => 'Редактировать',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'deleteFolder' => array(
        'controller' => 'deleteFolder',
        'jip' => '1',
        'role' => array(
            'moderator'),
        'icon' => 'sprite:mzz-icon/folder/del',
        'title' => 'Удалить папку',
        'confirm' => 'Вы хотите удалить эту папку и всё её содержимое?',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'moveFolder' => array(
        'controller' => 'moveFolder',
        'jip' => '1',
        'role' => array(
            'moderator'),
        'icon' => 'sprite:mzz-icon/folder/move',
        'title' => 'Переместить каталог',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'admin' => array(
        'controller' => 'admin',
        'title' => '_ admin',
        'icon' => 'page.gif',
        'admin' => '1',
        'role' => array(
            'moderator'),
        'main' => 'deny',));

?>