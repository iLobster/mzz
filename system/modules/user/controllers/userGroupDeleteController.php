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
 * userGroupDeleteController: контроллер для метода groupDelete модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userGroupDeleteController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->get('id', 'integer');

        // исключаем пользователей из этой группы
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');
        $groups = $userGroupMapper->searchAllByField('group_id', $id);

        foreach ($groups as $val) {
            $userGroupMapper->delete($val->getId());
        }

        // удаляем группу
        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $groupMapper->delete($id);

        return jipTools::redirect();
    }
}

?>