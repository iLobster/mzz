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

fileLoader::load('admin/views/adminAddModuleView');
fileLoader::load('admin/views/adminAddModuleForm');

/**
 * adminAddModuleController: контроллер для метода addModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminAddModuleController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $action = $this->request->getAction();

        $db = DB::factory();

        $data = null;

        if ($action == 'editModule') {
            $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);

            if ($data === false) {
                // @todo изменить
                return 'модуля не существует';
            }

            $adminMapper = $this->toolkit->getMapper('admin', 'admin');
            $modules = $adminMapper->getModulesList();

            foreach ($modules as $val) {
                if ($val['id'] == $data['id']) {
                    if (sizeof($val['classes'])) {
                        // @todo изменить
                        return 'нельзя изменить имя модуля';
                    }
                    break;
                }
            }
        }

        $form = adminAddModuleForm::getForm($data, $db, $action);

        if ($form->validate()) {
            $values = $form->exportValues();

            if ($action == 'addModule') {
                $stmt = $db->prepare('INSERT INTO `sys_modules` (`name`) VALUES (:name)');

            } else {
                $stmt = $db->prepare('UPDATE `sys_modules` SET `name` = :name WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            }

            $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
            $stmt->execute();

            return new simpleJipRefreshView();
        }

        //return new adminAddClassView($data, $form);
        return new adminAddModuleView($data, $form, $action);
    }
}

?>