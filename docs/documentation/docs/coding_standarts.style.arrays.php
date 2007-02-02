<p>Каждый элемент массива должен быть отделен от другого пробелом перед запятой:</p>
<<code>>
$sample = array(1);<br />
$sample = array(1, 2, 'hello', "world's");<br />
$sample = array(1, 2, 'hello', "world's",<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'cms', $a, $b, $c,<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$f, 'value', null, -1);
<</code>>

<p>При указании ключа перед и после '=>' необходимо поставить пробел:</p>
<<code>>
$sample = array('key' => 'value');
<</code>>