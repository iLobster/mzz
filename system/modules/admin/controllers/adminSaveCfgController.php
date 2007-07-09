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
 * @version 0.2
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

        $module = $db->getRow($qry = 'SELECT * FROM `sys_modules` WHERE `id` = ' . (int)$id);
        $config = new config('', $module['name']);
        $params = $config->getDefaultValues();

        if (empty($module) || ($isEdit && (!isset($params[$name])))) {
            $controller = new messageController('Выбранного параметра в конфигурации или модуля не существует', messageController::WARNING);
            return $controller->run();
        }

        $configInfo = array();
        $configInfo['param'] = $isEdit ? $name : '';
        $configInfo['value'] = $isEdit ? $params[$name] : '';
        $configInfo['title'] = $isEdit ? $config->getTitle($name) : '';

        $validator = new formValidator();

        $validator->add('required', 'param', 'Необходимо указать имя параметра');
        $validator->add('regex', 'param', 'Недопустимые символы в имени параметра', '/^[a-z0-9_\-]+$/i');
        $validator->add('callback', 'param', 'Такой параметр уже есть у этого модуля', array('checkParamNotExists', $name, $params));

        if ($validator->validate()) {
            $param = $this->request->get('param', 'string', SC_POST);
            $value = $this->request->get('value', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);

            if ($isEdit) {
                $config->update($name, $param, $value, $title);
            } else {
                $config->create($param, $value, $title);
            }

            return jipTools::closeWindow();
        }

        if ($isEdit) {
            $url = new url('adminCfgEdit');
            $url->addParam('name', $name);
        } else {
            $url = new url('withId');
            $url->setSection('admin');
        }
        $url->setAction($action);
        $url->addParam('id', $id);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('configInfo', $configInfo);
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/saveCfg.tpl');
    }
}

function checkParamNotExists($param, $name, $params)
{
    if ($param == $name) {
        return true;
    }

    return !isset($params[$param]);
}
?>