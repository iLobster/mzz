<?php

return array(
    'list' => array(
        'controller' => 'list'),
    'create' => array(
        'controller' => 'save',
        'jip' => true,
        'role' => array(
            'moderator'),
        'icon' => 'sprite:sys/news-add',
        'lang' => true,
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'createFolder' => array(
        'controller' => 'saveFolder',
        'jip' => true,
        'role' => array(
            'moderator'),
        'icon' => 'sprite:sys/folder-add',
        'lang' => true,
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'editFolder' => array(
        'controller' => 'saveFolder',
        'jip' => true,
        'role' => array(
            'moderator'),
        'icon' => 'sprite:sys/folder-edit',
        'lang' => true,
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'moveFolder' => array(
        'controller' => 'moveFolder',
        'jip' => true,
        'role' => array(
            'moderator'),
        'icon' => 'sprite:sys/folder-move',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'),
    'deleteFolder' => array(
        'controller' => 'deleteFolder',
        'jip' => true,
        'role' => array(
            'moderator'),
        'icon' => 'sprite:sys/folder-del',
        'confirm' => '_ news/confirm_delete_folder',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'));

?>