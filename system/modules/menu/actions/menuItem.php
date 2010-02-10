<?php
//menuItem actions config

return array(
    'create' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/blank-add',
        'title' => 'Создать подпункт',
        'main' => 'active.blank.tpl',
    ),
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/page-edit',
        'title' => 'Редактировать пункт',
        'lang' => '1',
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/page-del',
        'title' => 'Удалить пункт',
        'confirm' => 'Вы уверены, что хотите удалить элемент меню и все его подпункты?',
    ),
);
?>