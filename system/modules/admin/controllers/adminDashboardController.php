<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * adminDashboardController
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDashboardController extends simpleController
{
    protected function getView()
    {
        return $this->render('admin/dashboard.tpl');
    }
}

?>