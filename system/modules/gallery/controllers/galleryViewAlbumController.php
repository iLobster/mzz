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
 * galleryViewAlbumController: контроллер для метода viewAlbum модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryViewAlbumController extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('gallery/viewAlbum.tpl');
    }
}

?>