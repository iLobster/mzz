<p>Таблица для сущности <code>message</code> будет содержать следующие поля:</p>
<ul>
    <li><code>id</code> - первичный ключ таблицы, идентификатор сообщения</li>
    <li><code>title</code> - заголовок сообщения</li>
    <li><code>text</code> - текст сообщения</li>
    <li><code>sender</code> - id отправителя</li>
    <li><code>recipient</code> - id получателя</li>
    <li><code>time</code> - timestamp времени отправления сообщения</li>
    <li><code>watched</code> - флаг, определяющий, просмотрено сообщение или нет</li>
    <li><code>category_id</code> - идентификатор категории, к которой относится сообщение</li>
    <li><code>obj_id</code> - уникальный идентификатор объекта, служебное поле для <a href="structure.acl.html#structure.acl">ACL</a></li>
</ul>
<<code sql>>
CREATE TABLE `message_message` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `text` text,
  `sender` int(11) default NULL,
  `recipient` int(11) default NULL,
  `time` int(11) default NULL,
  `watched` tinyint(4) default NULL,
  `category_id` int(11) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
<</code>>
<p>Для сущности <code>messageCategory</code> таблица будет несколько проще:</p>
<ul>
    <li><code>id</code> - первичный ключ таблицы, идентификатор сообщения</li>
    <li><code>title</code> - название категории, будет отображаться для пользователей</li>
    <li><code>name</code> - имя категории, будет составлять часть урла и использоваться для служебных целей</li>
    <li><code>obj_id</code> - уникальный идентификатор объекта, служебное поле для <a href="structure.acl.html#structure.acl">ACL</a></li>
</ul>
<<code sql>>
CREATE TABLE `message_messageCategory` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  `name` char(20) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
<</code>>
<p>Теперь вернёмся снова в devToolbar, и для каждой из сущностей откроем редактор map-файла. В результате <code>message.map.ini</code> и <code>messageCategory.map.ini</code> будут сгенерированы на основе таблиц в БД. Если всё выполнено верно, то файлы будут выглядеть так:</p>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"

[title]
accessor = "getTitle"
mutator = "setTitle"

[text]
accessor = "getText"
mutator = "setText"

[sender]
accessor = "getSender"
mutator = "setSender"

[recipient]
accessor = "getRecipient"
mutator = "setRecipient"

[time]
accessor = "getTime"
mutator = "setTime"

[watched]
accessor = "getWatched"
mutator = "setWatched"

[category_id]
accessor = "getCategory_id"
mutator = "setCategory_id"
<</code>>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"

[title]
accessor = "getTitle"
mutator = "setTitle"

[name]
accessor = "getName"
mutator = "setName"
<</code>>
<p>Теперь свяжем сообщения с категорями, а пользователей - с сущностью пользователь системы, а также переименуем методы для category_id в более удобные:</p>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"

[title]
accessor = "getTitle"
mutator = "setTitle"

[text]
accessor = "getText"
mutator = "setText"

[sender]
accessor = "getSender"
mutator = "setSender"
owns = "user.id"
module = "user"
section = "user"

[recipient]
accessor = "getRecipient"
mutator = "setRecipient"
owns = "user.id"
module = "user"
section = "user"

[time]
accessor = "getTime"
mutator = "setTime"

[watched]
accessor = "getWatched"
mutator = "setWatched"

[category_id]
accessor = "getCategory"
mutator = "setCategory"
owns = "messageCategory.id"
<</code>>