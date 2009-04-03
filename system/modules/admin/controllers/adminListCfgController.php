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
 * adminListCfgController: контроллер для метода listCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminListCfgController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $data = $adminMapper->searchModuleById($id);

        if (!$data) {
            return 'Запрашиваемый Вами модуль не найден';
        }

        $config = new config($data['name']);
        $params = $config->getValues();

        $this->smarty->assign('data', $data);
        $this->smarty->assign('params', $params);

        return $this->smarty->fetch('admin/listCfg.tpl');
    }
}

?>