<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * fileManagerBrowseController: контроллер для метода browse модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerBrowseController extends simpleController
{
    public function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->getString('params');

        $folder = $folderMapper->searchByPath($path);

        if ($folder) {
            $this->smarty->assign('files', $folder->getItems());
            return $this->smarty->fetch('fileManager/browse.tpl');
        }

        return $folderMapper->get404()->run();
    }
}

?>