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
 * messageCategory: класс для работы c данными
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageCategory extends entity
{
    protected $name = 'message';

    public function getAcl($name = null)
    {
        return systemToolkit::getInstance()->getUser()->isLoggedIn();
    }
}

?>