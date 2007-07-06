<p>��� ������� � ������������� ��� ����� ��������� ����:</p>
<ul>
    <li><em>id</em> - ��������� ���� �������, ������������� �����������;</li>
    <li><em>obj_id</em> - ��������� ������������� ������� � �������� ����� ���������� (������);</li>
    <li><em>text</em> - ����� �����������;</li>
    <li><em>author</em> - ����� ���������, ��� ���� ����� ��������� �� ������� � ��������������;</li>
    <li><em>time</em> - ����� � ������� unix timestamp;</li>
    <li><em>folder_id</em> - ������������� ����� (commentsFolder), � ������� ��������� ������ �����������.</li>
</ul>
<p>��� ��������� ��������� ���� ����� ���������:</p>
<<code sql>>
CREATE TABLE `comments_comments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `text` text,
  `author` int(11) unsigned default NULL,
  `time` int(11) unsigned default NULL,
  `folder_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
<</code>>
<p>��� �� ��������� ������ � ����� comments.map.ini:</p>
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
<<note>>��� �� ������ �������� - � ���� ����� �� ��� �� ���� ��������� � ��������� ������������� � <code>commentsFolder</code>. ��� ����� ������� ���� �������.<</note>>
<p>��� �������� <code>commentsFolder</code> ������� �� ����� ���������:</p>
<ul>
    <li><em>id</em> - ��������� ���� �������, ������������� ����� � �������������;</li>
    <li><em>obj_id</em> - ��������� ������������� ������� � �������� ����� ���������� (������);</li>
    <li><em>parent_id</em> - ��������� ������������� ��������������� �������.</li>
</ul>
<<code sql>>
CREATE TABLE `comments_commentsfolder` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `obj_id` int(11) unsigned default NULL,
  `parent_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
<</code>>
<p>��� ��������� ����� ������ � ����� commentsFolder.map.ini:</p>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"
once = true

[parent_id]
accessor = "getParentId"
mutator = "setParentId"
<</code>>