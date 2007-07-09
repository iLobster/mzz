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
 * fileManagerDeleteFolderController: ���������� ��� ������ deleteFolder ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerDeleteFolderController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);

        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $folder = $folderMapper->searchByPath($name);

        if (!$folder) {
            return '������� �� ������';
        }

        $folderMapper->remove($folder);

        return jipTools::redirect();
    }
}

?>