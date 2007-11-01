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
 * userGroupsListController: контроллер для метода groupsList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */
class userGroupsListController extends simpleController
{
    protected function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');

        $criteria = new criteria();
        $criteria->addSelectField(new sqlFunction('count', '*', true), $userGroupMapper->getClassName() . simpleMapper::TABLE_KEY_DELIMITER . 'cnt');
        $criteria->addGroupBy('group_id');

        $usersGroups = array();
        foreach ($userGroupMapper->searchAllByCriteria($criteria) as $val) {
            $usersGroups[$val->getGroup()->getId()] = $val->fakeField('cnt');
        }

        $config = $this->toolkit->getConfig('user', $this->request->getSection());

        $this->setPager($groupMapper, $config->get('items_per_page'), true);

        $this->smarty->assign('groups', $groupMapper->searchAll());
        $this->smarty->assign('usersGroups', $usersGroups);
        $this->smarty->assign('obj_id', $groupMapper->convertArgsToObj(null)->getObjId());

        $this->response->setTitle('Пользователь -> Список групп');

        return $this->smarty->fetch('user/groupsList.tpl');
    }
}

?>