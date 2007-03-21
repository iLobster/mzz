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
 * adminDeleteCfgController: ���������� ��� ������ deleteCfg ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */

class adminDeleteCfgController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $name = $this->request->get('name', 'string', SC_PATH);

        $db = DB::factory();

        $module = $db->getRow($qry = 'SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
        $config = new config('', $module['name']);
        $params = $config->getDefaultValues();

        if (!isset($params[$name])) {
            return '���������� ��������� � ������������ �� ����������';
        }

        $config->delete($name);

        return jipTools::closeWindow(2);
    }
}

?>