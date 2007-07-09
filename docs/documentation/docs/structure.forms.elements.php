<p>Для генерации полей (элементов) формы в шаблоне используется механизм хелперов. Данное решение освобождает от необходимости заботиться о восстановлении значений формы, в случае неправильного её заполнения и о выделении ошибочно заполненных полей. Файлы с классами хелперов расположены в каталоге <i>system/forms</i>. Следует отметить, что хелперами генерируется валидный xhtml-код. Запускаются они из шаблона следующим образом:</p>
<<code smarty>>
    {form->helper_name ...}
<</code>>
<p>Хелперы могут принимать различные параметры, но есть и несколько общих:</p>
<ul>
    <li>
        <i>name</i> - параметр, определяющий имя элемента формы
    </li>
    <li>
        <i>value (content для textarea)</i> - параметр, определяющий значение для элемента формы
    </li>
    <li>
        <i>freeze</i> - параметр, определяющий, что поле будет заморожено, т.е. вместо активного элемента, с которым можно производить различные действия (отмечать щелчком, редактировать значение, выбирать значение из списка), будет обычная надпись
    </li>
</ul>
<p>Также могут быть указаны любые параметры html-синтаксиса, используемые в тегах. Например: <i>style</i>, <i>class</i>, <i>id</i>. Примеры их использования:</p>
<<code smarty>>
    {form->text style="form_text_field" id="some_field" name="login"}
<</code>>
<p>К использованию доступны следующие хелперы:</p>
<ul>
    <li>
        <i>caption</i> - используется для вывода названия поля формы. С помощью параметра <i>name</i> указывается, к какому из полей формы относится этот заголовок.
        <<code smarty>>
            {form->caption name="title" value="Название" onError="style=color: red;" onRequired='&lt;span style="color: red; font-size: 150%;"&gt;*&lt;/span&gt; '}
        <</code>>
        Этот хелпер, при отсутствии ошибок и при условии, что поле формы с именем <i>title</i> будет заполнено без ошибок, сгенерирует следующий код:
        <<code html>>
            Название
        <</code>>
        В вышеприведённом коде перечислены все возможные аргументы, которые могут быть использованы в хелпере
        <ul>
            <li>
                <i>onError</i> - перечисление хтмл-тегов, которые будут применены к блоку <i>&lt;span&gt;</i>, в который автоматически заключается данный хелпер (в случае - если поле, к которому относится надпись, введено с ошибками).<br />
                Сгенерированный хтмл:
                <<code html>>
                    &lt;span style="color: red;"&gt;Название&lt;/span&gt;<br />
                <</code>>
                Отображение:
                <<example>>
                    <span style="color: red;">Название</span>
                <</example>>
            </li>
            <li>
                <i>onRequired</i> - параметр, отвечающий за знак, выводимый перед заголовком поля и обозначающий, что данное поле является обязательным к заполнению. Значением по умолчанию для данного параметра является:<br />
                <<code html>>
                    &lt;span style="color: red;"&gt;*&lt;/span&gt; 
                <</code>>
                Для вышеприведённого кода, в случае, если поле формы <i>title</i> является обязательным к заполнению, сгенерированный хтмл будет:
                <<code html>>
                    &lt;span style="color: red; font-size: 150%;"&gt;*&lt;/span&gt; Название
                <</code>>
                Отображение:
                <<example>>
                    <span style="color: red; font-size: 150%;">*</span> Название
                <</example>>
            </li>
        </ul>
    </li>
    <li>
        <i>checkbox</i> - хелпер для вывода checkbox'ов. Типичный пример использования хелпера:
        <<code smarty>>
            {form->checkbox name="save" text="Запомнить" value="off" values="off|on"}
        <</code>>
        По вызову данного кода будет сгенерирован следующй html:
        <<code html>>
            &lt;input name="save" type="hidden" value="off" /&gt;&lt;input id="mzzForms_ccbde77946cbec11692f84948f593d48" name="save" type="checkbox" value="on" /&gt;&lt;label for="mzzForms_ccbde77946cbec11692f84948f593d48" style="cursor: pointer; cursor: hand;"&gt;Запомнить&lt;/label&gt;
        <</code>>
        В браузере пользователя это будет выглядеть следующим образом:
        <<example>>
            <input name="save" type="hidden" value="off" /><input id="mzzForms_ccbde77946cbec11692f84948f593d48" name="save" type="checkbox" value="on" /><label for="mzzForms_ccbde77946cbec11692f84948f593d48" style="cursor: pointer; cursor: hand;">Запомнить</label>
        <</example>>
        В качестве принимаемых параметров кроме вышеописанных <i>name</i> и <i>value</i>, checkbox также может принимать парметр <i>text</i>, который будет выводить текст, поясняющий назначение данного чекбокса. Этот параметр необязательный и параметр <i>values</i>, в котором перечислены значения, отправляемые на сервер при выключенном и включенном состоянии соответственно (значение по умолчанию: <i>0|1</i>).
    </li>
    <li>
        <i>file</i> - хелпер, предоставлящий стандартное поле выбора файла. Пример использования:
        <<code smarty>>
            {form->file name="file"}
        <</code>>
        Сгенерированный html:
        <<code html>>
            &lt;input name="file" type="file" /&gt;
        <</code>>
        Отображение:
        <<example>>
            <input name="file" type="file" />
        <</example>>
    </li>
    <li>
        <i>radio</i> - хелпер для генерации элемента интерфейса "радио-кнопка" (radio-button). Пример использования:
        <<code smarty>>
            {form->radio name="field" text="sample radio button" value=10}
        <</code>>
        Html:
        <<code html>>
            &lt;input id="mzzForms_25c6f3917428566415187f5b2d3020f1" name="field" type="radio" value="10" /&gt;&lt;label for="mzzForms_25c6f3917428566415187f5b2d3020f1" style="cursor: pointer; cursor: hand;"&gt;sample radio button&lt;/label&gt;
        <</code>>
        Отображение:
        <<example>>
            <input id="mzzForms_25c6f3917428566415187f5b2d3020f1" name="field" type="radio" value="10" /><label for="mzzForms_25c6f3917428566415187f5b2d3020f1" style="cursor: pointer; cursor: hand;">sample radio button</label>
        <</example>>
    </li>
    <li>
        <i>select</i> - хелпер для генерации выпадающего списка. Пример использования:
        В пхп заранее сформируем массив с пунктами выпадающего списка:
        <!-- php code 1 -->
        А в шаблоне вызовем хелпер:
        <<code smarty>>
            {form->select name="sample_select" options=$data one_item_freeze=1 value="2" emptyFirst=1}
        <</code>>
        То будет сгенерировано:
        <<code html>>
