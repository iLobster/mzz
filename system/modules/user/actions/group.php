<?php
//group actions config

return array(
    'groupEdit' => array(
        'controller' => 'groupSave',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/group/edit',
        'title' => 'Редактировать',
        'main' => 'active.blank.tpl',
    ),
    'membersList' => array(
        'controller' => 'membersList',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/group',
        'title' => 'Члены группы',
        'main' => 'active.blank.tpl',
    ),
    'addToGroup' => array(
        'controller' => 'addToGroup',
        'role' => array('moderator'),
        'main' => 'active.blank.tpl',
    ),
    'groupDelete' => array(
        'controller' => 'groupDelete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/group/del',
        'title' => 'Удалить',
        'confirm' => 'Вы хотите удалить эту группу?',
        'main' => 'active.blank.tpl',
    ),
);
?>