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
        $id = $this->request->getInteger('id');
        $name = $this->request->getString('name');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editCfg');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $module = $adminMapper->searchModuleById($id);
        $config = new config($module['name']);
        $params = $config->getValues();

        if (empty($module) || ($isEdit && (!isset($params[$name])))) {
            $controller = new messageController('Выбранного параметра в конфигурации нет или модуля не существует', messageController::WARNING);
            return $controller->run();
        }

        $configInfo = array();
        $configInfo['param'] = $isEdit ? $name : '';
        $configInfo['value'] = $isEdit ? $params[$name]['value'] : '';
        $configInfo['title'] = $isEdit ? $config->getTitle($name) : '';
        $configInfo['type'] = $isEdit ? $params[$name]['type'] : array(
            'id' => 0);

        $types_tmp = $config->getTypes();
        $types = array();
        foreach ($types_tmp as $t) {
            $types[$t['id']] = $t['title'] . '(' . $t['name'] . ')';
        }

        $type = $this->request->getInteger('type', SC_POST);

        $validator = new formValidator();

        $validator->add('required', 'param', 'Необходимо указать имя параметра');
        $validator->add('required', 'type', 'Необходимо указать тип параметра');
        $validator->add('regex', 'param', 'Недопустимые символы в имени параметра', '/^[a-z0-9_\-]+$/i');
        $validator->add('callback', 'param', 'Такой параметр уже есть у этого модуля', array(
            array(
                $this,
                'checkParamNotExists'),
            $name,
            $params));
        $validator->add('callback', 'type', 'Неверный тип', array(
            array(
                $this,
                'checkIsset'),
            $types));

        if ($validator->validate()) {
            $param = $this->request->getString('param', SC_POST);
            $value = $this->request->getString('value', SC_POST);
            $title = $this->request->getString('title', SC_POST);

            if ($isEdit) {
                $config->update($name, $param, $value, $title, $type);
            } else {
                $config->create($param, $value, $title, $type);
            }

            return jipTools::closeWindow();
        }

        if ($isEdit) {
            $url = new url('adminCfgEdit');
            $url->add('name', $name);
        } else {
            $url = new url('withId');
            $url->setSection('admin');
        }
        $url->setAction($action);
        $url->add('id', $id);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('configInfo', $configInfo);
        $this->smarty->assign('types', $types);
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/saveCfg.tpl');
    }

    public function checkParamNotExists($param, $name, $params)
    {
        if ($param == $name) {
            return true;
        }

        return !isset($params[$param]);
    }

    public function checkIsset($param, $params)
    {
        return isset($params[$param]);
    }
}

?>