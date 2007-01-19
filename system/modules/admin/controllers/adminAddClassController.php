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

fileLoader::load('admin/views/adminAddClassView');
fileLoader::load('admin/views/adminAddClassForm');

/**
 * adminAddClassController: контроллер для метода addClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminAddClassController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $action = $this->request->getAction();

        $db = DB::factory();

        if ($action == 'addClass') {
            $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
        } else {
            $data = $db->getRow('SELECT * FROM `sys_classes` WHERE `id` = ' . $id);

            if ($data === false) {
                // @todo изменить
                return 'класса не существует';
            }

            $adminMapper = $this->toolkit->getMapper('admin', 'admin');
            $modules = $adminMapper->getModulesList();

            if (isset($modules[$data['module_id']]['classes'][$data['id']]) && $modules[$data['module_id']]['classes'][$data['id']]['exists']) {
                // @todo изменить
                return 'нельзя изменить имя класса';
            }
        }

        $form = adminAddClassForm::getForm($data, $db, $action);

        if ($form->validate()) {
            $values = $form->exportValues();

            if ($action == 'addClass') {
                $stmt = $db->prepare('INSERT INTO `sys_classes` (`name`, `module_id`) VALUES (:name, :module_id)');
                $stmt->bindValue(':module_id', $data['id'], PDO::PARAM_INT);

            } else {
                $stmt = $db->prepare('UPDATE `sys_classes` SET `name` = :name WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            }

            $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
            $stmt->execute();

            return new simpleJipRefreshView();
        }

        return new adminAddClassView($data, $form, $action);
    }
}

?>