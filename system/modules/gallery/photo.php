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
 * photo: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class photo extends simple
{
    protected $name = 'gallery';

    public function getFile()
    {
        static $folder_id = 0;

        if (!$folder_id) {
            // @todo: ����������� � ������� � fm
            $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder', 'fileManager');
            $folder = $folderMapper->searchOneByField('path', 'root/gallery');
            $folder_id = $folder->getId();
        }

        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file', 'fileManager');

        $criteria = new criteria();
        $criteria->add('name', $this->getId() . '.%', criteria::LIKE)->add('folder_id', $folder_id);

        $file = $fileMapper->searchOneByCriteria($criteria);

        return $file;
    }
}

?>