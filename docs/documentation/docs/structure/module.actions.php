<p>В директории <code>actions</code> расположены файлы, определяющие набор возможных действий с каждой из сущностей модуля. Для модуля <code>news</code> это будут файлы <code>news.php</code> и <code>newsFolder.php</code>:</p>
<p>news.php:</p>
<<code php>>
<?php
return array(
    'view' => array(
        'controller' => 'view'),
    'edit' => array(
        'controller' => 'save',
        'jip' => 1,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'lang' => true,
        'main' => 'active.blank.tpl'),
    'move' => array(
        'controller' => 'move',
        'jip' => 1,
        'role' => array('moderator'),
        'icon' => 'sprite:mzz-icon/page-text/move'),
    'delete' => array(
        'controller' => 'delete',
        'jip' => 1,
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

<p>Рассмотрим пример простейшего actions-конфига:</p>
<<code php>>
<?php
return array(
    'view' => array(
        'controller' => 'view'
    )
}
?>
<</code>>
<p>Как видно из примера, обязательный параметр у действия только один — <code>controller</code>. Представляет собой имя контроллера, который будет обслуживать данное действие.</p>
<p>Также, доступны следующие необязательные параметры для действий:</p>
<table class="listTable" style="width: 85%;">
    <thead>
        <tr>
            <th style="width: 120px;">Имя переменной</th>
            <th>Описание</th>
            <th style="width: 200px;">Принимаемые значения</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>main</td>
            <td>
                <p>Main-шаблон для действия (todo: где описать для чего это? в процессе запуска приложения или прям тут?). Может принимать следующие значения:</p>
                <ul>
                    <li><strong>active.main.tpl</strong> — результат работы действия будет включено в main.tpl шаблон</li>
                    <li><strong>active.blank.tpl</strong> — результат работы действия будет выведено на экран без main.tpl шаблона</li>
                    <li><strong>deny</strong> — данный экшн запрещен к вызову через адресную строку браузера.</li>
                </ul>
                <p>Если данный параметр не задан, то по-умолчанию будет использоваться <strong>active.main.tpl</strong> шаблон</p>
            </td>
            <td>string</td>
        </tr>
        <tr>
            <td>jip</td>
            <td>Является ли действие действием JIP (todo: ссылка на описание JIP)</td>
            <td>int</td>
        </tr>
        <tr>
            <td>icon</td>
            <td>Иконка действия (используется для JIP) (todo: ссылка на описание)</td>
            <td>string</td>
        </tr>
        <tr>
            <td>confirm</td>
            <td>Сообщение перед выполнением действия (используется для JIP)</td>
            <td>string</td>
        </tr>
        <tr>
            <td>title</td>
            <td>Заголовок действия (используется для JIP). Если строка начинается со знака "_", то значение возмется из i18n</td>
            <td>string</td>
        </tr>
        <tr>
            <td>admin</td>
            <td>Является ли действие действием admin части фреймворка</td>
            <td>boolean</td>
        </tr>
        <tr>
            <td>role</td>
            <td>
                Массив или строка ролей модуля, которым будем разрешен доступ к этому действию.
                Если данный параметр не указан, то доступ к действию разрешен всем.
                (todo: ссылка на описание механизма ролей)
            </td>
            <td>array|string</td>
        </tr>
    </tbody>
</table>