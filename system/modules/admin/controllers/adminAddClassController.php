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

fileLoader::load('admin/forms/adminAddClassForm');
fileLoader::load('codegenerator/classGenerator');

/**
 * adminAddClassController: контроллер для метода addClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */

class adminAddClassController extends simpleController
{
    public function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $dest = $adminMapper->getDests();

        $id = $this->request->get('id', 'integer', SC_PATH);
        $action = $this->request->getAction();

        $db = DB::factory();

        if ($action == 'addClass') {
            $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
            $module_name = $data['name'];
        } else {
            $data = $db->getRow('SELECT * FROM `sys_classes` WHERE `id` = ' . $id);

            if ($data === false) {
                // @todo изменить
                return 'класса не существует';
            }

            $modules = $adminMapper->getModulesList();

            if (isset($modules[$data['module_id']]['classes'][$data['id']]) && $modules[$data['module_id']]['classes'][$data['id']]['exists']) {
                // @todo изменить
                return 'нельзя изменить имя класса';
            }

            $module_name = $modules[$data['module_id']]['name'];
        }

        $form = adminAddClassForm::getForm($data, $db, $action, $module_name);

        if ($form->validate()) {
            $values = $form->exportValues();

            if ($action == 'addClass') {
                $classGenerator = new classGenerator($data['name'], $dest[$values['dest']]);
                try {
                    $log = $classGenerator->generate($values['name']);
                } catch (Exception $e) {
                    return $e->getMessage() . $e->getLine() . $e->getFile();
                }

                $stmt = $db->prepare('INSERT INTO `sys_classes` (`name`, `module_id`) VALUES (:name, :module_id)');
                $stmt->bindValue(':module_id', $data['id'], PDO::PARAM_INT);
                $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
                $stmt->execute();

                $this->smarty->assign('log', $log);
                return $this->smarty->fetch('admin/addClassResult.tpl');
            }

            $classGenerator = new classGenerator($modules[$data['module_id']]['name'], $dest[$values['dest']]);
            $classGenerator->rename($data['name'], $values['name']);

            $stmt = $db->prepare('UPDATE `sys_classes` SET `name` = :name WHERE `id` = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
            $stmt->execute();

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('data', $data);
        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());
        return $this->smarty->fetch('admin/addClass.tpl');
    }
}

?>