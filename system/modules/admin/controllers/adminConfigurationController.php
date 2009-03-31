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
 * adminConfigurationController: контроллер для метода configuration модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminConfigurationController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $this->smarty->assign('info', $adminMapper->getInfo());
        $this->smarty->assign('title', 'Панель управления');
        return $this->smarty->fetch('admin/configuration.tpl');
    }
}

?>