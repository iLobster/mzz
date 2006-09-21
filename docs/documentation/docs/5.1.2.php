Пример типичного файла с экшнами (действиями):<br />
<div class="code"><code>
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
</code></div>
Каждая секция (Например: [view]) обозначает имя определяемого действия. Имя может состоять из букв латинского алфавита (желательно в нижнем регистре), цифр и знака подчёркивания. В каждой секции указывается свойство <i>controller</i> - это имя контроллера, который будет обслуживать данное действие (ссылка на теорию MVC). Это свойство является обязательным (?).<br />
Следующие свойства опциональны:<br />
<ul>
        <li><i>jip</i> - представляет собой булевое значение <b>true</b> или <b>false</b>, и означающие соответственно наличие или отсутствие данного пункта в jip'ах (ссылка), выводимых для данных объектов.
        </li>
        <li><i>title</i> - Определяет надпись, которая будет выведена в jip. Используется совместно со свойством <i>jip</i>.
        </li>
        <li><i>confirm</i> - Определяет предупреждение, которое будет выведено на форме с двумя кнопками <b>Ok</b> и <b>Отмена</b> при щелчке на этом пункте меню в jip. Используется совместно со свойством <i>jip</i>.
        </li>
</ul>