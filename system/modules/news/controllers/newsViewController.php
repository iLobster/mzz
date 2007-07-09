<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * NewsViewController: контроллер для метода list модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.1
 */

class newsViewController extends simpleController
{
    protected function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news');

        //Генерилка "мусора" ;)
        /*for ($i=0; $i<=10000; $i++) {
            $news = $newsMapper->create();
            $news->setText(md5(microtime()));
            $news->setTitle(md5(microtime()));
            $news->setFolder(2);
            $newsMapper->save($news);
        }*/

        $id = $this->request->get('id', 'integer', SC_PATH);
        $news = $newsMapper->searchById($id);

        if (empty($news)) {
            return $newsMapper->get404()->run();
        }

        $this->smarty->assign('news', $news);
        $this->response->setTitle('Новости -> Просмотр -> ' . $news->getTitle());
        return $this->smarty->fetch('news/view.tpl');
    }
}

?>