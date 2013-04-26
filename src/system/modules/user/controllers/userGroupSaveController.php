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
        $validator->rule('required', 'name', 'Обязательное для заполнения поле');
        $validator->rule('callback', 'name', 'Группа с таким именем уже существует', array(array($this, 'checkUniqueGroupName'), $group, $groupMapper));

        if ($validator->validate()) {
            if (!$isEdit) {
                $group = $groupMapper->create();
            }

            $name = $this->request->getString('name', SC_POST);
            $is_default = $this->request->getInteger('is_default', SC_POST);
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
        $this->view->assign('group', $group);
        $this->view->assign('form_action', $url->get());
        $this->view->assign('isEdit', $isEdit);
        $this->view->assign('validator', $validator);
        return $this->render('user/groupEdit.tpl');
    }

    function checkUniqueGroupName($name, $group, $groupMapper)
    {
        if (is_object($group) && $name === $group->getName()) {
            return true;
        }

        return is_null($groupMapper->searchOneByField('name', $name));
    }
}

?>