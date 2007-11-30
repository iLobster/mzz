<p>Для создания структуры каталогов в командной строке перейдите в каталог <code>system/modules</code> и выполните следующую команду:</p>
<<code>>generateModule.bat comments<</code>>
<p>В ответ на эту команду будет выдана информация о результате генерации: какие файлы и каталоги были созданы или изменены, или ошибка и, возможно, причина, по которой сгенерировать модуль не удалось.</p>
<<code>>
Module root folder created successfully:
- comments

Folder created successfully:
- comments/actions
- comments/controllers
- comments/mappers
- comments/maps
- comments/views

File created successfully:
- comments/commentsFactory.php
- generateDO.bat
- generateAction.bat

ALL OPERATIONS COMPLETED SUCCESSFULLY
<</code>>