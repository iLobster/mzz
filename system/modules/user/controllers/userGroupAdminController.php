<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * userGroupAdminController: контроллер для метода groupAdmin модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userGroupAdminController extends simpleController
{
    protected function getView()
    {
        return $this->smarty->fetch('user/groupAdmin.tpl');
    }
}

?>