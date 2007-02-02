<p>Методы должны всегда определять свою область видимости с помощью одного из префиксов private, protected или public.</p>

<p>Как и у классов, фигурная скобка всегда пишется на следующей строке под именем функции. Пробелы между именем функции и круглой скобкой для аргументов отсутствуют. Аргументы разделяются пробелом.</p>

<p>Функции в глобальной области видимости крайне не приветствуются.</p>

<p>Пример определения метода:</p>
<<code>>
/**<br />
&nbsp;* Блок комментариев<br />
&nbsp;*/<br />
class Foo<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;/**<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Блок комментариев<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/<br />
&nbsp;&nbsp;&nbsp;&nbsp;public function bar($arg, $name, $value = 'default')<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// содержимое класса<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}
<</code>>

<p>Возвращаемое значение не должно обрамляться в круглые скобки:</p>
<<code>>
return $this->bar; // ПРАВИЛЬНО<br />
return($this->bar); // НЕПРАВИЛЬНО
<</code>>