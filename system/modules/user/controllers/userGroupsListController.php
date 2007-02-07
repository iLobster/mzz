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
 * @version 0.1
 */
class userGroupsListController extends simpleController
{
    public function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group');

        $config = $this->toolkit->getConfig('user', $this->request->getSection());

        fileLoader::load('pager');

        $pager = new pager($this->request->getUrl(), $this->getPageFromRequest(), $config->get('items_per_page'));

        $groupMapper->setPager($pager);

        $this->smarty->assign('groups', $groupMapper->searchAll());
        $this->smarty->assign('pager', $pager);
        $this->smarty->assign('obj_id', $groupMapper->convertArgsToId(null));


        $this->response->setTitle('Пользователь -> Список групп');

        return $this->smarty->fetch('user/groupsList.tpl');
    }

    private function getPageFromRequest()
    {
        $page = $this->request->get('page', 'integer', SC_GET);
        return ($page > 0) ? $page : 1;
    }
}

?>