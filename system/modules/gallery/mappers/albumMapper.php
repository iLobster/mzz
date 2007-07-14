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

fileLoader::load('gallery/album');

/**
 * albumMapper: ������
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class albumMapper extends simpleMapper
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
    protected $className = 'album';

    /**
     * ��������� ����� ������� �� ��������������
     *
     * @param integer $id �������������
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * ��������� ����� ������� �� �������������� �������
     *
     * @param integer $gallery_id ������������� �������
     * @return object|null
     */
    public function searchByGalleryId($gallery_id)
    {
        return $this->searchOneByField('gallery_id', $gallery_id);
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['created'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * ���������� ����� ���������� (�����������) ���������� �� �������
     *
     * @param album $album DO
     * @return array|null
     */
    public function getBestPhoto($album)
    {
        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file', 'fileManager');
        $photoMapper = systemToolkit::getInstance()->getMapper('gallery', 'photo', $this->section);

        $folder_id = systemToolkit::getInstance()->getMapper('gallery', 'gallery')->getFolderId();
        $criteria = new criteria();

        $criteria->add('album_id', $album->getId());

        $criterion = new criterion('f.name', new sqlFunction('CONCAT', array('photo.id' => true, '.%')), criteria::LIKE);
        $criterion->addAnd(new criterion('f.folder_id', $folder_id));
        $criteria->addJoin($fileMapper->getTable(), $criterion, 'f', criteria::JOIN_INNER);
        $criteria->setOrderByFieldDesc('f.downloads');
        $criteria->setLimit(1);

        return $photoMapper->searchOneByCriteria($criteria);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        $action = systemToolkit::getInstance()->getRequest()->getAction();
        return (int)$this->searchById(($action == 'viewAlbum') ? $args['album'] : $args['id'])->getObjId();
    }
}

?>