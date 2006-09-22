<p>Пример типичного файла с экшнами (действиями):</p>
<<code>>
        ; news actions config<br />
        <br />
        [view]<br />
        controller = "view"<br />
        <br />
        [folders]<br />
        controller = "folders"<br />
        <br />
        [create]<br />
        controller = "create"<br />
        <br />
        [edit]<br />
        controller = "edit"<br />
        jip = true<br />
        title = "&lt;img src='/templates/images/edit.png' width=16 height=16 border=0 alt='edit' /&gt;"<br />
        <br />
        [delete]<br />
        controller = "delete"<br />
        jip = true<br />
        title = "&lt;img src='/templates/images/delete.png' width=16 height=16 border=0 alt='delete' /&gt;"<br />
        confirm = "Вы хотите удалить эту новость?"<br />
<</code>>

<p>Каждая секция (Например: [view]) обозначает имя определяемого действия. Имя может состоять из букв латинского алфавита (желательно в нижнем регистре), цифр и знака подчёркивания. В каждой секции указывается свойство <em>controller</em> - это имя контроллера, который будет обслуживать данное действие (ссылка на теорию MVC). Это свойство является обязательным (?).<p>
<p>Следующие свойства опциональны:
<ul>
        <li><em>jip</em> - представляет собой булевое значение <strong>true</strong> или <strong>false</strong>, и означающие соответственно наличие или отсутствие данного пункта в jip'ах (ссылка), выводимых для данных объектов.
        </li>
        <li><em>title</em> - Определяет надпись, которая будет выведена в jip. Используется при <em>jip</em> = <strong>true</strong>.
        </li>
        <li><em>confirm</em> - Определяет текст предупреждения, который будет выведен на форме с двумя кнопками <strong>Ok</strong> и <b>Отмена</b> при щелчке на этом пункте меню в jip. Используется при <em>jip</em> = <strong>true</strong>.
        </li>
</ul>
</p>