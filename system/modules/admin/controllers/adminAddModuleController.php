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
fileLoader::load('codegenerator/moduleGenerator');

/**
 * adminAddModuleController: контроллер для метода addModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2.1
 */

class adminAddModuleController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $dest = $adminMapper->getDests();

        $id = $this->request->get('id', 'integer', SC_PATH);
        $action = $this->request->getAction();

        $db = DB::factory();

        $data = null;

        $isEdit = ($action == 'editModule');

        $nameRO = false;

        $classes_select = null;

        if ($isEdit) {
            $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);

            if ($data === false) {
                $controller = new messageController('Модуля не существует', messageController::WARNING);
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
            $validator->add('callback', 'name', 'Имя модуля должно быть уникально', array('checkUniqueModuleName', $db, $data['name']));
        }

        if ($isEdit) {
            $validator->add('callback', 'main_class', 'выбранный класс не существует или принадлежит другому модулю', array('checkValidMainClass', $db, $data));
        }

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $icon = $this->request->get('icon', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);
            $order = $this->request->get('order', 'integer', SC_POST);
            $newDest = $this->request->get('dest', 'string', SC_POST);
            $main_class = $this->request->get('main_class', 'integer', SC_POST);

            $moduleGenerator = new moduleGenerator($dest[$newDest]);

            if (!$isEdit) {
                try {
                    $log = $moduleGenerator->generate($name);
                } catch (Exception $e) {
                    return $e->getMessage() . $e->getLine() . $e->getFile();
                }

                $stmt = $db->prepare('INSERT INTO `sys_modules` (`name`) VALUES (:name)');
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $id = $stmt->execute();

                $this->smarty->assign('log', $log);
                //return $this->smarty->fetch('admin/addModuleResult.tpl');
            }

            if (!$nameRO && $isEdit) {
                $moduleGenerator->rename($data['name'], $name);

                $stmt = $db->prepare('UPDATE `sys_modules` SET `name` = :name WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $stmt->execute();
            }

            $stmt = $db->prepare('UPDATE `sys_modules` SET `icon` = :icon, `title` = :title, `order` = :order, `main_class` = :main_class WHERE `id` = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':icon', $icon, PDO::PARAM_STR);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':order', $order, PDO::PARAM_INT);
            if (empty($main_class)) {
                $main_class = 0;
            }
            $stmt->bindValue(':main_class', $main_class, PDO::PARAM_INT);
            $stmt->execute();

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $data['id']);
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $dest = $adminMapper->getDests(true);

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
}

function checkUniqueModuleName($name, $db, $module_name)
{
    if ($name == $module_name) {
        return true;
    }

    $stmt = $db->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_modules` WHERE `name` = :name');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}

function checkValidMainClass($id, $db, $data)
{
    $stmt = $db->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes` WHERE `id` = :id AND `module_id` = :module');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':module', $data['id'], PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 1 || !$id;
}


?>