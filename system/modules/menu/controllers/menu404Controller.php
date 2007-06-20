<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * menu404Controller: контроллер для метода 404 модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menu404Controller extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('menu/notfound.tpl');
    }
}

?>