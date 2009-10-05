<?php

return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => true,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'lang' => true,
        'main' => 'active.blank.tpl'),
    'move' => array(
        'controller' => 'move',
        'jip' => true,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/move'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => true,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/del',
        'confirm' => '_ news/confirm_delete',
        'main' => 'active.blank.tpl'),
    'admin' => array(
        'role' => array('moderator'),
        'controller' => 'admin',
        'title' => '_ admin',
        'admin' => true));

?>