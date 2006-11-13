<p>Для создания сущностей используется генератор, подобный использованному в предыдущей главе. Для создания двух запланированных сущностей перейдите в только что созданный каталог. Затем также в командной строке наберите:</p>
<ul>
    <li>Для сущности comments:
        <<code>>generateDO.bat comments<</code>>
        <p>Результат выполнения команды:</p>
        <<code>>
            File created successfully:<br />
            - comments/comments.php<br />
            - comments/mappers/commentsMapper.php<br />
            - comments/actions/comments.ini<br />
            - comments/maps/comments.map.ini<br />
            <br />
            ALL OPERATIONS COMPLETED SUCCESSFULLY
        <</code>>
    </li>
    <li>Для сущности commentsFolder:
        <<code>>generateDO.bat commentsFolder<</code>>
        <p>Результат выполнения команды:</p>
        <<code>>
            File created successfully:<br />
            - comments/commentsFolder.php<br />
            - comments/mappers/commentsFolderMapper.php<br />
            - comments/actions/commentsFolder.ini<br />
            - comments/maps/commentsFolder.map.ini<br />
            <br />
            ALL OPERATIONS COMPLETED SUCCESSFULLY
        <</code>>
    </li>
</ul>