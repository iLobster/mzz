<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * newsDeleteFolderController: контроллер для метода delete модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */


class newsDeleteFolderController extends simpleController
{
    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $name = $this->request->get('name', 'string', SC_PATH);

        $folder = $newsFolderMapper->searchByPath($name);

        $newsFolderMapper->remove($folder->getParent());

        return jipTools::redirect();
    }
}

?>