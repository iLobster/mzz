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
 * pageAdminController: контроллер для метода admin модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */

class pageAdminController extends simpleController
{
    protected function getView()
    {
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $path = $this->request->getString('params');

        if (empty($path)) {
            $path = 'root';
        }

        $pageFolder = $pageFolderMapper->searchByPath($path);
        if ($pageFolder) {
            $breadCrumbs = $pageFolder->getTreeParentBranch();
            
            $locale = new fLocale(systemConfig::$i18n);
            $old_lang = $pageMapper->detach('i18n');
            $pages = $pageMapper->searchByFolder($pageFolder->getId());
            $pageMapper->plugins('i18n');

            $pager = $this->setPager($pageMapper);
            $this->view->assign('section_name', $this->request->getString('section_name'));
            $this->view->assign('pages', $pages);
            $this->view->assign('breadCrumbs', $breadCrumbs);
            $this->view->assign('pageFolder', $pageFolder);
            return $this->render('page/admin.tpl');
        }

        return $this->forward404($pageFolderMapper);
    }
}

?>