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
 * menuSaveController: контроллер для метода save модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuSaveController extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('menu/save.tpl');
    }
}

?>