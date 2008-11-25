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

fileLoader::load('codegenerator/classGenerator');
fileLoader::load('forms/validators/formValidator');

/**
 * adminAddClassController: контроллер для метода addClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */

class adminAddClassController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $dest = $adminMapper->getDests();

        $id = $this->request->getInteger('id');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editClass');

        $db = DB::factory();

        $modules = $adminMapper->getModulesList();

        if ($isEdit) {
            $data = $db->getRow('SELECT * FROM `sys_classes` WHERE `id` = ' . $id);

            if ($data === false) {
                $controller = new messageController('Класса не существует', messageController::WARNING);
                return $controller->run();
            }

            /*
            if (isset($modules[$data['module_id']]['classes'][$data['id']]) && $modules[$data['module_id']]['classes'][$data['id']]['exists']) {
            $controller = new messageController('Нельзя изменить имя класса', messageController::WARNING);
            return $controller->run();
            }*/

            $module_name = $modules[$data['module_id']]['name'];
        } else {
            $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
            $module_name = $data['name'];
        }

        $data['dest'] = $adminMapper->getDests(true, $module_name);

        $validator = new formValidator();
        $validator->add('required', 'name', 'Обязательное для заполнения поле');
        $validator->add('callback', 'name', 'Название должно быть уникально', array('checkUniqueClass', $db, $data['name'], $isEdit));
        $validator->add('regex', 'name', 'Разрешено использовать только a-zA-Z0-9_-', '#^[a-z0-9_-]+$#i');
        $validator->add('required', 'dest', 'Нет прав на запись в директорию');
        $validator->add('callback', 'dest', 'Нет прав на запись в директорию', array(array($this, 'checkdest'), $data['dest']));

        if ($validator->validate()) {
            $name = trim($this->request->getString('name', SC_POST));
            $newDest = $this->request->getString('dest', SC_POST);
            $bd_only = $this->request->getString('bd_only', SC_POST);

            if (!$isEdit) {
                $classGenerator = new classGenerator($data['name'], $dest[$newDest]);

                if ($bd_only == 'no') {
                    try {
                        $log = $classGenerator->generate($name);
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                    $log = "generate files skipped ";
                }

                $stmt = $db->prepare('INSERT INTO `sys_classes` (`name`, `module_id`) VALUES (:name, :module_id)');
                $stmt->bindValue(':module_id', $data['id'], PDO::PARAM_INT);
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $class_id = $stmt->execute();

                if (!sizeof($modules[$id]['classes'])) {
                    $stmt = $db->prepare('UPDATE `sys_modules` SET `main_class` = :class_id WHERE `id` = :id');
                    $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
                    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }

                $editAclId = $db->getOne("SELECT `id` FROM `sys_actions` WHERE `name` = 'editACL'");
                $db->query('INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES (' . $class_id . ', ' . $editAclId . ')');

                $adminMapper->registerClassInSections($class_id);

                $this->smarty->assign('log', $log);
                $this->smarty->assign('module', $module_name);
                $this->smarty->assign('name', $name);
                return $this->smarty->fetch('admin/addClassResult.tpl');
            }

            $classGenerator = new classGenerator($modules[$data['module_id']]['name'], $dest[$newDest]);
            $classGenerator->rename($data['name'], $name);

            $stmt = $db->prepare('UPDATE `sys_classes` SET `name` = :name WHERE `id` = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->execute();

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->add('id', $data['id']);
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);

        if (!$isEdit) {
            $data['name'] = '';
        }

        $this->smarty->assign('data', $data);
        return $this->smarty->fetch('admin/addClass.tpl');
    }

    public function checkdest($val, $dest)
    {
        return count($dest) > 0;
    }

}

function checkUniqueClass($name, $db, $currentName, $isEdit)
{
    if ($isEdit && $name == $currentName) {
        return true;
    }
    $stmt = $db->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes` WHERE `name` = :name');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}
?>