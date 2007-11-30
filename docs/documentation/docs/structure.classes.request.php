<p>К GET, POST, COOKIE и к параметрам в пути необходимо обращаться через класс <code>httpRequest</code>. В приложении существует только один объект этого класса, который может быть получен из Toolkit следующим образом:</p>
<<code php>>
$request = $toolkit->getRequest();
<</code>>
<p>Для получения значения необходимого параметра используется метод <code>httpRequest::get()</code>, который может принимать три аргумента:
имя внешней переменной, тип (к которому будет приведено значение) и источник данных. По умолчанию тип - <code>mixed</code>, источник данных - <code>SC_PATH</code>.</p>
<!-- php code 1 -->
<p>Доступные типы:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td><strong>Имя</strong></td>
 <td><strong>Описание</strong></td>
</tr>
</thead>
<tr>
 <td>mixed</td>
 <td>любой тип данных</td>
</tr>
<tr>
 <td>string</td>
 <td>строка</td>
</tr>
<tr>
 <td>integer</td>
 <td>число</td>
</tr>
<tr>
 <td>array</td>
 <td>массив</td>
</tr>
<tr>
 <td>boolean</td>
 <td>Булево значение (true или false)</td>
</tr>
</table>
<<note>>Если значение является массивом, а указанный тип не 'array', то из массива будет получен первый элемент, который и будет приведен к нужному типу. Если он тоже окажется массивом, результат будет null.<</note>>

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
 <td>SC_PATH</td>
 <td>результат обработки запрошенного пути объектом класса <code>requestRouter</code></td>
</tr>
</table>

<p>Из объекта класса <code>httpRequest</code> могут быть получены такие данные, как: запрошенный URL, текущее действие, секция, принят ли запрос средствами AJAX и др. Описание всех методов можно найти в API-документации.</p>
