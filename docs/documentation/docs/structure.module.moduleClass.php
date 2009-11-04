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