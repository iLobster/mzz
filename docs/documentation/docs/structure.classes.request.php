<p>К GET, POST, COOKIE и к параметрам в пути необходимо обращаться через класс <code>httpRequest</code>. В приложении существует только один объект этого класса, который может быть получен из Toolkit следующим образом:</p>
<<code php>>
$request = $toolkit->getRequest();
<</code>>
<p>Для получения значения сушествует несколько методов, которые отличаются типом значения, которое будет получено из запроса.</p>
<!-- php code 1 -->
<p>Доступные методы:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td><strong>Имя</strong></td>
 <td><strong>Описание</strong></td>
</tr>
</thead>
<tr>
 <td>getString()</td>
 <td>string (строка)</td>
</tr>
<tr>
 <td>getInteger()</td>
 <td>integer (целое число)</td>
</tr>
<tr>
 <td>getNumeric()</td>
 <td>numeric (любое число)</td>
</tr>
<tr>
 <td>getArray()</td>
 <td>array (массив)</td>
</tr>
<tr>
 <td>getBoolean()</td>
 <td>boolean (true или false)</td>
</tr>
<tr>
 <td>getRaw()</td>
 <td>любой тип (значение как есть)</td>
</tr>
</table>
<<note>>Если значение является массивом, а указанный тип не 'array', то из массива будет получен первый элемент, который и будет приведен к нужному типу. Если он тоже окажется массивом, результат будет null.<</note>>

<p>Каждый метод может принимать два аргумента: имя и источник данных. По умолчанию источник данных <code>SC_PATH</code>.</p>

<p><code>httpRequest</code> может получать данные из следующих источников данных:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td>Константа</td>
 <td>Описание</td>
</tr>
</thead>
<tr>
 <td>SC_GET</td>
 <td>массив $_GET (при GET-запросе)</td>
</tr>
<tr>
 <td>SC_POST</td>
 <td>массив $_POST (при POST-запросе)</td>
</tr>
<tr>
 <td>SC_REQUEST</td>
 <td>массив $_GET или $_POST (приоритет имеет $_POST)</td>
</tr>
<tr>
 <td>SC_COOKIE</td>
 <td>массив $_COOKIE</td>
</tr>
<tr>
 <td>SC_SERVER</td>
 <td>массив $_SERVER</td>
</tr>
<tr>
 <td>SC_FILES</td>
 <td>массив $_FILES</td>
</tr>
<tr>
 <td>SC_PATH</td>
 <td>результат обработки запрошенного пути объектом класса <code>requestRouter</code></td>
</tr>
</table>

<p>Из объекта класса <code>httpRequest</code> могут быть получены такие данные, как: запрошенный URL, текущее действие, секция, принят ли запрос средствами AJAX и др. Описание всех методов можно найти в API-документации.</p>
