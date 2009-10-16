<?php
//configOption actions config

return array(
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/wrench/edit',
        'title' => 'Редактировать'
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/wrench/del',
        'title' => 'Удалить',
        'confirm' => 'Вы уверены?'
    ),
);
?>