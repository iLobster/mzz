<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * newsDeleteFolderController: контроллер для метода delete модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */
class newsDeleteFolderController extends simpleController
{
    protected function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $name = $this->request->getString('name');

        $folder = $newsFolderMapper->searchByPath($name);

        if (!$folder) {
            return $this->forward404($newsFolderMapper);
        }

        $newsFolderMapper->delete($folder);

        return jipTools::redirect();
    }
}

?>