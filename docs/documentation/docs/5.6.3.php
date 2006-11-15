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
<<code>>
CREATE TABLE `comments_comments` (<br />
  `id` int(11) unsigned NOT NULL auto_increment,<br />
  `obj_id` int(11) unsigned default NULL,<br />
  `text` text,<br />
  `author` int(11) unsigned default NULL,<br />
  `time` int(11) unsigned default NULL,<br />
  `folder_id` int(11) unsigned default NULL,<br />
  PRIMARY KEY  (`id`)<br />
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
<</code>>
<p>Эту же структуру опишем в файле comments.map.ini:</p>
<<code>>
    [id]<br />
    accessor = "getId"<br />
    mutator = "setId"<br />
    once = true<br />
    <br />
    [text]<br />
    accessor = "getText"<br />
    mutator = "setText"<br />
    <br />
    [author]<br />
    accessor = "getAuthor"<br />
    mutator = "setAuthor"<br />
    <br />
    [time]<br />
    accessor = "getTime"<br />
    mutator = "setTime"<br />
    <br />
    [folder_id]<br />
    accessor = "getFolder"<br />
    mutator = "setFolder"<br />
<</code>>
<<note>>Как вы можете заметить - в этой схеме мы ещё не учли отношения с таблицами пользователей и <code>commentsFolder</code>. Это будет сделано чуть позднее.<</note>>
<p>Для сущности <code>commentsFolder</code> таблица БД будет следующей:</p>
<ul>
    <li><em>id</em> - первичный ключ таблицы, идентификатор папки с комментариями;</li>
    <li><em>obj_id</em> - системный идентификатор объекта в пределах всего приложения (ссылку);</li>
    <li><em>parent_id</em> - системный идентификатор комментируемого объекта.</li>
</ul>
<<code>>
CREATE TABLE `comments_commentsfolder` (<br />
  `id` int(11) unsigned NOT NULL auto_increment,<br />
  `obj_id` int(11) unsigned default NULL,<br />
  `parent_id` int(11) unsigned default NULL,<br />
  PRIMARY KEY  (`id`),<br />
  KEY `parent_id` (`parent_id`)<br />
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
<</code>>
<p>Эту структуру также опишем в файле commentsFolder.map.ini:</p>
<<code>>
    [id]<br />
    accessor = "getId"<br />
    mutator = "setId"<br />
    once = true<br />
    <br />
    [parent_id]<br />
    accessor = "getParentId"<br />
    mutator = "setParentId"<br />
<</code>>