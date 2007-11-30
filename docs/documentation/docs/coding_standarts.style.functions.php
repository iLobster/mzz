<p>Методы должны всегда определять свою область видимости с помощью одного из префиксов private, protected или public.</p>

<p>Как и у классов, фигурная скобка всегда пишется на следующей строке под именем функции. Пробелы между именем функции и круглой скобкой для аргументов отсутствуют. Аргументы разделяются пробелом.</p>

<p>Функции в глобальной области видимости крайне не приветствуются.</p>

<p>Пример определения метода:</p>
<<code php>>
/**
&nbsp;* Блок комментариев
&nbsp;*/
class Foo
{
&nbsp;&nbsp;&nbsp;&nbsp;/**
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Блок комментариев
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/
&nbsp;&nbsp;&nbsp;&nbsp;public function bar($arg, $name, $value = 'default')
&nbsp;&nbsp;&nbsp;&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// содержимое класса
&nbsp;&nbsp;&nbsp;&nbsp;}
}
<</code>>

<p>Возвращаемое значение не должно обрамляться в круглые скобки:</p>
<<code php>>
return $this->bar; // ПРАВИЛЬНО
return($this->bar); // НЕПРАВИЛЬНО
<</code>>