&lt;select name="sample_select"&gt;
&lt;option value=""&gt;&amp;nbsp;&lt;/option&gt;
&lt;option value="1"&gt;One&lt;/option&gt;
&lt;option value="2" selected="selected"&gt;Two&lt;/option&gt;
&lt;option value="3"&gt;Three&lt;/option&gt;
&lt;/select&gt;
        <</code>>
        Отображение:
        <<example>>
            <select name="sample_select">
            <option value="">&nbsp;</option>
            <option value="1">One</option>
            <option value="2" selected="selected">Two</option>
            <option value="3">Three</option>
            </select>
        <</example>>
        <p>Если был указан параметр <i>multiple=true</i>, то в конец имени элемента добавится "<i>[]</i>" при условии, что оно уже не кончается на [].</p>

        Дополнительные параметры, которые может принимать данный хелпер:
        <ul>
            <li><i>emptyFirst</i> - установленный в значение "<i>1</i>", данный параметр добавит к массиву пунктов списка первый пункт, с пустым значением. Значение по умолчанию: "<i>0</i>"</li>
            <li><i>one_item_freeze</i> - установленный в значение "<i>1</i>", данный параметр "заморозит" (т.е. превратит из списка в обычную надпись) список в случае, если имеется лишь 1 вариант для выбора. Значение по умолчанию: "<i>0</i>"</li>
        </ul>
    </li>
    <li>
        <i>textarea</i> - хелпер для генерации текстареи
        <<code smarty>>
            {form->textarea content="содержимое текстареи" name="sample"}
        <</code>>
        Html:
        <<code html>>
            &lt;textarea name="sample"&gt;содержимое текстареи&lt;/textarea&gt;
        <</code>>
        Этот хелпер используется аналогично <i>text</i>, с тем лишь отличием, что значение, которое будет показано в этом поле - записывается в параметр <i>content</i>.
    </li>
    <li>
        <i>text</i> - хелпер для отображение поля стандарнтного поля ввода.
        <<code smarty>>
            {form->text value="содержимое" name="sample"}
        <</code>>
        Html:
        <<code html>>
            &lt;input type="text" name="sample" value="содержимое" /&gt;
        <</code>>
    </li>
    <li>
        Остальные хелперы: <i>password</i>, <i>image</i>, <i>hidden</i>, <i>submit</i>, <i>reset</i>, используются аналогично хелперу <i>text</i>.
    </li>
</ul>
