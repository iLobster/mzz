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

fileLoader::load('codegenerator/fileGenerator');
fileLoader::load('codegenerator/fileIniTransformer');
fileLoader::load('codegenerator/fileSearchReplaceTransformer');

/**
 * adminSaveActionController: контроллер для метода addAction|editAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminSaveActionController extends simpleController
{
    private $plugins = array();

    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $action = $this->request->getAction();
        $isEdit = ($action === 'editAction');

        $module_name = $this->request->getString('module_name');
        try {
            $module = $this->toolkit->getModule($module_name);
        } catch (mzzModuleNotFoundException $e) {
            return $this->forward404($adminMapper);
        }

        if ($isEdit) {
            $action_name = $this->request->getString('class_name');
            try {
                $actionObject = $module->getAction($action_name);
            } catch (mzzUnknownModuleActionException $e) {
                return $this->forward404($adminMapper);
            }

            $class_name = $actionObject->getClassName();
        } else {
            $class_name = $this->request->getString('class_name');
            $classes = $module->getClasses();
            if (!in_array($class_name, $classes)) {
                return $this->forward404($adminMapper);
            }

            $actionObject = new simpleAction('', $module->getName(), $class_name, '');
        }

        $dests = $adminGeneratorMapper->getDests(true, $module->getName());

        if (!sizeof($dests)) {
            $controller = new messageController($this->getAction(), i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $validator = new formValidator();

        if (!$isEdit) {
            $validator->add('required', 'action[name]', i18n::getMessage('action.error.name_required', 'admin'));
            $validator->add('regex', 'action[name]', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')), '#^[a-z0-9_-]+$#i');
            $validator->add('callback', 'action[name]', i18n::getMessage('action.error.unique', 'admin'), array(array($this, 'unique'), $module));
        }

        $validator->add('regex', 'action[main]', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-.')), '#^[a-z0-9_\-.]+$#i');
        $validator->add('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));

        if ($validator->validate()) {
            $values = $this->request->getArray('action', SC_POST);
            $dest = $this->request->getString('dest', SC_POST);

            if (!$isEdit) {
                $action_name = $values['name'];
                unset($values['name']);
            }

            try {
                $adminGeneratorMapper->saveAction($module, $class_name, $action_name, $values, $dests[$dest], $isEdit);
            } catch (Exception $e) {
                return $e->getMessage();
                //$controller = new messageController($this->getAction(), $e->getMessage(), messageController::WARNING);
                //return $controller->run();
            }

            return jipTools::closeWindow();
        }

        $this->smarty->assign('aclMethods', $this->getAclMethods());
        $this->smarty->assign('crudList', $this->getCRUDList());

        $url = new url('adminModuleEntity');
        $url->add('module_name', $module_name);
        $url->setAction($action);

        if ($isEdit) {
            $url->add('class_name', $action_name);
        } else {
            $url->add('class_name', $class_name);
        }

        $this->smarty->assign('plugins', $this->plugins);

        $this->smarty->assign('form_action', $url->get());

        $this->smarty->assign('dests', $dests);

        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('module', $module);
        $this->smarty->assign('actionObject', $actionObject);

        return $this->smarty->fetch('admin/saveAction.tpl');
    }

    private function crudView($module, $class, $action_name, $values, $fileGenerator)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        $map = $this->getMap($mapper);

        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $this->smarty->assign('map', $map);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.view.tpl'));
        $fileGenerator->create($this->templates($action_name), $this->smarty->fetch('admin/generator/template.view.tpl'));

        $fileGenerator->run();
    }

    private function crudDelete($module, $class, $action_name, & $values, $fileGenerator)
    {
        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.delete.tpl'));

        if (empty($values['jip'])) {
            $values['jip'] = true;
        }

        if (empty($values['confirm'])) {
            $values['confirm'] = '_ ' . $module['name'] . '/' . $class['name'] . '.delete.confirm';
        }

        if (empty($values['icon'])) {
            $values['icon'] = '/templates/images/delete.gif';
        }

        if (empty($values['main'])) {
            $values['main'] = 'active.blank.tpl';
        }

        $fileGenerator->run();
    }

    private function crudList($module, $class, $action_name, $values, $fileGenerator)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        $map = $this->getMap($mapper);

        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $this->smarty->assign('map', $map);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.list.tpl'));
        $fileGenerator->create($this->templates($action_name), $this->smarty->fetch('admin/generator/template.list.tpl'));

        $fileGenerator->run();
    }

    private function crudSave($module, $class, $action_name, $values, $fileGenerator)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        $map = $this->getMap($mapper);

        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $this->smarty->assign('map', $map);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.save.tpl'));
        $fileGenerator->create($this->templates($action_name), $this->smarty->fetch('admin/generator/template.save.tpl'));

        $fileGenerator->run();
    }

    private function getMap(mapper $mapper)
    {
        $map = $mapper->map();

        $exclude = array_keys($mapper->getRelations()->oneToOneBack() + $mapper->getRelations()->manyToMany() + $mapper->getRelations()->oneToMany());

        foreach ($map as $key => $val) {
            if ((isset($val['options']) && (in_array('fake', $val['options']) || in_array('plugin', $val['options']))) || in_array($key, $exclude)) {
                unset($map[$key]);
            }
        }

        return $map;
    }

    public function unique($name, simpleModule $module, $action_name = null)
    {
        if ($name == $action_name) {
            return true;
        }

        $actions = $module->getActions();
        return !isset($actions[$name]);
    }

    /*
    public function otherCase($name, $adminMapper)
    {
        $action = $adminMapper->searchActionByName($name);

        if ($action) {
            return $action['name'] == $name;
        }

        return true;
    }
    */

    private function isDataChanged($old, $values)
    {
        foreach ($values as $key => $value) {
            if (!isset($old[$key]) || $old[$key] != $value) {
                return true;
            }
        }

        return false;
    }

    private function getAclMethods()
    {
        $aclMethods = array(
            'none' => i18n::getMessage('action.acl.none', 'admin'));
        if (in_array('acl', $this->plugins)) {
            $aclMethods += array(
                'manual' => i18n::getMessage('action.acl.manual', 'admin'),
                'auto' => i18n::getMessage('action.acl.auto', 'admin'));
        }

        return $aclMethods;
    }

    private function getCRUDList()
    {
        $crud = array(
            'none' => 'none',
            'view' => 'view',
            'list' => 'list',
            'save' => 'save');

        if (in_array('jip', $this->plugins)) {
            $crud['delete'] = 'delete';
        }

        return $crud;
    }

    private function getDefaults($module, $class)
    {
        $mapper = $this->toolkit->getMapper($module, $class);

        $defaults = array(
            'name' => '',
            'controller' => '',
            'confirm' => '',
            '403handle' => 'auto',
            'act_template' => '',
            'lang' => '',
            'crud' => 'none',
            'main' => 'active.main.tpl');

        if ($mapper->isAttached('jip')) {
            $defaults += array(
                'jip' => 0,
                'title' => '',
                'icon' => '');
            $this->plugins[] = 'jip';
        }

        if ($mapper->isAttached('acl_ext') || $mapper->isAttached('acl_simple')) {
            $defaults += array(
                'alias' => '');
            $this->plugins[] = 'acl';
        }

        return $defaults;
    }

    private function normalize(& $values, $defaults)
    {
        $exclude = array(
            'crud');

        foreach ($values as $key => & $val) {
            if (!isset($defaults[$key]) || ($defaults[$key] == $val && !in_array($key, $exclude))) {
                if (!preg_match('!^route[._].+!', $key)) {
                    unset($values[$key]);
                }
            }
        }

        if (empty($values['controller'])) {
            $values['controller'] = $values['name'];
        }
    }
}

?>