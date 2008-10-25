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
 * catalogueAdminController: контроллер для метода edit модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueAdminController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $path = $this->request->getString('params', SC_PATH);

        if (is_null($path)) {
            $path = 'root';
        }

        $catalogueFolder = $catalogueFolderMapper->searchByPath($path);

        if (!$catalogueFolder) {
            return $catalogueFolderMapper->get404()->run();
        }

        $chain = $catalogueFolderMapper->getParentBranch($catalogueFolder);
        $this->smarty->assign('chains', $chain);

        $pager = $this->setPager($catalogueFolder);

        $types = $catalogueMapper->getAllTypes();
        $this->smarty->assign('types', $types);

        $this->smarty->assign('items', $catalogueFolder->getItems());
        $this->smarty->assign('catalogueFolder', $catalogueFolder);
        return $this->smarty->fetch('catalogue/admin.tpl');
    }
}

?>