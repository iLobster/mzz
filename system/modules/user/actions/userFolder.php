<?php
//userFolder actions config

return array(
    'create' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/user/add',
        'title' => 'Добавить пользователя',
        'main' => 'active.blank.tpl'
    ),
    'register' => array(
        'controller' => 'register',
        'title' => 'Регистрация',
    ),
    'login' => array(
        'controller' => 'login'
    ),
    'exit' => array(
        'controller' => 'exit',
        'main' => 'active.blank.tpl',
    ),
    'list' => array(
        'controller' => 'admin',
        'title' => '_ user/admin',
        'role' => array('moderator'),
        'admin' => '1',
        'main' => 'active.admin.tpl',
    ),
);
?>