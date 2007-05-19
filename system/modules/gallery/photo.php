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
 * photo: класс дл€ работы c данными
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class photo extends simple
{
    protected $name = 'gallery';

    private static $folder_id = 0;

    public function getFile()
    {
        if (!self::$folder_id) {
            // @todo: разобратьс€ с секшном в fm
            $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder', 'fileManager');
            $folder = $folderMapper->searchOneByField('path', 'root/gallery');
            self::$folder_id = $folder->getId();
        }

        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file', 'fileManager');

        $criteria = new criteria();
        $criteria->add('name', $this->getId() . '.%', criteria::LIKE)->add('folder_id', self::$folder_id);

        $file = $fileMapper->searchOneByCriteria($criteria);

        return $file;
    }
}

?>