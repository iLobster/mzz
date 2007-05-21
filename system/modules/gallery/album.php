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
 * @version 0.1
 */

class album extends simple
{
    protected $name = 'gallery';

    public function getBestPhoto()
    {
        $albumMapper = systemToolkit::getInstance()->getMapper('gallery', 'album', $this->section());
        return $albumMapper->getBestPhoto($this);
    }
}

?>