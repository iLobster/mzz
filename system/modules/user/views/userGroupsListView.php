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
 * userGroupsListView: вид для метода groupsList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userGroupsListView extends simpleView
{
    private $config;

    public function toString()
    {
        $this->config = $this->toolkit->getConfig($this->httprequest->getSection(), 'user');

        fileLoader::load('pager');

        $page = ($this->getPageFromRequest() > 0) ? $this->getPageFromRequest() : 1;

        $pager = new pager($this->httprequest->getUrl(), $page, $this->config->get('items_per_page'));

        $this->DAO->setPager($pager);

        $this->smarty->assign('groups', $this->DAO->searchAll());
        $this->smarty->assign('pager', $pager);

        $this->response->setTitle('Пользователь -> Список групп');

        return $this->smarty->fetch('user/groupsList.tpl');
    }

    private function getPageFromRequest()
    {
        return $this->httprequest->get('page', 'integer', SC_GET);
    }
}

?>