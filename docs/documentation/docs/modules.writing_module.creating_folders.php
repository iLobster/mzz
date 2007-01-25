<p>Для создания структуры каталогов в командной строке перейдите в каталог <code>system/modules</code> и выполните следующую команду:</p>
<<code>>generateModule.bat comments<</code>>
<p>В ответ на эту команду будет выдана информация о результате генерации: какие файлы и каталоги были созданы или изменены, или ошибка и, возможно, причина, по которой сгенерировать модуль не удалось.</p>
<<code>>
Module root folder created successfully:<br />
- comments<br />
<br />
Folder created successfully:<br />
- comments/actions<br />
- comments/controllers<br />
- comments/mappers<br />
- comments/maps<br />
- comments/views<br />
<br />
File created successfully:<br />
- comments/commentsFactory.php<br />
- generateDO.bat<br />
- generateAction.bat<br />
<br />
ALL OPERATIONS COMPLETED SUCCESSFULLY
<</code>>