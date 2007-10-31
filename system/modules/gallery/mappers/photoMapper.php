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

fileLoader::load('gallery/photo');

/**
 * photoMapper: ������
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class photoMapper extends simpleMapper
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
    protected $className = 'photo';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByAlbum($id)
    {
        $criteria = new criteria();
        //$criteria->addSelectField(new sqlFunction('count', '*', true), 'cnt');
        $criteria->add('album_id', $id);
        return $this->searchAllByCriteria($criteria);
    }

    public function searchLastByGallery($gallery)
    {
        $config = systemToolkit::getInstance()->getConfig('gallery');
        $number = $config->get('last_photo_number');
        $galleryMapper = systemToolkit::getInstance()->getMapper('gallery', 'gallery', $this->section);
        $albumMapper = systemToolkit::getInstance()->getMapper('gallery', 'album', $this->section);

        $criteria = new criteria();
        //$criteria->addJoin($albumMapper->getTable(), new criterion('a.' . $albumMapper->getTableKey(), 'photo.album_id', criteria::EQUAL, true), 'a', criteria::JOIN_INNER);
        $criteria->addJoin($galleryMapper->getTable(), new criterion('g.id', 'album_id.gallery_id', criteria::EQUAL, true), 'g', criteria::JOIN_INNER);
        $criteria->setLimit($number);
        $criteria->setOrderByFieldDesc('photo.id');

        return $this->searchAllByCriteria($criteria);
    }

    public function delete(photo $do)
    {
        $fileMapper = $do->getFileMapper();
        $file = $do->getFile();
        $thumbnail = $do->getThumbnail();
        if ($thumbnail) {
            $fileMapper->delete($thumbnail);
        }
        if ($file) {
            $fileMapper->delete($file);
        }
        parent::delete($do->getId());
    }

    public function convertArgsToObj($args)
    {
        $item = $this->searchOneByField('id', $args['id']);
        if ($item) {
            return $item;
        }

        throw new mzzDONotFoundException();
    }
}

?>