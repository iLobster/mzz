<?php

class newsViewController extends simpleController
{
    protected function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news');

        $id = $this->request->get('id', 'integer', SC_PATH);
        $news = $newsMapper->searchByKey($id);

        if (empty($news)) {
            return $newsMapper->get404()->run();
        }

        $this->smarty->assign('news', $news);
        return $this->smarty->fetch('news/view.tpl');
    }
}

?>