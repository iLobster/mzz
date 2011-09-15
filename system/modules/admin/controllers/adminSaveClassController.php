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

/**
 * adminSaveClassController: контроллер для метода addClass|editClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminSaveClassController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $action = $this->request->getAction();
        $isEdit = $action == 'editClass';

        $data = array(
            'className' => '',
            'tableName' => ''
        );

        if ($isEdit) {
            $name = $this->request->getString('module_name');
            try {
                $module = $this->toolkit->getModule($name);
            } catch (mzzModuleNotFoundException $e) {
                return $this->forward404($adminMapper);
            }

            $classes = $module->getClasses();
            $class_name = $this->request->getString('class_name');
            if (!in_array($class_name, $classes)) {
                return $this->forward404($adminMapper);
            }

            $mapper = $module->getMapper($class_name);

            $data['className'] = $class_name;
            $data['tableName'] = $mapper->table();
        } else {
            $name = $this->request->getString('name');
            try {
                $module = $this->toolkit->getModule($name);
            } catch (mzzModuleNotFoundException $e) {
                return $this->forward404($adminMapper);
            }
        }

       $dests = $adminGeneratorMapper->getDests(true, $module->getName());

        if (!sizeof($dests)) {
            $controller = new messageController($this->getAction(), i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $validator = new formValidator();

        if (!$isEdit) {
            $validator->rule('required', 'name', i18n::getMessage('class.error.name_required', 'admin'));
            $validator->rule('callback', 'name', i18n::getMessage('class.error.unique', 'admin'), array(array($this, 'checkUniqueClassName'), $adminMapper, $isEdit ? $data['className'] : ''));
            $validator->rule('regex', 'name', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
            $validator->rule('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));
            $validator->rule('regex', 'table', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
        }

        if ($validator->validate()) {
            if (!$isEdit) {
                $name = $this->request->getString('name', SC_POST);
                $table = $this->request->getString('table', SC_POST);
                $dest = $this->request->getString('dest', SC_POST);

                try {
                    $adminGeneratorMapper->createClass($module, $name, $table, $dests[$dest]);
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                $this->view->assign('name', $name);
                $this->view->assign('module', $module);

                return $this->render('admin/addClassResult.tpl');
            } else {
                return jipTools::redirect();
            }
        }

        if ($isEdit) {
            $url = new url('adminModuleEntity');
            $url->add('module_name', $module->getName());
            $url->add('class_name', $data['className']);
        } else {
            $url = new url('adminModule');
            $url->add('name', $module->getName());
        }
        $url->setAction($action);

        $this->view->assign('form_action', $url->get());
        $this->view->assign('data', $data);
        $this->view->assign('isEdit', $isEdit);
        $this->view->assign('dests', $dests);
        $this->view->assign('validator', $validator);

        return $this->render('admin/saveClass.tpl');
    }

    public function checkUniqueClassName($name, $adminMapper, $class_name)
    {
        return true;
        if ($name == $class_name) {
            return true;
        }

        $class = $adminMapper->searchClassByName($name);

        return !$class;
    }
}

?>