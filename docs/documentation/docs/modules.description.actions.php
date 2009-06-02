<p>Пример типичного файла с actions (действиями):</p>
<<code ini>>
; news actions config

[view]
controller = "view"

[edit]
controller = "save"
jip = 1
icon = "sprite:mzz-icon/mzz-icon-doc-edit"
lang = 1
main = "active.blank.tpl"

[move]
controller = "move"
jip = 1
icon = "sprite:mzz-icon/mzz-icon-doc-move"

[delete]
controller = "delete"
jip = 1
icon = "sprite:mzz-icon/mzz-icon-doc-del"
confirm = "_ news/confirm_delete"
main = "active.blank.tpl"

[admin]
controller = "admin"
title = "_ admin"
admin = "1"

[searchByTag]
controller = "searchByTag"
title = "searchByTag"

<</code>>

<p>Каждая секция (Например: [view]) обозначает имя определяемого действия. Имя может состоять из букв латинского алфавита (желательно в нижнем регистре), цифр и знака подчёркивания. В каждой секции указывается свойство <em>controller</em> - это имя контроллера, который будет обслуживать данное действие (ссылка на теорию MVC). Это свойство является обязательным (?).<p>
<p>Следующие свойства опциональны:
<ul>
    <li><em>jip</em> — представляет собой булевое значение <strong>true</strong> или <strong>false</strong>, и означающие соответственно наличие или отсутствие данного пункта в jip'ах (ссылка), выводимых для данных объектов.
    </li>
    <li><em>title</em> — Определяет надпись, которая будет выведена в jip. Используется при <em>jip</em> = <strong>true</strong>.
    </li>
    <li><em>icon</em> — Определяет иконку, которая будет выведена в jip. Используется при <em>jip</em> = <strong>true</strong>. (desperado, опиши, пожалуйста, что оно из себя представляет)
    </li>
    <li><em>lang</em> — (???)
    </li>
    <li><em>confirm</em> — Определяет текст предупреждения, который будет выведен на форме с двумя кнопками <strong>Ok</strong> и <b>Отмена</b> при щелчке на этом пункте меню в jip. Используется при <em>jip</em> = <strong>true</strong>.
    </li>
    <li><em>main</em> — Определяет main шаблон для данного действия. (описать допустимые значения)
    </li>
    <li><em>admin</em> — представляет собой булевое значение. Если <em>admin</em> = <strong>true</strong>, то этот экшн предназначается для администрирования модуля и будет отображен в admin-меню
    </li>
</ul>
</p>