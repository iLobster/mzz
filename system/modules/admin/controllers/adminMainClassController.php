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

fileLoader::load('admin/views/adminMainClassForm');

/**
 * adminMainClassController: контроллер для метода mainClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminMainClassController extends simpleController
{
    public function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $id = $this->request->get('id', 'integer', SC_PATH);

        $db = DB::factory();

        $data = $db->getRow('SELECT * FROM `sys_modules` WHERE `id` = ' . $id);

        if ($data === false) {
            // @todo изменить
            return 'класса не существует';
        }

        $modules = $adminMapper->getModulesList();

        $classes = $modules[$data['id']]['classes'];
        $classes_select = array(0 => '');
        foreach ($classes as $key => $val) {
            $classes_select[$key] = $val['name'];
        }

        $form = adminMainClassForm::getForm($data, $classes_select, $db);

        if ($form->validate()) {
            $values = $form->exportValues();

            $stmt = $db->prepare('UPDATE `sys_modules` SET `main_class` = :main_class WHERE `id` = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':main_class', $values['main_class'], PDO::PARAM_INT);
            $stmt->execute();

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('data', $data);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('admin/mainClass.tpl');
    }
}

?>