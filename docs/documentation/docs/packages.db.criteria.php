<p>Класс <code>criteria</code> служит для указания параметров выборки: полей, условий, объединений таблиц, группировки, итд. Сам по себе этот класс не используется нигде в приложениях, но он необходим как набор правил для генерации запроса с помощью класса <code>simpleSelect</code>.</p>
<<note>>Так как каждый из методов <code>criteria</code> возвращает ссылку на сам объект критерии - то вызовы методов можно выстраивать в цепочку для уменьшения объёма кода и улучшения читабельности. Это будет рассмотрено в примерах ниже.<</note>>
<p>Интерфейс <code>criteria</code>:</p>

== __construct.__construct([string $table = null [,string $alias = null]])
<ul>
    <li><code>$table</code> - имя таблицы;</li>
    <li><code>$alias</code> - алиас.</li>
</ul>
<p>Указывает таблицу, для которой генерируется запрос.</p>

== select.criteria select(string $field [, string $alias = null])
<ul>
    <li><code>$field</code> - имя поля;</li>
    <li><code>$alias</code> - алиас.</li>
</ul>
<p>Указывает выбираемые поля
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
</p>

== where.criteria where(string|criterion $field [, mixed $value = null [, int $comparison = criteria::EQUAL]]
<ul>
    <li><code>$field</code> - имя поля либо объект <code>criterion</code> (todo ссылка на criterion);</li>
    <li><code>$value</code> - сравниваемое значение. В зависимости от условия тип может быть любым;</li>
    <li><code>$comparison</code> - тип сравнения.</li>
</ul>
<p>Указывает условия выборки
<<code php>>
$criteria = new criteria('table');
$criteria->where('field', 'value', criteria::GREATER)->where('field2', 'value2');
$select = new simpleSelect($criteria);
echo $select->toString(); // "SELECT * FROM `table` WHERE `table`.`field` > 'value' AND `table`.`field2` = 'value2'"
<</code>>
Доступные для использования типы сравнений:
<ul>
    <li><code>EQUAL</code> - =</li>
    <li><code>NOT_EQUAL</code> - &lt;&gt;</li>
    <li><code>GREATER</code> - &gt;</li>
    <li><code>LESS</code> - &lt;</li>
    <li><code>GREATER_EQUAL</code> - &gt;=</li>
    <li><code>LESS_EQUAL</code> - &lt;=</li>
    <li><code>IN</code> - IN</li>
    <li><code>NOT_IN</code> - NOT IN</li>
    <li><code>LIKE</code> - LIKE</li>
    <li><code>NOT_LIKE</code> - NOT LIKE</li>
    <li><code>BETWEEN</code> - BETWEEN</li>
    <li><code>NOT_BETWEEN</code> - NOT BETWEEN</li>
    <li><code>FULLTEXT</code> - MATCH (%s) AGAINST (%s)</li>
    <li><code>FULLTEXT_BOOLEAN</code> - MATCH (%s) AGAINST (%s IN BOOLEAN MODE)</li>
    <li><code>IS_NULL</code> - IS NULL</li>
    <li><code>IS_NOT_NULL</code> - IS NOT NULL</li>
</ul>
Для сравнений, в которых операнд "значение" состоит фактически из нескольких значений (Например: IN (1, 2, 3)) необходимо передавать массив этих значений.<br />
Пример работы с такими сравнениями:
<<code php>>
$criteria->where('field', array(1, 2, 3), criteria::IN); // `field` IN (1, 2, 3)
$criteria->where('field', array(1, 2), criteria::BETWEEN); // `field` BETWEEN 1 AND 2
$criteria->where(array('field1', 'field2'), 'value', criteria::FULLTEXT); // MATCH(`field1`, `field2`) AGAINST ('value')
$criteria->where('field', null, criteria::IS_NULL); // `field` IS NULL
<</code>>
</p>

== orders.criteria orderByAsc(string $field [, boolean $alias = true]), criteria orderByDesc(string $field [, boolean $alias = true])</td>
<ul>
    <li><code>string $field</code> - имя поля;</li>
    <li><code>[boolean $alias = true]</code> - добавлять ли к сортируемому полю алиас на таблицу.</li>
</ul>
<p>Добавляет сортировку в запрос
<<code php>>
$criteria = new criteria('table');
$criteria->select('field1');
$criteria->orderByAsc('field1');
$select = new simpleSelect($criteria);
$select->toString(); // "SELECT `field1` FROM `table` ORDER BY `table`.`field1` ASC"
<</code>>
</p>