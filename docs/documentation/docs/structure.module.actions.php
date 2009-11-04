<p>В директории <code>actions</code> расположены файлы, определяющие набор возможных действий с каждой из сущностей модуля. Для модуля <code>news</code> это будут файлы <code>news.php</code> и <code>newsFolder.php</code>:</p>
<p>news.php:</p>
<<code php>>
<?php

return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => true,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'lang' => true,
        'main' => 'active.blank.tpl'),
    'move' => array(
        'controller' => 'move',
        'jip' => true,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/move'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => true,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/del',
        'confirm' => '_ news/confirm_delete',
        'main' => 'active.blank.tpl'),
    'admin' => array(
        'role' => array('moderator'),
        'controller' => 'admin',
        'title' => '_ admin',
        'admin' => true));

?>
<</code>>
<p>В этом файле определены 5 действий: <code>view</code>, <code>edit</code>, <code>move</code>, <code>delete</code> и <code>admin</code>. Назначение этих действий легко определяется по их названию.</p>
<p>todo: таблица со всеми возможными параметрами</p>