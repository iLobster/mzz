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

fileLoader::load('user/forms/userEditForm');

/**
 * userEditController: контроллер для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.2
 */

class userEditController extends simpleController
{
    public function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $id = $this->request->get('id', 'integer', SC_PATH | SC_POST);
        $editedUser = $userMapper->searchById($id);

        $action = $this->request->getAction();

        if ($editedUser->getId() == $id || $action == 'create') {

            $form = userEditForm::getForm($editedUser, $this->request->getSection(), $action, $userMapper);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('user', $editedUser);
                $this->smarty->assign('action', $action);

                $title = $action == 'edit' ? 'Редактирование -> ' . $editedUser->getLogin() : 'Создание';

                $this->response->setTitle('Пользователь -> ' . $title);
                return $this->smarty->fetch('user/edit.tpl');
            } else {
                if ($action == 'create') {
                    $editedUser = $userMapper->create();
                }

                $values = $form->exportValues();
                $editedUser->setLogin($values['login']);
                if (!empty($values['password'])) {
                    $editedUser->setPassword($values['password']);
                }

                if ($action == 'create') {
                    // добавим созданного пользователя в группы с флагом 'is_default'
                    $groupMapper = $this->toolkit->getMapper('user', 'group');
                    $groups = $groupMapper->searchAllByField('is_default', 1);

                    $userMapper->save($editedUser);

                    $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');
                    $userGroup = array();

                    foreach ($groups as $group) {
                        $userGroup_tmp = $userGroupMapper->create();
                        $userGroup_tmp->setGroup($group);

                        $userGroup[] = $userGroup_tmp;
                    }

                    $editedUser->setGroups($userGroup);
                }

                $userMapper->save($editedUser);

                $view = jipTools::redirect();
            }

            return $view;
        } else {
            return $userMapper->get404()->run();
        }
    }
}

?>