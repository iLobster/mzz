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
 * userGroupEditController: контроллер для метода groupEdit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userGroupEditView');
fileLoader::load('user/views/groupEditForm');

class userGroupEditController extends simpleController
{
    public function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group', $this->request->getSection());

        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $group = $groupMapper->searchById($id);

        $action = $this->request->getAction();

        if ($group || $action == 'groupCreate') {

            $form = groupEditForm::getForm($group, $this->request->getSection(), $action, $groupMapper);

            if ($form->validate() == false) {
                $view = new userGroupEditView($group, $form, $action);
            } else {
                if ($action == 'groupCreate') {
                    $group = $groupMapper->create();
                }

                $values = $form->exportValues();
                $group->setName($values['name']);
                $groupMapper->save($group);

                $view = new simpleJipRefreshView();
            }

            return $view;
        } else {
            fileLoader::load('user/views/group404View');
            return new group404View();
        }
    }
}

?>