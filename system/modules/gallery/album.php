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
 * album: класс для работы c данными
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1.2
 */

class album extends simple
{
    protected $name = 'gallery';

    public function getBestPhoto()
    {
        $albumMapper = systemToolkit::getInstance()->getMapper('gallery', 'album', $this->section());
        return $albumMapper->getBestPhoto($this);
    }

    public function getMainPhoto($real_data = false)
    {
        $photo = parent::__call('getMainPhoto', array());

        if (!$real_data && !$photo->getId()) {
            return $this->getBestPhoto();
        }

        return $photo;
    }

    public function getPhotos()
    {
        $photoMapper = systemToolkit::getInstance()->getMapper('gallery', 'photo');
        return $photoMapper->searchByAlbum($this->getId());
    }
}

?>