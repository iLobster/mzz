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
 * userListView: вид для метода list модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userListView extends simpleView
{
    private $config;

    public function toString()
    {
        $this->config = $this->toolkit->getConfig($this->httprequest->getSection(), 'user');

        fileLoader::load('pager');

        $page = ($this->getPageFromRequest() > 0) ? $this->getPageFromRequest() : 1;

        $pager = new pager($this->httprequest->getUrl(), $page, $this->config->get('items_per_page'));

        $this->DAO->setPager($pager);

        $this->smarty->assign('users', $this->DAO->searchAll());
        $this->smarty->assign('pager', $pager);

        $this->DAO->removePager();

        $this->response->setTitle('Пользователь -> Список');

        return $this->smarty->fetch('user/list.tpl');
    }

    private function getPageFromRequest()
    {
        return $this->httprequest->get('page', 'integer', SC_GET);
    }
}

?>