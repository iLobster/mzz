<?php
//access actions config

return array(
    'list' => array(
        'controller' => 'list',
        'main' => 'active.blank.tpl',
    ),
    'edit' => array(
        'controller' => 'save',
        'main' => 'active.blank.tpl',
    ),
    'add' => array(
        'controller' => 'save',
        'main' => 'active.blank.tpl',
    ),
    'delete' => array(
        'controller' => 'delete',
        'main' => 'active.blank.tpl',
        'confirm' => 'Вы хотите удалить группу из ролей? (не забыть сделать i18n)',
    )
);

?>