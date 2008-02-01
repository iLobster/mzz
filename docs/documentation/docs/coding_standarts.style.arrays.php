<p>Каждый элемент массива должен быть отделен от другого пробелом после запятой:</p>
<<code php>>
$sample = array(1);
$sample = array(1, 2, 'hello', "world's");
$sample = array(1, 2, 'hello', "world's",
                'cms', $a, $b, $c,
                $f, 'value', null, -1);
<</code>>

<p>При указании ключа перед и после '=>' необходимо поставить пробел:</p>
<<code php>>
$sample = array('key' => 'value');
<</code>>