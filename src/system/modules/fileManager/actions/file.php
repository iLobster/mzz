<?php
//file actions config

return array(
    'admin' => array(
        'controller' => 'admin',
        'icon' => 'sprite:sys/folder',
        'role' => array('moderator'),
        'title' => 'Файловый менеджер',
        'admin' => true
    ),
    'get' => array(
        'controller' => 'get',
        'jip' => '0',
        'icon' => 'sprite:sys/blank-add',
        'title' => 'Скачать',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
    'edit' => array(
        'controller' => 'edit',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/blank-edit',
        'title' => 'Редактирование',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
    'move' => array(
        'controller' => 'move',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/blank-move',
        'title' => 'Переместить',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/blank-del',
        'title' => 'Удалить',
        'confirm' => 'Вы хотите удалить этот файл?',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
);
?>