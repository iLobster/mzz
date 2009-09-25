<?php
//newsFolder actions config

return array(
    'list' => array(
        'controller' => 'list'
    ),
    'create' => array(
        'controller' => 'save',
        'jip' => true,
        'icon' => 'sprite:mzz-icon/page/add',
        'lang' => true,
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'
    ),
    'createFolder' => array(
        'controller' => 'saveFolder',
        'jip' => true,
        'icon' => 'sprite:mzz-icon/folder/add',
        'lang' => true,
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'
    ),
    'editFolder' => array(
        'controller' => 'saveFolder',
        'jip' => true,
        'icon' => 'sprite:mzz-icon/folder/add',
        'lang' => true,
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'
    ),
    'moveFolder' => array(
        'controller' => 'moveFolder',
        'jip' => true,
        'icon' => 'sprite:mzz-icon/folder/move',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'
    ),
    'deleteFolder' => array(
        'controller' => 'deleteFolder',
        'jip' => true,
        'icon' => 'sprite:mzz-icon/folder/del',
        'confirm' => '_ news/confirm_delete_folder',
        'main' => 'active.blank.tpl',
        'route_name' => 'withAnyParam',
        'route.name' => '->getTreePath'
    )
);
?>