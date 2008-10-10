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
 * catalogueDeleteFolderController: контроллер для метода deleteFolder модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueDeleteFolderController extends simpleController
{
    protected function getView()
    {
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $name = $this->request->getString('name');

        $folder = $catalogueFolderMapper->searchByPath($name);

        if (!$folder) {
            return $catalogueFolderMapper->get404()->run();
        }

        $treeFields = $folder->exportTreeFields();
        if ($treeFields['lkey'] == 1) {
            $controller = new messageController('root каталог не может быть удален', messageController::INFO);
            return $controller->run();
        }

        $catalogueFolderMapper->delete($folder);
        return jipTools::redirect();
    }
}

?>