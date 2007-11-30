<p>От экранирования кавычек в строках лучше избавляться, т.е. если в строке нет одинарных кавычек, то для ее обрамления используются одинарные кавычки:</p>
<<code php>>
$sample = 'world';
<</code>>
<p>Для обрамления строк, которые содержат одинарные кавычки, используются двойные кавычки:</p>
<<code php>>
$sample = "world's";
<</code>>
<p>Использовать heredoc-синтаксис запрещено.</p>

<p>Строки соединяются с другими строками или переменными с помощью оператора ".". Пробел должен всегда добавлятся до и после этого оператора:</p>
<<code php>>
$sample = 'hello ' . 'world';
$sample = $msg . "world's";
<</code>>

<p>Если строка слишком длинная необходимо разрывать строку на несколько. Следующая строка должна быть дополнена пробелами так, чтобы оператор "." был выровнен под оператором "=":</p>
<<code php>>
$query = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`'
       . 'INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`'
       . 'INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`'
       . 'INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`'
       . 'WHERE `r`.`obj_id` = ' . $this->obj_id;
<</code>>
<p>Допустим также и такой способ разрыва, например, для SQL запроса:</p>
<<code php>>
$qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_access_registry` `r`
         INNER JOIN `sys_classes_sections` `cs` ON `cs`.`id` = `r`.`class_section_id`
          INNER JOIN `sys_classes_actions` `ca` ON `ca`.`class_id` = `cs`.`class_id`
           INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
            WHERE `r`.`obj_id` = ' . $this->obj_id;
<</code>>