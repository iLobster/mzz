<?php
//menu actions config

return array(
    'view' => array(
        'controller' => 'view',
        'main' => 'deny'
    ),
    'createRoot' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/blank-add',
        'title' => 'Создать пункт',
        'main' => 'active.blank.tpl',
    ),
    'editmenu' => array(
        'controller' => 'savemenu',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/page-edit',
        'title' => 'Редактировать',
    ),
    'deletemenu' => array(
        'controller' => 'deletemenu',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/page-del',
        'title' => 'Удалить',
        'confirm' => 'Вы уверены?',
    ),
    'move' => array(
        'controller' => 'move',
        'role' => array('moderator'),
        'main' => 'active.blank.tpl',
    ),
);
?>