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
 * gallerySavePhotoController: ���������� ��� ������ savePhoto ������ gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class gallerySavePhotoController extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('gallery/savePhoto.tpl');
    }
}

?>