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
<p>��� �� ��������� ������ � ����� comments.map.ini:</p>
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
<<note>>��� �� ������ �������� - � ���� ����� �� ��� �� ���� ��������� � ��������� ������������� � <code>commentsFolder</code>. ��� ����� ������� ���� �������.<</note>>
<p>��� �������� <code>commentsFolder</code> ������� �� ����� ���������:</p>
<ul>
    <li><em>id</em> - ��������� ���� �������, ������������� ����� � �������������;</li>
    <li><em>obj_id</em> - ��������� ������������� ������� � �������� ����� ���������� (������);</li>
    <li><em>parent_id</em> - ��������� ������������� ��������������� �������.</li>
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
<p>��� ��������� ����� ������ � ����� commentsFolder.map.ini:</p>
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