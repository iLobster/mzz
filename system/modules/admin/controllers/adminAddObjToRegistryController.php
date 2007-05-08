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
 * adminAddObjToRegistryController: контроллер для метода addObjToRegistryController модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */
class adminAddObjToRegistryController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();

        $db = DB::factory();

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $classes = $adminMapper->getClassesInSections();

        $sections = array_combine(array_keys($classes), array_keys($classes));

        $validator = new formValidator();
        $validator->add('required', 'section', 'Необходимо указать секцию');
        $validator->add('required', 'class', 'Необходимо указать класс');
        $validator->add('callback', 'class', 'Укажите существующий класс', array('checkClassSectionExists', $db));

        if ($validator->validate()) {
            $class = $this->request->get('class', 'integer', SC_POST);

            $obj_id = $this->toolkit->getObjectId();
            $stmt = $db->prepare('INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES (:obj_id, :class_section)');

            $stmt->bindValue(':obj_id', $obj_id, PDO::PARAM_INT);
            $stmt->bindValue(':class_section', $class, PDO::PARAM_INT);
            $stmt->execute();

            return jipTools::redirect();
        }
        $url = new url('default2');
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $action);
        $this->smarty->assign('classes', $classes);

        $this->smarty->assign('sections', $sections);
        return $this->smarty->fetch('admin/addObjToRegistry.tpl');
    }
}

function checkClassSectionExists($id, $db)
{
    if (empty($id) || preg_match('/[^0-9]/', $id)) {
        return false;
    }

    $stmt = $db->prepare('SELECT COUNT(*) AS `cnt` FROM `sys_classes_sections` WHERE `id` = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();

    return $res['cnt'] == 1;
}
?>