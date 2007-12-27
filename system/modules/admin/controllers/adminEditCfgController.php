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

fileLoader::load('forms/validators/formValidator');

/**
 * adminSaveCfgController: контроллер для метода SaveCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */

class adminSaveCfgController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $name = $this->request->get('name', 'string', SC_PATH);
        $action = $this->request->getAction();
        $isEdit = ($action == 'editCfg');

        $db = DB::factory();

        $module = $db->getRow($qry = 'SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
        $config = new config('', $module['name']);
        $params = $config->getDefaultValues();

        if ($isEdit && !isset($params[$name])) {
            $controller = new messageController('Выбранного параметра в конфигурации не существует', messageController::WARNING);
            return $controller->run();
        }

        $configInfo = array();
        $configInfo['name'] = $name;
        $configInfo['value'] = $isEdit ? $params[$name] : '';
        $configInfo['title'] = $config->getTitle($name);

        $validator = new formValidator();

        $validator->add('required', 'param', 'Необходимо указать имя параметра');
        $validator->add('regex', 'param', 'Недопустимые символы в имени параметра', '/^[a-z0-9_\-]+$/i');

        if ($validator->validate()) {
            /*$values = $form->exportValues();

            if ($isEdit) {
                $config->update($name, $values['param'], $values['value'], $values['title']);
            } else {
                $config->create($values['param'], $values['value'], $values['title']);
            }

            return jipTools::closeWindow();*/
        }



        if ($isEdit) {
            $url = new url('adminCfgEdit');
            $url->add('name', $name);
        } else {
            $url = new url('withId');
            $url->setSection('admin');
        }
        $url->setAction($action);
        $url->add('id', $module);

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('configInfo', $configInfo);
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/saveCfg.tpl');
    }
}

?>