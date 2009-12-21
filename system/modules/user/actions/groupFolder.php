<?php
//groupFolder actions config

return array(
    'groupCreate' => array(
        'controller' => 'groupSave',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/group/add',
        'title' => 'Создать группу',
        'main' => 'active.blank.tpl',
        'route_name' => 'default2'
    ),
    'groupsList' => array(
        'controller' => 'groupsList',
        'admin' => true,
        'role' => array('moderator'),
        'title' => '_ user/groups',
    ),
);
?>