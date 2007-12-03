<p>Для таблицы с комментариями нам нужны следующие поля:</p>
<ul>
    <li><em>id</em> - первичный ключ таблицы, идентификатор комментария;</li>
    <li><em>obj_id</em> - системный идентификатор объекта в пределах всего приложения (ссылку);</li>
    <li><em>text</em> - текст комментария;</li>
    <li><em>author</em> - автор сообщения, это поле будет ссылаться на таблицу с пользователями;</li>
    <li><em>time</em> - время в формате unix timestamp;</li>
    <li><em>folder_id</em> - идентификатор папки (commentsFolder), в которой находится данный комментарий.</li>
</ul>
<p>Для описанной структуры дамп будет следующим:</p>
<<code sql>>
CREATE TABLE `comments_comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `text` text,
  `author` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  `folder_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
<</code>>
<p>Эту же структуру опишем в файле comments.map.ini:</p>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"
once = true

[text]
accessor = "getText"
mutator = "setText"

[author]
accessor = "getAuthor"
mutator = "setAuthor"

[time]
accessor = "getTime"
mutator = "setTime"

[folder_id]
accessor = "getFolder"
mutator = "setFolder"
<</code>>
<<note>>Как вы можете заметить - в этой схеме мы ещё не учли отношения с таблицами пользователей и <code>commentsFolder</code>. Это будет сделано чуть позднее.<</note>>
<p>Для сущности <code>commentsFolder</code> таблица БД будет следующей:</p>
<ul>
    <li><em>id</em> - первичный ключ таблицы, идентификатор папки с комментариями;</li>
    <li><em>obj_id</em> - системный идентификатор объекта в пределах всего приложения (ссылку);</li>
    <li><em>parent_id</em> - системный идентификатор комментируемого объекта.</li>
</ul>
<<code sql>>
CREATE TABLE `comments_commentsfolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `parent_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
<</code>>
<p>Эту структуру также опишем в файле commentsFolder.map.ini:</p>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"
once = true

[parent_id]
accessor = "getParentId"
mutator = "setParentId"
<</code>>