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
 * fileManagerListController: контроллер для метода list модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerListController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $name = $this->request->getString('name');

        $folder = $folderMapper->searchByPath($name);

        if ($folder) {
            $breadCrumbs = $folder->getTreeParentBranch();
            $this->view->assign('breadCrumbs', $breadCrumbs);

            $config = $this->toolkit->getConfig('fileManager');
            $pager = $this->setPager($fileMapper, $config->get('items_per_page'));
            $this->view->assign('current_folder', $folder);
            $this->view->assign('files', $fileMapper->searchByFolder($folder->getId()));
            return $this->view->render('fileManager/list.tpl');
        }

        return $this->forward404($folderMapper);
    }
}

?>