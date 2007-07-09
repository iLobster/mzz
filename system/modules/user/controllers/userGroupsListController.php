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

        $config = $this->toolkit->getConfig('user', $this->request->getSection());

        $this->setPager($groupMapper, $config->get('items_per_page'), true);

        $this->smarty->assign('groups', $groupMapper->searchAll());
        $this->smarty->assign('obj_id', $groupMapper->convertArgsToId(null));

        $this->response->setTitle('Пользователь -> Список групп');

        return $this->smarty->fetch('user/groupsList.tpl');
    }
}

?>