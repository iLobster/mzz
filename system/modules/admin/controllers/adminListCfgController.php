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
        $id = $this->request->get('id', 'string', SC_PATH);

        $db = DB::factory();
        $data = $db->getRow($qry = 'SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
        if (!$data) {
            return 'Запрашиваемый вами модуль не найден';
        }

        $cfg_id = $db->getOne('SELECT `id` FROM `sys_cfg` WHERE `module` = ' . $id . ' AND `section` = 0');
        if (is_null($cfg_id)) {
            $db->query('INSERT INTO `sys_cfg` (`section`, `module`) VALUES (0, ' . $id . ')');
        }

        $config = new config('', $data['name']);
        $params = $config->getDefaultValues();

        $this->smarty->assign('data', $data);
        $this->smarty->assign('params', $params);

        return $this->smarty->fetch('admin/listCfg.tpl');
    }
}

?>