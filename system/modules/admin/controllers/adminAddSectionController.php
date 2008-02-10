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
 * adminAddSectionController: контроллер для метода addSection модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */

class adminAddSectionController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $action = $this->request->getAction();

        $db = DB::factory();

        $data = array('name' => '', 'title' => '', 'order' => '');

        $nameRO = false;

        $isEdit = ($action == 'editSection');

        if ($isEdit) {
            $data = $db->getRow('SELECT * FROM `sys_sections` WHERE `id` = ' . $id);

            if ($data === false) {
                $controller = new messageController('Раздела не существует', messageController::WARNING);
                return $controller->run();
            }

            $adminMapper = $this->toolkit->getMapper('admin', 'admin');
            $sections = $adminMapper->getSectionsList();

            if (sizeof($sections[$data['id']]['classes'])) {
                /*
                $controller = new messageController('Нельзя изменить имя раздела', messageController::WARNING);
                return $controller->run();
                */
                $nameRO = true;
            }
        }

        $validator = new formValidator();

        if (!$nameRO) {
            $validator->add('required', 'name', 'Обязательное для заполнения поле');
            $validator->add('callback', 'name', 'Имя раздела должно быть уникально', array('checkUniqueSectionName', $db, $data['name'], $isEdit));
            $validator->add('regex', 'name', 'Разрешено использовать только a-zA-Z0-9_-', '#^[a-z0-9_-]+$#i');
        }

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $title = $this->request->getString('title', SC_POST);
            $order = $this->request->getInteger('order', SC_POST);

            if (!$isEdit) {
                $stmt = $db->prepare('INSERT INTO `sys_sections` (`name`) VALUES (:name)');
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $id = $stmt->execute();

            }

            if (!$nameRO && $isEdit) {
                $stmt = $db->prepare('UPDATE `sys_sections` SET `name` = :name WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $stmt->execute();
            }

            $stmt = $db->prepare('UPDATE `sys_sections` SET `title` = :title, `order` = :order WHERE `id` = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':order', $order, PDO::PARAM_INT);
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

        $this->smarty->assign('data', $data);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('nameRO', $nameRO);

        return $this->smarty->fetch('admin/addSection.tpl');
    }
}

function checkUniqueSectionName($name, $db, $currentName, $isEdit)
{
    if ($isEdit && $name == $currentName) {
        return true;
    }

    $stmt = $db->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_sections` WHERE `name` = :name');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 0;
}

?>