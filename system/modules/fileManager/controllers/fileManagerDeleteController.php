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
 * fileManagerDeleteController: контроллер для метода delete модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */

class fileManagerDeleteController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');
        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $this->forward404($fileMapper);
        }

        $fileMapper->delete($file);

        return jipTools::redirect();
    }
}

?>