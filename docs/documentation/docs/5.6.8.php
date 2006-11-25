<p>� ������ ������� ������� �������� �������� list, ������� ����� �������� ������ ������������ � ������� �������. ��������������� ����� ��� ������ news (������ �� ����� ��������, ��� ���������� ������ ������ ���� ����������� � ���� ��������� ������������ � ������ �������).</p>
<p>��������� ���� <code>news.view.tpl</code>, ������� ������������� � �������� <code>www/templates/news</code> � ��������� � ���� ��������� ������:</p>
<<code>>{load module="comments" section="comments" action="list" parent_id=$news->getObjId() owner=$news->getEditor()->getId()}<</code>>
<p>��������� �������� ��������� - ��� ����� ���������� ������ ��� ���������� <code>commentsFolder'�</code>. ����� ���������� ������� �����-���� �������. ������ ��� ����������� ������� ����� ��������� �������������� ���:</p>
<<code>>http://mzz/news/4/view<</code>>
<p>����������� �� ����� ������� �� ������ �������������� �������� (Exception).</p>
<<code>>System Exception. Thrown in file D:\server\sites\mzz\system\action\action.php (Line: 182) with message:<br />
�������� "list" �� ������� ��� ������ "comments"<</code>>
<p>�� ����� �������� �� �����, ��� �� ���� ������� �������� list. ������� ��� ��������. � ��������� ������, �������� � �������� �������� ������ <code>comments</code> �������� �������:</p>
<<code>>generateAction.bat commentsFolder list<</code>>
<p>����������� ��������� ���������� �����:</p>
<<code>>
File edited successfully:<br />
- actions/commentsFolder.ini<br />
<br />
File created successfully:<br />
- controllers/commentsFolderListController.php<br />
- views/commentsFolderListView.php<br />
<br />
ALL OPERATIONS COMPLETED SUCCESSFULLY
<</code>>
<p>������ ������� �������� http://mzz/news/4/view. ��������� �� ������ ����������:</p>
<<code>>Invalid Parameter. Thrown in file D:\server\sites\mzz\system\acl\acl.php (Line: 803) with message:<br />
�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0 (0)<</code>>
<p>� ��� �������, �.�. <code>commentsFolder</code> ������ ���������� <code>obj_id</code> �������� <code>commentsFolder'�</code>, � �� ���� ����� ��� �� ��������. �� ����� ���� - ������� ������� � ������� <code>`comments_commentsFolder`</code> ���� ������, � ������� �� � ����� ������ �������� (� ����� ��������� ������ <code>commentsFolder'�</code> ����� ����������� �������������). � ����� ������ <code>obj_id</code> ����� ����� 76 (��� �������� ���������� � ������� <code>`sys_obj_id`</code>, ������� ������� ��� ���� ������), � <code>`parent_id`</code> = 66 (��� �������� ����� ���������� ���� � ���� <code>`obj_id`</code> ������� <code>`news_news`</code>, ���� ������� <code>{$news->getObjId()}</code> � ������, � ������� �� ������ ��������, � ������� ���). ����� �������������� ����� ������ � ACL. ��� ����� � ������� <code>`sys_access_registry`</code> ������� ������ �� ���������� <code>obj_id</code> = 76 � <code>class_section_id</code> = 11.</p>
<p>������ ��������� ���� <code>commentsFolderMapper.php</code>, ������������� � �������� <code>mappers</code> ������ comments. ��� ���������� ����� <code>convertArgsToId()</code>. � ������� <code>$args</code> ��������� <code>parent_id</code>, �� �������� �� ����� ����� ����������� ��� <code>commentsFolder</code>. ����� � ���� ��������� � ���� ������ �������� <code>var_dump($args);</code> � �������� ��������. ���� �� ���� ��������� ���������, �� <code>$args['parent_id']</code> ����� ����� 66 (� ����� ������ - �������� ����). ������ �� �������� <code>parent_id</code> ��� ����� ����� ��������������� ������ � ������� <code>obj_id</code>, ������� ������������� ���� ������. ��� �������� ��������� �����:</p>
<!-- code 1 -->
<p>�������� ��������. ���� �� ��������� ����� - �� �� ��� �����, ��� ������ ������������� �����������, �� ������� ������� "������ ��������". ������� ����� ������ �������� ������������ ��� ������ ������������. � ������� <code>`sys_access`</code> ������� ������ �� ����������: `action_id` = 9 (editACL), `class_section_id` = 11, `obj_id` = 76, `uid` = 2 (admin), `allow` = 1. ���� gid ������� �� ��������� <code>null</code>. ������ ����� ���� ������ ������ �� ���� ������ ������������� ����������� ����������� ��� ��������� ����. �� �������� �� ������: http://mzz/access/76/editACL. � ���� ���� ������� �� ������������ admin � ������� �������� list, ����� ���� ����� ������ "���������� �����". ������� ��� ���� � ������� ���� � ��������. ������ ���������:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\template\mzzFileSmarty.php (Line: 50) with message:
������ 'D:\server\sites\mzz\www/templates/comments/comments.list.tpl' �����������.<</code>>
<p>��� ������, ��� �� �� ������� ����������� �������. ������� � ������� � ��������� (<code>www/templates</code>) � �������� ������� <code>comments</code>, � ������� �������� ���� <code>comments.list.tpl</code>. � ���� ���� ������� ������������ ����� ��� �������� - �������� 'hello world'. � ����� ������� ��������. ������ ������ ����� ������ ��������� �������, ����� ������� ��������� ���� ������� hello world. ������ ���� �� ��������� ������� ������ �������, �� ������ ��������� ������:</p>
<<code>>Fatal error: Call to a member function getObjId() on a non-object in D:\server\sites\mzz\system\modules\comments\mappers\commentsFolderMapper.php on line 49
<</code>>
<p>Ÿ ������� � ���, ��� ��� ���� ������ ������� �� ������� <code>commentsFolder</code>. �����������, ��� ����������� ��� ����� �������������. ������� ������� ���, ������� ����� ��������� � �������� ������� <code>commentsFolder</code> ���� �������� �� ����������.</p>
<!-- code 2 -->
<p>������ ������� ��������. ������ ���������, ��� � ������ ��� ������������ <code>commentsFolder'�</code> � ��� ��� �������. ��� ������� - ���� ����� ������� ��� ����� ������ comments ���� ��� �� ���� ����������� ����. �� �������, ����� ���������� ����, ��������, ��� ������ � ������� <code>`comments_commentsFolder`</code> ���������. ��� ��������� ���� �� ��������� ������� ��������</p>
<<code>>http://mzz/access/comments/commentsFolder/editDefault<</code>>
<p>�� �������� ���� �������� � ��� ���� ����� ��� ����. ��������� ��. � ������� <code>`sys_obj_id_named`</code> ��������� id � ������ �� ��������� ���� `name` = access_comments_commentsFolder. � ��� ������ ��� 78. ����� � ������� <code>`sys_access_registry`</code> ����� ���� ������, � ������ ��� � ���� ���� `class_section_id` = 7. ������ � ������� <code>`sys_access`</code> ��������� ������ �� ���������� ����������: `action_id` = 9 (editACL), `class_section_id` = 7, `obj_id` = 78, `uid` = 2 (admin), `allow` = 1. ���� `gid` ������� �� ��������� null. ������ ������� ��������</p>
<<code>>http://mzz/access/78/editACL<</code>>
<p>� ��� ���������� ���������� ������� ����� �� <code>editDefault</code> ��� ������������ admin. ������ ������� � ��������</p>
<<code>>http://mzz/access/comments/commentsFolder/editDefault<</code>>
<p>� ���� ���������� ������� ��� ������: auth � unauth. ��� ����� �������� ����� �� list, � ��� auth - ��� � ����� �� editACL. ������ ����������� ��� ��� ���������� <code>commentsFolder'�</code> ��� ����� ��������� �� �����. ��� ��� ������� ������ �� ������� ��� ���������� �� ������ ��������� <code>commentsFolder'�</code> � ������� ��������. ������� �����: ������ ������ � ������� <code>`comments_commentsFolder`</code> � ������ �� <code>`sys_access_registry`</code>. ������ ������� �������� �� ������ ��������. ���� �� ������� ����� - ����� ��� ���� �������� ������� 'hello world' � � ������� ����� �������� ����� commentsFolder � ����� �� ����.</p>
<p>�� ���� ��������� �� ���������������� ������ list � �������� ������ ����� - post. ������� ��������� ���� ���������� ���������� ��������� ���� ��� list. ���������, ��� ������ ������ ����� post: ��������� ����� � ��������� ������ �� $_POST-������� � ����������� ����������� � ��. �� ��� �, ������� <code>comments.list.tpl</code>. ������ � �� hello world � ������� ������ ����� �� ������ comments, �� �������� post.</p>
<<code>>{load module="comments" section="comments" action="post" parent_id=$news->getObjId()}<</code>>
<p>����� ���������� �������� ������, ��� ����� ��� �������. ������� ��� ����� ��� �������� ���������</p>
<<code>>http://mzz/access/79/editACL<</code>>
<p>��������� �������� � ����� - ��� �� ������ ������ <code>comments.post.tpl</code>. ����������� ������ ��� � ��� �������� ��� ������ hello world. ����� ���������� ���������� �������� ������ ���� �� ������, �� ������ ��������� ������� hello world. �� ����� ���� ������� ��� ����� �������� �����. ����� ������� ����� - ������ ����� ���� <code>commentsPostForm.php</code> � �������� <code>views</code>:</p>
<!-- code 3 -->
<p>������������� ��������� ����������� ���� ����� <code>commentsFolderPostController.php</code> � <code>commentsFolderPostView.php</code></p>
<!-- code 4 -->
<!-- code 5 -->
<p>�� � ������� �� ������ ��� ����������� ����� <code>comments.post.tpl</code></p>
<!-- html code 6 -->
<p>������ �� ���������� �������� �� ������ ������� �����, ��������� �� ���� ��� ����� � ������ "���������" � "�����". ��� ����� �������� ����������� ��������� �� ��, ��� � ���� � ������������ ����� �����-���� ����������. �������� ���-���� � ��������� ���������. �������� ��������� �� ������:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\controller\sectionMapper.php (Line: 81) with message:<br />
�� ������ �������� ������ ��� section = "comments", action = "post"<</code>>
<p>������� � ������� <code>www/templates/act</code> � �������� � �� ���������� <code>comments</code>. � �� ����� ������������� �������� ������� ������ comments. � ���� �������� �������� ���� <code>post.tpl</code> �� ��������� �����������:</p>
<<code>>{load module="comments" action="post"}<</code>>
<p>����� ������� ��������. ������ ��������� �� ������:</p>
<<code>>PHP Error Exception. Thrown in file D:\server\sites\mzz\system\exceptions\errorDispatcher.php (Line: 49) with message:<br />
Notice in file D:\server\sites\mzz\system\modules\comments\mappers\commentsFolderMapper.php:48: Undefined index: parent_id<</code>>
<p>��� ��������� ������, ��� ������� <code>requestRouter-�</code> �� ��������� �������� � ������ ������� ��� id, � �� ���������� � �������� ������� parent_id. ������� ������� � ��������� id ����� � <code>commentsFolderMapper</code>:</p>
<!-- code 7 -->
<p>������� ��������. � ������ ����� � �������� ���������. ��� ������, ��� ����� post ���� �� ����� ������������ post-�������. ������� ������ ��� ������ ��� ;). ������������ ��������������� ������� ���� <code>commentsFolderPostController.php</code></p>
<!-- code 8 -->
<p>� ����� �������� ����� ����� <code>commentsPostSuccessView</code>, ������� ����� �������������� ��� ����� �������� ���������� ����������� �� �������� ��������, � �������� ��� � ������� <code>views</code>:</p>
<!-- code 9 -->
<p>���� ������ ���������� � ��, �� ����� �������, ��� ���� `time` �� ����������� ��� ����������� ������������. ����� ��������� ���, ������� � <code>commentsMapper</code> ��������� �����:</p>
<!-- code 10 -->
<p>����� ����� ��������� � ���� ����� ����������� ������������ ���� `time` ����� ��������������� �������������.</p>
<p>������ ������� ��������� � ����� `list` � ������� ������ ������������. ��� ����� ������� ������� � ����� �� � ����� <code>commentsFolder.map.ini</code> � ���������� 1:N ������ �������� "�����������" � "����� � �������������". � <code>commentsFolder.map.ini</code> ������� ��� ���� ����, ������ ���� ���� ����� ��������� ���:</p>
<!-- code 11 -->
<p>����� ��������� ����������, ����������� � ������ ��� ������ list ��������������:</p>
<!-- code 12 -->
<!-- code 13 -->
<!-- code 14 -->
<p>��� ������ - ������ �� ������ <code>jip</code> ��� <code>commentsFolder</code>. ������ �� ���������� �������� �� ������ ������� ������ ������������. ������, ��� ����� �� ������� � ��������������� � ������ ������������, ������ ������ ������ ����������� � ��� ��������� ��� id. ������ ������������ 1:1 ����������� � �������������, � ����� ����������� � "����� � �������������". <code>�omments.map.ini</code> � ������ �������������� ���������:</p>
<!-- code 15 -->
<!-- code 16 -->
<p>����� ��� �������� ����� ������� �������� ����� <code>commentsFolderPostController</code>:</p>
<!-- code 27 -->
<p>������ ��������� ������ ������� ���������. �������� ����������� ������ delete � edit. ���������. ����� ����� edit ������ ��� ������, �� �������� ������ ������ �� <code>commentsFolder</code>, � <code>comments</code>. ����� ������� ��� �������� � <code>jip</code> ��� ������� comments:</p>
<<code>>
[edit]<br />
controller = "edit"<br />
jip = "1"<br />
icon = "/templates/images/edit.gif"<br />
title = "�������������"
<</code>>
<p>����� ������������ ������ ������ ������������, ������� <code>{$comment->getJip()}</code>, ��� ������� � ��������� ����� ������ � ���������� ���� jip, � ������� ����� 2 ������: "��������������" � "����� �������". ���� ����������� �������� ����� ������� � ������ �� ������������ - �� ������ ��������� � ���, ��� ��� �������. ��� ������, ��� ��� <code>comments</code> �� ��� �� ������� �������� ���� �� ���������. �������� ��� �� ��������� ��� �����: � �������� `sys_obj_id_named` � `sys_access_registry` �� ������� obj_id � class_section_id ��������� ������ � `sys_access` ������ �� ����������: `action_id` = 18 (editDefault), `class_section_id` = 7, `obj_id` = 86, `uid` = 2, `allow` = 1. ������ ��������� ���</p>
<<code>>http://mzz/access/comments/comments/editDefault<</code>>
<p>� � ������ �� ��������� ��� ������ ����������� �������� edit � editACL. �������� ����� ����������� � ���������� �������� ��� ���� ����� �������. ���� �� ������� ����� - �� ������ ���� �� ������. ������ ��������� � ����� ���� ���</p>
<<code>>http://mzz/comments/7/edit<</code>>
<p>��� 7 - id ������ ��� ���������� �����������. �� ������ ������ ��������� ������:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\controller\sectionMapper.php (Line: 81) with message:<br />
�� ������ �������� ������ ��� section = "comments", action = "edit"<</code>>
<p>�� ��� ��������� �������� �������� ����� �������� ������ <code>comments/edit.tpl</code>.</p>
<!-- code 17 -->
<p>����� �������� ��������� ������� ������:</p>
<<code>>Invalid Parameter. Thrown in file D:\server\sites\mzz\system\acl\acl.php (Line: 803) with message:<br />
�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0 (0)<</code>>
<p>��������� <code>commentsMapper</code> � ������������ ���:</p>
<!-- code 18 -->
<p>��������� ��������. �����:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\template\mzzFileSmarty.php (Line: 50) with message:<br />
������ 'D:\server\sites\mzz\www/templates/comments/comments.edit.tpl' �����������.<</code>>
<p>������ �����, ��� ���� <code>commentsEditView.php</code> ��� �� ����� (�� ����� ������������ ����� <code>commentsPostForm</code> ������ ����). ��� ��� ��� ����� �������. ����� ������������ ����� <code>commentsEditController.php</code>, <code>commentsPostForm.php</code>, <code>comments/edit.tpl</code>, <code>commentsMapper.php</code>, <code>commentsFolderPostView</code>, <code>comments.post.tpl</code>. ������ ��� ����� ��������� ��� (� ��� �� �������):</p>
<!-- code 19 -->
<!-- code 20 -->
<!-- code 21 -->
<!-- code 22 -->
<!-- code 25 -->
<!-- code 26 -->
<p>���� �� ��������� ����� - �� ������ ����� edit ������ ��������. ������ ��������� ����� - ����� delete. �� �� �������� ������� ������� ��� ���. ������ ��������� ���� ��� �������� <code>comments</code>. ����� ��������� ��� � <code>jip</code>:</p>
<!-- code 23 -->
<p>��������� �������� ������ <code>comments/delete.tpl</code>:</p>
<!-- code 24 -->
<p>������ ��� �������������� ����� �� �������� ������-���� ����������� � ������� ��� �������. ���� �� ������� ����� - �� ��������� ����������� ������ ���� �����.</p>
<p>�� � ���������� - ������� � ������, �� ���������� ������ ���������� - �������� ������������ ��� �������� ��������������� �������. � ���������� ������� �� ��� ������ ��������. ������ ����� ���� - deleteFolder. � ������� �� ���� ��������� ������ ���� �� ����� �������� �����. ������� ������� ���� ����� ����� ���� ������ ������ � ������ �������. ������� ��������� ����� �������� ������, � ����� ����������� ����� �������� � ������� `sys_actions` � ������������� ��� � ���� ������� - �� �����. ����� ����� ��������� ��� ����� ����� inACL = 0 � commentsFolder.ini, ��� ���� ����� ACL ������������� ��� �� ������� � ������ ��������� �������. ����� ������ ����� ��������� ��� ���:</p>
<<code>>{load module="comments" section="comments" action="deleteFolder" 403handle="manual"}<</code>>
<p>��������� �������� 403handle="manual" ����� �������� ��� ������, ��� acl ��� ����� ������ ������ ����� ���������� false, ������ ��� ����� ������ � ����� ������ ��� acl �� ���������� (�� ��� �� ���������). ���������� ��� �������� ����� ��������� ��������� �������:</p>
<!-- code 28 -->
<p>�.�. ������� �� ���� ��� commentsFolder'�, ������� ��������� �� ��� �� ������������ �������, � ����� � ����� ������� ��� �������. ��� ����� �������� - �������� ������������ �� ������� simpleMapper::delete(), � remove. ������� ��� ����� ������:</p>
<!-- code 29 -->
<p>����� �� ����� ��������, ��� ����� ����� �� ����� ����� �������� � � �������� ������ news/deleteFolder.tpl.</p>