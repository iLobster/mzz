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
 * adminConfigController: контроллер для метода config модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminConfigController extends simpleController
{
    protected function getView()
    {
        $module_name = $this->request->getString('name');
        $module = $this->toolkit->getModule($module_name);

        if ($module->isEnabled()) {
            $config = $this->toolkit->getConfig($module_name);
            $data = $config->export();
            
            $this->smarty->assign('config_data', $data);
            $this->smarty->assign('module_name', $module_name);
            return $this->smarty->fetch('admin/config.tpl');
        }

        return 'disabled';
    }
}
?>
