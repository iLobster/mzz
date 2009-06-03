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
 * fileManagerAdminController: контроллер для метода admin модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2.1
 */

class fileManagerAdminController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->getString('params');

        if (!$path) {
            $path = 'root';
        }

        $folder = $folderMapper->searchByPath($path);

        if (!$folder) {
            return $this->forward404($folderMapper);
        }

        $breadCrumbs = $folder->getTreeParentBranch();
        $this->setPager($folderMapper);

        $this->smarty->assign('breadCrumbs', $breadCrumbs);
        $this->smarty->assign('current_folder', $folder);
        $this->smarty->assign('files', $folderMapper->getItems($folder));

        return $this->smarty->fetch('fileManager/admin.tpl');
    }
}

?>