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
 * @version 0.2
 */

class fileManagerAdminController extends simpleController
{
    public function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $folderMapper->searchByPath($path);
        if ($folder) {
            $this->smarty->assign('current_folder', $folder);
            $this->smarty->assign('folders', $folderMapper->getTree());
            $this->smarty->assign('files', $folder->getItems());
            return $this->smarty->fetch('fileManager/admin.tpl');
        }

        return $folderMapper->get404()->run();
    }
}

?>