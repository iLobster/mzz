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
 * userGroupEditController: контроллер для метода groupEdit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userGroupSaveController extends simpleController
{
    protected function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $id = $this->request->getInteger('id', SC_PATH | SC_POST);

        $group = $groupMapper->searchByKey($id);

        $action = $this->request->getAction();
        $isEdit = ($action == 'groupEdit');

        if (!$group && $isEdit) {
            return $groupMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Обязательное для заполнения поле');
        $validator->add('callback', 'name', 'Группа с таким именем уже существует', array('checkUniqueGroupName', $group, $groupMapper));

        if ($validator->validate()) {
            if (!$isEdit) {
                $group = $groupMapper->create();
            }

            $name = $this->request->getString('name', SC_POST);
            $is_default = $this->request->getBoolean('is_default', SC_POST);
            $group->setName($name);
            $group->setIsDefault($is_default);
            $groupMapper->save($group);

            return jipTools::redirect();
        }


        $url = new url('default2');
        $url->setAction($action);

        if ($isEdit) {
            $url->setRoute('withId');
            $url->add('id', $group->getId());
        }

        $group = ($isEdit) ? $group : $groupMapper->create();
        $this->smarty->assign('group', $group);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('user/groupEdit.tpl');
    }
}

function checkUniqueGroupName($name, $group, $groupMapper)
{
    if (is_object($group) && $name === $group->getName()) {
        return true;
    }

    $group = $groupMapper->searchByName($name);
    return empty($group);
}

?>