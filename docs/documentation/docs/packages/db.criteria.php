<p>Класс <code>criteria</code> служит для указания параметров выборки: полей, условий, объединений таблиц, группировки, итд. Сам по себе этот класс не используется нигде в приложениях, но он необходим как набор правил для генерации запроса с помощью класса <code>simpleSelect</code>.</p>
<<note>>Так как каждый из методов <code>criteria</code> возвращает ссылку на сам объект критерии - то вызовы методов можно выстраивать в цепочку для уменьшения объёма кода и улучшения читабельности. Это будет рассмотрено в примерах ниже.<</note>>
<p>Интерфейс <code>criteria</code>:</p>

== __construct.__construct
<p>Указывает таблицу, для которой генерируется запрос.</p>

<p><b>__construct</b>([string $table = null [,string $alias = null]])</p>

<table class="beauty">
    <tr>
        <td><code>$table</code></td>
        <td>имя таблицы</td>
    </tr>
    <tr>
        <td><code>$alias</code></td>
        <td>алиас</td>
    </tr>
</table>

== select.select
<p>Указывает выбираемые поля</p>
<code>criteria <b>select</b>(string $field [, string $alias = null])</code>

<table class="beauty">
    <tr>
        <td><code>$field</code></td>
        <td>имя поля</td>
    </tr>
    <tr>
        <td><code>$alias</code></td>
        <td>алиас</td>
    </tr>
</table>

<<code php>>
$criteria = new criteria('table');
$criteria->select('field1');
$criteria->select('field2', 'alias');
$select = new simpleSelect($criteria);
echo $select->toString(); // выведет "SELECT `field1`, `field2` AS `alias` FROM `table`"
<</code>>
<p>Потому как метод <code>select</code> возвращает ссылку на объект критерии - можно сократить данный код:</p>
<<code php>>
$criteria = new criteria('table');
$criteria->select('field1')->select('field2', 'alias');
$select = new simpleSelect($criteria);
echo $select->toString(); // выведет "SELECT `field1`, `field2` AS `alias` FROM `table`"
<</code>>

== where.where
<p>Указывает условия выборки</p>
<code>criteria <b>where</b>(string|criterion $field [, mixed $value = null [, int $comparison = criteria::EQUAL]])</code>

<table class="beauty">
    <tr>
        <td><code>$field</code></td>
        <td>имя поля либо объект <code>criterion</code> (todo ссылка на criterion)</td>
    </tr>
    <tr>
        <td><code>$value</code></td>
        <td>сравниваемое значение. В зависимости от условия тип может быть любым</td>
    </tr>
    <tr>
        <td><code>$comparison</code></td>
        <td>тип сравнения</td>
    </tr>
</table>

<<code php>>
$criteria = new criteria('table');
$criteria->where('field', 'value', criteria::GREATER)->where('field2', 'value2');
$select = new simpleSelect($criteria);
echo $select->toString(); // "SELECT * FROM `table` WHERE `table`.`field` > 'value' AND `table`.`field2` = 'value2'"
<</code>>
<p>Доступные для использования типы сравнений:</p>

<table class="beauty">
    <tr>
        <td><code>EQUAL</code></td>
        <td>=</td>
    </tr>
    <tr>
        <td><code>NOT_EQUAL</code></td>
        <td>&lt;&gt;</td>
    </tr>
    <tr>
        <td><code>GREATER</code></td>
        <td>&gt;</td>
    </tr>
    <tr>
        <td><code>LESS</code></td>
        <td>&lt;</td>
    </tr>
    <tr>
        <td><code>GREATER_EQUAL</code></td>
        <td>&gt;=</td>
    </tr>
    <tr>
        <td><code>LESS_EQUAL</code></td>
        <td>=&lt;</td>
    </tr>
    <tr>
        <td><code>IN</code></td>
        <td>IN</td>
    </tr>
    <tr>
        <td><code>NOT_IN</code></td>
        <td>NOT IN</td>
    </tr>
    <tr>
        <td><code>LIKE</code></td>
        <td>LIKE</td>
    </tr>
    <tr>
        <td><code>NOT_LIKE</code></td>
        <td>NOT LIKE</td>
    </tr>
    <tr>
        <td><code>BETWEEN</code></td>
        <td>BETWEEN</td>
    </tr>
    <tr>
        <td><code>NOT_BETWEEN</code></td>
        <td>NOT BETWEEN</td>
    </tr>
    <tr>
        <td><code>FULLTEXT</code></td>
        <td>MATCH (%s) AGAINST (%s)</td>
    </tr>
    <tr>
        <td><code>FULLTEXT_BOOLEAN</code></td>
        <td>MATCH (%s) AGAINST (%s IN BOOLEAN MODE)</td>
    </tr>
    <tr>
        <td><code>IS_NULL</code></td>
        <td>IS NULL</td>
    </tr>
    <tr>
        <td><code>IS_NOT_NULL</code></td>
        <td>IS NOT NULL</td>
    </tr>
</table>

<p>Для сравнений, в которых операнд "значение" состоит фактически из нескольких значений (Например: IN (1, 2, 3)) необходимо передавать массив этих значений.<br />
Пример работы с такими сравнениями:
<<code php>>
$criteria->where('field', array(1, 2, 3), criteria::IN); // `field` IN (1, 2, 3)
$criteria->where('field', array(1, 2), criteria::BETWEEN); // `field` BETWEEN 1 AND 2
$criteria->where(array('field1', 'field2'), 'value', criteria::FULLTEXT); // MATCH(`field1`, `field2`) AGAINST ('value')
$criteria->where('field', null, criteria::IS_NULL); // `field` IS NULL
<</code>>
</p>

== orders.orderByAsc, orderByDesc
<p>Добавляет сортировку в запрос</p>
<code>criteria <b>orderByAsc</b>(string $field [, boolean $alias = true]), criteria orderByDesc(string $field [, boolean $alias = true])</code>

<table class="beauty">
    <tr>
        <td><code>$field</code></td>
        <td>имя поля</td>
    </tr>
    <tr>
        <td><code>$alias</code></td>
        <td>алиас</td>
    </tr>
</table>

<<code php>>
$criteria = new criteria('table');
$criteria->select('field1');
$criteria->orderByAsc('field1');
$select = new simpleSelect($criteria);
$select->toString(); // "SELECT `field1` FROM `table` ORDER BY `table`.`field1` ASC"
<</code>>