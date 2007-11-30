<p>В одном файле может быть определен только один класс.</p>
<p>Имена классов выбираются в зависимости от решаемых им задач. Старайтесь выбрать наиболее подходящее название, раскрывающее суть класса. Для этого можно использовать латинские буквы. Знак подчеркивания ("_") не рекомендуется. Обычно имя класса начинается со строчной буквы. Иерархия классов также отражается на их именах, каждый уровень отделяется заглавной буквой.</p>

<p>Примеры правильных имен:</p>
<<code>>
newsDeleteController
httpRequest
adminMapper
<</code>>

<p>Класс может быть определен как абстрактный (abstract class core) или как финальный (final class core). Подумайте прежде чем объявлять класс финальным.</p>

<p>Свойства класса должны быть определены как public, private, или protected. Использование var (который хоть и является алиасом public), для указания доступа к свойству не допускается.</p>

<p>Пример класса:</p>
<<code php>>
class funnyAction
{
    const SOME_CONSTANT = 'value';
    public $foo;
    protected $some;
    private $bar = 'Default value';
}
<</code>>
