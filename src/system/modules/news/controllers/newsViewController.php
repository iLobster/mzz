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
 * newsViewController: контроллер для метода view модуля news
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

        $id = $this->request->getInteger('id');
        $news = $newsMapper->searchByKey($id);

        if (empty($news)) {
            return $this->forward404($newsMapper);
        }

        $this->view->assign('news', $news);
        return $this->render('news/view.tpl');
    }
}

?>