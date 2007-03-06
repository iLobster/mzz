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

fileLoader::load('admin/forms/adminAddSectionForm');

/**
 * adminAddSectionController: контроллер дл€ метода addSection модул€ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
 
class adminAddSectionController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $action = $this->request->getAction();

        $db = DB::factory();

        $data = null;

        if ($action == 'editSection') {
            $data = $db->getRow('SELECT * FROM `sys_sections` WHERE `id` = ' . $id);

            if ($data === false) {
                $controller = new messageController('–аздела не существует', messageController::WARNING);
                return $controller->run();
            }

            $adminMapper = $this->toolkit->getMapper('admin', 'admin');
            $sections = $adminMapper->getSectionsList();

            if (sizeof($sections[$data['id']]['classes'])) {
                $controller = new messageController('Ќельз€ изменить им€ раздела', messageController::WARNING);
                return $controller->run();
            }
        }

        $form = adminAddSectionForm::getForm($data, $db, $action);

        if ($form->validate()) {
            $values = $form->exportValues();

            if ($action == 'addSection') {
                $stmt = $db->prepare('INSERT INTO `sys_sections` (`name`) VALUES (:name)');

            } else {
                $stmt = $db->prepare('UPDATE `sys_sections` SET `name` = :name WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            }
            //echo '<br><pre>'; var_dump($values); echo '<br></pre>'; exit;
            $stmt->bindValue(':name', $values['name'], PDO::PARAM_STR);
            $stmt->execute();

            return jipTools::redirect();
        }


        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);
        $this->smarty->assign('data', $data);
        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());
        return $this->smarty->fetch('admin/addSection.tpl');
    }
}

?>