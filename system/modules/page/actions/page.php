<?php

return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'title' => 'Редактировать',
        'lang' => '1',
        'role' => array('moderator'),
        'main' => 'active.blank.tpl',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page-text/del',
        'title' => 'Удалить',
        'role' => array('moderator'),
        'confirm' => 'Вы хотите удалить эту страницу?',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),
    'move' => array(
        'controller' => 'move',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/move',
        'title' => 'Переместить',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'));

?>