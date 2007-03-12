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
class userGroupEditController extends simpleController
{
    public function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $id = $this->request->get('id', 'integer', SC_PATH | SC_POST);

        $group = $groupMapper->searchById($id);

        $action = $this->request->getAction();

        if ($group || $action == 'groupCreate') {
            fileLoader::load('user/forms/groupEditForm');
            $form = groupEditForm::getForm($group, $this->request->getSection(), $action, $groupMapper);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('group', $group);
                $this->smarty->assign('action', $action);

                $title = $action == 'edit' ? 'Редактирование группы -> ' . $group->getName() : 'Создание группы';

                $this->response->setTitle('Пользователь -> ' . $title);
                $view = $this->smarty->fetch('user/groupEdit.tpl');
            } else {
                if ($action == 'groupCreate') {
                    $group = $groupMapper->create();
                }

                $values = $form->exportValues();
                $group->setName($values['name']);
                $groupMapper->save($group);

                $view = jipTools::redirect();
            }

            return $view;
        } else {
            return $groupMapper->get404()->run();
        }
    }
}

?>