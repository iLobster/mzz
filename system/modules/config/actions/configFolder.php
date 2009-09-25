<?php
//configFolder actions config

return array(
    'list' => array(
        'controller' => 'list',
        '403handle' => 'none',
        'main' => 'active.blank.tpl',
    ),
    'add' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/wrench/add',
        'title' => 'Добавить параметр',
        '403handle' => 'none',
    ),
    'admin' => array(
        'controller' => 'admin',
        'admin' => '1',
    ),
    'configure' => array(
        'controller' => 'configure',
        'jip' => '1',
        'title' => 'Конфигурация модуля',
        '403handle' => 'none',
    ),
);
?>