<?php

return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => 1,
        'role' => array('moderator'),
        'icon' => 'sprite:sys/news-edit',
        'lang' => true,
        'main' => 'active.blank.tpl'),
    'move' => array(
        'controller' => 'move',
        'jip' => 1,
        'role' => array('moderator'),
        'icon' => 'sprite:sys/news-move'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => 1,
        'role' => array('moderator'),
        'icon' => 'sprite:sys/news-del',
        'confirm' => '_ news/confirm_delete',
        'main' => 'active.blank.tpl'),
    'admin' => array(
        'role' => array('moderator'),
        'controller' => 'admin',
        'icon' => 'sprite:sys/news',
        'title' => '_ admin',
        'admin' => true,
        'main' => 'active.admin.tpl'));

?>