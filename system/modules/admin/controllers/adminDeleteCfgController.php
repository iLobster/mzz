<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * adminDeleteCfgController: контроллер для метода deleteCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */

class adminDeleteCfgController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $name = $this->request->getString('name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $module = $adminMapper->searchModuleById($id);

        $config = new config($module['name']);
        $params = $config->getValues();

        if (!isset($params[$name])) {
            return 'Выбранного параметра в конфигурации не существует';
        }

        $config->delete($name);

        return jipTools::closeWindow();
    }
}

?>