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
    public function getView()
    {
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $path = $this->request->get('params', 'string', SC_PATH);

        if (is_null($path)) {
            $path = 'root';
        }

        $pageFolder = $pageFolderMapper->searchByPath($path);
        if ($pageFolder) {
            $breadCrumbs = $pageFolderMapper->getPath($pageFolder);

            $pager = $this->setPager($pageFolder, 'fileManager');
            $this->smarty->assign('section_name', $this->request->get('section_name', 'string', SC_PATH));
            $this->smarty->assign('pages', $pageFolder->getItems());
            $this->smarty->assign('pager', $pager);
            $this->smarty->assign('breadCrumbs', $breadCrumbs);
            $this->smarty->assign('pageFolder', $pageFolder);
            return $this->smarty->fetch('page/admin.tpl');
        }

        return $pageFolderMapper->get404()->run();
    }
}

?>