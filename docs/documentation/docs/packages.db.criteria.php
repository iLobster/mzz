<p>Класс <code>criteria</code> служит для указания параметров выборки: полей, условий, объединений таблиц, группировки, итд. Сам по себе этот класс не используется нигде в приложениях, но он необходим как набор правил для генерации запроса с помощью класса <code>simpleSelect</code>.</p>
<<note>>Так как каждый из методов <code>criteria</code> возвращает ссылку на сам объект критерии - то вызовы методов можно выстраивать в цепочку для уменьшения объёма кода и улучшения читабельности. Это будет рассмотрено в примерах ниже.<</note>>
<p>Интерфейс <code>criteria</code>:</p>

<table class="beauty">
    <tr>
        <th>Метод</th>
        <th>Аргументы</th>
        <th>Описание</th>
    </tr>

    <tr>
        <td>__construct</td>
        <td>
            <ul>
                <li><code>[strng $table = null]</code> - имя таблицы;</li>
                <li><code>[strng $alias = null]</code> - алиас.</li>
            </ul>
        </td>
        <td>
            Указывает таблицу, для которой генерируется запрос.
        </td>
    </tr>

    <tr>
        <td>select</td>
        <td>
            <ul>
                <li><code>strng $field</code> - имя поля;</li>
                <li><code>[strng $alias = null]</code> - алиас.</li>
            </ul>
        </td>
        <td>
            Указывает выбираемые поля
<<code php>>
$criteria = new criteria('table');
$criteria->select('field1');
$criteria->select('field2', 'alias');
$select = new simpleSelect($criteria);
echo $select->toString(); // выведет "SELECT `field1`, `field2` AS `alias` FROM `table`"
<</code>>
            Потому как метод <code>select</code> возвращает ссылку на объект критерии - можно сократить данный код:
<<code php>>
$criteria = new criteria('table');
$criteria->select('field1')->select('field2', 'alias');
$select = new simpleSelect($criteria);
echo $select->toString(); // выведет "SELECT `field1`, `field2` AS `alias` FROM `table`"
<</code>>
        </td>
    </tr>
</table>