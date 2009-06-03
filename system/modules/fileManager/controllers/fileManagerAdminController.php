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
        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $path = $this->request->getString('params');

        if (!$path) {
            $path = 'root';
        }

        $folder = $folderMapper->searchByPath($path);

        if ($folder) {
            $breadCrumbs = $folder->getTreeParentBranch();
            $this->smarty->assign('breadCrumbs', $breadCrumbs);

            $pager = $this->setPager($fileMapper);
            $this->smarty->assign('current_folder', $folder);
            return $this->smarty->fetch('fileManager/admin.tpl');
        }

        return $this->forward404($folderMapper);
    }
}

?>