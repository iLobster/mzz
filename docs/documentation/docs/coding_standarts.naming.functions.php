<p>Так как mzz использует объектно-ориентированный стиль программирования, то в коде должно быть минимальное число функций, поэтому желательно описать функцию как метод.</p>

<p>Имена функций и методов должны быть оформлены в соответствии с <a href="http://ru.wikipedia.org/wiki/CamelCase">camelCase</a>-нотацией.</p>

<p>Для имени функций или методов можно использовать латинские буквы. Имя функции, в отличие от имени метода, может содержать также знаки подчеркивания ("_"). Старайтесь выбрать наиболее подходящее название, раскрывающее суть функции.</p>

<p>Функции должны иметь префикс в виде имени пакета для того, чтобы избежать проблем с функциями из других пакетов. Первая буква в имени должна быть в нижнем регистре, каждая первая буква "слова" - в верхнем.</p>

<p>Примеры имен функций (аналогично для методов):</p>
<<code php>>
function setTitle()
{
    //...
}

function resolve()
{
    //...
}
<</code>>
