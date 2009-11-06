<p>Контроллеры располагаются в директории <code>controllers</code> модуля. Имена контроллеров должны соответствовать следующему соглашению: <code>&lt;Имя_модуля&gt;&lt;Имя_контроллера&gt;Controller</code>. Например, для модуля <code>news</code> контроллер <code>view</code> будет называться: <code>newsViewController</code>.</p>
<p>Контроллеры в ваших модулях должны наследоваться от базового абстрактного класса <code>simpleController</code>. Каждый контроллер должен реализовывать защищённый (protected) метод <code>getView()</code>.</p>
<p>Таким образом, простейшим примером может выступать следующий контроллер, возвращающий клиенту строку <code>Hello, world!</code>:</p>

<<code php>>
class helloWorldController extends simpleController
{
    protected function getView()
    {
        return 'Hello, world!';
    }
}
<</code>>