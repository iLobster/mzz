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
        //$module = $this->toolkit->getModule($module_name);
        $config = $this->toolkit->getConfig($module_name);

        if ($config) {
            $validator = new formValidator();

            if ($validator->validate()) {
                $config->import($this->request->getArray('config', SC_POST), true);
                $config->save();
                return jipTools::refresh();
            }

            $data = $config->exportRaw();
            
            $url = new url('adminModule');
            $url->add('name', $module_name);
            $url->setAction('config');

            $this->view->assign('form_action', $url->get());
            $this->view->assign('config_data', $data);
            $this->view->assign('module_name', $module_name);
            return $this->render('admin/config.tpl');
        }

        return 'disabled';
    }
}
?>
