<?php
//comments actions config

return array(
    'edit' => array(
        'controller' => 'edit',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/comment/edit',
        'title' => 'Редактировать',
        'main' => 'active.blank.tpl',
        'role' => array('moderator')
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/comment/del',
        'confirm' => 'Вы хотите удалить этот комментарий?',
        'main' => 'active.blank.tpl',
        'role' => array('moderator')
    ),
);
?>