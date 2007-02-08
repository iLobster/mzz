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
 * fileManagerGetController: ���������� ��� ������ get ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerGetController extends simpleController
{
    public function getView()
    {
        fileLoader::load('libs/PEAR/Download');

        $name = $this->request->get('name', 'string', SC_PATH);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return '���� �� ������';
        }

        $params = array(
        'file' => $file->getRealFullPath(),
        );

        $dl = new HTTP_Download;
        $dl->setParams($params);
        $dl->setCache(false);
        $dl->setContentDisposition(HTTP_DOWNLOAD_ATTACHMENT, $file->getName());
        $dl->send();
    }
}

?>