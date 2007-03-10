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

fileLoader::load('admin/forms/adminAddModuleForm');
fileLoader::load('codegenerator/moduleGenerator');

/**
 * adminAddModuleController: ���������� ��� ������ addModule ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.3
 */

class adminAddModuleController extends simpleController
{
    public function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $dest = $adminMapper->getDests();

        $id = $this->request->get('id', 'integer', SC_PATH);
        $action = $this->request->getAction();

        $db = DB::factory();

        $data = null;

        $nameRO = false;

        $classes_select = null;

        if ($action == 'editModule') {
            $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);

            if ($data === false) {
                $controller = new messageController('������ �� ����������', messageController::WARNING);
                return $controller->run();
            }

            $modules = $adminMapper->getModulesList();

            if (sizeof($modules[$data['id']]['classes'])) {
                /*
                $controller = new messageController('������ �������� ��� ������', messageController::WARNING);
                return $controller->run();
                */
                $nameRO = true;
            }

            $modules = $adminMapper->getModulesList();

            $classes = $modules[$data['id']]['classes'];
            $classes_select = array(0 => '');
            foreach ($classes as $key => $val) {
                $classes_select[$key] = $val['name'];
            }
        }

        $form = adminAddModuleForm::getForm($data, $db, $action, $nameRO, $classes_select);

        if ($form->validate()) {
            $values = $form->exportValues();

            $moduleGenerator = new moduleGenerator($dest[$values['dest']]);

            if ($action == 'addModule') {
                try {
                    $log = $moduleGenerator->generate($values['name']);
                } catch (Exception $e) {
                    return $e->getMessage() . $e->getLine() . $e->getFile();
                }

                $stmt = $db->prepare('INSERT INTO `sys_modules` (`name`) VALUES (:name)');
                $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
                $stmt->execute();

                $this->smarty->assign('log', $log);
                return $this->smarty->fetch('admin/addModuleResult.tpl');
            }

            if (!$nameRO) {
                $moduleGenerator->rename($data['name'], $values['name']);

                $stmt = $db->prepare('UPDATE `sys_modules` SET `name` = :name WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
                $stmt->execute();
            }

            $stmt = $db->prepare('UPDATE `sys_modules` SET `icon` = :icon, `title` = :title, `order` = :order, `main_class` = :main_class WHERE `id` = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':icon', $values['icon'], PDO::PARAM_STR);
            $stmt->bindValue(':title', $values['title'], PDO::PARAM_STR);
            $stmt->bindValue(':order', $values['order'], PDO::PARAM_INT);
            $stmt->bindValue(':main_class', $values['main_class'], PDO::PARAM_INT);
            $stmt->execute();

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('data', $data);
        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());
        return $this->smarty->fetch('admin/addModule.tpl');
    }
}

?>