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

fileLoader::load('admin/forms/adminAddCfgForm');

/**
 * adminEditCfgController: контроллер дл€ метода editCfg модул€ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
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
            $controller = new messageController('¬ыбранного параметра в конфигурации не существует', messageController::WARNING);
            return $controller->run();
        }

        $form = adminAddCfgForm::getForm($name, $id, $action, !$isEdit ? '' : $params[$name], !$isEdit ? '' : $config->getTitle($name));

        if ($form->validate()) {
            $values = $form->exportValues();

            if ($isEdit) {
                $config->update($name, $values['param'], $values['value'], $values['title']);
            } else {
                $config->create($values['param'], $values['value'], $values['title']);
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