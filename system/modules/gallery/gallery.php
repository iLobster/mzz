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
 * gallery: класс для работы c данными
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class gallery extends simple
{
    protected $name = 'gallery';

    public function getAlbums()
    {
        $criteria = new criteria;
        $criteria->add('gallery_id', $this->getId());

        $albumMapper = systemToolkit::getInstance()->getMapper('gallery', 'album');
        return $albumMapper->searchAllByField('gallery_id', $this->getId());
    }

    public function getJip()
    {
        return $this->getJipView($this->name, $this->getOwner()->getLogin(), get_class($this));
    }
}

?>