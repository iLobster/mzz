<p>Часто бывает, что необходимо поменять некоторые вещи в коробочных модулях framy, например,
модифицировать $map (todo: ссылка туда, где знают, что такое MAP объекта) или же просто добавить недостающий метод в маппер.
В таком случае подойдет способ, описанный в <a href="extending.system.html">этой</a> главе, но он не очень удобен по ряду причин.</p>

<p>Framy предлагает немного иной подход к проблеме переопределения частей модуля в приложениях. Рассмотрим его на примере модуля user.</p>

<p>Мы имеем userMapper.php следующего содержания (тело класса скрыто, весь листинг вы можете посмотреть, открыв файл &lt;framy&gt;/system/modules/user/mappers/userMapper.php):</p>
<<code php>>
class userMapper extends mapper
{

    /* ... */

}
?>
<</code>>

<p>И мы хотим переопределить этот маппер с целью добавить новый метод <code>searchAllLastLoggedIn</code> — метод, возвращающий нам всех пользователей, которые
приходили на сайт не ранее заданной даты</p>

<p>Для реализации этой идеи достаточно создать файл в каталоге <i>&lt;project&gt;/modules/user/mappers/appUserMapper.php</i>, где &lt;project&gt; это путь до
вашего приложения (опция systemConfig::$pathToApplication), а <code>appUserMapper.php</code> — новое имя маппера, которое
было образовано путем добавления приставки <i>app</i> к базовому имени маппера. Префикс <em>app</em> в данном случае является стандартным и одинаковым для всех переопределяемых мапперов. </p>
<p><code>appUserMapper.php</code> будет выглядеть примерно так:</p>
<<code php>>
fileLoader::load('modules/user/mappers/userMapper');

class appUserMapper extends userMapper
{
    public function searchAllLastLoggedIn($time)
    {
        $criteria = new criteria;
        $criteria->where('last_login', $time, criteria::GREATER);

        return $this->searchAllByCriteria($criteria);
    }

}
<</code>>


<p>Несложно догадаться, что теперь можно добавлять, переопределять любые методы и свойства базового маппера <code>userMapper</code></p>