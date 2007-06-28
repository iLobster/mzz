<p>�� ������������� ������� � ������� ����� �����������, �.�. ���� � ������ ��� ��������� �������, �� ��� �� ���������� ������������ ��������� �������:</p>
<<code php>>
$sample = 'world';
<</code>>
<p>��� ���������� �����, ������� �������� ��������� �������, ������������ ������� �������:</p>
<<code php>>
$sample = "world's";
<</code>>
<p>������������ heredoc-��������� ���������.</p>

<p>������ ����������� � ������� �������� ��� ����������� � ������� ��������� ".". ������ ������ ������ ���������� �� � ����� ����� ���������:</p>
<<code php>>
$sample = 'hello ' . 'world';
$sample = $msg . "world's";
<</code>>

<p>���� ������ ������� ������� ���������� ��������� ������ �� ���������. ��������� ������ ������ ���� ��������� ��������� ���, ����� �������� "." ��� �������� ��� ���������� "=":</p>
<<code php>>
$query = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`'
       . 'INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`'
       . 'INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`'
       . 'INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`'
       . 'WHERE `r`.`obj_id` = ' . $this->obj_id;
<</code>>
<p>�������� ����� � ����� ������ �������, ��������, ��� SQL �������:</p>
<<code php>>
$qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`
         INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
          INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`
           INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
            WHERE `r`.`obj_id` = ' . $this->obj_id;
<</code>>