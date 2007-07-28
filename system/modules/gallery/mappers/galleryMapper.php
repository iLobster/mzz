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

fileLoader::load('gallery');

/**
 * galleryMapper: ������
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'gallery';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'gallery';

    /**
     * ��������� ����� ������� �� ���������
     *
     * @param integer $owner ������������� ���������
     * @return object|null
     */
    public function searchByOwner($owner)
    {
        return $this->searchOneByField('owner', $owner);
    }

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['created'] = new sqlFunction('UNIX_TIMESTAMP');
        $fields['updated'] = $fields['created'];
    }

    public function getFolderId()
    {
        static $folder_id = 0;

        if (!$folder_id) {
            $config = systemToolkit::getInstance()->getConfig('gallery', $this->section);
            $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder', $config->get('filemanager_section'));
            $folder = $folderMapper->searchOneByField('path', 'root/gallery');
            $folder_id = $folder->getId();
        }

        return $folder_id;
    }

    public function getThumbFolderId()
    {
        static $thumb_folder_id = 0;

        if (!$thumb_folder_id) {
            $config = systemToolkit::getInstance()->getConfig('gallery', $this->section);
            $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder', $config->get('filemanager_section'));
            $folder = $folderMapper->searchOneByField('path', 'root/gallery/thumbnails');
            $thumb_folder_id = $folder->getId();
        }

        return $thumb_folder_id;
    }

    public function convertArgsToObj($args)
    {
        $gallery = $this->searchOneByField('owner.login', $args['name']);

        if ($gallery) {
            return $gallery;
        }

        throw new mzzDONotFoundException();
    }
}

?>