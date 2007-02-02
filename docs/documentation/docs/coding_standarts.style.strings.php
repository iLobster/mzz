<p>���� � ������ ��� ��������� �������, �� ��� �� ���������� ������������ ��������� �������:</p>
<<code>>
$sample = 'world';
<</code>>
<p>��� ���������� �����, ������� �������� ��������� �������, ������������ ������� �������:</p>
<<code>>
$sample = "world's";
<</code>>
<p>������������ heredoc-��������� �� �������������.</p>

<p>������ ����������� � ������� �������� ��� ����������� � ������� ��������� ".". ������ ������ ������ ���������� �� � ����� ����� ���������:</p>
<<code>>
$sample = 'hello ' . 'world';<br />
$sample = $msg . "world's";
<</code>>

<p>���� ������ ������� ������� ���������� ��������� ������ �� ���������. ��������� ������ ������ ���� ��������� ��������� ���, ����� �������� "." ��� �������� ��� ���������� "=":</p>
<<code>>
$qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`'<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;. 'INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`'<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;. 'INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`'<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;. 'INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`'<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;. 'WHERE `r`.`obj_id` = ' . $this->obj_id;<br />
<</code>>
<p>�������� ����� � ����� ������ �������, ��������, ��� SQL �������:</p>
<<code>>
$qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHERE `r`.`obj_id` = ' . $this->obj_id;<br />
<</code>>