<p>»мена переменных могут содержать латинские буквы и в некоторых случа€х, описанных ниже, знаки подчеркивани€ ("_").</p>

<p>–екомендуетс€ раздел€ть слова в имени переменных, которые определены в функции (методе) или в глобальной видимости, знаком подчеркивани€.
ѕримеры правильных имен:</p>

<<code>>
class sample<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;public $originalVar = 'foo';<br />
&nbsp;&nbsp;&nbsp;&nbsp;public function __construct($simpleView)<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$test_var = $this->originalVar;<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}<br />
$sample_object = new Sample;
<</code>>

