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
 * albumMapper: маппер
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class albumMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'gallery';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'album';

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * Выполняет поиск объекта по идентификатору галереи
     *
     * @param integer $gallery_id идентификатор галереи
     * @return object|null
     */
    public function searchByGalleryId($gallery_id)
    {
        return $this->searchOneByField('gallery_id', $gallery_id);
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['created'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * Возвращает самую популярную (скачиваемую) фотографию из альбома
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
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
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