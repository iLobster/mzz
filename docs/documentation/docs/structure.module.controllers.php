<p>Контроллеры предназначены для обеспечения взаимодействия моделей (todo ссылка) и отображения (todo ссылка). Контроллеры в ваших модулях должны наследоваться от базового абстрактного класса <code>simpleController</code>. Каждый контроллер должен реализовывать защищённый (protected) метод <code>getView()</code>.</p>
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

<p>Имя контроллера складывается из &lt;имя_модуля&gt;&lt;Имя_контроллера&gt;Controller.</p>
<p>Например, для действия <i>view</i> модуля <i>news</i> контроллер будет иметь имя <code>newsViewController</code></p>

<<code php>>
<?php

class newsViewController extends simpleController
{
    protected function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news');

        $id = $this->request->getInteger('id');
        $news = $newsMapper->searchByKey($id);

        if (empty($news)) {
            return $this->forward404($newsMapper);
        }

        $this->smarty->assign('news', $news);
        return $this->smarty->fetch('news/view.tpl');
    }
}

?>
<</code>>