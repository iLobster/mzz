<?php
//configFolder actions config

return array(
    'list' => array(
        'controller' => 'list',
        'main' => 'active.blank.tpl',
    ),
    'add' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/wrench/add',
        'title' => 'Добавить параметр'
    ),
    'admin' => array(
        'controller' => 'admin',
        'admin' => '1',
        'role' => array('moderator'),
    ),
    'configure' => array(
        'controller' => 'configure',
        'jip' => '1',
        'role' => array('moderator'),
        'title' => 'Конфигурация модуля'
    ),
);
?>