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
 * configAdminController: контроллер для метода admin модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configAdminController extends simpleController
{
    protected function getView()
    {
        $configFolderMapper = $this->toolkit->getMapper('config', 'configFolder');
        $folders = $configFolderMapper->searchAllWithOptions();

        $this->smarty->assign('folders', $folders);
        return $this->smarty->fetch('config/admin.tpl');
    }
}

?>