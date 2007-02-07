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
 * userListController: контроллер для метода list модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userListController extends simpleController
{
    public function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $config = $this->toolkit->getConfig('user', $this->request->getSection());

        fileLoader::load('pager');
        $pager = new pager($this->request->getRequestUrl(), $this->getPageFromRequest(), $config->get('items_per_page'));
        $userMapper->setPager($pager);

        $this->smarty->assign('users', $userMapper->searchAll());
        $this->smarty->assign('pager', $pager);

        $userMapper->removePager();

        $this->response->setTitle('Пользователь -> Список');

        return $this->smarty->fetch('user/list.tpl');
    }

    private function getPageFromRequest()
    {
        $page = $this->request->get('page', 'integer', SC_GET);
        return ($page > 0) ? $page : 1;
    }
}

?>