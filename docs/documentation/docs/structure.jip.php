<p>JIP - это быстрый доступ к действиям над объектом.</p>
<p>Все действия, на которые есть права у текущего пользователя, собраны в виде элементов меню, которое отображается при нажатии на кнопку JIP рядом с объектом. При нажатии на такой элемент открывается JIP окно и благодаря технологии AJAX позволяет выполнить действие над объектом не покидая текущую страницу.</p>

<p>Реализация клиентской части JIP состоит из трех Javascript-файлов: <code>prototype.js</code>, <code>effects.js</code>, <code>jip.js</code>
и одного CSS: <code>jip.css</code>. Два последних файла подгружается только при наличии на странице хотя бы одного JIP-меню. Подключение Javascript/CSS файлов, используемых только в JIP-окнах, может располагаться в шаблоне <code>jip.tpl</code> (см. <a href="structure.templates.html#structure.templates.add">{add}</a>).</p>
<<note>>
Кнопка JIP появляется только когда у текущего пользователя есть хотя бы одно разрешенное действие над объектом.
<</note>>

<p>В качестве JavaScript Framework используется <a href="http://www.prototypejs.org/">Prototype</a>, существенно облегчающий разработку JavaScript сценариев. Кроме того, используется  библиотека <a href="http://script.aculo.us/">script.aculo.us</a>.</p>

<p>JIP имеет каждый DataObject, наследованный от класса <code>simple</code>.</p>

<p>Действия, которые доступны в меню при наличии прав на них, имеют опцию <code>jip</code> со значением 1 в конфигурации действий:</p>
<<code ini>>
[edit]
controller = "edit"
jip = "1"
<</code>>

<p>Для отображения кнопки JIP необходимо в шаблоне вызвать метод <code>simple::getJip()</code>:</p>
<<code smarty>>
{$news->getJip()}
<</code>>

<p>При нажатии на один из элементов соответствующая страница открывается в JIP-окне.</p>

<p>Также в JIP-окне открываются любые ссылки, принадлежащие CSS-классу <code>jipLink</code>:</p>
<<code html>>
&lt;a href="{url route="default" section="news" action="info"}" class="jipLink"&gt;Сис. информация&lt;/a&gt;
<</code>>
<p>Открываемые в JIP-окне страницы должны содержать как минимум его заголовок. Он определяется HTML-элементом &lt;DIV&gt;, который принадлежит к CSS-классу <code>jipTitle</code>:</p>
<<code html>>
&lt;div class="jipTitle"&gt;Создать новость&lt;/div&gt;
<</code>>

<p>Форму можно отправить через Ajax добавив атрибут <code>onsubmit="return mzzAjax.sendForm(this);"</code>:</p>
<<code html>>
&lt;form action="/winner/add" method="post" onsubmit="return mzzAjax.sendForm(this);"&gt;<br />
Имя: &lt;input size="60" name="name" type="text"&gt;<br />
&lt;input type="submit"&gt;<br />
&lt;/form&gt;
<</code>>

Закрыть JIP-окно можно вызовом Javascript-функции <code>jipWindow.close()</code>:
<<code html>>
&lt;input type="reset" onclick="jipWindow.close();"&gt;
&lt;a href="javascript: void(jipWindow.close());"&gt;закрыть&lt;/a&gt;
<</code>>