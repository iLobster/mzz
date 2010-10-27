<p>В ORM mzz на основе паттерна The Observer реализована система хуков. Каждый из хуков вызывается после (или до) определённого действия в маппере. Также в хуки передаются данные, собственно с которыми код хука и должен работать. Полный список хуков может быть уточнён вами в файле orm/observer.php. Пример работы маппера с хуками:<p>

<<code php>>
class newsMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'news';
    protected $table = 'news_news';

    protected $map = array(...);

    [...]

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['updated'] = $data['created'];
        }
    }

    protected function preUpdate(& $data)
    {
        if (is_array($data)) {
            $data['updated'] = new sqlFunction('UNIX_TIMESTAMP');
        }
    }

    [...]
}
<</code>

<p>В этом коде продемонстрировано, как автоматически можно менять время изменения и создания публикации во время изменения и создания нового объекта новости соответственно.</p>