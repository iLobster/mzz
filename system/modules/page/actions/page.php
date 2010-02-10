<?php

return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:sys/page-edit',
        'lang' => '1',
        'role' => array('moderator'),
        'main' => 'active.blank.tpl',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),
    'move' => array(
        'controller' => 'move',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/page-move',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'icon' => 'sprite:sys/page-del',
        'role' => array('moderator'),
        'confirm' => 'Вы хотите удалить эту страницу?',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),);

?>