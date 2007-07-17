<p>������� ��� �������� <code>message</code> ����� ��������� ��������� ����:</p>
<ul>
    <li><code>id</code> - ��������� ���� �������, ������������� ���������</li>
    <li><code>title</code> - ��������� ���������</li>
    <li><code>text</code> - ����� ���������</li>
    <li><code>sender</code> - id �����������</li>
    <li><code>recipient</code> - id ����������</li>
    <li><code>time</code> - timestamp ������� ����������� ���������</li>
    <li><code>watched</code> - ����, ������������, ����������� ��������� ��� ���</li>
    <li><code>category_id</code> - ������������� ���������, � ������� ��������� ���������</li>
    <li><code>obj_id</code> - ���������� ������������� �������, ��������� ���� ��� <a href="structure.acl.html#structure.acl">ACL</a></li>
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
<</code>>
<p>��� �������� <code>messageCategory</code> ������� ����� ��������� �����:</p>
<ul>
    <li><code>id</code> - ��������� ���� �������, ������������� ���������</li>
    <li><code>title</code> - �������� ���������, ����� ������������ ��� �������������</li>
    <li><code>name</code> - ��� ���������, ����� ���������� ����� ���� � �������������� ��� ��������� �����</li>
    <li><code>obj_id</code> - ���������� ������������� �������, ��������� ���� ��� <a href="structure.acl.html#structure.acl">ACL</a></li>
</ul>
<<code sql>>
CREATE TABLE `message_messageCategory` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` char(255) default NULL,
  `name` char(20) default NULL,
  `obj_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
<</code>>
<p>������ ������� ����� � devToolbar, � ��� ������ �� ��������� ������� �������� map-�����. � ���������� <code>message.map.ini</code> � <code>messageCategory.map.ini</code> ����� ������������� �� ������ ������ � ��. ���� �� ��������� �����, �� ����� ����� ��������� ���:</p>
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
<p>������ ������ ��������� � ����������, � ������������� - � ��������� ������������ �������, � ����� ����������� ������ ��� category_id � ����� �������:</p>
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