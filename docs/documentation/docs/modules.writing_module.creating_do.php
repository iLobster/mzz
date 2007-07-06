<p>Для создания сущностей используется генератор, подобный использованному в предыдущей главе. Для создания наших двух запланированных сущностей перейдите в только что созданный каталог модуля и выполните в командной строке:</p>
<ul>
    <li>Для сущности <code>comments</code>:
        <<code>>generateDO.bat comments<</code>>
        <p>Результат успешного выполнения команды:</p>
        <<code>>
File created successfully:
- comments/comments.php
- comments/mappers/commentsMapper.php
- comments/actions/comments.ini
- comments/maps/comments.map.ini

ALL OPERATIONS COMPLETED SUCCESSFULLY
        <</code>>
    </li>
    <li>Для сущности <code>commentsFolder</code>:
        <<code>>generateDO.bat commentsFolder<</code>>
        <p>Результат успешного выполнения команды:</p>
        <<code>>
File created successfully:
- comments/commentsFolder.php
- comments/mappers/commentsFolderMapper.php
- comments/actions/commentsFolder.ini
- comments/maps/commentsFolder.map.ini

ALL OPERATIONS COMPLETED SUCCESSFULLY
        <</code>>
    </li>
</ul>