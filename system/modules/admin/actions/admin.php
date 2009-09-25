<?php
//admin actions config

return array(
    'admin' => array(
        'controller' => 'admin',
        'main' => 'active.admin.tpl',
        'admin' => '1',
        '403handle' => 'manual',
    ),
    'access' => array(
        'controller' => 'access',
        'main' => 'active.admin.tpl',
        '403handle' => 'manual',
    ),
    'devToolbar' => array(
        'controller' => 'devToolbar',
        'main' => 'active.admin.tpl',
        'admin' => '1',
        'title' => 'devToolbar',
    ),
    'addClass' => array(
        'controller' => 'saveClass',
        'alias' => 'devToolbar',
        'jip' => '1',
        'main' => 'active.blank.tpl',
    ),
    'editClass' => array(
        'controller' => 'saveClass',
        'jip' => '1',
        'alias' => 'devToolbar',
        'main' => 'active.blank.tpl',
    ),
    'deleteClass' => array(
        'controller' => 'deleteClass',
        'alias' => 'devToolbar',
        'jip' => '1',
        'confirm' => 'Вы действительно хотите удалить этот класс?',
        'main' => 'active.blank.tpl',
    ),
    'addModule' => array(
        'controller' => 'saveModule',
        'alias' => 'devToolbar',
        'jip' => '1',
        'main' => 'active.blank.tpl',
    ),
    'editModule' => array(
        'controller' => 'saveModule',
        'jip' => '1',
        'alias' => 'devToolbar',
        'main' => 'active.blank.tpl',
    ),
    'deleteModule' => array(
        'controller' => 'deleteModule',
        'alias' => 'devToolbar',
        'jip' => '1',
        'confirm' => 'Вы действительно хотите удалить этот модуль?',
        'main' => 'active.blank.tpl',
    ),
    'listActions' => array(
        'controller' => 'listActions',
        'alias' => 'devToolbar',
        'jip' => '1',
        'main' => 'active.blank.tpl',
    ),
    'addAction' => array(
        'controller' => 'saveAction',
        'alias' => 'devToolbar',
        'jip' => '1',
        'main' => 'active.blank.tpl',
    ),
    'editAction' => array(
        'controller' => 'saveAction',
        'jip' => '1',
        'alias' => 'devToolbar',
        'main' => 'active.blank.tpl',
    ),
    'deleteAction' => array(
        'controller' => 'deleteAction',
        'alias' => 'devToolbar',
        'jip' => '1',
        'confirm' => 'Вы действительно хотите удалить это действие?',
        'main' => 'active.blank.tpl',
    ),
    'addObjToRegistry' => array(
        'controller' => 'addObjToRegistry',
        'alias' => 'devToolbar',
        'jip' => '1',
        'main' => 'active.blank.tpl',
    ),
    'editSections' => array(
        'controller' => 'editSections',
        'alias' => 'devToolbar',
        'jip' => '1',
        'main' => 'active.blank.tpl',
    ),
    'map' => array(
        'controller' => 'map',
        'jip' => '1',
        'alias' => 'devToolbar',
        'main' => 'active.blank.tpl',
        'confirm' => '_ admin/refresh_map',
    ),
    'translate' => array(
        'controller' => 'translate',
        'jip' => '1',
        'alias' => 'devToolbar',
        'main' => 'active.blank.tpl',
    ),
    'menu' => array(
        'controller' => 'menu',
        '403handle' => 'none',
        'main' => 'deny',
    ),
    'dashboard' => array(
        '403handle' => 'none',
        'controller' => 'dashboard',
        'dashboard' => true,
        'main' => 'deny',
    ),
);
?>