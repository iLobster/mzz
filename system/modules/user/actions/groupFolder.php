<?php
//groupFolder actions config

return array(
    'groupCreate' => array(
        'controller' => 'groupSave',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/group/add',
        'title' => 'Создать группу',
        'main' => 'active.blank.tpl',
        'alias' => 'groupsList',
    ),
    'groupsList' => array(
        'controller' => 'groupsList',
        'admin' => '1',
        'title' => '_ user/groups',
        'main' => 'active.admin.tpl',
    ),
);
?>