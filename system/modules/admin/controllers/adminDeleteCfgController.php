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
 * @version 0.1
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

        if (!isset($params[$name]) && $isEdit) {
            return 'выбранного параметра в конфигурации не существует';
        }

        $stmt = $db->query('SELECT `id` FROM `sys_cfg` WHERE `module` = ' . $id);
        $ids = '';
        while ($row = $stmt->fetch()) {
            $ids .= $row['id'] . ', ';
        }
        $ids = substr($ids, 0, -2);

        $db->query('DELETE FROM `sys_cfg_values` WHERE `cfg_id` IN (' . $ids . ') AND `name` = ' . $db->quote($name));

        return jipTools::closeWindow(2);
    }
}

?>