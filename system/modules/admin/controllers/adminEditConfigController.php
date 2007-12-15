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

fileLoader::load('forms/validators/formValidator');

/**
 * adminEditConfigController: контроллер для метода editConfig модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminEditConfigController extends simpleController
{
    public function getView()
    {
        $module_name = $this->request->get('module_name', 'string', SC_PATH);
        $section_name = $this->request->get('section_name', 'string', SC_PATH);

        $validator = new formValidator();

        $config = $this->toolkit->getConfig($module_name, $section_name);
        $values = $config->getValues();

        foreach ($values as $name => $value) {
            switch ($value['type']['name']) {
                case 'int':
                    $validator->add('numeric', 'config[' . $name . ']', 'Только целочисленные значения');
                    break;
            }
        }

        if ($validator->validate() /*$this->request->getMethod() == 'POST'*/) {
            $cfg = $this->request->get('config', 'array', SC_POST);
            $config = $this->toolkit->getConfig($section_name, $module_name);
            $config->set($cfg);

            return jipTools::closeWindow();
        }

        $this->smarty->assign('configs', $values);
        $this->smarty->assign('section', $section_name);
        $this->smarty->assign('module', $module_name);
        $this->smarty->assign('errors', $validator->getErrors());

        return $this->smarty->fetch('admin/editConfig.tpl');
    }
}

?>