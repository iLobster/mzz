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
 * fileManagerDeleteController: ���������� ��� ������ delete ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */

class fileManagerDeleteController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);
        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return '���� �� ������';
        }

        $fileMapper->delete($file->getId());

        $path = substr($name, 0, strrpos($name, '/'));

        return jipTools::redirect();
    }
}

?>