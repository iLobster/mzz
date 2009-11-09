<?php
//menuFolder actions config

return array(
    'admin' => array(
        'controller' => 'admin',
        'admin' => 1,
        'role' => array('moderator'),
    ),
    'addmenu' => array(
        'controller' => 'savemenu',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/folder/add',
        'title' => 'Добавить меню',
        'route_name' => 'default2',
    ),
);
?>