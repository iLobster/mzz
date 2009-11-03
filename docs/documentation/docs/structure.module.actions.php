<p>В директории <code>actions</code> расположены файлы, определяющие набор возможных действий с каждой из сущностей модуля. Для модуля <code>page</code> это будут файлы <code>page.php</code> и <code>pageFolder.php</code>:</p>
<p>page.php:</p>
<<code php>>
<?php

return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'lang' => '1',
        'role' => array('moderator'),
        'main' => 'active.blank.tpl',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),
    'move' => array(
        'controller' => 'move',
        'jip' => '1',
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/move',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page-text/del',
        'role' => array('moderator'),
        'confirm' => 'Вы хотите удалить эту страницу?',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'),);

?>
<</code>>
<p>В этом файле определены 4 действия: <code>view</code>, <code>edit</code>, <code>move</code>, <code>delete</code>. Назначение этих действий легко определяется по их названию.</p>
<p>todo: таблица со всеми возможными параметрами</p>