<?php
//configOption actions config

return array(
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/wrench/edit',
        'title' => 'Редактировать',
        '403handle' => 'none',
    ),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/wrench/del',
        'title' => 'Удалить',
        'confirm' => 'Вы уверены?',
        '403handle' => 'none',
    ),
);
?>