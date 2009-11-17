<p>newsModule.php представляет собой класс, описывающий модуль.</p>
<<code php>>
class newsModule extends simpleModule
{
    protected $classes = array(
        'news',
        'newsFolder');

    protected $roles = array(
        'moderator',
        'user');

    public function getRoutes()
    {
        return array(
            array(),
            array(
                'newsFolder' => new requestRoute('news/:name/:action', array(
                    'module' => 'news',
                    'name' => 'root',
                    'action' => 'list'), array(
                    'name' => '.*?',
                    'action' => '(?:list|create|createFolder|editFolder|deleteFolder|moveFolder)'))));
    }
}
<</code>>

<p>Данный класс <strong>должен</strong> наследоваться от класса simpleModule и служит для хранения служебной информации о модуле. Так, к примеру, в данном классе
содержится информация:</p>

<ul>
    <li>о классах модуля (массив protected $classes)</li>
    <li>роли, используемые в модуле (todo: ссылка на соответствующий раздел)</li>
    <li>модуле-зависимые роуты (возвращается массив из двух элементов, в котором первый массив содержит роуты, которые должны быть добавлены в начало и второй массив - в конец)</li>
    <li>иконка модуля в admin-интерфейсе фреймворка</li>
</ul>

<p>Помимо всего прочего, данный класс отвечает за получение мапперов и действий модуля, что позволит, к примеру, реализовать нестандартную схему получения маппера
для объекта или создать так называемые multi-action контроллеры (todo: сделать раздел доки tricks и описать там такой финт)</p>