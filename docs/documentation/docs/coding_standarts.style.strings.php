<p>ќт экранировани€ кавычек в строках лучше избавл€тьс€, т.е. если в строке нет одинарных кавычек, то дл€ ее обрамлени€ используютс€ одинарные кавычки:</p>
<<code php>>
$sample = 'world';
<</code>>
<p>ƒл€ обрамлени€ строк, которые содержат одинарные кавычки, используютс€ двойные кавычки:</p>
<<code php>>
$sample = "world's";
<</code>>
<p>»спользовать heredoc-синтаксис запрещено.</p>

<p>—троки соедин€ютс€ с другими строками или переменными с помощью оператора ".". ѕробел должен всегда добавл€тс€ до и после этого оператора:</p>
<<code php>>
$sample = 'hello ' . 'world';
$sample = $msg . "world's";
<</code>>

<p>≈сли строка слишком длинна€ необходимо разрывать строку на несколько. —ледующа€ строка должна быть дополнена пробелами так, чтобы оператор "." был выровнен под оператором "=":</p>
<<code php>>
$query = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`'
       . 'INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`'
       . 'INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`'
       . 'INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`'
       . 'WHERE `r`.`obj_id` = ' . $this->obj_id;
<</code>>
<p>ƒопустим также и такой способ разрыва, например, дл€ SQL запроса:</p>
<<code php>>
$qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`
         INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
          INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`
           INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
            WHERE `r`.`obj_id` = ' . $this->obj_id;
<</code>>