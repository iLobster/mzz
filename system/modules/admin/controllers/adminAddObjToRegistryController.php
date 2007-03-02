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

fileLoader::load('admin/forms/adminAddObjToRegistryForm');

/**
 * adminAddObjToRegistryController: контроллер для метода addObjToRegistryController модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminAddObjToRegistryController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();

        $db = DB::factory();

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $data = $adminMapper->getClassesInSections();

        $formData = array_combine(array_keys($data), array_keys($data));
        $form = adminAddObjToRegistryForm::getForm($formData, $db, $action);

        if ($form->validate()) {
            $values = $form->exportValues();

            $obj_id = $this->toolkit->getObjectId();
            $stmt = $db->prepare('INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES (:obj_id, :class_section)');

            $stmt->bindValue(':obj_id', $obj_id, PDO::PARAM_INT);
            $stmt->bindValue(':class_section', $values['class'], PDO::PARAM_INT);
            $stmt->execute();

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);
        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('classes', $data);
        return $this->smarty->fetch('admin/addObjToRegistry.tpl');
    }
}

?>