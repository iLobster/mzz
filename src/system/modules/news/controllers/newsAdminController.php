<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * newsAdminController: контроллер для метода admin модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */

class newsAdminController extends simpleController
{
    protected function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $path = $this->request->getString('params');

        if (empty($path)) {
            $path = 'root';
        }

        $newsFolder = $newsFolderMapper->searchByPath($path);
        if (empty($newsFolder)) {
            return $this->forward404($newsFolderMapper);
        }

        $breadCrumbs = $newsFolder->getTreeParentBranch();

        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $this->setPager($newsMapper);

        $this->view->assign('news', $newsMapper->searchByFolder($newsFolder->getId()));
        $this->view->assign('newsFolder', $newsFolder);
        $this->view->assign('breadCrumbs', $breadCrumbs);

        return $this->render('news/admin.tpl');
    }
}

?>