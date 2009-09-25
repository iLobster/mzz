<?php
//user actions config

return array(
    'login' => array(
        'controller' => 'login',
        '403handle' => 'none',
    ),
    'exit' => array(
        'controller' => 'exit',
        '403handle' => 'none',
        'main' => 'active.blank.tpl',
    ),
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/user/edit',
        'title' => 'Редактировать',
    ),
    'memberOf' => array(
        'controller' => 'memberOf',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/group',
        'title' => 'Группы',
        'main' => 'active.blank.tpl',
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/user/del',
        'title' => 'Удалить',
        'confirm' => 'Вы хотите удалить этого пользователя?',
        'main' => 'active.blank.tpl',
    ),
    'loginForm' => array(
        'controller' => 'loginForm',
        'title' => 'loginForm',
        'alias' => 'login',
        '403handle' => 'none',
        'main' => 'active.blank.tpl',
    ),
);
?>