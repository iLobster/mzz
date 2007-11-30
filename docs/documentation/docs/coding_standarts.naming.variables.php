<p>Имена переменных могут содержать латинские буквы и в некоторых случаях, описанных ниже, знаки подчеркивания ("_").</p>

<p>Рекомендуется разделять слова в имени переменных, которые определены в функции (методе) или в глобальной видимости, знаком подчеркивания.
Примеры правильных имен:</p>

<<code php>>
class sample
{
    public $originalVar = 'foo';

    public function __construct($simpleView)
    {
        $test_var = $this->originalVar;
    }
}
$sample_object = new Sample;
<</code>>