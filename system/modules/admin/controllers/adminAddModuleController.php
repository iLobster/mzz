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

fileLoader::load('codegenerator/directoryGenerator');

/**
 * adminAddModuleController: контроллер для метода addModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminAddModuleController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $action = $this->request->getAction();
        $isEdit = $action == 'editModule';

        $data = null;

        $dests = $adminGeneratorMapper->getDests();

        $validator = new formValidator();

        $validator->add('required', 'name', i18n::getMessage('module.error.name_required', 'admin'));
        $validator->add('required', 'title', i18n::getMessage('module.error.title_required', 'admin'));
        $validator->add('regex', 'name', i18n::getMessage('module.error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
        $validator->add('callback', 'name', i18n::getMessage('module.error.unique', 'admin'), array(array($this, 'checkUniqueModuleName'), $adminMapper, $data['name']));
        $validator->add('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));
        $validator->add('numeric', 'order', i18n::getMessage('module.error.not_numeric_order', 'admin'));

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $icon = $this->request->getString('icon', SC_POST);
            $title = $this->request->getString('title', SC_POST);
            $order = $this->request->getInteger('order', SC_POST);
            $dest = $this->request->getString('dest', SC_POST);

            $generator = new directoryGenerator($dests[$dest]);

            if (!$isEdit) {
                try {
                    $generator->create($name);
                    $generator->create($name . '/actions');
                    $generator->create($name . '/controllers');
                    $generator->create($name . '/i18n');
                    $generator->create($name . '/mappers');
                    $generator->create($name . '/templates');

                    $generator->run();
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                $id = $adminGeneratorMapper->createModule($name, $title, $icon, $order);

                $this->smarty->assign('id', $id);
                $this->smarty->assign('dest', $dests[$dest]);
                $this->smarty->assign('name', $name);
                return $this->smarty->fetch('admin/addModuleResult.tpl');
            }

            return 'ok';
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $data['id']);
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $this->smarty->assign('nameRO', false);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('data', $data);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('dests', $dests);

        return $this->smarty->fetch('admin/addModule.tpl');
    }

    public function checkUniqueModuleName($name, $adminMapper, $module_name)
    {
        if ($name == $module_name) {
            return true;
        }

        $modules = $adminMapper->getModules();

        return !array_key_exists($name, $modules);
    }
}

class aadminAddModuleController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $dest = $adminGeneratorMapper->getDests();

        $id = $this->request->getInteger('id');
        $action = $this->request->getAction();

        $data = null;

        $isEdit = $action == 'editModule';

        $nameRO = false;

        $classes_select = array();

        if ($isEdit) {
            $data = $adminMapper->searchModuleById($id);

            if ($data === false) {
                $controller = new messageController('Модуль не существует', messageController::WARNING);
                return $controller->run();
            }

            $modules = $adminMapper->getModulesList();

            if (sizeof($modules[$data['id']]['classes'])) {
                /*
                $controller = new messageController('Нельзя изменить имя модуля', messageController::WARNING);
                return $controller->run();
                */
                $nameRO = true;
            }

            $modules = $adminMapper->getModulesList();

            $classes = $modules[$data['id']]['classes'];
            foreach ($classes as $key => $val) {
                $classes_select[$key] = $val['name'];
            }
        }


        $validator = new formValidator();

        if (!$nameRO) {
            $validator->add('required', 'name', 'поле обязательно к заполнению');
            $validator->add('regex', 'name', 'Разрешено использовать только a-zA-Z0-9_-', '#^[a-z0-9_-]+$#i');
            $validator->add('callback', 'name', 'Имя модуля должно быть уникально', array(array($this, 'checkUniqueModuleName'), $adminMapper, $data['name']));
        }

        if ($validator->validate()) {
            $name = trim($this->request->getString('name', SC_POST));
            $icon = $this->request->getString('icon', SC_POST);
            $title = $this->request->getString('title', SC_POST);
            $order = $this->request->getInteger('order', SC_POST);
            $newDest = $this->request->getString('dest', SC_POST);

            $generator = new directoryGenerator($dest[$newDest]);

            if (!$isEdit) {
                try {
                    $generator->create($name);
                    $generator->create($name . '/actions');
                    $generator->create($name . '/controllers');
                    $generator->create($name . '/i18n');
                    $generator->create($name . '/mappers');
                    $generator->create($name . '/templates');

                    $generator->run();

                    $log = 'ololo';
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                $id = $adminGeneratorMapper->createModule($name);

                $this->smarty->assign('id', $id);
                $this->smarty->assign('dest', $dest[$newDest]);
                $this->smarty->assign('name', $name);
                return $this->smarty->fetch('admin/addModuleResult.tpl');
            }

            if (!$nameRO && $isEdit) {
                $generator->rename($data['name'], $name);
                $generator->run();

                $adminGeneratorMapper->renameModule($id, $name);
            }


            $adminGeneratorMapper->updateModule($id, array('icon' => $icon, 'title' => $title, 'order' => $order));

            return jipTools::closeWindow();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $data['id']);
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        if (!sizeof($dest)) {
            $controller = new messageController('Нет доступа на запись в каталоги для создания модуля', messageController::WARNING);
            return $controller->run();
        }

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('data', $data);
        $this->smarty->assign('classes_select', $classes_select);
        $this->smarty->assign('dests', $dest);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('nameRO', $nameRO);
        return $this->smarty->fetch('admin/addModule.tpl');
    }

    public function checkUniqueModuleName($name, $adminMapper, $module_name)
    {
        if ($name == $module_name) {
            return true;
        }

        $modules = $adminMapper->getModules();

        return !isset($modules[$name]);
    }
}

?>