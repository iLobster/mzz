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

        $newsFolder = $newsFolderMapper->searchByPath($path);
        if (empty($newsFolder)) {
            return $newsFolderMapper->get404()->run();
        }

        $breadCrumbs = $newsFolderMapper->getParentBranch($newsFolder);

        $pager = $this->setPager($newsFolder);

        $this->smarty->assign('section_name', $this->request->getString('section_name'));
        $this->smarty->assign('news', $newsFolder->getItems());
        $this->smarty->assign('newsFolder', $newsFolder);
        $this->smarty->assign('breadCrumbs', $breadCrumbs);

        return $this->smarty->fetch('news/admin.tpl');
    }
}

?>