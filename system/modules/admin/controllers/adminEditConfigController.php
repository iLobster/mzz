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

        $name = $this->request->get('name', 'string');
        $configMapper = $this->toolkit->getMapper('config', 'config', 'config');

        $type = $configMapper->searchTypeByName($module_name);

        if (!$type) {
            return 'для этого модуля конфиг отсутствует';
        }

        $config = $configMapper->searchBySection($type['id'], $section_name);

        if (!$config) {
            $properties = $configMapper->getProperties($type['id']);
        } else {
            $properties = $config->exportOldProperties();
        }

        $validator = new formValidator();

        if ($validator->validate()) {
            if (!$config) {
                $config = $configMapper->create();
                $config->setType($type['id']);
                $config->setName($section_name);
                $configMapper->save($config);
            }

            $cfg = $this->request->get('config', 'array', SC_POST);

            foreach ($cfg as $key => $value) {
                $config->setProperty($key, $value);
            }

            $configMapper->save($config);

            return jipTools::redirect();
        }

        $this->smarty->assign('properties', $properties);
        $this->smarty->assign('section', $section_name);
        $this->smarty->assign('module', $module_name);
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('admin/editConfig.tpl');
    }
}

?>