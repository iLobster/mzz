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
 * pageDeleteFolderController: контроллер для метода deleteFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageDeleteFolderController extends simpleController
{
    protected function getView()
    {
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $name = $this->request->getString('name');

        $folder = $pageFolderMapper->searchByPath($name);

        if (!$folder) {
            return $pageFolderMapper->get404()->run();
        }

        $pageFolderMapper->delete($folder);

        return jipTools::redirect();
    }
}

?>