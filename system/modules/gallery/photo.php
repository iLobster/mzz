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
 * photo: класс для работы c данными
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class photo extends simple
{
    protected $name = 'gallery';

    public function getThumbnail()
    {
        //@todo: хардкод убрать нельзя оставить :)
        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file', 'fileManager');
        $thumbnail = $fileMapper->searchByPath('root/gallery/thumbnails/' . $this->getId() . '.jpg');
        if ($thumbnail) {
            return $thumbnail;
        } else {
            return null;
        }
    }

    public function getFile()
    {
        $folder_id = systemToolkit::getInstance()->getMapper('gallery', 'gallery')->getFolderId();
        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file', 'fileManager');

        $criteria = new criteria();
        $criteria->add('name', $this->getId() . '.%', criteria::LIKE)->add('folder_id', $folder_id);

        $file = $fileMapper->searchOneByCriteria($criteria);

        return $file;
    }
}

?>