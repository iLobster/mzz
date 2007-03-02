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

fileLoader::load('admin/views/adminAddCfgForm');

/**
 * adminEditCfgController: контроллер для метода editCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminEditCfgController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $name = $this->request->get('name', 'string', SC_PATH);
        $action = $this->request->getAction();

        $isEdit = ($action == 'editCfg');

        $db = DB::factory();

        $module = $db->getRow($qry = 'SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
        $config = new config('', $module['name']);
        $params = $config->getDefaultValues();

        if (!isset($params[$name]) && $isEdit) {
            return 'выбранного параметра в конфигурации не существует';
        }

        $form = adminAddCfgForm::getForm($name, $id, $action, !$isEdit ? '' : $params[$name]);

        if ($form->validate()) {
            $values = $form->exportValues();

            $cfg_id = $db->getOne('SELECT `id` FROM `sys_cfg` WHERE `module` = ' . $id . ' AND `section` = 0');

            if ($isEdit) {
                if ($values['param'] != $name) {
                    $stmt = $db->query('SELECT `id` FROM `sys_cfg` WHERE `module` = ' . $id);
                    $ids = '';
                    while ($row = $stmt->fetch()) {
                        $ids .= $row['id'] . ', ';
                    }
                    $ids = substr($ids, 0, -2);

                    $db->query('UPDATE `sys_cfg_values` SET `name` = ' . $db->quote($values['param']) . ' WHERE `cfg_id` IN (' . $ids . ') AND `name` = ' . $db->quote($name));
                }

                $db->query('UPDATE `sys_cfg_values` SET `value` = ' . $db->quote($values['value']) . ' WHERE `cfg_id` = ' . $cfg_id . ' AND `name` = ' . $db->quote($values['param']));
            } else {
                $db->query('INSERT INTO `sys_cfg_values` (`cfg_id`, `name`, `value`) VALUES (' . $cfg_id . ', ' . $db->quote($values['param']) . ', ' . $db->quote($values['value']) . ')');
            }

            return jipTools::closeWindow();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);
        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/editCfg.tpl');
    }
}

?>