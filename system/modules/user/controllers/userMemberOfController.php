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
 * userMemberOfController: контроллер для метода memberOf модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userMemberOfController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id', SC_PATH | SC_POST);

        $userMapper = $this->toolkit->getMapper('user', 'user');

        $user = $userMapper->searchByKey($id);

        // проверяем что найден нужный пользователь
        if ($user && $id != $user->getId()) {
            return $userMapper->get404()->run();
        }

        $validator = new formValidator();

        if ($validator->validate()) {
            $groupMapper = $this->toolkit->getMapper('user', 'group');

            $groups = (array)$this->request->getArray('groups', SC_POST);

            $groups = array_keys($groups);

            $userGroups = $user->getGroups();

            foreach (array_diff($userGroups->keys(), $groups) as $id) {
                $userGroups->delete($id);
            }

            foreach (array_diff($groups, $userGroups->keys()) as $id) {
                if ($group = $groupMapper->searchByKey($id)) {
                    $userGroups->add($group);
                }
            }

            $userMapper->save($user);

            return jipTools::closeWindow();
        }

        // если просто показать список групп и пользователей
        $groupMapper = $this->toolkit->getMapper('user', 'group');

        $criteria = new criteria();
        $criteria->setOrderByFieldAsc('name');
        $groups = $groupMapper->searchAll($criteria);

        $url = new url('withId');
        $url->setSection('user');
        $url->setAction('memberOf');
        $url->add('id', $id);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('groups', $groups);
        $this->smarty->assign('user', $user);

        return $this->smarty->fetch('user/memberOf.tpl');
    }
}

?>