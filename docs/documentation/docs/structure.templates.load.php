<p>Функция <code>{load}</code> предназначена для запуска модулей из шаблонов. Этот метод является реализацией некоей "стратегии вытягивания", в которой шаблоны (по сути клиентский код) сами определяют, какие данные нужно получить и отобразить пользователю. За счёт этого достигается удобство и гибкость приложений, использующих данный принцип.</p>

<p>Синтаксис функции:</p>
<<code smarty>>
    {load module="" action="" section="" <имя>="значение" ...}
<</code>>
<p>Описание основных аргументов:</p>
<ul>
        <li><strong>module</strong> - имя загружаемого модуля, обязательный параметр; </li>
        <li><strong>action</strong> - имя действия загружаемого модуля, обязательный параметр;</li>
        <li><strong>&lt;имя&gt;, ...</strong> - аргументы, передаваемые в запускаемый модуль;</li>
        <li><strong>section</strong> - имя раздела, в контексте которого будет запущен модуль, за счёт чего достигается возможность обслуживания модулем различных разделов, обладающих одинаковой функциональностью;</li>
</ul>


<p><strong>Пример 1.</strong> Выполнение действия "list" модуля "Новости" в текущей секции:</p>
<<code smarty>>
    {load module="news" action="list"}
<</code>>

<p><strong>Пример 2.</strong> Отображение новости с ID 15 в секции "mainNews":</p>
<<code smarty>>
    {load module="news" action="view" id="15" section="mainNews"}
<</code>>

<p>Дополнительно у <code>{load}</code> есть два аргумента: <code>403tpl</code> и <code>403header</code>. Первый определяет имя шаблон, отображаемого в случае, если прав нет (по умолчанию используется <code>simple403Controller</code>), а второй -- нужно ли выдавать HTTP-ответ 403 Forbidden, если прав нет. Смотрите также раздел о <a href="structure.acl.html#structure.acl.module_running">взаимодействие системы проверки прав и шаблонов</a>.</p>