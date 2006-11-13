<p>� ������ ������� ������� �������� �������� list, ������� ����� �������� ������ ������������ � ������� �������. ��������������� ����� ��� ������ news (������ �� ����� ��������, ��� ���������� ������ ������ ���� ����������� � ���� ��������� ������������ � ������ �������).</p>
<p>��������� ���� news.view.tpl, ������� ������������� � �������� www/templates/news � ��������� � ���� ��������� ������:</p>
<<code>>{load module="comments" section="comments" action="list" parent_id=$news->getObjId()}<</code>>
<p>����� ���������� ������� �����-���� �������. ��� ��� ����������� ������� ����� ��������� �������������� ���:</p>
<<code>>http://mzz/news/4/view<</code>>
<p>����������� �� ����� ������� �� ������ �������������� ��������.</p>
<<code>>System Exception. Thrown in file D:\server\sites\mzz\system\action\action.php (Line: 182) with message:<br />
�������� "list" �� ������� ��� ������ "comments"<</code>>
<p>�� ����� �������� �� �����, ��� �� ���� ������� �������� list. ������� ��� ��������. � ��������� ������, �������� � �������� �������� ������ comments �������� �������:</p>
<<code>>generateAction.bat commentsFolder list<</code>>
<p>����������� ���������� �����:</p>
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
<p>������ ������� �������� http://mzz/news/4/view. ������ ��������� �� ������ ����������:</p>
<<code>>Invalid Parameter. Thrown in file D:\server\sites\mzz\system\acl\acl.php (Line: 803) with message:<br />
�������� obj_id ������ ���� �������������� ���� � ����� �������� > 0 (0)<</code>>
<p>� ��� �������, �.�. commentsFolder ������ ���������� obj_id �������� commentsFolder'�, � �� ���� ����� ��� �� ��������. �� ����� ���� - ������� ������� � ������� `comments_commentsFolder` ���� ������, � ������� �� � ����� ������ �������� (� ���������� ��������� ������ commentsFolder'� ������� �� ����� ����������� �������������). � ��� ������ obj_id ����� ����� 76 (��� �������� ���������� � ������� `sys_obj_id`, ������� ������� ��� ���� ������), � `parent_id` = 66 (��� �������� ����� ���������� ���� � ���� `obj_id` ������� `news_news`, ���� ������� {$news->getObjId()} � ������, � ������� �� ������ ��������, � ������� ���). ����� �������������� ����� ������ � ACL. ��� ����� � ������� `sys_access_registry` ������� ������ �� ���������� obj_id = 76 � class_section_id = 11.</p>
<p>������ ��������� ���� commentsFolderMapper.php, ������������� � �������� mappers � �������� � ������� comments. ������ ��� ���������� ����� convertArgsToId(). � ������� $args ��������� parent_id, �� �������� �� ����� ����� ����������� ��� commentsFolder. ����� � ���� ��������� � ���� ������ �������� var_dump($args); � �������� ��������. ���� �� ���� ��������� ���������, �� $args['parent_id'] ����� ����� 66 (� ����� ������ - �������� ����). ������ �� �������� parent_id ��� ����� ����� ��������������� ������ � ������� obj_id, ������� ������������� ���� ������. ��� �������� ��������� �����:</p>
<!-- code 1 -->
<p>������ �������� ��������. ���� �� ��������� ����� - �� �� �� ��� ����� ��� ������ ������������� ����������� ������� ������� "������ ��������". ������� ����� ������ �������� ������������ ��� ������ ������������. � ������� `sys_access` ������� ������ �� ����������: `action_id` = 9 (editACL), `class_section_id` = 11, `obj_id` = 76, `uid` = 2 (admin), `allow` = 1. ���� gid ������� �� ��������� null. ������ ����� ���� ������ ������ �� ���� ������ ������������� ����������� ����������� ��� ��������� ����. �� �������� �� ����: http://mzz/access/76/editACL. � ���� ���� ������� �� ������������ admin � ������� �������� list, ����� ���� ����� ������ "���������� �����". ������� ��� ���� � ������� ���� � ��������. ������ ����� ���������:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\template\mzzFileSmarty.php (Line: 50) with message:
������ 'D:\server\sites\mzz\www/templates/commentsFolder/commentsFolder.list.tpl' �����������.<</code>>
<p>��� ������, ��� �� �� ������� ����������� �������. ������� � ������� � ��������� (www/templates) � �������� ������� comments, � ������� �������� ���� comments.list.tpl. � ���� ���� ������� ������������ ����� ��� �������� - �������� 'hello world'. � ����� ������� ��������. ������ ������ ����� ������ ��������� �������, ����� ������� ��������� ���� ������� hello world.</p>