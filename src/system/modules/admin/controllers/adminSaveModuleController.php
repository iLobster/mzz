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
 * adminSaveModuleController: контроллер для метода addModule|editModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminSaveModuleController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $action = $this->request->getAction();
        $isEdit = $action == 'editModule';

        $dests = $adminGeneratorMapper->getDests(true);

        if (!sizeof($dests)) {
            $controller = new messageController($this->getAction(), i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $currentDestination = 'app';

        if ($isEdit) {
            $name = $this->request->getString('name');
            try {
                $module = $this->toolkit->getModule($name);
            } catch (mzzModuleNotFoundException $e) {
                return $this->forward404($adminMapper);
            }

            $currentDestination = current($adminGeneratorMapper->getDests(true, $module->getName()));
        }

        $validator = new formValidator();

        if (!$isEdit) {
            $validator->rule('required', 'name', i18n::getMessage('module.error.name_required', 'admin'));
            $validator->rule('regex', 'name', i18n::getMessage('module.error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
            $validator->rule('callback', 'name', i18n::getMessage('module.error.unique', 'admin'), array(array($this, 'checkUniqueModuleName'), $adminMapper));
            $validator->rule('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));
        }

        if ($validator->validate()) {
            if (!$isEdit) {
                $name = $this->request->getString('name', SC_POST);
                $dest = $this->request->getString('dest', SC_POST);

                try {
                    $module = $adminGeneratorMapper->createModule($name, $dests[$dest]);
                } catch (Exception $e) {
                    $controller = new messageController($e->getMessage(), messageController::WARNING);
                    return $controller->run();
                }

                $this->view->assign('dest', $dests[$dest]);
                $this->view->assign('module', $module);
                return $this->render('admin/addModuleResult.tpl');
            }

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('adminModule');
            $url->add('name', $name);

            $this->view->assign('module', $module);
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $this->view->assign('form_action', $url->get());
        $this->view->assign('isEdit', $isEdit);
        $this->view->assign('validator', $validator);
        $this->view->assign('dests', $dests);
        $this->view->assign('currentDestination', $currentDestination);

        return $this->render('admin/saveModule.tpl');
    }

    public function checkUniqueModuleName($name, $adminMapper, $module_name = '')
    {
        if ($name == $module_name) {
            return true;
        }

        $modules = $adminMapper->getModules();

        return !array_key_exists($name, $modules);
    }

}

?>