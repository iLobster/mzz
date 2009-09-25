<?php
//userFolder actions config

return array(
    'create' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/user/add',
        'title' => 'Добавить пользователя',
        'main' => 'active.blank.tpl',
        'alias' => 'list',
    ),
    'register' => array(
        'controller' => 'register',
        'title' => 'Регистрация',
    ),
    'list' => array(
        'controller' => 'admin',
        'title' => '_ user/admin',
        'admin' => '1',
        'main' => 'active.admin.tpl',
    ),
);
?>