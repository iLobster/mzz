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

            $actionData = array(
                'name' => $actionObject->getName(),
                'controllerName' => $actionObject->getControllerName(),
                'title' => $actionObject->getTitle(),
                'confirm' => $actionObject->getConfirm(),
                'activeTemplate' => $actionObject->getActiveTemplate(),
                'jip' => $actionObject->isJip(),
                'icon' => $actionObject->getIcon()
            );
        } else {
            $class_name = $this->request->getString('class_name');
            $classes = $module->getClasses();
            if (!in_array($class_name, $classes)) {
                return $this->forward404($adminMapper);
            }

            $actionData = array(
                'name' => '',
                'controllerName' => '',
                'title' => '',
                'confirm' => '',
                'activeTemplate' => simpleAction::DEFAULT_ACTIVE_TPL,
                'jip' => false,
                'icon' => ''
            );

        }

        $dests = $adminGeneratorMapper->getDests(true, $module->getName());

        if (!sizeof($dests)) {
            $controller = new messageController($this->getAction(), i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $validator = new formValidator();

        if (!$isEdit) {
            $validator->rule('required', 'action[name]', i18n::getMessage('action.error.name_required', 'admin'));
            $validator->rule('regex', 'action[name]', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')), '#^[a-z0-9_-]+$#i');
            $validator->rule('callback', 'action[name]', i18n::getMessage('action.error.unique', 'admin'), array(array($this, 'unique'), $module));
            $validator->rule('callback', 'action[crud_class]', i18n::getMessage('action.error.crud_class', 'admin'), array('in_array', $classes));
        }

        $validator->rule('regex', 'action[main]', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-.')), '#^[a-z0-9_\-.]+$#i');
        $validator->rule('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));

        if ($validator->validate()) {
            $values = $this->request->getArray('action', SC_POST);
            $dest = $this->request->getString('dest', SC_POST);
            $crud_class_name = null;
            if (!empty($values['crud']) && $values['crud'] == 'save' && !empty($values['crud_class'])) {
                $crud_class_name = $values['crud_class'];
                unset($values['crud_class']);
            }

            if (!$isEdit) {
                $action_name = $values['name'];
                unset($values['name']);

                if ($values['main'] == simpleAction::DEFAULT_ACTIVE_TPL) {
                    unset($values['main']);
                }
            }

            if (empty($values['title'])) {
                unset($values['title']);
            }

            if (empty($values['confirm'])) {
                unset($values['confirm']);
            }

            try {
                $adminGeneratorMapper->saveAction($module, $class_name, $action_name, $values, $dests[$dest], $isEdit, $crud_class_name);
            } catch (Exception $e) {
                return $e->getMessage();
                //$controller = new messageController($this->getAction(), $e->getMessage(), messageController::WARNING);
                //return $controller->run();
            }

            return jipTools::closeWindow();
        }

        $crud = array(
            'view' => 'view',
            'list' => 'list',
            'save' => 'save'
        );

        $moduleClassMapper = $this->toolkit->getMapper($module_name, $class_name);
        if ($moduleClassMapper->isAttached('jip')) {
            $crud['delete'] = 'delete';
        }

        $this->view->assign('crudList', $crud);

        $url = new url('adminModuleEntity');
        $url->add('module_name', $module_name);
        $url->setAction($action);

        if ($isEdit) {
            $url->add('class_name', $action_name);
        } else {
            $url->add('class_name', $class_name);
        }

        $this->view->assign('form_action', $url->get());
        $this->view->assign('validator', $validator);

        $this->view->assign('dests', $dests);
        $this->view->assign('isEdit', $isEdit);
        $this->view->assign('module', $module);
        $this->view->assign('moduleClassMapper', $moduleClassMapper);
        $this->view->assign('actionData', $actionData);
        if (!$isEdit) {
            $this->view->assign('classes', array_combine($classes, $classes));
            $this->view->assign('class_name', $class_name);
        }

        return $this->view->render('admin/saveAction.tpl');
    }

    public function unique($name, simpleModule $module, $action_name = null)
    {
        if ($name == $action_name) {
            return true;
        }

        $actions = $module->getActions();
        return !isset($actions[$name]);
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

}

?>