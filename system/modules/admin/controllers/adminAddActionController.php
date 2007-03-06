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

fileLoader::load('admin/forms/adminAddActionForm');
fileLoader::load('codegenerator/actionGenerator');

/**
 * adminAddActionController: контроллер для метода addAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */
 
class adminAddActionController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $action_name = $this->request->get('action_name', 'string', SC_PATH);

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $dest = $adminMapper->getDests();

        $action = $this->request->getAction();

        $db = DB::factory();

        $data = $db->getRow('SELECT `c`.`id` AS `c_id`, `m`.`id` AS `m_id`, `c`.`name` AS `c_name`, `m`.`name` AS `m_name` FROM `sys_classes` `c` INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` WHERE `c`.`id` = ' . $id);
        if ($data === false) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $act = new action($data['m_name']);
        $info = $act->getActions();

        if ($action == 'editAction' && !isset($info[$data['c_name']][$action_name])) {
            $controller = new messageController('У выранного класса нет запрашиваемого экшна', messageController::WARNING);
            return $controller->run();
        }

        $actnionsInfo = $info[$data['c_name']];

        $form = adminAddActionForm::getForm($data, $db, $action, $action_name, $actnionsInfo);

        if ($form->validate()) {
            $values = $form->exportValues();
            $modules = $adminMapper->getModulesList();

            $actionGenerator = new actionGenerator($modules[$data['m_id']]['name'], $dest[$values['dest']], $data['c_name']);

            if ($action == 'addAction') {
                try {
                    $log = $actionGenerator->generate($values['name'], $values);
                } catch (Exception $e) {
                    return $e->getMessage() . $e->getLine() . $e->getFile();
                }

                $actionGenerator->addToDB($values['name']);
            } else {
                $actionGenerator->rename($action_name, $values['name'], $values);
            }

            return jipTools::closeWindow();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('data', $data);
        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());
        return $this->smarty->fetch('admin/addAction.tpl');
    }
}

?>