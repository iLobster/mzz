<?php
//user actions config

return array(
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/user/edit',
        'title' => 'Редактировать',
    ),
    'memberOf' => array(
        'controller' => 'memberOf',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/group',
        'title' => 'Группы',
        'main' => 'active.blank.tpl',
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/user/del',
        'title' => 'Удалить',
        'confirm' => 'Вы хотите удалить этого пользователя?',
        'main' => 'active.blank.tpl',
    )
);
?>