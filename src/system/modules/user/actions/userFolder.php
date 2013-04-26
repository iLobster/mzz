<?php
//userFolder actions config

return array(
    'create' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:sys/user-add',
        'title' => 'Добавить пользователя',
        'main' => 'active.blank.tpl',
        'route_name' => 'default2'
    ),
    'register' => array(
        'controller' => 'register',
        'title' => 'Регистрация',
        'main' => 'deny',   //must be commented by programmer if allowed
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
        'icon' => 'sprite:sys/user',
        'admin' => true
    )
);
?>