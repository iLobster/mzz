<?php
//file actions config

return array(
    'admin' => array(
        'controller' => 'admin',
        'icon' => 'fm.gif',
        'role' => array('moderator'),
        'title' => 'Файловый менеджер',
        'admin' => true
    ),
    'get' => array(
        'controller' => 'get',
        'jip' => '0',
        'icon' => 'sprite:mzz-icon/page/add',
        'title' => 'Скачать',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
    'edit' => array(
        'controller' => 'edit',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page/edit',
        'title' => 'Редактирование',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
    'move' => array(
        'controller' => 'move',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page/move',
        'title' => 'Переместить',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page/del',
        'title' => 'Удалить',
        'confirm' => 'Вы хотите удалить этот файл?',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getFullPath',
    ),
);
?>