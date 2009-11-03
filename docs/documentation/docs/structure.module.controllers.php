<p>Контроллеры предназначены для обеспечения взаимодействия моделей (todo ссылка) и отображения (todo ссылка). Контроллеры в ваших модулях должны наследоваться от базового абстрактного класса <code>simpleController</code>. Каждый контроллер должен реализовывать защищённый (protected) метод <code>getView()</code>.</p>
<p>Таким образом, простейшим примером может выступать следующий контроллер, возвращающий клиенту строку <code>Hello, world!</code>:</p>
<<code php>>
class HelloWorldController extends simpleController
{
    protected function getView()
    {
        return 'Hello, world!';
    }
}
<</code>>
<p>todo стандарты именования контроллеров</p>