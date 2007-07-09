<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * galleryAdminController: контроллер для метода admin модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryAdminController extends simpleController
{
    public function getView()
    {
        $galleryMapper = $this->toolkit->getMapper('gallery', 'gallery');
        $galleries = $galleryMapper->searchAll();

        $this->smarty->assign('galleries', $galleries);
        return $this->smarty->fetch('gallery/admin.tpl');
    }
}

?>