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
        $path = $this->request->getString('path');

        $folder = $folderMapper->searchByPath($path);

        if ($folder) {
            $breadCrumbs = $folderMapper->getParentBranch($folder);
            $this->smarty->assign('breadCrumbs', $breadCrumbs);

            $config = $this->toolkit->getConfig('fileManager');
            $pager = $this->setPager($folder, $config->get('items_per_page'));
            $this->smarty->assign('current_folder', $folder);
            $this->smarty->assign('files', $folder->getItems());
            return $this->smarty->fetch('fileManager/list.tpl');
        }

        return $folderMapper->get404()->run();
    }
}

?>