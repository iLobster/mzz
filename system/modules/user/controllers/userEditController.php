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

/**
 * userEditController: контроллер для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userEditView');
fileLoader::load('user/views/userEditSuccessView');
fileLoader::load('user/views/userEditForm');

class userEditController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $userMapper = $this->toolkit->getMapper('user', 'user', $this->request->getSection());

        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $editedUser = $userMapper->searchById($id);

        if ($editedUser->getId() == $id) {
            $form = userEditForm::getForm($editedUser, $this->request->getSection());

            if ($form->validate() == false) {
                $view = new userEditView($editedUser, $form);
            } else {
                $values = $form->exportValues();
                $editedUser->setLogin($values['login']);
                $userMapper->save($editedUser);

                $view = new userEditSuccessView();
            }
            return $view;
        } else {
        	fileLoader::load('user/views/user404View');
            return new user404View();
        }
    }
}

?>