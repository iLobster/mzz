<p>  GET, POST и COOKIE параметрам необходимо обращатьс€ через объект класса <code>httpRequest</code>. ¬ процессе выполнени€ существует только один такой объект, который может быть получен из Toolkit следующим образом:</p>
<<code>>
$request = $toolkit->getRequest();
<</code>>
<p>ƒл€ получени€ значени€ необходимого параметра используетс€ метод <code>httpRequest::get()</code>, который может принимать три аргумента:
им€ внешней переменной, тип (к которому будет приведено значение) и источник данных. ѕо умолчанию тип - mixed, источник данных - SC_REQUEST.</p>
<!-- code 1 -->
<p>ƒоступные типы:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td><strong>»м€</strong></td>
 <td><strong>ќписание</strong></td>
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
 <td>Ѕулево значение (true или false)</td>
</tr>
</table>
<<note>>≈сли значение €вл€етс€ массивом, а указанный тип не 'array', то из массива будет получен первый элемент, который и будет приведен к нужному типу. ≈сли он тоже окажетс€ массивом, результат будет null.<</note>>

<p><code>httpRequest</code> может получать данные из следующих источников данных:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td> онстанта</td>
 <td>ќписание</td>
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
 <td>запрошенный путь (результат обработки пути объектом класса <code>requestRouter</code>)</td>
</tr>
</table>

<p>»з объекта класса <code>httpRequest</code> могут быть получены такие данные, как: запрошенный URL, текущее действие, секци€, прин€т ли запрос средствами AJAX и др. ќписание всех методов можно найти в API-документации.</p>
