<?php
//menu actions config

return array(
    'view' => array(
        'controller' => 'view',
        '403handle' => 'none',
    ),
    'createRoot' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page/add',
        'title' => 'Создать пункт',
        'main' => 'active.blank.tpl',
    ),
    'editmenu' => array(
        'controller' => 'savemenu',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page/edit',
        'title' => 'Редактировать',
    ),
    'deletemenu' => array(
        'controller' => 'deletemenu',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page/del',
        'title' => 'Удалить',
        'confirm' => 'Вы уверены?',
    ),
    'move' => array(
        'controller' => 'move',
        'main' => 'active.blank.tpl',
    ),
);
?>