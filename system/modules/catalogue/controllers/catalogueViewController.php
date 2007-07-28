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
 * catalogueViewController: контроллер для метода view модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueViewController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $id = $this->request->get('id', 'integer', SC_PATH);
        $item = $catalogueMapper->searchById($id);

        if (!$item) {
            return $catalogueMapper->get404()->run();
        }

        $catalogueFolder = $item->getFolder();

        $this->smarty->assign('catalogue', $item);
        $this->smarty->assign('folderPath', $catalogueFolder->getPath());
        $this->smarty->assign('catalogueFolder', $catalogueFolder);
        $this->smarty->assign('folders', $catalogueFolderMapper->getTreeForMenu($catalogueFolder));

        $chain = $catalogueFolderMapper->getParentBranch($catalogueFolder);
        $chain[] = $item;

        $this->smarty->assign('chains', $chain);
        return $this->smarty->fetch('catalogue/view.tpl');
    }
}

?>