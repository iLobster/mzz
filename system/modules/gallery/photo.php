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
 * @version 0.1.1
 */

class photo extends simple
{
    protected $name = 'gallery';

    public function getThumbnail()
    {
        $folder_id = systemToolkit::getInstance()->getMapper('gallery', 'gallery')->getThumbFolderId();
        return $this->getFromFM($folder_id);
    }

    public function getFile()
    {
        $folder_id = systemToolkit::getInstance()->getMapper('gallery', 'gallery')->getFolderId();
        return $this->getFromFM($folder_id);
    }

    protected function getFromFM($folder_id)
    {
        $fileMapper = $this->getFileMapper();

        $criteria = new criteria();
        $criteria->add('name', $this->getId() . '.%', criteria::LIKE)->add('folder_id', $folder_id);

        return $fileMapper->searchOneByCriteria($criteria);
    }

    public function getFileMapper()
    {
        $config = systemToolkit::getInstance()->getConfig('gallery', $this->section);
        return systemToolkit::getInstance()->getMapper('fileManager', 'file', $config->get('filemanager_section'));
    }

    public function setName($name)
    {
        // @todo подумать, такое решение неудобно тем, что перед setName() обязательно надо делать save()
        parent::__call('setName', array($name));
        $file = $this->getFile();
        $fileMapper = $this->getFileMapper();
        $file->setAbout($name);
        $fileMapper->save($file);
    }
}

?>