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
        $fileMapper = $this->getFileMapper();
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
        $fileMapper = $this->getFileMapper();

        $criteria = new criteria();
        $criteria->add('name', $this->getId() . '.%', criteria::LIKE)->add('folder_id', $folder_id);

        $file = $fileMapper->searchOneByCriteria($criteria);

        return $file;
    }

    public function getFileMapper()
    {
        $config = systemToolkit::getInstance()->getConfig('gallery', $this->section);
        return systemToolkit::getInstance()->getMapper('fileManager', 'file', $config->get('filemanager_section'));
    }
}

?>